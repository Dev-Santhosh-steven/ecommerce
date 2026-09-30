@extends('layouts.store')

@section('title', 'Yara LED Video Walls | Indoor, Outdoor & Rental LED Screens P1.25 to P10')

@push('styles')
    <meta name="description" content="Yara LED video walls from P1.25 fine-pitch indoor to P10 outdoor billboards: up to 7,000 nits, up to 7680 Hz refresh, seamless screens for retail, stages, facades and control rooms. Plan yours with the LED Wall Calculator.">
@endpush

@php
    $vw = fn ($file) => asset("storage/products/video-walls/{$file}");
    $c = fn (...$keys) => array_map(fn ($k) => $vw("content-{$k}.jpg"), $keys);
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in an LED video wall. Please share details and pricing.');

    // LED walls are measured and quoted per project, so every model links to a quote, not a price.
    $quote = fn ($p) => $wa("Hi Yara, I would like a quote for the {$p->name}. My wall size and location: ");

    // Live scenes: screen corners are percentages of each photo (TL TR BR BL).
    $scenes = [
        'times' => ['img' => $vw('scene-times.jpg'), 'fg' => $vw('scene-times-fg.png'), 'alt' => 'Yara outdoor LED billboard on a city square',
            'screens' => [['quad' => '13.315,1.020 80.299,25.340 84.511,64.116 8.152,57.143', 'aspect' => 2]],
            'slides' => $c('yara', 'swirl', 'vivera', 'cosmos', 'sale', 'opening')],
        'cube' => ['img' => $vw('scene-cube.jpg'), 'alt' => 'Yara LED facade wrapping the corner of a flagship store',
            'screens' => [
                ['quad' => '8.036,28.646 62.054,8.333 62.054,45.015 8.036,54.985', 'aspect' => 1, 'part' => [0, 0.5625]],
                ['quad' => '62.054,8.333 94.196,27.753 94.196,57.813 62.054,45.015', 'aspect' => 0.778, 'part' => [0.5625, 1]],
            ],
            'slides' => $c('fluid', 'blossom', 'moon', 'swirl')],
        'retail' => ['img' => $vw('scene-retail.jpg'), 'alt' => 'Yara indoor LED video wall in a fashion store',
            'screens' => [['quad' => '42.993,26.327 88.299,6.939 88.299,74.694 42.993,63.061', 'aspect' => 16 / 9]],
            'slides' => $c('aurora', 'fluid', 'sale', 'vivera')],
        'stage' => ['img' => $vw('scene-stage.jpg'), 'fg' => $vw('scene-stage-fg.png'), 'alt' => 'Yara curved LED wall on a conference stage',
            'screens' => [['box' => '9.75,37.8,89.333,63.333', 'clip' => 'polygon(0% 0.8%, 11% 5.5%, 22.6% 9.4%, 36% 12.5%, 50.6% 13.8%, 63% 12.9%, 75% 11.2%, 88% 6.8%, 99.8% 0%, 100% 100%, 0% 100%)']],
            'slides' => $c('summit', 'lobby', 'yara', 'moon')],
        'studio' => ['img' => $vw('scene-studio.jpg'), 'alt' => 'Broadcast studio with a Yara fine-pitch LED screen',
            'screens' => [['quad' => '39.936,43.645 62.300,43.645 62.300,63.549 39.936,63.549', 'aspect' => 1.69]],
            'slides' => $c('swirl', 'circuit', 'dj', 'fluid')],
        'portals' => ['img' => $vw('scene-portals.jpg'), 'alt' => 'Creative free-standing LED portals',
            'screens' => [
                ['quad' => '14.583,29.094 28.125,36.111 27.344,68.567 13.802,72.368', 'aspect' => 0.42],
                ['quad' => '70.313,43.129 89.844,41.594 91.536,70.760 70.313,68.860', 'aspect' => 0.5],
            ],
            'slides' => $c('cosmos', 'brain', 'circuit', 'vinyl')],
    ];

    $applications = [
        ['key' => 'times', 'label' => 'Billboards', 'icon' => 'building-2', 'title' => 'Own the skyline.', 'text' => 'Sunlight-readable outdoor screens for city squares, highways and building tops. IP65 sealed, auto-dimming at night.', 'pitches' => ['P5', 'P8', 'P10'], 'sku' => 'YE-LED-P8-OUT'],
        ['key' => 'cube', 'label' => 'Facades', 'icon' => 'box', 'title' => 'Wrap the building.', 'text' => 'Corner-wrapping facades that turn a flagship store into a landmark, with content flowing around the edge.', 'pitches' => ['P4', 'P5'], 'sku' => 'YE-LED-P4-OUT'],
        ['key' => 'retail', 'label' => 'Retail', 'icon' => 'shopping-bag', 'title' => 'Sell with light.', 'text' => 'Seamless indoor walls for stores and malls. Change campaigns in seconds and stop shoppers in their tracks.', 'pitches' => ['P1.86', 'P2.5'], 'sku' => 'YE-LED-P25-IN'],
        ['key' => 'stage', 'label' => 'Conferences', 'icon' => 'presentation', 'title' => 'Take the stage.', 'text' => 'Fine-pitch walls, straight or curved, for keynotes, town halls and boardrooms. Sharp on camera at up to 7680 Hz.', 'pitches' => ['P1.25', 'P1.53', 'P1.86'], 'sku' => 'YE-LED-P125-IN'],
        ['key' => 'studio', 'label' => 'Studios', 'icon' => 'video', 'title' => 'Broadcast ready.', 'text' => 'Flicker-free fine-pitch screens for newsrooms, virtual sets and control rooms.', 'pitches' => ['P1.25', 'P1.53'], 'sku' => 'YE-LED-P153-IN'],
        ['key' => 'portals', 'label' => 'Creative', 'icon' => 'sparkles', 'title' => 'Beyond the rectangle.', 'text' => 'Free-standing portals, pillars and sculptural installs for experience centres and brand activations.', 'pitches' => ['P2.5', 'P2.6'], 'sku' => 'YE-LED-P26-IR'],
    ];

    $looks = [$vw('scene-look-moon.jpg'), $vw('scene-arc.jpg'), $vw('scene-look-fan.jpg'), $vw('scene-arc-2.jpg'), $vw('scene-look-carnival.jpg')];

    // Pixel-pitch explorer data, straight from the product specifications.
    $num = fn ($v) => (float) preg_replace('/[^\d.]/', '', (string) $v);
    $range = $products->map(fn ($p) => [
        'name' => $p->name,
        'pitch' => $num($p->specifications['Pixel Pitch'] ?? 0),
        'nits' => (int) $num($p->specifications['Brightness'] ?? 0),
        'refresh' => $p->specifications['Refresh Rate'] ?? '',
        'app' => $p->specifications['Application'] ?? '',
        'outdoor' => str_contains(strtolower($p->specifications['Application'] ?? ''), 'outdoor'),
        'quote' => $quote($p),
        'img' => $p->primaryImage ? asset('storage/' . $p->primaryImage->image) : '',
    ])->sortBy('pitch')->values();
    $bySku = $products->keyBy('sku');
    $maxNits = max(1, $range->max('nits'));
