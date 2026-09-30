<?php

namespace App\Services\Search;

/**
 * Reads a search the way a person means it.
 *
 *   "tv under 5k"                    → Televisions, price ≤ ₹5,000
 *   "cheap 55 inch smart tv"         → Televisions, 55", smart, sorted by price
 *   "ac for bedroom"                 → Air conditioners, 1 ton
 *   "washing machine for family of 5" → Washing machines, 8–10.2 kg
 *   "between 20 and 30 thousand"     → ₹20,000 – ₹30,000
 *   "telivision"                     → "television" (spelling fixed)
 */
final class QueryParser
{
    private const BELOW = 'under|below|less than|lesser than|lower than|within|upto|up to|max|maximum|not more than|no more than|cheaper than|smaller than|budget of|budget is|budget|in|<|less then|bellow|undr|under rs|max rs';
    private const ABOVE = 'above|over|more than|greater than|higher than|min|minimum|at least|atleast|starting|starting from|starts at|from|bigger than|larger than|>|more then|abov';
    private const AROUND = 'around|about|approx|approximately|near|nearly|close to|roughly|~|arround';

    private const CHEAP = ['cheapest', 'cheap', 'affordable', 'budget', 'economical', 'inexpensive', 'low cost', 'low price', 'lowest price', 'low budget', 'price low to high', 'low to high', 'value for money', 'less price', 'least price', 'lowest'];
    private const PREMIUM = ['expensive', 'costliest', 'premium', 'high end', 'highend', 'luxury', 'price high to low', 'high to low', 'top end', 'flagship', 'most expensive'];
    private const POPULAR = ['best', 'top', 'popular', 'best selling', 'bestseller', 'best seller', 'most popular', 'trending', 'recommended', 'top rated', 'top selling', 'featured'];
    private const NEWEST = ['latest', 'newest', 'new', 'recent', 'new arrival', 'new arrivals', 'just launched', 'launched'];

    private const BIG = ['big', 'bigger', 'biggest', 'large', 'larger', 'largest', 'huge', 'giant', 'massive', 'jumbo'];
    private const SMALL = ['small', 'smaller', 'smallest', 'compact', 'little', 'tiny'];

    /** Categories whose products have a screen size. */
    private const SCREEN_CATEGORIES = ['televisions', 'interactive-panels', 'commercial-display-solutions', 'commercial-displays', 't-standees', 'a-standees', 'stand-alone-kiosk', 'table-top-standee', 'mini-qled-tv'];

    public function __construct(private ProductIndex $index)
    {
    }

    public function parse(string $input): ParsedQuery
    {
        $q = new ParsedQuery();
        $q->original = trim($input);
        $q->isQuestion = (bool) preg_match('/\?|^(how|what|when|where|why|can|could|do|does|is|are|will|should|who)\b/i', $q->original);

        $normalized = Text::normalize($q->original);
        [$text, $corrected] = $this->fixSpelling(' ' . $normalized . ' ');

        if ($corrected !== $normalized) {
            $q->corrected = $corrected;
        }

        $text = $this->numbersInWords($text);
        $text = $this->amounts($text);

        $this->roomArea($q, $text);
        $this->audience($q, $text);
        $this->ranges($q, $text);
        $this->comparisons($q, $text);
        $this->units($q, $text);
        $this->family($q, $text);
        // Before sorting words: "top load" is a feature, "top" alone means most popular.
        $this->typesAndFeatures($q, $text);
        $this->sorting($q, $text);
        $this->uses($q, $text);
        $this->sizeWords($q, $text);
        $this->bareNumbers($q, $text);
        $this->notSold($q, $text);

        $q->terms = array_values(array_unique(array_filter(
            Text::tokens($text),
            fn ($t) => strlen($t) > 1 && ! is_numeric($t),
        )));

        $this->label($q);

        return $q;
    }

    // ------------------------------------------------------------------ text clean-up

    private function numbersInWords(string $text): string
    {
        $words = Vocabulary::NUMBER_WORDS;
        uksort($words, fn ($a, $b) => strlen($b) <=> strlen($a));

        foreach ($words as $word => $n) {
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/', (string) $n, $text);
        }

        return $text;
    }

