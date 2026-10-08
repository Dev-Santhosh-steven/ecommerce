@extends('layouts.store')

@section('title', 'Yara Centum 100" 4K UHD Smart LED TV')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the Yara Centum 100" 4K UHD Smart LED TV. Please share the price and availability.');
    $screen = fn ($name) => asset("storage/products/centum/screen-{$name}.jpg");
    $screens = [
        ['src' => $screen('neon'), 'title' => 'Neon Garden', 'label' => 'Glow & deep reds', 'live' => true, 'ms' => 12000],
        ['src' => $screen('leopard-royal'), 'title' => 'Royal Leopard', 'label' => 'Lifelike detail'],
        ['src' => $screen('leopard-swirl'), 'title' => 'The Prowl', 'label' => 'Deep contrast'],
        ['src' => $screen('horses'), 'title' => 'Crimson Herd', 'label' => 'Rich, deep reds'],
        ['src' => $screen('layers'), 'title' => 'Colour Strata', 'label' => 'A+ grade colour'],
        ['src' => $screen('house'), 'title' => 'Still Waters', 'label' => 'Pure contrast'],
        ['src' => $screen('mountain'), 'title' => 'Thread Peak', 'label' => 'Fine texture'],
        ['src' => $screen('mandala'), 'title' => 'Golden Mandala', 'label' => 'Intricate detail'],
        ['src' => $screen('earth'), 'title' => 'Night Planet', 'label' => 'Deep blacks'],
        ['src' => $screen('coast'), 'title' => 'Coastal Dusk', 'label' => '4K clarity'],
    ];
@endphp

@section('content')

<div class="centum-page overflow-x-clip text-white">

{{-- =========================================================
     HERO — the TV powers on and plays
========================================================= --}}
<section class="relative overflow-hidden pb-16 pt-14 sm:pt-20">

    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob -left-40 top-20 h-[30rem] w-[30rem] bg-brand-800"></div>
    <div class="about-blob -right-32 top-40 h-[26rem] w-[26rem] bg-brand-red/40 [animation-delay:-7s]"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="about-intro text-center">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Introducing
            </p>
            <h1 class="mt-5 text-5xl font-bold sm:text-7xl">
                Yara <span class="about-gradient-text">Centum</span>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300 sm:text-xl">
                100" 4K UHD Smart LED TV. Bigger than life, brighter than ever.
            </p>
        </div>

        {{-- TV stage: the Centum on a living-room feature wall, the neon frame flickering on over deep red leaves --}}
        <div class="relative mx-auto mt-12 max-w-6xl">

            <div class="centum-ambient !inset-[8%_6%_12%]"></div>

            <x-tv-room src="{{ asset('storage/products/centum/room-living.jpg') }}"
                       alt="Yara Centum 100 inch 4K UHD Smart LED TV on a wood-slat feature wall in a living room"
                       :screen="[[29.57, 32.20], [63.48, 32.20], [63.48, 69.41], [29.57, 69.41]]"
                       glow="rgba(255, 40, 80, 0.16)"
                       class="tv-room-rise rounded-[1.5rem] shadow-[0_50px_100px_-30px_rgba(220,30,70,0.45)] ring-1 ring-white/10 sm:rounded-[2rem]">
                <x-neon-scene class="absolute inset-0" />
            </x-tv-room>

        </div>

        {{-- Headline specs --}}
        <div class="mt-12 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach (['4K UHD', '100" Display', 'A+ Grade Panel', 'Android 12', '30W Sound', 'OTT Onboard'] as $pill)
                <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm font-medium text-gray-200 backdrop-blur">{{ $pill }}</span>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-4" data-reveal style="--reveal-delay: 120ms">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire now
            </a>
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                <i data-lucide="calendar-check" class="h-4 w-4"></i>
                Book a live demo
            </a>
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY PRODUCT BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0a0a]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Centum 100"</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">4K UHD Smart LED TV · {{ $product->hasPrice() ? '₹' . number_format((float) ($product->sale_price ?: $product->price)) : 'Price on request' }}</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#picture" class="transition hover:text-white">Picture</a>
            <a href="#smart" class="transition hover:text-white">Smart</a>
            <a href="#sound" class="transition hover:text-white">Sound</a>
            <a href="#connect" class="transition hover:text-white">Connectivity</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">
            Enquire
        </a>
    </div>
