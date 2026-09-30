@extends('layouts.store')

@section('title', 'Yara T-Standees | Digital Signage Standees 55" 65" 75"')

@push('styles')
    <meta name="description" content="Yara T-Standee digital signage in 55, 65 and 75 inch: eye-catching portrait displays for malls, fashion stores, automobile showrooms and hotel lobbies.">
@endpush

@php
    $base = fn ($file) => asset("storage/products/t-standees/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in your T-Standee digital signage. Please share details and pricing.');

    // Live demo: what the standee plays, and where.
    $demo = [
        ['img' => $base('screen-sale.jpg'), 'place' => 'Retail & malls', 'text' => 'Flash sales and offers that stop shoppers mid-stride.', 'icon' => 'shopping-bag'],
        ['img' => $base('screen-fashion.jpg'), 'place' => 'Fashion stores', 'text' => 'New collections, lookbooks and in-store campaigns.', 'icon' => 'shirt'],
        ['img' => $base('screen-bike-red.jpg'), 'place' => 'Bike showrooms', 'text' => 'Every model in stunning, full-height detail.', 'icon' => 'bike'],
        ['img' => $base('screen-car.jpg'), 'place' => 'Car showrooms', 'text' => 'Launch videos and variants beside the real car.', 'icon' => 'car'],
        ['img' => $base('screen-lake.jpg'), 'place' => 'Hotels & lobbies', 'text' => 'Welcome screens, wayfinding and event schedules.', 'icon' => 'hotel'],
        ['img' => $base('screen-fashion-red.jpg'), 'place' => 'Brand launches', 'text' => 'Bold visuals for exhibitions and pop-up events.', 'icon' => 'sparkles'],
    ];

    $sizeScreens = [55 => 'screen-fashion.jpg', 65 => 'screen-sale.jpg', 75 => 'screen-car.jpg'];
    $sizeWidths = [55 => 'w-[8.5rem]', 65 => 'w-[10rem]', 75 => 'w-[11.5rem]'];
    $idealFor = [55 => 'Store entrances, boutiques & receptions', 65 => 'Malls, supermarkets & showroom floors', 75 => 'Large showrooms, atriums & big venues'];

    $posters = [
        ['img' => $base('poster-mall.jpg'), 'place' => 'Shopping Malls'],
        ['img' => $base('poster-fashion.jpg'), 'place' => 'Fashion Stores'],
        ['img' => $base('poster-auto.jpg'), 'place' => 'Automobile Showrooms'],
        ['img' => $base('poster-lobby.jpg'), 'place' => 'Hotels & Lobbies'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0b0a0a] text-white">

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative overflow-hidden pb-16 pt-14 sm:pt-20">

    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob -left-32 top-24 h-[30rem] w-[30rem] bg-brand-800"></div>
    <div class="about-blob -right-24 top-10 h-[24rem] w-[24rem] bg-brand-red/40 [animation-delay:-6s]"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="about-intro text-center">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Commercial Display Solutions
            </p>
            <h1 class="mt-5 text-5xl font-bold sm:text-7xl">
                Yara <span class="about-gradient-text">T-Standees</span>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300 sm:text-xl">
                Digital signage that stands out. Portrait displays in 55", 65" and 75" for every shop floor, showroom and lobby.
            </p>
        </div>

        <div class="relative mx-auto mt-4 max-w-5xl">
            <div class="centum-ambient"></div>
            <img src="{{ $base('t-standee-trio.png') }}" alt="Yara T-Standees in 55, 65 and 75 inch" class="centum-hero-tv relative w-full">
            <img src="{{ $base('t-standee-trio.png') }}" alt="" aria-hidden="true" class="chill-reflection relative -mt-2 w-full">
        </div>

        <div class="-mt-[8%] flex flex-wrap justify-center gap-4" data-reveal>
            <a href="#sizes" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                Choose your size
                <i data-lucide="arrow-down" class="h-4 w-4"></i>
            </a>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire now
            </a>
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0a0a]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara T-Standees</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">55" · 65" · 75" · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#sizes" class="transition hover:text-white">Sizes</a>
            <a href="#demo" class="transition hover:text-white">Live demo</a>
            <a href="#places" class="transition hover:text-white">Where to use</a>
            <a href="#touch" class="transition hover:text-white">Touch options</a>
            <a href="#features" class="transition hover:text-white">Features</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     SIZES — the three products
========================================================= --}}
<section id="sizes" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Choose your size</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Three sizes. <span class="about-gradient-text">One standout.</span></h2>
        </div>

        <div class="mt-14 grid items-end gap-6 md:grid-cols-3">
            @foreach ($products as $i => $product)
                @php $inch = (int) preg_replace('/\D/', '', $product->sku); @endphp

                <article class="group flex flex-col rounded-[2rem] border border-white/10 bg-white/[0.03] p-6 transition duration-500 hover:-translate-y-2 hover:border-brand-500/40 hover:bg-white/[0.06] sm:p-8"
                         data-reveal style="--reveal-delay: {{ $i * 140 }}ms">

                    <div class="flex h-[31rem] items-end justify-center">
                        <x-t-standee class="{{ $sizeWidths[$inch] ?? 'w-[70%]' }} transition duration-700 group-hover:scale-[1.03]">
                            <img src="{{ $base($sizeScreens[$inch] ?? 'screen-sale.jpg') }}" alt="" loading="lazy" class="h-full w-full object-cover">
                        </x-t-standee>
                    </div>

                    <div class="mt-8 flex items-end justify-between gap-4">
                        <div>
                            <p class="font-display text-5xl font-extrabold">{{ $inch }}<span class="text-brand-500">"</span></p>
                            <p class="mt-1 text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">T-Standee</p>
                        </div>
                        <span class="rounded-full border border-white/15 px-3 py-1 text-xs text-gray-300">Price on request</span>
                    </div>

                    <p class="mt-4 text-sm leading-6 text-gray-400">{{ $idealFor[$inch] ?? $product->short_description }}</p>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('store.product', $product) }}" class="flex-1 rounded-full bg-white px-5 py-3 text-center text-sm font-semibold text-gray-900 transition hover:bg-brand-600 hover:text-white">
                            View details
                        </a>
                        <a href="{{ $wa("Hi Yara, I am interested in the {$inch}\" T-Standee. Please share the price.") }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 transition hover:border-brand-500 hover:bg-brand-600" aria-label="Enquire about the {{ $inch }} inch T-Standee on WhatsApp">
                            <i data-lucide="message-circle" class="h-5 w-5"></i>
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     LIVE DEMO — the standee plays different content per business
========================================================= --}}
<section id="demo" class="relative scroll-mt-32 overflow-hidden bg-white py-24 text-gray-900"
         x-data="{ i: 0, n: {{ count($demo) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 3800) }, pick(k) { this.i = k; this.start() } }"
         x-init="start()">

    <div class="mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div class="order-2 lg:order-1" data-reveal="left">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Live demo</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">One standee. <span class="text-brand-600">Every business.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Tap a business to see what a Yara T-Standee can do for it.</p>

            <div class="mt-8 space-y-3">
                @foreach ($demo as $k => $item)
                    <button type="button" @click="pick({{ $k }})"
                            class="group relative flex w-full items-center gap-4 overflow-hidden rounded-2xl border p-4 text-left transition duration-300"
                            :class="i === {{ $k }} ? 'border-brand-200 bg-brand-50 shadow-lg' : 'border-gray-200 hover:border-gray-300'">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition"
                              :class="i === {{ $k }} ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-600'">
                            <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>
                        </span>
                        <span class="min-w-0">
                            <span class="block font-bold">{{ $item['place'] }}</span>
                            <span class="block truncate text-sm text-gray-500">{{ $item['text'] }}</span>
                        </span>
                        <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-brand-600" :class="i === {{ $k }} ? 'centum-thumb-progress [animation-duration:3.8s]' : 'scale-x-0'"></span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="order-1 flex justify-center lg:order-2" data-reveal="right">
            <div class="relative w-[62%] max-w-[20rem]">
                <div class="absolute -inset-10 rounded-full bg-brand-500/15 blur-3xl"></div>
                <x-t-standee class="relative w-full">
                    <div class="centum-screen-content absolute inset-0">
                        @foreach ($demo as $k => $item)
                            <div class="centum-slide" :class="i === {{ $k }} ? 'is-active' : ''">
                                <img src="{{ $item['img'] }}" alt="{{ $item['place'] }} content on a Yara T-Standee" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </x-t-standee>
                <div class="mx-auto mt-3 h-4 w-[90%] rounded-[50%] bg-black/25 blur-md"></div>
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     WHERE TO PLACE — location posters
========================================================= --}}
<section id="places" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="about-blob -right-24 top-1/3 h-96 w-96 bg-brand-800"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Wherever people <span class="about-gradient-text">walk by.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">From mall atriums to showroom floors, a Yara T-Standee turns footfall into attention.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($posters as $i => $poster)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $poster['img'] }}" alt="Yara T-Standee in {{ strtolower($poster['place']) }}" loading="lazy"
                         class="aspect-[4/5] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                </figure>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach ([
                ['utensils', 'Restaurants & cafés'], ['hospital', 'Hospitals & clinics'], ['plane', 'Airports & stations'],
                ['graduation-cap', 'Colleges & campuses'], ['building', 'Corporate offices'], ['presentation', 'Exhibitions & events'],
            ] as [$icon, $label])
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-brand-400"></i>
                    {{ $label }}
                </span>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     TOUCH vs NON-TOUCH
