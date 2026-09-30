@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('page-title', 'Edit Testimonial')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Edit Testimonial</h1>

        <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @method('PUT')
            @include('admin.testimonials._form')

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Testimonial</button>
                <a href="{{ route('admin.testimonials.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
