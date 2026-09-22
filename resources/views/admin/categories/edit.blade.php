@extends('admin.layouts.app')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Edit Category</h1>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Parent Category</label>
                <select name="parent_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                    <option value="">None</option>
                    @foreach ($parentCategories as $item)
                        <option value="{{ $item->id }}" {{ old('parent_id', $category->parent_id) == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Description</label>
                <textarea name="description" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">{{ old('description', $category->description) }}</textarea>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Thumbnail Image</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                <p class="mt-1 text-xs text-slate-500">Shown in category grids and menus.</p>
                @if ($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="mt-3 h-20 w-20 rounded-lg object-cover">
                @endif
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Banner Image</label>
                <input type="file" name="banner" accept="image/*" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                <p class="mt-1 text-xs text-slate-500">Wide hero image shown at the top of this category's page.</p>
                @if ($category->banner)
                    <img src="{{ asset('storage/' . $category->banner) }}" alt="{{ $category->name }} banner" class="mt-3 h-20 w-40 rounded-lg object-cover">
                @endif
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                        <option value="1" {{ old('status', $category->status) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $category->status) ? '' : 'selected' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
