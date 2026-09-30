@extends('layouts.store')

@section('title', 'Yara Commercial Displays | 24/7 Digital Signage 32" to 86"')

@push('styles')
    <meta name="description" content="Yara commercial displays in 32, 43, 55, 65, 75 and 86 inch: slim 24/7 digital signage, up to 500 nits, landscape or portrait, with a built-in media player for retail, restaurants, lobbies and transit.">
@endpush

@php
    $base = fn ($file) => asset("storage/products/commercial-displays/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in your Commercial Displays (digital signage). Please share details and pricing.');

    // Hero: the angled display cycles through different kinds of content.
    $heroSlides = ['vivera', 'aurora', 'sale', 'lobby', 'menu', 'opening'];

    // Size cards: front render with each size's own content.
    $sizeContent = [32 => 'menu', 43 => 'sale', 55 => 'aurora', 65 => 'vivera', 75 => 'lobby', 86 => 'opening'];
    $idealFor = [
        32 => 'Counters, cafés & menu boards',
        43 => 'Retail promotions & shop windows',
        55 => 'Showrooms, brand stores & malls',
        65 => 'Lobbies, hotels & transit',
        75 => 'Corporate receptions & large stores',
        86 => 'Atriums, auditoriums & flagships',
    ];

    // Industries: angled render + copy.
    $industries = [
        ['key' => 'sale', 'label' => 'Retail', 'icon' => 'shopping-bag', 'title' => 'Turn footfall into sales', 'text' => 'Flash sales, new arrivals and offers that change by the hour, right where shoppers decide.'],
        ['key' => 'aurora', 'label' => 'Brands', 'icon' => 'gem', 'title' => 'Premium brand stories', 'text' => '4K visuals that do justice to watches, fashion, beauty and electronics.'],
        ['key' => 'menu', 'label' => 'Restaurants', 'icon' => 'utensils', 'title' => 'Menus that update themselves', 'text' => 'Switch breakfast to lunch automatically and change prices without reprinting.'],
        ['key' => 'lobby', 'label' => 'Corporate', 'icon' => 'building-2', 'title' => 'A smarter reception', 'text' => 'Welcome guests, show schedules, news and wayfinding in your lobby.'],
        ['key' => 'vivera', 'label' => 'FMCG', 'icon' => 'cup-soda', 'title' => 'Launch products loudly', 'text' => 'Eye-catching launches at the shelf, the counter and the store entrance.'],
        ['key' => 'opening', 'label' => 'Events', 'icon' => 'party-popper', 'title' => 'Announce what\'s next', 'text' => 'Openings, events and countdowns that pull people in.'],
    ];

    // Size visualiser (display dimensions from the 16:9 diagonal).
    $visualSizes = collect([32, 43, 55, 65, 75, 86])->map(fn ($d) => [
        'inch' => $d,
        'w' => round($d * 2.54 * 0.8716),
        'h' => round($d * 2.54 * 0.4903),
        'img' => $base('slide-' . $sizeContent[$d] . '.jpg'),
    ])->values();
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0b0a0a] text-white">

