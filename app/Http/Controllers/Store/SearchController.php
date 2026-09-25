<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Full search results page.
     */
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q'));

        $products = Product::query()
            ->where('status', true)
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($inner) use ($query) {
                    $inner->where('name', 'like', "%{$query}%")
                        ->orWhere('brand', 'like', "%{$query}%")
                        ->orWhere('short_description', 'like', "%{$query}%")
                        ->orWhere('model_number', 'like', "%{$query}%");
                });
            })
            ->with('primaryImage')
            ->orderBy('sort_order')
            ->paginate(12)
            ->appends($request->query());

        return view('store.search', compact('products', 'query'));
    }

    /**
     * Instant search suggestions (JSON) for the header search box.
     */
    public function suggest(Request $request)
    {
        $query = trim((string) $request->input('q'));

        if ($query === '') {
            return response()->json([]);
        }

        $products = Product::query()
            ->where('status', true)
            ->where(function ($inner) use ($query) {
                $inner->where('name', 'like', "%{$query}%")
                    ->orWhere('brand', 'like', "%{$query}%")
                    ->orWhere('model_number', 'like', "%{$query}%");
            })
            ->with('primaryImage')
            ->limit(6)
            ->get()
            ->map(function (Product $product) {
                return [
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'url' => route('store.product', $product),
                    'image' => $product->primaryImage
                        ? asset('storage/' . $product->primaryImage->image)
                        : null,
                    'price' => number_format($product->sale_price ?? $product->price, 2),
                ];
            });

        return response()->json($products);
    }
}
