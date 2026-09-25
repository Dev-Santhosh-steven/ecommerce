@extends('admin.layouts.app')

@section('title', 'Edit LED Module')

@section('page-title', 'Edit LED Module')

@section('content')
    <div class="max-w-5xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Edit {{ $module->name }}</h1>
        <p class="mt-1 text-sm text-slate-500">Active modules appear in the public LED Wall Calculator.</p>

        <form action="{{ route('admin.led-modules.update', $module) }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')

            @include('admin.led-modules._form')

            <div class="mt-8 flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Module</button>
                <a href="{{ route('admin.led-modules.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
