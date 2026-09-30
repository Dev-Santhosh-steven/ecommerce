@extends('layouts.store')

@section('title', 'Yara Stand Alone Kiosk | Touchscreen Information Kiosk 32" 43" 55"')

@push('styles')
    <meta name="description" content="Yara stand alone touchscreen kiosks in 32, 43 and 55 inch: tilted-display kiosks for mall wayfinding, showroom catalogues, hotel & hospital check-in and corporate lobbies.">
    <style>
        /* Touch + swipe gesture over the kiosk screen (car carousel) */
        .sak-touch { position: absolute; left: 44%; top: 21%; width: 0; height: 0; pointer-events: none; animation: sak-swipe 3.6s cubic-bezier(.45,0,.2,1) infinite; }
        .sak-touch-dot { position: absolute; left: -14px; top: -14px; width: 28px; height: 28px; border-radius: 9999px; background: rgb(255 255 255 / .85); box-shadow: 0 0 0 6px rgb(255 255 255 / .25), 0 6px 18px rgb(0 0 0 / .35); animation: sak-press 3.6s ease-in-out infinite; }
        .sak-touch-ring { position: absolute; left: -26px; top: -26px; width: 52px; height: 52px; border-radius: 9999px; border: 2px solid rgb(232 190 96 / .9); animation: sak-ring 3.6s ease-out infinite; }
        .sak-touch-trail { position: absolute; right: 8px; top: -2px; height: 4px; width: 0; border-radius: 9999px; background: linear-gradient(90deg, transparent, rgb(232 190 96 / .9)); animation: sak-trail 3.6s cubic-bezier(.45,0,.2,1) infinite; }
        @keyframes sak-swipe { 0%, 12% { left: 58%; top: 22%; opacity: 0; } 20% { opacity: 1; left: 58%; top: 22%; } 58% { left: 38%; top: 20.5%; opacity: 1; } 66%, 100% { left: 38%; top: 20.5%; opacity: 0; } }
        @keyframes sak-press { 0%, 18% { transform: scale(1.3); } 24%, 56% { transform: scale(.85); } 64%, 100% { transform: scale(1.3); } }
        @keyframes sak-ring { 0%, 20% { transform: scale(.4); opacity: 0; } 24% { opacity: 1; } 44%, 100% { transform: scale(1.6); opacity: 0; } }
        @keyframes sak-trail { 0%, 22% { width: 0; } 58% { width: 140px; } 66%, 100% { width: 0; } }
        @media (prefers-reduced-motion: reduce) { .sak-touch, .sak-touch * { animation: none !important; } }
    </style>
@endpush

