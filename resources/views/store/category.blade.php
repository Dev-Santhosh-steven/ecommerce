@extends('layouts.store')

@section('title', $category->name . ' | Yara Store')

@section('content')

{{-- =========================================================
     CATEGORY BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="relative h-[300px] w-full overflow-hidden bg-[#0a0a0f] sm:h-[360px] lg:h-[440px]">

        {{-- Banners are 3:1 artwork with the product on the right: show them whole, anchored right,
             so the product is never cropped; the dark left side melts into the page for the title. --}}
        @if ($category->banner || $category->image)
            <img
                src="{{ asset('storage/' . ($category->banner ?: $category->image)) }}"
                alt="{{ $category->name }}"
                class="absolute inset-y-0 right-0 h-full w-auto max-w-none [mask-image:linear-gradient(to_right,transparent,transparent_14%,black_34%)] {{ $category->banner ? '' : 'opacity-60' }}"
            >
        @endif

        <div class="absolute inset-0 bg-gradient-to-r from-[#0a0a0f] via-[#0a0a0f]/70 via-35% to-transparent to-60%"></div>
        <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-[#0a0a0f]/80 to-transparent"></div>

        <div class="absolute inset-0 flex items-end">

            <div class="mx-auto w-full max-w-[1500px] px-4 pb-10 sm:px-6 lg:px-10">

                <nav class="mb-3 text-sm text-gray-300">

                    <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>

                    @if ($category->parent)
                        <span class="mx-2">/</span>
                        <a href="{{ route('store.category', $category->parent) }}" class="hover:text-white">{{ $category->parent->name }}</a>
                    @endif

                    <span class="mx-2">/</span>
                    <span class="text-white">{{ $category->name }}</span>

                </nav>

                <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
                    {{ $category->name }}
                </h1>

                @if ($category->description)

                    <p class="mt-3 max-w-2xl text-gray-300">
                        {{ $category->description }}
                    </p>

                @endif

                @if ($hasLedCalculator)

                    <a href="{{ route('store.led-calculator') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">
                        <i data-lucide="calculator" class="h-4 w-4"></i>
                        Open the LED Wall Calculator
                    </a>

                @endif

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     CENTUM PROMO (TV categories) — Yara Centum 100"
========================================================= --}}
@if (in_array($category->slug, ['televisions', 'smart-tv', 'google-tv'], true))

    <section class="bg-white pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.centum') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0b0a0a] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -right-20 top-0 h-80 w-80 bg-brand-700"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Introducing
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="about-gradient-text">Centum</span> 100"</h2>
                    <p class="mt-4 max-w-md text-gray-300">A cinema-sized 4K UHD Smart LED TV with an A+ grade panel, Android 12 and 30W sound.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['100" 4K UHD', 'A+ Panel', 'Android 12', '30W Sound'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Discover Centum
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative">
                    <div class="centum-ambient"></div>
                    <img src="{{ asset('storage/products/centum/centum-neon.png') }}" alt="Yara Centum 100 inch 4K UHD Smart LED TV" loading="lazy"
                         class="relative w-full drop-shadow-[0_30px_40px_rgba(0,0,0,0.7)] transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     CHILLERS PROMO — links to the /chillers showcase
========================================================= --}}
@if ($category->slug === 'chillers')

    <section class="bg-white pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.chillers') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0a0b0e] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-50"></div>
                <div class="about-blob -right-20 top-0 h-80 w-80 bg-sky-700/60"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-sky-300">
                        <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                        Commercial Cooling
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="chill-gradient-text">Chillers</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">50% less power, 100% cooling power. Chiller-based AC for malls, offices and large spaces.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['Quick Chill', 'Steady Temperature', 'Built Tough', 'Energy Saver'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore Chillers
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative">
                    <div class="absolute inset-[10%] rounded-full bg-sky-500/25 blur-3xl"></div>
                    <img src="{{ asset('storage/products/chillers/chiller-cutout.png') }}" alt="Yara chiller-based AC plant" loading="lazy"
                         class="relative w-full drop-shadow-[0_30px_40px_rgba(0,0,0,0.7)] transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     INTERACTIVE PANELS PROMO — links to the /interactive-panels explore page
