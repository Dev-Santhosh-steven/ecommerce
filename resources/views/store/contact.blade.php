@extends('layouts.store')

@section('title', 'Contact Us | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Contact Us</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Contact Us
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            Questions about a product, an order, or a service call? Reach us directly, or drop by
            our Coimbatore showroom and see the range in person.
        </p>

    </div>

</section>


{{-- =========================================================
     CONTACT CARDS
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Call --}}
            <a href="tel:9842881500"
               class="group flex flex-col rounded-2xl border border-gray-200 p-6 transition hover:-translate-y-1 hover:shadow-xl">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-brand-600 text-white transition group-hover:bg-brand-700">
                    <i data-lucide="phone" class="h-5 w-5"></i>
                </div>

                <h3 class="font-semibold text-gray-900">Call Us</h3>
                <p class="mt-1 text-sm text-gray-500">Speak to our support team directly.</p>
                <p class="mt-3 text-sm font-semibold text-gray-900">98428 81500</p>

            </a>


            {{-- WhatsApp --}}
            <a href="https://wa.me/919842881500" target="_blank" rel="noopener noreferrer"
               class="group flex flex-col rounded-2xl border border-gray-200 p-6 transition hover:-translate-y-1 hover:shadow-xl">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-brand-600 text-white transition group-hover:bg-brand-700">
                    <i data-lucide="message-circle" class="h-5 w-5"></i>
                </div>

                <h3 class="font-semibold text-gray-900">WhatsApp Us</h3>
                <p class="mt-1 text-sm text-gray-500">Chat with us for a quick response.</p>
                <p class="mt-3 text-sm font-semibold text-gray-900">98428 81500</p>

            </a>


            {{-- Email --}}
            <div
                x-data="{ copied: false }"
                class="group flex flex-col rounded-2xl border border-gray-200 p-6 transition hover:-translate-y-1 hover:shadow-xl"
            >

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-brand-600 text-white transition group-hover:bg-brand-700">
                    <i data-lucide="mail" class="h-5 w-5"></i>
                </div>

                <h3 class="font-semibold text-gray-900">Email Us</h3>
                <p class="mt-1 text-sm text-gray-500">Write to us anytime.</p>

                <button
                    type="button"
                    @click="navigator.clipboard.writeText('info@yaraelectronics.com'); copied = true; setTimeout(() => copied = false, 1500)"
                    class="mt-3 flex items-center gap-1.5 text-left text-sm font-semibold text-gray-900 hover:text-gray-600"
                >
                    <span x-show="!copied">info@yaraelectronics.com</span>
                    <span x-show="copied" x-cloak class="text-green-600">Copied to clipboard!</span>
                    <i data-lucide="copy" class="h-3.5 w-3.5 text-gray-400" x-show="!copied"></i>
                    <i data-lucide="check" class="h-3.5 w-3.5 text-green-600" x-show="copied" x-cloak></i>
                </button>

            </div>


            {{-- Showroom --}}
            <a href="#showroom"
               class="group flex flex-col rounded-2xl border border-gray-200 p-6 transition hover:-translate-y-1 hover:shadow-xl">

                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-brand-600 text-white transition group-hover:bg-brand-700">
                    <i data-lucide="store" class="h-5 w-5"></i>
                </div>

                <h3 class="font-semibold text-gray-900">Visit Our Showroom</h3>
                <p class="mt-1 text-sm text-gray-500">See the full range in person.</p>
                <p class="mt-3 text-sm font-semibold text-gray-900">PVG Towers, Coimbatore</p>

            </a>

        </div>


        {{-- Book a service call CTA --}}
        <div class="mt-8 flex flex-col items-center justify-between gap-4 rounded-2xl bg-gray-950 px-6 py-6 text-white sm:flex-row">

            <div>
                <h3 class="font-semibold">Need a technician instead?</h3>
                <p class="mt-1 text-sm text-gray-300">Book a service call and we'll take it from there.</p>
            </div>

            <a href="https://erp.yaraelectronics.com/book-service-call" target="_blank" rel="noopener noreferrer"
               class="inline-flex shrink-0 items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">
                Book a Service Call
                <i data-lucide="external-link" class="h-4 w-4"></i>
            </a>

        </div>

    </div>

</section>


{{-- =========================================================
     SHOWROOM / MAP
========================================================= --}}
<section id="showroom" class="scroll-mt-24 bg-gray-50 py-14" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid gap-10 lg:grid-cols-2 lg:items-center">

            <div>

                <h2 class="text-xl font-bold tracking-tight text-gray-900">
                    Visit the Yara Showroom
                </h2>

                <p class="mt-3 leading-7 text-gray-600">
                    Want to see our TVs, ACs, and washing machines up close before you buy? Drop by
                    our showroom at PVG Towers &mdash; our team is happy to walk you through the
                    full range and help you find the right fit for your home.
                </p>

                <div class="mt-6 flex gap-3">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-950 text-white">
                        <i data-lucide="map-pin" class="h-5 w-5"></i>
                    </div>

                    <address class="not-italic leading-6 text-gray-600">
                        PVG Towers,<br>
                        473 Avinashi Road, Peelamedu,<br>
                        Coimbatore, Tamil Nadu &ndash; 641004
                    </address>

                </div>

                <a href="https://www.google.com/maps/dir/?api=1&destination=PVG+Towers%2C+473+Avinashi+Road%2C+Peelamedu%2C+Coimbatore%2C+Tamil+Nadu+641004"
                   target="_blank" rel="noopener noreferrer"
                   class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                    <i data-lucide="navigation" class="h-4 w-4"></i>
                    Get Directions
                </a>

            </div>

            <div class="aspect-[4/3] overflow-hidden rounded-2xl border border-gray-200 shadow-sm">

                <iframe
                    class="h-full w-full"
                    src="https://www.google.com/maps?q=PVG+Towers,+473+Avinashi+Road,+Peelamedu,+Coimbatore,+Tamil+Nadu+641004&output=embed"
                    title="Yara Electronics Showroom Location"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                ></iframe>

            </div>

        </div>

    </div>

</section>

@endsection
