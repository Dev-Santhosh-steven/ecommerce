<?php

namespace App\Services\Search;

use App\Models\ChatbotFaq;
use App\Services\ChatbotService;

/**
 * Natural-language product search.
 *
 * 1. QueryParser turns the words into constraints (type, budget, size, features, use, sort) and free words.
 * 2. Products must meet every constraint; free words are scored against the whole product
 *    (name, model, category, features, specs, description), with prefix and typo tolerance.
 * 3. If nothing meets everything, the least important constraint is relaxed (features, then size,
 *    rating, price, words, category) and the page says what was relaxed — never a dead end.
 * 4. Pages, guides and a knowledge-base answer are found alongside the products.
 */
final class SearchEngine
{
    /** Relaxed first → last. */
    private const RELAX_ORDER = ['features', 'size', 'stars', 'price', 'terms', 'category'];

    public function __construct(
        private ProductIndex $index,
        private QueryParser $parser,
        private SiteIndex $site,
        private ChatbotService $bot,
    ) {
    }

    /**
     * @param  array  $drop  understood parts the visitor removed (chip keys)
     * @param  ?string  $sort  sort chosen on the page (overrides the one in the words)
     * @param  ?string  $category  category chosen on the page
     */
    public function search(string $query, array $drop = [], ?string $sort = null, ?string $category = null, bool $withExtras = true): SearchResult
    {
        $parsed = $this->parser->parse($query);
        $parsed->drop($drop);

        if ($category && $this->index->categoryName($category)) {
            $parsed->categories = [$category];
            $parsed->labels = ['category' => $this->index->categoryName($category)] + $parsed->labels;
        }

        if ($sort) {
            $parsed->sort = $sort === 'relevance' ? null : $sort;
        }

        $result = new SearchResult($parsed);
        $docs = $this->index->data()['docs'];

        if (trim($query) === '' && ! $category) {
            $result->ids = $this->order(array_keys($docs), [], $parsed);

            return $result;
        }

        [$termScores, $termHits, $usefulTerms] = $this->scoreTerms($parsed->terms, $docs);
        $result->ignoredTerms = array_values(array_diff($parsed->terms, $usefulTerms));

        if ($parsed->notSold) {
            $result->notes[] = 'Yara doesn\'t make ' . str($parsed->notSold)->plural() . ' yet. Here are our most popular products instead.';
            $result->fallback = true;
            $result->ids = $this->popular($docs);
        } else {
            $this->match($result, $docs, $termScores, $termHits, $usefulTerms);
        }

        if ($withExtras) {
            $result->pages = $this->site->search(array_values(array_unique([...$parsed->terms, ...$this->categoryWords($parsed)])));
            $result->answer = $this->answer($parsed, $result);

            // A plain question ("how long does delivery take?") or a topic with its own page ("warranty") is
            // answered with that, not padded out with unrelated popular products.
            if (($result->answer && $parsed->isQuestion && ! $parsed->hasConstraints()) || ($result->fallback && ! $parsed->notSold && ($result->answer || $result->pages))) {
                [$result->ids, $result->notes, $result->fallback] = [[], [], false];
            }

            $result->facets = $this->facets($result->ids);
        }

        return $result;
    }

    // ------------------------------------------------------------------ matching

