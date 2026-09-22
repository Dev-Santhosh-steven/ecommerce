@extends('admin.layouts.app')

@section('title', 'Edit Banner')

@section('page-title', 'Edit Banner')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Edit Banner</h1>

        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Title</label>
                <input type="text" name="title" value="{{ old('title', $banner->title) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Subtitle</label>
                <input type="text" name="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                @error('subtitle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Image</label>
                <input type="file" name="image" accept="image/*" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="mt-3 h-24 w-40 rounded-lg object-cover">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Button Text</label>
                    <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Button Link</label>
                    <input type="text" name="button_link" value="{{ old('button_link', $banner->button_link) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                        <option value="1" {{ old('status', $banner->status) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $banner->status) ? '' : 'selected' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" min="0" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Banner</button>
                <a href="{{ route('admin.banners.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
