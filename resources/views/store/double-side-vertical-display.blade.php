@extends('layouts.store')

@section('title', 'Yara 43" Double Side Vertical Display | Window & Ceiling Hanging Digital Signage')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $base = fn ($file) => asset("storage/products/double-side-vertical-display/{$file}");
    $logo = asset('storage/products/centum/yara-logo-light.png');
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the 43" Double Side Vertical Display. Please share details and pricing.');
    $specs = \App\Support\SpecSheet::visible($product->specifications);

    // Where the screen sits on dsvd-front.png (percent of the cut-out), measured from the product photo.
    $screen = 'left: 12.63%; top: 35.89%; width: 75%; height: 56.96%;';

    $heroSlides = ['beach', 'departures', 'news', 'sale'];

    $playback = [
        ['columns-2', 'Free split screen', 'Show a video, a price list and a logo at the same time, laid out the way you like.'],
        ['images', 'Pictures and text together', 'Play images, video and scrolling text simultaneously on one screen.'],
        ['timer', 'Timing switch', 'Schedule the display to switch on before opening and off after closing.'],
        ['radio-tower', 'Live inter-cut', 'Cut in a live message or an urgent notice over the running playlist.'],
    ];

    $system = [
        ['Operating system', 'Android'],
        ['Processor', 'Quad-core'],
        ['Memory', ($specs['RAM'] ?? '2 GB')],
        ['Connectivity', 'Wi-Fi · Bluetooth · LAN'],
    ];

    $places = [
        ['img' => $base('scene-check-in.jpg'), 'place' => 'Airports & check-in halls', 'icon' => 'plane'],
        ['img' => $base('scene-lounge.jpg'), 'place' => 'Departure & waiting lounges', 'icon' => 'armchair'],
        ['img' => $base('scene-waiting-hall.jpg'), 'place' => 'Railway & bus stations', 'icon' => 'train-front'],
        ['img' => $base('scene-experience.jpg'), 'place' => 'Experience centres & exhibitions', 'icon' => 'sparkles'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0b0b10] text-white">

{{-- =========================================================
     HERO — the display hanging, its screen playing live content
========================================================= --}}
<section class="relative isolate overflow-hidden" x-data="{ i: 0, t: null, init() { this.t = setInterval(() => this.i = (this.i + 1) % {{ count($heroSlides) }}, 3800) } }">

    <div class="about-grid absolute inset-0 -z-10 opacity-40"></div>
    <div class="absolute right-[-10%] top-[10%] -z-10 h-[38rem] w-[38rem] rounded-full bg-brand-800/50 blur-[120px]"></div>

    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 pt-14 sm:px-6 lg:grid-cols-[1.1fr_1fr] lg:px-10 lg:pt-0">

        <div class="about-intro py-10 lg:py-28">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-black/30 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-200 backdrop-blur">
                <img src="{{ $logo }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Double Side Vertical Display
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-7xl">
                One display.<br><span class="about-gradient-text">Two audiences.</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg text-gray-300 sm:text-xl">
                A 43" Full HD screen on each face: sunlight-readable for your shop window, built for 24/7 and ready for remote content.
            </p>
            <div class="mt-9 flex flex-wrap gap-4">
                <a href="#two-sides" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                    See both sides
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-black/20 px-7 py-4 text-sm font-semibold backdrop-blur transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <div class="mt-10 flex flex-wrap gap-3">
                @foreach (['43"', 'Double-sided', 'Full HD', 'Sunlight-readable', '24/7', 'Price on request'] as $pill)
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">{{ $pill }}</span>
                @endforeach
            </div>
        </div>

        {{-- the display, hanging from two rods --}}
        <div class="relative mx-auto w-full max-w-[15rem] pb-14 pt-20 sm:max-w-[17rem] lg:pt-24" data-no-auto-reveal>
            <div class="dsvd-sway relative">
                <span class="absolute bottom-full left-[28%] h-[60rem] w-[3px] -translate-x-1/2 bg-gradient-to-b from-transparent via-gray-500 to-gray-400"></span>
                <span class="absolute bottom-full left-[72%] h-[60rem] w-[3px] -translate-x-1/2 bg-gradient-to-b from-transparent via-gray-500 to-gray-400"></span>

                <img src="{{ $base('dsvd-front.png') }}" alt="Yara 43 inch Double Side Vertical Display" class="relative w-full drop-shadow-[0_40px_50px_rgba(0,0,0,0.6)]">

                <div class="absolute overflow-hidden rounded-[2px] bg-black [container-type:inline-size]" style="{{ $screen }}">
                    @foreach ($heroSlides as $k => $slide)
                        <div class="absolute inset-0 transition-opacity duration-1000" :class="i === {{ $k }} ? 'opacity-100' : 'opacity-0'" @if ($k > 0) style="opacity: 0" @endif :style="''">
                            @include('store.partials.dsvd-screen', ['slide' => $slide])
                        </div>
                    @endforeach
                    <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(115deg,transparent_40%,rgba(255,255,255,0.14)_48%,transparent_58%)]"></div>
                </div>
            </div>

            <div class="mt-6 flex justify-center gap-2">
                @foreach ($heroSlides as $k => $slide)
                    <button type="button" @click="i = {{ $k }}; clearInterval(t)" class="h-1.5 rounded-full transition-all" :class="i === {{ $k }} ? 'w-8 bg-brand-500' : 'w-3 bg-white/30'" aria-label="Show slide {{ $k + 1 }}"></button>
                @endforeach
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0b10]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara 43" Double Side Vertical Display</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Two Full HD screens · Sunlight-readable · 24/7 · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#two-sides" class="transition hover:text-white">Both sides</a>
            <a href="#playback" class="transition hover:text-white">Smart playback</a>
            <a href="#places" class="transition hover:text-white">Where to use</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     TWO SIDES — flip the display to see the other face
