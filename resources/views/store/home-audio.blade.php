@extends('layouts.store')

@section('title', 'Yara Home Audio | Tower Speakers & Soundbars')

@push('styles')
    <meta name="description" content="Yara home audio: twin tower multimedia speakers, single tower speakers and soundbars with subwoofer. Deep bass, Bluetooth and USB playback for music, movies and parties.">
@endpush

@php
    $base = fn ($file) => asset("storage/products/home-audio/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in your home audio speakers. Please share details and pricing.');
    $bySku = $products->keyBy('sku');

    // One spotlight per family: cut-out, backdrop, hotspots (x%, y% on the cut-out), bass rings, details.
    $spotlights = [
        [
            'id' => 'twin', 'sku' => 'YE-HA-TT01', 'cut' => 'cut-twin-tower.png', 'bg' => 'mood-vinyl.jpg',
            'category' => 'twin-tower-speakers', 'eyebrow' => 'Twin Tower Multimedia Speaker',
            'title' => 'Two towers.', 'accent' => 'True stereo.',
            'text' => 'A matched pair with a driver and tweeter in each tower, and a big side-firing bass driver that fills the whole room.',
            'width' => 'max-w-[34rem]',
            'rings' => [[14.1, 83.2, '16%'], [86.2, 83.2, '16%'], [37.9, 68.8, '22%'], [61, 68.8, '22%']],
            'hotspots' => [
                [14.1, 16.7, 'Full-range driver', 'Clear vocals and instruments from each tower.'],
                [16.5, 35.4, 'Tweeter', 'Crisp, detailed highs.'],
                [37.9, 68.8, 'Side-firing bass', 'A large bass driver on each tower.'],
                [86.2, 57.9, 'Control panel', 'USB, mode, track and volume keys.'],
                [86.2, 83.2, 'Bass port', 'Tuned port for deeper, cleaner bass.'],
            ],
            'details' => ['detail-twin-drivers.jpg', 'detail-twin-controls.jpg', 'life-twin-bass.jpg'],
        ],
        [
            'id' => 'single', 'sku' => 'YE-HA-ST01', 'cut' => 'cut-single-tower.png', 'bg' => 'mood-party.jpg',
            'category' => 'single-tower-speakers', 'eyebrow' => 'Single Tower Speaker',
            'title' => 'Slim tower.', 'accent' => 'Big bass.',
            'text' => 'Twin front drivers, a side-firing woofer and an LED display, all in one slim tower that fits any corner.',
            'width' => 'max-w-[15rem]',
            'rings' => [[22.5, 85.1, '34%'], [72.3, 70.2, '46%']],
            'hotspots' => [
                [14.5, 4.0, 'LED display', 'See Bluetooth, USB or AUX at a glance.'],
                [20.9, 18.9, 'Metal volume knob', 'Precise, satisfying control.'],
                [22.5, 42.9, 'Twin drivers', 'Two front drivers for balanced sound.'],
                [72.3, 70.2, 'Side-firing woofer', 'Punchy bass from a slim tower.'],
                [22.5, 85.1, 'Bass port', 'Adds depth to every beat.'],
            ],
            'details' => ['detail-single-panel.jpg', 'detail-single-drivers.jpg', 'life-single-cosmos.jpg'],
        ],
        [
            'id' => 'soundbar', 'sku' => 'YE-HA-SB01', 'cut' => 'cut-soundbar.png', 'bg' => 'mood-movies.jpg',
            'category' => 'soundbars', 'eyebrow' => 'Soundbar with Subwoofer',
            'title' => 'Your TV,', 'accent' => 'now a theatre.',
            'text' => 'A slim soundbar for clear dialogue, and a dedicated subwoofer for the rumble that makes movies and match days feel real.',
            'width' => 'max-w-[36rem]',
            'rings' => [[76.0, 41.3, '24%'], [55.9, 57.3, '16%']],
            'hotspots' => [
                [64.9, 73.7, 'Slim soundbar', 'Fits neatly under your TV.'],
                [55.9, 19.8, 'Control panel', 'Source and volume keys on the subwoofer.'],
                [76.0, 41.3, 'Side-firing woofer', 'Deep, cinematic bass.'],
                [55.9, 57.3, 'Bass port', 'Tuned for clean low-end.'],
            ],
            'details' => ['life-soundbar-cinema.jpg', 'life-soundbar-city.jpg'],
        ],
    ];

    $moods = [
        ['key' => 'music', 'img' => 'mood-music.jpg', 'icon' => 'music', 'label' => 'Music', 'title' => 'Every note, in gold.', 'text' => 'Rich mids and sparkling highs for the playlists you love.', 'pick' => 'twin'],
        ['key' => 'movies', 'img' => 'mood-movies.jpg', 'icon' => 'clapperboard', 'label' => 'Movies', 'title' => 'Feel the scene.', 'text' => 'Clear dialogue up front, cinematic bass underneath.', 'pick' => 'soundbar'],
        ['key' => 'party', 'img' => 'mood-party.jpg', 'icon' => 'party-popper', 'label' => 'Party', 'title' => 'Turn the room up.', 'text' => 'Bluetooth or USB, side-firing bass and volume to spare.', 'pick' => 'single'],
        ['key' => 'chill', 'img' => 'mood-chill.jpg', 'icon' => 'headphones', 'label' => 'Chill', 'title' => 'Sound that relaxes.', 'text' => 'Warm, balanced sound for slow evenings at home.', 'pick' => 'twin'],
    ];
    $picks = collect($spotlights)->keyBy('id');
@endphp

@section('content')

<div class="ha-page overflow-x-clip bg-[#070605] text-white">

{{-- =========================================================
     HERO — sound-reactive stage
========================================================= --}}
<section class="relative isolate flex min-h-[calc(100vh-4.25rem)] flex-col overflow-hidden" x-data="yaraBeat">

    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="{{ $base('mood-bass.jpg') }}" alt="" class="ha-kenburns h-full w-full object-cover opacity-40">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_65%_55%,transparent_0%,rgba(7,6,5,0.75)_55%,#070605_85%)]"></div>
        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-[#070605] to-transparent"></div>
    </div>

    {{-- gold dust --}}
    <div class="ha-dust pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        @foreach (range(1, 28) as $n)
            <span style="left: {{ ($n * 37) % 100 }}%; --s: {{ 2 + ($n % 3) }}px; --d: {{ 9 + ($n % 7) * 1.7 }}s; --delay: -{{ ($n * 1.3) % 14 }}s; --x: {{ (($n % 5) - 2) * 30 }}px; --o: {{ 0.4 + ($n % 4) * 0.15 }}"></span>
        @endforeach
    </div>

    <div class="relative mx-auto grid w-full max-w-[1500px] flex-1 items-center gap-10 px-4 pb-8 pt-12 sm:px-6 lg:grid-cols-[1fr_1.1fr] lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-[#f5b54a]/30 bg-[#f5b54a]/10 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-[#ffd88a] backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Home Audio
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.02] sm:text-7xl xl:text-8xl">
                Feel every<br><span class="ha-gold-text">beat.</span>
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Tower speakers and soundbars with deep, room-filling bass. Built for music, movies and every party in between.
            </p>

            <div class="mt-9 flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                <button type="button" @click="toggle()"
                        class="group inline-flex items-center gap-3 rounded-full bg-gradient-to-r from-[#c8922f] via-[#f5b54a] to-[#ffd88a] py-2 pl-2 pr-7 text-sm font-bold text-[#1a1206] shadow-[0_10px_40px_-10px_rgba(245,181,74,0.7)] transition hover:brightness-110">
                    <span class="relative flex h-11 w-11 items-center justify-center rounded-full bg-[#1a1206] text-[#ffd88a]">
                        <span x-show="! playing"><i data-lucide="play" class="h-5 w-5 translate-x-0.5"></i></span>
                        <span x-show="playing" x-cloak><i data-lucide="pause" class="h-5 w-5"></i></span>
                    </span>
                    <span x-text="playing ? 'Stop the beat' : 'Play the demo beat'">Play the demo beat</span>
                </button>
                <a href="#collection" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                    Explore the range
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
            </div>
            <p class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500 lg:justify-start">
                <i data-lucide="volume-2" class="h-3.5 w-3.5"></i>
                Sound on. The speakers pulse with the bass.
            </p>
        </div>

        {{-- Stage --}}
        <div class="relative mx-auto w-full max-w-2xl">
            <div class="ha-glow absolute inset-[8%] rounded-full bg-[#f5b54a]/30 blur-[90px]"></div>
            <svg class="ha-spin absolute -right-6 -top-6 h-28 w-28 text-[#f5b54a]/40 sm:h-36 sm:w-36" viewBox="0 0 100 100" aria-hidden="true">
                <circle cx="50" cy="50" r="48" fill="#0d0b09" stroke="currentColor" stroke-width="1"/>
                @foreach ([40, 34, 28, 22] as $r)
                    <circle cx="50" cy="50" r="{{ $r }}" fill="none" stroke="currentColor" stroke-width="0.5" opacity="0.6"/>
                @endforeach
                <circle cx="50" cy="50" r="12" fill="#f5b54a"/>
                <circle cx="50" cy="50" r="2" fill="#0d0b09"/>
                <path d="M50 2 A48 48 0 0 1 90 25" stroke="#ffd88a" stroke-width="1.5" fill="none" opacity="0.8"/>
            </svg>

            <div class="centum-hero-tv relative">
                <div class="ha-thump relative">
                    <img src="{{ $base('cut-twin-tower.png') }}" alt="Yara Twin Tower Multimedia Speaker" class="relative w-full">
                    @foreach ($spotlights[0]['rings'] as [$x, $y, $w])
                        <span class="ha-woofer" style="left: {{ $x }}%; top: {{ $y }}%; --w: {{ $w }}"></span>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    {{-- Equaliser --}}
    <div class="relative mx-auto w-full max-w-[1500px] px-4 pb-8 sm:px-6 lg:px-10">
        <div x-ref="eq" class="ha-eq is-idle flex h-16 items-end gap-1 opacity-80 sm:h-20 sm:gap-1.5" aria-hidden="true">
            @foreach (range(1, 48) as $n)
                <span style="--delay: -{{ ($n * 0.37) % 1.6 }}s; --peak: {{ 30 + (($n * 53) % 65) }}%"></span>
            @endforeach
        </div>
    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#070605]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Home Audio</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Twin Tower · Single Tower · Soundbar · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#twin" class="transition hover:text-[#ffd88a]">Twin Tower</a>
            <a href="#single" class="transition hover:text-[#ffd88a]">Single Tower</a>
            <a href="#soundbar" class="transition hover:text-[#ffd88a]">Soundbar</a>
            <a href="#moods" class="transition hover:text-[#ffd88a]">Moods</a>
            <a href="#compare" class="transition hover:text-[#ffd88a]">Compare</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-[#f5b54a] px-5 py-2.5 text-sm font-bold text-[#1a1206] transition hover:bg-[#ffd88a]">Enquire</a>
    </div>
</div>


{{-- =========================================================
     COLLECTION — tilt cards
========================================================= --}}
<section id="collection" class="relative scroll-mt-32 py-24">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#f5b54a]">The collection</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Three ways to <span class="ha-gold-text">fill the room.</span></h2>
        </div>

        <div class="mt-14 grid gap-6 md:grid-cols-3">
            @foreach ($spotlights as $i => $s)
                @php $product = $bySku[$s['sku']] ?? null; @endphp
                <a href="#{{ $s['id'] }}" data-reveal style="--reveal-delay: {{ $i * 130 }}ms"
                   x-data="{ rx: 0, ry: 0 }"
                   @mousemove="const r = $el.getBoundingClientRect(); ry = (($event.clientX - r.left) / r.width - 0.5) * 12; rx = -(($event.clientY - r.top) / r.height - 0.5) * 12"
                   @mouseleave="rx = 0; ry = 0"
                   :style="`--rx: ${rx}deg; --ry: ${ry}deg`"
                   class="ha-tilt group relative flex flex-col overflow-hidden rounded-[2rem] border border-white/10 bg-gradient-to-b from-[#1a1510] to-[#0b0a08] p-7 transition-colors hover:border-[#f5b54a]/40">
                    <div class="absolute inset-x-10 top-16 h-40 rounded-full bg-[#f5b54a]/0 blur-3xl transition duration-700 group-hover:bg-[#f5b54a]/25"></div>
                    <div class="ha-pop relative flex h-72 items-end justify-center">
                        <img src="{{ $base($s['cut']) }}" alt="{{ $product?->name ?? $s['eyebrow'] }}" loading="lazy"
                             class="max-h-full w-auto max-w-full drop-shadow-[0_25px_25px_rgba(0,0,0,0.8)] transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.04]">
                    </div>
                    <div class="ha-pop relative mt-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#f5b54a]">{{ $s['eyebrow'] }}</p>
                        <h3 class="mt-2 text-2xl font-bold">{{ $s['title'] }} {{ $s['accent'] }}</h3>
                        <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-gray-300 transition group-hover:text-[#ffd88a]">
                            Discover
                            <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>


{{-- Sound-wave divider --}}
<div class="relative h-24 overflow-hidden" aria-hidden="true">
    <svg class="ha-wave-flow absolute inset-y-0 left-0 h-full w-[200%]" viewBox="0 0 2400 100" preserveAspectRatio="none">
        <path d="M0 50 Q 75 5 150 50 T 300 50 T 450 50 T 600 50 T 750 50 T 900 50 T 1050 50 T 1200 50 T 1350 50 T 1500 50 T 1650 50 T 1800 50 T 1950 50 T 2100 50 T 2250 50 T 2400 50" fill="none" stroke="#f5b54a" stroke-opacity="0.5" stroke-width="2"/>
        <path d="M0 50 Q 37 80 75 50 T 150 50 T 225 50 T 300 50 T 375 50 T 450 50 T 525 50 T 600 50 T 675 50 T 750 50 T 825 50 T 900 50 T 975 50 T 1050 50 T 1125 50 T 1200 50 T 1275 50 T 1350 50 T 1425 50 T 1500 50 T 1575 50 T 1650 50 T 1725 50 T 1800 50 T 1875 50 T 1950 50 T 2025 50 T 2100 50 T 2175 50 T 2250 50 T 2325 50 T 2400 50" fill="none" stroke="#ffd88a" stroke-opacity="0.25" stroke-width="1.5"/>
    </svg>
</div>


{{-- =========================================================
     SPOTLIGHTS — one per family, with hotspots
========================================================= --}}
@foreach ($spotlights as $i => $s)
    @php $product = $bySku[$s['sku']] ?? null; @endphp
    @continue(! $product)

    <section id="{{ $s['id'] }}" class="relative isolate scroll-mt-32 overflow-hidden py-24 lg:py-32" x-data="{ active: null }">

        <div class="absolute inset-0 -z-10 overflow-hidden">
            <img src="{{ $base($s['bg']) }}" alt="" loading="lazy" class="ha-kenburns h-full w-full object-cover opacity-25" style="animation-delay: -{{ $i * 7 }}s">
            <div class="absolute inset-0 bg-gradient-to-b from-[#070605] via-[#070605]/70 to-[#070605]"></div>
        </div>

        <div class="mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

            {{-- product with hotspots --}}
            <div class="relative {{ $i % 2 ? 'lg:order-2' : '' }}" data-reveal="{{ $i % 2 ? 'right' : 'left' }}">
                <div class="absolute inset-[10%] rounded-full bg-[#f5b54a]/15 blur-[80px]"></div>
                <div class="relative mx-auto {{ $s['width'] }}">
                    <img src="{{ $base($s['cut']) }}" alt="{{ $product->name }}" loading="lazy" class="relative w-full drop-shadow-[0_40px_40px_rgba(0,0,0,0.8)]">
                    @foreach ($s['rings'] as [$x, $y, $w])
                        <span class="ha-woofer" style="left: {{ $x }}%; top: {{ $y }}%; --w: {{ $w }}"></span>
                    @endforeach
                    @foreach ($s['hotspots'] as $k => [$x, $y, $label, $desc])
                        <div class="ha-hotspot z-10" style="left: {{ $x }}%; top: {{ $y }}%">
                            <button type="button" @mouseenter="active = {{ $k }}" @mouseleave="active = null" @click="active = active === {{ $k }} ? null : {{ $k }}"
                                    :aria-expanded="active === {{ $k }}" aria-label="{{ $label }}">
                                <i data-lucide="plus" class="h-3.5 w-3.5"></i>
                            </button>
                            <div x-show="active === {{ $k }}" x-cloak x-transition.opacity.duration.200ms
                                 class="absolute left-1/2 top-full z-20 mt-3 w-52 -translate-x-1/2 rounded-2xl border border-[#f5b54a]/30 bg-black/85 p-4 text-left shadow-2xl backdrop-blur">
                                <p class="text-sm font-bold text-[#ffd88a]">{{ $label }}</p>
                                <p class="mt-1 text-xs leading-5 text-gray-300">{{ $desc }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- copy --}}
            <div class="{{ $i % 2 ? 'lg:order-1' : '' }}" data-reveal="{{ $i % 2 ? 'left' : 'right' }}">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#f5b54a]">{{ $s['eyebrow'] }}</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-6xl">{{ $s['title'] }}<br><span class="ha-gold-text">{{ $s['accent'] }}</span></h2>
                <p class="mt-5 max-w-xl text-lg text-gray-300">{{ $s['text'] }}</p>

                {{-- hotspot list mirrors the dots on the product --}}
                <ul class="mt-8 grid gap-2 sm:grid-cols-2">
                    @foreach ($s['hotspots'] as $k => [$x, $y, $label, $desc])
                        <li @mouseenter="active = {{ $k }}" @mouseleave="active = null"
                            class="flex cursor-default items-center gap-3 rounded-xl border px-4 py-3 text-sm transition"
                            :class="active === {{ $k }} ? 'border-[#f5b54a]/50 bg-[#f5b54a]/10 text-white' : 'border-white/10 text-gray-300'">
                            <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#f5b54a]/15 text-xs font-bold text-[#ffd88a]">{{ $k + 1 }}</span>
                            {{ $label }}
                        </li>
                    @endforeach
                </ul>

                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach ([['bluetooth', 'Bluetooth'], ['usb', 'USB'], ['cable', 'AUX']] as [$icon, $label])
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-xs font-semibold text-gray-200">
                            <i data-lucide="{{ $icon }}" class="h-4 w-4 text-[#f5b54a]"></i>
                            {{ $label }}
                        </span>
                    @endforeach
                </div>

                <div class="mt-8 flex gap-3">
                    @foreach ($s['details'] as $k => $detail)
                        <a href="{{ route('store.product', $product) }}" class="group block h-20 w-20 overflow-hidden rounded-2xl ring-1 ring-white/10 transition hover:ring-[#f5b54a]/60 sm:h-24 sm:w-24">
                            <img src="{{ $base($detail) }}" alt="{{ $product->name }} detail" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                        </a>
                    @endforeach
                </div>

                <div class="mt-9 flex flex-wrap gap-3">
                    <a href="{{ route('store.product', $product) }}" class="inline-flex items-center gap-2 rounded-full bg-[#f5b54a] px-7 py-3.5 text-sm font-bold text-[#1a1206] transition hover:bg-[#ffd88a]">
                        View details
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                    <a href="{{ $wa("Hi Yara, I am interested in the {$product->name}. Please share the price.") }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>
                        Enquire
                    </a>
                    <a href="{{ route('store.category', $s['category']) }}" class="inline-flex items-center gap-2 px-2 py-3.5 text-sm font-semibold text-gray-400 transition hover:text-[#ffd88a]">
                        See all
                    </a>
                </div>
            </div>

        </div>
    </section>
@endforeach


{{-- =========================================================
     MOODS — full-bleed backdrops that crossfade
========================================================= --}}
<section id="moods" class="relative isolate scroll-mt-32 overflow-hidden"
         x-data="{ i: 0, n: {{ count($moods) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 5000) }, pick(k) { this.i = k; this.start() } }"
         x-init="start()">

    <div class="absolute inset-0 -z-10" data-no-auto-reveal>
        @foreach ($moods as $k => $mood)
            <img src="{{ $base($mood['img']) }}" alt="" loading="lazy"
                 class="ha-kenburns absolute inset-0 h-full w-full object-cover transition-opacity duration-[1400ms]"
                 :class="i === {{ $k }} ? 'opacity-60' : 'opacity-0'" @if ($k > 0) style="opacity: 0" @endif :style="''">
        @endforeach
        <div class="absolute inset-0 bg-gradient-to-r from-[#070605] via-[#070605]/80 to-[#070605]/20"></div>
        <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-[#070605] to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-[#070605] to-transparent"></div>
    </div>

    <div class="mx-auto grid min-h-[38rem] max-w-[1500px] items-center gap-10 px-4 py-24 sm:px-6 lg:grid-cols-[1.1fr_1fr] lg:px-10">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#f5b54a]" data-reveal>Sound for every moment</p>

            <div class="mt-6 flex flex-wrap gap-2" data-reveal>
                @foreach ($moods as $k => $mood)
                    <button type="button" @click="pick({{ $k }})"
                            class="relative inline-flex items-center gap-2 overflow-hidden rounded-full px-5 py-2.5 text-sm font-semibold backdrop-blur transition"
                            :class="i === {{ $k }} ? 'bg-[#f5b54a] text-[#1a1206]' : 'bg-white/10 text-white hover:bg-white/20'">
                        <i data-lucide="{{ $mood['icon'] }}" class="h-4 w-4"></i>
                        {{ $mood['label'] }}
                        <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-[#1a1206]/40" :class="i === {{ $k }} ? 'centum-thumb-progress [animation-duration:5s]' : 'scale-x-0'"></span>
                    </button>
                @endforeach
            </div>

            <div class="relative mt-10 grid" data-no-auto-reveal>
                @foreach ($moods as $k => $mood)
                    <div class="col-start-1 row-start-1 transition-all duration-700"
                         :class="i === {{ $k }} ? 'opacity-100 translate-y-0' : 'pointer-events-none opacity-0 translate-y-6'"
                         @if ($k > 0) style="opacity: 0" @endif :style="''">
                        <h2 class="text-5xl font-bold sm:text-6xl">{{ $mood['title'] }}</h2>
                        <p class="mt-5 max-w-lg text-lg text-gray-300">{{ $mood['text'] }}</p>
                        <a href="#{{ $mood['pick'] }}" class="mt-8 inline-flex items-center gap-3 rounded-full border border-white/15 bg-black/40 py-2 pl-2 pr-5 text-sm font-semibold backdrop-blur transition hover:border-[#f5b54a]/60">
                            <span class="flex h-12 w-12 items-center justify-center rounded-full bg-white/5 p-1.5">
                                <img src="{{ $base($picks[$mood['pick']]['cut']) }}" alt="" class="max-h-full max-w-full">
                            </span>
                            Best pick: {{ $picks[$mood['pick']]['eyebrow'] }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</section>


{{-- =========================================================
     COMPARE
========================================================= --}}
<section id="compare" class="scroll-mt-32 bg-[#0d0b09] py-24">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        <div class="text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#f5b54a]">Compare</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Find your <span class="ha-gold-text">sound.</span></h2>
        </div>

        <div class="mt-12 overflow-x-auto rounded-3xl ring-1 ring-white/10" data-reveal>
            <table class="w-full min-w-[40rem] text-left text-sm">
                <thead>
                    <tr class="bg-white/[0.04]">
                        <th class="p-5"></th>
                        @foreach ($spotlights as $s)
                            <th class="p-5 text-center align-bottom">
                                <img src="{{ $base($s['cut']) }}" alt="" loading="lazy" class="mx-auto h-24 w-auto">
                                <span class="mt-3 block font-bold text-white">{{ $s['eyebrow'] }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-gray-300">
                    @foreach ([
                        ['Best for', ['Music & living rooms', 'Bedrooms & parties', 'TV, movies & sport']],
                        ['Speakers', ['2 towers (stereo pair)', '1 tower', 'Soundbar + subwoofer']],
                        ['Bass', ['Side-firing driver + port, each tower', 'Side-firing woofer + port', 'Subwoofer: side woofer + port']],
                        ['Display / controls', ['Front control panel', 'LED display + volume knob', 'Subwoofer control panel']],
                        ['Bluetooth · USB · AUX', ['check', 'check', 'check']],
                    ] as [$label, $values])
                        <tr>
                            <td class="p-5 font-semibold text-white">{{ $label }}</td>
                            @foreach ($values as $v)
                                <td class="p-5 text-center">
                                    @if ($v === 'check')
                                        <i data-lucide="circle-check" class="mx-auto h-5 w-5 text-[#f5b54a]"></i>
                                    @else
                                        {{ $v }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr>
                        <td class="p-5"></td>
                        @foreach ($spotlights as $s)
                            @php $product = $bySku[$s['sku']] ?? null; @endphp
                            <td class="p-5 text-center">
                                @if ($product)
                                    <a href="{{ route('store.product', $product) }}" class="inline-flex rounded-full bg-white px-5 py-2.5 text-xs font-bold text-gray-900 transition hover:bg-[#f5b54a]">View details</a>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative isolate overflow-hidden py-28 text-center">

    <div class="absolute inset-0 -z-10">
        <img src="{{ $base('mood-vinyl.jpg') }}" alt="" loading="lazy" class="ha-kenburns h-full w-full object-cover opacity-30">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(7,6,5,0.4),#070605_75%)]"></div>
    </div>

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Bring the <span class="ha-gold-text">bass home.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us your room and what you love to listen to. We'll help you pick the right Yara speaker.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-[#f5b54a] px-7 py-4 text-sm font-bold text-[#1a1206] transition hover:bg-[#ffd88a]">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.category', 'home-audio') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                All home audio
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>

</section>

</div>

@endsection