@endphp

@section('content')

<div class="overflow-x-clip bg-[#05060a] text-white">

{{-- =========================================================
     HERO — live billboard
========================================================= --}}
<section class="relative isolate overflow-hidden pb-16 pt-12 sm:pt-16">

    <div class="absolute inset-0 -z-10">
        <div class="about-grid absolute inset-0 opacity-50"></div>
        <div class="about-blob -left-40 top-10 h-[34rem] w-[34rem] bg-brand-800"></div>
        <div class="about-blob -right-32 bottom-0 h-[30rem] w-[30rem] bg-indigo-700/50 [animation-delay:-5s]"></div>
    </div>

    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                LED Video Walls
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.02] sm:text-7xl">
                Brilliance at<br><span class="about-gradient-text">every pixel.</span>
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Seamless LED screens of any size, from P1.25 fine-pitch boardrooms to P10 billboards you can see from the highway.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="#pitch" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                    Find your pixel pitch
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ route('store.led-calculator') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i data-lucide="calculator" class="h-4 w-4"></i>
                    LED Wall Calculator
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -inset-6 rounded-[2.5rem] bg-gradient-to-tr from-brand-600/30 via-fuchsia-500/20 to-indigo-500/30 blur-3xl"></div>
            <div class="centum-hero-tv relative overflow-hidden rounded-[2rem] shadow-2xl shadow-black/60 ring-1 ring-white/10">
                @include('store.partials.live-scene', ['scene' => $scenes['times'], 'interval' => 4000, 'eager' => true])
                <div class="pointer-events-none absolute inset-x-0 bottom-0 z-20 flex items-end justify-between gap-3 bg-gradient-to-t from-black/80 to-transparent p-5">
                    <span class="inline-flex items-center gap-2 rounded-full bg-black/60 px-3 py-1.5 text-xs font-semibold backdrop-blur">
                        <span class="about-pulse h-2 w-2 rounded-full bg-red-500"></span>
                        Live · P8 outdoor
                    </span>
                    <span class="text-xs text-gray-300">7,000 nits · IP65</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Headline figures --}}
    <div class="mx-auto mt-14 grid max-w-[1500px] grid-cols-2 gap-px overflow-hidden rounded-3xl bg-white/10 px-0 sm:mx-6 lg:mx-auto lg:grid-cols-4"
         x-data="{ go: false }" x-init="new IntersectionObserver(([e], o) => { if (e.isIntersecting) { go = true; o.disconnect() } }).observe($el)">
        @foreach ([
            ['P1.25', 'to P10', 'Pixel pitch range'],
            [number_format($maxNits), 'nits', 'Peak outdoor brightness'],
            ['7680', 'Hz', 'Refresh rate (up to)'],
            [$products->count(), 'models', 'Indoor · outdoor · rental'],
        ] as $k => [$big, $unit, $label])
            <div class="bg-[#05060a] p-6 text-center transition-all duration-700 sm:p-8"
                 :class="go ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'" style="transition-delay: {{ $k * 120 }}ms">
                <p class="font-display text-4xl font-extrabold sm:text-5xl">{{ $big }}<span class="ml-1 text-base font-semibold text-brand-400">{{ $unit }}</span></p>
                <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">{{ $label }}</p>
            </div>
        @endforeach
    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#05060a]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara LED Video Walls</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">P1.25 – P10 · Indoor · Outdoor · Rental</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#pitch" class="transition hover:text-white">Pixel pitch</a>
            <a href="#applications" class="transition hover:text-white">Applications</a>
            <a href="#stages" class="transition hover:text-white">Stages</a>
            <a href="#range" class="transition hover:text-white">Range</a>
            <a href="#lcd" class="transition hover:text-white">LCD walls</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Get a quote</a>
    </div>