@php
    $base = fn ($file) => asset("storage/products/standalone-kiosk/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in your Stand Alone Kiosk. Please share details and pricing.');

    // Live screens: the kiosk running each kind of app (pre-rendered with perspective).
    $screens = [
        ['img' => $base('kiosk-white-car.png'), 'title' => 'Showroom experience', 'text' => 'Visitors swipe through the range and book a test drive on their own.', 'icon' => 'hand'],
        ['img' => $base('kiosk-silver-wayfinding.png'), 'title' => 'Wayfinding', 'text' => 'Store directory, live map and the route to walk.', 'icon' => 'map'],
        ['img' => $base('kiosk-white-catalogue.png'), 'title' => 'Product catalogue', 'text' => 'Your full range with photos, sizes and prices.', 'icon' => 'layout-grid'],
        ['img' => $base('kiosk-white-checkin.png'), 'title' => 'Self check-in', 'text' => 'Check-in, check-out and queue tokens in seconds.', 'icon' => 'badge-check'],
    ];

    // Orbit: offsets from the centre of the system map.
    $orbit = [
        ['x' => '0%', 'y' => '-46%', 'size' => 'h-16 w-16', 'type' => 'gold', 'code' => 'P-01', 'title' => 'Multi-touch', 'icon' => 'pointer'],
        ['x' => '40%', 'y' => '-22%', 'size' => 'h-12 w-12', 'type' => 'silver', 'code' => 'P-02', 'title' => 'Tilted display', 'icon' => 'monitor'],
        ['x' => '44%', 'y' => '24%', 'size' => 'h-14 w-14', 'type' => 'rock', 'code' => 'AST-01', 'title' => 'Metal body', 'icon' => 'shield-check'],
        ['x' => '0%', 'y' => '46%', 'size' => 'h-12 w-12', 'type' => 'black', 'code' => 'MOON-A', 'title' => 'Your software', 'icon' => 'settings-2'],
        ['x' => '-44%', 'y' => '24%', 'size' => 'h-16 w-16', 'type' => 'gold', 'code' => 'P-03', 'title' => 'Wayfinding', 'icon' => 'map'],
        ['x' => '-40%', 'y' => '-22%', 'size' => 'h-12 w-12', 'type' => 'silver', 'code' => 'P-04', 'title' => 'Catalogues', 'icon' => 'layout-grid'],
    ];

    $sizeRenders = [32 => 'kiosk-white-checkin.png', 43 => 'kiosk-silver-wayfinding.png', 55 => 'kiosk-white-catalogue.png'];
    $sizeWidths = [32 => 'w-[70%]', 43 => 'w-[84%]', 55 => 'w-[98%]'];
    $idealFor = [32 => 'Check-in desks, queue tokens & help points', 43 => 'Mall wayfinding, directories & info points', 55 => 'Showroom catalogues, experience centres & lobbies'];

    $posters = [
        ['img' => $base('poster-showroom.jpg'), 'place' => 'Showrooms'],
        ['img' => $base('poster-mall.jpg'), 'place' => 'Shopping malls'],
        ['img' => $base('poster-hotel.jpg'), 'place' => 'Hotels & hospitals'],
        ['img' => $base('poster-lobby.jpg'), 'place' => 'Corporate lobbies'],
    ];

    $specs = $products->first()->specifications ?? [];
    $specs['Screen Size'] = $products->map(fn ($p) => preg_replace('/\D/', '', $p->sku) . '"')->join(' · ');
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0b0a0a] text-white">

{{-- =========================================================
     HERO — showroom: glowing ceiling, reflective floor, vertical gold wordmark
========================================================= --}}
<section class="sak-room relative overflow-hidden">

    <div class="sak-ceiling" aria-hidden="true">
        <div class="sak-ceiling-plane">
            @for ($i = 0; $i < 18; $i++)
                <span class="sak-light"></span>
            @endfor
        </div>
    </div>
    <div class="sak-floor" aria-hidden="true"></div>

    <div class="relative mx-auto grid min-h-[38rem] max-w-[1500px] items-end gap-6 px-4 pb-10 pt-32 sm:px-6 lg:grid-cols-[1fr_1.25fr_auto] lg:px-10 lg:pt-24">

        <div class="about-intro pb-6 text-center lg:pb-24 lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-[#e8be60]/30 bg-black/30 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-[#f1d48f] backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Commercial Display Solutions
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-7xl">
                Stand Alone <span class="sak-gold">Kiosk</span>
            </h1>
            <p class="mx-auto mt-5 max-w-md text-lg text-gray-300 lg:mx-0">
                Touch. Find. Explore. A tilted touchscreen that lets every visitor help themselves.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="#screens" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#f1d48f] to-[#c8963e] px-7 py-4 text-sm font-semibold text-[#1a1208] shadow-lg shadow-black/40 transition hover:brightness-110">
                    Explore the kiosk
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-2xl" data-reveal="zoom">
            <div class="absolute inset-x-[10%] bottom-[8%] h-1/2 rounded-full bg-[#e8be60]/15 blur-3xl"></div>
            <div class="relative">
                <img src="{{ $base('kiosk-white-car.png') }}" alt="Yara Stand Alone Kiosk showing a car showroom app" class="relative w-full">
                {{-- a finger touching and sliding the car carousel --}}
                <span class="sak-touch" aria-hidden="true">
                    <span class="sak-touch-trail"></span>
                    <span class="sak-touch-ring"></span>
                    <span class="sak-touch-dot"></span>
                </span>
            </div>
            <img src="{{ $base('kiosk-white-car.png') }}" alt="" aria-hidden="true" class="sak-reflect pointer-events-none absolute left-0 top-full w-full -translate-y-[3%]">
        </div>

        <div class="hidden items-center gap-5 self-stretch pb-24 lg:flex">
            <span class="h-full w-px bg-gradient-to-b from-transparent via-[#e8be60]/70 to-transparent"></span>
            <div class="flex flex-col items-center gap-6">
                <p class="sak-vertical sak-gold font-display text-2xl font-semibold uppercase">Stand Alone</p>
                <span class="h-px w-8 bg-[#e8be60]/60"></span>
                <p class="text-center text-[0.65rem] uppercase leading-5 tracking-[0.35em] text-gray-300">32"<br>43"<br>55"</p>
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0a0a]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Stand Alone Kiosk</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">32" · 43" · 55" · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#screens" class="transition hover:text-white">Live screens</a>
            <a href="#system" class="transition hover:text-white">Features</a>
            <a href="#sizes" class="transition hover:text-white">Sizes</a>
            <a href="#places" class="transition hover:text-white">Where to use</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     LIVE SCREENS
