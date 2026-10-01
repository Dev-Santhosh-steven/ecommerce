@extends('layouts.store')

@section('title', 'Yara Glass Displays | Rugged 24/7 Touch Displays with Scanner')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $base = fn ($file) => asset("storage/products/glass-displays/{$file}");
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the Glass Display. Please share details and pricing.');

    $spaces = [
        ['slug' => 'office', 'icon' => 'briefcase', 'name' => 'Smart offices', 'title' => 'Check in. Book. Control.',
         'text' => 'Wall-mounted at desks and doors for check-in, desk booking, access and building controls.',
         'uses' => ['Desk & hot-desk booking', 'Visitor check-in', 'Lighting & climate control']],
        ['slug' => 'meeting', 'icon' => 'calendar-clock', 'name' => 'Meeting rooms', 'title' => 'Rooms that manage themselves.',
         'text' => 'Show live availability outside every room and let teams book or extend a meeting with a tap.',
         'uses' => ['Live room status', 'Tap to book or extend', 'Calendar integration']],
        ['slug' => 'lobby', 'icon' => 'gem', 'name' => 'Lobbies & showrooms', 'title' => 'Glass that carries your brand.',
         'text' => 'A sleek glass front that looks at home in premium interiors, not just on the shop floor.',
         'uses' => ['Premium glass finish', 'Wayfinding & directories', 'Product information']],
        ['slug' => 'cafeteria', 'icon' => 'utensils', 'name' => 'Corporate cafeterias', 'title' => 'Scan. Order. Eat.',
         'text' => 'Employees scan their ID or QR code, order and pay at the counter without waiting in line.',
         'uses' => ['Scan-to-order', 'Employee ID & wallet', 'Menu & nutrition info']],
        ['slug' => 'canteen', 'icon' => 'cup-soda', 'name' => 'Canteens & vending', 'title' => 'Scan, peel, blend, sip.',
         'text' => 'Built into automated food and drink stations that run all day, every day, with little upkeep.',
         'uses' => ['Automated beverage stations', 'QR / barcode scanning', '24/7 self-service']],
        ['slug' => 'exhibition', 'icon' => 'store', 'name' => 'Exhibitions & retail', 'title' => 'Built to be touched all day.',
         'text' => 'Rugged glass and fast touch for busy stands, stores and public spaces with heavy footfall.',
         'uses' => ['Product catalogues', 'Lead capture', 'Interactive demos']],
    ];

    $tough = [
        ['icon' => 'clock', 'value' => '24/7', 'label' => 'Continuous operation', 'text' => 'Industrial-grade panel made to run round the clock.'],
        ['icon' => 'thermometer', 'value' => 'Wide', 'label' => 'Operating temperature', 'text' => 'Reliable in hot kitchens, cold stores and factory floors.'],
        ['icon' => 'shield-check', 'value' => 'Metal', 'label' => 'Housing options', 'text' => 'Durable enclosures that take knocks, dust and vibration.'],
        ['icon' => 'pointer', 'value' => 'Touch', 'label' => 'Responsive interface', 'text' => 'Fast, accurate touch for operators and customers alike.'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#070a14] text-white">

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative overflow-hidden pb-16 pt-14 sm:pt-20">

    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob -left-32 top-24 h-[30rem] w-[30rem] bg-blue-800/70"></div>
    <div class="about-blob -right-24 top-10 h-[24rem] w-[24rem] bg-brand-red/30 [animation-delay:-6s]"></div>

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Commercial Display Solutions
            </p>
            <h1 class="mt-6 text-5xl font-bold sm:text-7xl">
                Glass <span class="bg-gradient-to-r from-sky-300 via-blue-400 to-blue-600 bg-clip-text text-transparent">Displays</span>
            </h1>
            <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Built for mission-critical environments. Rugged, 24/7 touch displays with a sleek glass front and built-in scanner.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="{{ route('store.product', $product) }}" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-blue-950/50 transition hover:bg-blue-500">
                    View details
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <div class="mt-10 flex flex-wrap justify-center gap-3 lg:justify-start">
                @foreach (['24/7 Operation', 'Glass Front', 'Touch + Scanner', 'Metal Housing', 'Price on request'] as $pill)
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">{{ $pill }}</span>
                @endforeach
            </div>
        </div>

        {{-- Bottom padding leaves room for the float animation so the panel's lower edge is never clipped --}}
        <div class="relative mx-auto w-full max-w-xl pb-10 pt-4">
            <div class="absolute inset-x-[8%] bottom-[8%] top-[20%] rounded-full bg-blue-600/30 blur-3xl"></div>
            <img src="{{ $base('glass-display-cutout.png') }}" alt="Yara Glass Display" class="centum-hero-tv relative mx-auto w-[64%] drop-shadow-[0_30px_40px_rgba(0,0,0,0.55)]">
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#070a14]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Glass Display</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Rugged · 24/7 · Touch + scanner · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#tough" class="transition hover:text-white">Built tough</a>
            <a href="#spaces" class="transition hover:text-white">Where to use</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     BUILT TOUGH
========================================================= --}}
<section id="tough" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="about-grid absolute inset-0 opacity-40"></div>
    <div class="about-blob -right-24 bottom-0 h-96 w-96 bg-blue-800/60"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="grid items-end gap-6 lg:grid-cols-2" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-400">Built tough</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Made for places a TV <span class="bg-gradient-to-r from-sky-300 to-blue-500 bg-clip-text text-transparent">wouldn't survive.</span></h2>
            </div>
            <p class="max-w-lg text-gray-300 lg:justify-self-end">Kitchens, factory floors, control rooms and busy public spaces: industrial parts chosen for years of dependable service.</p>
        </div>

        <div class="mt-14 grid gap-6 lg:grid-cols-5">

            <div class="grid gap-5 sm:grid-cols-2 lg:col-span-3">
                @foreach ($tough as $i => $item)
                    <div class="group rounded-3xl border border-white/10 bg-white/[0.04] p-7 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-sky-400/40 hover:bg-white/[0.07]"
                         data-reveal style="--reveal-delay: {{ $i * 100 }}ms">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-400 to-blue-700 text-white shadow-lg shadow-blue-900/40 transition group-hover:-rotate-6">
                            <i data-lucide="{{ $item['icon'] }}" class="h-6 w-6"></i>
                        </span>
                        <p class="mt-6 font-display text-4xl font-extrabold">{{ $item['value'] }}</p>
                        <p class="mt-1 text-lg font-semibold">{{ $item['label'] }}</p>
                        <p class="mt-2 text-sm leading-6 text-gray-400">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>

            <figure class="relative overflow-hidden rounded-3xl ring-1 ring-white/10 lg:col-span-2" data-reveal="right">
                <img src="{{ asset('storage/products/glass-displays/glass-display-installed.jpg') }}" alt="Yara Glass Display with metal mounting bracket" loading="lazy"
                     class="h-full w-full object-cover">
                <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                    <p class="font-semibold">Flush wall or panel mounting</p>
                    <p class="text-sm text-gray-300">Metal bracket and housing, efficient heat dissipation.</p>
                </figcaption>
            </figure>

        </div>

    </div>

</section>


{{-- =========================================================
     WHERE TO USE — space explorer
========================================================= --}}
<section id="spaces" class="relative scroll-mt-32 overflow-hidden bg-[#f4f4f5] py-24 text-gray-900"
         x-data="{ s: 0, n: {{ count($spaces) }}, t: null,
                   start() { clearInterval(this.t); this.t = setInterval(() => this.s = (this.s + 1) % this.n, 5000) },
                   pick(k) { this.s = k; this.start() } }"
         x-init="start()">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Where to use</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">One display. <span class="text-blue-600">Every space.</span></h2>
            <p class="mt-5 text-lg text-gray-600">From the boardroom to the canteen, the same rugged display fits right in.</p>
        </div>

        {{-- Space tabs --}}
        <div class="mt-12 flex gap-2 overflow-x-auto pb-2 [scrollbar-width:none] lg:justify-center" data-reveal>
            @foreach ($spaces as $k => $space)
                <button type="button" @click="pick({{ $k }})"
                        class="relative inline-flex shrink-0 items-center gap-2 overflow-hidden rounded-full px-5 py-3 text-sm font-semibold transition"
                        :class="s === {{ $k }} ? 'bg-gray-900 text-white shadow-lg' : 'bg-white text-gray-600 ring-1 ring-gray-200 hover:text-gray-900'">
                    <i data-lucide="{{ $space['icon'] }}" class="h-4 w-4"></i>
                    {{ $space['name'] }}
                    <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-blue-500" :class="s === {{ $k }} ? 'centum-thumb-progress [animation-duration:5s]' : 'scale-x-0'"></span>
                </button>
            @endforeach
        </div>

        <div class="mt-8 grid items-stretch gap-6 lg:grid-cols-5" data-reveal>

            {{-- Scene with the display in it --}}
            <div class="relative aspect-[4/3] overflow-hidden rounded-[2rem] bg-gray-900 lg:col-span-3 lg:aspect-auto lg:min-h-[34rem]">
                @foreach ($spaces as $k => $space)
                    <div class="absolute inset-0 transition-opacity duration-700" :class="s === {{ $k }} ? 'opacity-100' : 'opacity-0'" @if ($k > 0) style="opacity: 0" @endif :style="''">
                        <img src="{{ $base('scene-' . $space['slug'] . '.jpg') }}" alt="{{ $space['name'] }}" loading="lazy"
                             class="h-full w-full object-cover transition duration-[5000ms] ease-linear" :class="s === {{ $k }} ? 'scale-105' : 'scale-100'">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-black/50"></div>
                        <img src="{{ $base('glass-display-cutout.png') }}" alt="Yara Glass Display in {{ strtolower($space['name']) }}" loading="lazy"
                             class="absolute bottom-[6%] right-[5%] w-[24%] drop-shadow-[0_25px_35px_rgba(0,0,0,0.55)] transition duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                             :class="s === {{ $k }} ? 'translate-y-0 opacity-100' : 'translate-y-6 opacity-0'">
                    </div>
                @endforeach
            </div>

            {{-- Copy --}}
            <div class="relative rounded-[2rem] bg-white p-8 ring-1 ring-gray-200 sm:p-10 lg:col-span-2">
                @foreach ($spaces as $k => $space)
                    <div x-show="s === {{ $k }}" @if ($k > 0) x-cloak @endif>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-600/30">
                            <i data-lucide="{{ $space['icon'] }}" class="h-6 w-6"></i>
                        </span>
                        <p class="mt-6 text-sm font-semibold uppercase tracking-wider text-gray-400">{{ $space['name'] }}</p>
                        <h3 class="mt-2 text-3xl font-bold sm:text-4xl">{{ $space['title'] }}</h3>
                        <p class="mt-4 text-gray-600">{{ $space['text'] }}</p>
                        <ul class="mt-8 space-y-3">
                            @foreach ($space['uses'] as $use)
                                <li class="flex items-center gap-3">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                        <i data-lucide="check" class="h-3.5 w-3.5"></i>
                                    </span>
                                    <span class="font-medium">{{ $use }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     POSTERS
========================================================= --}}
<section class="relative overflow-hidden py-24">

    <div class="about-blob -left-24 top-0 h-96 w-96 bg-blue-800/60"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-400">Gallery</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Installed where <span class="bg-gradient-to-r from-sky-300 to-blue-500 bg-clip-text text-transparent">work happens.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Offices, meeting rooms, lobbies, cafeterias, canteens and exhibition stands.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($spaces as $i => $space)
                <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ ($i % 3) * 110 }}ms">
                    <img src="{{ $base('poster-' . $space['slug'] . '.jpg') }}" alt="Yara Glass Display in {{ strtolower($space['name']) }}" loading="lazy"
                         class="aspect-[4/5] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                </figure>
            @endforeach
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-3" data-reveal>
            @foreach ([
                ['factory', 'Factories & HMI'], ['monitor-cog', 'Control rooms'], ['cup-soda', 'Vending & beverage'],
                ['building-2', 'Smart buildings'], ['hospital', 'Hospitals'], ['store', 'Retail & exhibitions'],
            ] as [$icon, $label])
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-sky-400"></i>
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
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Engineered for <span class="text-blue-600">mission-critical use.</span></h2>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($product->features as $feature)
                <div class="group rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-blue-200">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-blue-700 text-white shadow-lg shadow-blue-600/30 transition group-hover:-rotate-6">
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
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-blue-700/70"></div>

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Rugged inside. <span class="bg-gradient-to-r from-sky-300 to-blue-500 bg-clip-text text-transparent">Ready for anywhere.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us where it goes and what it runs. We'll set it up and integrate it with your systems.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-blue-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-blue-950/50 transition hover:bg-blue-500">
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
