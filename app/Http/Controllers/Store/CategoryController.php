<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\LedModule;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category, Request $request)
    {
        abort_unless($category->status, 404);

        $category->load([
            'children' => function ($query) {
                $query->active()->orderBy('sort_order')->orderBy('name');
            },
        ]);

        $selectedValueIds = array_filter(
            array_map('intval', (array) $request->input('attributes', []))
        );

        $selectedAttributeValues = empty($selectedValueIds)
            ? collect()
            : AttributeValue::with('attribute')->whereIn('id', $selectedValueIds)->get();

        $priceMin = is_numeric($request->input('price_min')) ? (float) $request->input('price_min') : null;
        $priceMax = is_numeric($request->input('price_max')) ? (float) $request->input('price_max') : null;

        // A parent category lists the products of all its sub-categories too.
        $categoryIds = $this->descendantIds($category);

        $products = Product::whereIn('category_id', $categoryIds)
            ->where('status', true)
            ->with('primaryImage');

        if (!empty($selectedValueIds)) {
            $valuesByAttribute = AttributeValue::whereIn('id', $selectedValueIds)->get()->groupBy('attribute_id');

            foreach ($valuesByAttribute as $attributeId => $values) {
                $products->whereHas('attributeValues', function ($query) use ($values) {
                    $query->whereIn('attribute_values.id', $values->pluck('id'));
                });
            }
        }

        if ($priceMin !== null) {
            $products->whereRaw('COALESCE(sale_price, price) >= ?', [$priceMin]);
        }

        if ($priceMax !== null) {
            $products->whereRaw('COALESCE(sale_price, price) <= ?', [$priceMax]);
        }

        $sort = $request->input('sort', 'default');

        match ($sort) {
            'price_asc' => $products->orderByRaw('COALESCE(sale_price, price) asc'),
            'price_desc' => $products->orderByRaw('COALESCE(sale_price, price) desc'),
            'newest' => $products->latest(),
            'name_asc' => $products->orderBy('name'),
            default => $products->orderBy('sort_order'),
        };

        $products = $products
            ->paginate(12)
            ->appends($request->query());

        // Attributes/values that are actually used by active products in this category.
        $filterAttributes = Attribute::whereHas('values.products', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds)->where('status', true);
            })
            ->with(['values' => function ($query) use ($categoryIds) {
                $query->whereHas('products', function ($q) use ($categoryIds) {
                    $q->whereIn('category_id', $categoryIds)->where('status', true);
                })->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        $priceBounds = Product::whereIn('category_id', $categoryIds)
            ->where('status', true)
            ->selectRaw('MIN(COALESCE(sale_price, price)) as min_price, MAX(COALESCE(sale_price, price)) as max_price')
            ->first();

        $hasLedCalculator = LedModule::where('is_active', true)
            ->whereHas('product', fn ($query) => $query->whereIn('category_id', $categoryIds))
            ->exists();

        return view('store.category', compact(
            'hasLedCalculator',
            'category',
            'products',
            'filterAttributes',
            'selectedValueIds',
            'priceMin',
            'priceMax',
            'priceBounds',
            'sort',
            'selectedAttributeValues',
        ));
    }

    /**
     * The category's own id plus every active sub-category below it.
     */
    private function descendantIds(Category $category): array
    {
        $ids = [$category->id];
        $level = [$category->id];

        while ($level) {
            $level = Category::whereIn('parent_id', $level)->where('status', true)->pluck('id')->all();
            $ids = array_merge($ids, $level);
        }

        return $ids;
    }
}