</div>


{{-- =========================================================
     PIXEL PITCH EXPLORER
========================================================= --}}
<section id="pitch" class="scroll-mt-32 bg-white py-24 text-gray-900"
         x-data="{ range: @js($range), k: 3, get m() { return this.range[this.k] } }">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Pixel pitch explorer</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Closer viewers need <span class="text-brand-600">finer pixels.</span></h2>
            <p class="mt-4 text-lg text-gray-600">Slide through the range to see how pitch changes the picture, the best viewing distance and the brightness.</p>
        </div>

        <div class="mt-14 grid items-center gap-10 lg:grid-cols-[1.25fr_1fr]">

            {{-- preview: the picture through LED dots, sized to the pitch --}}
            <div class="relative overflow-hidden rounded-[2rem] bg-black shadow-2xl shadow-gray-900/20" data-reveal="left">
                <img src="{{ $vw('content-cosmos.jpg') }}" alt="" class="vw-dots aspect-[16/9] w-full object-cover" :style="`--dot: ${Math.max(3, m.pitch * 3.2)}px`">
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                <div class="absolute left-5 top-5 rounded-full bg-black/60 px-4 py-2 font-display text-2xl font-extrabold text-white backdrop-blur" x-text="'P' + m.pitch"></div>
                <div class="absolute inset-x-5 bottom-5 flex flex-wrap items-center justify-between gap-3 text-white">
                    <span class="text-sm" x-text="m.app"></span>
                    <span class="rounded-full bg-white/15 px-3 py-1 text-xs font-semibold backdrop-blur" x-text="m.outdoor ? 'Outdoor · IP65' : 'Indoor'"></span>
                </div>
            </div>

            <div data-reveal="right">
                <input type="range" min="0" :max="range.length - 1" step="1" x-model.number="k" class="w-full accent-brand-600" aria-label="Pixel pitch">
                <div class="mt-2 flex justify-between text-[11px] font-semibold text-gray-400">
                    <template x-for="(r, idx) in range" :key="r.pitch + r.app">
                        <button type="button" @click="k = idx" :class="k === idx && 'text-brand-600'" x-text="'P' + r.pitch"></button>
                    </template>
                </div>

                <h3 class="mt-8 text-2xl font-bold" x-text="m.name"></h3>

                <dl class="mt-6 grid grid-cols-2 gap-4">
                    <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-200">
                        <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Best viewed from</dt>
                        <dd class="mt-1 font-display text-3xl font-extrabold"><span x-text="(m.pitch * 2).toFixed(1).replace('.0', '')"></span>–<span x-text="(m.pitch * 3).toFixed(1).replace('.0', '')"></span> <span class="text-base font-semibold text-gray-500">m</span></dd>
                    </div>
                    <div class="rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-200">
                        <dt class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Refresh</dt>
                        <dd class="mt-1 font-display text-3xl font-extrabold" x-text="m.refresh"></dd>
                    </div>
                    <div class="col-span-2 rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-200">
                        <dt class="flex justify-between text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Brightness <span class="text-gray-900" x-text="m.nits.toLocaleString() + ' nits'"></span></dt>
                        <dd class="mt-3 h-2.5 overflow-hidden rounded-full bg-gray-200">
                            <div class="h-full rounded-full bg-gradient-to-r from-amber-400 via-orange-500 to-brand-600 transition-all duration-700" :style="`width: ${m.nits / {{ $maxNits }} * 100}%`"></div>
                        </dd>
                    </div>
                </dl>

                <div class="mt-6 flex flex-wrap items-center gap-4">
                    <p class="text-lg font-semibold text-gray-700">Price on request</p>
                    <a :href="m.quote" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">
                        Get a quote <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                    <a href="{{ route('store.led-calculator') }}" class="text-sm font-semibold text-brand-600 hover:underline">Size it in the calculator</a>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
     APPLICATIONS — live scenes
