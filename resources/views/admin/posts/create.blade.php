@extends('admin.layouts.app')

@section('title', 'New Blog Post')

@section('page-title', 'New Blog Post')

@section('content')
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Create Blog Post</h1>

        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
            @include('admin.posts._form')

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Save Post</button>
                <a href="{{ route('admin.posts.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