    /**
     * Known misspellings, then closest known word for anything the site has never seen.
     *
     * @return array{0: string, 1: string}
     */
    private function fixSpelling(string $text): array
    {
        foreach (Vocabulary::SPELLING as $wrong => $right) {
            $text = preg_replace('/(?<= )' . preg_quote($wrong, '/') . '(?= )/', $right, $text);
        }

        $vocab = $this->index->data()['vocab'];
        $known = array_flip(array_merge(
            Vocabulary::STOP_WORDS,
            Vocabulary::NOT_SOLD,
            explode(' ', implode(' ', array_keys(Vocabulary::NUMBER_WORDS))),
            array_values(Vocabulary::SPELLING),
            explode(' ', implode(' ', [...self::CHEAP, ...self::PREMIUM, ...self::POPULAR, ...self::NEWEST, ...self::BIG, ...self::SMALL])),
            explode('|', self::BELOW . '|' . self::ABOVE . '|' . self::AROUND),
            ['inch', 'kg', 'ton', 'star', 'rs', 'lakh', 'thousand', 'family', 'member', 'members', 'people', 'person', 'persons', 'between', 'and', 'to'],
        ));

        $words = explode(' ', trim($text));

        foreach ($words as $i => $word) {
            if (strlen($word) < 4 || ! ctype_alpha($word) || isset($known[$word]) || isset($vocab[Text::stem($word)])) {
                continue;
            }

            $words[$i] = $this->closest($word, $vocab) ?? $word;
        }

        $fixed = implode(' ', $words);

        return [' ' . $fixed . ' ', $fixed];
    }

    private function closest(string $word, array $vocab): ?string
    {
        $limit = strlen($word) >= 7 ? 2 : 1;
        $best = null;
        $bestDistance = $limit + 1;

        foreach (array_keys($vocab) as $candidate) {
            if (! is_string($candidate) || abs(strlen($candidate) - strlen($word)) > $limit || $candidate[0] !== $word[0] && $limit === 1) {
                continue;
            }

            $distance = levenshtein($word, $candidate);

            if ($distance < $bestDistance) {
                [$best, $bestDistance] = [$candidate, $distance];
            }
        }

        return $best;
    }

    /**
     * "5k" → 5000, "1.5 lakh" → 150000, "20 thousand" → 20000, "rs." / "₹" kept as "rs".
     */
    private function amounts(string $text): string
    {
        // "20000rs", "7kg", "1.5ton" → "20000 rs", "7 kg", "1.5 ton" (model numbers like "55su23g" are left alone).
        $text = preg_replace('/\b(\d+(?:\.\d+)?)(rs|kg|kgs|ton|tons|lakh|lakhs|lac|lacs|star|stars)\b/', '$1 $2', $text);

        $text = preg_replace_callback('/(\d+(?:\.\d+)?)\s*(lakhs?|lacs?|l)\b/', fn ($m) => ' ' . (int) round($m[1] * 100000) . ' rs ', $text);
        // "4k" / "8k" are resolutions, not ₹4,000.
        $text = preg_replace_callback(
            '/(\d+(?:\.\d+)?)\s*(k|thousand|thousands|thousnd|thousend)\b/',
            fn ($m) => $m[2] === 'k' && in_array($m[1], ['4', '8'], true) ? $m[0] : ' ' . (int) round($m[1] * 1000) . ' ',
            $text,
        );
        $text = preg_replace('/\b(inr|rupees?|rupee|rs)\b/', ' rs ', $text);

        return preg_replace('/\s+/', ' ', $text);
    }

    // ------------------------------------------------------------------ numbers

