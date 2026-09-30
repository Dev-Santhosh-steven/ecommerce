@extends('layouts.store')

@section('title', 'Yara Anti-Glare QLED TV | No Reflections, Even in Daylight · 65" to 100"')

@push('styles')
    <meta name="description" content="Yara Anti-Glare QLED TVs in 65, 75, 86 and 100 inch: a matte, anti-reflective 4K screen that stays clear in bright rooms, with QLED colour, Dolby Audio and smart TV apps.">
@endpush

@php
    $ag = fn ($file) => asset("storage/products/televisions/anti-glare/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in your Anti-Glare QLED TVs. Please share details and pricing.');
    $inch = fn ($p) => (int) ($p->specifications['Screen Size'] ?? 0);
    $label = fn ($p) => ($inch($p) ?: '') . '"';

    $compareRows = [
        'Screen Size' => 'Screen size', 'Resolution' => 'Resolution', 'Brightness' => 'Brightness', 'Contrast Ratio' => 'Contrast',
        'HDR' => 'HDR', 'Refresh Rate' => 'Refresh rate', 'Audio Output' => 'Speakers', 'Operating System' => 'Platform',
        'RAM' => 'RAM', 'Storage' => 'Storage', 'HDMI' => 'HDMI', 'USB' => 'USB', 'Power Consumption' => 'Power',
        'Product Dimensions' => 'Dimensions', 'Net / Gross Weight' => 'Weight',
    ];
    $scenes = [
        ['img' => $ag('screen-coast.jpg'), 'label' => 'Coast'],
        ['img' => $ag('screen-f1-night.jpg'), 'label' => 'Night race'],
        ['img' => $ag('screen-ember-tree.jpg'), 'label' => 'Ember tree'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0c0a08] text-white">

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative isolate overflow-hidden pb-20 pt-14 sm:pt-20">

    <div class="ag-beams pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        @foreach ([4, 22, 40, 58] as $k => $left)
            <span style="left: {{ $left }}%; animation-delay: -{{ $k * 2.7 }}s"></span>
        @endforeach
    </div>
    <div class="absolute inset-0 -z-20 bg-[radial-gradient(ellipse_at_75%_45%,rgba(255,150,60,0.18),transparent_60%)]"></div>

    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-amber-300/30 bg-amber-300/10 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-amber-100 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Anti-Glare QLED TV
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.02] sm:text-7xl">
                Bright room.<br><span class="bg-gradient-to-r from-amber-200 via-orange-300 to-amber-100 bg-clip-text text-transparent">Clear picture.</span>
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                A matte, anti-reflective 4K QLED screen that turns sunlight and lamps into a soft haze, not a mirror. Watch in daylight without closing the curtains.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="#compare" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-7 py-4 text-sm font-bold text-[#1a1206] shadow-lg shadow-amber-900/40 transition hover:bg-amber-300">
                    See the difference
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="#models" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                    65" · 75" · 86" · 100"
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-[10%] rounded-full bg-orange-500/20 blur-[90px]"></div>
            {{-- a sun drifting over the screen: no hard glare, only a faint warm haze --}}
            <div class="centum-hero-tv relative">
                <img src="{{ $ag('ag-hero.png') }}" alt="Yara Anti-Glare QLED TV" class="relative w-full">
                <div class="pointer-events-none absolute left-[3.6%] right-[2.6%] top-[4.5%] h-[79%] overflow-hidden">
                    <div class="ag-sun absolute left-1/3 top-[5%] h-[70%] w-[45%] rounded-full bg-amber-100/15 blur-[60px]"></div>
                </div>
            </div>
            @foreach ([
                ['sun', 'Anti-reflective matte', 'left-0 top-[6%]', '0s'],
                ['palette', '1.07 billion colours', 'right-0 top-0', '-2s'],
                ['monitor', '4K Ultra HD QLED', 'left-[4%] bottom-[16%]', '-4s'],
                ['volume-2', 'Dolby Audio', 'right-[3%] bottom-[10%]', '-1s'],
            ] as [$icon, $text, $pos, $delay])
                <span class="cd-chip absolute {{ $pos }} hidden items-center gap-2 rounded-full border border-white/15 bg-black/55 px-4 py-2 text-xs font-semibold shadow-xl backdrop-blur-md sm:inline-flex" style="animation-delay: {{ $delay }}">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-amber-300"></i>
                    {{ $text }}
                </span>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0c0a08]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Anti-Glare QLED TV</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">65" · 75" · 86" · 100" · from ₹{{ number_format($products->min('price')) }}</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#compare" class="transition hover:text-amber-200">Glossy vs matte</a>
            <a href="#how" class="transition hover:text-amber-200">How it works</a>
            <a href="#benefits" class="transition hover:text-amber-200">Benefits</a>
            <a href="#models" class="transition hover:text-amber-200">Models</a>
            <a href="#specs" class="transition hover:text-amber-200">Compare</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-amber-400 px-5 py-2.5 text-sm font-bold text-[#1a1206] transition hover:bg-amber-300">Enquire</a>
    </div>
</div>


{{-- =========================================================
     GLOSSY vs ANTI-GLARE — drag to compare
========================================================= --}}
<section id="compare" class="scroll-mt-32 bg-[#f6f3ee] py-24 text-gray-900"
         x-data="{ pos: 50, light: 'day', s: 0, drag: false,
                   set(e) { const r = $refs.stage.getBoundingClientRect(); const x = (e.touches ? e.touches[0].clientX : e.clientX) - r.left; this.pos = Math.min(98, Math.max(2, x / r.width * 100)) } }">
    <div class="mx-auto max-w-[1300px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Glossy vs anti-glare</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Same room. Same light. <span class="text-orange-600">See the difference.</span></h2>
            <p class="mt-4 text-lg text-gray-600">Drag the handle. On the left, a normal glossy screen mirrors the window and lamp. On the right, the Yara anti-glare screen diffuses them.</p>
        </div>

        <div class="mt-12 flex flex-wrap items-center justify-center gap-3" data-reveal>
            <div class="inline-flex rounded-full bg-white p-1 text-sm font-semibold shadow-sm ring-1 ring-gray-200">
                <button type="button" @click="light = 'day'" class="inline-flex items-center gap-2 rounded-full px-5 py-2 transition" :class="light === 'day' ? 'bg-gray-900 text-white' : 'text-gray-600'"><i data-lucide="sun" class="h-4 w-4"></i> Daylight</button>
                <button type="button" @click="light = 'evening'" class="inline-flex items-center gap-2 rounded-full px-5 py-2 transition" :class="light === 'evening' ? 'bg-gray-900 text-white' : 'text-gray-600'"><i data-lucide="lamp" class="h-4 w-4"></i> Evening lamps</button>
            </div>
            <div class="inline-flex rounded-full bg-white p-1 text-sm font-semibold shadow-sm ring-1 ring-gray-200">
                @foreach ($scenes as $k => $scene)
                    <button type="button" @click="s = {{ $k }}" class="rounded-full px-4 py-2 transition" :class="s === {{ $k }} ? 'bg-orange-500 text-white' : 'text-gray-600'">{{ $scene['label'] }}</button>
                @endforeach
            </div>
        </div>

        <div class="mx-auto mt-10 max-w-5xl pb-16" data-reveal="zoom">
            <div class="ag-tv">
                <div x-ref="stage" class="relative aspect-[16/9] cursor-ew-resize select-none overflow-hidden bg-black"
                     @mousedown="drag = true; set($event)" @mousemove.window="drag && set($event)" @mouseup.window="drag = false"
                     @touchstart.passive="set($event)" @touchmove.passive="set($event)">

                    @foreach ($scenes as $k => $scene)
                        <img src="{{ $scene['img'] }}" alt="{{ $scene['label'] }} on a Yara TV" loading="lazy" draggable="false"
                             class="absolute inset-0 h-full w-full object-cover transition-opacity duration-700" :class="s === {{ $k }} ? 'opacity-100' : 'opacity-0'" @if ($k) style="opacity: 0" @endif :style="''">
                    @endforeach

                    {{-- reflections: sharp on the glossy side, scattered on the anti-glare side --}}
                    @foreach (['glossy', 'matte'] as $side)
                        <div class="absolute inset-0" :style="`clip-path: inset(0 {{ $side === 'glossy' ? '${100 - pos}% 0 0' : '0 0 ${pos}%' }})`">
                            <svg class="ag-reflect {{ $side === 'matte' ? 'is-matte' : '' }}" viewBox="0 0 1600 900" preserveAspectRatio="none" aria-hidden="true">
                                <g :opacity="light === 'day' ? 1 : 0" style="transition: opacity .6s">
                                    <polygon points="110,70 620,120 590,700 80,760" fill="#fff" fill-opacity="0.62"/>
                                    <g stroke="#3b3b3b" stroke-opacity="0.55" stroke-width="18">
                                        <line x1="280" y1="86" x2="258" y2="720"/><line x1="450" y1="102" x2="428" y2="712"/><line x1="96" y1="410" x2="606" y2="405"/>
                                    </g>
                                    <polygon points="110,70 620,120 590,700 80,760" fill="url(#ag-fade)"/>
                                </g>
                                <g :opacity="light === 'evening' ? 1 : 0.35" style="transition: opacity .6s">
                                    <circle cx="1250" cy="200" r="70" fill="#fff4dc" fill-opacity="0.9"/>
                                    <circle cx="1250" cy="200" r="150" fill="#ffe2a8" fill-opacity="0.25"/>
                                </g>
                                <g fill="#000" fill-opacity="0.35">
                                    <ellipse cx="900" cy="560" rx="80" ry="95"/>
                                    <rect x="770" y="650" width="260" height="300" rx="90"/>
                                </g>
                                <defs>
                                    <linearGradient id="ag-fade" x1="0" x2="1"><stop offset="0" stop-color="#fff" stop-opacity="0.15"/><stop offset="1" stop-color="#fff" stop-opacity="0"/></linearGradient>
                                </defs>
                            </svg>
                        </div>
                    @endforeach

                    {{-- handle --}}
                    <div class="pointer-events-none absolute inset-y-0 w-0.5 bg-white shadow-[0_0_12px_rgba(0,0,0,0.5)]" :style="`left: ${pos}%`">
                        <span class="absolute left-1/2 top-1/2 flex h-12 w-12 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white text-gray-900 shadow-xl">
                            <i data-lucide="move-horizontal" class="h-5 w-5"></i>
                        </span>
                    </div>
                    <span class="pointer-events-none absolute bottom-4 left-4 rounded-full bg-black/60 px-4 py-2 text-xs font-bold backdrop-blur" :class="pos < 12 && 'opacity-0'">Glossy screen</span>
                    <span class="pointer-events-none absolute bottom-4 right-4 rounded-full bg-orange-500/90 px-4 py-2 text-xs font-bold backdrop-blur" :class="pos > 88 && 'opacity-0'">Yara Anti-Glare</span>
                    <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="" class="absolute bottom-[-4.8%] left-1/2 w-[5%] -translate-x-1/2 opacity-80">
                </div>
            </div>
            <input type="range" min="2" max="98" x-model.number="pos" class="mt-20 w-full accent-orange-500 sm:hidden" aria-label="Compare glossy and anti-glare">
        </div>
    </div>
</section>


{{-- =========================================================
     HOW IT WORKS — animated light paths
========================================================= --}}
<section id="how" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-grid absolute inset-0 opacity-40"></div>
    <div class="relative mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">How anti-glare works</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">It scatters the light <span class="bg-gradient-to-r from-amber-200 to-orange-300 bg-clip-text text-transparent">before it reaches you.</span></h2>
            <p class="mt-5 text-lg text-gray-300">A glossy screen is a mirror: light from a window bounces straight back into your eyes. The Yara anti-glare screen has a fine, micro-textured matte surface that breaks that light into thousands of tiny, weak reflections spread in every direction. The bright spot disappears into a soft, even haze, and the picture underneath stays visible.</p>
        </div>

        <div class="mt-14 grid gap-6 lg:grid-cols-2">
            @foreach (['glossy' => ['Ordinary glossy screen', 'One strong reflection hits your eyes as glare.', 'text-rose-300'], 'matte' => ['Yara anti-glare screen', 'Light is diffused into a faint haze. No mirror image.', 'text-amber-300']] as $type => [$title, $text, $tone])
                <figure class="rounded-[2rem] border border-white/10 bg-white/[0.03] p-6 sm:p-8" data-reveal="{{ $type === 'glossy' ? 'left' : 'right' }}">
                    <svg viewBox="0 0 600 340" class="w-full" aria-hidden="true">
                        {{-- sun --}}
                        <g class="ag-glint"><circle cx="70" cy="60" r="30" fill="#fcd34d"/><circle cx="70" cy="60" r="48" fill="#fcd34d" fill-opacity="0.2"/></g>
                        {{-- incoming rays --}}
                        @foreach ([0, 22, 44] as $o)
                            <line x1="{{ 95 + $o }}" y1="{{ 80 + $o * .3 }}" x2="{{ 290 + $o * .6 }}" y2="265" stroke="#fcd34d" stroke-width="3" class="ag-ray"/>
                        @endforeach
                        @if ($type === 'glossy')
                            <rect x="170" y="265" width="300" height="12" rx="3" fill="#cbd5e1"/>
                            @foreach ([0, 22, 44] as $o)
                                <line x1="{{ 290 + $o * .6 }}" y1="265" x2="{{ 500 + $o * .5 }}" y2="{{ 105 + $o * .3 }}" stroke="#fda4af" stroke-width="3.5" class="ag-ray"/>
                            @endforeach
                            <circle cx="522" cy="112" r="22" fill="#fda4af" fill-opacity="0.35" class="ag-glint"/>
                        @else
                            <path d="M170 271 {{ collect(range(0, 29))->map(fn ($i) => 'l5 -6 l5 6')->implode(' ') }}" stroke="#fcd34d" stroke-opacity="0.8" stroke-width="2" fill="none"/>
                            <rect x="170" y="271" width="300" height="8" rx="3" fill="#78716c"/>
                            @foreach ([[-150, -70], [-90, -120], [-30, -140], [20, -130], [70, -110], [120, -80], [160, -40], [-170, -20]] as [$dx, $dy])
                                <line x1="310" y1="262" x2="{{ 310 + $dx * .55 }}" y2="{{ 262 + $dy * .55 }}" stroke="#fcd34d" stroke-opacity="0.45" stroke-width="2" class="ag-ray is-slow"/>
                            @endforeach
                        @endif
                        {{-- viewer --}}
                        <g fill="#e5e7eb"><circle cx="540" cy="100" r="16"/><path d="M515 150 q25 -32 50 0 v40 h-50z"/></g>
                        <text x="320" y="318" text-anchor="middle" fill="#9ca3af" font-size="16" font-family="sans-serif">{{ $type === 'glossy' ? 'mirror-smooth surface' : 'micro-textured matte surface' }}</text>
                    </svg>
                    <figcaption class="mt-4">
                        <p class="text-xl font-bold {{ $tone }}">{{ $title }}</p>
                        <p class="mt-1 text-gray-300">{{ $text }}</p>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     BENEFITS
========================================================= --}}
<section id="benefits" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Why anti-glare</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Made for real living rooms.</h2>
        </div>
        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['sun', 'Watch in daylight', 'Keep the curtains open. Windows and sunlight don\'t wash out the picture.'],
                ['scan-eye', 'No mirror image', 'You won\'t see yourself, the lamps or the room in dark scenes.'],
                ['eye', 'Easier on the eyes', 'Less harsh glare means more comfortable viewing for longer.'],
                ['armchair', 'Every seat works', '178° × 178° viewing angles keep colours even from the sofa ends.'],
                ['palette', 'QLED colour', '1.07 billion colours and 3000:1 contrast stay rich under the matte finish.'],
                ['briefcase', 'Great for offices too', 'Bright meeting rooms and shops get a clear, readable screen all day.'],
            ] as $k => [$icon, $title, $text])
                <div class="group rounded-3xl bg-[#faf7f2] p-7 ring-1 ring-orange-100 transition duration-300 hover:-translate-y-1 hover:shadow-xl" data-reveal style="--reveal-delay: {{ ($k % 3) * 100 }}ms">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-orange-600 text-white shadow-lg shadow-orange-600/30 transition group-hover:-rotate-6">
                        <i data-lucide="{{ $icon }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $text }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     MODELS