{{-- =========================================================
     HERO — angled display cycling through content
========================================================= --}}
<section class="relative overflow-hidden pb-10 pt-14 sm:pt-20"
         x-data="{ i: 0, n: {{ count($heroSlides) }}, init() { setInterval(() => this.i = (this.i + 1) % this.n, 3500) } }">

    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob -left-32 top-24 h-[30rem] w-[30rem] bg-brand-800"></div>
    <div class="about-blob -right-24 top-10 h-[24rem] w-[24rem] bg-brand-red/40 [animation-delay:-6s]"></div>

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-10 px-4 sm:px-6 lg:grid-cols-[1fr_1.35fr] lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Commercial Display Solutions
            </p>
            <h1 class="mt-5 text-5xl font-bold leading-[1.05] sm:text-7xl">
                Yara <span class="about-gradient-text">Commercial Displays</span>
            </h1>
            <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Slim digital signage that never sleeps. 24/7 displays in 32" to 86", in landscape or portrait, for every store, menu and lobby.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4 lg:justify-start">
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

        <div class="relative">
            <div class="centum-ambient"></div>
            <div class="centum-hero-tv relative grid" data-no-auto-reveal>
                @foreach ($heroSlides as $k => $key)
                    <img src="{{ $base("cd-angle-right-{$key}.png") }}" alt="Yara Commercial Display showing {{ $key }} content"
                         @if ($k > 0) loading="lazy" @endif
                         class="col-start-1 row-start-1 w-full transition-opacity duration-1000"
                         :class="i === {{ $k }} ? 'opacity-100' : 'opacity-0'"
                         @if ($k > 0) style="opacity: 0" @endif :style="''">
                @endforeach
            </div>

            {{-- Floating spec chips --}}
            @foreach ([
                ['clock', '24/7 rated', 'left-0 top-[8%]', '0s'],
                ['sun', 'Up to 500 nits', 'right-2 top-0', '-2s'],
                ['monitor', '4K UHD', 'left-[6%] bottom-[10%]', '-4s'],
                ['rotate-cw', 'Landscape · Portrait', 'right-[4%] bottom-[4%]', '-1s'],
            ] as [$icon, $label, $pos, $delay])
                <span class="cd-chip absolute {{ $pos }} hidden items-center gap-2 rounded-full border border-white/15 bg-black/50 px-4 py-2 text-xs font-semibold text-white shadow-xl backdrop-blur-md sm:inline-flex"
                      style="animation-delay: {{ $delay }}">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-brand-400"></i>
                    {{ $label }}
                </span>
            @endforeach
        </div>

    </div>

    {{-- Use-case ticker --}}
    <div class="relative mt-14 overflow-hidden border-y border-white/10 bg-white/[0.03] py-4 [mask-image:linear-gradient(90deg,transparent,black_10%,black_90%,transparent)]">
        <div class="about-marquee gap-10 pr-10 text-sm font-semibold uppercase tracking-[0.25em] text-gray-400">
            @foreach (range(1, 2) as $loopIndex)
                @foreach (['Retail stores', 'Restaurants & QSR', 'Corporate lobbies', 'Hotels', 'Malls', 'Showrooms', 'Clinics', 'Banks', 'Transit', 'Campuses'] as $place)
                    <span class="inline-flex items-center gap-10 whitespace-nowrap">{{ $place }} <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span></span>
                @endforeach
            @endforeach
        </div>
    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0a0a]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Commercial Displays</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">32" · 43" · 55" · 65" · 75" · 86" · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#sizes" class="transition hover:text-white">Sizes</a>
            <a href="#visualiser" class="transition hover:text-white">Size guide</a>
            <a href="#rotate" class="transition hover:text-white">Portrait</a>
            <a href="#industries" class="transition hover:text-white">Industries</a>
            <a href="#features" class="transition hover:text-white">Features</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     SIZES
