<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Curated icon choices for product highlight features (icon => label).
     */
    public const FEATURE_ICONS = [
        'tv' => 'Display',
        'monitor' => 'Monitor',
        'monitor-smartphone' => 'Screen Mirroring',
        'zap' => 'Fast / Power',
        'volume-2' => 'Sound',
        'speaker' => 'Speaker',
        'audio-waveform' => 'Audio',
        'wifi' => 'Wi-Fi',
        'bluetooth' => 'Bluetooth',
        'shield-check' => 'Protection / Warranty',
        'sparkles' => 'Highlight',
        'gauge' => 'Performance',
        'palette' => 'Colour',
        'cpu' => 'Processor',
        'camera' => 'Camera',
        'smartphone' => 'Smart Control',
        'sun' => 'Brightness',
        'eye' => 'Picture Quality',
        'award' => 'Certified',
        'battery-charging' => 'Energy Efficient',
        'wind' => 'Air Flow',
        'snowflake' => 'Cooling',
        'droplets' => 'Water / Wash',
        'thermometer' => 'Temperature',
        'timer' => 'Timer',
        'star' => 'Premium',
        'circle-check-big' => 'Verified',
        'gamepad-2' => 'Gaming',
        'rotate-3d' => '360° View',
        'layers' => 'Design',
    ];

    public function index()
    {
        $products = Product::with('category', 'primaryImage')->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('status', true)->get();
        $attributes = Attribute::with('values')->orderBy('sort_order')->get();
        $featureIcons = self::FEATURE_ICONS;

        return view('admin.products.create', compact('categories', 'attributes', 'featureIcons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
            'model_number' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'price_unit' => ['nullable', 'string', 'max:20'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'warranty_months' => ['nullable', 'integer', 'min:0'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'array'],
            'features.*.icon' => ['nullable', 'string', 'max:255'],
            'features.*.title' => ['nullable', 'string', 'max:255'],
            'features.*.description' => ['nullable', 'string', 'max:255'],
            'status' => ['boolean'],
            'featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'attribute_values' => ['nullable', 'array'],
            'attribute_values.*' => ['exists:attribute_values,id'],
        ]);

        $images = $validated['images'] ?? [];
        unset($validated['images']);

        $attributeValues = $validated['attribute_values'] ?? [];
        unset($validated['attribute_values']);

        $features = $validated['features'] ?? [];
        unset($validated['features']);

        $validated['specifications'] = $this->parseSpecifications($validated['specifications'] ?? []);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $product = Product::create($validated);

        $product->attributeValues()->sync($attributeValues);

        $this->syncFeatures($product, $features);

        foreach ($images as $index => $image) {
            $product->images()->create([
                'image' => $image->store('products', 'public'),
                'sort_order' => $index,
                'is_primary' => $index === 0,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('images', 'category');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', true)->get();
        $attributes = Attribute::with('values')->orderBy('sort_order')->get();
        $featureIcons = self::FEATURE_ICONS;

        $product->load('images', 'attributeValues', 'features');

        return view('admin.products.edit', compact('product', 'categories', 'attributes', 'featureIcons'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'model_number' => ['nullable', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'price_unit' => ['nullable', 'string', 'max:20'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'warranty_months' => ['nullable', 'integer', 'min:0'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.key' => ['nullable', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'array'],
            'features.*.icon' => ['nullable', 'string', 'max:255'],
            'features.*.title' => ['nullable', 'string', 'max:255'],
            'features.*.description' => ['nullable', 'string', 'max:255'],
            'status' => ['boolean'],
            'featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'attribute_values' => ['nullable', 'array'],
            'attribute_values.*' => ['exists:attribute_values,id'],
        ]);

        $images = $validated['images'] ?? [];
        unset($validated['images']);

        $attributeValues = $validated['attribute_values'] ?? [];
        unset($validated['attribute_values']);

        $features = $validated['features'] ?? [];
        unset($validated['features']);

        $validated['specifications'] = $this->parseSpecifications($validated['specifications'] ?? []);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);

        $product->update($validated);

        $product->attributeValues()->sync($attributeValues);

        $this->syncFeatures($product, $features);

        $hasPrimary = $product->images()->where('is_primary', true)->exists();
        $nextSortOrder = (int) $product->images()->max('sort_order') + 1;

        foreach ($images as $index => $image) {
            $product->images()->create([
                'image' => $image->store('products', 'public'),
                'sort_order' => $nextSortOrder + $index,
                'is_primary' => !$hasPrimary && $index === 0,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    /**
     * Delete a single product image.
     */
    public function destroyImage(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);

        $wasPrimary = $image->is_primary;

        $image->delete();

        if ($wasPrimary) {
            $product->images()->orderBy('sort_order')->first()?->update(['is_primary' => true]);
        }

        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Mark a product image as the primary image.
     */
    public function setPrimaryImage(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);

        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Primary image updated successfully.');
    }

    /**
     * Turn the [{key, value}, ...] repeater rows into a plain key => value map.
     */
    private function parseSpecifications(array $rows): array
    {
        return collect($rows)
            ->filter(fn ($row) => filled($row['key'] ?? null) && filled($row['value'] ?? null))
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Replace a product's highlight features with the submitted [{icon, title, description}, ...] rows.
     */
    private function syncFeatures(Product $product, array $rows): void
    {
        $product->features()->delete();

        collect($rows)
            ->filter(fn ($row) => filled($row['title'] ?? null))
            ->values()
            ->each(function (array $row, int $index) use ($product) {
                $product->features()->create([
                    'icon' => $row['icon'] ?: 'sparkles',
                    'title' => $row['title'],
                    'description' => $row['description'] ?? null,
                    'sort_order' => $index,
                ]);
            });
    }
}
