<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->get();

        $categories = Category::active()
            ->topLevel()
            ->withCount('children')
            ->with(['children' => fn ($query) => $query->active()->orderBy('sort_order')->orderBy('name')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::where('status', true)
            ->where('featured', true)
            ->with(['primaryImage', 'category', 'features'])
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        // The Yara Centum 100" always takes the big spotlight card in "Popular Products".
        $centum = Product::where('status', true)
            ->where('sku', 'YE-CENTUM-100')
            ->with(['primaryImage', 'category', 'features'])
            ->first();

        if ($centum) {
            $featuredProducts = $featuredProducts->reject(fn (Product $p) => $p->is($centum))->prepend($centum)->take(8)->values();
        }

        $newArrivals = Product::where('status', true)
            ->with(['primaryImage', 'category'])
            ->latest()
            ->limit(12)
            ->get();

        $ledCategory = Category::active()->where('slug', 'led-video-walls')->first();

        $testimonials = Testimonial::active()->limit(9)->get();

        $latestPosts = Post::published()->limit(3)->get();

        $stats = Setting::current()->homeStats();

        return view('store.home', compact('banners', 'categories', 'featuredProducts', 'newArrivals', 'ledCategory', 'testimonials', 'latestPosts', 'stats'));
    }
}