    /**
     * "between 20000 and 30000", "32 to 43 inch", "6.5-8 kg".
     */
    private function ranges(ParsedQuery $q, string &$text): void
    {
        $text = preg_replace_callback(
            '/(?:between|from)?\s*(?:rs\s*)?(\d+(?:\.\d+)?)\s*(inch|kg|ton|rs)?\s*(?:and|to|-)\s*(?:rs\s*)?(\d+(?:\.\d+)?)\s*(inch|kg|ton|rs)?(?=\s)/',
            function ($m) use ($q) {
                [$a, $b] = [(float) $m[1], (float) $m[3]];
                [$a, $b] = [min($a, $b), max($a, $b)];
                $unit = ($m[4] ?? '') ?: ($m[2] ?? '');

                return match (true) {
                    $unit === 'inch' => $this->set($q, ['inchMin' => $a, 'inchMax' => $b]),
                    $unit === 'kg' => $this->set($q, ['kgMin' => $a, 'kgMax' => $b]),
                    $unit === 'ton' => $this->set($q, ['tonMin' => $a, 'tonMax' => $b]),
                    $unit === 'rs' || $b >= 500 => $this->set($q, ['priceMin' => $a < 100 && $b >= 1000 ? $a * 1000 : $a, 'priceMax' => $b]),
                    default => $m[0],
                };
            },
            $text,
        );
    }

    /**
     * "under 5000", "above 55 inch", "around 30000", "less than 7 kg".
     */
    private function comparisons(ParsedQuery $q, string &$text): void
    {
        foreach (['max' => self::BELOW, 'min' => self::ABOVE, 'around' => self::AROUND] as $kind => $words) {
            $words = implode('|', array_map(fn ($w) => preg_quote($w, '/'), explode('|', $words)));

            $text = preg_replace_callback(
                "/\b(?:{$words})\s+(?:rs\s*)?(\d+(?:\.\d+)?)\s*(inch|kg|ton|star|rs)?(?=\s)/",
                function ($m) use ($q, $kind) {
                    $n = (float) $m[1];
                    $unit = $m[2] ?? '';

                    if ($unit === 'star') {
                        return $this->set($q, ['stars' => (int) $n]);
                    }

                    // A small number with no unit after "under" is ambiguous ("under 5" people?) — leave it.
                    if ($unit === '' && $n < 100 && $kind !== 'around') {
                        return $m[0];
                    }

                    $field = match ($unit) {
                        'inch' => 'inch',
                        'kg' => 'kg',
                        'ton' => 'ton',
                        default => $n < 100 ? 'inch' : 'price',
                    };

                    return match ($kind) {
                        'max' => $this->set($q, [$field . 'Max' => $n]),
                        'min' => $this->set($q, [$field . 'Min' => $n]),
                        default => $field === 'price'
                            ? $this->set($q, ['priceAround' => $n])
                            : $this->set($q, [$field . 'Min' => $n, $field . 'Max' => $n]),
                    };
                },
                $text,
            );
        }
    }

    /**
     * "55 inch", "7 kg", "1.5 ton", "5 star", "rs 20000".
     */
    private function units(ParsedQuery $q, string &$text): void
    {
        $text = preg_replace_callback('/(\d+(?:\.\d+)?)\s*inch\b/', fn ($m) => $this->set($q, ['inchMin' => (float) $m[1], 'inchMax' => (float) $m[1]]), $text);
        $text = preg_replace_callback('/(\d+(?:\.\d+)?)\s*(?:kg|kgs|kilo|kilos|kilogram)\b/', fn ($m) => $this->set($q, ['kgMin' => (float) $m[1], 'kgMax' => (float) $m[1]]), $text);
        $text = preg_replace_callback('/(\d(?:\.\d+)?)\s*(?:ton|tr)\b/', fn ($m) => $this->set($q, ['tonMin' => (float) $m[1], 'tonMax' => (float) $m[1]]), $text);
        $text = preg_replace_callback('/(\d)\s*star\b/', fn ($m) => $this->set($q, ['stars' => (int) $m[1]]), $text);
        $text = preg_replace_callback('/(?:rs\s*(\d+(?:\.\d+)?)|(\d+(?:\.\d+)?)\s*rs)\b/', fn ($m) => $this->set($q, ['priceMax' => (float) (($m[1] ?? '') !== '' ? $m[1] : $m[2])]), $text);
    }

