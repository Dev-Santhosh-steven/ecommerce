@extends('admin.layouts.app')

@section('title', 'Manage Attribute')

@section('page-title', 'Manage Attribute')

@section('content')

    <div class="mx-auto max-w-2xl space-y-6">

        <!-- Success Message -->
        @if (session('success'))

            <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <i data-lucide="circle-check" class="h-5 w-5"></i>
                <span>{{ session('success') }}</span>
            </div>

        @endif


        <!-- Attribute Details -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <h1 class="text-2xl font-bold">Edit Attribute</h1>

            <form action="{{ route('admin.attributes.update', $attribute) }}" method="POST" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $attribute->name) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $attribute->sort_order) }}" min="0" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Update Attribute</button>
                    <a href="{{ route('admin.attributes.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Back to Attributes</a>
                </div>
            </form>

        </div>


        <!-- Values -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <h2 class="text-lg font-bold">Values</h2>
            <p class="mt-1 text-sm text-slate-500">
                The individual options for "{{ $attribute->name }}" &mdash; e.g. 24", 32", 43".
            </p>

            @if ($attribute->values->isNotEmpty())

                <ul class="mt-5 divide-y divide-slate-100 rounded-xl border border-slate-200">

                    @foreach ($attribute->values as $value)

                        <li class="flex items-center justify-between gap-3 px-4 py-3">

                            <span class="text-sm font-medium text-slate-800">
                                {{ $value->value }}
                            </span>

                            <form
                                method="POST"
                                action="{{ route('admin.attributes.values.destroy', [$attribute, $value]) }}"
                                onsubmit="return confirm('Delete this value? Products using it will lose this value.');"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="rounded-lg p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600" title="Delete value">
                                    <i data-lucide="trash-2" class="h-4 w-4"></i>
                                </button>
                            </form>

                        </li>

                    @endforeach

                </ul>

            @else

                <p class="mt-5 rounded-xl border border-dashed border-slate-300 px-4 py-6 text-center text-sm text-slate-500">
                    No values yet. Add the first one below.
                </p>

            @endif

            <form action="{{ route('admin.attributes.values.store', $attribute) }}" method="POST" class="mt-5 flex items-start gap-3">
                @csrf

                <div class="flex-1">
                    <input type="text" name="value" value="{{ old('value') }}" placeholder='e.g. 55"' class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" required>
                    @error('value')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Add Value
                </button>
            </form>

        </div>

    </div>

@endsection
