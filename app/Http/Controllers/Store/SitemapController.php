<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/**
 * /sitemap.xml for Google and other search engines: every public page, category, product and
 * blog post at its current address, so the new URLs get indexed in place of the old site's.
 * Listed in /robots.txt (routes/web.php).
 */
class SitemapController extends Controller
{
    /** Public store pages (named routes without parameters). */
    private const PAGES = [
        'store.home', 'store.about', 'store.contact', 'store.catalogue', 'store.certifications',
        'store.blog.index', 'store.demo.create', 'store.led-calculator',
        'store.centum', 'store.antiglare', 'store.chillers', 'store.homeaudio', 'store.commercialwashers',
        'store.interactivepanels', 'store.ledwalls', 'store.lcdwalls', 'store.commercialdisplays',
        'store.tstandees', 'store.astandees', 'store.tabletopstandee', 'store.digitalpodium',
        'store.printingkiosk', 'store.standalonekiosk', 'store.glassdisplays', 'store.industrialdisplays',
        'store.rotatabledisplay', 'store.doublesidedisplay',
        'store.delivery', 'store.warranty', 'store.e-waste', 'store.privacy', 'store.terms',
    ];

    public function __invoke(): Response
    {
        $urls = [];

        foreach (self::PAGES as $name) {
            if (Route::has($name)) {
                $urls[route($name)] = null;
            }
        }

        Category::where('status', true)->get(['slug', 'updated_at'])
            ->each(function ($category) use (&$urls) {
                $urls[route('store.category', $category->slug)] = $category->updated_at;
            });

        Product::where('status', true)->get()
            ->each(function ($product) use (&$urls) {
                // Products with an explore page (Centum, chillers ...) are listed at that page instead.
                $urls[$product->url()] ??= $product->updated_at;
            });

        Post::published()->get(['slug', 'updated_at'])
            ->each(function ($post) use (&$urls) {
                $urls[route('store.blog.show', $post->slug)] = $post->updated_at;
            });

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $loc => $updated) {
            $xml .= '  <url><loc>' . e($loc) . '</loc>'
                . ($updated ? '<lastmod>' . $updated->toAtomString() . '</lastmod>' : '')
                . "</url>\n";
        }

        return response($xml . '</urlset>' . "\n", 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }
}