    /**
     * "150 sq ft room" → AC tonnage (up to 120 sq ft: 1 ton, 120–180: 1.5 ton, 180–250: 2 ton).
     */
    private function roomArea(ParsedQuery $q, string &$text): void
    {
        $text = preg_replace_callback(
            '/(\d{2,4})\s*(?:sq\s*ft|sqft|sq\s*feet|square\s*feet|square\s*foot|sft)\b/',
            function ($m) use ($q) {
                $area = (int) $m[1];
                $ton = match (true) {
                    $area <= 120 => 1.0,
                    $area <= 180 => 1.5,
                    default => 2.0,
                };

                $q->categories = $q->categories ?: ['air-conditioners'];
                $q->useLabel = "For a {$area} sq ft room";
                $q->useEffects = ['ton'];

                return $this->set($q, ['tonMin' => $ton, 'tonMax' => $ton]);
            },
            $text,
        );
    }

    /**
     * "panel for 40 students" → a screen big enough for the room, not a 40" screen.
     */
    private function audience(ParsedQuery $q, string &$text): void
    {
        $text = preg_replace_callback(
            '/(\d{1,4})\s*(?:students?|kids|children|pupils|learners|seats|audience|attendees)\b/',
            function ($m) use ($q) {
                $n = (int) $m[1];
                [$min, $max] = match (true) {
                    $n <= 20 => [55, 65],
                    $n <= 40 => [65, 75],
                    default => [75, 100],
                };

                $q->categories = $q->categories ?: ['interactive-panels'];
                $q->useLabel = "For {$n} students";
                $q->useEffects = ['inch'];

                return $this->set($q, ['inchMin' => $min, 'inchMax' => $max]);
            },
            $text,
        );
    }

    /**
     * "family of 5", "4 members", "for 2 people" → wash capacity.
     */
    private function family(ParsedQuery $q, string &$text): void
    {
        $text = preg_replace_callback(
            '/\b(?:family of|for)?\s*(\d{1,2})\s*(?:members?|people|persons?|family members)\b|\bfamily of\s*(\d{1,2})\b/',
            function ($m) use ($q) {
                $n = (int) (($m[1] ?? '') !== '' ? $m[1] : $m[2]);
                [$min, $max] = match (true) {
                    $n <= 2 => [6, 7],
                    $n <= 4 => [7, 8.5],
                    $n <= 6 => [8, 10.2],
                    default => [10, 25],
                };
                $q->labels['kg'] = "For {$n} " . ($n === 1 ? 'person' : 'people') . ' (' . Text::num($min) . '–' . Text::num($max) . ' kg)';
                $q->categories = $q->categories ?: ['washing-machine'];

                return $this->set($q, ['kgMin' => $min, 'kgMax' => $max]);
            },
            $text,
        );
    }

    // ------------------------------------------------------------------ words

    private function sorting(ParsedQuery $q, string &$text): void
    {
        foreach (['price_asc' => self::CHEAP, 'price_desc' => self::PREMIUM, 'popular' => self::POPULAR, 'newest' => self::NEWEST] as $sort => $phrases) {
            usort($phrases, fn ($a, $b) => strlen($b) <=> strlen($a));

            foreach ($phrases as $phrase) {
                if (str_contains($text, " {$phrase} ")) {
                    $q->sort ??= $sort;
                    $text = str_replace(" {$phrase} ", ' ', $text);
                }
            }
        }
    }

    private function typesAndFeatures(ParsedQuery $q, string &$text): void
    {
        $types = Vocabulary::PRODUCT_TYPES;
        $features = Vocabulary::FEATURES;

        // Phrases that are both a product type and a feature ("google tv", "qled") set both.
        $phrases = array_unique([...array_keys($types), ...array_keys($features)]);
        usort($phrases, fn ($a, $b) => strlen($b) <=> strlen($a));

        $categories = [];

        foreach ($phrases as $phrase) {
            $needle = ' ' . $phrase . ' ';

            if (! str_contains($text, $needle)) {
                continue;
            }

            if (isset($types[$phrase])) {
                $categories = [...$categories, ...$types[$phrase]];
            }

            if (isset($features[$phrase])) {
                $q->features[] = $features[$phrase];
            }

            $text = str_replace($needle, ' ', $text);
        }

        if ($categories) {
            $q->categories = $this->mostSpecific(array_unique([...$q->categories, ...$categories]));
        }

        $q->features = array_values(array_unique($q->features));

        // "smart" alone on a TV search means a smart TV; next to "board" etc. it was already consumed.
        if (in_array('non_smart', $q->features, true)) {
            $q->features = array_values(array_diff($q->features, ['smart']));
        }
    }