</div>


{{-- =========================================================
     BIG NUMBERS
========================================================= --}}
<section class="relative py-24">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
    <div class="grid grid-cols-2 gap-px overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 lg:grid-cols-4">
        @foreach ([
            ['value' => 100, 'suffix' => '"', 'label' => 'Cinema-sized screen', 'count' => true],
            ['value' => '4K', 'suffix' => '', 'label' => '3840 × 2160 UHD', 'count' => false],
            ['value' => '8.3', 'suffix' => 'M', 'label' => 'Pixels of detail', 'count' => false],
            ['value' => 30, 'suffix' => 'W', 'label' => 'Room-filling sound', 'count' => true],
        ] as $i => $stat)
            <div class="group bg-[#0e0c0c] p-8 text-center transition duration-500 hover:bg-[#161212] sm:p-12" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                <p class="font-display text-6xl font-extrabold tabular-nums sm:text-7xl">
                    <span class="bg-gradient-to-b from-white to-gray-500 bg-clip-text text-transparent" @if ($stat['count']) data-centum-count="{{ $stat['value'] }}" @endif>{{ $stat['value'] }}</span><span class="text-brand-500">{{ $stat['suffix'] }}</span>
                </p>
                <p class="mt-3 text-sm font-medium uppercase tracking-[0.2em] text-gray-400 transition group-hover:text-gray-200">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>
    </div>
</section>


{{-- =========================================================
     EVERY PICTURE — all artwork playing on the Centum
========================================================= --}}
<section class="relative overflow-hidden pb-28 pt-8">

    <div class="about-blob -left-24 bottom-0 h-96 w-96 bg-brand-800"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10"
         x-data="{
            i: 0,
            n: {{ count($screens) }},
            timer: null,
            ms: @js(collect($screens)->map(fn ($s) => $s['ms'] ?? 4500)),
            start() { clearTimeout(this.timer); this.timer = setTimeout(() => { this.i = (this.i + 1) % this.n; this.start(); }, this.ms[this.i]); },
            pick(k) { this.i = k; this.start(); },
         }"
         x-init="start()">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">4K UHD · A+ Grade Panel</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-6xl">Made for <span class="about-gradient-text">every picture.</span></h2>
            <p class="mt-5 text-lg text-gray-300">From bold colour to the finest thread of detail, see it all on a 100" canvas.</p>
        </div>

        <div class="relative mx-auto mt-14 max-w-6xl" data-reveal="zoom">

            <div class="centum-ambient"></div>

            <x-centum-tv class="relative w-full">
                <div class="centum-screen-content centum-glare absolute inset-0">
                    @foreach ($screens as $s => $item)
                        <div class="centum-slide" :class="i === {{ $s }} ? 'is-active' : ''">
                            @if (! empty($item['live']))
                                {{-- mounted each time the slide comes round, so the sequence plays from the start --}}
                                <template x-if="i === {{ $s }}"><x-neon-scene class="absolute inset-0" /></template>
                            @else
                                <img src="{{ $item['src'] }}" alt="{{ $item['title'] }} on Yara Centum" loading="lazy">
                            @endif
                        </div>
                    @endforeach

                    {{-- On-screen caption --}}
                    <div class="absolute bottom-[5%] left-[3%] flex items-center gap-3 rounded-2xl bg-black/45 px-4 py-2.5 backdrop-blur-md">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-white"><i data-lucide="play" class="h-4 w-4 fill-current"></i></span>
                        @foreach ($screens as $s => $item)
                            <span x-show="i === {{ $s }}" @if ($s > 0) x-cloak @endif x-transition.opacity.duration.500ms>
                                <span class="block text-sm font-bold text-white sm:text-base">{{ $item['title'] }}</span>
                                <span class="block text-[11px] uppercase tracking-wider text-white/70">{{ $item['label'] }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            </x-centum-tv>

        </div>

        {{-- Thumbnails --}}
        <div class="mx-auto mt-10 flex max-w-6xl gap-3 overflow-x-auto pb-2 [scrollbar-width:none]" data-reveal>
            @foreach ($screens as $s => $item)
                <button type="button" @click="pick({{ $s }})"
                        class="group relative aspect-video w-32 shrink-0 overflow-hidden rounded-xl ring-2 transition duration-300 sm:w-40"
                        :class="i === {{ $s }} ? 'ring-brand-500 scale-105' : 'ring-white/10 opacity-60 hover:opacity-100'"
                        aria-label="Show {{ $item['title'] }}">
                    <img src="{{ $item['src'] }}" alt="" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-110">
                    <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-brand-red"
                          :class="i === {{ $s }} ? 'centum-thumb-progress' : 'scale-x-0'"></span>
                </button>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     PICTURE — scroll to zoom into the screen
========================================================= --}}
<section id="picture" class="centum-scrub relative h-[260vh] scroll-mt-32">

    <div class="sticky top-0 flex h-screen flex-col items-center justify-center overflow-hidden px-4">

        <div class="scrub-fade-out pointer-events-none absolute inset-x-0 top-[14%] z-10 text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">4K Ultra HD</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-6xl">Step into the picture.</h2>
        </div>

        <div class="scrub-tv w-[min(92vw,1300px)]">
            <x-centum-tv class="w-full">
                <img src="{{ asset('storage/products/centum/screen-mountain.jpg') }}" alt="4K detail on Yara Centum" loading="lazy" class="h-full w-full object-cover">
            </x-centum-tv>
        </div>

        <div class="scrub-fade-in pointer-events-none absolute inset-x-0 bottom-[10%] z-10 px-4 text-center [text-shadow:0_4px_30px_rgb(0_0_0/0.7)]">
            <h2 class="text-4xl font-bold sm:text-6xl lg:text-7xl">Every detail.<br>100 inches wide.</h2>
            <p class="mx-auto mt-4 max-w-xl text-lg text-gray-200">3840 × 2160 resolution: over 8.3 million pixels on a true cinema-sized, 16:9 wide screen.</p>
        </div>

    </div>