========================================================= --}}
<section id="applications" class="relative scroll-mt-32 overflow-hidden py-24"
         x-data="{ a: 0 }">

    <div class="about-blob -right-24 top-1/4 h-96 w-96 bg-brand-800"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Applications</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Anywhere people <span class="about-gradient-text">look up.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Every screen below is live. Pick a space to see a Yara LED wall at work.</p>
        </div>

        <div class="mt-10 flex flex-wrap gap-2" data-reveal>
            @foreach ($applications as $k => $app)
                <button type="button" @click="a = {{ $k }}"
                        class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition"
                        :class="a === {{ $k }} ? 'bg-white text-gray-900' : 'bg-white/5 text-gray-300 ring-1 ring-white/10 hover:bg-white/10'">
                    <i data-lucide="{{ $app['icon'] }}" class="h-4 w-4"></i>
                    {{ $app['label'] }}
                </button>
            @endforeach
        </div>

        <div class="mt-10">
            @foreach ($applications as $k => $app)
                @php $product = $bySku[$app['sku']] ?? null; @endphp
                <div x-show="a === {{ $k }}" @if ($k > 0) x-cloak @endif
                     x-transition:enter="transition duration-700 ease-out" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                     class="grid items-center gap-10 lg:grid-cols-[1.35fr_1fr]">
                    <div class="mx-auto w-full {{ in_array($app['key'], ['cube', 'portals', 'stage'], true) ? 'max-w-md lg:max-w-lg' : '' }} overflow-hidden rounded-[2rem] ring-1 ring-white/10">
                        @include('store.partials.live-scene', ['scene' => $scenes[$app['key']], 'interval' => 4200 + $k * 150])
                    </div>
                    <div>
                        <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red text-white shadow-lg shadow-brand-950/50">
                            <i data-lucide="{{ $app['icon'] }}" class="h-7 w-7"></i>
                        </span>
                        <h3 class="mt-6 text-4xl font-bold">{{ $app['title'] }}</h3>
                        <p class="mt-4 text-lg text-gray-300">{{ $app['text'] }}</p>
                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach ($app['pitches'] as $pitch)
                                <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-semibold">{{ $pitch }}</span>
                            @endforeach
                        </div>
                        @if ($product)
                            <a href="{{ $quote($product) }}" target="_blank" rel="noopener noreferrer" class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition hover:bg-brand-500">
                                Get a quote for {{ str($product->name)->after('Yara ')->before(' LED') }}
                                <i data-lucide="arrow-right" class="h-4 w-4"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>