========================================================= --}}
<section id="two-sides" class="relative scroll-mt-32 overflow-hidden bg-[#f5f3f0] py-24 text-gray-900"
         x-data="{ back: false, t: null, init() { this.t = setInterval(() => this.back = ! this.back, 4500) } }">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Double the reach</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Talk to the street <span class="text-brand-600">and the store.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Hang it in your window: one face greets passers-by outside, the other welcomes shoppers inside.</p>
        </div>

        <div class="mt-14 grid items-center gap-12 lg:grid-cols-[1fr_1.1fr]">

            {{-- the flipping display --}}
            <div class="relative mx-auto w-full max-w-[17rem] [perspective:1600px] sm:max-w-[19rem]" data-no-auto-reveal>
                <div class="absolute inset-x-[10%] -bottom-6 h-8 rounded-[50%] bg-black/20 blur-2xl"></div>
                <div class="dsvd-flip relative" :style="back ? 'transform: rotateY(180deg)' : ''">
                    @foreach (['sale' => '', 'arrivals' => 'absolute inset-0 [transform:rotateY(180deg)]'] as $slide => $faceClass)
                        <div class="dsvd-face {{ $faceClass }}">
                            <img src="{{ $base('dsvd-front.png') }}" alt="{{ $loop->first ? 'Street side of the Yara Double Side Vertical Display' : 'Store side of the Yara Double Side Vertical Display' }}" class="w-full" loading="lazy">
                            <div class="absolute overflow-hidden rounded-[2px] bg-black [container-type:inline-size]" style="{{ $screen }}">
                                @include('store.partials.dsvd-screen', ['slide' => $slide])
                                <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(115deg,transparent_40%,rgba(255,255,255,0.14)_48%,transparent_58%)]"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                @foreach ([[false, 'store', 'Side A · faces the street', 'A bright, sunlight-readable screen that stops people walking past: offers, launches and opening hours.'], [true, 'shopping-bag', 'Side B · faces the store', 'Different content for shoppers already inside: new arrivals, prices and what to ask the team about.']] as [$isBack, $icon, $title, $text])
                    <button type="button" @click="back = {{ $isBack ? 'true' : 'false' }}; clearInterval(t)"
                            class="flex w-full items-start gap-4 rounded-2xl p-5 text-left transition"
                            :class="back === {{ $isBack ? 'true' : 'false' }} ? 'bg-white shadow-lg ring-1 ring-brand-200' : 'hover:bg-white/70'">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition" :class="back === {{ $isBack ? 'true' : 'false' }} ? 'bg-brand-600 text-white' : 'bg-gray-200/70 text-gray-600'">
                            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                        </span>
                        <span>
                            <span class="block text-lg font-bold">{{ $title }}</span>
                            <span class="mt-1 block text-sm leading-6 text-gray-600">{{ $text }}</span>
                        </span>
                    </button>
                @endforeach
                <p class="flex items-center gap-2 pl-2 pt-2 text-sm text-gray-500">
                    <i data-lucide="rotate-3d" class="h-4 w-4 text-brand-600"></i>
                    Tap a side to turn the display.
                </p>
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
     SMART PLAYBACK