</section>


{{-- =========================================================
     COLOUR — before / after on an A+ grade panel
========================================================= --}}
<section class="relative overflow-hidden py-28">

    <div class="about-blob -right-40 top-10 h-96 w-96 bg-brand-900"></div>

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-5 lg:px-10">

        <div class="lg:col-span-2" data-reveal="left">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">A+ Grade Panel</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Lifelike colour.<br><span class="about-gradient-text">See the difference.</span></h2>
            <p class="mt-6 text-lg leading-8 text-gray-300">
                A premium A+ grade panel delivers stunning picture quality, with rich, true-to-life colours and deep contrast
                on every one of its 100 inches.
            </p>
            <p class="mt-6 inline-flex items-center gap-2 text-sm text-gray-400">
                <i data-lucide="move-horizontal" class="h-4 w-4 text-brand-400"></i>
                Drag across the screen to compare
            </p>
        </div>

        <div class="lg:col-span-3" data-reveal="right">
            <x-centum-tv class="w-full">
                <div class="centum-compare absolute inset-0" x-data="{ pos: 50 }">
                    <img src="{{ asset('storage/products/centum/screen-layers.jpg') }}" alt="Yara Centum colour" loading="lazy" class="absolute inset-0 h-full w-full object-cover">
                    <img src="{{ asset('storage/products/centum/screen-layers.jpg') }}" alt="" aria-hidden="true" loading="lazy"
                         class="absolute inset-0 h-full w-full object-cover [filter:saturate(0.35)_contrast(0.75)_brightness(0.85)]"
                         :style="`clip-path: inset(0 ${100 - pos}% 0 0)`" style="clip-path: inset(0 50% 0 0)">
                    <div class="pointer-events-none absolute inset-y-0 w-0.5 bg-white shadow-[0_0_20px_rgba(255,255,255,0.8)]" :style="`left: ${pos}%`" style="left: 50%">
                        <span class="absolute left-1/2 top-1/2 flex h-10 w-10 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white text-gray-900 shadow-xl">
                            <i data-lucide="move-horizontal" class="h-5 w-5"></i>
                        </span>
                    </div>
                    <span class="pointer-events-none absolute left-3 top-3 rounded-full bg-black/60 px-3 py-1 text-[10px] font-semibold uppercase tracking-wider text-white/80 sm:text-xs">Ordinary panel</span>
                    <span class="pointer-events-none absolute right-3 top-3 rounded-full bg-brand-600 px-3 py-1 text-[10px] font-semibold uppercase tracking-wider text-white sm:text-xs">Yara Centum</span>
                    <input type="range" min="0" max="100" x-model="pos" class="absolute inset-0 h-full w-full" aria-label="Compare ordinary panel with Yara Centum">
                </div>
            </x-centum-tv>
        </div>

    </div>

