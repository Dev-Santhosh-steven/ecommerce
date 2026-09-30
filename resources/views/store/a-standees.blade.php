@extends('layouts.store')

@section('title', 'Yara A-Standees | Portable Digital Posters 32" 43" 55"')

@push('styles')
    <meta name="description" content="Yara A-Standee portable digital posters in 32, 43 and 55 inch: foldable A-frame displays for mall promotions, beauty stores, boutique entrances and offices.">
@endpush

@php
    $base = fn ($file) => asset("storage/products/a-standees/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in your A-Standee portable digital posters. Please share details and pricing.');

    // Live demo: the standee with each kind of content (pre-rendered with perspective).
    $demo = [
        ['img' => $base('a-standee-perfume-violet.png'), 'place' => 'Mall promotions', 'text' => 'Launch campaigns right where shoppers walk.', 'icon' => 'shopping-bag'],
        ['img' => $base('a-standee-berry.png'), 'place' => 'Beauty & cosmetics', 'text' => 'New shades and fragrances at the counter.', 'icon' => 'sparkles'],
        ['img' => $base('a-standee-gold.png'), 'place' => 'Boutique entrances', 'text' => 'An elegant welcome at your door.', 'icon' => 'gem'],
        ['img' => $base('a-standee-perfume-ember.png'), 'place' => 'Events & launches', 'text' => 'Bold visuals for exhibitions and pop-ups.', 'icon' => 'party-popper'],
        ['img' => $base('a-standee-creative.png'), 'place' => 'Offices & co-working', 'text' => 'Announcements, agendas and brand stories.', 'icon' => 'briefcase'],
    ];

    $sizeRenders = [32 => 'a-standee-perfume-violet.png', 43 => 'a-standee-berry.png', 55 => 'a-standee-gold.png'];
    $sizeWidths = [32 => 'w-[9.5rem]', 43 => 'w-[12rem]', 55 => 'w-[14.5rem]'];
    $idealFor = [32 => 'Shop counters, cafés & reception desks', 43 => 'Mall promotions, beauty stores & events', 55 => 'Boutique entrances, lobbies & exhibitions'];

    $posters = [
        ['img' => $base('poster-mall.jpg'), 'place' => 'Mall atriums'],
        ['img' => $base('poster-beauty.jpg'), 'place' => 'Beauty & cosmetics'],
        ['img' => $base('poster-boutique.jpg'), 'place' => 'Boutique entrances'],
        ['img' => $base('poster-office.jpg'), 'place' => 'Offices & co-working'],
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
                Yara <span class="about-gradient-text">A-Standees</span>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300 sm:text-xl">
                The digital poster you can carry. Fold-out A-frame displays in 32", 43" and 55" for every entrance, counter and event.
            </p>
        </div>

        <div class="relative mx-auto mt-4 max-w-5xl">
            <div class="centum-ambient"></div>
            <img src="{{ $base('a-standee-trio.png') }}" alt="Yara A-Standees in 32, 43 and 55 inch" class="centum-hero-tv relative w-full">
        </div>

        <div class="mt-6 flex flex-wrap justify-center gap-4" data-reveal>
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
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara A-Standees</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">32" · 43" · 55" · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#sizes" class="transition hover:text-white">Sizes</a>
            <a href="#demo" class="transition hover:text-white">Live demo</a>
            <a href="#places" class="transition hover:text-white">Where to use</a>
            <a href="#portable" class="transition hover:text-white">Why portable</a>
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
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Three sizes. <span class="about-gradient-text">Set up anywhere.</span></h2>
        </div>

        <div class="mt-14 grid items-end gap-6 md:grid-cols-3">
            @foreach ($products as $i => $product)
                @php $inch = (int) preg_replace('/\D/', '', $product->sku); @endphp

                <article class="group flex flex-col rounded-[2rem] border border-white/10 bg-white/[0.03] p-6 transition duration-500 hover:-translate-y-2 hover:border-brand-500/40 hover:bg-white/[0.06] sm:p-8"
                         data-reveal style="--reveal-delay: {{ $i * 140 }}ms">

                    <div class="relative flex h-[26rem] items-end justify-center">
                        <div class="absolute bottom-2 h-4 w-40 rounded-[50%] bg-black/60 blur-md"></div>
                        <img src="{{ $base($sizeRenders[$inch] ?? 'a-standee-gold.png') }}" alt="Yara {{ $inch }} inch A-Standee" loading="lazy"
                             class="relative {{ $sizeWidths[$inch] ?? 'w-[12rem]' }} transition duration-700 group-hover:-translate-y-1 group-hover:scale-[1.03]">
                    </div>

                    <div class="mt-8 flex items-end justify-between gap-4">
                        <div>
                            <p class="font-display text-5xl font-extrabold">{{ $inch }}<span class="text-brand-500">"</span></p>
                            <p class="mt-1 text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">A-Standee</p>
                        </div>
                        <span class="rounded-full border border-white/15 px-3 py-1 text-xs text-gray-300">Price on request</span>
                    </div>

                    <p class="mt-4 text-sm leading-6 text-gray-400">{{ $idealFor[$inch] ?? $product->short_description }}</p>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('store.product', $product) }}" class="flex-1 rounded-full bg-white px-5 py-3 text-center text-sm font-semibold text-gray-900 transition hover:bg-brand-600 hover:text-white">
                            View details
                        </a>
                        <a href="{{ $wa("Hi Yara, I am interested in the {$inch}\" A-Standee. Please share the price.") }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 transition hover:border-brand-500 hover:bg-brand-600" aria-label="Enquire about the {{ $inch }} inch A-Standee on WhatsApp">
                            <i data-lucide="message-circle" class="h-5 w-5"></i>
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     LIVE DEMO
========================================================= --}}
<section id="demo" class="relative scroll-mt-32 overflow-hidden bg-white py-24 text-gray-900"
         x-data="{ i: 0, n: {{ count($demo) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 3800) }, pick(k) { this.i = k; this.start() } }"
         x-init="start()">

    <div class="mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div class="order-2 lg:order-1" data-reveal="left">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Live demo</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">One poster. <span class="text-brand-600">Endless campaigns.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Tap a use to see what a Yara A-Standee can show.</p>

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
            <div class="relative w-[70%] max-w-[24rem]">
                <div class="absolute -inset-10 rounded-full bg-brand-500/15 blur-3xl"></div>
                <div class="relative grid">
                    @foreach ($demo as $k => $item)
                        <img src="{{ $item['img'] }}" alt="{{ $item['place'] }} content on a Yara A-Standee" loading="lazy"
                             class="col-start-1 row-start-1 w-full transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                             :class="i === {{ $k }} ? 'opacity-100 translate-y-0' : 'pointer-events-none opacity-0 translate-y-3'"
                             @if ($k > 0) style="opacity: 0" @endif :style="''">
                    @endforeach
                </div>
                <div class="mx-auto -mt-3 h-4 w-[70%] rounded-[50%] bg-black/25 blur-md"></div>
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     WHERE TO USE
========================================================= --}}
<section id="places" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="about-blob -right-24 top-1/3 h-96 w-96 bg-brand-800"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Right at the <span class="about-gradient-text">front door.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Set it up in seconds at entrances, counters and event spaces, then fold it away when you're done.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($posters as $i => $poster)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $poster['img'] }}" alt="Yara A-Standee in {{ strtolower($poster['place']) }}" loading="lazy"
                         class="aspect-[4/5] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                </figure>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach ([
                ['coffee', 'Cafés & restaurants'], ['store', 'Shop entrances'], ['hotel', 'Hotel lobbies'],
                ['presentation', 'Exhibitions & expos'], ['graduation-cap', 'Campuses & events'], ['hospital', 'Clinics & reception'],
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
     WHY PORTABLE — A-Standee vs printed standee