{{-- =========================================================
     STAGES — pixel-dissolve showcase
========================================================= --}}
<section id="stages" class="scroll-mt-32 bg-black py-24">
    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-[1fr_1.4fr] lg:px-10">

        <div data-reveal="left">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Rental & events</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">A new stage, <span class="about-gradient-text">every night.</span></h2>
            <p class="mt-5 text-lg text-gray-300">Tool-less rental cabinets lock together in minutes. Build flat, curved or stepped stages, then change the whole look with a click.</p>
            <ul class="mt-8 space-y-3 text-gray-300">
                @foreach (['Quick-lock die-cast cabinets', 'Curved and right-angle builds', 'Front & rear service', 'Indoor P2.6 · outdoor P3.91'] as $point)
                    <li class="flex items-center gap-3"><i data-lucide="circle-check" class="h-5 w-5 shrink-0 text-brand-400"></i>{{ $point }}</li>
                @endforeach
            </ul>
            <div class="mt-8 flex flex-wrap gap-3">
                @foreach (['YE-LED-P26-IR', 'YE-LED-P391-OR'] as $sku)
                    @if ($p = $bySku[$sku] ?? null)
                        <a href="{{ $quote($p) }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-semibold transition hover:bg-white/10">{{ str($p->name)->after('Yara ') }}</a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="relative overflow-hidden rounded-[2rem] ring-1 ring-white/10" data-reveal="right" data-no-auto-reveal
             x-data="pixelDissolve(@js($looks), 16, 9, 4200)">
            <img :src="@js($looks)[current]" src="{{ $looks[0] }}" alt="Yara LED stage designs" class="block aspect-[16/9] w-full object-cover">
            <div class="absolute inset-0 grid" style="grid-template-columns: repeat(16, 1fr); grid-template-rows: repeat(9, 1fr)">
                <template x-for="t in tiles" :key="t.k">
                    <div class="vw-tile" :class="fading && 'is-on'" :style="tileStyle(t)"></div>
                </template>
            </div>
            <div class="vw-scanline pointer-events-none absolute inset-0 opacity-40"></div>
            <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="absolute bottom-5 right-5 w-20 opacity-80">
        </div>

    </div>
</section>


