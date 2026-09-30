@extends('layouts.store')

@section('title', 'Yara 21.5" Printing Kiosk | Self-Order, Billing & Token Printing')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $base = fn ($file) => asset("storage/products/printing-kiosk/{$file}");
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the 21.5" Printing Kiosk. Please share details and pricing.');

    $steps = [
        ['icon' => 'hand-platter', 'title' => 'Browse', 'text' => 'Customers explore the menu or catalogue on a big 21.5" touchscreen.'],
        ['icon' => 'shopping-bag', 'title' => 'Order', 'text' => 'They customise items and add them to the cart. No waiting in line.'],
        ['icon' => 'credit-card', 'title' => 'Pay', 'text' => 'Payment options are configured for your business.'],
        ['icon' => 'printer', 'title' => 'Print', 'text' => 'The built-in printer issues the receipt or order token instantly.'],
    ];

    $demo = [
        ['img' => $base('kiosk-menu.png'), 'place' => 'Self-order menu', 'icon' => 'utensils-crossed'],
        ['img' => $base('kiosk-burger.png'), 'place' => 'Burger promotions', 'icon' => 'sparkles'],
        ['img' => $base('kiosk-chicken.png'), 'place' => 'Combo offers', 'icon' => 'ticket'],
        ['img' => $base('kiosk-shawarma.png'), 'place' => 'Daily specials', 'icon' => 'receipt'],
    ];

    $posters = [
        ['img' => $base('poster-restaurant.jpg'), 'place' => 'Restaurants & cafés'],
        ['img' => $base('poster-foodcourt.jpg'), 'place' => 'Mall food courts'],
        ['img' => $base('poster-retail.jpg'), 'place' => 'Retail & billing'],
        ['img' => $base('poster-tokens.jpg'), 'place' => 'Tokens & queues'],
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

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Commercial Display Solutions
            </p>
            <h1 class="mt-6 text-5xl font-bold sm:text-7xl">
                Yara <span class="about-gradient-text">Printing Kiosk</span>
            </h1>
            <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Order. Pay. Print. A 21.5" self-service kiosk with a built-in printer that keeps queues moving.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="{{ route('store.product', $product) }}" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                    View details
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <div class="mt-10 flex flex-wrap justify-center gap-3 lg:justify-start">
                @foreach (['21.5" Touchscreen', 'Built-in Printer', 'QR Scanner', 'Price on request'] as $pill)
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">{{ $pill }}</span>
                @endforeach
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-xl">
            <div class="centum-ambient"></div>
            <img src="{{ $base('kiosk-pair.png') }}" alt="Yara 21.5 inch Printing Kiosks" class="centum-hero-tv relative w-full">
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0a0a]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara 21.5" Printing Kiosk</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Self-order · Billing · Tokens · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#how" class="transition hover:text-white">How it works</a>
            <a href="#demo" class="transition hover:text-white">Live demo</a>
            <a href="#places" class="transition hover:text-white">Where to use</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     HOW IT WORKS — Browse → Order → Pay → Print (receipt prints out)
========================================================= --}}
<section id="how" class="relative scroll-mt-32 overflow-hidden bg-white py-24 text-gray-900"
         x-data="{ step: 0, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.step = (this.step + 1) % 4, 2600) }, pick(k) { this.step = k; this.start() } }"
         x-init="start()">

    <div class="mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div class="relative mx-auto flex w-full max-w-md justify-center" data-reveal="left">
            <div class="absolute inset-10 rounded-full bg-brand-500/10 blur-3xl"></div>
            <img src="{{ $base('kiosk-menu.png') }}" alt="Yara Printing Kiosk self-order screen" loading="lazy" class="relative w-[78%]">

            {{-- Receipt that "prints" out of the slot on the Print step --}}
            <div class="absolute left-[68.5%] top-[45%] w-[10.5%] overflow-hidden" style="height: 22%">
                <div class="rounded-b-md bg-white p-2 shadow-xl ring-1 ring-gray-200 transition-transform duration-[1400ms] ease-[cubic-bezier(0.16,1,0.3,1)]"
                     :class="step === 3 ? 'translate-y-0' : '-translate-y-full'">
                    <p class="text-center text-[6px] font-bold tracking-widest text-gray-900">ORDER</p>
                    <p class="text-center font-display text-sm font-extrabold leading-none text-brand-600">#A27</p>
                    <div class="mt-1 space-y-0.5 border-t border-dashed border-gray-300 pt-1">
                        <div class="h-1 rounded bg-gray-200"></div>
                        <div class="h-1 w-3/4 rounded bg-gray-200"></div>
                        <div class="h-1 w-5/6 rounded bg-gray-200"></div>
                    </div>
                    <p class="mt-1 text-center text-[5px] text-gray-400">Thank you!</p>
                </div>
            </div>
        </div>

        <div data-reveal="right">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">How it works</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">From tap to token <span class="text-brand-600">in seconds.</span></h2>

            <ol class="relative mt-10 space-y-4">
                <span class="absolute bottom-6 left-[27px] top-6 w-0.5 bg-gray-200"></span>
                <span class="absolute left-[27px] top-6 w-0.5 origin-top bg-brand-600 transition-all duration-700" :style="`height: calc((100% - 3rem) * ${step / 3})`"></span>

                @foreach ($steps as $k => $s)
                    <li>
                        <button type="button" @click="pick({{ $k }})" class="relative flex w-full items-start gap-5 rounded-2xl p-3 text-left transition" :class="step === {{ $k }} ? 'bg-brand-50' : 'hover:bg-gray-50'">
                            <span class="relative z-10 flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl ring-4 ring-white transition"
                                  :class="step >= {{ $k }} ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'bg-gray-100 text-gray-500'">
                                <i data-lucide="{{ $s['icon'] }}" class="h-6 w-6"></i>
                            </span>
                            <span class="pt-1">
                                <span class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Step {{ $k + 1 }}</span>
                                <span class="block text-xl font-bold">{{ $s['title'] }}</span>
                                <span class="mt-1 block text-sm leading-6 text-gray-600">{{ $s['text'] }}</span>
                            </span>
                        </button>
                    </li>
                @endforeach
            </ol>
        </div>

    </div>

