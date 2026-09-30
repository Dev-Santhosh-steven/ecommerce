@extends('admin.layouts.app')

@section('title', 'Add Certification')

@section('page-title', 'Add Certification')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Add Certification</h1>

        <form action="{{ route('admin.certifications.store') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
            @csrf

            @include('admin.certifications._form')

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Save Certification</button>
                <a href="{{ route('admin.certifications.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
