@extends('admin.layouts.app')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Create Theme Section</h1>

        <form action="{{ route('admin.theme-sections.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Page</label>
                <input type="text" name="page" value="{{ old('page', 'homepage') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Type</label>
                <select name="type" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                    <option value="hero">Hero</option>
                    <option value="categories">Categories</option>
                    <option value="products">Products</option>
                    <option value="promo_banner">Promo Banner</option>
                    <option value="benefits">Benefits</option>
                    <option value="image_text">Image and Text</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Position</label>
                <input type="number" name="position" value="{{ old('position', 0) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Settings (JSON)</label>
                <textarea name="settings" rows="6" class="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm focus:border-slate-500 focus:outline-none">{{ old('settings') }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Save Section</button>
                <a href="{{ route('admin.theme-sections.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
