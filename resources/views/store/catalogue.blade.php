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
<section class="bg-gray-50 py-14">

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

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                @foreach ($catalogues as $i => $catalogue)

                    <article data-reveal style="--reveal-delay: {{ ($i % 4) * 90 }}ms"
                             class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1.5 hover:border-brand-200 hover:shadow-2xl">

                        {{-- Cover --}}
                        <a href="{{ asset('storage/' . $catalogue->file) }}" target="_blank" rel="noopener noreferrer"
                           class="relative block aspect-[3/4] overflow-hidden bg-gradient-to-br from-gray-900 to-gray-700" title="View {{ $catalogue->title }}">

                            @if ($catalogue->coverUrl())
                                <img src="{{ $catalogue->coverUrl() }}" alt="{{ $catalogue->title }}" loading="lazy"
                                     class="h-full w-full object-cover object-top transition duration-700 group-hover:scale-105">
                            @else
                                <span class="flex h-full w-full items-center justify-center">
                                    <i data-lucide="file-text" class="h-16 w-16 text-white/25"></i>
                                </span>
                            @endif

                            <span class="absolute right-3 top-3 rounded-full bg-gray-950/70 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wider text-white backdrop-blur">PDF</span>

                            <span class="absolute inset-x-0 bottom-0 flex translate-y-full items-center justify-center gap-2 bg-gradient-to-t from-gray-950/90 to-transparent pb-5 pt-12 text-sm font-semibold text-white transition duration-300 group-hover:translate-y-0">
                                <i data-lucide="eye" class="h-4 w-4"></i>
                                Open catalogue
                            </span>

                        </a>

                        {{-- Title + actions (always visible, also on phones) --}}
                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="line-clamp-2 font-semibold leading-snug text-gray-900">{{ $catalogue->title }}</h3>
                            @if ($catalogue->sizeLabel())
                                <p class="mt-1 text-xs text-gray-400">{{ $catalogue->sizeLabel() }}</p>
                            @endif

                            <div class="mt-auto flex gap-2 pt-4">
                                <a href="{{ asset('storage/' . $catalogue->file) }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-full border border-gray-200 px-3 py-2 text-sm font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50">
                                    <i data-lucide="eye" class="h-4 w-4"></i> View
                                </a>
                                <a href="{{ asset('storage/' . $catalogue->file) }}" download
                                   class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-full bg-brand-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
                                    <i data-lucide="download" class="h-4 w-4"></i> Download
                                </a>
                            </div>
                        </div>

                    </article>

                @endforeach

            </div>

        @endif

    </div>

</section>

@endsection
