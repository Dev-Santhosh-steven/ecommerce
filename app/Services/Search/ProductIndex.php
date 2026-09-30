<?php

namespace App\Services\Search;

use App\Models\Category;
use App\Models\ChatbotFaq;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

/**
 * A search document for every live product: weighted words from the whole product (name, model,
 * category, features, description, specs) plus the facts people filter by (price, screen size,
 * kg, tonnage, star rating, features).
 *
 * Cached; the cache key changes whenever a product, category or post is saved, so it rebuilds itself.
 */
final class ProductIndex
{
    /** How much a word counts, by where it appears. */
    private const WEIGHTS = [
        'model' => 8.0,
        'name' => 6.0,
        'category' => 4.0,
        'feature' => 2.0,
        'short' => 2.0,
        'spec' => 1.0,
        'description' => 0.5,
    ];

    private ?array $data = null;

    /**
     * @return array{docs: array<int, array>, df: array<string, int>, vocab: array<string, true>, categories: array<string, array>, count: int}
     */
    public function data(): array
    {
        return $this->data ??= Cache::remember('search.index.' . $this->signature(), now()->addDay(), fn () => $this->build());
    }

    public function doc(int $id): ?array
    {
        return $this->data()['docs'][$id] ?? null;
    }

    /**
     * Category slug → itself plus every sub-category slug.
     */
    public function expandCategories(array $slugs): array
    {
        $categories = $this->data()['categories'];

        return collect($slugs)
            ->flatMap(fn ($slug) => [$slug, ...($categories[$slug]['descendants'] ?? [])])
            ->unique()
            ->values()
            ->all();
    }

    public function categoryName(string $slug): ?string
    {
        return $this->data()['categories'][$slug]['name'] ?? null;
    }

    private function signature(): string
    {
        return md5(implode('|', [
            Product::count(), Product::max('updated_at'),
            Category::count(), Category::max('updated_at'),
            Post::count(), Post::max('updated_at'),
            ChatbotFaq::count(), ChatbotFaq::max('updated_at'),
            filemtime(__FILE__), filemtime(__DIR__ . '/Vocabulary.php'),
        ]));
    }

    private function build(): array
    {
        $categories = Category::where('status', true)->get(['id', 'parent_id', 'name', 'slug', 'description']);
        $bySlug = $this->categoryTree($categories);
        $byId = $categories->keyBy('id');

        $products = Product::where('status', true)
            ->with(['features:id,product_id,title,description'])
            ->get();

        $docs = [];
        $df = [];

        foreach ($products as $product) {
            $doc = $this->document($product, $byId);
            $docs[$product->id] = $doc;

            foreach (array_keys($doc['w']) as $token) {
                $df[$token] = ($df[$token] ?? 0) + 1;
            }
        }

        $vocab = array_fill_keys(array_keys($df), true);

        // Words from the vocabulary, the site pages and the chatbot answers are real words too
        // ("delivery", "warranty"), so spelling correction leaves them alone.
        $siteWords = implode(' ', [
            ...array_keys(Vocabulary::PRODUCT_TYPES + Vocabulary::FEATURES + Vocabulary::USES),
            ...array_map(fn ($page) => $page[0] . ' ' . $page[3], SiteIndex::PAGES),
            ...ChatbotFaq::whereNull('product_id')->pluck('keywords')->all(),
            ...$categories->pluck('name')->all(),
        ]);

        foreach (Text::tokens($siteWords, true) as $word) {
            $vocab[$word] = true;
        }

        return ['docs' => $docs, 'df' => $df, 'vocab' => $vocab, 'categories' => $bySlug, 'count' => max(1, count($docs))];
    }

