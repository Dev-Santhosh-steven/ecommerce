@extends('layouts.store')

@section('title', 'Yara Store | Smart Technology & Electronics')

@section('content')

{{-- =========================================================
     HERO SECTION
========================================================= --}}
<section class="relative overflow-hidden bg-gray-950 text-white">

    <div class="absolute inset-0">
        <div class="absolute -left-40 top-10 h-96 w-96 rounded-full bg-blue-600/20 blur-3xl"></div>
        <div class="absolute -right-40 bottom-0 h-96 w-96 rounded-full bg-cyan-500/20 blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="swiper hero-swiper">

            <div class="swiper-wrapper">

                @forelse ($banners as $banner)

                    <div class="swiper-slide">

                        <div class="grid min-h-[580px] items-center gap-12 py-16 lg:grid-cols-2 lg:py-20">

                            <div class="max-w-2xl">

                                @if ($banner->subtitle)

                                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-gray-300">
                                        <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                                        {{ $banner->subtitle }}
                                    </div>

                                @endif

                                @if ($banner->title)

                                    <h1 class="text-5xl font-bold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                                        {{ $banner->title }}
                                    </h1>

                                @endif

                                @if ($banner->button_text && $banner->button_link)

                                    <div class="mt-9 flex flex-wrap gap-4">

                                        <a href="{{ $banner->button_link }}"
                                           class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3.5 text-sm font-semibold text-gray-950 transition hover:bg-gray-200">

                                            {{ $banner->button_text }}

                                            <i data-lucide="arrow-right" class="h-4 w-4"></i>

                                        </a>

                                    </div>

                                @endif

                            </div>


                            <div class="relative flex items-center justify-center">

                                <div class="relative w-full max-w-2xl overflow-hidden rounded-3xl border border-white/10 shadow-2xl">

                                    <img
                                        src="{{ asset('storage/' . $banner->image) }}"
                                        alt="{{ $banner->title ?? 'Banner' }}"
                                        class="aspect-[4/3] w-full object-cover"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="swiper-slide">

                        <div class="grid min-h-[580px] items-center gap-12 py-16 lg:grid-cols-2 lg:py-20">

                            <div class="max-w-2xl">

                                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-gray-300">
                                    <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                                    Smart Technology for Modern Spaces
                                </div>

                                <h1 class="text-5xl font-bold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                                    Technology
                                    <span class="text-cyan-400">Built for</span>
                                    Life.
                                </h1>

                                <p class="mt-6 max-w-xl text-lg leading-8 text-gray-400">
                                    Explore next-generation TVs, interactive panels,
                                    commercial displays, audio systems and smart
                                    home appliances.
                                </p>

                                <div class="mt-9 flex flex-wrap gap-4">

                                    <a href="#products"
                                       class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3.5 text-sm font-semibold text-gray-950 transition hover:bg-gray-200">

                                        Explore Products

                                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                                    </a>

                                    <a href="#categories"
                                       class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">

                                        View Categories

                                    </a>

                                </div>

                            </div>


                            <div class="relative flex items-center justify-center">

                                <div class="absolute h-72 w-72 rounded-full bg-cyan-400/10 blur-3xl"></div>

                                <div class="relative w-full max-w-xl">

                                    <div class="aspect-[4/3] overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-gray-800 to-gray-950 shadow-2xl">

                                        <img
                                            src="https://images.unsplash.com/photo-1593784991095-a205069470b6?auto=format&fit=crop&w=1200&q=85"
                                            alt="Modern television"
                                            class="h-full w-full object-cover opacity-90"
                                        >

                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-transparent to-transparent"></div>

                                        <div class="absolute bottom-6 left-6">

                                            <p class="text-sm text-gray-300">
                                                Featured Technology
                                            </p>

                                            <h2 class="mt-1 text-2xl font-semibold">
                                                Smart Entertainment
                                            </h2>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforelse

            </div>


            {{-- Hero Navigation --}}
            <div class="absolute bottom-8 left-0 z-10 flex items-center gap-3">

                <button
                    class="hero-prev flex h-10 w-10 items-center justify-center rounded-full border border-white/20 bg-white/5 transition hover:bg-white/10"
                    aria-label="Previous slide"
                >
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                </button>

                <button
                    class="hero-next flex h-10 w-10 items-center justify-center rounded-full border border-white/20 bg-white/5 transition hover:bg-white/10"
                    aria-label="Next slide"
                >
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </button>

            </div>

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

                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                    Explore
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                    Shop by Category
                </h2>

                <p class="mt-3 max-w-xl text-gray-500">
                    Discover technology for your home, office, business and
                    commercial spaces.
                </p>

            </div>

            <a href="#products"
               class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900 hover:underline">

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
     FEATURED PRODUCTS
========================================================= --}}
<section id="products" class="bg-gray-50 py-20">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-12 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

            <div>

                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                    Featured
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                    Popular Products
                </h2>

                <p class="mt-3 text-gray-500">
                    Explore some of our featured electronics.
                </p>

            </div>

            <a href="#"
               class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900 hover:underline">

                View all

                <i data-lucide="arrow-right" class="h-4 w-4"></i>

            </a>

        </div>


        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Product 1 --}}
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="relative aspect-square overflow-hidden bg-gray-100">

                    <span class="absolute left-4 top-4 z-10 rounded-full bg-gray-950 px-3 py-1 text-xs font-semibold text-white">
                        Featured
                    </span>

                    <button class="absolute right-4 top-4 z-10 rounded-full bg-white p-2 shadow-sm transition hover:bg-gray-950 hover:text-white">

                        <i data-lucide="heart" class="h-4 w-4"></i>

                    </button>

                    <img
                        src="https://images.unsplash.com/photo-1593359677879-a4bb92f829d1?auto=format&fit=crop&w=800&q=85"
                        alt="Smart TV"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    >

                </div>

                <div class="p-5">

                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                        Television
                    </p>

                    <h3 class="mt-2 font-semibold text-gray-900">
                        Premium Smart TV
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        4K Ultra HD Smart Entertainment
                    </p>

                    <div class="mt-5 flex items-center justify-between">

                        <span class="text-lg font-bold">
                            ₹49,999
                        </span>

                        <button class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-950 text-white transition hover:bg-gray-700">

                            <i data-lucide="shopping-bag" class="h-4 w-4"></i>

                        </button>

                    </div>

                </div>

            </article>


            {{-- Product 2 --}}
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="relative aspect-square overflow-hidden bg-gray-100">

                    <span class="absolute left-4 top-4 z-10 rounded-full bg-blue-600 px-3 py-1 text-xs font-semibold text-white">
                        Business
                    </span>

                    <button class="absolute right-4 top-4 z-10 rounded-full bg-white p-2 shadow-sm transition hover:bg-gray-950 hover:text-white">

                        <i data-lucide="heart" class="h-4 w-4"></i>

                    </button>

                    <img
                        src="https://images.unsplash.com/photo-1587825140708-dfaf72ae4b04?auto=format&fit=crop&w=800&q=85"
                        alt="Interactive panel"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    >

                </div>

                <div class="p-5">

                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                        Interactive Panel
                    </p>

                    <h3 class="mt-2 font-semibold text-gray-900">
                        Interactive Smart Panel
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Collaboration & presentation display
                    </p>

                    <div class="mt-5 flex items-center justify-between">

                        <span class="text-lg font-bold">
                            ₹89,999
                        </span>

                        <button class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-950 text-white transition hover:bg-gray-700">

                            <i data-lucide="shopping-bag" class="h-4 w-4"></i>

                        </button>

                    </div>

                </div>

            </article>


            {{-- Product 3 --}}
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="relative aspect-square overflow-hidden bg-gray-100">

                    <span class="absolute left-4 top-4 z-10 rounded-full bg-emerald-600 px-3 py-1 text-xs font-semibold text-white">
                        Commercial
                    </span>

                    <button class="absolute right-4 top-4 z-10 rounded-full bg-white p-2 shadow-sm transition hover:bg-gray-950 hover:text-white">

                        <i data-lucide="heart" class="h-4 w-4"></i>

                    </button>

                    <img
                        src="https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=800&q=85"
                        alt="Commercial display"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    >

                </div>

                <div class="p-5">

                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                        Commercial Display
                    </p>

                    <h3 class="mt-2 font-semibold text-gray-900">
                        Professional Display
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        High-performance business display
                    </p>

                    <div class="mt-5 flex items-center justify-between">

                        <span class="text-lg font-bold">
                            ₹74,999
                        </span>

                        <button class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-950 text-white transition hover:bg-gray-700">

                            <i data-lucide="shopping-bag" class="h-4 w-4"></i>

                        </button>

                    </div>

                </div>

            </article>


            {{-- Product 4 --}}
            <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="relative aspect-square overflow-hidden bg-gray-100">

                    <span class="absolute left-4 top-4 z-10 rounded-full bg-orange-500 px-3 py-1 text-xs font-semibold text-white">
                        New
                    </span>

                    <button class="absolute right-4 top-4 z-10 rounded-full bg-white p-2 shadow-sm transition hover:bg-gray-950 hover:text-white">

                        <i data-lucide="heart" class="h-4 w-4"></i>

                    </button>

                    <img
                        src="https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&w=800&q=85"
                        alt="Speaker"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    >

                </div>

                <div class="p-5">

                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                        Audio
                    </p>

                    <h3 class="mt-2 font-semibold text-gray-900">
                        Premium Wireless Speaker
                    </h3>

                    <p class="mt-2 text-sm text-gray-500">
                        Powerful sound for every space
                    </p>

                    <div class="mt-5 flex items-center justify-between">

                        <span class="text-lg font-bold">
                            ₹14,999
                        </span>

                        <button class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-950 text-white transition hover:bg-gray-700">

                            <i data-lucide="shopping-bag" class="h-4 w-4"></i>

                        </button>

                    </div>

                </div>

            </article>

        </div>

    </div>