========================================================= --}}
@if ($category->slug === 'interactive-panels')

    <section class="bg-white pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.interactivepanels') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0b0a0a] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -right-20 top-0 h-80 w-80 bg-brand-700"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="about-gradient-text">Interactive Panels</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Smart boards for schools, colleges and coaching centres, on the wall or on a stand.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['55"', '65"', '75"', '85"', '100"', '4K Touch'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore Interactive Panels
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative">
                    <div class="centum-ambient"></div>
                    <img src="{{ asset('storage/products/interactive-panels/explore/ifp-range.png') }}" alt="Yara Interactive Panels in 55, 65, 75, 85 and 100 inch" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     ANTI-GLARE TV PROMO — links to the /anti-glare-tv explore page
========================================================= --}}
@if (in_array($category->slug, ['televisions', 'anti-glare-tv'], true))

    <section class="bg-white pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.antiglare') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0c0a08] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_75%_50%,rgba(255,150,60,0.25),transparent_60%)]"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-amber-300">
                        <span class="about-pulse h-2 w-2 rounded-full bg-amber-400"></span>
                        New · Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Anti-Glare <span class="bg-gradient-to-r from-amber-200 to-orange-300 bg-clip-text text-transparent">QLED TVs</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">A matte, anti-reflective 4K screen that stays clear in bright rooms. Drag the slider to see glossy vs anti-glare.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['65"', '75"', '86"', '100"', 'No reflections', 'QLED 4K'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-amber-400 px-6 py-3 text-sm font-bold text-[#1a1206] transition group-hover:bg-amber-300">
                        See the difference
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative">
                    <img src="{{ asset('storage/products/televisions/anti-glare/ag-compare.jpg') }}" alt="Glossy screen vs Yara anti-glare screen" loading="lazy"
                         class="w-full rounded-2xl transition duration-700 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     VIDEO WALL PROMOS — /led-video-walls and /lcd-video-walls explore pages
========================================================= --}}
@php
    $wallPromos = [
        'led-video-walls' => [
            ['route' => 'store.ledwalls', 'title' => 'LED Video Walls', 'accent' => 'about-gradient-text', 'button' => 'bg-brand-600 group-hover:bg-brand-500',
                'text' => 'See live LED walls on billboards, facades, stores and stages, and find the right pixel pitch.',
                'pills' => ['P1.25 – P10', 'Indoor', 'Outdoor', 'Rental'], 'img' => 'products/video-walls/scene-times.jpg', 'cta' => 'Explore LED Walls'],
            ['route' => 'store.lcdwalls', 'title' => 'LCD Video Walls', 'accent' => 'bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent', 'button' => 'bg-sky-500 group-hover:bg-sky-400',
                'text' => 'Need it sharper up close? Full HD panels with bezels from 0.88 mm, with an online wall builder.',
                'pills' => ['0.88 mm bezel', 'Full HD per panel', '24/7'], 'img' => 'products/lcd-video-walls/lcd-scene-retail.jpg', 'cta' => 'Explore LCD Walls'],
        ],
        'lcd-video-walls' => [
            ['route' => 'store.lcdwalls', 'title' => 'LCD Video Walls', 'accent' => 'bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent', 'button' => 'bg-sky-500 group-hover:bg-sky-400',
                'text' => 'Design your wall online: pick a panel and a layout, and see the size, resolution and panel count instantly.',
                'pills' => ['32" to 100"', '0.88 – 3.5 mm bezel', 'Wall builder'], 'img' => 'products/lcd-video-walls/lcd-scene-retail.jpg', 'cta' => 'Build Your Wall'],
        ],
    ][$category->slug] ?? [];