    private function document(Product $product, $categoriesById): array
    {
        $category = $categoriesById[$product->category_id] ?? null;
        $parent = $category ? ($categoriesById[$category->parent_id] ?? null) : null;
        $specs = collect($product->specifications ?: [])->filter(fn ($v) => is_scalar($v));
        $specText = $specs->map(fn ($v, $k) => "{$k} {$v}")->implode(' ');

        $fields = [
            'model' => trim($product->model_number . ' ' . $product->sku),
            'name' => $product->name,
            'category' => trim(($category?->name ?? '') . ' ' . ($parent?->name ?? '')),
            'feature' => $product->features->map(fn ($f) => $f->title . ' ' . $f->description)->implode(' '),
            'short' => (string) $product->short_description,
            'spec' => $specText,
            'description' => (string) $product->description,
        ];

        $weights = [];
        foreach ($fields as $field => $text) {
            foreach (Text::tokens($text) as $token) {
                $weights[$token] = max($weights[$token] ?? 0, self::WEIGHTS[$field]);
            }
        }

        // Model numbers are also searched whole ("55SU23G", "YE-IFP55-A14" → "yeifp55a14").
        foreach ([$product->model_number, $product->sku] as $id) {
            $compact = preg_replace('/[^a-z0-9]/', '', mb_strtolower((string) $id));
            if (strlen($compact) >= 4) {
                $weights[$compact] = self::WEIGHTS['model'];
            }
        }

        // Facts come from the name, category and specs, not the long description (which compares with other products).
        $facts = Text::normalize(implode(' ', [$product->name, $fields['category'], $specText, $product->short_description]));

        return [
            'id' => $product->id,
            'w' => $weights,
            'name' => Text::normalize($product->name),
            'price' => $product->hasPrice() ? $product->unitPrice() : null,
            'inch' => $this->inches($product, $specs->all()),
            'kg' => $this->number('/(\d+(?:\.\d+)?)\s*kg\b/', Text::normalize($product->name . ' ' . ($specs['Wash Capacity'] ?? $specs['Washing Capacity'] ?? ''))),
            'ton' => $this->number('/(\d+(?:\.\d+)?)\s*ton\b/', Text::normalize($product->name . ' ' . ($specs['Capacity'] ?? ''))),
            'star' => ($star = $this->number('/(\d)\s*star\b/', Text::normalize($product->name . ' ' . ($specs['Energy Rating'] ?? '')))) ? (int) $star : null,
            'flags' => $this->flags($facts, $category?->slug, $parent?->slug),
            'cats' => array_values(array_filter([$category?->slug, $parent?->slug])),
            'featured' => (bool) $product->featured,
            'created' => $product->created_at?->timestamp ?? 0,
            'order' => (int) $product->sort_order,
        ];
    }

    private function inches(Product $product, array $specs): ?float
    {
        foreach (['Screen Size', 'Display Size', 'Screen', 'Size'] as $key) {
            if (isset($specs[$key]) && preg_match('/(\d+(?:\.\d+)?)\s*(?:inch|")/i', Text::normalize((string) $specs[$key]) . ' ', $m)) {
                return (float) $m[1];
            }
        }

        return $this->number('/(\d+(?:\.\d+)?)\s*inch\b/', Text::normalize($product->name));
    }

    private function number(string $pattern, string $text): ?float
    {
        return preg_match($pattern, $text, $m) ? (float) $m[1] : null;
    }

    private function flags(string $t, ?string $category, ?string $parent): array
    {
        $has = fn (string $re) => (bool) preg_match($re, $t);
        $isTv = in_array('televisions', [$category, $parent], true);
        $four = $has('/\b4k\b|3840|\buhd\b|2160/');
        $full = ! $four && $has('/full hd|1920\s*(x|×)?\s*1080|1080p|\bfhd\b/');

        $flags = [
            '4k' => $four,
            'fhd' => $full,
            'hd' => ! $four && ! $full && $has('/\bhd\b|1280|720p/'),
            'qled' => $has('/qled/'),
            'mini_qled' => $has('/mini qled/'),
            'google_tv' => $has('/google tv/'),
            'non_smart' => $category === 'non-smart-tv' || $has('/non smart/'),
            'anti_glare' => $has('/anti glare/'),
            'dolby' => $has('/dolby/'),
            'voice' => $has('/voice/'),
            'inverter' => $has('/inverter/'),
            'front_load' => $has('/front load/'),
            'top_load' => $has('/top load/'),
            'fully_auto' => $has('/fully automatic/'),
            'semi_auto' => $has('/semi automatic|twin tub/'),
            'indoor' => $has('/\bindoor\b/'),
            'outdoor' => $has('/\boutdoor\b/'),
            'rental' => $has('/\brental\b/'),
            'touch' => $has('/\btouch/'),
            'bluetooth' => $has('/bluetooth/'),
            'portable' => $has('/portable|foldable/'),
            'steel_drum' => $has('/stainless steel/'),
        ];

        $flags['smart'] = $isTv && ! $flags['non_smart'] && $has('/smart|android|google tv|prism os|cloud os|gaia os/');

        return array_keys(array_filter($flags));
    }

    /**
     * slug → name, parent slug and all descendant slugs.
     */
    private function categoryTree($categories): array
    {
        $byId = $categories->keyBy('id');
        $children = $categories->groupBy('parent_id');
        $tree = [];

        $descendants = function ($id) use (&$descendants, $children) {
            return collect($children[$id] ?? [])->flatMap(fn ($c) => [$c->slug, ...$descendants($c->id)])->all();
        };

        foreach ($categories as $category) {
            $tree[$category->slug] = [
                'name' => $category->name,
                'parent' => $byId[$category->parent_id]->slug ?? null,
                'descendants' => $descendants($category->id),
                'description' => (string) $category->description,
            ];
        }

        return $tree;
    }
}
