@extends('layouts.store')

@section('title', 'Certifications | Yara Electronics')

@push('styles')
    <meta name="description" content="Yara Electronics certifications and registrations: BIS, ISO 9001, ISO 14001, ISO 27001, BEE, CE, RoHS and more. View and download our certificates.">
@endpush

@php
    $wa = fn ($title) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode("Hi Yara, please share a copy of your {$title}.");
    $downloadable = $certifications->filter->hasFile()->count();
@endphp

@section('content')

{{-- =========================================================
     HERO
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="about-grid absolute inset-0 opacity-40"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.3fr_1fr] lg:px-8">

        <div class="about-intro">
            <nav class="mb-3 text-sm text-gray-300">
                <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">Certifications</span>
            </nav>
            <h1 class="text-4xl font-bold tracking-tight sm:text-6xl">Certified. <span class="about-gradient-text">Verified.</span></h1>
            <p class="mt-5 max-w-xl text-lg text-gray-300">
                Quality, safety and compliance are built into how we design, manufacture and deliver every Yara product.
                View and download our certificates below.
            </p>
            <div class="mt-8 flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold backdrop-blur">
                    <i data-lucide="award" class="h-4 w-4 text-brand-300"></i>
                    {{ $certifications->count() }} certifications &amp; registrations
                </span>
                @if ($downloadable)
                    <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold backdrop-blur">
                        <i data-lucide="download" class="h-4 w-4 text-brand-300"></i>
                        {{ $downloadable }} ready to download
                    </span>
                @endif
            </div>
        </div>

        {{-- Floating stack of marks --}}
        <div class="relative mx-auto hidden h-72 w-full max-w-sm lg:block" aria-hidden="true">
            @foreach ($certifications->filter->logoUrl()->take(5)->values() as $i => $c)
                <span class="cert-float absolute flex h-24 w-24 items-center justify-center rounded-3xl bg-white p-3 shadow-2xl shadow-black/40"
                      style="left: {{ [8, 58, 30, 70, 0][$i] }}%; top: {{ [6, 0, 38, 52, 62][$i] }}%; --float-delay: -{{ $i * 1.3 }}s; --float-tilt: {{ [-6, 5, -3, 7, 4][$i] }}deg">
                    <img src="{{ $c->logoUrl() }}" alt="" class="max-h-full max-w-full object-contain">
                </span>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     CERTIFICATES
========================================================= --}}
<section class="bg-gray-50 py-16" x-data="{ view: null }">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($certifications as $i => $c)

                <article data-reveal style="--reveal-delay: {{ ($i % 3) * 110 }}ms"
                         class="about-shine group flex flex-col overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:ring-brand-200">

                    <div class="relative flex h-40 items-center justify-center bg-gradient-to-b from-gray-50 to-white">
                        @if ($c->logoUrl())
                            <img src="{{ $c->logoUrl() }}" alt="{{ $c->title }}" loading="lazy" class="max-h-24 max-w-[60%] object-contain transition duration-500 group-hover:scale-110">
                        @else
                            <span class="flex h-24 w-24 items-center justify-center rounded-full border-2 border-dashed border-brand-200 transition duration-700 group-hover:rotate-[360deg] group-hover:border-brand-600">
                                <span class="flex h-20 w-20 flex-col items-center justify-center rounded-full bg-gradient-to-br from-gray-950 to-brand-800 text-white">
                                    <i data-lucide="{{ $c->icon ?: 'award' }}" class="h-6 w-6"></i>
                                    <span class="mt-0.5 font-display text-[10px] font-bold">{{ $c->code }}</span>
                                </span>
                            </span>
                        @endif

                        @if ($c->hasFile())
                            <span class="absolute right-4 top-4 inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 ring-1 ring-emerald-100">
                                <i data-lucide="file-check" class="h-3.5 w-3.5"></i> Available
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-1 flex-col p-6">
                        @if ($c->code)
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">{{ $c->code }}</p>
                        @endif
                        <h2 class="mt-1 text-lg font-bold leading-snug text-gray-900">{{ $c->title }}</h2>
                        @if ($c->issuer)
                            <p class="mt-1 text-sm text-gray-500">{{ $c->issuer }}</p>
                        @endif
                        @if ($c->description)
                            <p class="mt-3 text-sm leading-6 text-gray-600">{{ $c->description }}</p>
                        @endif

                        <div class="mt-auto flex flex-wrap items-center gap-2 pt-6">
                            @if ($c->hasFile())
                                <a href="{{ route('store.certifications.download', $c) }}"
                                   class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                                    <i data-lucide="download" class="h-4 w-4"></i>
                                    Download
                                </a>
                                <button type="button" @click="view = {{ $i }}"
                                        class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-gray-300 hover:bg-gray-50">
                                    <i data-lucide="eye" class="h-4 w-4"></i>
                                    View
                                </button>
                                <span class="text-xs text-gray-400">{{ $c->fileLabel() }}</span>
                            @else
                                <a href="{{ $wa($c->title) }}" target="_blank" rel="noopener noreferrer"
                                   class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-brand-200 hover:text-brand-700">
                                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                                    Request a copy
                                </a>
                            @endif
                        </div>
                    </div>

                </article>

            @endforeach

        </div>

        <p class="mt-10 text-center text-sm text-gray-500">
            Certificates are issued to Ceezet Electronics Private Limited, the company that manufactures Yara products.
        </p>

    </div>

    {{-- Viewer --}}
    <div x-show="view !== null" x-cloak x-transition.opacity @keydown.escape.window="view = null"
         class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-950/90 p-4 backdrop-blur-sm" @click.self="view = null">
        @foreach ($certifications as $i => $c)
            @if ($c->hasFile())
                <figure x-show="view === {{ $i }}" class="flex h-[85vh] w-full max-w-4xl flex-col overflow-hidden rounded-3xl bg-white shadow-2xl">
                    <figcaption class="flex items-center justify-between gap-4 border-b border-gray-100 px-6 py-4">
                        <span class="font-bold text-gray-900">{{ $c->title }}</span>
                        <span class="flex items-center gap-2">
                            <a href="{{ route('store.certifications.download', $c) }}" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                                <i data-lucide="download" class="h-4 w-4"></i> Download
                            </a>
                            <button type="button" @click="view = null" class="rounded-full p-2 text-gray-500 hover:bg-gray-100" aria-label="Close">
                                <i data-lucide="x" class="h-5 w-5"></i>
                            </button>
                        </span>
                    </figcaption>
                    <template x-if="view === {{ $i }}">
                        @if ($c->fileIsImage())
                            <div class="flex flex-1 items-center justify-center overflow-auto bg-gray-50 p-6">
                                <img src="{{ asset('storage/' . $c->file) }}" alt="{{ $c->title }}" class="max-h-full max-w-full object-contain">
                            </div>
                        @else
                            <iframe src="{{ asset('storage/' . $c->file) }}#view=FitH" class="w-full flex-1" title="{{ $c->title }}"></iframe>
                        @endif
                    </template>
                </figure>
            @endif
        @endforeach
    </div>

</section>

@endsection
