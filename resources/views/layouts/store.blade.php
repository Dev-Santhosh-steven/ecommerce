<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Yara Store')
    </title>

    @fonts

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="brand-page text-gray-900 antialiased">

    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b-2 border-brand-600 bg-white/95 shadow-sm backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex h-20 items-center justify-between gap-6">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex shrink-0 items-center">

                    @if ($siteLogo)

                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="Yara Electronics" class="h-16 w-auto max-w-[240px] object-contain sm:h-[68px] sm:max-w-[300px]">

                    @else

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-600 text-lg font-bold text-white">
                            Y
                        </div>

                    @endif

                </a>


                {{-- Desktop Navigation --}}
                <nav class="hidden items-center gap-7 md:flex">

                    <a href="{{ url('/') }}"
                       class="text-[15px] font-medium text-gray-700 transition hover:text-brand-600">
                        Home
                    </a>

                    @foreach ($navCategories as $navCategory)

                        <div class="group relative">

                            <a href="{{ route('store.category', $navCategory) }}"
                               class="flex items-center gap-1 text-[15px] font-medium text-gray-700 transition hover:text-brand-600">

                                {{ $navCategory->name }}

                                @if ($navCategory->children->isNotEmpty())
                                    <i data-lucide="chevron-down" class="h-3.5 w-3.5 text-gray-400"></i>
                                @endif

                            </a>

                            @if ($navCategory->children->isNotEmpty())

                                <div class="invisible absolute left-1/2 top-full z-50 w-56 -translate-x-1/2 pt-3 opacity-0 transition group-hover:visible group-hover:opacity-100">

                                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-2 shadow-xl">

                                        @foreach ($navCategory->children as $child)

                                            <a href="{{ route('store.category', $child) }}"
                                               class="block rounded-lg px-3 py-2 text-[15px] text-gray-700 transition hover:bg-brand-50 hover:text-brand-700">
                                                {{ $child->name }}
                                            </a>

                                        @endforeach

                                    </div>

                                </div>

                            @endif

                        </div>

                    @endforeach

                    <a href="{{ route('store.about') }}"
                       class="text-[15px] font-medium text-gray-700 transition hover:text-brand-600">
                        About
                    </a>

                    <a href="{{ route('store.contact') }}"
                       class="text-[15px] font-medium text-gray-700 transition hover:text-brand-600">
                        Contact
                    </a>

                </nav>


                {{-- Right Side --}}
                <div class="flex items-center gap-3">

                    {{-- Search --}}
                    <div
                        class="relative hidden sm:block"
                        x-data="{
                            open: false,
                            query: '',
                            results: [],
                            loading: false,
                            async search() {
                                if (this.query.trim().length < 2) { this.results = []; return; }
                                this.loading = true;
                                const res = await fetch('{{ route('store.search.suggest') }}?q=' + encodeURIComponent(this.query));
                                this.results = await res.json();
                                this.loading = false;
                            },
                        }"
                        @keydown.escape="open = false"
                    >
                        <button
                            type="button"
                            @click="open = !open; $nextTick(() => open && $refs.searchInput.focus())"
                            class="rounded-full p-2.5 text-gray-600 transition hover:bg-brand-50 hover:text-brand-600"
                            aria-label="Search"
                        >
                            <i data-lucide="search" class="h-5 w-5"></i>
                        </button>

                        <div
                            x-show="open"
                            x-cloak
                            @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="absolute right-0 top-full z-50 mt-2 w-96 max-w-[90vw] rounded-2xl border border-gray-200 bg-white p-4 shadow-xl"
                        >

                            <form action="{{ route('store.search') }}" method="GET">

                                <div class="relative">

                                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>

                                    <input
                                        x-ref="searchInput"
                                        type="text"
                                        name="q"
                                        x-model="query"
                                        @input.debounce.300ms="search()"
                                        autocomplete="off"
                                        placeholder="Search for TVs, ACs, washing machines..."
                                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-9 pr-4 text-sm focus:border-brand-500 focus:outline-none"
                                    >

                                </div>

                            </form>

                            <div x-show="results.length > 0" class="mt-3 max-h-80 space-y-1 overflow-y-auto">

                                <template x-for="item in results" :key="item.url">

                                    <a :href="item.url" class="flex items-center gap-3 rounded-lg p-2 transition hover:bg-gray-50">

                                        <template x-if="item.image">
                                            <img :src="item.image" class="h-10 w-10 shrink-0 rounded-lg bg-gray-100 object-cover">
                                        </template>

                                        <template x-if="!item.image">
                                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-300">
                                                <i data-lucide="image" class="h-4 w-4"></i>
                                            </div>
                                        </template>

                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-gray-900" x-text="item.name"></p>
                                            <p class="text-xs text-gray-500" x-text="'₹' + item.price"></p>
                                        </div>

                                    </a>

                                </template>

                            </div>

                            <p x-show="query.trim().length >= 2 && !loading && results.length === 0" class="mt-3 text-sm text-gray-500">
                                No products found.
                            </p>

                            <button
                                type="button"
                                x-show="query.trim().length > 0"
                                @click="window.location.href = '{{ route('store.search') }}?q=' + encodeURIComponent(query)"
                                class="mt-3 w-full rounded-lg bg-brand-600 py-2 text-sm font-semibold text-white transition hover:bg-brand-700"
                            >
                                View all results
                            </button>

                        </div>

                    </div>


                    {{-- Account --}}
                    <button
                        type="button"
                        class="hidden rounded-full p-2.5 text-gray-600 transition hover:bg-brand-50 hover:text-brand-600 sm:block"
                        aria-label="Account"
                    >
                        <i data-lucide="user-round" class="h-5 w-5"></i>
                    </button>


                    {{-- Cart --}}
                    <button
                        type="button"
                        class="relative rounded-full p-2.5 text-gray-600 transition hover:bg-brand-50 hover:text-brand-600"
                        aria-label="Shopping cart"
                    >
                        <i data-lucide="shopping-bag" class="h-5 w-5"></i>

                        <span class="absolute -right-0.5 -top-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-brand-red text-[10px] font-semibold text-white">
                            0
                        </span>
                    </button>


                    {{-- Mobile Menu --}}
                    <button
                        type="button"
                        x-data
                        @click="$dispatch('toggle-mobile-menu')"
                        class="rounded-full p-2.5 text-gray-600 transition hover:bg-gray-100 md:hidden"
                        aria-label="Open menu"
                    >
                        <i data-lucide="menu" class="h-5 w-5"></i>
                    </button>

                </div>

            </div>

        </div>


        {{-- Mobile Navigation --}}
        <div
            x-data="{ open: false }"
            @toggle-mobile-menu.window="open = !open"
            x-show="open"
            x-cloak
            class="border-t border-gray-200 bg-white md:hidden"
        >

            <nav class="mx-auto flex max-w-7xl flex-col px-4 py-4 sm:px-6">

                <form action="{{ route('store.search') }}" method="GET" class="relative mb-3">

                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>

                    <input
                        type="text"
                        name="q"
                        placeholder="Search products..."
                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-9 pr-4 text-sm focus:border-brand-500 focus:outline-none"
                    >

                </form>

                <a href="{{ url('/') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium hover:bg-gray-100">
                    Home
                </a>

                @foreach ($navCategories as $navCategory)

                    @if ($navCategory->children->isNotEmpty())

                        <div x-data="{ expanded: false }">

                            <button
                                type="button"
                                @click="expanded = !expanded"
                                class="flex w-full items-center justify-between rounded-lg px-3 py-3 text-left text-[15px] font-medium hover:bg-gray-100"
                            >
                                {{ $navCategory->name }}
                                <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400 transition-transform" :class="expanded ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="expanded" x-cloak class="ml-3 space-y-1 border-l border-gray-200 pl-3">

                                <a href="{{ route('store.category', $navCategory) }}" class="block rounded-lg px-3 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                    All {{ $navCategory->name }}
                                </a>

                                @foreach ($navCategory->children as $child)

                                    <a href="{{ route('store.category', $child) }}" class="block rounded-lg px-3 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                        {{ $child->name }}
                                    </a>

                                @endforeach

                            </div>

                        </div>

                    @else

                        <a href="{{ route('store.category', $navCategory) }}"
                           class="rounded-lg px-3 py-3 text-[15px] font-medium hover:bg-gray-100">
                            {{ $navCategory->name }}
                        </a>

                    @endif

                @endforeach

                <a href="{{ route('store.about') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium hover:bg-gray-100">
                    About
                </a>

                <a href="{{ route('store.contact') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium hover:bg-gray-100">
                    Contact
                </a>

            </nav>

        </div>

    </header>


    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>


    {{-- Footer --}}
    <footer id="contact" class="brand-dots overflow-hidden bg-gray-950 text-white">

        {{-- Crimson band, as on the catalogue back cover --}}
        <div class="bg-gradient-to-r from-brand-700 via-brand-600 to-brand-600/90">
            <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-6 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">

                <p class="max-w-3xl text-sm leading-6 text-white/90">
                    At Yara Electronics, we design and manufacture advanced display solutions that power communication
                    across businesses, education, healthcare, retail and public environments.
                </p>

                <a href="{{ route('store.demo.create') }}"
                   class="inline-flex shrink-0 items-center gap-2 self-start rounded-full bg-white px-5 py-2.5 text-sm font-semibold text-brand-700 transition hover:bg-gray-100 md:self-auto">
                    Book a Demo
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>

            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Brand --}}
                <div>

                    <div class="mb-5 flex items-center">

                        @if ($siteLogo)

                            <span class="rounded-xl bg-white px-3 py-2">
                                <img src="{{ asset('storage/' . $siteLogo) }}" alt="Yara Electronics" class="h-11 w-auto">
                            </span>

                        @else

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-600 text-lg font-bold text-white">
                                Y
                            </div>

                        @endif

                    </div>

                    <p class="font-semibold text-brand-400">
                        Yara Electronics Private Limited
                    </p>

                    <p class="mt-1 text-sm italic text-gray-400">
                        Display Solutions to Everyone
                    </p>

                    <ul class="mt-6 space-y-3 text-sm text-gray-400">
                        <li class="flex gap-3">
                            <i data-lucide="map-pin" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400"></i>
                            <span>PVG Towers, Third Floor, 473, Avinashi Road, Peelamedu, Coimbatore - 641004, India</span>
                        </li>
                        <li class="flex gap-3">
                            <i data-lucide="phone" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400"></i>
                            <span>
                                <a href="tel:+919842088300" class="transition hover:text-white">+91 98420 88300</a><br>
                                <a href="tel:+919677712000" class="transition hover:text-white">+91 96777 12000</a>
                            </span>
                        </li>
                        <li class="flex gap-3">
                            <i data-lucide="mail" class="mt-0.5 h-4 w-4 shrink-0 text-brand-400"></i>
                            <span>
                                <a href="mailto:sales@yaraelectronics.com" class="transition hover:text-white">sales@yaraelectronics.com</a><br>
                                <a href="mailto:info@yaraelectronics.com" class="transition hover:text-white">info@yaraelectronics.com</a>
                            </span>
                        </li>
                    </ul>

                </div>


                {{-- Shop --}}
                <div>

                    <h3 class="mb-5 border-l-[3px] border-brand-600 pl-3 text-sm font-semibold uppercase tracking-wider">
                        Shop
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-400">

                        <li>
                            <a href="{{ route('store.search') }}" class="transition hover:text-white">
                                All Products
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.home') }}#categories" class="transition hover:text-white">
                                Categories
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.home') }}#new-arrivals" class="transition hover:text-white">
                                New Arrivals
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.home') }}#products" class="transition hover:text-white">
                                Best Sellers
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Information --}}
                <div id="about">

                    <h3 class="mb-5 border-l-[3px] border-brand-600 pl-3 text-sm font-semibold uppercase tracking-wider">
                        Information
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-400">

                        <li>
                            <a href="{{ route('store.about') }}" class="transition hover:text-white">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.catalogue') }}" class="transition hover:text-white">
                                Catalogue
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.privacy') }}" class="transition hover:text-white">
                                Privacy Policy
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.terms') }}" class="transition hover:text-white">
                                Terms & Conditions
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.e-waste') }}" class="transition hover:text-white">
                                E-waste Management
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Customer Service --}}
                <div>

                    <h3 class="mb-5 border-l-[3px] border-brand-600 pl-3 text-sm font-semibold uppercase tracking-wider">
                        Customer Service
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-400">

                        <li>
                            <a href="{{ route('store.contact') }}" class="transition hover:text-white">
                                Contact Us
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.demo.create') }}" class="transition hover:text-white">
                                Book a Demo
                            </a>
                        </li>

                        <li>
                            <a href="https://erp.yaraelectronics.com/book-service-call"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="inline-flex items-center gap-1.5 transition hover:text-white">
                                Book a Service Call
                                <i data-lucide="external-link" class="h-3.5 w-3.5"></i>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.warranty') }}" class="transition hover:text-white">
                                Warranty Terms
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.delivery') }}" class="transition hover:text-white">
                                Shipping Information
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.delivery') }}" class="transition hover:text-white">
                                Returns & Refunds
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
                                FAQ
                            </a>
                        </li>

                    </ul>

                </div>

            </div>


            {{-- Bottom --}}
            <div class="mt-12 flex flex-col gap-4 border-t border-white/10 pt-8 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Yara Electronics Private Limited. All rights reserved.
                </p>

                <div class="flex items-center gap-4 text-gray-500">

                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 transition hover:bg-brand-600 hover:text-white" aria-label="Facebook">
                        <i data-lucide="globe" class="h-5 w-5"></i>
                    </a>

                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 transition hover:bg-brand-600 hover:text-white" aria-label="Instagram">
                        <i data-lucide="sparkles" class="h-5 w-5"></i>
                    </a>

                    <a href="#" class="flex h-9 w-9 items-center justify-center rounded-full bg-white/5 transition hover:bg-brand-600 hover:text-white" aria-label="Twitter">
                        <i data-lucide="message-circle" class="h-5 w-5"></i>
                    </a>

                </div>

            </div>

        </div>

    </footer>


    @stack('scripts')

</body>
</html>