========================================================= --}}
<section id="sizes" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Choose your size</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Six sizes. <span class="about-gradient-text">One clean look.</span></h2>
        </div>

        <div class="relative mx-auto mt-12 max-w-6xl" data-reveal="zoom">
            <div class="centum-ambient"></div>
            <img src="{{ $base('cd-range.png') }}" alt="Yara Commercial Displays from 32 to 86 inch" loading="lazy" class="relative w-full">
        </div>

        <div class="mt-16 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($products as $i => $product)
                @php $inch = (int) preg_replace('/\D/', '', $product->sku); @endphp

                <article class="about-shine group flex flex-col rounded-[2rem] border border-white/10 bg-white/[0.03] p-6 transition duration-500 hover:-translate-y-2 hover:border-brand-500/40 hover:bg-white/[0.06] sm:p-8"
                         data-reveal style="--reveal-delay: {{ ($i % 3) * 120 }}ms">

                    <div class="relative flex h-56 items-center justify-center">
                        <div class="absolute inset-x-10 bottom-2 h-6 rounded-[50%] bg-black/60 blur-lg"></div>
                        <img src="{{ $base('cd-front-' . ($sizeContent[$inch] ?? 'vivera') . '.png') }}" alt="Yara {{ $inch }} inch Commercial Display" loading="lazy"
                             class="relative transition duration-700 group-hover:-translate-y-1 group-hover:scale-[1.04]"
                             style="width: {{ 55 + ($inch - 32) * 0.8 }}%">
                    </div>

                    <div class="mt-6 flex items-end justify-between gap-4">
                        <div>
                            <p class="font-display text-5xl font-extrabold">{{ $inch }}<span class="text-brand-500">"</span></p>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">
                                {{ str($product->specifications['Resolution'] ?? '')->between('(', ')') }} · {{ $product->specifications['Brightness'] ?? '' }}
                            </p>
                        </div>
                        <span class="rounded-full border border-white/15 px-3 py-1 text-xs text-gray-300">Price on request</span>
                    </div>

                    <p class="mt-4 text-sm leading-6 text-gray-400">{{ $idealFor[$inch] ?? $product->short_description }}</p>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('store.product', $product) }}" class="flex-1 rounded-full bg-white px-5 py-3 text-center text-sm font-semibold text-gray-900 transition hover:bg-brand-600 hover:text-white">
                            View details
                        </a>
                        <a href="{{ $wa("Hi Yara, I am interested in the {$inch}\" Commercial Display. Please share the price.") }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 transition hover:border-brand-500 hover:bg-brand-600" aria-label="Enquire about the {{ $inch }} inch Commercial Display on WhatsApp">
                            <i data-lucide="message-circle" class="h-5 w-5"></i>
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     SIZE VISUALISER — the display next to a person, to scale
========================================================= --}}
<section id="visualiser" class="scroll-mt-32 bg-white py-24 text-gray-900"
         x-data="{ sizes: @js($visualSizes), k: 2, get s() { return this.sizes[this.k] } }">
    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-[1fr_1.5fr] lg:px-10">

        <div data-reveal="left">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Size guide</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">See it <span class="text-brand-600">to scale.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Pick a size to compare it with a person of 170 cm. Displays are shown mounted at eye level.</p>

            <div class="mt-8 flex flex-wrap gap-2">
                <template x-for="(size, idx) in sizes" :key="size.inch">
                    <button type="button" @click="k = idx"
                            class="rounded-full px-5 py-2.5 text-sm font-bold transition"
                            :class="k === idx ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
                            x-text="size.inch + '&quot;'"></button>
                </template>
            </div>

            <dl class="mt-8 grid grid-cols-2 gap-4">
                <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-200">
                    <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Screen width</dt>
                    <dd class="mt-1 font-display text-3xl font-extrabold"><span x-text="s.w"></span> <span class="text-base font-semibold text-gray-500">cm</span></dd>
                </div>
                <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-200">
                    <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Screen height</dt>
                    <dd class="mt-1 font-display text-3xl font-extrabold"><span x-text="s.h"></span> <span class="text-base font-semibold text-gray-500">cm</span></dd>
                </div>
            </dl>
        </div>

        {{-- Stage: 444 cm × 250 cm, floor at the bottom --}}
        <div class="relative aspect-[16/9] w-full overflow-hidden rounded-[2rem] bg-gradient-to-b from-[#f4f4f5] to-[#e7e7ea] ring-1 ring-gray-200" data-reveal="right">
            <div class="absolute inset-x-0 bottom-0 h-[6%] bg-gradient-to-b from-gray-300 to-gray-200"></div>

            {{-- person, 170 cm --}}
            <svg viewBox="0 0 60 170" class="absolute bottom-[6%] left-[8%] h-[68%] w-auto text-gray-400" fill="currentColor" aria-hidden="true">
                <circle cx="30" cy="12" r="10"/>
                <path d="M16 27h28a8 8 0 0 1 8 8v48a4 4 0 0 1-8 0V43h-2v122a5 5 0 0 1-10 0V103h-4v62a5 5 0 0 1-10 0V43h-2v40a4 4 0 0 1-8 0V35a8 8 0 0 1 8-8z"/>
            </svg>
            <span class="absolute bottom-[8%] left-[4%] text-[10px] font-semibold uppercase tracking-widest text-gray-400 [writing-mode:vertical-rl] rotate-180">170 cm</span>

            {{-- display, centre at 160 cm --}}
            <div class="cd-grow absolute left-[32%] flex flex-col overflow-hidden rounded-[3px] bg-[#131316] p-[0.45%] pb-[1.1%] shadow-2xl shadow-black/40"
                 :style="`width: ${s.w / 444 * 100}%; height: ${(s.h + 3) / 250 * 100}%; bottom: ${(6 + (160 - s.h / 2) / 250 * 94)}%`">
                <div class="cd-sweep relative min-h-0 flex-1 overflow-hidden bg-black">
                    <template x-for="(size, idx) in sizes" :key="'v' + size.inch">
                        <img :src="size.img" alt="" class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500" :class="k === idx ? 'opacity-100' : 'opacity-0'">
                    </template>
                </div>
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="" class="mx-auto mt-[0.4%] h-[3%] min-h-[5px] w-auto opacity-80">
            </div>

            <span class="absolute right-5 top-5 rounded-full bg-white/80 px-4 py-2 font-display text-2xl font-extrabold shadow-sm backdrop-blur" x-text="s.inch + '&quot;'"></span>
        </div>

    </div>
