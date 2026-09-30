<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Keeps links to the previous website working (Google results, bookmarks, shared links).
 *
 * Runs for any address no other route handles. Known old addresses (config/legacy_redirects.php)
 * get a 301 to their new page, so search engines move their ranking across; a current product or
 * category slug typed without its prefix is redirected too; anything else is a normal 404.
 */
class LegacyRedirectController extends Controller
{
    public function __invoke(Request $request)
    {
        abort_unless($request->isMethod('GET') || $request->isMethod('HEAD'), 404);

        $path = trim(mb_strtolower(rawurldecode($request->path())), '/');

        $map = config('legacy_redirects.pages', []) + config('legacy_redirects.products', []);

        $url = isset($map[$path]) ? $this->resolve($map[$path]) : $this->guess($path);

        abort_unless($url, 404);

        return redirect()->to($url, 301);
    }

    private function resolve(string $target): ?string
    {
        [$type, $value] = array_pad(explode(':', $target, 2), 2, '');

        return match ($type) {
            'sku' => $this->product($value),
            'category' => Category::where('slug', $value)->where('status', true)->exists() ? route('store.category', $value) : route('store.search'),
            'route' => Route::has($value) ? route($value) : null,
            'url' => url($value),
            default => null,
        };
    }

    /**
     * The product with that model number / SKU; if it's hidden, its category; otherwise a search for it.
     */
    private function product(string $model): string
    {
        $product = Product::with('category')
            ->where(fn ($q) => $q->where('model_number', $model)->orWhere('sku', $model)->orWhere('sku', 'like', '%-' . $model))
            ->orderByDesc('status')
            ->first();

        return match (true) {
            $product?->status => $product->url(),
            $product?->category?->status => route('store.category', $product->category),
            default => route('store.search', ['q' => $model]),
        };
    }

    /**
     * Not in the map: a current product or category slug used without its "/product" or "/category" prefix.
     */
    private function guess(string $path): ?string
    {
        if (! preg_match('/^[a-z0-9-]+$/', $path)) {
            return null;
        }

        if ($product = Product::where('slug', $path)->where('status', true)->first()) {
            return $product->url();
        }

        if (Category::where('slug', $path)->where('status', true)->exists()) {
            return route('store.category', $path);
        }

        return null;
    }
}