</section>


{{-- =========================================================
     SMART — Android 12 home screen on the TV
========================================================= --}}
<section id="smart" class="scroll-mt-32 bg-white py-28 text-gray-900">

    <div class="mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-5 lg:px-10">

        <div class="lg:col-span-3 lg:order-2" data-reveal="right">
            <x-centum-tv class="w-full">
                @php
                    $tiles = [
                        ['icon' => 'clapperboard', 'label' => 'Movies', 'from' => 'from-rose-600', 'to' => 'to-red-800'],
                        ['icon' => 'trophy', 'label' => 'Sports', 'from' => 'from-emerald-500', 'to' => 'to-teal-700'],
                        ['icon' => 'music', 'label' => 'Music', 'from' => 'from-violet-500', 'to' => 'to-purple-800'],
                        ['icon' => 'baby', 'label' => 'Kids', 'from' => 'from-amber-400', 'to' => 'to-orange-600'],
                        ['icon' => 'newspaper', 'label' => 'News', 'from' => 'from-sky-500', 'to' => 'to-blue-800'],
                        ['icon' => 'globe', 'label' => 'Browser', 'from' => 'from-gray-500', 'to' => 'to-gray-800'],
                    ];
                @endphp
                <div class="absolute inset-0 flex flex-col bg-gradient-to-br from-[#14161c] to-[#0a0b0e] p-[3%] text-white"
                     x-data="{ focus: 0 }" x-init="setInterval(() => focus = (focus + 1) % {{ count($tiles) }}, 1300)">

                    <div class="flex items-center justify-between text-[8px] text-white/70 sm:text-xs">
                        <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-2.5 w-auto sm:h-4">
                        <span class="flex items-center gap-2"><i data-lucide="wifi" class="h-3 w-3"></i> 9:41</span>
                    </div>

                    <div class="relative mt-[2.5%] flex-[1.3] overflow-hidden rounded-md sm:rounded-lg">
                        <img src="{{ asset('storage/products/centum/screen-leopard-royal.jpg') }}" alt="" loading="lazy" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/30 to-transparent"></div>
                        <div class="absolute bottom-[10%] left-[4%]">
                            <p class="text-[7px] font-semibold uppercase tracking-widest text-brand-400 sm:text-[10px]">Now streaming</p>
                            <p class="font-display text-xs font-bold sm:text-2xl">Royal Leopard</p>
                            <span class="mt-1 inline-flex items-center gap-1 rounded bg-white px-2 py-0.5 text-[7px] font-bold text-gray-900 sm:mt-2 sm:text-xs">
                                <i data-lucide="play" class="h-2.5 w-2.5 fill-current sm:h-3 sm:w-3"></i> Play
                            </span>
                        </div>
                    </div>

                    <p class="mt-[2.5%] text-[7px] font-semibold text-white/70 sm:text-[11px]">Your apps</p>
                    <div class="mt-[1.5%] grid flex-1 grid-cols-6 gap-[1.5%]">
                        @foreach ($tiles as $t => $tile)
                            <div class="flex flex-col items-center justify-center gap-1 rounded-md bg-gradient-to-br {{ $tile['from'] }} {{ $tile['to'] }} transition duration-300 sm:rounded-lg"
                                 :class="focus === {{ $t }} ? 'scale-110 ring-2 ring-white shadow-[0_0_20px_rgba(255,255,255,0.35)]' : 'opacity-80'">
                                <i data-lucide="{{ $tile['icon'] }}" class="h-3 w-3 sm:h-6 sm:w-6"></i>
                                <span class="text-[6px] font-semibold sm:text-[10px]">{{ $tile['label'] }}</span>
                            </div>
                        @endforeach
                    </div>

                </div>
            </x-centum-tv>
        </div>

        <div class="lg:col-span-2 lg:order-1" data-reveal="left">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Smart TV</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">All your entertainment, <span class="text-brand-600">one remote away.</span></h2>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Built-in smart features make it easy to stream your favourite shows and movies, with OTT apps onboard and a quick,
                familiar Android 12 experience.
            </p>
            <div class="mt-8 grid grid-cols-2 gap-4">
                @foreach ([
                    ['icon' => 'smartphone', 'title' => 'Android 12', 'text' => 'Smooth & familiar'],
                    ['icon' => 'cpu', 'title' => 'Quad Core', 'text' => 'Fast, responsive'],
                    ['icon' => 'memory-stick', 'title' => '2 GB RAM', 'text' => 'Multitask easily'],
                    ['icon' => 'hard-drive', 'title' => '16 GB ROM', 'text' => 'Room for apps'],
                    ['icon' => 'tv-minimal', 'title' => 'OTT Onboard', 'text' => 'Stream instantly'],
                    ['icon' => 'bluetooth', 'title' => 'Bluetooth', 'text' => 'Go wireless'],
                ] as $item)
                    <div class="flex items-start gap-3 rounded-2xl border border-gray-200 p-4 transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-lg">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-600"><i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i></span>
                        <span><span class="block font-bold">{{ $item['title'] }}</span><span class="block text-sm text-gray-500">{{ $item['text'] }}</span></span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     SOUND