</section>


{{-- =========================================================
     LANDSCAPE ↔ PORTRAIT — the display turns on its mount
========================================================= --}}
<section id="rotate" class="relative scroll-mt-32 overflow-hidden py-24"
         x-data="{ portrait: false, t: null, auto() { clearInterval(this.t); this.t = setInterval(() => this.portrait = ! this.portrait, 4500) }, set(v) { this.portrait = v; this.auto() } }"
         x-init="auto()">

    <div class="about-blob -left-24 top-1/4 h-96 w-96 bg-brand-800"></div>

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-[1fr_1.3fr] lg:px-10">

        <div data-reveal="left">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Landscape or portrait</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Turn it. <span class="about-gradient-text">Tell it differently.</span></h2>
            <p class="mt-5 text-lg text-gray-300">Wide for menus and promotions, tall for posters and fashion. Every Yara Commercial Display is rated for both.</p>

            <div class="mt-8 inline-flex rounded-full border border-white/15 bg-white/5 p-1 text-sm font-semibold">
                <button type="button" @click="set(false)" class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 transition"
                        :class="! portrait ? 'bg-white text-gray-900' : 'text-gray-300 hover:text-white'" :aria-pressed="! portrait">
                    <i data-lucide="rectangle-horizontal" class="h-4 w-4"></i>
                    Landscape
                </button>
                <button type="button" @click="set(true)" class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 transition"
                        :class="portrait ? 'bg-white text-gray-900' : 'text-gray-300 hover:text-white'" :aria-pressed="portrait">
                    <i data-lucide="rectangle-vertical" class="h-4 w-4"></i>
                    Portrait
                </button>
            </div>

            <ul class="mt-8 space-y-3 text-gray-300">
                @foreach (['Rotates on standard VESA mounts', 'Content player detects the orientation', 'Portrait for posters, fashion & wayfinding'] as $point)
                    <li class="flex items-center gap-3">
                        <i data-lucide="circle-check" class="h-5 w-5 shrink-0 text-brand-400"></i>
                        {{ $point }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-center" data-reveal="right">
            <div class="relative w-full max-w-3xl">
                <div class="absolute -inset-8 rounded-full bg-brand-500/15 blur-3xl"></div>
                <div class="cd-rotor relative aspect-[16/9] rounded-md bg-gradient-to-b from-[#26272c] to-[#0f0f12] p-[1.1%] pb-[2.6%] shadow-[0_40px_80px_-20px_rgba(0,0,0,0.8)] ring-1 ring-white/10"
                     :class="portrait && 'is-portrait'">
                    <div class="cd-sweep relative h-full w-full overflow-hidden bg-black">
                        <img src="{{ $base('slide-sale.jpg') }}" alt="Landscape promotion on a Yara Commercial Display" loading="lazy"
                             class="absolute inset-0 h-full w-full object-cover transition-opacity duration-500"
                             :class="portrait ? 'opacity-0 delay-300' : 'opacity-100 delay-300'">
                        <img src="{{ $base('slide-aurora-portrait.jpg') }}" alt="Portrait poster on a Yara Commercial Display" loading="lazy"
                             class="cd-portrait-slide transition-opacity duration-500"
                             :class="portrait ? 'opacity-100 delay-300' : 'opacity-0 delay-300'" style="opacity: 0" :style="''">
                    </div>
                    <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="" class="absolute bottom-[0.7%] left-1/2 h-[1.4%] min-h-[6px] w-auto -translate-x-1/2 opacity-80">
                </div>
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     INDUSTRIES — one screen, every message
========================================================= --}}
<section id="industries" class="scroll-mt-32 bg-white py-24 text-gray-900"
         x-data="{ i: 0, n: {{ count($industries) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 4200) }, pick(k) { this.i = k; this.start() } }"
         x-init="start()">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Industries</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">One screen. <span class="text-brand-600">Every message.</span></h2>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-2" data-reveal>
            @foreach ($industries as $k => $industry)
                <button type="button" @click="pick({{ $k }})"
                        class="relative inline-flex items-center gap-2 overflow-hidden rounded-full px-5 py-2.5 text-sm font-semibold transition"
                        :class="i === {{ $k }} ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'">
                    <i data-lucide="{{ $industry['icon'] }}" class="h-4 w-4"></i>
                    {{ $industry['label'] }}
                    <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-brand-500" :class="i === {{ $k }} ? 'centum-thumb-progress [animation-duration:4.2s]' : 'scale-x-0'"></span>
                </button>
            @endforeach
        </div>

        <div class="mt-12 grid items-center gap-12 lg:grid-cols-[1.4fr_1fr]">
            <div class="relative grid" data-no-auto-reveal>
                <div class="absolute inset-[12%] rounded-full bg-brand-500/10 blur-3xl"></div>
                @foreach ($industries as $k => $industry)
                    <img src="{{ $base("cd-angle-left-{$industry['key']}.png") }}" alt="{{ $industry['label'] }} content on a Yara Commercial Display" loading="lazy"
                         class="relative col-start-1 row-start-1 w-full drop-shadow-[0_30px_40px_rgba(0,0,0,0.25)] transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                         :class="i === {{ $k }} ? 'opacity-100 translate-x-0' : 'pointer-events-none opacity-0 -translate-x-6'"
                         @if ($k > 0) style="opacity: 0" @endif :style="''">
                @endforeach
            </div>

            <div class="relative grid" data-no-auto-reveal>
                @foreach ($industries as $k => $industry)
                    <div class="col-start-1 row-start-1 transition-all duration-500"
                         :class="i === {{ $k }} ? 'opacity-100 translate-y-0' : 'pointer-events-none opacity-0 translate-y-4'"
                         @if ($k > 0) style="opacity: 0" @endif :style="''">
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red text-white shadow-lg shadow-brand-600/30">
                            <i data-lucide="{{ $industry['icon'] }}" class="h-7 w-7"></i>
                        </span>
                        <p class="mt-6 text-sm font-semibold uppercase tracking-[0.2em] text-brand-600">{{ $industry['label'] }}</p>
                        <h3 class="mt-2 text-3xl font-bold sm:text-4xl">{{ $industry['title'] }}</h3>
                        <p class="mt-4 text-lg text-gray-600">{{ $industry['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>


{{-- =========================================================
     IN THE REAL WORLD
========================================================= --}}
<section class="relative overflow-hidden py-24">

    <div class="about-blob -right-24 top-1/3 h-96 w-96 bg-brand-800"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">In the real world</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Made to be <span class="about-gradient-text">noticed.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">From the store floor to the bus shelter, bright slim screens that stop people in their tracks.</p>
        </div>

        <div class="mt-12 grid gap-5 lg:grid-cols-4">
            <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10 lg:col-span-1 lg:row-span-2" data-reveal>
                <img src="{{ $base('scene-retail.jpg') }}" alt="Portrait commercial display in a retail store" loading="lazy"
                     class="h-full w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-sm font-semibold">Retail stores</figcaption>
            </figure>
            <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10 lg:col-span-1 lg:row-span-2" data-reveal style="--reveal-delay: 110ms">
                <img src="{{ $base('scene-transit.jpg') }}" alt="Commercial display in a bus shelter" loading="lazy"
                     class="h-full w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-sm font-semibold">Transit & shelters</figcaption>
            </figure>

            <div class="grid grid-cols-2 items-end gap-5 rounded-[1.75rem] bg-white/[0.03] p-6 ring-1 ring-white/10 sm:grid-cols-4 lg:col-span-2 lg:row-span-2 lg:grid-cols-2" data-no-auto-reveal>
                @foreach (['vivera', 'aurora', 'sale', 'honey'] as $k => $key)
                    <img src="{{ $base("cd-portrait-{$key}.png") }}" alt="Portrait Yara Commercial Display" loading="lazy"
                         class="{{ $k % 2 ? 'about-float-delayed' : 'about-float' }} mx-auto w-[70%] drop-shadow-[0_25px_30px_rgba(0,0,0,0.6)]">
                @endforeach
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     WHY COMMERCIAL — vs a consumer TV
========================================================= --}}
<section class="bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Why commercial</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">A TV isn't built for business.</h2>
        </div>

        <div class="mt-12 overflow-hidden rounded-3xl bg-white ring-1 ring-gray-200" data-reveal>
            <div class="grid grid-cols-3 bg-gray-950 text-sm font-semibold text-white">
                <div class="p-4 sm:p-5"></div>
                <div class="p-4 text-center text-gray-400 sm:p-5">Home TV</div>
                <div class="bg-brand-600 p-4 text-center sm:p-5">Yara Commercial Display</div>
            </div>
            @foreach ([
                ['Operating hours', '6–8 hours a day', '24/7 rated'],
                ['Brightness', '250–300 nits', 'Up to 500 nits, anti-glare'],
                ['Orientation', 'Landscape only', 'Landscape & portrait'],
                ['Content', 'Manual, from a remote', 'Scheduled playlists, USB or network'],
                ['Control', 'IR remote', 'RS232 & LAN control'],
                ['Warranty for business use', 'Often void', '3 years commercial'],
            ] as $row)
                <div class="grid grid-cols-3 border-t border-gray-100 text-sm">
                    <div class="p-4 font-semibold sm:p-5">{{ $row[0] }}</div>
                    <div class="p-4 text-center text-gray-500 sm:p-5">{{ $row[1] }}</div>
                    <div class="flex items-center justify-center gap-2 bg-brand-50/60 p-4 text-center font-semibold sm:p-5">
                        <i data-lucide="circle-check" class="hidden h-4 w-4 shrink-0 text-brand-600 sm:block"></i>
                        {{ $row[2] }}
                    </div>
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
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Slim outside. <span class="text-brand-600">Smart inside.</span></h2>
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
        <h2 class="text-4xl font-bold sm:text-6xl">Your message, <span class="about-gradient-text">always on.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us where it goes. We'll recommend the right size and orientation, and help you set up your content.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.category', 'commercial-display-solutions') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                All display solutions
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>

</section>

</div>

@endsection