    /**
     * "tv" + "qled" → keep televisions (QLED is a feature of it); "tv" + "mini qled" → mini-qled-tv only.
     */
    private function mostSpecific(array $slugs): array
    {
        return array_values(array_filter($slugs, function ($slug) use ($slugs) {
            foreach ($slugs as $other) {
                if ($other !== $slug && in_array($other, $this->index->expandCategories([$slug]), true)) {
                    return false;
                }
            }

            return true;
        }));
    }

    private function uses(ParsedQuery $q, string &$text): void
    {
        $uses = Vocabulary::USES;
        uksort($uses, fn ($a, $b) => strlen($b) <=> strlen($a));

        foreach ($uses as $phrase => $rule) {
            if (! str_contains($text, " {$phrase} ")) {
                continue;
            }

            $text = str_replace(" {$phrase} ", ' ', $text);

            // Only the most specific room / use applies; further ones ("school" in "podium for school auditorium")
            // are just understood and removed from the free words.
            if ($q->useLabel !== null) {
                continue;
            }

            $q->useLabel = $rule['label'];

            if (! $q->categories && isset($rule['categories'])) {
                $q->categories = $rule['categories'];
                $q->useEffects[] = 'category';
            }

            // A room with no product named ("for bedroom") means the TVs and ACs that suit it.
            if (! $q->categories && (isset($rule['inch']) || isset($rule['ton']))) {
                $q->categories = [...(isset($rule['inch']) ? ['televisions'] : []), ...(isset($rule['ton']) ? ['air-conditioners'] : [])];
                $q->useEffects[] = 'category';
            }

            $screens = (bool) array_intersect($q->categories, self::SCREEN_CATEGORIES);
            $cooling = (bool) array_intersect($q->categories, ['air-conditioners', '1-ton-ac', '1-5-ton-ac', '2-ton-ac']);

            if (isset($rule['inch']) && $screens && $q->inchMin === null && $q->inchMax === null) {
                [$q->inchMin, $q->inchMax] = $rule['inch'];
                $q->useEffects[] = 'inch';
            }

            if (isset($rule['ton']) && $cooling && $q->tonMin === null && $q->tonMax === null) {
                [$q->tonMin, $q->tonMax] = $rule['ton'];
                $q->useEffects[] = 'ton';
            }

            foreach ($rule['features'] ?? [] as $flag) {
                $q->features[] = $flag;
                $q->useEffects[] = "f:{$flag}";
            }
        }
    }

    /**
     * "big tv" → 65"+, "small washing machine" → up to 7 kg, "big ac" → 2 ton.
     */
    private function sizeWords(ParsedQuery $q, string &$text): void
    {
        foreach (['big' => self::BIG, 'small' => self::SMALL] as $kind => $words) {
            foreach ($words as $word) {
                if (! str_contains($text, " {$word} ")) {
                    continue;
                }

                $text = str_replace(" {$word} ", ' ', $text);
                $cats = $q->categories;

                if (array_intersect($cats, ['washing-machine', 'fully_automatic', 'semi-automatic', 'only-washer'])) {
                    $q->kgMin ??= $kind === 'big' ? 8.5 : null;
                    $q->kgMax ??= $kind === 'small' ? 7 : null;
                } elseif (array_intersect($cats, ['air-conditioners', '1-ton-ac', '1-5-ton-ac', '2-ton-ac'])) {
                    $q->tonMin ??= $kind === 'big' ? 2 : null;
                    $q->tonMax ??= $kind === 'small' ? 1 : null;
                } elseif (! $cats || array_intersect($cats, self::SCREEN_CATEGORIES)) {
                    $q->inchMin ??= $kind === 'big' ? 65 : null;
                    $q->inchMax ??= $kind === 'small' ? 32 : null;
                }
            }
        }
    }