========================================================= --}}
<section id="models" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-blob -right-24 top-1/3 h-96 w-96 bg-orange-700/40"></div>
    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-amber-300">The range</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Four sizes. <span class="bg-gradient-to-r from-amber-200 to-orange-300 bg-clip-text text-transparent">Zero glare.</span></h2>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($products as $i => $product)
                @php $s = $product->specifications; @endphp
                <article class="about-shine group flex flex-col rounded-[2rem] border border-white/10 bg-white/[0.04] p-6 transition duration-500 hover:-translate-y-2 hover:border-amber-300/40" data-reveal style="--reveal-delay: {{ $i * 120 }}ms">
                    <div class="flex h-48 items-end justify-center">
                        <img src="{{ $ag('ag-model-' . ($i % 4) . '.png') }}" alt="{{ $product->name }}" loading="lazy"
                             class="transition duration-700 group-hover:-translate-y-1 group-hover:scale-[1.04]" style="width: {{ 62 + $i * 12 }}%">
                    </div>
                    <p class="mt-6 font-display text-5xl font-extrabold">{{ $label($product) }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-[0.2em] text-amber-300">Anti-Glare QLED · 4K</p>
                    <ul class="mt-5 flex-1 space-y-2 text-sm text-gray-300">
                        @foreach (array_filter([
                            ['monitor', $s['Resolution'] ?? null],
                            ['sun', $s['Brightness'] ?? null ? $s['Brightness'] . ' · ' . ($s['Contrast Ratio'] ?? '') . ' contrast' : null],
                            ['tv', $s['Operating System'] ?? 'Smart TV · ' . str($s['Apps & Casting'] ?? '')->before(',')],
                            ['cpu', isset($s['RAM']) ? $s['RAM'] . ' RAM' . (isset($s['Storage']) ? ' · ' . $s['Storage'] : '') : null],
                            ['volume-2', ($s['Audio Output'] ?? '') . ' · ' . ($s['Sound'] ?? '')],
                            ['sparkles', $s['HDR'] ?? null],
                            ['gauge', $s['Refresh Rate'] ?? null],
                        ], fn ($row) => filled($row[1])) as [$icon, $text])
                            <li class="flex items-start gap-2"><i data-lucide="{{ $icon }}" class="mt-0.5 h-4 w-4 shrink-0 text-amber-300"></i>{{ $text }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-6 text-2xl font-bold">₹{{ number_format($product->sale_price ?: $product->price) }} <span class="text-xs font-medium text-gray-400">MRP</span></p>
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('store.product', $product) }}" class="flex-1 rounded-full bg-white px-5 py-3 text-center text-sm font-semibold text-gray-900 transition hover:bg-amber-300">View details</a>
                        <a href="{{ $wa("Hi Yara, I am interested in the {$product->name}. Please share the best price.") }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border border-white/20 transition hover:border-amber-300 hover:bg-amber-400 hover:text-[#1a1206]" aria-label="Enquire on WhatsApp">
                            <i data-lucide="message-circle" class="h-5 w-5"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     SPEC COMPARISON