========================================================= --}}
<section id="playback" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-grid absolute inset-0 opacity-40"></div>
    <div class="about-blob -right-24 top-10 h-96 w-96 bg-brand-800/60"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Smart playback</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Your content, <span class="about-gradient-text">on your schedule.</span></h2>
            <p class="mt-5 text-lg text-gray-300">Android inside and remote content management ready: update both screens without climbing a ladder.</p>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($playback as $i => [$icon, $title, $text])
                <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-7 transition duration-300 hover:-translate-y-1 hover:border-brand-500/40 hover:bg-white/[0.07]" data-reveal style="--reveal-delay: {{ $i * 90 }}ms">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red shadow-lg shadow-brand-900/40">
                        <i data-lucide="{{ $icon }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-400">{{ $text }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-10 grid grid-cols-2 gap-px overflow-hidden rounded-3xl bg-white/10 sm:grid-cols-4" data-reveal>
            @foreach ($system as [$label, $value])
                <div class="bg-[#111018] p-6 text-center">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-gray-500">{{ $label }}</p>
                    <p class="mt-2 font-display text-xl font-extrabold sm:text-2xl">{{ $value }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     FEATURES
========================================================= --}}
<section class="bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Features</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Made for <span class="text-brand-600">windows and showrooms.</span></h2>
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
     WHERE TO USE
========================================================= --}}
<section id="places" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-blob -left-24 top-10 h-96 w-96 bg-brand-800/50"></div>
    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Wherever people <span class="about-gradient-text">pass both ways.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Shop windows, showrooms, banks, airports, stations and malls: anywhere one screen would only reach half the crowd.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($places as $i => $p)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $p['img'] }}" alt="{{ $p['place'] }}" loading="lazy"
                         class="aspect-[3/4] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                    <figcaption class="absolute inset-x-0 bottom-0 flex items-center gap-3 bg-gradient-to-t from-black/85 to-transparent p-6 font-semibold">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/15 backdrop-blur"><i data-lucide="{{ $p['icon'] }}" class="h-4 w-4"></i></span>
                        {{ $p['place'] }}
                    </figcaption>
                </figure>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach ([['store', 'Shop windows'], ['car', 'Showrooms'], ['landmark', 'Banks'], ['shopping-bag', 'Malls'], ['hotel', 'Hotel lobbies'], ['utensils', 'Restaurants']] as [$icon, $label])
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
            <p class="mt-4 text-gray-500">Available in one size: 43". Price on request.</p>
        </div>
        <dl class="mt-12 grid gap-x-12 sm:grid-cols-2" data-reveal>
            @foreach ($specs as $key => $value)
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
        <h2 class="mt-8 text-4xl font-bold sm:text-6xl">Make your window <span class="about-gradient-text">work both ways.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us about your store or venue and we'll help you plan the mounting, content and pricing.</p>
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