@endphp
@foreach ($wallPromos as $k => $promo)

    <section class="bg-white {{ $k ? 'pt-8' : 'pt-14' }}">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route($promo['route']) }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#05060a] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-50"></div>

                <div class="relative {{ $k % 2 ? 'lg:order-2' : '' }}">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300">
                        <span class="about-pulse h-2 w-2 rounded-full bg-red-500"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="{{ $promo['accent'] }}">{{ $promo['title'] }}</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">{{ $promo['text'] }}</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach ($promo['pills'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-semibold transition {{ $promo['button'] }}">
                        {{ $promo['cta'] }}
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative overflow-hidden rounded-2xl {{ $k % 2 ? 'lg:order-1' : '' }}">
                    <img src="{{ asset('storage/' . $promo['img']) }}" alt="{{ $promo['title'] }}" loading="lazy"
                         class="w-full transition duration-700 group-hover:scale-[1.04]">
                </div>

            </a>

        </div>
    </section>

@endforeach


{{-- =========================================================
     HOME AUDIO PROMO — links to the /home-audio explore page (anchored to the family on sub-categories)
========================================================= --}}
@php
    $audioAnchors = ['home-audio' => '', 'twin-tower-speakers' => '#twin', 'single-tower-speakers' => '#single', 'soundbars' => '#soundbar'];
@endphp
@if (array_key_exists($category->slug, $audioAnchors))

    <section class="bg-white pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.homeaudio') }}{{ $audioAnchors[$category->slug] }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#070605] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_75%_50%,rgba(245,181,74,0.22),transparent_60%)]"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#f5b54a]">
                        <span class="about-pulse h-2 w-2 rounded-full bg-[#f5b54a]"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="ha-gold-text">Home Audio</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Tower speakers and soundbars with deep, room-filling bass. Press play and feel the beat.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['Twin Tower', 'Single Tower', 'Soundbar + Subwoofer', 'Bluetooth', 'USB'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-[#f5b54a] px-6 py-3 text-sm font-bold text-[#1a1206] transition group-hover:bg-[#ffd88a]">
                        Explore Home Audio
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative">
                    <img src="{{ asset('storage/products/home-audio/category-home-audio.jpg') }}" alt="Yara twin tower, single tower and soundbar speakers" loading="lazy"
                         class="relative w-full rounded-2xl transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     COMMERCIAL DISPLAYS PROMO — links to the /commercial-displays explore page
========================================================= --}}
@if (in_array($category->slug, ['commercial-displays', 'commercial-display-solutions'], true))

    <section class="bg-white pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.commercialdisplays') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0b0a0a] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -left-20 top-0 h-80 w-80 bg-brand-700"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="about-gradient-text">Commercial Displays</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Slim 24/7 digital signage in 32" to 86", landscape or portrait, for stores, menus and lobbies.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['32"', '43"', '55"', '65"', '75"', '86"', '24/7'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore Commercial Displays
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative">
                    <div class="centum-ambient"></div>
                    <img src="{{ asset('storage/products/commercial-displays/cd-duo.png') }}" alt="Yara Commercial Displays in landscape and portrait" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     T-STANDEES PROMO — links to the /t-standees explore page
========================================================= --}}
@if (in_array($category->slug, ['t-standees', 'commercial-display-solutions'], true))

    <section class="bg-white pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.tstandees') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0b0a0a] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -right-20 top-0 h-80 w-80 bg-brand-700"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="about-gradient-text">T-Standees</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Digital signage that stands out, in 55", 65" and 75", for malls, showrooms, stores and lobbies.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['55"', '65"', '75"', 'Touch & Non-Touch'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore T-Standees
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative">
                    <div class="centum-ambient"></div>
                    <img src="{{ asset('storage/products/t-standees/t-standee-trio.png') }}" alt="Yara T-Standees in 55, 65 and 75 inch" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     A-STANDEES PROMO — links to the /a-standees explore page
