<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_unless($product->status, 404);

        $product->load(['images', 'category', 'attributeValues.attribute', 'features', 'ledModule']);

        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', true)
            ->with('primaryImage')
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('store.product', compact('product', 'related'));
    }
}
