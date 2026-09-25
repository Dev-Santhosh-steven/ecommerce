<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->get();

        $categories = Category::active()
            ->topLevel()
            ->withCount('children')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $featuredProducts = Product::where('status', true)
            ->where('featured', true)
            ->with('primaryImage')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        $newArrivals = Product::where('status', true)
            ->with('primaryImage')
            ->latest()
            ->limit(8)
            ->get();

        $ledCategory = Category::active()->where('slug', 'led-video-walls')->first();

        return view('store.home', compact('banners', 'categories', 'featuredProducts', 'newArrivals', 'ledCategory'));
    }
}
