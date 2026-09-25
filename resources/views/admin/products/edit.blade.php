@extends('admin.layouts.app')

@section('content')
    <div class="max-w-4xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Edit Product</h1>

        @if ($product->images->isNotEmpty())

            <div class="mt-6">
                <label class="mb-2 block text-sm font-medium text-slate-700">Current Images</label>

                <div class="grid grid-cols-3 gap-4 sm:grid-cols-4 md:grid-cols-6">

                    @foreach ($product->images as $image)

                        <div class="group relative overflow-hidden rounded-lg border border-slate-200">

                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}" class="aspect-square w-full object-cover">

                            @if ($image->is_primary)

                                <span class="absolute left-1 top-1 rounded-full bg-slate-900 px-2 py-0.5 text-[10px] font-semibold text-white">
                                    Primary
                                </span>

                            @endif

                            <div class="absolute inset-x-0 bottom-0 flex items-center justify-center gap-1 bg-black/60 p-1 opacity-0 transition group-hover:opacity-100">

                                @unless ($image->is_primary)

                                    <form method="POST" action="{{ route('admin.products.images.primary', [$product, $image]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded p-1 text-white hover:bg-white/20" title="Set as primary">
                                            <i data-lucide="star" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                @endunless

                                <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $image]) }}" onsubmit="return confirm('Delete this image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded p-1 text-white hover:bg-white/20" title="Delete image">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>

                            </div>

                        </div>

                    @endforeach

                </div>
            </div>

        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Category</label>
                    <select name="category_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Model Number</label>
                    <input type="text" name="model_number" value="{{ old('model_number', $product->model_number) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Short Description</label>
                <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Description</label>
                <textarea name="description" rows="5" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>
            </div>

            @php
                $existingSpecs = collect($product->specifications ?? [])
                    ->map(fn ($value, $key) => ['key' => $key, 'value' => $value])
                    ->values();

                if ($existingSpecs->isEmpty()) {
                    $existingSpecs = collect([['key' => '', 'value' => '']]);
                }
            @endphp

            <div
                x-data="{
                    specs: {{ $existingSpecs->toJson() }},
                    async importCsv(event) {
                        const file = event.target.files[0];
                        if (!file) return;
                        let rows = await window.readCsvFile(file);
                        if (rows.length && /^(key|title)$/i.test(rows[0][0] || '') && /^value$/i.test(rows[0][1] || '')) {
                            rows = rows.slice(1);
                        }
                        const parsed = rows.filter((r) => r[0]).map((r) => ({ key: r[0] || '', value: r[1] || '' }));
                        if (!parsed.length) return;
                        const isEmpty = this.specs.length === 1 && !this.specs[0].key && !this.specs[0].value;
                        this.specs = isEmpty ? parsed : [...this.specs, ...parsed];
                        event.target.value = '';
                    },
                }"
            >
                <label class="mb-1 block text-sm font-medium text-slate-700">Specifications</label>
                <p class="mb-3 text-xs text-slate-500">Shown as a spec table on the product page (e.g. Screen Size &rarr; 55").</p>

                <div class="mb-3 flex flex-wrap items-center gap-3 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-3">
                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-300 hover:bg-slate-100">
                        <i data-lucide="upload" class="h-4 w-4"></i>
                        Upload CSV
                        <input type="file" accept=".csv" class="hidden" @change="importCsv($event)">
                    </label>
                    <a href="data:text/csv;charset=utf-8,Screen%20Size,55%20inch%0AResolution,4K%20Ultra%20HD%0ARefresh%20Rate,120Hz" download="specifications-template.csv" class="text-xs font-medium text-slate-500 underline hover:text-slate-700">
                        Download sample CSV
                    </a>
                    <span class="text-xs text-slate-400">Format: Title,Value &mdash; one per line.</span>
                </div>

                <div class="space-y-2">
                    <template x-for="(spec, index) in specs" :key="index">
                        <div class="flex gap-2">
                            <input type="text" :name="`specifications[${index}][key]`" x-model="spec.key" placeholder="Screen Size" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                            <input type="text" :name="`specifications[${index}][value]`" x-model="spec.value" placeholder="55 inch" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                            <button type="button" @click="specs.length > 1 && specs.splice(index, 1)" class="shrink-0 rounded-lg px-3 text-lg leading-none text-slate-400 hover:bg-red-50 hover:text-red-600" title="Remove">
                                &times;
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="specs.push({ key: '', value: '' })" class="mt-2 inline-flex items-center gap-1.5 text-sm font-medium text-slate-700 hover:text-slate-900">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Add Specification
                </button>
            </div>

            @php
                $existingFeatures = $product->features
                    ->map(fn ($feature) => ['icon' => $feature->icon, 'title' => $feature->title, 'description' => $feature->description])
                    ->values();

                if ($existingFeatures->isEmpty()) {
                    $existingFeatures = collect([['icon' => 'sparkles', 'title' => '', 'description' => '']]);
                }
            @endphp

            <div
                x-data="{
                    features: {{ $existingFeatures->toJson() }},
                    validIcons: {{ \Illuminate\Support\Js::from(array_keys($featureIcons)) }},
                    async importCsv(event) {
                        const file = event.target.files[0];
                        if (!file) return;
                        let rows = await window.readCsvFile(file);
                        if (rows.length && /^icon$/i.test(rows[0][0] || '') && /^title$/i.test(rows[0][1] || '')) {
                            rows = rows.slice(1);
                        }
                        const parsed = rows.filter((r) => r[1]).map((r) => ({
                            icon: this.validIcons.includes((r[0] || '').toLowerCase().trim()) ? r[0].toLowerCase().trim() : 'sparkles',
                            title: r[1] || '',
                            description: r[2] || '',
                        }));
                        if (!parsed.length) return;
                        const isEmpty = this.features.length === 1 && !this.features[0].title;
                        this.features = isEmpty ? parsed : [...this.features, ...parsed];
                        event.target.value = '';
                    },
                }"
            >
                <label class="mb-1 block text-sm font-medium text-slate-700">Key Features</label>
                <p class="mb-3 text-xs text-slate-500">Marketing highlights shown as feature cards on the product page (e.g. Dolby Atmos Sound &mdash; Immersive audio with deep, powerful bass).</p>

                <div class="mb-3 flex flex-wrap items-center gap-3 rounded-lg border border-dashed border-slate-300 bg-slate-50 p-3">
                    <label class="inline-flex cursor-pointer items-center gap-2 rounded-lg bg-white px-3 py-1.5 text-sm font-medium text-slate-700 ring-1 ring-slate-300 hover:bg-slate-100">
                        <i data-lucide="upload" class="h-4 w-4"></i>
                        Upload CSV
                        <input type="file" accept=".csv" class="hidden" @change="importCsv($event)">
                    </label>
                    <a href="data:text/csv;charset=utf-8,icon,title,description%0Aeye,4K%20Ultra%20HD%20Picture,Stunning%20clarity%20with%20vibrant%20colours%0Avolume-2,Dolby%20Atmos%20Sound,Rich%20theatre-like%20sound%20built%20in%0Awifi,Smart%20Connectivity,Built-in%20Wi-Fi%20and%20screen%20mirroring" download="features-template.csv" class="text-xs font-medium text-slate-500 underline hover:text-slate-700">
                        Download sample CSV
                    </a>
                    <span class="text-xs text-slate-400">Format: icon,title,description &mdash; icon is optional (leave blank for default).</span>
                </div>

                <div class="space-y-3">
                    <template x-for="(feature, index) in features" :key="index">
                        <div class="grid gap-2 rounded-lg border border-slate-200 p-3 sm:grid-cols-[140px_1fr_1fr_auto]">
                            <select :name="`features[${index}][icon]`" x-model="feature.icon" class="rounded-lg border border-slate-300 px-2 py-2 text-sm focus:border-slate-500 focus:outline-none">
                                @foreach ($featureIcons as $iconValue => $iconLabel)
                                    <option value="{{ $iconValue }}">{{ $iconLabel }}</option>
                                @endforeach
                            </select>
                            <input type="text" :name="`features[${index}][title]`" x-model="feature.title" placeholder="Dolby Atmos Sound" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
                            <input type="text" :name="`features[${index}][description]`" x-model="feature.description" placeholder="Immersive audio with deep, powerful bass" class="rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
                            <button type="button" @click="features.length > 1 && features.splice(index, 1)" class="shrink-0 rounded-lg px-3 text-lg leading-none text-slate-400 hover:bg-red-50 hover:text-red-600" title="Remove">
                                &times;
                            </button>
                        </div>
                    </template>
                </div>

                <button type="button" @click="features.push({ icon: 'sparkles', title: '', description: '' })" class="mt-2 inline-flex items-center gap-1.5 text-sm font-medium text-slate-700 hover:text-slate-900">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Add Feature
                </button>
            </div>

            <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Sale Price</label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Price Unit</label>
                    <input type="text" name="price_unit" value="{{ old('price_unit', $product->price_unit) }}" placeholder="Blank = per piece, or e.g. sq ft" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Stock Quantity</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Warranty Months</label>
                    <input type="number" name="warranty_months" value="{{ old('warranty_months', $product->warranty_months) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                        <option value="1" {{ old('status', $product->status) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $product->status) ? '' : 'selected' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Featured</label>
                    <select name="featured" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                        <option value="0" {{ old('featured', $product->featured) ? '' : 'selected' }}>No</option>
                        <option value="1" {{ old('featured', $product->featured) ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $product->sort_order) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Meta Description</label>
                <textarea name="meta_description" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">{{ old('meta_description', $product->meta_description) }}</textarea>
            </div>

            @if ($attributes->isNotEmpty())

                @php
                    $selectedAttributeValues = old('attribute_values', $product->attributeValues->pluck('id')->all());
                @endphp

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700">Attributes</label>
                    <p class="mb-3 text-xs text-slate-500">Select every value that applies to this product (e.g. Size: 55").</p>

                    <div class="grid gap-4 rounded-lg border border-slate-200 p-4 sm:grid-cols-2">

                        @foreach ($attributes as $attribute)

                            <div>
                                <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
                                    {{ $attribute->name }}
                                </p>

                                @if ($attribute->values->isEmpty())

                                    <p class="text-xs text-slate-400">No values yet.</p>

                                @else

                                    <div class="flex flex-wrap gap-2">

                                        @foreach ($attribute->values as $value)

                                            <label
                                                x-data="{ checked: {{ in_array($value->id, $selectedAttributeValues) ? 'true' : 'false' }} }"
                                                :style="checked ? 'background-color:#0f172a;border-color:#0f172a;color:#fff' : 'background-color:transparent;border-color:#cbd5e1;color:#334155'"
                                                class="inline-flex cursor-pointer items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-medium transition"
                                            >
                                                <input
                                                    type="checkbox"
                                                    name="attribute_values[]"
                                                    value="{{ $value->id }}"
                                                    x-model="checked"
                                                    class="hidden"
                                                >
                                                {{ $value->value }}
                                            </label>

                                        @endforeach

                                    </div>

                                @endif
                            </div>

                        @endforeach

                    </div>
                </div>

            @endif

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Add More Images</label>
                <input type="file" name="images[]" accept="image/*" multiple class="w-full rounded-lg border border-slate-300 px-3 py-2">
                <p class="mt-1 text-xs text-slate-500">Recommended size: 1000&times;1000px (square).</p>
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
