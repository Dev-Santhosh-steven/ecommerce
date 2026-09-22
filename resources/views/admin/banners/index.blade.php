@extends('admin.layouts.app')

@section('title', 'Banners')

@section('page-title', 'Banners')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Banners
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage the homepage hero carousel slides.
            </p>
        </div>

        <a
            href="{{ route('admin.banners.create') }}"
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

            Add Banner
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


    <!-- Banners Table -->
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
                    All Banners
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $banners->total() }} banners
                </p>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Banner
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Button Link
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

                    @forelse ($banners as $banner)

                        <tr class="transition hover:bg-slate-50">

                            <!-- Banner -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    <img
                                        src="{{ asset('storage/' . $banner->image) }}"
                                        alt="{{ $banner->title }}"
                                        class="h-12 w-20 rounded-xl object-cover"
                                    >

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            {{ $banner->title ?: '—' }}
                                        </p>

                                        @if ($banner->subtitle)

                                            <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                                {{ $banner->subtitle }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            <!-- Button Link -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-700">
                                    {{ $banner->button_link ?: '—' }}
                                </span>

                            </td>


                            <!-- Sort -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-700">
                                    {{ $banner->sort_order }}
                                </span>

                            </td>


                            <!-- Status -->
                            <td class="px-6 py-5">

                                @if ($banner->status)

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
                                        href="{{ route('admin.banners.edit', $banner) }}"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                        title="Edit banner"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.banners.destroy', $banner) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this banner?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                            title="Delete banner"
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
                                        <i data-lucide="image" class="h-8 w-8"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-900">
                                        No banners yet
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Create your first homepage banner slide.
                                    </p>

                                    <a
                                        href="{{ route('admin.banners.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                    >
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                        Add Banner
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($banners->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $banners->links() }}
            </div>

        @endif

    </div>

@endsection