========================================================= --}}
<section id="touch" class="scroll-mt-32 bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Touch options</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Touch or non-touch? <span class="text-brand-600">You choose.</span></h2>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @foreach ([
                ['icon' => 'pointer', 'title' => 'Touch T-Standee', 'tag' => 'Interactive', 'points' => ['Product catalogues & comparisons', 'Mall directories & wayfinding', 'Self-service menus & forms', 'Customer feedback & surveys']],
                ['icon' => 'play', 'title' => 'Non-Touch T-Standee', 'tag' => 'Digital poster', 'points' => ['Looping offers & promotions', 'Brand videos & launches', 'Welcome & event screens', 'Lower cost, zero upkeep']],
            ] as $i => $option)
                <div class="about-shine rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl" data-reveal style="--reveal-delay: {{ $i * 140 }}ms">
                    <div class="flex items-center justify-between">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-950 text-white"><i data-lucide="{{ $option['icon'] }}" class="h-7 w-7"></i></span>
                        <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">{{ $option['tag'] }}</span>
                    </div>
                    <h3 class="mt-6 text-2xl font-bold">{{ $option['title'] }}</h3>
                    <ul class="mt-5 space-y-3">
                        @foreach ($option['points'] as $point)
                            <li class="flex gap-3 text-gray-600"><i data-lucide="circle-check" class="mt-0.5 h-5 w-5 shrink-0 text-brand-600"></i>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

    </div>
</section>


{{-- =========================================================
     FEATURES
========================================================= --}}
<section id="features" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Features</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Built to <span class="text-brand-600">get noticed.</span></h2>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products->first()->features as $feature)
                <div class="group rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-brand-200">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red text-white shadow-lg shadow-brand-600/30 transition group-hover:-rotate-6">
                        <i data-lucide="{{ $feature->icon }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ $feature->title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $feature->description }}</p>
                </div>
            @endforeach
        </div>

    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative overflow-hidden py-28 text-center">

    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-brand-700"></div>

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Make every visitor <span class="about-gradient-text">look twice.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us where your standee will stand. We'll recommend the right size and set up your content.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                Book a live demo
            </a>
        </div>
    </div>

</section>

</div>

@endsection