========================================================= --}}
<section id="sound" class="relative scroll-mt-32 overflow-hidden py-28">

    <div class="about-blob left-1/3 top-1/4 h-[28rem] w-[28rem] bg-brand-700"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 text-center sm:px-6 lg:px-10">

        <div data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">High Quality Audio</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-6xl">Sound as big as the screen.</h2>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300">Twin 15W speakers deliver 30W of clear, room-filling audio for movies, music and matches.</p>
        </div>

        <div class="relative mx-auto mt-14 max-w-5xl" data-reveal="zoom">
            <x-centum-tv class="w-full">
                <img src="{{ asset('storage/products/centum/screen-stage.jpg') }}" alt="Concert on Yara Centum" loading="lazy" class="h-full w-full object-cover">
            </x-centum-tv>

            {{-- Speakers with live equalizer --}}
            @foreach (['left-0 sm:-left-6', 'right-0 sm:-right-6'] as $side)
                <div class="centum-eq absolute bottom-[26%] {{ $side }} hidden h-24 items-end gap-1.5 sm:flex" aria-hidden="true">
                    @foreach ([0.1, 0.35, 0.2, 0.5, 0.15, 0.4] as $delay)
                        <span class="h-full" style="animation-delay: -{{ $delay * 3 }}s; animation-duration: {{ 0.8 + $delay }}s"></span>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="mx-auto mt-14 grid max-w-3xl grid-cols-3 gap-4" data-reveal>
            @foreach ([['15W', 'Left speaker'], ['30W', 'Total output'], ['15W', 'Right speaker']] as [$w, $label])
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                    <p class="font-display text-3xl font-bold sm:text-4xl">{{ $w }}</p>
                    <p class="mt-1 text-xs uppercase tracking-wider text-gray-400">{{ $label }}</p>
                </div>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     CONNECTIVITY & EFFICIENCY
