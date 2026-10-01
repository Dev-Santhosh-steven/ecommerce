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

    <script>window.YARA = @json($shopBoot);</script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="brand-page text-gray-900 antialiased">

    {{-- Header --}}
    {{-- Dark charcoal → crimson, matching the hero banners --}}
    <header class="site-header sticky top-0 z-50 bg-gradient-to-r from-gray-950 via-gray-950 to-brand-950 text-white shadow-lg shadow-black/25">
        {{-- Full-width row: the logo sits at the left edge and the nav spreads out on wide screens --}}
        <div class="mx-auto max-w-[1760px] px-4 sm:px-6 lg:px-10">

            <div class="header-row flex h-20 items-center justify-between gap-4">

                {{-- Logo (white version on the dark header) --}}
                <a href="{{ url('/') }}" class="flex shrink-0 items-center">

                    @if ($siteLogo)

                        <img src="{{ asset('storage/' . ($siteLogoLight ?? $siteLogo)) }}" alt="Yara Electronics" class="header-logo h-14 w-auto max-w-[200px] object-contain sm:h-16 sm:max-w-[240px]">

                    @else

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-600 text-lg font-bold text-white">
                            Y
                        </div>

                    @endif

                </a>


                {{-- Desktop Navigation: every product category up front, company pages under "More" --}}
                @php
                    // Short labels keep every category on one line in the header (full names are on the category pages).
                    $navShort = [
                        'televisions' => 'TVs',
                        'air-conditioners' => 'ACs',
                        'washing-machine' => 'Washing Machines',
                        'interactive-panels' => 'Panels',
                        'led-video-walls' => 'LED Walls',
                        'lcd-video-walls' => 'LCD Walls',
                        'commercial-display-solutions' => 'Commercial Displays',
                    ];

                    $pageLinks = [
                        ['label' => 'About', 'icon' => 'building-2', 'url' => route('store.about'), 'active' => request()->routeIs('store.about')],
                        ['label' => 'Certifications', 'icon' => 'award', 'url' => route('store.certifications'), 'active' => request()->routeIs('store.certifications')],
                        ['label' => 'Contact', 'icon' => 'phone', 'url' => route('store.contact'), 'active' => request()->routeIs('store.contact')],
                        ['label' => 'Blog', 'icon' => 'newspaper', 'url' => route('store.blog.index'), 'active' => request()->routeIs('store.blog.*')],
                    ];
                @endphp

                <nav class="hidden items-center gap-0.5 xl:flex 2xl:gap-1 min-[1700px]:gap-1.5">

                    <a href="{{ url('/') }}" aria-label="Home"
                       class="nav-link flex items-center gap-1.5 {{ request()->routeIs('store.home') ? 'is-active' : '' }}">
                        <i data-lucide="house" class="h-4 w-4"></i>
                    </a>

                    @foreach ($navCategories as $navCategory)

                        <div class="group relative">

                            <a href="{{ route('store.category', $navCategory) }}"
                               class="nav-link flex items-center gap-1 {{ request()->route('category')?->is($navCategory) || request()->route('category')?->parent_id === $navCategory->id ? 'is-active' : '' }}">

                                <span title="{{ $navCategory->name }}">{{ $navShort[$navCategory->slug] ?? $navCategory->name }}</span>

                                @if ($navCategory->children->isNotEmpty())
                                    <i data-lucide="chevron-down" class="hidden h-3.5 w-3.5 opacity-60 transition group-hover:rotate-180 min-[1700px]:block"></i>
                                @endif

                            </a>

                            @if ($navCategory->children->isNotEmpty())

                                <div class="nav-dropdown invisible absolute left-1/2 top-full z-50 w-56 -translate-x-1/2 pt-3 opacity-0 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">

                                    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-2 shadow-xl">

                                        @foreach ($navCategory->children as $child)

                                            <a href="{{ route('store.category', $child) }}" style="--i: {{ $loop->index }}"
                                               class="nav-dropdown-item block rounded-lg px-3 py-2 text-[15px] text-gray-700 hover:bg-brand-50 hover:text-brand-700">
                                                {{ $child->name }}
                                            </a>

                                        @endforeach

                                    </div>

                                </div>

                            @endif

                        </div>

                    @endforeach

                    {{-- Company pages --}}
                    <div class="group relative">

                        <button type="button" class="nav-link flex items-center gap-1 {{ collect($pageLinks)->contains('active', true) ? 'is-active' : '' }}">
                            More
                            <i data-lucide="chevron-down" class="h-3.5 w-3.5 opacity-60 transition group-hover:rotate-180"></i>
                        </button>

                        <div class="nav-dropdown invisible absolute right-0 top-full z-50 w-60 pt-3 opacity-0 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-2 shadow-xl">
                                @foreach ($pageLinks as $link)
                                    <a href="{{ $link['url'] }}" style="--i: {{ $loop->index }}"
                                       class="nav-dropdown-item flex items-center gap-3 rounded-lg px-3 py-2.5 text-[15px] hover:bg-brand-50 hover:text-brand-700 {{ $link['active'] ? 'bg-brand-50 font-semibold text-brand-700' : 'text-gray-700' }}">
                                        <i data-lucide="{{ $link['icon'] }}" class="h-4 w-4 opacity-70"></i>
                                        {{ $link['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                    </div>

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
                            chips: [],
                            pages: [],
                            notes: [],
                            answer: null,
                            corrected: null,
                            total: 0,
                            loading: false,
                            async search() {
                                const q = this.query.trim();
                                if (q.length < 2) { this.results = []; this.chips = []; this.pages = []; this.notes = []; this.answer = null; this.corrected = null; return; }
                                this.loading = true;
                                try {
                                    const res = await fetch('{{ route('store.search.suggest') }}?q=' + encodeURIComponent(q));
                                    const data = await res.json();
                                    if (q !== this.query.trim()) return; // a newer search is on its way
                                    this.results = data.products || [];
                                    this.chips = data.chips || [];
                                    this.pages = data.pages || [];
                                    this.notes = data.notes || [];
                                    this.answer = data.answer || null;
                                    this.corrected = data.corrected || null;
                                    this.total = data.total || 0;
                                } finally {
                                    this.loading = false;
                                }
                            },
                        }"
                        @keydown.escape="open = false"
                    >
                        <button
                            type="button"
                            @click="open = !open; $nextTick(() => open && $refs.searchInput.focus())"
                            class="rounded-full p-2.5 text-white/80 transition hover:bg-white/10 hover:text-white"
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
                                        placeholder="Try “TV under 20000” or “AC for bedroom”"
                                        class="w-full rounded-lg border border-gray-300 py-2.5 pl-9 pr-4 text-sm text-gray-900 placeholder:text-gray-400 focus:border-brand-500 focus:outline-none"
                                    >

                                </div>

                            </form>

                            {{-- What the search understood --}}
                            <p x-show="corrected" x-cloak class="mt-3 text-xs text-gray-500">
                                Showing results for <span class="font-semibold text-gray-900" x-text="corrected"></span>
                            </p>

                            <div x-show="chips.length" x-cloak class="mt-3 flex flex-wrap gap-1.5">
                                <template x-for="chip in chips" :key="chip">
                                    <span class="rounded-full bg-brand-50 px-2.5 py-1 text-xs font-medium text-brand-700" x-text="chip"></span>
                                </template>
                            </div>

                            <template x-for="note in notes" :key="note">
                                <p class="mt-3 rounded-lg bg-amber-50 px-3 py-2 text-xs text-amber-900" x-text="note"></p>
                            </template>

                            <a x-show="answer" x-cloak :href="'{{ route('store.search') }}?q=' + encodeURIComponent(query)"
                               class="mt-3 flex items-center gap-2 rounded-lg bg-gray-50 px-3 py-2 text-sm text-gray-800 transition hover:bg-gray-100">
                                <i data-lucide="message-circle-question" class="h-4 w-4 shrink-0 text-brand-600"></i>
                                <span class="truncate" x-text="answer?.question"></span>
                            </a>

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
                                            <p class="text-xs text-gray-500">
                                                <span class="font-semibold text-gray-700" x-text="item.price || 'Price on request'"></span>
                                                <span x-show="item.category" x-text="' · ' + item.category"></span>
                                            </p>
                                        </div>

                                    </a>

                                </template>

                            </div>

                            <div x-show="pages.length" x-cloak class="mt-3 border-t border-gray-100 pt-3">
                                <p class="mb-1 text-[11px] font-semibold uppercase tracking-wider text-gray-400">Pages &amp; guides</p>
                                <template x-for="page in pages" :key="page.url">
                                    <a :href="page.url" class="flex items-center justify-between gap-3 rounded-lg px-2 py-1.5 text-sm text-gray-700 transition hover:bg-gray-50">
                                        <span class="truncate" x-text="page.title"></span>
                                        <span class="shrink-0 text-xs text-gray-400" x-text="page.kind"></span>
                                    </a>
                                </template>
                            </div>

                            <p x-show="query.trim().length >= 2 && !loading && results.length === 0 && !pages.length && !answer" class="mt-3 text-sm text-gray-500">
                                No matches yet. Try a product, budget or room, e.g. “washing machine under 20000”.
                            </p>

                            <button
                                type="button"
                                x-show="query.trim().length > 0"
                                @click="window.location.href = '{{ route('store.search') }}?q=' + encodeURIComponent(query)"
                                class="mt-3 w-full rounded-lg bg-brand-600 py-2 text-sm font-semibold text-white transition hover:bg-brand-700"
                                x-text="total > results.length ? 'View all ' + total + ' results' : 'View all results'"
                            >
                                View all results
                            </button>

                        </div>

                    </div>


                    {{-- Wishlist --}}
                    <a href="{{ route('wishlist.index') }}" x-data
                       class="relative hidden rounded-full p-2.5 text-white/80 transition hover:bg-white/10 hover:text-white sm:block"
                       aria-label="Wishlist">
                        <i data-lucide="heart" class="h-5 w-5"></i>
                        <span x-show="$store.shop.wishlistCount" x-cloak x-text="$store.shop.wishlistCount"
                              class="absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-white px-1 text-[10px] font-bold text-brand-700"></span>
                    </a>


                    {{-- Account --}}
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
                        <button type="button" @click="open = !open"
                                class="flex items-center gap-2 rounded-full p-2.5 text-white/80 transition hover:bg-white/10 hover:text-white"
                                aria-label="Account" :aria-expanded="open">
                            @auth
                                <span class="flex h-7 w-7 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white">{{ Str::upper(Str::substr(auth()->user()->name, 0, 1)) }}</span>
                                <span class="hidden max-w-[7rem] truncate text-sm font-medium 2xl:block">{{ Str::before(auth()->user()->name, ' ') }}</span>
                            @else
                                <i data-lucide="user-round" class="h-5 w-5"></i>
                            @endauth
                        </button>

                        <div x-show="open" x-cloak x-transition.origin.top.right
                             class="absolute right-0 top-full z-50 mt-3 w-72 overflow-hidden rounded-2xl border border-gray-200 bg-white text-gray-900 shadow-2xl">
                            @auth
                                <div class="bg-gradient-to-br from-gray-950 to-brand-950 px-5 py-4 text-white">
                                    <p class="text-xs text-white/60">Signed in as</p>
                                    <p class="truncate font-semibold">{{ auth()->user()->name }}</p>
                                    <p class="truncate text-xs text-white/60">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="p-2">
                                    @foreach ([['account.index', 'user-round', 'My account'], ['wishlist.index', 'heart', 'My wishlist'], ['cart.index', 'shopping-bag', 'My cart']] as [$r, $icon, $label])
                                        <a href="{{ route($r) }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition hover:bg-brand-50 hover:text-brand-700">
                                            <i data-lucide="{{ $icon }}" class="h-4 w-4 text-gray-400"></i>{{ $label }}
                                        </a>
                                    @endforeach
                                    @if (auth()->user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition hover:bg-brand-50 hover:text-brand-700">
                                            <i data-lucide="layout-dashboard" class="h-4 w-4 text-gray-400"></i>Admin panel
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('logout') }}" class="mt-1 border-t border-gray-100 pt-1">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-600 transition hover:bg-gray-50">
                                            <i data-lucide="log-out" class="h-4 w-4 text-gray-400"></i>Sign out
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="p-5">
                                    <p class="font-display text-lg font-bold">Welcome to Yara</p>
                                    <p class="mt-1 text-sm text-gray-500">Sign in to save your wishlist and cart on every device.</p>
                                    <a href="{{ route('login', ['redirect' => '/' . ltrim(request()->path(), '/')]) }}" class="mt-4 flex w-full items-center justify-center rounded-full bg-brand-600 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">Sign in</a>
                                    <p class="mt-3 text-center text-sm text-gray-500">New here? <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:underline">Create an account</a></p>
                                </div>
                                <div class="border-t border-gray-100 p-2">
                                    <a href="{{ route('wishlist.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition hover:bg-brand-50 hover:text-brand-700"><i data-lucide="heart" class="h-4 w-4 text-gray-400"></i>My wishlist</a>
                                    <a href="{{ route('cart.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition hover:bg-brand-50 hover:text-brand-700"><i data-lucide="shopping-bag" class="h-4 w-4 text-gray-400"></i>My cart</a>
                                </div>
                            @endauth
                        </div>
                    </div>


                    {{-- Cart --}}
                    <button type="button" x-data @click="$store.shop.openCart()"
                            class="relative rounded-full p-2.5 text-white/80 transition hover:bg-white/10 hover:text-white"
                            aria-label="Shopping cart">
                        <i data-lucide="shopping-bag" class="h-5 w-5"></i>
                        <span x-text="$store.shop.cartCount" :class="$store.shop.cartCount ? 'scale-100' : 'scale-0'"
                              class="absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-brand-red px-1 text-[10px] font-semibold text-white transition">{{ $shopBoot['cartCount'] }}</span>
                    </button>


                    {{-- Mobile Menu --}}
                    <button
                        type="button"
                        x-data
                        @click="$dispatch('toggle-mobile-menu')"
                        class="rounded-full p-2.5 text-white/80 transition hover:bg-white/10 hover:text-white xl:hidden"
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
            class="border-t border-white/10 bg-gray-950 xl:hidden"
        >

            <nav class="mx-auto flex max-w-[1760px] flex-col px-4 py-4 sm:px-6">

                <form action="{{ route('store.search') }}" method="GET" class="relative mb-3">

                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>

                    <input
                        type="text"
                        name="q"
                        placeholder="Search products..."
                        class="w-full rounded-lg border border-white/15 bg-white/10 py-2.5 pl-9 pr-4 text-sm text-white placeholder:text-white/50 focus:border-brand-400 focus:outline-none"
                    >

                </form>

                <a href="{{ url('/') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium text-white/85 transition hover:bg-white/10 hover:text-white">
                    Home
                </a>

                @foreach ($navCategories as $navCategory)

                    @if ($navCategory->children->isNotEmpty())

                        <div x-data="{ expanded: false }">

                            <button
                                type="button"
                                @click="expanded = !expanded"
                                class="flex w-full items-center justify-between rounded-lg px-3 py-3 text-left text-[15px] font-medium text-white/85 transition hover:bg-white/10 hover:text-white"
                            >
                                {{ $navCategory->name }}
                                <i data-lucide="chevron-down" class="h-4 w-4 text-gray-400 transition-transform" :class="expanded ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="expanded" x-cloak class="ml-3 space-y-1 border-l border-white/10 pl-3">

                                <a href="{{ route('store.category', $navCategory) }}" class="block rounded-lg px-3 py-2 text-sm text-white/70 transition hover:bg-white/10 hover:text-white">
                                    All {{ $navCategory->name }}
                                </a>

                                @foreach ($navCategory->children as $child)

                                    <a href="{{ route('store.category', $child) }}" class="block rounded-lg px-3 py-2 text-sm text-white/70 transition hover:bg-white/10 hover:text-white">
                                        {{ $child->name }}
                                    </a>

                                @endforeach

                            </div>

                        </div>

                    @else

                        <a href="{{ route('store.category', $navCategory) }}"
                           class="rounded-lg px-3 py-3 text-[15px] font-medium text-white/85 transition hover:bg-white/10 hover:text-white">
                            {{ $navCategory->name }}
                        </a>

                    @endif

                @endforeach

                <a href="{{ route('store.about') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium text-white/85 transition hover:bg-white/10 hover:text-white">
                    About
                </a>

                <a href="{{ route('store.certifications') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium text-white/85 transition hover:bg-white/10 hover:text-white">
                    Certifications
                </a>

                <a href="{{ route('store.blog.index') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium text-white/85 transition hover:bg-white/10 hover:text-white">
                    Blog
                </a>

                <a href="{{ route('store.contact') }}"
                   class="rounded-lg px-3 py-3 text-[15px] font-medium text-white/85 transition hover:bg-white/10 hover:text-white">
                    Contact
                </a>

            </nav>

        </div>

        {{-- Reading progress --}}
        <div class="scroll-progress" aria-hidden="true"></div>

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

                        @if ($siteLogoLight)

                            <img src="{{ asset('storage/' . $siteLogoLight) }}" alt="Yara Electronics" class="h-14 w-auto">

                        @elseif ($siteLogo)

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
                            <a href="{{ route('store.certifications') }}" class="transition hover:text-white">
                                Certifications
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('store.blog.index') }}" class="transition hover:text-white">
                                Blog
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
                            <a href="{{ route('store.delivery') }}" class="transition hover:text-white">
                                Shipping Information
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


    {{-- Back to top (bottom-left, clear of the chatbot) with a scroll-progress ring --}}
    <button type="button" class="back-to-top fixed bottom-6 left-4 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-gray-950 text-white shadow-xl shadow-black/30 transition hover:bg-brand-600 sm:left-6" aria-label="Back to top">
        <svg class="absolute inset-0 h-full w-full -rotate-90" viewBox="0 0 48 48" aria-hidden="true">
            <circle cx="24" cy="24" r="22" fill="none" stroke="rgb(255 255 255 / 0.12)" stroke-width="2"/>
            <circle class="ring" cx="24" cy="24" r="22" fill="none" stroke="#ed1c24" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <i data-lucide="arrow-up" class="relative h-5 w-5"></i>
    </button>

    {{-- Chatbot (bottom-right robot button) --}}

    {{-- Mini cart drawer --}}
    <div x-data x-show="$store.shop.drawer" x-cloak class="fixed inset-0 z-[80]" @keydown.escape.window="$store.shop.drawer = false">
        <div x-show="$store.shop.drawer" x-transition.opacity class="absolute inset-0 bg-gray-950/60 backdrop-blur-sm" @click="$store.shop.drawer = false"></div>
        <aside x-show="$store.shop.drawer"
               x-transition:enter="transition duration-300 ease-out" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
               x-transition:leave="transition duration-200 ease-in" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
               class="absolute inset-y-0 right-0 flex w-full max-w-md flex-col bg-white shadow-2xl" role="dialog" aria-label="Your cart">
            <div class="flex items-center justify-between bg-gradient-to-r from-gray-950 to-brand-950 px-6 py-5 text-white">
                <div>
                    <p class="font-display text-lg font-bold">Your cart</p>
                    <p class="text-xs text-white/60"><span x-text="$store.shop.cartCount"></span> item<span x-show="$store.shop.cartCount !== 1">s</span></p>
                </div>
                <button type="button" @click="$store.shop.drawer = false" class="rounded-full p-2 hover:bg-white/10" aria-label="Close cart"><i data-lucide="x" class="h-5 w-5"></i></button>
            </div>

            <div class="flex-1 overflow-y-auto px-6 py-4">
                <template x-if="$store.shop.loading && !$store.shop.cart.items.length">
                    <div class="space-y-4">
                        <template x-for="n in 3"><div class="h-24 animate-pulse rounded-2xl bg-gray-100"></div></template>
                    </div>
                </template>

                <template x-if="!$store.shop.loading && !$store.shop.cart.items.length">
                    <div class="flex h-full flex-col items-center justify-center py-16 text-center">
                        <span class="flex h-20 w-20 items-center justify-center rounded-full bg-brand-50 text-brand-600"><i data-lucide="shopping-bag" class="h-9 w-9"></i></span>
                        <p class="mt-5 font-display text-xl font-bold">Your cart is empty</p>
                        <p class="mt-1 text-sm text-gray-500">Explore TVs, ACs, washing machines and more.</p>
                        <a href="{{ route('store.search') }}" class="mt-6 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700">Start shopping</a>
                    </div>
                </template>

                <ul class="divide-y divide-gray-100">
                    <template x-for="item in $store.shop.cart.items" :key="item.id">
                        <li class="flex gap-4 py-4">
                            <a :href="item.url" class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-gray-50 ring-1 ring-gray-100">
                                <img :src="item.image" :alt="item.name" class="h-full w-full object-contain">
                            </a>
                            <div class="min-w-0 flex-1">
                                <a :href="item.url" class="line-clamp-2 text-sm font-semibold text-gray-900 hover:text-brand-600" x-text="item.name"></a>
                                <p class="mt-1 text-sm">
                                    <span class="font-bold" x-text="$store.shop.money(item.price)"></span>
                                    <span x-show="item.mrp > item.price" class="ml-1 text-xs text-gray-400 line-through" x-text="$store.shop.money(item.mrp)"></span>
                                </p>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="inline-flex items-center rounded-full ring-1 ring-gray-200">
                                        <button type="button" @click="$store.shop.setQty(item, item.quantity - 1)" :disabled="item.quantity <= 1" class="flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-100 disabled:opacity-30" aria-label="Decrease">&minus;</button>
                                        <span class="w-7 text-center text-sm font-semibold" x-text="item.quantity"></span>
                                        <button type="button" @click="$store.shop.setQty(item, item.quantity + 1)" :disabled="item.quantity >= item.max" class="flex h-8 w-8 items-center justify-center rounded-full text-gray-600 hover:bg-gray-100 disabled:opacity-30" aria-label="Increase">+</button>
                                    </div>
                                    <button type="button" @click="$store.shop.removeItem(item)" class="text-xs font-medium text-gray-500 hover:text-brand-600">Remove</button>
                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>

            <div x-show="$store.shop.cart.items.length" class="border-t border-gray-100 px-6 py-5">
                <div class="flex items-center justify-between text-sm text-gray-500">
                    <span>Delivery</span><span class="font-semibold text-emerald-600">FREE</span>
                </div>
                <div x-show="$store.shop.cart.summary.discount > 0" class="mt-1 flex items-center justify-between text-sm text-gray-500">
                    <span>You save</span><span class="font-semibold text-emerald-600" x-text="$store.shop.money($store.shop.cart.summary.discount)"></span>
                </div>
                <div class="mt-2 flex items-center justify-between">
                    <span class="font-semibold">Subtotal</span>
                    <span class="font-display text-2xl font-extrabold" x-text="$store.shop.money($store.shop.cart.summary.total)"></span>
                </div>
                <a href="{{ route('cart.index') }}" class="mt-4 flex w-full items-center justify-center gap-2 rounded-full bg-brand-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700">
                    View cart &amp; checkout <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
                <button type="button" @click="$store.shop.drawer = false" class="mt-2 w-full py-2 text-sm font-medium text-gray-500 hover:text-gray-900">Continue shopping</button>
            </div>
        </aside>
    </div>

    {{-- Toasts --}}
    <div x-data class="pointer-events-none fixed inset-x-0 bottom-6 z-[90] flex flex-col items-center gap-2 px-4">
        <template x-for="t in $store.shop.toasts" :key="t.id">
            <div x-transition class="pointer-events-auto flex items-center gap-3 rounded-full bg-gray-950 py-3 pl-5 pr-3 text-sm text-white shadow-2xl ring-1 ring-white/10">
                <i data-lucide="check-circle-2" class="h-4 w-4 text-emerald-400"></i>
                <span x-text="t.message"></span>
                <a x-show="t.action" :href="t.action?.href" x-text="t.action?.label" class="rounded-full bg-white/10 px-3 py-1 font-semibold text-brand-300 hover:bg-white/20"></a>
            </div>
        </template>
    </div>

    @include('store.partials.chatbot')

    @stack('scripts')

</body>
</html>