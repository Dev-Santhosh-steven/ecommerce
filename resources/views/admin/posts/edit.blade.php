@extends('admin.layouts.app')

@section('title', 'Edit Blog Post')

@section('page-title', 'Edit Blog Post')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-2xl font-bold">Edit Blog Post</h1>

            @if ($post->isLive())
                <a href="{{ route('store.blog.show', $post) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-slate-900">
                    <i data-lucide="external-link" class="h-4 w-4"></i>
                    View on website
                </a>
            @endif
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @method('PUT')
            @include('admin.posts._form')

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Post</button>
                <a href="{{ route('admin.posts.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
