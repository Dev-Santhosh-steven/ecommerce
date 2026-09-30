@extends('layouts.store')

@section('title', 'Yara 27" Touchscreen Digital Podium | Smart Presentation Podium with Dual Mics')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $base = fn ($file) => asset("storage/products/digital-podium/{$file}");
    $logo = asset('storage/products/centum/yara-logo-light.png');
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the 27" Touchscreen Digital Podium. Please share details and pricing.');

    // Hotspots on the podium drawing (SVG user units, viewBox 0 0 420 640). "head" points move with the height.
    $spots = [
        ['x' => 212, 'y' => 268, 'head' => true, 'icon' => 'monitor-smartphone', 'title' => '27" all-in-one touch screen', 'text' => '16:9 LED-backlit display under toughened glass. Present, annotate and browse with a finger or the stylus.'],
        ['x' => 64, 'y' => 70, 'head' => true, 'icon' => 'mic', 'title' => 'Dual wireless gooseneck mics', 'text' => 'Two microphones and a wireless voice system, so every word reaches the back row.'],
        ['x' => 212, 'y' => 470, 'head' => false, 'icon' => 'move-vertical', 'title' => 'Electric height adjustment', 'text' => 'Raise or lower the podium at the touch of a button to suit every presenter. Try the slider.'],
        ['x' => 270, 'y' => 338, 'head' => true, 'icon' => 'laptop', 'title' => 'Side tray', 'text' => 'Room for a laptop, notes or a PC beside the screen.'],
        ['x' => 330, 'y' => 596, 'head' => false, 'icon' => 'rotate-3d', 'title' => '360° ball-bearing casters', 'text' => 'Stainless steel and aluminium frame that rolls smoothly from stage to classroom.'],
        ['x' => 360, 'y' => 228, 'head' => true, 'icon' => 'cable', 'title' => 'USB · HDMI · VGA', 'text' => 'Plug in laptops, cameras and projectors. Optional battery for cable-free use.'],
    ];

    $platforms = [
        'android' => ['label' => 'Android', 'icon' => 'smartphone', 'rows' => [['OS', 'Android 9'], ['Memory', '4GB RAM'], ['Storage', '32GB ROM'], ['Ports', 'USB · HDMI · VGA']], 'note' => 'Simple, instant-on presenting with apps and screen sharing.'],
        'windows' => ['label' => 'Windows', 'icon' => 'laptop', 'rows' => [['OS', 'Windows 10'], ['Processor', 'Intel i5'], ['Memory', '8GB RAM'], ['Storage', '256GB SSD']], 'note' => 'A full PC in the podium for Office, browsers and your own software.'],
    ];

    $venues = [
        ['img' => $base('podium-auditorium.jpg'), 'place' => 'Auditoriums & lecture halls', 'icon' => 'graduation-cap'],
        ['img' => $base('venue-conference.jpg'), 'place' => 'Conferences & events', 'icon' => 'mic-2'],
        ['img' => $base('venue-launch.jpg'), 'place' => 'Product launches & stages', 'icon' => 'sparkles'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0b0908] text-white">

{{-- =========================================================
     HERO — the podium on stage
========================================================= --}}
<section class="relative isolate flex min-h-[40rem] items-center overflow-hidden lg:min-h-[44rem]">

    <img src="{{ $base('podium-auditorium.jpg') }}" alt="Yara 27 inch Digital Podium on stage in an auditorium"
         class="ha-kenburns absolute inset-0 -z-10 h-full w-full object-cover object-[65%_50%]">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-[#0b0908] via-[#0b0908]/80 via-40% to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-[#0b0908] to-transparent"></div>

    <div class="mx-auto w-full max-w-[1500px] px-4 py-20 sm:px-6 lg:px-10">
        <div class="about-intro max-w-xl">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-black/30 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-200 backdrop-blur">
                <img src="{{ $logo }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Digital Podium
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-7xl">
                Smart presentations<br><span class="about-gradient-text">made simple.</span>
            </h1>
            <p class="mt-6 text-lg text-gray-200 sm:text-xl">
                All-in-one 27" touchscreen digital podium with dual microphones and seamless connectivity.
            </p>
            <div class="mt-9 flex flex-wrap gap-4">
                <a href="#stage" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                    Explore the podium
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-black/20 px-7 py-4 text-sm font-semibold backdrop-blur transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <div class="mt-10 flex flex-wrap gap-3">
                @foreach (['27" Touch', 'Dual Mics', 'Height Adjustable', 'Android or Windows', 'Price on request'] as $pill)
                    <span class="rounded-full border border-white/15 bg-black/25 px-4 py-2 text-sm text-gray-100 backdrop-blur">{{ $pill }}</span>
                @endforeach
            </div>
        </div>
    </div>

    <img src="{{ $logo }}" alt="Yara" class="absolute bottom-8 right-8 hidden w-28 opacity-80 sm:block">

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0908]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara 27" Digital Podium</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Touchscreen · Dual mics · Height adjustable · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#stage" class="transition hover:text-white">Tour</a>
            <a href="#platform" class="transition hover:text-white">Android / Windows</a>
            <a href="#venues" class="transition hover:text-white">Where to use</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     INTERACTIVE TOUR — hotspots + height slider
========================================================= --}}
<section id="stage" class="relative scroll-mt-32 overflow-hidden bg-[#f5f3f0] py-24 text-gray-900"
         x-data="{ s: 0, lift: 0, slide: 0, t: null,
                   init() { this.t = setInterval(() => this.slide = (this.slide + 1) % 3, 3500) } }">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Take the stage</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Everything a presenter needs, <span class="text-brand-600">in one podium.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Tap the points to explore, and drag the slider to raise the podium.</p>
        </div>

        <div class="mt-14 grid items-center gap-12 lg:grid-cols-[1.1fr_1fr]">

            {{-- the podium --}}
            <div class="relative mx-auto w-full max-w-lg" data-no-auto-reveal>
                <div class="absolute inset-x-[15%] bottom-[3%] h-10 rounded-[50%] bg-black/15 blur-2xl"></div>
                <svg viewBox="0 0 420 640" class="relative w-full" role="img" aria-label="Yara 27 inch digital podium">
                    <defs>
                        <linearGradient id="pd-metal" x1="0" x2="1">
                            <stop offset="0" stop-color="#1b1c20"/><stop offset=".45" stop-color="#3a3c44"/><stop offset="1" stop-color="#121316"/>
                        </linearGradient>
                        <linearGradient id="pd-frame" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0" stop-color="#2b2d33"/><stop offset="1" stop-color="#0d0e11"/>
                        </linearGradient>
                        <linearGradient id="pd-screen" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0" stop-color="#1d3fd8"/><stop offset=".55" stop-color="#5b2fd6"/><stop offset="1" stop-color="#b03ad1"/>
                        </linearGradient>
                        <linearGradient id="pd-glare" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0" stop-color="#fff" stop-opacity="0"/><stop offset=".5" stop-color="#fff" stop-opacity=".18"/><stop offset="1" stop-color="#fff" stop-opacity="0"/>
                        </linearGradient>
                        <radialGradient id="pd-led"><stop offset="0" stop-color="#ff3b47"/><stop offset="1" stop-color="#ff3b47" stop-opacity="0"/></radialGradient>
                    </defs>

                    {{-- base: curved foot with casters --}}
                    <path d="M92 592 Q212 520 332 592" fill="none" stroke="url(#pd-metal)" stroke-width="26" stroke-linecap="round"/>
                    <path d="M92 592 Q212 520 332 592" fill="none" stroke="#fff" stroke-opacity=".08" stroke-width="3" transform="translate(0 -9)"/>
                    @foreach ([[92, 604], [332, 604]] as [$cx, $cy])
                        <g class="pd-caster" style="transform-origin: {{ $cx }}px {{ $cy }}px">
                            <circle cx="{{ $cx }}" cy="{{ $cy }}" r="11" fill="#0d0e11"/><circle cx="{{ $cx }}" cy="{{ $cy }}" r="5" fill="#9aa0aa"/>
                            <line x1="{{ $cx - 8 }}" y1="{{ $cy }}" x2="{{ $cx + 8 }}" y2="{{ $cy }}" stroke="#555" stroke-width="2"/>
                        </g>
                    @endforeach

                    {{-- column: its top follows the height --}}
                    <path :d="`M190 ${300 - lift} L234 ${300 - lift} L240 568 L184 568 Z`" d="M190 300 L234 300 L240 568 L184 568 Z" fill="url(#pd-metal)"/>
                    <path :d="`M205 ${300 - lift} L212 ${300 - lift} L214 568 L206 568 Z`" d="M205 300 L212 300 L214 568 L206 568 Z" fill="#fff" fill-opacity=".06"/>
                    <image href="{{ $logo }}" x="194" y="488" width="38" height="13" preserveAspectRatio="xMidYMid meet"/>

                    {{-- head: screen, mics and tray move together --}}
                    <g :transform="`translate(0 ${-lift})`" class="transition-transform duration-300">
                        {{-- side tray --}}
                        <path d="M236 318 L300 312 L304 330 L240 338 Z" fill="url(#pd-frame)"/>
                        <rect x="228" y="300" width="14" height="34" rx="3" fill="#1b1c20"/>

                        {{-- gooseneck mics --}}
                        <path d="M72 252 C 66 190, 58 130, 62 64" fill="none" stroke="#15161a" stroke-width="4" stroke-linecap="round"/>
                        <path d="M350 214 C 356 160, 362 100, 366 44" fill="none" stroke="#15161a" stroke-width="4" stroke-linecap="round"/>
                        <rect x="57" y="46" width="10" height="22" rx="4" fill="#1e1f24"/>
                        <rect x="361" y="26" width="10" height="22" rx="4" fill="#1e1f24"/>
                        <circle class="pd-led" cx="62" cy="48" r="9" fill="url(#pd-led)"/>
                        <circle class="pd-led [animation-delay:-1.2s]" cx="366" cy="28" r="9" fill="url(#pd-led)"/>
                        <circle cx="62" cy="48" r="2.2" fill="#ff3b47"/><circle cx="366" cy="28" r="2.2" fill="#ff3b47"/>

                        {{-- tablet frame (a tilted slab, mapped from a 300 × 170 rectangle) --}}
                        <g transform="matrix(1.0133 -0.12 0.1529 0.4353 56 250)">
                            <rect x="-6" y="-6" width="312" height="186" rx="8" fill="#0b0c0f"/>
                            <rect x="0" y="0" width="300" height="170" rx="4" fill="url(#pd-frame)"/>
                            <g>
                                <rect x="14" y="12" width="272" height="146" rx="2" fill="url(#pd-screen)"/>
                                {{-- slide 1: home screen with clock, like the product photo --}}
                                <g class="transition-opacity duration-700" :opacity="slide === 0 ? 1 : 0">
                                    <text x="150" y="58" text-anchor="middle" font-size="26" font-weight="700" fill="#fff" font-family="sans-serif">09:18</text>
                                    @foreach ([70, 118, 166, 214] as $k => $ix)
                                        <rect x="{{ $ix }}" y="82" width="22" height="22" rx="5" fill="{{ ['#ff9f43', '#48dbfb', '#feca57', '#ff6b6b'][$k] }}" opacity=".95"/>
                                    @endforeach
                                </g>
                                {{-- slide 2: presentation --}}
                                <g class="transition-opacity duration-700" :opacity="slide === 1 ? 1 : 0" opacity="0">
                                    <rect x="14" y="12" width="272" height="146" rx="2" fill="#fbfbfd"/>
                                    <rect x="30" y="28" width="120" height="10" rx="3" fill="#a51d35"/>
                                    <rect x="30" y="46" width="80" height="6" rx="3" fill="#c9ccd4"/>
                                    @foreach ([[40, 60], [80, 90], [120, 45], [160, 110], [200, 75]] as [$bx, $bh])
                                        <rect x="{{ $bx + 20 }}" y="{{ 145 - $bh }}" width="24" height="{{ $bh }}" rx="3" fill="{{ $bx === 160 ? '#ed1c24' : '#3b5bdb' }}" opacity=".85"/>
                                    @endforeach
                                </g>
                                {{-- slide 3: annotation --}}
                                <g class="transition-opacity duration-700" :opacity="slide === 2 ? 1 : 0" opacity="0">
                                    <rect x="14" y="12" width="272" height="146" rx="2" fill="#0f172a"/>
                                    <path class="pd-ink" d="M50 110 C 80 50, 120 140, 150 80 S 220 60, 250 100" fill="none" stroke="#ffd43b" stroke-width="5" stroke-linecap="round"/>
                                    <text x="150" y="42" text-anchor="middle" font-size="14" font-weight="700" fill="#fff" font-family="sans-serif">Write on the screen</text>
                                </g>
                                <rect x="14" y="12" width="272" height="146" fill="url(#pd-glare)"/>
                            </g>
                            <image href="{{ $logo }}" x="130" y="160" width="40" height="8" preserveAspectRatio="xMidYMid meet" opacity=".85"/>
                        </g>
                    </g>

                    {{-- hotspots --}}
                    @foreach ($spots as $k => $p)
                        <g class="cursor-pointer" @click="s = {{ $k }}"
                           transform="translate({{ $p['x'] }} {{ $p['y'] }})"
                           @if ($p['head']) :transform="`translate({{ $p['x'] }} ${ {{ $p['y'] }} - lift })`" @endif>
                            <circle r="15" class="pd-pulse" :fill="s === {{ $k }} ? '#ed1c24' : '#ffffff'" fill="#ffffff" fill-opacity=".35"/>
                            <circle r="9" :fill="s === {{ $k }} ? '#ed1c24' : '#ffffff'" fill="#ffffff" stroke="#a51d35" stroke-width="2.5"/>
                        </g>
                    @endforeach
                </svg>

                {{-- height slider --}}
                <label class="mx-auto mt-6 flex max-w-sm items-center gap-4 rounded-full bg-white px-5 py-3 shadow-sm ring-1 ring-gray-200">
                    <i data-lucide="move-vertical" class="h-5 w-5 shrink-0 text-brand-600"></i>
                    <span class="text-sm font-semibold">Height</span>
                    <input type="range" min="0" max="70" x-model.number="lift" @input="s = 2" class="w-full accent-[#a51d35]" aria-label="Podium height">
                </label>
            </div>

            {{-- feature list --}}
            <div class="space-y-3">
                @foreach ($spots as $k => $p)
                    <button type="button" @click="s = {{ $k }}" class="flex w-full items-start gap-4 rounded-2xl p-4 text-left transition"
                            :class="s === {{ $k }} ? 'bg-white shadow-lg ring-1 ring-brand-200' : 'hover:bg-white/70'">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition" :class="s === {{ $k }} ? 'bg-brand-600 text-white' : 'bg-gray-200/70 text-gray-600'">
                            <i data-lucide="{{ $p['icon'] }}" class="h-5 w-5"></i>
                        </span>
                        <span>
                            <span class="block font-bold">{{ $p['title'] }}</span>
                            <span class="mt-1 block text-sm leading-6 text-gray-600" x-show="s === {{ $k }}" @if ($k > 0) x-cloak @endif>{{ $p['text'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
     PLATFORM — Android or Windows
========================================================= --}}
<section id="platform" class="relative scroll-mt-32 overflow-hidden py-24" x-data="{ p: 'android' }">
    <div class="about-grid absolute inset-0 opacity-40"></div>
    <div class="about-blob -right-24 top-10 h-96 w-96 bg-brand-800/60"></div>

    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Inside the screen</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Android or Windows. <span class="about-gradient-text">Your choice.</span></h2>
        </div>

        <div class="mx-auto mt-10 flex w-fit rounded-full bg-white/5 p-1 ring-1 ring-white/10">
            @foreach ($platforms as $key => $pf)
                <button type="button" @click="p = '{{ $key }}'" class="inline-flex items-center gap-2 rounded-full px-6 py-2.5 text-sm font-semibold transition"
                        :class="p === '{{ $key }}' ? 'bg-brand-600 text-white shadow-lg' : 'text-gray-300 hover:text-white'">
                    <i data-lucide="{{ $pf['icon'] }}" class="h-4 w-4"></i>
                    {{ $pf['label'] }}
                </button>
            @endforeach
        </div>

        @foreach ($platforms as $key => $pf)
            <div x-show="p === '{{ $key }}'" @if ($key !== 'android') x-cloak @endif class="about-intro mt-10">
                <div class="grid grid-cols-2 gap-px overflow-hidden rounded-3xl bg-white/10 sm:grid-cols-4">
                    @foreach ($pf['rows'] as [$label, $value])
                        <div class="bg-[#110e0d] p-6 text-center">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-500">{{ $label }}</p>
                            <p class="mt-2 font-display text-2xl font-extrabold">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
                <p class="mt-6 text-center text-gray-300">{{ $pf['note'] }}</p>
            </div>
        @endforeach
    </div>
</section>


{{-- =========================================================
     FEATURES
========================================================= --}}
<section class="bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Features</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Built for <span class="text-brand-600">confident speakers.</span></h2>
        </div>
        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($product->features as $feature)
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
     VENUES
========================================================= --}}
<section id="venues" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-blob -left-24 top-10 h-96 w-96 bg-brand-800/50"></div>
    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Wherever people <span class="about-gradient-text">take the stage.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Lecture halls, conferences, launches, boardrooms and classrooms.</p>
        </div>

        <div class="mt-12 grid gap-5 lg:grid-cols-3">
            @foreach ($venues as $i => $v)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10 {{ $i === 0 ? 'lg:row-span-2' : '' }}" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $v['img'] }}" alt="{{ $v['place'] }}" loading="lazy"
                         class="h-full min-h-[16rem] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105 {{ $i === 0 ? 'object-[65%_50%] lg:min-h-[34rem]' : 'aspect-[16/9]' }}">
                    <figcaption class="absolute inset-x-0 bottom-0 flex items-center gap-3 bg-gradient-to-t from-black/85 to-transparent p-6 font-semibold">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 backdrop-blur"><i data-lucide="{{ $v['icon'] }}" class="h-4 w-4"></i></span>
                        {{ $v['place'] }}
                    </figcaption>
                </figure>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach ([['building-2', 'Boardrooms'], ['presentation', 'Smart classrooms'], ['landmark', 'Government & courts'], ['theater', 'Events & award nights']] as [$icon, $label])
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-brand-400"></i>
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
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">{{ $product->name }}</h2>
        </div>
        <dl class="mt-12 grid gap-x-12 sm:grid-cols-2" data-reveal>
            @foreach ($product->specifications ?? [] as $key => $value)
                <div class="flex items-baseline justify-between gap-6 border-b border-gray-200 py-4">
                    <dt class="text-sm text-gray-500">{{ $key }}</dt>
                    <dd class="text-right font-semibold">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
        <div class="mt-10 text-center">
            <a href="{{ route('store.product', $product) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:underline">
                View product page
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
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
        <img src="{{ $logo }}" alt="Yara" class="mx-auto h-10 w-auto">
        <h2 class="mt-8 text-4xl font-bold sm:text-6xl">Own <span class="about-gradient-text">every stage.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us about your venue and we'll set up the podium with the right platform, microphones and connections.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                Book a demo
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</section>

</div>

@endsection
