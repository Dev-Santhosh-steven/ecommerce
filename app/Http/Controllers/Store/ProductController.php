<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_unless($product->status, 404);

        // Products with their own showcase page (Centum, Chillers) send visitors there so the features come first.
        if (isset(Product::SHOWCASE_ROUTES[$product->sku])) {
            return redirect()->to($product->url());
        }

        $product->load(['images', 'category', 'attributeValues.attribute', 'features', 'ledModule']);

        $related = $this->related($product);

        return view('store.product', compact('product', 'related'));
    }

    /**
     * Four products to recommend, so the row is always full: same sub-category first, then sister
     * sub-categories under the same parent, then the parent itself, then featured products.
     */
    private function related(Product $product, int $count = 4)
    {
        $category = $product->category;
        $pools = [[$product->category_id]];
        if ($category?->parent_id) {
            $pools[] = Category::where('parent_id', $category->parent_id)->where('status', true)->pluck('id')->all();
            $pools[] = [$category->parent_id];
        }

        $related = collect();
        foreach ($pools as $ids) {
            $related = $related->merge(
                Product::whereIn('category_id', $ids)
                    ->where('status', true)
                    ->whereNotIn('id', $related->pluck('id')->push($product->id))
                    ->with('primaryImage')
                    ->inRandomOrder()
                    ->limit($count - $related->count())
                    ->get()
            );
            if ($related->count() >= $count) {
                return $related;
            }
        }

        return $related->merge(
            Product::where('status', true)
                ->where('featured', true)
                ->whereNotIn('id', $related->pluck('id')->push($product->id))
                ->with('primaryImage')
                ->inRandomOrder()
                ->limit($count - $related->count())
                ->get()
        );
    }
}
