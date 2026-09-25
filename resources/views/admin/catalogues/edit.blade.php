@extends('admin.layouts.app')

@section('title', 'Edit Catalogue')

@section('page-title', 'Edit Catalogue')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Edit Catalogue</h1>

        <form action="{{ route('admin.catalogues.update', $catalogue) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Title</label>
                <input type="text" name="title" value="{{ old('title', $catalogue->title) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">PDF File</label>
                <input type="file" name="file" accept="application/pdf" class="w-full rounded-lg border border-slate-300 px-3 py-2">

                <a
                    href="{{ asset('storage/' . $catalogue->file) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-3 inline-flex items-center gap-1.5 text-sm text-slate-600 underline decoration-slate-300 underline-offset-2 hover:text-slate-900"
                >
                    View current PDF
                    <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                </a>

                @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                        <option value="1" {{ old('status', $catalogue->status) ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status', $catalogue->status) ? '' : 'selected' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $catalogue->sort_order) }}" min="0" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Catalogue</button>
                <a href="{{ route('admin.catalogues.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
