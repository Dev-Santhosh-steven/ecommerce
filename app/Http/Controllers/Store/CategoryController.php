<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\LedModule;
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

        $products = $category->products()
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
        $filterAttributes = Attribute::whereHas('values.products', function ($query) use ($category) {
                $query->where('category_id', $category->id)->where('status', true);
            })
            ->with(['values' => function ($query) use ($category) {
                $query->whereHas('products', function ($q) use ($category) {
                    $q->where('category_id', $category->id)->where('status', true);
                })->orderBy('sort_order');
            }])
            ->orderBy('sort_order')
            ->get();

        $priceBounds = $category->products()
            ->where('status', true)
            ->selectRaw('MIN(COALESCE(sale_price, price)) as min_price, MAX(COALESCE(sale_price, price)) as max_price')
            ->first();

        $hasLedCalculator = LedModule::where('is_active', true)
            ->whereHas('product', fn ($query) => $query->where('category_id', $category->id))
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
}
