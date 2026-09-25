@extends('admin.layouts.app')

@section('title', 'Attributes')

@section('page-title', 'Attributes')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Attributes
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage product attributes (Size, AC Ton, Washing Machine Weight, etc.) and their values.
            </p>
        </div>

        <a
            href="{{ route('admin.attributes.create') }}"
            class="
                inline-flex items-center justify-center gap-2
                rounded-xl bg-slate-900
                px-5 py-3
                text-sm font-semibold text-white
                transition
                hover:bg-slate-800
            "
        >
            <i data-lucide="plus" class="h-5 w-5"></i>

            Add Attribute
        </a>

    </div>


    <!-- Success Message -->
    @if (session('success'))

        <div
            class="
                mb-6 flex items-center gap-3
                rounded-xl border border-emerald-200
                bg-emerald-50
                px-4 py-3
                text-sm text-emerald-700
            "
        >

            <i data-lucide="circle-check" class="h-5 w-5"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- Attributes Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div
            class="
                flex flex-col gap-3
                border-b border-slate-200
                px-6 py-5
                sm:flex-row sm:items-center sm:justify-between
            "
        >

            <div>

                <h3 class="font-semibold text-slate-900">
                    All Attributes
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $attributes->count() }} attributes
                </p>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[600px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Attribute
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Values
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Sort
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($attributes as $attribute)

                        <tr class="transition hover:bg-slate-50">

                            <!-- Attribute -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-500">
                                        <i data-lucide="sliders-horizontal" class="h-5 w-5"></i>
                                    </div>

                                    <p class="font-semibold text-slate-900">
                                        {{ $attribute->name }}
                                    </p>

                                </div>

                            </td>


                            <!-- Values -->
                            <td class="px-6 py-5">

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                    {{ $attribute->values_count }} {{ \Illuminate\Support\Str::plural('value', $attribute->values_count) }}
                                </span>

                            </td>


                            <!-- Sort -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-700">
                                    {{ $attribute->sort_order }}
                                </span>

                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('admin.attributes.edit', $attribute) }}"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                        title="Manage attribute"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.attributes.destroy', $attribute) }}"
                                        onsubmit="return confirm('Delete this attribute and all its values? Products using them will lose this attribute.');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                            title="Delete attribute"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i data-lucide="sliders-horizontal" class="h-8 w-8"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-900">
                                        No attributes yet
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Create your first attribute, like "Size" or "AC Ton".
                                    </p>

                                    <a
                                        href="{{ route('admin.attributes.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                    >
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                        Add Attribute
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
