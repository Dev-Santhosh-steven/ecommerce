@extends('layouts.store')

@section('title', 'Yara 10" Table Top Standee | Virtual Try-On, Digital Menus & Promotions')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $base = fn ($file) => asset("storage/products/table-top-standee/{$file}");
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the 10" Table Top Standee. Please share details and pricing.');

    $looks = [
        ['img' => $base('screen-emerald.jpg'), 'standee' => $base('standee-emerald.png'), 'name' => 'Emerald Bridal Set'],
        ['img' => $base('screen-earrings.jpg'), 'standee' => $base('standee-earrings.png'), 'name' => 'Gold Leaf Earrings'],
        ['img' => $base('screen-pearls.jpg'), 'standee' => $base('standee-pearls.png'), 'name' => 'Heritage Pearl Choker'],
    ];

    $steps = [
        ['icon' => 'scan-face', 'title' => 'Look into the screen', 'text' => 'The front camera shows the customer, live.'],
        ['icon' => 'gem', 'title' => 'Pick a piece', 'text' => 'Necklaces, earrings and sets from your catalogue.'],
        ['icon' => 'sparkles', 'title' => 'See it on you', 'text' => 'The jewellery appears on the customer in real time.'],
        ['icon' => 'share-2', 'title' => 'Save & share', 'text' => 'Capture the look and share it, then buy at the counter.'],
    ];

    $demo = [
        ['img' => $base('standee-emerald.png'), 'place' => 'Jewellery try-on', 'icon' => 'gem'],
        ['img' => $base('standee-earrings.png'), 'place' => 'Earring collections', 'icon' => 'sparkles'],
        ['img' => $base('standee-pearls.png'), 'place' => 'Luxury welcome', 'icon' => 'crown'],
        ['img' => $base('standee-menu.png'), 'place' => 'Digital menu', 'icon' => 'utensils-crossed'],
        ['img' => $base('standee-pho.png'), 'place' => "Today's special", 'icon' => 'soup'],
        ['img' => $base('standee-dumplings.png'), 'place' => "Chef's pick", 'icon' => 'chef-hat'],
    ];

    $posters = [
        ['img' => $base('poster-jewellery.jpg'), 'place' => 'Jewellery stores'],
        ['img' => $base('poster-restaurant.jpg'), 'place' => 'Restaurants & cafés'],
        ['img' => $base('poster-retail.jpg'), 'place' => 'Retail counters'],
        ['img' => $base('poster-hotel.jpg'), 'place' => 'Hotels & reception'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0b1122] text-white">

{{-- =========================================================
     HERO — navy & gold boutique, halo ring, marble counter
========================================================= --}}
<section class="tts-navy relative overflow-hidden">

    <div class="tts-arches" aria-hidden="true"></div>
    <div class="tts-spots" aria-hidden="true"></div>

    <div class="relative mx-auto grid max-w-[1500px] items-end gap-10 px-4 pt-16 sm:px-6 lg:grid-cols-2 lg:px-10 lg:pt-20">

        <div class="about-intro pb-10 text-center lg:pb-28 lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-[#e8c478]/30 bg-black/20 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-[#f1d48f] backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Commercial Display Solutions
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-7xl">
                <span class="tts-gold">10"</span> Table Top<br>Standee
            </h1>
            <p class="mx-auto mt-5 max-w-md text-lg text-gray-300 lg:mx-0">
                A small screen with big charm. Virtual try-on, digital menus and promotions, right on your counter.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="#mirror" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#f1d48f] to-[#c8963e] px-7 py-4 text-sm font-semibold text-[#1a1208] shadow-lg shadow-black/40 transition hover:brightness-110">
                    Explore the standee
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <div class="mt-10 flex flex-wrap justify-center gap-3 lg:justify-start">
                @foreach (['10" Touchscreen', 'Front Camera', 'Virtual Try-On', 'Price on request'] as $pill)
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">{{ $pill }}</span>
                @endforeach
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-lg" data-reveal="zoom">
            <div class="absolute inset-[12%] top-[20%] rounded-full bg-[#f1d48f]/30 blur-3xl"></div>
            <div class="tts-halo"></div>
            <img src="{{ $base('standee-emerald.png') }}" alt="Yara 10 inch Table Top Standee with virtual jewellery try-on" class="relative z-10 mx-auto w-[82%]">
        </div>

    </div>

    <div class="tts-marble relative -mt-10 h-24 sm:h-32" aria-hidden="true"></div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b1122]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara 10" Table Top Standee</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Try-on · Menus · Promotions · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#mirror" class="transition hover:text-white">Virtual try-on</a>
            <a href="#menu" class="transition hover:text-white">Digital menu</a>
            <a href="#demo" class="transition hover:text-white">Live demo</a>
            <a href="#product" class="transition hover:text-white">Product</a>
            <a href="#places" class="transition hover:text-white">Where to use</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     MAGIC MIRROR — virtual try-on