    private function match(SearchResult $result, array $docs, array $termScores, array $termHits, array $terms): void
    {
        $parsed = $result->parsed;
        $active = array_filter([
            'features' => (bool) $parsed->features,
            'size' => $parsed->hasSize(),
            'stars' => (bool) $parsed->stars,
            'price' => $parsed->hasPrice(),
            'terms' => (bool) $terms,
            'category' => (bool) $parsed->categories,
        ]);

        if (! $active) {
            $result->notes[] = "No products match “{$parsed->original}”. Here are our most popular products.";
            $result->fallback = true;
            $result->ids = $this->popular($docs);

            return;
        }

        $relaxed = [];
        $ids = $this->filter($docs, $parsed, $active, $termHits, count($terms));

        foreach (self::RELAX_ORDER as $step) {
            if ($ids || ! isset($active[$step])) {
                continue;
            }

            unset($active[$step]);
            $relaxed[] = $step;

            // Only a budget was asked for ("under 5000") and nothing fits: show everything, cheapest first.
            // Otherwise, with nothing left to match on, popular products beat an unranked list.
            if (! $active) {
                $ids = $step === 'price' ? array_keys(array_filter($docs, fn ($d) => $d['price'] !== null)) : [];
                break;
            }

            $ids = $this->filter($docs, $parsed, $active, $termHits, count($terms));
        }

        if (! $ids) {
            $result->notes[] = "No products match “{$parsed->original}”. Here are our most popular products.";
            $result->fallback = true;
            $result->ids = $this->popular($docs);

            return;
        }

        $result->relaxed = $relaxed;
        $result->notes = [...$result->notes, ...$this->relaxNotes($relaxed, $parsed, $ids, $docs)];
        $result->ids = $this->order($ids, $termScores, $parsed, $relaxed);
    }

    private function filter(array $docs, ParsedQuery $q, array $active, array $termHits, int $termCount): array
    {
        $categories = isset($active['category']) ? $this->index->expandCategories($q->categories) : [];
        $needHits = $termCount ? max(1, (int) ceil($termCount * 0.5)) : 0;

        return array_keys(array_filter($docs, function (array $d) use ($q, $active, $categories, $termHits, $needHits) {
            if ($categories && ! array_intersect($d['cats'], $categories)) {
                return false;
            }

            if (isset($active['price']) && ! $this->priceFits($d['price'], $q)) {
                return false;
            }

            if (isset($active['size']) && ! $this->sizeFits($d, $q)) {
                return false;
            }

            if (isset($active['stars']) && $d['star'] !== $q->stars) {
                return false;
            }

            if (isset($active['features']) && array_diff($q->features, $d['flags'])) {
                return false;
            }

            if (isset($active['terms']) && ($termHits[$d['id']] ?? 0) < $needHits) {
                return false;
            }

            return true;
        }));
    }

    private function priceFits(?float $price, ParsedQuery $q): bool
    {
        if ($price === null) {
            return false;
        }

        if ($q->priceAround !== null) {
            return $price >= $q->priceAround * 0.75 && $price <= $q->priceAround * 1.25;
        }

        return ($q->priceMin === null || $price >= $q->priceMin) && ($q->priceMax === null || $price <= $q->priceMax);
    }

    /**
     * Each size constraint applies to the products that have that measure (inches for screens,
     * kg for washers, tons for ACs); a product must have at least one of the measures asked for.
     */
    private function sizeFits(array $d, ParsedQuery $q): bool
    {
        $checks = [
            'inch' => [$q->inchMin, $q->inchMax, 1.0],
            'kg' => [$q->kgMin, $q->kgMax, 0.05],
            'ton' => [$q->tonMin, $q->tonMax, 0.01],
        ];

        $relevant = 0;

        foreach ($checks as $facet => [$min, $max, $tolerance]) {
            if ($min === null && $max === null) {
                continue;
            }

            if ($d[$facet] === null) {
                continue;
            }

            $relevant++;

            if (($min !== null && $d[$facet] < $min - $tolerance) || ($max !== null && $d[$facet] > $max + $tolerance)) {
                return false;
            }
        }

        return $relevant > 0;
    }

    // ------------------------------------------------------------------ words