    /**
     * Numbers with no unit: "tv 20000" is a budget, "tv 55" is a screen size.
     */
    private function bareNumbers(ParsedQuery $q, string &$text): void
    {
        $text = preg_replace_callback('/(?<= )(\d+(?:\.\d+)?)(?= )/', function ($m) use ($q) {
            $n = (float) $m[1];
            $screens = ! $q->categories || array_intersect($q->categories, self::SCREEN_CATEGORIES);

            return match (true) {
                $n >= 1000 && $q->priceMax === null && $q->priceAround === null => $this->set($q, ['priceMax' => $n]),
                $n >= 19 && $n <= 110 && $screens && $q->inchMin === null && $q->inchMax === null => $this->set($q, ['inchMin' => $n, 'inchMax' => $n]),
                default => $m[0],
            };
        }, $text);
    }

    private function notSold(ParsedQuery $q, string $text): void
    {
        foreach (Vocabulary::NOT_SOLD as $word) {
            if (str_contains($text, " {$word} ") && ! $q->categories) {
                $q->notSold = $word;

                return;
            }
        }
    }

    /**
     * Assign fields and return a space (the matched words are consumed).
     */
    private function set(ParsedQuery $q, array $values): string
    {
        foreach ($values as $field => $value) {
            $q->{$field} = $value;
        }

        return ' ';
    }

    // ------------------------------------------------------------------ labels

    private function label(ParsedQuery $q): void
    {
        $labels = [];

        if ($q->categories) {
            $labels['category'] = collect($q->categories)->map(fn ($s) => $this->index->categoryName($s) ?? str($s)->headline())->implode(' / ');
        }

        if ($q->useLabel) {
            $labels['use'] = $q->useLabel;
        }

        $labels['price'] = match (true) {
            $q->priceAround !== null => 'Around ' . Text::rupees($q->priceAround),
            $q->priceMin !== null && $q->priceMax !== null => Text::rupees($q->priceMin) . ' – ' . Text::rupees($q->priceMax),
            $q->priceMax !== null => 'Under ' . Text::rupees($q->priceMax),
            $q->priceMin !== null => 'Above ' . Text::rupees($q->priceMin),
            default => null,
        };

        $labels['inch'] = $this->rangeLabel($q->inchMin, $q->inchMax, '"');
        $labels['kg'] = $q->labels['kg'] ?? $this->rangeLabel($q->kgMin, $q->kgMax, ' kg');
        $labels['ton'] = $this->rangeLabel($q->tonMin, $q->tonMax, ' ton');
        $labels['stars'] = $q->stars ? "{$q->stars} star" : null;

        foreach ($q->features as $flag) {
            $labels["f:{$flag}"] = Vocabulary::FEATURE_LABELS[$flag] ?? $flag;
        }

        $labels['sort'] = match ($q->sort) {
            'price_asc' => 'Lowest price first',
            'price_desc' => 'Highest price first',
            'popular' => 'Most popular',
            'newest' => 'Newest first',
            default => null,
        };

        // Size/tonnage/categories implied by a room are shown as part of the room chip.
        foreach ($q->useEffects as $key) {
            if ($key !== 'category' && isset($labels[$key], $labels['use'])) {
                $labels['use'] .= ' · ' . $labels[$key];
                unset($labels[$key]);
            }
        }

        $q->labels = array_filter($labels);
    }

    private function rangeLabel(?float $min, ?float $max, string $unit): ?string
    {
        return match (true) {
            $min !== null && $max !== null && $min == $max => Text::num($min) . $unit,
            $min !== null && $max !== null => Text::num($min) . '–' . Text::num($max) . $unit,
            $max !== null => 'Up to ' . Text::num($max) . $unit,
            $min !== null => Text::num($min) . $unit . ' & above',
            default => null,
        };
    }
}
