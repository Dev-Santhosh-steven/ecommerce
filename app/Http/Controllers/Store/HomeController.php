<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;

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

        return view('store.home', compact('banners', 'categories'));
    }
}