========================================================= --}}
<section id="screens" class="relative scroll-mt-32 overflow-hidden bg-white py-24 text-gray-900"
         x-data="{ i: 0, n: {{ count($screens) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 4200) }, pick(k) { this.i = k; this.start() } }"
         x-init="start()">

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Live screens</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">One kiosk. <span class="text-brand-600">Any app you need.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Wayfinding, catalogues, check-in or your own software, all on one sleek touchscreen.</p>
        </div>

        <div class="mt-12 grid items-center gap-10 lg:grid-cols-5">

            <div class="lg:order-2 lg:col-span-2" data-reveal="right">
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                    @foreach ($screens as $k => $item)
                        <button type="button" @click="pick({{ $k }})"
                                class="relative flex items-start gap-4 overflow-hidden rounded-2xl border p-4 text-left transition duration-300"
                                :class="i === {{ $k }} ? 'border-brand-200 bg-brand-50 shadow-sm' : 'border-gray-200 hover:bg-gray-50'">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition" :class="i === {{ $k }} ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-500'">
                                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>
                            </span>
                            <span>
                                <span class="block font-semibold">{{ $item['title'] }}</span>
                                <span class="mt-0.5 block text-sm text-gray-500">{{ $item['text'] }}</span>
                            </span>
                            <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-brand-red" :class="i === {{ $k }} ? 'centum-thumb-progress [animation-duration:4.2s]' : 'scale-x-0'"></span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-center lg:order-1 lg:col-span-3" data-reveal="left">
                <div class="relative w-full max-w-xl">
                    <div class="absolute inset-8 rounded-full bg-brand-500/10 blur-3xl"></div>
                    <div class="absolute bottom-1 left-1/2 h-5 w-3/5 -translate-x-1/2 rounded-[50%] bg-black/15 blur-md"></div>
                    <div class="relative grid">
                        @foreach ($screens as $k => $item)
                            <img src="{{ $item['img'] }}" alt="{{ $item['title'] }} on the Yara Stand Alone Kiosk" loading="lazy"
                                 class="col-start-1 row-start-1 w-full self-end transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                 :class="i === {{ $k }} ? 'opacity-100 scale-100' : 'pointer-events-none opacity-0 scale-[0.98]'"
                                 @if ($k > 0) style="opacity: 0" @endif :style="''">
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     SYSTEM MAP — features orbiting the kiosk
========================================================= --}}
<section id="system" class="sak-space relative scroll-mt-32 overflow-hidden py-24">

    <div class="sak-lines" aria-hidden="true"></div>
    <div class="sak-stars" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-xs font-semibold uppercase tracking-[0.5em] text-[#e8be60]">System map</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Everything <span class="sak-gold">revolves around touch.</span></h2>
        </div>

        {{-- Orbit (tablet & desktop) --}}
        <div class="mt-10 hidden md:block" data-reveal="zoom">
            <div class="sak-orbit">
                <div class="sak-ring sak-ring--3"></div>
                <div class="sak-ring"></div>
                <div class="sak-ring sak-ring--2"></div>

                <div class="absolute left-1/2 top-1/2 w-[46%] -translate-x-1/2 -translate-y-1/2">
                    <div class="absolute inset-0 rounded-full bg-[#e8be60]/20 blur-3xl"></div>
                    <img src="{{ $base('kiosk-silver-catalogue.png') }}" alt="Yara Stand Alone Kiosk" loading="lazy" class="relative w-full">
                </div>

                @foreach ($orbit as $k => $node)
                    <div class="sak-node" style="--x: {{ $node['x'] }}; --y: {{ $node['y'] }}; --d: -{{ $k * 0.9 }}s">
                        <div class="flex items-center gap-3 {{ str_starts_with($node['x'], '-') ? 'flex-row-reverse text-right' : '' }}">
                            <span class="sak-planet sak-planet--{{ $node['type'] }} flex {{ $node['size'] }} shrink-0 items-center justify-center">
                                <i data-lucide="{{ $node['icon'] }}" class="h-5 w-5 {{ $node['type'] === 'black' || $node['type'] === 'rock' ? 'text-white' : 'text-[#1a1208]' }}"></i>
                            </span>
                            <span>
                                <span class="block text-[0.65rem] font-semibold tracking-[0.3em] text-[#e8be60]">{{ $node['code'] }}</span>
                                <span class="block whitespace-nowrap text-sm font-semibold">{{ $node['title'] }}</span>
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Features (all widths; detail cards) --}}
        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products->first()->features as $i => $feature)
                <div class="group rounded-3xl border border-white/10 bg-white/[0.03] p-6 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-[#e8be60]/40"
                     data-reveal style="--reveal-delay: {{ $i * 80 }}ms">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#f1d48f] to-[#b8862f] text-[#1a1208] shadow-lg shadow-black/40 transition group-hover:-rotate-6">
                        <i data-lucide="{{ $feature->icon }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ preg_replace('/^\d+" /', '', $feature->title) }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-400">{{ $feature->description }}</p>
                </div>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     CAPSULE — the kiosk in a glass capsule