========================================================= --}}
<section id="specs" class="scroll-mt-32 bg-[#f6f3ee] py-24 text-gray-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Compare</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Side by side.</h2>
        </div>
        <div class="mt-12 overflow-x-auto rounded-3xl bg-white ring-1 ring-gray-200" data-reveal>
            <table class="w-full min-w-[46rem] text-left text-sm">
                <thead class="bg-gray-950 text-white">
                    <tr>
                        <th class="p-4"></th>
                        @foreach ($products as $product)
                            <th class="p-4 text-center"><span class="font-display text-2xl font-extrabold">{{ $label($product) }}</span></th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($compareRows as $key => $name)
                        @continue($products->every(fn ($p) => blank($p->specifications[$key] ?? null)))
                        <tr class="odd:bg-orange-50/30">
                            <td class="p-4 font-semibold">{{ $name }}</td>
                            @foreach ($products as $product)
                                <td class="p-4 text-center text-gray-700">{{ $product->specifications[$key] ?? '—' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td class="p-4 font-semibold">MRP</td>
                        @foreach ($products as $product)
                            <td class="p-4 text-center font-bold">₹{{ number_format($product->price) }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>


{{-- =========================================================
     FAQ
========================================================= --}}
<section class="bg-white py-24 text-gray-900" x-data="{ open: 0 }">
    <div class="mx-auto max-w-3xl px-4 sm:px-6">
        <h2 class="text-center text-4xl font-bold" data-reveal>Good questions.</h2>
        <div class="mt-10 divide-y divide-gray-200 rounded-3xl ring-1 ring-gray-200" data-reveal>
            @foreach ([
                ['Does anti-glare make the picture dull?', 'No. The matte layer only scatters light coming from the room. Light from the QLED panel still passes straight through, so colours and brightness look the same, and they look better in a bright room because there is no glare on top.'],
                ['Is it worth it in a dark room?', 'In a dark room any screen looks good. Anti-glare pays off in daylight, with lamps on, or in rooms with windows opposite or beside the TV, which is most Indian living rooms.'],
                ['What is the difference between anti-glare and anti-reflective?', 'People use both words for the same idea: stopping the screen acting like a mirror. Yara uses a matte, micro-textured surface that diffuses reflections into a faint haze instead of a sharp image.'],
                ['How should I clean the screen?', 'Switch the TV off and wipe gently with a dry microfibre cloth. For marks, dampen the cloth slightly with water. Don\'t spray liquid directly on the screen or use glass cleaners.'],
                ['Can I wall-mount it?', 'Yes. A wall-mount bracket is included with every Yara anti-glare model, along with the table stand.'],
            ] as $k => [$q, $a])
                <div>
                    <button type="button" @click="open = open === {{ $k }} ? null : {{ $k }}" class="flex w-full items-center justify-between gap-4 p-6 text-left font-semibold" :aria-expanded="open === {{ $k }}">
                        {{ $q }}
                        <i data-lucide="plus" class="h-5 w-5 shrink-0 transition" :class="open === {{ $k }} && 'rotate-45'"></i>
                    </button>
                    <div x-show="open === {{ $k }}" x-transition.opacity.duration.300ms @if ($k) x-cloak @endif class="px-6 pb-6 text-gray-600">{{ $a }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative isolate overflow-hidden py-28 text-center">
    <div class="ag-beams pointer-events-none absolute inset-0 -z-10" aria-hidden="true">
        @foreach ([10, 45, 75] as $k => $left)
            <span style="left: {{ $left }}%; animation-delay: -{{ $k * 3 }}s"></span>
        @endforeach
    </div>
    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Open the curtains. <span class="bg-gradient-to-r from-amber-200 to-orange-300 bg-clip-text text-transparent">Keep watching.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us your room size and where the windows are. We'll help you pick the right Yara anti-glare TV.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-amber-400 px-7 py-4 text-sm font-bold text-[#1a1206] transition hover:bg-amber-300">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.category', 'televisions') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                All Yara TVs
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</section>

</div>

@endsection
