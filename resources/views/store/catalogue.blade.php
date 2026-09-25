@extends('layouts.store')

@section('title', 'Catalogue | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Catalogue</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Catalogue
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            Browse and download our latest product catalogues &mdash; TVs, ACs, washing machines,
            and more, all in one place.
        </p>

    </div>

</section>


{{-- =========================================================
     CATALOGUE GRID
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        @if ($catalogues->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 py-20 text-center text-gray-500">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                    <i data-lucide="file-text" class="h-7 w-7"></i>
                </div>

                <h3 class="mt-4 font-semibold text-gray-900">No catalogues available yet</h3>
                <p class="mt-1 text-sm text-gray-500">Please check back soon.</p>

            </div>

        @else

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($catalogues as $catalogue)

                    <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        {{-- Cover --}}
                        <div class="relative flex aspect-[3/4] items-center justify-center overflow-hidden bg-gradient-to-br from-gray-900 to-gray-700">

                            <i data-lucide="file-text" class="h-16 w-16 text-white/25"></i>

                            <span class="absolute right-3 top-3 rounded-full bg-white/10 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider text-white backdrop-blur">
                                PDF
                            </span>

                            {{-- Hover overlay --}}
                            <div class="absolute inset-0 flex items-center justify-center gap-3 bg-gray-950/70 opacity-0 backdrop-blur-sm transition duration-300 group-hover:opacity-100">

                                <a
                                    href="{{ asset('storage/' . $catalogue->file) }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex h-11 w-11 -translate-y-2 items-center justify-center rounded-full bg-white text-gray-950 opacity-0 shadow-lg transition duration-300 delay-75 hover:bg-gray-100 group-hover:translate-y-0 group-hover:opacity-100"
                                    title="View catalogue"
                                >
                                    <i data-lucide="eye" class="h-5 w-5"></i>
                                </a>

                                <a
                                    href="{{ asset('storage/' . $catalogue->file) }}"
                                    download
                                    class="flex h-11 w-11 -translate-y-2 items-center justify-center rounded-full bg-white text-gray-950 opacity-0 shadow-lg transition duration-300 delay-150 hover:bg-gray-100 group-hover:translate-y-0 group-hover:opacity-100"
                                    title="Download catalogue"
                                >
                                    <i data-lucide="download" class="h-5 w-5"></i>
                                </a>

                            </div>

                        </div>

                        {{-- Title --}}
                        <div class="p-4">
                            <h3 class="line-clamp-2 text-sm font-semibold text-gray-900">
                                {{ $catalogue->title }}
                            </h3>
                        </div>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection
