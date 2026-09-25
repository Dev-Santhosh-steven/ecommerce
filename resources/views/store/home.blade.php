@extends('layouts.store')

@section('title', 'Yara Store | Smart Technology & Electronics')

@section('content')

{{-- =========================================================
     HERO SECTION (full-screen banner)
========================================================= --}}
<section class="relative h-[calc(100dvh-5rem)] min-h-[520px] w-full overflow-hidden bg-gray-950 text-white">

    <div class="swiper hero-swiper h-full w-full">

        <div class="swiper-wrapper h-full">

            @forelse ($banners as $banner)

                <div class="swiper-slide relative h-full w-full">

                    <img
                        src="{{ asset('storage/' . $banner->image) }}"
                        alt="{{ $banner->title ?? 'Banner' }}"
                        class="absolute inset-0 h-full w-full object-cover"
                    >

                    <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/50 to-gray-950/10"></div>
                    <div class="absolute inset-0 bg-gradient-to-r from-gray-950/60 via-transparent to-transparent"></div>

                    <div class="relative flex h-full items-end">

                        <div class="mx-auto w-full max-w-7xl px-4 pb-20 pt-24 sm:px-6 lg:px-8">

                            <div class="max-w-2xl">

                                @if ($banner->subtitle)

                                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-gray-300 backdrop-blur">
                                        <span class="h-2 w-2 rounded-full bg-brand-red"></span>
                                        {{ $banner->subtitle }}
                                    </div>

                                @endif

                                @if ($banner->title)

                                    <h1 class="text-4xl font-bold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                                        {{ $banner->title }}
                                    </h1>

                                @endif

                                @if ($banner->button_text && $banner->button_link)

                                    <div class="mt-9 flex flex-wrap gap-4">

                                        <a href="{{ $banner->button_link }}"
                                           class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">

                                            {{ $banner->button_text }}

                                            <i data-lucide="arrow-right" class="h-4 w-4"></i>

                                        </a>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="swiper-slide relative h-full w-full bg-gray-950">

                    <div class="absolute inset-0">
                        <img src="{{ asset('images/brand/hero-showroom.jpg') }}" alt="" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-950/95 via-gray-950/70 to-brand-900/40"></div>
                        <div class="absolute inset-x-0 bottom-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>
                    </div>

                    <div class="relative flex h-full items-end">

                        <div class="mx-auto w-full max-w-7xl px-4 pb-20 pt-24 sm:px-6 lg:px-8">

                            <div class="max-w-2xl">

                                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-gray-300">
                                    <span class="h-2 w-2 rounded-full bg-brand-red"></span>
                                    Smart Technology for Modern Spaces
                                </div>

                                <h1 class="text-4xl font-bold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                                    Technology
                                    <span class="text-brand-400">Built for</span>
                                    Life.
                                </h1>

                                <p class="mt-6 max-w-xl text-lg leading-8 text-gray-400">
                                    Explore next-generation TVs, interactive panels,
                                    commercial displays, audio systems and smart
                                    home appliances.
                                </p>

                                <div class="mt-9 flex flex-wrap gap-4">

                                    <a href="#products"
                                       class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">

                                        Explore Products

                                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                                    </a>

                                    <a href="#categories"
                                       class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">

                                        View Categories

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- Hero Navigation --}}
        @if ($banners->count() > 1)

            <button
                class="hero-prev absolute left-4 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur transition hover:bg-white/20 sm:left-6"
                aria-label="Previous slide"
            >
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
            </button>

            <button
                class="hero-next absolute right-4 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur transition hover:bg-white/20 sm:right-6"
                aria-label="Next slide"
            >
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </button>

            <div class="hero-pagination absolute bottom-8 right-4 z-10 flex w-auto items-center justify-end gap-2 sm:right-6"></div>

        @endif

    </div>


    {{-- Scroll hint --}}
    <div class="pointer-events-none absolute inset-x-0 bottom-6 z-10 flex justify-center">
        <div class="flex animate-bounce flex-col items-center gap-1 text-white/70">
            <span class="text-[11px] font-medium uppercase tracking-wider">Scroll</span>
            <i data-lucide="chevron-down" class="h-5 w-5"></i>
        </div>
    </div>

</section>


{{-- =========================================================
     CATEGORY SECTION
========================================================= --}}
<section id="categories" class="bg-white py-20">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-12 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

            <div>

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                    Explore
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                    Shop by <span class="text-brand-600">Category</span>
                </h2>

                <p class="mt-3 max-w-xl text-gray-500">
                    Discover technology for your home, office, business and
                    commercial spaces.
                </p>

            </div>

            <a href="#products"
               class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 hover:underline">

                View all products

                <i data-lucide="arrow-right" class="h-4 w-4"></i>

            </a>

        </div>


        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">

            @forelse ($categories as $category)

                <a href="{{ route('store.category', $category) }}"
                   class="group relative overflow-hidden rounded-2xl bg-gray-100">

                    <div class="aspect-[4/3]">

                        @if ($category->image)

                            <img
                                src="{{ asset('storage/' . $category->image) }}"
                                alt="{{ $category->name }}"
                                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                            >

                        @else

                            <div class="flex h-full w-full items-center justify-center bg-gray-200 text-gray-400">
                                <i data-lucide="layers" class="h-10 w-10"></i>
                            </div>

                        @endif

                    </div>

                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-5 pt-12">

                        <h3 class="font-semibold text-white">
                            {{ $category->name }}
                        </h3>

                        @if ($category->children_count > 0)

                            <p class="mt-1 text-sm text-gray-300">
                                {{ $category->children_count }} {{ \Illuminate\Support\Str::plural('subcategory', $category->children_count) }}
                            </p>

                        @elseif ($category->description)

                            <p class="mt-1 text-sm text-gray-300">
                                {{ $category->description }}
                            </p>

                        @endif

                    </div>

                </a>

            @empty

                <div class="col-span-full rounded-2xl border border-dashed border-gray-300 py-16 text-center text-gray-500">
                    No categories yet. Add some from the admin panel.
                </div>

            @endforelse

        </div>

    </div>

</section>


{{-- =========================================================
     LED VIDEO WALLS + CALCULATOR
========================================================= --}}
@if ($ledCategory)

<section id="led-walls" class="brand-dots overflow-hidden bg-gray-950 py-20 text-white" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid items-center gap-12 lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]">

            <div>

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em] !text-brand-400">
                    New &middot; LED Video Walls
                </p>

                <h2 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">
                    Go big.
                    <span class="text-brand-400">Plan your LED wall in seconds.</span>
                </h2>

                <p class="mt-6 max-w-xl leading-7 text-gray-400">
                    Seamless LED video walls for lobbies, boardrooms, stages, storefronts and highway billboards &mdash;
                    from P1.25 fine-pitch indoor to 7,000-nit outdoor. Enter your wall space and our calculator shows
                    the exact screen size, resolution, power and viewing distance.
                </p>

                <dl class="mt-8 grid grid-cols-3 gap-4 border-y border-white/10 py-6">
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Pixel pitch</dt>
                        <dd class="mt-1 text-xl font-bold">P1.25&ndash;P10</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Brightness</dt>
                        <dd class="mt-1 text-xl font-bold">7,000 nits</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Size</dt>
                        <dd class="mt-1 text-xl font-bold">Any</dd>
                    </div>
                </dl>

                <ol class="mt-8 space-y-3 text-sm text-gray-300">
                    @foreach (['Choose indoor or outdoor', 'Pick a pixel pitch for your viewing distance', 'Enter your wall space — get the full solution'] as $i => $step)
                        <li class="flex items-center gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold">{{ $i + 1 }}</span>
                            {{ $step }}
                        </li>
                    @endforeach
                </ol>

                <div class="mt-9 flex flex-wrap gap-4">

                    <a href="{{ route('store.led-calculator') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">
                        Explore More
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>

                    <a href="{{ route('store.category', $ledCategory) }}"
                       class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                        View LED Walls
                    </a>

                </div>

            </div>


            <div class="relative">

                <div class="absolute -inset-10 rounded-full bg-brand-600/10 blur-3xl"></div>

                <div class="relative grid grid-cols-2 gap-4">

                    @foreach ([
                        ['home-outdoor', 'Outdoor billboards', 'Sunlight readable, IP65', 'col-span-2 aspect-[16/9]'],
                        ['home-indoor', 'Indoor & corporate', 'Fine-pitch P1.25–P2.5', 'aspect-[4/3]'],
                        ['home-stage', 'Rental & events', 'Tool-less cabinets', 'aspect-[4/3]'],
                    ] as [$image, $title, $caption, $size])

                        <a href="{{ route('store.led-calculator') }}" class="group relative overflow-hidden rounded-2xl border border-white/10 {{ $size }}">
                            <img src="{{ asset('storage/led-video-walls/' . $image . '.jpg') }}"
                                 alt="{{ $title }} LED video wall"
                                 loading="lazy"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>
                            <div class="absolute bottom-0 p-4 sm:p-5">
                                <p class="font-semibold">{{ $title }}</p>
                                <p class="mt-0.5 text-xs text-gray-300">{{ $caption }}</p>
                            </div>
                        </a>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</section>

@endif


{{-- =========================================================
     FEATURED PRODUCTS
========================================================= --}}
<section id="products" class="bg-gray-50 py-20" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-12 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

            <div>

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                    Featured
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                    Popular <span class="text-brand-600">Products</span>
                </h2>

                <p class="mt-3 text-gray-500">
                    Explore some of our featured electronics.
                </p>

            </div>

            <a href="{{ route('store.search') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 hover:underline">

                View all

                <i data-lucide="arrow-right" class="h-4 w-4"></i>

            </a>

        </div>


        @if ($featuredProducts->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-16 text-center text-gray-500">
                No featured products yet. Mark products as &ldquo;Featured&rdquo; from the admin panel to show them here.
            </div>

        @else

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($featuredProducts as $product)

                    @include('store.partials.product-card', ['product' => $product])

                @endforeach

            </div>

        @endif

    </div>

</section>


{{-- =========================================================
     NEW ARRIVALS
========================================================= --}}
<section id="new-arrivals" class="bg-white py-20" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-12 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

            <div>

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                    Just In
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                    New <span class="text-brand-600">Arrivals</span>
                </h2>

                <p class="mt-3 text-gray-500">
                    The latest additions to our electronics range.
                </p>

            </div>

            <a href="{{ route('store.search') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 hover:underline">

                View all

                <i data-lucide="arrow-right" class="h-4 w-4"></i>

            </a>

        </div>


        @if ($newArrivals->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 py-16 text-center text-gray-500">
                No products yet. Add some from the admin panel.
            </div>

        @else

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($newArrivals as $product)

                    @include('store.partials.product-card', ['product' => $product])

                @endforeach

            </div>

        @endif

    </div>

</section>


{{-- =========================================================
     BOOK A DEMO CTA
========================================================= --}}
<section class="bg-white py-16" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="brand-dots relative overflow-hidden rounded-3xl bg-gray-950 px-6 py-14 text-center text-white sm:px-16">

            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>

            <div class="relative">

                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10">
                    <i data-lucide="calendar-check" class="h-7 w-7 text-brand-400"></i>
                </div>

                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                    See It Before You Buy It
                </h2>

                <p class="mx-auto mt-3 max-w-xl text-gray-400">
                    Book a free, no-obligation demo and experience our TVs, ACs and appliances up
                    close &mdash; at our showroom or wherever suits you.
                </p>

                <a
                    href="{{ route('store.demo.create') }}"
                    class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500"
                >
                    Book a Demo
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     COMMERCIAL SOLUTIONS
========================================================= --}}
<section id="commercial" class="brand-dots overflow-hidden bg-gray-950 py-20 text-white">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid items-center gap-12 lg:grid-cols-2">

            <div>

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em] !text-brand-400">
                    Business Solutions
                </p>

                <h2 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">
                    Technology that
                    <span class="text-brand-400">works for your business.</span>
                </h2>

                <p class="mt-6 max-w-xl leading-7 text-gray-400">
                    From interactive classrooms to retail signage and
                    corporate meeting spaces, our professional display
                    solutions help businesses communicate, collaborate
                    and connect.
                </p>


                <div class="mt-8 grid gap-4 sm:grid-cols-2">

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="monitor-smartphone" class="h-6 w-6 text-brand-400"></i>

                        <h3 class="mt-4 font-semibold">
                            Interactive Panels
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Modern collaboration and presentation solutions.
                        </p>

                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="monitor" class="h-6 w-6 text-brand-400"></i>

                        <h3 class="mt-4 font-semibold">
                            Commercial Displays
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Professional displays for business environments.
                        </p>

                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="megaphone" class="h-6 w-6 text-brand-400"></i>

                        <h3 class="mt-4 font-semibold">
                            T-Standees
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Dynamic digital advertising and signage.
                        </p>

                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="presentation" class="h-6 w-6 text-brand-400"></i>

                        <h3 class="mt-4 font-semibold">
                            A-Standees
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Flexible solutions for retail and events.
                        </p>

                    </div>

                </div>

                <a href="#"
                   class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">

                    Explore Commercial Solutions

                    <i data-lucide="arrow-right" class="h-4 w-4"></i>

                </a>

            </div>


            <div class="relative">

                <div class="absolute -inset-10 rounded-full bg-brand-600/10 blur-3xl"></div>

                <div class="relative overflow-hidden rounded-3xl border border-white/10">

                    <img
                        src="https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1200&q=85"
                        alt="Business technology"
                        class="aspect-[4/3] w-full object-cover"
                    >

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     HOME APPLIANCES
========================================================= --}}
<section class="bg-white py-20">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-12">

            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                Smart Living
            </p>

            <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                Upgrade Your <span class="text-brand-600">Home</span>
            </h2>

            <p class="mt-3 max-w-xl text-gray-500">
                Modern appliances designed to make everyday life more comfortable.
            </p>

        </div>


        <div class="grid gap-6 md:grid-cols-3">

            {{-- AC --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gray-100">

                <img
                    src="{{ asset('storage/categories/air-conditioners.jpg') }}"
                    alt="Yara air conditioners"
                    class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

                <div class="absolute bottom-0 p-7">

                    <p class="text-sm text-gray-300">
                        Climate Control
                    </p>

                    <h3 class="mt-1 text-2xl font-bold text-white">
                        Air Conditioners
                    </h3>

                    <a href="{{ url('/category/air-conditioners') }}"
                       class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white">

                        Shop now

                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                    </a>

                </div>

            </div>


            {{-- Washing Machine --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gray-100">

                <img
                    src="{{ asset('storage/categories/washing-machines.jpg') }}"
                    alt="Yara washing machines"
                    class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

                <div class="absolute bottom-0 p-7">

                    <p class="text-sm text-gray-300">
                        Home Appliances
                    </p>

                    <h3 class="mt-1 text-2xl font-bold text-white">
                        Washing Machines
                    </h3>

                    <a href="{{ url('/category/washing-machine') }}"
                       class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white">

                        Shop now

                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                    </a>

                </div>

            </div>


            {{-- Audio --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gray-100">

                <img
                    src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=1000&q=80"
                    alt="Speaker system"
                    class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>

                <div class="absolute bottom-0 p-7">

                    <p class="text-sm text-gray-300">
                        Audio
                    </p>

                    <h3 class="mt-1 text-2xl font-bold text-white">
                        Speakers & Audio
                    </h3>

                    <a href="#products"
                       class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white">

                        Shop now

                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     WHY YARA
========================================================= --}}
<section class="bg-gray-50 py-20">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center">

            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                Why Choose Us
            </p>

            <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                Technology you can <span class="text-brand-600">trust.</span>
            </h2>

            <p class="mt-4 text-gray-500">
                We focus on quality products and dependable service from
                purchase to support.
            </p>

        </div>


        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="badge-check" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Quality Products
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Carefully selected electronics for home and business.
                </p>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="shield-check" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Reliable Warranty
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Support and warranty assistance for your products.
                </p>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="truck" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Dependable Delivery
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Reliable delivery for products and business solutions.
                </p>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="headphones" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Customer Support
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    We're here to help before and after your purchase.
                </p>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     NEWSLETTER / CTA
========================================================= --}}
<section class="bg-white py-20">

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="brand-dots relative overflow-hidden rounded-3xl bg-gray-950 px-6 py-14 text-center text-white sm:px-12">

            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>

            <div class="relative">

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em] !text-brand-400">
                    Stay Updated
                </p>

                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">
                    Discover what's next in technology.
                </h2>

                <p class="mx-auto mt-4 max-w-xl text-gray-400">
                    Get updates about new products, offers and technology solutions.
                </p>

                <form class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">

                    <input
                        type="email"
                        placeholder="Enter your email address"
                        class="min-w-0 flex-1 rounded-full border border-white/10 bg-white/10 px-5 py-3.5 text-sm text-white outline-none placeholder:text-gray-500 focus:border-brand-400"
                    >

                    <button
                        type="submit"
                        class="rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500"
                    >
                        Subscribe
                    </button>

                </form>

            </div>

        </div>

    </div>

</section>


{{-- WhatsApp Chat Button --}}
<a href="https://wa.me/919677712000?text={{ rawurlencode('Hi Yara Electronics, I would like to know more about your products.') }}"
   target="_blank"
   rel="noopener noreferrer"
   aria-label="Chat with us on WhatsApp"
   class="group fixed bottom-6 right-6 z-50 flex items-center">

    {{-- Hover popup --}}
    <span class="pointer-events-none mr-3 translate-x-2 whitespace-nowrap rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-800 opacity-0 shadow-lg ring-1 ring-gray-200 transition duration-200 group-hover:translate-x-0 group-hover:opacity-100 group-focus-visible:translate-x-0 group-focus-visible:opacity-100">
        Chat with us
    </span>

    {{-- Icon --}}
    <span class="relative flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg transition duration-200 group-hover:scale-110 group-hover:bg-[#1ebe5b]">

        <span class="absolute inset-0 animate-ping rounded-full bg-[#25D366] opacity-30"></span>

        <svg class="relative h-7 w-7" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>

    </span>

</a>


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        new Swiper('.hero-swiper', {

            loop: true,

            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },

            navigation: {
                nextEl: '.hero-next',
                prevEl: '.hero-prev',
            },

            pagination: {
                el: '.hero-pagination',
                clickable: true,
            },

            effect: 'slide',

            speed: 700,

        });

    });
</script>

@endpush

@endsection