========================================================= --}}
<section id="portable" class="scroll-mt-32 bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Why digital</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Goodbye, printed standees.</h2>
        </div>

        <div class="mt-12 overflow-hidden rounded-3xl bg-white ring-1 ring-gray-200" data-reveal>
            <div class="grid grid-cols-3 bg-gray-950 text-sm font-semibold text-white">
                <div class="p-4 sm:p-5"></div>
                <div class="p-4 text-center text-gray-400 sm:p-5">Printed standee</div>
                <div class="bg-brand-600 p-4 text-center sm:p-5">Yara A-Standee</div>
            </div>
            @foreach ([
                ['Changing the message', 'Reprint every time', 'Update in minutes'],
                ['Content', 'One static image', 'Images, videos & slideshows'],
                ['Visibility', 'Fades in bright areas', 'Bright, eye-catching screen'],
                ['Running cost', 'Printing adds up', 'Reuse forever'],
                ['Set-up', 'Assemble & replace', 'Fold out and switch on'],
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
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Small footprint. <span class="text-brand-600">Big impact.</span></h2>
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
        <h2 class="text-4xl font-bold sm:text-6xl">Put your message <span class="about-gradient-text">at the door.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us where you'll use it. We'll recommend the right size and help you set up your content.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.tstandees') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                See T-Standees
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>

</section>

</div>

@endsection
