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

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Price</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Sale Price</label>
                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
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
