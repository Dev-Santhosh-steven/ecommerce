@extends('admin.layouts.app')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Edit Theme Section</h1>

        <form action="{{ route('admin.theme-sections.update', $themeSection) }}" method="POST" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Page</label>
                <input type="text" name="page" value="{{ old('page', $themeSection->page) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $themeSection->name) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Type</label>
                <select name="type" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                    <option value="hero" {{ old('type', $themeSection->type) == 'hero' ? 'selected' : '' }}>Hero</option>
                    <option value="categories" {{ old('type', $themeSection->type) == 'categories' ? 'selected' : '' }}>Categories</option>
                    <option value="products" {{ old('type', $themeSection->type) == 'products' ? 'selected' : '' }}>Products</option>
                    <option value="promo_banner" {{ old('type', $themeSection->type) == 'promo_banner' ? 'selected' : '' }}>Promo Banner</option>
                    <option value="benefits" {{ old('type', $themeSection->type) == 'benefits' ? 'selected' : '' }}>Benefits</option>
                    <option value="image_text" {{ old('type', $themeSection->type) == 'image_text' ? 'selected' : '' }}>Image and Text</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Position</label>
                <input type="number" name="position" value="{{ old('position', $themeSection->position) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                    <option value="1" {{ old('status', $themeSection->status) ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $themeSection->status) ? '' : 'selected' }}>Inactive</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Settings (JSON)</label>
                <textarea name="settings" rows="6" class="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm focus:border-slate-500 focus:outline-none">{{ old('settings', json_encode($themeSection->settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Section</button>
                <a href="{{ route('admin.theme-sections.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