</section>


{{-- =========================================================
     LIVE DEMO
========================================================= --}}
<section id="demo" class="relative scroll-mt-32 overflow-hidden py-24"
         x-data="{ i: 0, n: {{ count($demo) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 3600) }, pick(k) { this.i = k; this.start() } }"
         x-init="start()">

    <div class="about-blob -left-24 bottom-0 h-96 w-96 bg-brand-800"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Live demo</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Menus that <span class="about-gradient-text">sell more.</span></h2>
            <p class="mt-5 text-lg text-gray-300">Rich food photos, combos and specials: the kiosk upsells while your team cooks.</p>
        </div>

        <div class="mt-12 grid items-center gap-10 lg:grid-cols-5">

            <div class="lg:col-span-2 lg:order-2" data-reveal="right">
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                    @foreach ($demo as $k => $item)
                        <button type="button" @click="pick({{ $k }})"
                                class="relative flex items-center gap-4 overflow-hidden rounded-2xl border p-4 text-left transition duration-300"
                                :class="i === {{ $k }} ? 'border-brand-500/50 bg-white/10' : 'border-white/10 hover:bg-white/5'">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition" :class="i === {{ $k }} ? 'bg-brand-600 text-white' : 'bg-white/10 text-gray-300'">
                                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>
                            </span>
                            <span class="font-semibold">{{ $item['place'] }}</span>
                            <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-brand-red" :class="i === {{ $k }} ? 'centum-thumb-progress [animation-duration:3.6s]' : 'scale-x-0'"></span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-center lg:col-span-3 lg:order-1" data-reveal="left">
                <div class="relative w-[52%] max-w-[18rem]">
                    <div class="absolute -inset-10 rounded-full bg-brand-600/20 blur-3xl"></div>
                    <div class="relative grid">
                        @foreach ($demo as $k => $item)
                            <img src="{{ $item['img'] }}" alt="{{ $item['place'] }} on the Yara Printing Kiosk" loading="lazy"
                                 class="col-start-1 row-start-1 w-full transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
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
     WHERE TO USE
========================================================= --}}
<section id="places" class="relative scroll-mt-32 overflow-hidden pb-24">

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Wherever people <span class="about-gradient-text">wait in line.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Restaurants, food courts, retail counters, clinics and offices: let customers serve themselves.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($posters as $i => $poster)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $poster['img'] }}" alt="Yara Printing Kiosk in {{ strtolower($poster['place']) }}" loading="lazy"
                         class="aspect-[4/5] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                </figure>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach ([
                ['coffee', 'Cafés & QSR'], ['clapperboard', 'Cinemas & ticketing'], ['hospital', 'Hospitals & clinics'],
                ['building', 'Office canteens'], ['hotel', 'Hotels & check-in'], ['store', 'Retail self-checkout'],
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
     FEATURES
========================================================= --}}
<section class="bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Features</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Everything at the <span class="text-brand-600">point of order.</span></h2>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
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

    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative overflow-hidden py-28 text-center">

    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-brand-700"></div>

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Shorter queues. <span class="about-gradient-text">Bigger orders.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us about your business and we'll set up the kiosk with your menu, software and printing.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.product', $product) }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                View product details
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>

</section>

</div>

@endsection
