<?php

namespace App\Services\Search;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/**
 * Pages, categories, guides and blog posts, so a search also finds "warranty", "LED wall calculator"
 * or an article, not only products.
 */
final class SiteIndex
{
    /**
     * Fixed pages: route => [title, kind, icon, words people use for it].
     */
    public const PAGES = [
        'store.interactivepanels' => ['Interactive Flat Panels', 'Explore', 'presentation', 'smart board smart class classroom teaching school digital board touch 4k android education'],
        'store.ledwalls' => ['LED Video Walls', 'Explore', 'layout-grid', 'led wall video wall billboard stage screen outdoor indoor pixel pitch rental quote p125 p153 p186 p25 p26 p391 p4 p5 p8 p10'],
        'store.lcdwalls' => ['LCD Video Walls', 'Explore', 'layout-dashboard', 'lcd wall video wall control room narrow bezel quote'],
        'store.led-calculator' => ['LED Wall Calculator', 'Tool', 'calculator', 'calculator size resolution cabinet module pixel pitch plan measure wall'],
        'store.centum' => ['Yara Centum 100"', 'Explore', 'tv', '100 inch tv biggest tv big screen home theatre centum'],
        'store.antiglare' => ['Anti-Glare QLED TVs', 'Explore', 'sun', 'anti glare matte reflection bright room qled tv'],
        'store.chillers' => ['Chiller-Based AC Systems', 'Explore', 'snowflake', 'chiller central ac hvac mall office building cassette'],
        'store.tstandees' => ['T-Standees', 'Explore', 'monitor', 't standee digital signage floor standing display mall showroom'],
        'store.astandees' => ['A-Standees', 'Explore', 'monitor', 'a standee portable digital poster foldable'],
        'store.commercialdisplays' => ['Commercial Displays', 'Explore', 'monitor', 'commercial display signage menu board 24 7'],
        'store.homeaudio' => ['Home Audio', 'Explore', 'speaker', 'speaker soundbar subwoofer tower music bluetooth party'],
        'store.printingkiosk' => ['Printing Kiosk', 'Explore', 'printer', 'kiosk self order token billing receipt printer restaurant'],
        'store.standalonekiosk' => ['Stand Alone Kiosk', 'Explore', 'monitor', 'kiosk touch wayfinding directory check in'],
        'store.tabletopstandee' => ['Table Top Standee', 'Explore', 'tablet', 'table top standee jewellery try on menu counter'],
        'store.glassdisplays' => ['Glass Displays', 'Explore', 'monitor', 'glass display industrial rugged scanner'],
        'store.commercialwashers' => ['Commercial Washing Machines', 'Explore', 'washing-machine', 'commercial washer laundry hotel hospital hostel industrial'],
        'store.digitalpodium' => ['Digital Podium', 'Explore', 'mic', 'podium lectern auditorium conference microphone'],
        'store.warranty' => ['Warranty Terms', 'Help', 'shield-check', 'warranty guarantee years claim repair defect'],
        'store.delivery' => ['Delivery & Returns', 'Help', 'truck', 'delivery shipping days return refund replacement damaged cancel'],
        'store.contact' => ['Contact Us', 'Help', 'phone', 'contact phone email address showroom location call whatsapp support'],
        'store.demo.create' => ['Book a Free Demo', 'Help', 'calendar-check', 'demo demonstration trial see product book'],
        'store.certifications' => ['Certifications', 'Company', 'award', 'certification certificate certified iso bis bee rohs ce msme lei download quality license licence'],
        'store.catalogue' => ['Catalogues', 'Help', 'book-open', 'catalogue catalog brochure pdf download spec sheet'],
        'store.about' => ['About Yara Electronics', 'Company', 'building-2', 'about company factory ceezet made in india since 2018 story journey'],
        'store.e-waste' => ['E-Waste Management', 'Help', 'recycle', 'e waste recycle disposal old product'],
        'store.terms' => ['Terms & Conditions', 'Help', 'file-text', 'terms conditions policy'],
        'store.privacy' => ['Privacy Policy', 'Help', 'lock', 'privacy data policy'],
        'store.blog.index' => ['Blog', 'Articles', 'newspaper', 'blog articles news guides tips'],
    ];

    private const WEIGHTS = ['title' => 4.0, 'words' => 2.0, 'text' => 1.0];

    public function search(array $tokens, int $limit = 4): array
    {
        if (! $tokens) {
            return [];
        }

        return collect($this->entries())
            ->map(function (array $entry) use ($tokens) {
                $score = 0;
                $matched = 0;

                foreach ($tokens as $token) {
                    $best = 0;
                    foreach (self::WEIGHTS as $field => $weight) {
                        foreach ($entry['tokens'][$field] as $word) {
                            $best = max($best, match (true) {
                                $word === $token => $weight,
                                strlen($token) >= 4 && (str_starts_with($word, $token) || str_starts_with($token, $word) && strlen($word) >= 4) => $weight * 0.6,
                                default => 0,
                            });
                        }
                    }
                    $score += $best;
                    $matched += $best > 0 ? 1 : 0;
                }

                return [...$entry, 'score' => $score * ($matched / count($tokens))];
            })
            ->filter(fn ($e) => $e['score'] >= 2)
            ->sortByDesc('score')
            // An explore page and its category often share a title: keep the first (best) one.
            ->unique('title')
            ->take($limit)
            ->map(fn ($e) => [...array_intersect_key($e, array_flip(['title', 'kind', 'icon', 'summary'])), 'url' => route($e['route'][0], $e['route'][1])])
            ->values()
            ->all();
    }

    private function entries(): array
    {
        $signature = md5(Category::max('updated_at') . Post::max('updated_at') . Post::count() . filemtime(__FILE__));

        return Cache::remember("search.site.{$signature}", now()->addDay(), fn () => $this->build());
    }

    private function build(): array
    {
        $entries = [];

        foreach (self::PAGES as $route => [$title, $kind, $icon, $words]) {
            if (Route::has($route)) {
                $entries[] = $this->entry($title, [$route, []], $kind, $icon, $words, '');
            }
        }

        foreach (Category::where('status', true)->get() as $category) {
            $entries[] = $this->entry($category->name, ['store.category', [$category->slug]], 'Category', 'layout-grid', '', (string) $category->description);
        }

        foreach (Post::where('is_published', true)->get(['title', 'slug', 'category', 'excerpt']) as $post) {
            $entries[] = $this->entry($post->title, ['store.blog.show', [$post->slug]], 'Article', 'newspaper', (string) $post->category, (string) $post->excerpt);
        }

        return $entries;
    }

    private function entry(string $title, array $route, string $kind, string $icon, string $words, string $text): array
    {
        return [
            'title' => $title,
            'route' => $route,
            'kind' => $kind,
            'icon' => $icon,
            'summary' => str($text)->limit(110)->toString(),
            'tokens' => [
                'title' => Text::tokens($title),
                'words' => Text::tokens($words),
                'text' => array_slice(Text::tokens($text), 0, 60),
            ],
        ];
    }
}