========================================================= --}}
<section id="mirror" class="relative scroll-mt-32 overflow-hidden bg-[#f7f3ec] py-24 text-gray-900"
         x-data="{ i: 0, n: {{ count($looks) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 3400) } }"
         x-init="start()">

    <div class="mx-auto grid max-w-[1500px] items-center gap-16 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div class="relative mx-auto w-full max-w-[20rem]" data-reveal="left">
            <div class="absolute -inset-10 rounded-full bg-[#e8c478]/30 blur-3xl"></div>
            {{-- The try-on runs on the standee itself: cross-fade the device showing each look --}}
            <div class="relative grid" data-no-auto-reveal>
                @foreach ($looks as $k => $look)
                    <img src="{{ $look['standee'] }}" alt="{{ $look['name'] }} virtual try-on on the Yara Table Top Standee" loading="lazy"
                         class="col-start-1 row-start-1 w-full drop-shadow-[0_30px_40px_rgba(60,40,10,0.25)] transition-opacity duration-1000"
                         :class="i === {{ $k }} ? 'opacity-100' : 'opacity-0'"
                         @if ($k > 0) style="opacity: 0" @endif :style="''">
                @endforeach
            </div>
            <div class="mx-auto mt-6 flex justify-center gap-2">
                @foreach ($looks as $k => $look)
                    <button type="button" @click="i = {{ $k }}; start()" class="h-2 rounded-full transition-all" :class="i === {{ $k }} ? 'w-8 bg-[#b8862f]' : 'w-2 bg-gray-300'" aria-label="Show {{ $look['name'] }}"></button>
                @endforeach
            </div>
        </div>

        <div data-reveal="right">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#b8862f]">Virtual try-on</p>
            <h2 class="mt-3 font-display text-4xl font-bold sm:text-5xl">A closer look <span class="text-[#b8862f]">reveals the sparkle.</span></h2>
            <p class="mt-5 max-w-lg text-lg text-gray-600">Customers see every necklace and earring on themselves, without opening a single display case.</p>

            <ol class="mt-10 grid gap-4 sm:grid-cols-2">
                @foreach ($steps as $k => $s)
                    <li class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-[#e8dcc4]">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-[#f1d48f] to-[#b8862f] text-[#1a1208]">
                            <i data-lucide="{{ $s['icon'] }}" class="h-5 w-5"></i>
                        </span>
                        <p class="mt-4 text-xs font-semibold uppercase tracking-wider text-gray-400">Step {{ $k + 1 }}</p>
                        <p class="font-bold">{{ $s['title'] }}</p>
                        <p class="mt-1 text-sm leading-6 text-gray-600">{{ $s['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

    </div>

</section>


{{-- =========================================================
     DIGITAL MENU — cream / olive wave with floating plates
========================================================= --}}
<section id="menu" class="tts-menu-band scroll-mt-32 py-24 text-gray-900">

    <svg class="tts-wave h-full" viewBox="0 0 400 800" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M120 0 C 40 120, 200 220, 90 360 S 60 620, 150 800 L 400 800 L 400 0 Z" />
    </svg>

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-[1fr_auto_1fr] lg:px-10">

        <div data-reveal="left">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#5c6e3a]">Digital menu</p>
            <h2 class="mt-3 font-display text-4xl font-bold sm:text-5xl">Menus that <span class="text-[#5c6e3a]">make mouths water.</span></h2>
            <p class="mt-5 max-w-md text-lg text-gray-600">Mouth-watering photos, daily specials and table ordering, right where your guests sit.</p>
            <ul class="mt-8 space-y-4">
                @foreach ([['leaf', 'Fresh photos, updated in minutes'], ['heart', 'Specials that sell themselves'], ['shopping-bag', 'Order and pay from the table'], ['languages', 'Menus in every language']] as [$icon, $label])
                    <li class="flex items-center gap-4">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full border border-[#5c6e3a]/40 text-[#5c6e3a]">
                            <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                        </span>
                        <span class="font-medium">{{ $label }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="relative mx-auto w-64 sm:w-72" data-reveal="zoom">
            <img src="{{ $base('standee-menu.png') }}" alt="Digital menu on the Yara Table Top Standee" loading="lazy" class="relative w-full drop-shadow-2xl">
        </div>

        <div class="relative hidden h-[30rem] lg:block" aria-hidden="true">
            <img src="{{ $base('screen-pho.jpg') }}" alt="" loading="lazy" class="tts-plate absolute left-[18%] top-0 h-40 w-40 object-cover object-[50%_42%]">
            <img src="{{ $base('screen-dumplings.jpg') }}" alt="" loading="lazy" class="tts-plate absolute right-[6%] top-[34%] h-44 w-44 object-cover object-[50%_62%]" style="--d: -2.3s">
            <img src="{{ $base('screen-pho.jpg') }}" alt="" loading="lazy" class="tts-plate absolute bottom-0 left-[10%] h-36 w-36 object-cover object-[35%_55%]" style="--d: -4.6s">
            <span class="tts-crumb left-[60%] top-[12%] h-2.5 w-2.5 bg-[#c0392b]"></span>
            <span class="tts-crumb left-[8%] top-[48%] h-2 w-2 bg-[#e8c478]" style="animation-delay:-1s"></span>
            <span class="tts-crumb left-[52%] top-[80%] h-3 w-3 bg-white/80" style="animation-delay:-2s"></span>
        </div>

    </div>

</section>


{{-- =========================================================
     LIVE DEMO
========================================================= --}}
<section id="demo" class="relative scroll-mt-32 overflow-hidden py-24"
         x-data="{ i: 0, n: {{ count($demo) }}, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.i = (this.i + 1) % this.n, 3200) }, pick(k) { this.i = k; this.start() } }"
         x-init="start()">

    <div class="tts-arches opacity-60" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#e8c478]">Live demo</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">One standee. <span class="tts-gold">Endless stories.</span></h2>
        </div>

        <div class="mt-12 grid items-center gap-10 lg:grid-cols-5">

            <div class="lg:order-2 lg:col-span-2" data-reveal="right">
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($demo as $k => $item)
                        <button type="button" @click="pick({{ $k }})"
                                class="relative flex items-center gap-4 overflow-hidden rounded-2xl border p-4 text-left transition duration-300"
                                :class="i === {{ $k }} ? 'border-[#e8c478]/50 bg-white/10' : 'border-white/10 hover:bg-white/5'">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition" :class="i === {{ $k }} ? 'bg-gradient-to-br from-[#f1d48f] to-[#b8862f] text-[#1a1208]' : 'bg-white/10 text-gray-300'">
                                <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5"></i>
                            </span>
                            <span class="font-semibold">{{ $item['place'] }}</span>
                            <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-[#e8c478]" :class="i === {{ $k }} ? 'centum-thumb-progress [animation-duration:3.2s]' : 'scale-x-0'"></span>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-center lg:order-1 lg:col-span-3" data-reveal="left">
                <div class="relative w-[62%] max-w-[22rem]">
                    <div class="absolute -inset-10 rounded-full bg-[#e8c478]/15 blur-3xl"></div>
                    <div class="relative grid">
                        @foreach ($demo as $k => $item)
                            <img src="{{ $item['img'] }}" alt="{{ $item['place'] }} on the Yara Table Top Standee" loading="lazy"
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
     PRODUCT — comes after the explore content
========================================================= --}}
<section id="product" class="relative scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        <div class="grid items-center gap-10 overflow-hidden rounded-[2rem] bg-[#f7f3ec] p-8 ring-1 ring-[#e8dcc4] sm:p-12 lg:grid-cols-2" data-reveal>
            <div class="relative mx-auto w-full max-w-sm">
                <div class="absolute inset-8 rounded-full bg-[#e8c478]/30 blur-3xl"></div>
                <img src="{{ $base('standee-trio.png') }}" alt="Yara 10 inch Table Top Standees" loading="lazy" class="relative w-full">
            </div>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#b8862f]">The product</p>
                <h2 class="mt-3 font-display text-4xl font-bold sm:text-5xl">{{ $product->name }}</h2>
                <p class="mt-4 text-gray-600">{{ $product->short_description }}</p>
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach (['10"', 'Portrait', 'Front camera', 'USB · LAN'] as $pill)
                        <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-gray-700 ring-1 ring-[#e8dcc4]">{{ $pill }}</span>
                    @endforeach
                </div>
                <p class="mt-6 font-semibold text-gray-900">Price on request</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ route('store.product', $product) }}" class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-7 py-3.5 text-sm font-semibold text-white transition hover:bg-[#b8862f]">
                        View details
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                    <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-7 py-3.5 text-sm font-semibold transition hover:border-[#b8862f] hover:text-[#b8862f]">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>
                        Enquire
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>


{{-- =========================================================
     WHERE TO USE
========================================================= --}}
<section id="places" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#e8c478]">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Every counter, <span class="tts-gold">every table.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Jewellery stores, restaurants, retail billing counters and hotel receptions: a compact screen that sells.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($posters as $i => $poster)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $poster['img'] }}" alt="Yara Table Top Standee in {{ strtolower($poster['place']) }}" loading="lazy"
                         class="aspect-[4/5] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                </figure>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     FEATURES + SPECS
========================================================= --}}
<section id="specs" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#b8862f]">Features</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Small screen. <span class="text-[#b8862f]">Big impression.</span></h2>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($product->features as $i => $feature)
                <div class="group rounded-3xl bg-[#f7f3ec] p-7 ring-1 ring-[#e8dcc4] transition duration-300 hover:-translate-y-1 hover:shadow-xl" data-reveal style="--reveal-delay: {{ $i * 80 }}ms">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#f1d48f] to-[#b8862f] text-[#1a1208] shadow-lg shadow-[#b8862f]/30 transition group-hover:-rotate-6">
                        <i data-lucide="{{ $feature->icon }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ $feature->title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $feature->description }}</p>
                </div>
            @endforeach
        </div>

        <div class="mx-auto mt-20 max-w-5xl">
            <h3 class="text-center text-3xl font-bold" data-reveal>Specifications</h3>
            <dl class="mt-8 grid gap-x-12 sm:grid-cols-2" data-reveal>
                @foreach ($product->specifications ?? [] as $key => $value)
                    <div class="flex items-baseline justify-between gap-6 border-b border-gray-200 py-4">
                        <dt class="text-sm text-gray-500">{{ $key }}</dt>
                        <dd class="text-right font-semibold">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="tts-navy relative overflow-hidden py-28 text-center">

    <div class="tts-arches" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Make every counter <span class="tts-gold">shine.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us about your store or restaurant and we'll set up the standee with your try-on, menu or promotions.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#f1d48f] to-[#c8963e] px-7 py-4 text-sm font-semibold text-[#1a1208] shadow-lg shadow-black/40 transition hover:brightness-110">
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
