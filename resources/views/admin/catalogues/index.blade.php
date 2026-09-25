@extends('admin.layouts.app')

@section('title', 'Catalogues')

@section('page-title', 'Catalogues')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Catalogues
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage the PDF catalogues shown on the public Catalogue page.
            </p>
        </div>

        <a
            href="{{ route('admin.catalogues.create') }}"
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

            Add Catalogue
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


    <!-- Catalogues Table -->
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
                    All Catalogues
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $catalogues->total() }} catalogues
                </p>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Catalogue
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            File
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Sort
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($catalogues as $catalogue)

                        <tr class="transition hover:bg-slate-50">

                            <!-- Catalogue -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-500">
                                        <i data-lucide="file-text" class="h-6 w-6"></i>
                                    </div>

                                    <p class="font-semibold text-slate-900">
                                        {{ $catalogue->title }}
                                    </p>

                                </div>

                            </td>


                            <!-- File -->
                            <td class="px-6 py-5">

                                <a
                                    href="{{ asset('storage/' . $catalogue->file) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="inline-flex items-center gap-1.5 text-sm text-slate-600 underline decoration-slate-300 underline-offset-2 hover:text-slate-900"
                                >
                                    View PDF
                                    <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                                </a>

                            </td>


                            <!-- Sort -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-700">
                                    {{ $catalogue->sort_order }}
                                </span>

                            </td>


                            <!-- Status -->
                            <td class="px-6 py-5">

                                @if ($catalogue->status)

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('admin.catalogues.edit', $catalogue) }}"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                        title="Edit catalogue"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.catalogues.destroy', $catalogue) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this catalogue?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                            title="Delete catalogue"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i data-lucide="file-text" class="h-8 w-8"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-900">
                                        No catalogues yet
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Upload your first product catalogue PDF.
                                    </p>

                                    <a
                                        href="{{ route('admin.catalogues.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                    >
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                        Add Catalogue
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($catalogues->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $catalogues->links() }}
            </div>

        @endif

    </div>

@endsection