</section>


{{-- =========================================================
     COMMERCIAL SOLUTIONS
========================================================= --}}
<section id="commercial" class="overflow-hidden bg-gray-950 py-20 text-white">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid items-center gap-12 lg:grid-cols-2">

            <div>

                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-400">
                    Business Solutions
                </p>

                <h2 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">
                    Technology that
                    <span class="text-cyan-400">works for your business.</span>
                </h2>

                <p class="mt-6 max-w-xl leading-7 text-gray-400">
                    From interactive classrooms to retail signage and
                    corporate meeting spaces, our professional display
                    solutions help businesses communicate, collaborate
                    and connect.
                </p>


                <div class="mt-8 grid gap-4 sm:grid-cols-2">

                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="monitor-smartphone" class="h-6 w-6 text-cyan-400"></i>

                        <h3 class="mt-4 font-semibold">
                            Interactive Panels
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Modern collaboration and presentation solutions.
                        </p>

                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="monitor" class="h-6 w-6 text-cyan-400"></i>

                        <h3 class="mt-4 font-semibold">
                            Commercial Displays
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Professional displays for business environments.
                        </p>

                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="megaphone" class="h-6 w-6 text-cyan-400"></i>

                        <h3 class="mt-4 font-semibold">
                            T-Standees
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Dynamic digital advertising and signage.
                        </p>

                    </div>


                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">

                        <i data-lucide="presentation" class="h-6 w-6 text-cyan-400"></i>

                        <h3 class="mt-4 font-semibold">
                            A-Standees
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            Flexible solutions for retail and events.
                        </p>

                    </div>

                </div>

                <a href="#"
                   class="mt-8 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3.5 text-sm font-semibold text-gray-950 transition hover:bg-gray-200">

                    Explore Commercial Solutions

                    <i data-lucide="arrow-right" class="h-4 w-4"></i>

                </a>

            </div>


            <div class="relative">

                <div class="absolute -inset-10 rounded-full bg-cyan-500/10 blur-3xl"></div>

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

            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                Smart Living
            </p>

            <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                Upgrade Your Home
            </h2>

            <p class="mt-3 max-w-xl text-gray-500">
                Modern appliances designed to make everyday life more comfortable.
            </p>

        </div>


        <div class="grid gap-6 md:grid-cols-3">

            {{-- AC --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gray-100">

                <img
                    src="https://images.unsplash.com/photo-1631545806609-4b7b1e2a3b3b?auto=format&fit=crop&w=1000&q=80"
                    alt="Air conditioner"
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

                    <a href="#products"
                       class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white">

                        Shop now

                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                    </a>

                </div>

            </div>


            {{-- Washing Machine --}}
            <div class="group relative overflow-hidden rounded-3xl bg-gray-100">

                <img
                    src="https://images.unsplash.com/photo-1626806787461-102c1bfaaea1?auto=format&fit=crop&w=1000&q=80"
                    alt="Washing machine"
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

                    <a href="#products"
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

            <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                Why Choose Us
            </p>

            <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                Technology you can trust.
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

        <div class="relative overflow-hidden rounded-3xl bg-gray-950 px-6 py-14 text-center text-white sm:px-12">

            <div class="absolute -left-20 -top-20 h-60 w-60 rounded-full bg-cyan-500/20 blur-3xl"></div>

            <div class="absolute -bottom-20 -right-20 h-60 w-60 rounded-full bg-blue-500/20 blur-3xl"></div>

            <div class="relative">

                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-cyan-400">
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
                        class="min-w-0 flex-1 rounded-full border border-white/10 bg-white/10 px-5 py-3.5 text-sm text-white outline-none placeholder:text-gray-500 focus:border-cyan-400"
                    >

                    <button
                        type="submit"
                        class="rounded-full bg-white px-6 py-3.5 text-sm font-semibold text-gray-950 transition hover:bg-gray-200"
                    >
                        Subscribe
                    </button>

                </form>

            </div>

        </div>

    </div>

</section>


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {

        new Swiper('.hero-swiper', {

            loop: true,

            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },

            navigation: {
                nextEl: '.hero-next',
                prevEl: '.hero-prev',
            },

            effect: 'slide',

            speed: 700,

        });

    });
</script>

@endpush

@endsection