<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Yara Store')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- Header --}}
    <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex h-20 items-center justify-between gap-6">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-900 text-lg font-bold text-white">
                        Y
                    </div>

                    <span class="text-xl font-bold tracking-tight">
                        Yara Store
                    </span>
                </a>


                {{-- Desktop Navigation --}}
                <nav class="hidden items-center gap-8 md:flex">

                    <a href="{{ url('/') }}"
                       class="text-sm font-medium text-gray-700 transition hover:text-gray-950">
                        Home
                    </a>

                    <a href="#categories"
                       class="text-sm font-medium text-gray-700 transition hover:text-gray-950">
                        Categories
                    </a>

                    <a href="#products"
                       class="text-sm font-medium text-gray-700 transition hover:text-gray-950">
                        Products
                    </a>

                    <a href="#about"
                       class="text-sm font-medium text-gray-700 transition hover:text-gray-950">
                        About
                    </a>

                    <a href="#contact"
                       class="text-sm font-medium text-gray-700 transition hover:text-gray-950">
                        Contact
                    </a>

                </nav>


                {{-- Right Side --}}
                <div class="flex items-center gap-3">

                    {{-- Search --}}
                    <button
                        type="button"
                        class="hidden rounded-full p-2.5 text-gray-600 transition hover:bg-gray-100 hover:text-gray-950 sm:block"
                        aria-label="Search"
                    >
                        <i data-lucide="search" class="h-5 w-5"></i>
                    </button>


                    {{-- Account --}}
                    <button
                        type="button"
                        class="hidden rounded-full p-2.5 text-gray-600 transition hover:bg-gray-100 hover:text-gray-950 sm:block"
                        aria-label="Account"
                    >
                        <i data-lucide="user-round" class="h-5 w-5"></i>
                    </button>


                    {{-- Cart --}}
                    <button
                        type="button"
                        class="relative rounded-full p-2.5 text-gray-600 transition hover:bg-gray-100 hover:text-gray-950"
                        aria-label="Shopping cart"
                    >
                        <i data-lucide="shopping-bag" class="h-5 w-5"></i>

                        <span class="absolute -right-0.5 -top-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-gray-900 text-[10px] font-semibold text-white">
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

                <a href="{{ url('/') }}"
                   class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-gray-100">
                    Home
                </a>

                <a href="#categories"
                   class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-gray-100">
                    Categories
                </a>

                <a href="#products"
                   class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-gray-100">
                    Products
                </a>

                <a href="#about"
                   class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-gray-100">
                    About
                </a>

                <a href="#contact"
                   class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-gray-100">
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
    <footer id="contact" class="border-t border-gray-200 bg-gray-950 text-white">

        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

                {{-- Brand --}}
                <div>

                    <div class="mb-5 flex items-center gap-2">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-lg font-bold text-gray-950">
                            Y
                        </div>

                        <span class="text-xl font-bold">
                            Yara Store
                        </span>

                    </div>

                    <p class="max-w-sm text-sm leading-6 text-gray-400">
                        Discover quality products, great value and a seamless shopping experience.
                    </p>

                </div>


                {{-- Shop --}}
                <div>

                    <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider">
                        Shop
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-400">

                        <li>
                            <a href="#products" class="transition hover:text-white">
                                All Products
                            </a>
                        </li>

                        <li>
                            <a href="#categories" class="transition hover:text-white">
                                Categories
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
                                New Arrivals
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
                                Best Sellers
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Information --}}
                <div id="about">

                    <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider">
                        Information
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-400">

                        <li>
                            <a href="#" class="transition hover:text-white">
                                About Us
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
                                Catalogue
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
                                Privacy Policy
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
                                Terms & Conditions
                            </a>
                        </li>

                    </ul>

                </div>


                {{-- Customer Service --}}
                <div>

                    <h3 class="mb-5 text-sm font-semibold uppercase tracking-wider">
                        Customer Service
                    </h3>

                    <ul class="space-y-3 text-sm text-gray-400">

                        <li>
                            <a href="#" class="transition hover:text-white">
                                Contact Us
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
                                Shipping Information
                            </a>
                        </li>

                        <li>
                            <a href="#" class="transition hover:text-white">
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
            <div class="mt-12 flex flex-col gap-4 border-t border-gray-800 pt-8 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-sm text-gray-500">
                    © {{ date('Y') }} Yara Store. All rights reserved.
                </p>

                <div class="flex items-center gap-4 text-gray-500">

                    <a href="#" class="transition hover:text-white" aria-label="Facebook">
                        <i data-lucide="globe" class="h-5 w-5"></i>
                    </a>

                    <a href="#" class="transition hover:text-white" aria-label="Instagram">
                        <i data-lucide="sparkles" class="h-5 w-5"></i>
                    </a>

                    <a href="#" class="transition hover:text-white" aria-label="Twitter">
                        <i data-lucide="message-circle" class="h-5 w-5"></i>
                    </a>

                </div>

            </div>

        </div>

    </footer>


    @stack('scripts')

</body>
</html>