{{-- =========================================================
     THE RANGE
========================================================= --}}
<section id="range" class="scroll-mt-32 bg-[#f4f4f5] py-24 text-gray-900" x-data="{ f: 'all' }">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col items-center justify-between gap-6 text-center md:flex-row md:items-end md:text-left" data-reveal>
            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">The range</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Ten walls. <span class="text-brand-600">One for every space.</span></h2>
            </div>
            <div class="inline-flex rounded-full bg-white p-1 text-sm font-semibold shadow-sm ring-1 ring-gray-200">
                @foreach (['all' => 'All', 'indoor' => 'Indoor', 'outdoor' => 'Outdoor', 'rental' => 'Rental'] as $key => $label)
                    <button type="button" @click="f = '{{ $key }}'" class="rounded-full px-5 py-2 transition" :class="f === '{{ $key }}' ? 'bg-gray-900 text-white' : 'text-gray-600 hover:text-gray-900'">{{ $label }}</button>
                @endforeach
            </div>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($products as $i => $product)
                @php
                    $app = strtolower($product->specifications['Application'] ?? '');
                    $tags = trim((str_contains($app, 'outdoor') ? 'outdoor' : 'indoor') . (str_contains($app, 'rental') ? ' rental' : ''));
                    $pitch = $product->specifications['Pixel Pitch'] ?? '';
                @endphp
                <a href="{{ $quote($product) }}" target="_blank" rel="noopener noreferrer" x-show="f === 'all' || '{{ $tags }}'.split(' ').includes(f)" x-transition.opacity
                   class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative aspect-square overflow-hidden">
                        <img src="{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image) : '' }}" alt="{{ $product->name }}" loading="lazy"
                             class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                        <span class="absolute left-3 top-3 rounded-full bg-black/70 px-3 py-1 font-display text-sm font-extrabold text-white backdrop-blur">P{{ str_replace(' mm', '', $pitch) }}</span>
                    </div>
                    <div class="p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.15em] text-brand-600">{{ $product->specifications['Application'] ?? '' }}</p>
                        <p class="mt-1 font-bold leading-snug">{{ $product->name }}</p>
                        <p class="mt-2 text-sm text-gray-500">{{ $product->specifications['Brightness'] ?? '' }} · {{ $product->specifications['Refresh Rate'] ?? '' }}</p>
                        <p class="mt-3 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600">Get a quote <i data-lucide="arrow-right" class="h-4 w-4"></i></p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- calculator CTA --}}
        <a href="{{ route('store.led-calculator') }}" data-reveal
           class="group mt-14 flex flex-col items-center justify-between gap-6 overflow-hidden rounded-[2rem] bg-gray-900 p-8 text-white sm:flex-row sm:p-10">
            <div class="flex items-center gap-5">
                <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-brand-600">
                    <i data-lucide="calculator" class="h-8 w-8"></i>
                </span>
                <div>
                    <p class="text-2xl font-bold">Plan your screen in 60 seconds</p>
                    <p class="mt-1 text-gray-400">Enter the wall size and get cabinets, resolution and power, then request your quote.</p>
                </div>
            </div>
            <span class="inline-flex shrink-0 items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition group-hover:bg-brand-600 group-hover:text-white">
                Open the LED Wall Calculator
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </span>
        </a>

    </div>
</section>


{{-- =========================================================
     LCD VIDEO WALLS — cross-promotion
========================================================= --}}
<section id="lcd" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-grid absolute inset-0 opacity-50"></div>
    <div class="relative mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">
        <div data-reveal="left">
            <p class="inline-flex items-center gap-2 text-sm font-semibold uppercase tracking-[0.3em] text-sky-400">
                <span class="about-pulse h-2 w-2 rounded-full bg-sky-400"></span>
                New
            </p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Need it sharper, <span class="bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent">up close?</span></h2>
            <p class="mt-5 text-lg text-gray-300">Yara LCD video walls put Full HD in every panel, with bezels as thin as 0.88 mm. They're ideal for control rooms, dashboards and anything people read from a few steps away.</p>
            <a href="{{ route('store.lcdwalls') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-sky-500 px-7 py-4 text-sm font-semibold text-white transition hover:bg-sky-400">
                Explore LCD Video Walls
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
        <div class="relative" data-reveal="right">
            <div class="absolute inset-[10%] rounded-full bg-sky-500/20 blur-3xl"></div>
            <img src="{{ asset('storage/products/lcd-video-walls/lcd-hero.png') }}" alt="Yara LCD video wall" loading="lazy" class="about-float relative w-full">
        </div>
    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative overflow-hidden bg-black py-28 text-center">
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-brand-700"></div>
    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Let's light up <span class="about-gradient-text">your space.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Share the wall size and where it goes. Our team will recommend the pitch and send a complete quote with design, installation and support.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Get a quote on WhatsApp
            </a>
            <a href="{{ route('store.led-calculator') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                <i data-lucide="calculator" class="h-4 w-4"></i>
                Measure your wall
            </a>
        </div>
    </div>
</section>

</div>

@endsection