========================================================= --}}
@if (in_array($category->slug, ['a-standees', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.astandees') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0b0a0a] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -left-20 top-0 h-80 w-80 bg-brand-700"></div>

                <div class="relative lg:order-2">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="about-gradient-text">A-Standees</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">The digital poster you can carry, in 32", 43" and 55", for entrances, counters and events.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['32"', '43"', '55"', 'Foldable A-frame'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore A-Standees
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative lg:order-1">
                    <div class="centum-ambient"></div>
                    <img src="{{ asset('storage/products/a-standees/a-standee-trio.png') }}" alt="Yara A-Standees in 32, 43 and 55 inch" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     PRINTING KIOSK PROMO — links to the /printing-kiosk explore page
========================================================= --}}
@if (in_array($category->slug, ['printing-kiosk', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.printingkiosk') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0b0a0a] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -right-20 top-0 h-80 w-80 bg-brand-700"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Yara <span class="about-gradient-text">Printing Kiosk</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Order, pay and print on a 21.5" self-service kiosk for restaurants, food courts, retail and clinics.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['21.5"', 'Built-in Printer', 'QR Scanner', 'Self-Order'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore the Kiosk
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative mx-auto w-full max-w-sm">
                    <div class="centum-ambient"></div>
                    <img src="{{ asset('storage/products/printing-kiosk/kiosk-pair.png') }}" alt="Yara 21.5 inch Printing Kiosks" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif


{{-- =========================================================
     STAND ALONE KIOSK PROMO — links to the /stand-alone-kiosk explore page
========================================================= --}}
@if (in_array($category->slug, ['stand-alone-kiosk', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.standalonekiosk') }}" data-reveal
               class="sak-room group relative grid items-center gap-8 overflow-hidden rounded-[2rem] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#e8be60]">
                        <span class="about-pulse h-2 w-2 rounded-full bg-[#e8be60]"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Stand Alone <span class="sak-gold">Kiosk</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Touch. Find. Explore. Tilted touchscreen kiosks for wayfinding, catalogues, check-in and visitor info.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['32"', '43"', '55"', 'Multi-touch', 'Tilted display'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#f1d48f] to-[#c8963e] px-6 py-3 text-sm font-semibold text-[#1a1208] transition group-hover:brightness-110">
                        Explore the Kiosk
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative mx-auto w-full max-w-md">
                    <div class="absolute inset-x-[10%] bottom-[10%] h-1/2 rounded-full bg-[#e8be60]/20 blur-3xl"></div>
                    <img src="{{ asset('storage/products/standalone-kiosk/kiosk-white-car.png') }}" alt="Yara Stand Alone Kiosk with a car showroom app" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     TABLE TOP STANDEE PROMO — links to the /table-top-standee explore page
========================================================= --}}
@if (in_array($category->slug, ['table-top-standee', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.tabletopstandee') }}" data-reveal
               class="tts-navy group relative grid items-center gap-8 overflow-hidden rounded-[2rem] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="tts-arches opacity-70"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-[#e8c478]">
                        <span class="about-pulse h-2 w-2 rounded-full bg-[#e8c478]"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl"><span class="tts-gold">10"</span> Table Top Standee</h2>
                    <p class="mt-4 max-w-md text-gray-300">Virtual jewellery try-on, digital menus and promotions on a compact counter-top touchscreen.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['10"', 'Front Camera', 'Virtual Try-On', 'Digital Menu'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-[#f1d48f] to-[#c8963e] px-6 py-3 text-sm font-semibold text-[#1a1208] transition group-hover:brightness-110">
                        Explore the Standee
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative mx-auto w-full max-w-md">
                    <div class="absolute inset-x-[10%] bottom-[10%] h-1/2 rounded-full bg-[#e8c478]/20 blur-3xl"></div>
                    <img src="{{ asset('storage/products/table-top-standee/standee-trio.png') }}" alt="Yara 10 inch Table Top Standees" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     GLASS DISPLAYS PROMO — links to the /glass-displays explore page
========================================================= --}}
@if (in_array($category->slug, ['glass-displays', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.glassdisplays') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#070a14] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -right-20 top-0 h-80 w-80 bg-blue-700/70"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-sky-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-sky-400"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Glass <span class="bg-gradient-to-r from-sky-300 to-blue-500 bg-clip-text text-transparent">Displays</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Rugged 24/7 touch displays with a glass front and scanner for offices, meeting rooms, canteens, factories and exhibitions.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['24/7', 'Glass Front', 'Touch + Scanner', 'Metal Housing'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-blue-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-blue-500">
                        Explore Glass Displays
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative mx-auto w-full max-w-md">
                    <div class="absolute inset-x-[10%] bottom-[10%] h-1/2 rounded-full bg-blue-600/30 blur-3xl"></div>
                    <img src="{{ asset('storage/products/glass-displays/glass-display-cutout.png') }}" alt="Yara Glass Display" loading="lazy"
                         class="relative mx-auto w-[62%] transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     DIGITAL PODIUM PROMO — links to the /digital-podium explore page
========================================================= --}}
@if (in_array($category->slug, ['digital-podium', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.digitalpodium') }}" data-reveal
               class="group relative grid min-h-[22rem] items-center overflow-hidden rounded-[2rem] bg-[#0b0908] text-white lg:grid-cols-2">

                <img src="{{ asset('storage/products/digital-podium/podium-auditorium.jpg') }}" alt="Yara 27 inch Digital Podium on stage" loading="lazy"
                     class="absolute inset-0 h-full w-full object-cover object-[70%_50%] transition duration-[1500ms] group-hover:scale-105">
                <div class="absolute inset-0 bg-gradient-to-r from-[#0b0908] via-[#0b0908]/85 to-transparent"></div>

                <div class="relative p-8 sm:p-12">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Digital <span class="about-gradient-text">Podium</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Smart presentations made simple: an all-in-one 27" touchscreen podium with dual microphones.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['27" Touch', 'Dual Mics', 'Height Adjustable', 'Android / Windows'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore the Podium
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     DOUBLE SIDE VERTICAL DISPLAY PROMO — links to the /double-side-vertical-display explore page
========================================================= --}}
@if (in_array($category->slug, ['double-side-vertical-display', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.doublesidedisplay') }}" data-reveal
               class="group relative grid items-center gap-6 overflow-hidden rounded-[2rem] bg-[#0b0b10] text-white lg:grid-cols-2">

                <div class="absolute -right-24 top-0 h-full w-2/3 bg-[radial-gradient(closest-side,rgba(165,29,53,0.45),transparent)]"></div>

                <div class="relative p-8 sm:p-12">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Double Side <span class="about-gradient-text">Vertical Display</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">One display, two audiences: a 43" Full HD screen on each face, sunlight-readable for shop windows and built for 24/7.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['43"', 'Double-sided', 'Sunlight-readable', '24/7'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore the Display
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative flex h-full items-end justify-center gap-6 px-8 pt-10 sm:gap-10 lg:pt-0">
                    <img src="{{ asset('storage/products/double-side-vertical-display/dsvd-front.png') }}" alt="Yara 43 inch Double Side Vertical Display" loading="lazy"
                         class="w-[38%] max-w-[13rem] drop-shadow-[0_30px_40px_rgba(0,0,0,0.6)] transition duration-700 group-hover:-translate-y-2">
                    <img src="{{ asset('storage/products/double-side-vertical-display/dsvd-angle.png') }}" alt="" aria-hidden="true" loading="lazy"
                         class="w-[30%] max-w-[10rem] drop-shadow-[0_30px_40px_rgba(0,0,0,0.6)] transition delay-100 duration-700 group-hover:-translate-y-2">
                </div>

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     ROTATABLE DISPLAY PROMO — links to the /rotatable-display explore page
========================================================= --}}
@if (in_array($category->slug, ['rotatable-display', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.rotatabledisplay') }}" data-reveal
               class="group relative grid items-center gap-6 overflow-hidden rounded-[2rem] bg-[#09090c] text-white lg:grid-cols-2"
               x-data="{ p: false, tilt: 0, init() { setInterval(() => this.p = ! this.p, 3200) } }">

                <div class="absolute -right-24 top-0 h-full w-2/3 bg-[radial-gradient(closest-side,rgba(165,29,53,0.45),transparent)]"></div>

                <div class="relative p-8 sm:p-12">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Rotatable <span class="about-gradient-text">Display</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Turn it, tilt it, take it anywhere: a 27" Full HD screen on a wheeled stand with its own battery.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['27"', 'Rotates 90°', 'On wheels', '9600 mAh'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore the Display
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative mx-auto w-[11rem] py-8 sm:w-[13rem]">
                    @include('store.partials.rd-unit', ['rotate' => true])
                </div>

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     INDUSTRIAL DISPLAYS PROMO — links to the /industrial-displays explore page
========================================================= --}}
@if (in_array($category->slug, ['industrial-displays', 'commercial-display-solutions'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.industrialdisplays') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#0b0c10] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-40"></div>
                <div class="absolute -right-24 top-0 h-full w-2/3 bg-[radial-gradient(closest-side,rgba(165,29,53,0.4),transparent)]"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Industrial <span class="about-gradient-text">Displays</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">An 8" Android touch display in a frameless metal body, with USB, LAN and Phoenix connectors for machines and factory floors.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['8" Touch', 'Android 11', 'Metal body', 'Phoenix I/O'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore Industrial Displays
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <img src="{{ asset('storage/products/industrial-displays/ind-front.png') }}" alt="Yara 8 inch Industrial Display" loading="lazy"
                     class="relative mx-auto w-full max-w-md drop-shadow-[0_30px_40px_rgba(0,0,0,0.6)] transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.02]">

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     COMMERCIAL WASHER PROMO — links to the /commercial-washing-machines explore page
========================================================= --}}
@if (in_array($category->slug, ['commercial-washing-machine', 'washing-machine'], true))

    <section class="bg-white pt-8 first:pt-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <a href="{{ route('store.commercialwashers') }}" data-reveal
               class="group relative grid items-center gap-8 overflow-hidden rounded-[2rem] bg-[#090b10] p-8 text-white sm:p-12 lg:grid-cols-2">

                <div class="about-grid absolute inset-0 opacity-60"></div>
                <div class="about-blob -right-20 top-0 h-80 w-80 bg-brand-700"></div>

                <div class="relative">
                    <p class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.3em] text-brand-400">
                        <span class="about-pulse h-2 w-2 rounded-full bg-brand-red"></span>
                        Flagship · Explore
                    </p>
                    <h2 class="mt-4 text-4xl font-bold sm:text-5xl">Commercial <span class="about-gradient-text">Washing Machine</span></h2>
                    <p class="mt-4 max-w-md text-gray-300">Fully automatic 10 – 25 kg washers for hotels, hospitals, laundries and institutions.</p>
                    <div class="mt-6 flex flex-wrap gap-2">
                        @foreach (['10 – 25 kg', 'Stainless steel drum', '1150 rpm', 'Coin option'] as $pill)
                            <span class="rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-gray-200">{{ $pill }}</span>
                        @endforeach
                    </div>
                    <span class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold transition group-hover:bg-brand-500">
                        Explore Commercial Washers
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </span>
                </div>

                <div class="relative mx-auto w-full max-w-md">
                    <div class="absolute inset-x-[10%] bottom-[10%] h-1/2 rounded-full bg-slate-400/20 blur-3xl"></div>
                    <img src="{{ asset('storage/products/commercial-washers/washer-hero.png') }}" alt="Yara commercial washing machine" loading="lazy"
                         class="relative w-full transition duration-700 group-hover:-translate-y-2 group-hover:scale-[1.03]">
                </div>

            </a>

        </div>
    </section>

@endif

{{-- =========================================================
     SUBCATEGORIES
========================================================= --}}
@if ($category->children->isNotEmpty())

    <section class="bg-white py-14">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-6 text-xl font-bold tracking-tight text-gray-900">
                Shop by Subcategory
            </h2>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">

                @foreach ($category->children as $child)

                    <a href="{{ route('store.category', $child) }}"
                       class="group relative overflow-hidden rounded-2xl bg-gray-100">

                        <div class="aspect-square">

                            @if ($child->image)

                                <img
                                    src="{{ asset('storage/' . $child->image) }}"
                                    alt="{{ $child->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                            @else

                                <div class="flex h-full w-full items-center justify-center bg-gray-200 text-gray-400">
                                    <i data-lucide="layers" class="h-8 w-8"></i>
                                </div>

                            @endif

                        </div>

                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4 pt-10">

                            <h3 class="text-sm font-semibold text-white">
                                {{ $child->name }}
                            </h3>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </section>

@endif


{{-- =========================================================
     PRODUCTS + FILTERS
========================================================= --}}
@if ($category->slug === 'lcd-video-walls' && $products->isEmpty())

    {{-- LCD video walls have no fixed models: sizes 32" to 100", configured per project --}}
    <section class="bg-gray-50 py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-gray-200 sm:p-12">
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Availability</p>
                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Available from <span class="text-sky-600">32" to 100"</span></h2>
                <p class="mt-4 max-w-2xl text-gray-600">There are no fixed models. Every Yara LCD video wall is configured for your space: choose any panel size from 32" to 100", a bezel from 3.5 mm down to 0.88 mm, and a layout from 2 × 2 upwards. We quote, install and support it.</p>
                <div class="mt-8 flex flex-wrap gap-2">
                    @foreach (['32"', '43"', '46"', '49"', '55"', '65"', '75"', '86"', '100"'] as $size)
                        <span class="rounded-full bg-gray-900 px-4 py-2 font-display text-sm font-bold text-white">{{ $size }}</span>
                    @endforeach
                </div>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('store.lcdwalls') }}#builder" class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-sky-400">
                        <i data-lucide="layout-grid" class="h-4 w-4"></i>
                        Build your wall
                    </a>
                    <a href="{{ route('store.lcdwalls') }}#details" class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-6 py-3.5 text-sm font-semibold text-gray-900 transition hover:bg-gray-50">
                        Full details
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

@else

<section class="bg-gray-50 py-14" x-data="{ mobileFiltersOpen: false }">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="lg:grid lg:grid-cols-[260px_1fr] lg:items-start lg:gap-10">

            {{-- Mobile backdrop --}}
            <div
                x-show="mobileFiltersOpen"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileFiltersOpen = false"
                class="fixed inset-0 z-40 bg-black/50 lg:hidden"
            ></div>

            {{-- Filters --}}
            <aside
                x-cloak
                :class="mobileFiltersOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 w-80 max-w-[85vw] overflow-y-auto bg-white transition-transform duration-300 lg:static lg:z-auto lg:mb-0 lg:w-auto lg:max-w-none lg:translate-x-0 lg:overflow-visible lg:bg-transparent lg:transition-none lg:sticky lg:top-24"
            >

                <div class="flex items-center justify-between border-b border-gray-200 p-5 lg:hidden">

                    <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">
                        Filters
                    </h2>

                    <button type="button" @click="mobileFiltersOpen = false" class="rounded-full p-1.5 text-gray-500 hover:bg-gray-100">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>

                </div>

                <form id="category-filters" method="GET" action="{{ route('store.category', $category) }}" class="space-y-8 p-5 lg:rounded-2xl lg:border lg:border-gray-200 lg:bg-white">

                    <div class="hidden items-center justify-between lg:flex">

                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">
                            Filters
                        </h2>

                        @if (!empty($selectedValueIds) || $priceMin !== null || $priceMax !== null)

                            <a href="{{ route('store.category', $category) }}" class="text-xs font-medium text-gray-500 underline hover:text-gray-900">
                                Clear all
                            </a>

                        @endif

                    </div>


                    {{-- Price --}}
                    <div>

                        <h3 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Price
                        </h3>

                        <div class="flex items-center gap-2">

                            <input
                                type="number"
                                name="price_min"
                                value="{{ $priceMin }}"
                                placeholder="{{ $priceBounds->min_price ? number_format($priceBounds->min_price, 0) : 'Min' }}"
                                min="0"
                                class="w-full rounded-lg border border-gray-300 px-2.5 py-2 text-sm focus:border-brand-500 focus:outline-none"
                            >

                            <span class="text-gray-400">&ndash;</span>

                            <input
                                type="number"
                                name="price_max"
                                value="{{ $priceMax }}"
                                placeholder="{{ $priceBounds->max_price ? number_format($priceBounds->max_price, 0) : 'Max' }}"
                                min="0"
                                class="w-full rounded-lg border border-gray-300 px-2.5 py-2 text-sm focus:border-brand-500 focus:outline-none"
                            >

                        </div>

                        <button
                            type="submit"
                            class="mt-3 w-full rounded-lg bg-brand-600 py-2 text-sm font-semibold text-white transition hover:bg-brand-700"
                        >
                            Apply Price
                        </button>

                    </div>


                    {{-- Attribute filters --}}
                    @foreach ($filterAttributes as $attribute)

                        @if ($attribute->values->isNotEmpty())

                            <div>

                                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    {{ $attribute->name }}
                                </h3>

                                <div class="space-y-2">

                                    @foreach ($attribute->values as $value)

                                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-gray-700">

                                            <input
                                                type="checkbox"
                                                name="attributes[]"
                                                value="{{ $value->id }}"
                                                onchange="this.form.submit()"
                                                {{ in_array($value->id, $selectedValueIds) ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-gray-300 text-gray-950 focus:ring-gray-500"
                                            >

                                            {{ $value->value }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    @endforeach

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-brand-600 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700 lg:hidden"
                    >
                        Show {{ $products->total() }} {{ \Illuminate\Support\Str::plural('result', $products->total()) }}
                    </button>

                </form>

            </aside>


            {{-- Product grid --}}
            <div>

                <div class="mb-4 flex items-center justify-between gap-3">

                    <div>

                        <h2 class="text-xl font-bold tracking-tight text-gray-900">
                            Products
                        </h2>

                        <span class="text-sm text-gray-500">
                            {{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}
                        </span>

                    </div>

                    <div class="flex items-center gap-2">

                        <button
                            type="button"
                            @click="mobileFiltersOpen = true"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 lg:hidden"
                        >
                            <i data-lucide="sliders-horizontal" class="h-4 w-4"></i>
                            Filters
                        </button>

                        <div class="relative">

                            <i data-lucide="arrow-up-down" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>

                            <select
                                name="sort"
                                form="category-filters"
                                onchange="document.getElementById('category-filters').submit()"
                                class="cursor-pointer appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-9 pr-8 text-sm text-gray-700 focus:border-brand-500 focus:outline-none"
                            >
                                <option value="default" {{ $sort === 'default' ? 'selected' : '' }}>Sort: Featured</option>
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            </select>

                        </div>

                    </div>

                </div>


                @if ($selectedAttributeValues->isNotEmpty() || $priceMin !== null || $priceMax !== null)

                    <div class="mb-6 flex flex-wrap items-center gap-2">

                        @foreach ($selectedAttributeValues as $value)

                            <a
                                href="{{ route('store.category', array_merge(['category' => $category], request()->except('page') , ['attributes' => array_values(array_diff($selectedValueIds, [$value->id]))])) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-brand-700"
                            >
                                {{ $value->attribute->name }}: {{ $value->value }}
                                <i data-lucide="x" class="h-3 w-3"></i>
                            </a>

                        @endforeach

                        @if ($priceMin !== null || $priceMax !== null)

                            <a
                                href="{{ route('store.category', array_merge(['category' => $category], request()->except(['page', 'price_min', 'price_max']))) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-brand-700"
                            >
                                Price: &#8377;{{ $priceMin ?? $priceBounds->min_price }} &ndash; &#8377;{{ $priceMax ?? $priceBounds->max_price }}
                                <i data-lucide="x" class="h-3 w-3"></i>
                            </a>

                        @endif

                    </div>

                @endif

                @if ($products->isEmpty())

                    <div class="rounded-2xl border border-dashed border-gray-300 py-16 text-center text-gray-500">
                        No products match the selected filters.
                    </div>

                @else

                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">

                        @foreach ($products as $product)

                            @include('store.partials.product-card', ['product' => $product])

                        @endforeach

                    </div>

                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>

</section>

@endif

@endsection