    /**
     * Score free words against every product.
     *
     * @return array{0: array<int, float>, 1: array<int, int>, 2: string[]} scores, words matched per product, words that matched anything
     */
    private function scoreTerms(array $terms, array $docs): array
    {
        $scores = [];
        $hits = [];
        $useful = [];
        $data = $this->index->data();

        foreach ($terms as $term) {
            $idf = log(1 + $data['count'] / max(1, $data['df'][$term] ?? 1));
            $matchedAny = false;

            foreach ($docs as $id => $doc) {
                $best = $this->termWeight($term, $doc['w']);

                if ($best > 0) {
                    $scores[$id] = ($scores[$id] ?? 0) + $best * $idf;
                }

                // A word only counts as matched if it is in the name, model, category, features, specs or
                // summary, not just somewhere in the long description ("long", "take"…).
                if ($best >= 1) {
                    $hits[$id] = ($hits[$id] ?? 0) + 1;
                    $matchedAny = true;
                }
            }

            if ($matchedAny) {
                $useful[] = $term;
            }
        }

        // A whole phrase in the name is the strongest signal ("single tower speaker").
        $phrase = implode(' ', $terms);
        if (count($terms) > 1) {
            foreach ($docs as $id => $doc) {
                if (str_contains($doc['name'], $phrase)) {
                    $scores[$id] = ($scores[$id] ?? 0) + 10;
                }
            }
        }

        return [$scores, $hits, $useful];
    }

    private function termWeight(string $term, array $weights): float
    {
        if (isset($weights[$term])) {
            return $weights[$term];
        }

        $best = 0.0;
        $len = strlen($term);

        // Model numbers ("55su23g") match exactly or by their start only: one letter off is another model.
        $modelLike = preg_match('/\d/', $term) && preg_match('/[a-z]/', $term);

        foreach ($weights as $word => $weight) {
            $word = (string) $word;

            $factor = match (true) {
                $len >= 3 && str_starts_with($word, $term) => 0.7,
                $modelLike => 0,
                strlen($word) >= 4 && str_starts_with($term, $word) => 0.5,
                $len >= 5 && abs(strlen($word) - $len) <= 1 && levenshtein($term, $word) === 1 => 0.4,
                default => 0,
            };

            $best = max($best, $weight * $factor);
        }

        return $best;
    }

    // ------------------------------------------------------------------ ranking

    private function order(array $ids, array $termScores, ParsedQuery $q, array $relaxed = []): array
    {
        $docs = $this->index->data()['docs'];
        $sort = $q->sort;

        // Sensible defaults when the words didn't say how to sort.
        if ($sort === null && ! $termScores) {
            $sort = match (true) {
                in_array('price', $relaxed, true) && $q->priceMin === null => 'price_asc',
                in_array('price', $relaxed, true) => 'price_desc',
                $q->priceAround !== null => 'closest_price',
                in_array('size', $relaxed, true) => 'closest_size',
                $q->priceMax !== null && $q->priceMin === null => 'price_desc',
                $q->priceMin !== null => 'price_asc',
                default => null,
            };
        }

        usort($ids, function ($a, $b) use ($docs, $termScores, $sort, $q) {
            [$x, $y] = [$docs[$a], $docs[$b]];

            $primary = match ($sort) {
                'price_asc' => $this->priceKey($x, 1) <=> $this->priceKey($y, 1),
                'price_desc' => $this->priceKey($y, -1) <=> $this->priceKey($x, -1),
                'newest' => $y['created'] <=> $x['created'],
                'popular' => $y['featured'] <=> $x['featured'],
                'closest_price' => abs(($x['price'] ?? INF) - $q->priceAround) <=> abs(($y['price'] ?? INF) - $q->priceAround),
                'closest_size' => $this->sizeDistance($x, $q) <=> $this->sizeDistance($y, $q),
                default => 0,
            };

            return $primary
                ?: (($termScores[$b] ?? 0) <=> ($termScores[$a] ?? 0))
                ?: ($y['featured'] <=> $x['featured'])
                ?: ($x['order'] <=> $y['order']);
        });

        return $ids;
    }

    /** "Price on request" products go last in either direction. */
    private function priceKey(array $doc, int $direction): float
    {
        return $doc['price'] ?? ($direction > 0 ? INF : -INF);
    }