========================================================= --}}
<section id="connect" class="scroll-mt-32 bg-[#f4f4f5] py-28 text-gray-900">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Connectivity</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Connect <span class="text-brand-600">everything.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Multiple HDMI and USB ports let you plug in all your devices: soundbars, consoles, set-top boxes and more.</p>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['icon' => 'cable', 'title' => 'HDMI ARC', 'text' => 'One cable to your soundbar or home theatre, controlled with the TV remote.'],
                ['icon' => 'usb', 'title' => 'USB', 'text' => 'Play movies, music and photos straight from a pen drive or hard disk.'],
                ['icon' => 'radio', 'title' => 'COAX Out', 'text' => 'Digital coaxial audio output for external amplifiers and receivers.'],
                ['icon' => 'headphones', 'title' => 'Earphone Port', 'text' => 'Plug in headphones for private late-night viewing.'],
                ['icon' => 'bluetooth', 'title' => 'Bluetooth', 'text' => 'Pair wireless headphones, speakers and keyboards.'],
                ['icon' => 'rectangle-horizontal', 'title' => '16:9 Wide Screen', 'text' => 'The native shape of films, shows and sport, with no wasted space.'],
                ['icon' => 'sparkles', 'title' => 'A+ Grade Panel', 'text' => 'Premium panel quality for vibrant, consistent picture.'],
                ['icon' => 'leaf', 'title' => 'Energy Efficient', 'text' => 'Efficient operation helps reduce your electricity bill.'],
            ] as $item)
                <div class="about-shine group rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-brand-200">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-950 text-white transition duration-500 group-hover:rotate-6 group-hover:bg-brand-600">
                        <i data-lucide="{{ $item['icon'] }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ $item['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     GALLERY
========================================================= --}}
@if ($product->images->isNotEmpty())
<section class="py-24">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <h2 class="text-center text-3xl font-bold sm:text-4xl" data-reveal>Designed to be the centrepiece.</h2>
        <div class="mt-12 grid gap-5 md:grid-cols-3">
            @foreach ($product->images as $image)
                <figure class="group overflow-hidden rounded-3xl {{ $loop->first ? 'bg-[#0b0a0a] ring-1 ring-white/10' : 'bg-white p-6' }}">
                    <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->alt_text }}" loading="lazy" class="aspect-[4/3] w-full {{ $loop->first ? 'object-cover' : 'object-contain' }} transition duration-700 group-hover:scale-105">
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- =========================================================
     SPECIFICATIONS
========================================================= --}}
<section id="specs" class="scroll-mt-32 bg-white py-28 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Specifications</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Yara Centum 100"</h2>
            <p class="mt-3 text-gray-500">{{ $product->name }}</p>
        </div>

        <dl class="mt-14 grid gap-x-12 sm:grid-cols-2" data-reveal>
            @foreach ($product->specifications ?? [] as $key => $value)
                <div class="flex items-baseline justify-between gap-6 border-b border-gray-200 py-4">
                    <dt class="text-sm text-gray-500">{{ $key }}</dt>
                    <dd class="text-right font-semibold">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>

    </div>
</section>


{{-- =========================================================
     FINAL CTA
========================================================= --}}
<section class="relative overflow-hidden py-28 text-center">

    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-brand-700"></div>

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Bring home the <span class="about-gradient-text">big picture.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Talk to our team for pricing, delivery and installation of your Yara Centum 100".</p>
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


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Scroll-scrubbed zoom: --p goes 0 → 1 while the section is pinned.
        const scrubs = [...document.querySelectorAll('.centum-scrub')];
        let queued = false;

        const updateScrub = () => {
            queued = false;
            scrubs.forEach((section) => {
                const rect = section.getBoundingClientRect();
                const range = rect.height - window.innerHeight;
                const p = Math.min(1, Math.max(0, -rect.top / range));
                section.style.setProperty('--p', p.toFixed(4));
            });
        };

        if (!reduce && scrubs.length) {
            window.addEventListener('scroll', () => {
                if (queued) return;
                queued = true;
                requestAnimationFrame(updateScrub);
            }, { passive: true });
            updateScrub();
        }

        // Count-up numbers.
        const counters = document.querySelectorAll('[data-centum-count]');
        if (!reduce) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    const target = parseInt(el.dataset.centumCount, 10);
                    const start = performance.now();
                    const tick = (now) => {
                        const t = Math.min((now - start) / 1600, 1);
                        el.textContent = Math.round(target * (1 - Math.pow(1 - t, 4)));
                        if (t < 1) requestAnimationFrame(tick);
                    };
                    requestAnimationFrame(tick);
                    observer.unobserve(el);
                });
            }, { threshold: 0.6 });
            counters.forEach((el) => { el.textContent = '0'; observer.observe(el); });
        }
    });
</script>
@endpush