========================================================= --}}
<section class="relative overflow-hidden bg-gradient-to-b from-[#e9eaed] to-[#cfd1d6] py-24 text-gray-900">
    <div class="mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div data-reveal="left">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">All in one</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Your front desk, <span class="text-brand-600">in one capsule.</span></h2>
            <p class="mt-5 max-w-lg text-lg text-gray-600">Screen, computer, touch and software in a single floor-standing unit. Plug it in, and it's ready to greet visitors all day.</p>
            <ul class="mt-8 grid max-w-lg gap-3 sm:grid-cols-2">
                @foreach (['Plug & play setup', 'Runs all day', 'Remote content updates', 'Wheelchair-friendly height'] as $point)
                    <li class="flex items-center gap-3 rounded-2xl bg-white/70 px-4 py-3 text-sm font-medium shadow-sm">
                        <i data-lucide="check" class="h-4 w-4 text-brand-600"></i>
                        {{ $point }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="px-2 sm:px-8" data-reveal="right">
            <div class="sak-capsule">
                <div class="sak-capsule-shell flex flex-col justify-center py-10 pl-10 pr-4 sm:pl-14">
                    <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-6 w-auto self-start sm:h-8">
                    <p class="sak-gold mt-3 font-display text-lg font-semibold uppercase tracking-[0.3em] sm:text-2xl">Kiosk</p>
                    <p class="mt-1 text-[0.65rem] uppercase tracking-[0.3em] text-white/70 sm:text-xs">32" · 43" · 55"</p>
                </div>
                <div class="sak-capsule-glass flex items-center justify-center p-4 pr-8">
                    <img src="{{ $base('kiosk-white-wayfinding.png') }}" alt="Yara Stand Alone Kiosk" loading="lazy" class="relative w-[78%] rotate-[8deg]">
                </div>
            </div>
            <div class="sak-capsule-shadow mx-auto mt-10 w-3/4"></div>
        </div>

    </div>
</section>


{{-- =========================================================
     SIZES — products come after the explore content
========================================================= --}}
<section id="sizes" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="about-blob -right-24 top-10 h-96 w-96 bg-[#6b4b12]/60"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#e8be60]">Choose your size</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Three sizes. <span class="sak-gold">One standard.</span></h2>
        </div>

        <div class="mt-14 grid items-end gap-6 md:grid-cols-3">
            @foreach ($products as $i => $product)
                @php $inch = (int) preg_replace('/\D/', '', $product->sku); @endphp

                <article class="group flex flex-col rounded-[2rem] border border-white/10 bg-white/[0.03] p-6 transition duration-500 hover:-translate-y-2 hover:border-[#e8be60]/40 hover:bg-white/[0.06] sm:p-8"
                         data-reveal style="--reveal-delay: {{ $i * 140 }}ms">

                    <div class="relative flex h-[20rem] items-end justify-center">
                        <div class="absolute bottom-1 h-4 w-40 rounded-[50%] bg-black/60 blur-md"></div>
                        <img src="{{ $base($sizeRenders[$inch] ?? 'kiosk-white-catalogue.png') }}" alt="Yara {{ $inch }} inch Stand Alone Kiosk" loading="lazy"
                             class="relative {{ $sizeWidths[$inch] ?? 'w-[84%]' }} transition duration-700 group-hover:-translate-y-1 group-hover:scale-[1.03]">
                    </div>

                    <div class="mt-8 flex items-end justify-between gap-4">
                        <div>
                            <p class="font-display text-5xl font-extrabold">{{ $inch }}<span class="text-[#e8be60]">"</span></p>
                            <p class="mt-1 text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">Stand Alone Kiosk</p>
                        </div>
                        <span class="rounded-full border border-white/15 px-3 py-1 text-xs text-gray-300">Price on request</span>
                    </div>

                    <p class="mt-4 text-sm leading-6 text-gray-400">{{ $idealFor[$inch] ?? $product->short_description }}</p>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('store.product', $product) }}" class="flex-1 rounded-full bg-white px-5 py-3 text-center text-sm font-semibold text-gray-900 transition hover:bg-[#e8be60]">
                            View details
                        </a>
                        <a href="{{ $wa("Hi Yara, I am interested in the {$inch}\" Stand Alone Kiosk. Please share the price.") }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 transition hover:border-brand-500 hover:bg-brand-600" aria-label="Enquire about the {{ $inch }} inch Stand Alone Kiosk on WhatsApp">
                            <i data-lucide="message-circle" class="h-5 w-5"></i>
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     WHERE TO USE
========================================================= --}}
<section id="places" class="relative scroll-mt-32 overflow-hidden pb-24">

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#e8be60]">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Wherever visitors <span class="sak-gold">need answers.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Showrooms, malls, hotels, hospitals and corporate lobbies: a helpful touchscreen that never takes a break.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($posters as $i => $poster)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $poster['img'] }}" alt="Yara Stand Alone Kiosk in {{ strtolower($poster['place']) }}" loading="lazy"
                         class="aspect-[4/5] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                </figure>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach ([
                ['store', 'Retail & showrooms'], ['map-pin', 'Malls & airports'], ['hotel', 'Hotels & check-in'],
                ['hospital', 'Hospitals & clinics'], ['building', 'Corporate lobbies'], ['graduation-cap', 'Campuses & museums'],
            ] as [$icon, $label])
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-[#e8be60]"></i>
                    {{ $label }}
                </span>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     SPECS
========================================================= --}}
<section id="specs" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Specifications</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Yara Stand Alone Kiosk</h2>
        </div>

        <dl class="mt-12 grid gap-x-12 sm:grid-cols-2" data-reveal>
            @foreach ($specs as $key => $value)
                <div class="flex items-baseline justify-between gap-6 border-b border-gray-200 py-4">
                    <dt class="text-sm text-gray-500">{{ $key }}</dt>
                    <dd class="text-right font-semibold">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>

    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="sak-room relative overflow-hidden py-28 text-center">

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Let visitors <span class="sak-gold">help themselves.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us where the kiosk will stand and what it should do. We'll set it up with your software and content.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#f1d48f] to-[#c8963e] px-7 py-4 text-sm font-semibold text-[#1a1208] shadow-lg shadow-black/40 transition hover:brightness-110">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="#sizes" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                Choose your size
                <i data-lucide="arrow-up" class="h-4 w-4"></i>
            </a>
        </div>
    </div>

</section>

</div>

@endsection