    private function sizeDistance(array $d, ParsedQuery $q): float
    {
        $distance = INF;

        foreach (['inch' => [$q->inchMin, $q->inchMax], 'kg' => [$q->kgMin, $q->kgMax], 'ton' => [$q->tonMin, $q->tonMax]] as $facet => [$min, $max]) {
            if ($d[$facet] === null || ($min === null && $max === null)) {
                continue;
            }

            $distance = min($distance, match (true) {
                $min !== null && $d[$facet] < $min => $min - $d[$facet],
                $max !== null && $d[$facet] > $max => $d[$facet] - $max,
                default => 0,
            });
        }

        return $distance;
    }

    private function popular(array $docs): array
    {
        $ids = array_keys(array_filter($docs, fn ($d) => $d['featured']));

        return $this->order($ids ?: array_keys($docs), [], new ParsedQuery());
    }

    // ------------------------------------------------------------------ explanations

    private function relaxNotes(array $relaxed, ParsedQuery $q, array $ids, array $docs): array
    {
        $notes = [];
        $what = $this->categoryWords($q) ? strtolower(collect($q->categories)->map(fn ($s) => $this->index->categoryName($s))->filter()->implode(' / ')) : 'products';

        foreach ($relaxed as $step) {
            $notes[] = match ($step) {
                'features' => 'No ' . $what . ' have all of: ' . collect($q->features)->map(fn ($f) => Vocabulary::FEATURE_LABELS[$f] ?? $f)->implode(', ') . '. Showing the closest matches.',
                'size' => 'Nothing in ' . ($q->labels['inch'] ?? $q->labels['kg'] ?? $q->labels['ton'] ?? 'that size') . ', so here are the nearest sizes.',
                'stars' => "No {$q->stars} star {$what} right now. Showing other ratings.",
                'price' => $this->priceNote($q, $ids, $docs, $what),
                'terms' => 'We couldn\'t match every word in “' . $q->original . '”, so these are the closest products.',
                'category' => 'We didn\'t find ' . $what . ' for that, so here are related products.',
                default => null,
            };
        }

        return array_filter($notes);
    }

    private function priceNote(ParsedQuery $q, array $ids, array $docs, string $what): string
    {
        $prices = collect($ids)->map(fn ($id) => $docs[$id]['price'])->filter();

        return match (true) {
            $q->priceMax !== null && $q->priceMin === null && $prices->isNotEmpty() => 'Nothing under ' . Text::rupees($q->priceMax) . ' yet. Our most affordable ' . $what . ' start at ' . Text::rupees($prices->min()) . '.',
            $q->priceMin !== null && $q->priceMax === null && $prices->isNotEmpty() => 'Nothing above ' . Text::rupees($q->priceMin) . ' here. The highest-priced ' . $what . ' go up to ' . Text::rupees($prices->max()) . '.',
            default => 'Nothing in ' . ($q->labels['price'] ?? 'that budget') . ', so here are the closest prices.',
        };
    }

    private function categoryWords(ParsedQuery $q): array
    {
        return collect($q->categories)->flatMap(fn ($s) => Text::tokens((string) $this->index->categoryName($s)))->unique()->values()->all();
    }

    private function answer(ParsedQuery $q, SearchResult $result): ?ChatbotFaq
    {
        if (! $q->isQuestion && ($result->ids && ! $result->fallback)) {
            return null;
        }

        return $this->bot->knowledgeAnswer($q->original);
    }

    /**
     * Category counts for the results (to narrow down).
     */
    private function facets(array $ids): array
    {
        $docs = $this->index->data()['docs'];

        return collect($ids)
            ->map(fn ($id) => $docs[$id]['cats'][0] ?? null)
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(8)
            ->map(fn ($count, $slug) => ['slug' => $slug, 'name' => $this->index->categoryName($slug), 'count' => $count])
            ->values()
            ->all();
    }
}
