<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        abort_unless($category->status, 404);

        $category->load([
            'children' => function ($query) {
                $query->active()->orderBy('sort_order')->orderBy('name');
            },
        ]);

        $products = $category->products()
            ->where('status', true)
            ->with('primaryImage')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('store.category', compact('category', 'products'));
    }
}
