@extends('layouts.store')

@section('title', 'About Us | Yara Electronics')

@php
    /*
     * About page content. Edit text here; product cards come from the live categories.
     * Leadership bios, vision and mission are starter copy to be reviewed by the team.
     */

    $stats = [
        ['value' => 10, 'suffix' => '+', 'label' => 'Product categories', 'icon' => 'layers'],
        ['value' => 100, 'suffix' => '"', 'label' => 'Largest TV we make', 'icon' => 'tv'],
        ['value' => 500, 'suffix' => '"', 'label' => 'Largest LED wall', 'icon' => 'layout-grid'],
        ['value' => 13, 'suffix' => '+', 'label' => 'Certifications & registrations', 'icon' => 'badge-check'],
    ];

    // Our journey, drawn as a wave: arcs alternate above and below the line (see the Our Story section).
    $timeline = [
        [
            'year' => 2018,
            'tag' => 'B2C Brand',
            'text' => 'Introduced our own brand, Yara, as a distribution-focused brand with import of LED TVs and washing machines.',
            'icon' => 'rocket',
            'color' => '#a51d35',
        ],
        [
            'year' => 2021,
            'tag' => 'Manufacturing',
            'text' => 'Commenced TV assembly at Ceezet Electronics with a state-of-the-art 30,000 sq ft facility and a 1,00,000 sq ft warehouse.',
            'icon' => 'factory',
            'color' => '#ed1c24',
        ],
        [
            'year' => 2023,
            'tag' => 'B2B Vertical',
            'text' => 'Established a separate vertical for B2B business, focused on providing solutions to educational institutions.',
            'icon' => 'graduation-cap',
            'color' => '#721524',
        ],
        [
            'year' => 2025,
            'tag' => 'Expansion Phase',
            'text' => 'Indigenising components, identifying target industries, introducing CMS and DMS, and increasing volumes in TV and display products.',
            'icon' => 'trending-up',
            'color' => '#33070f',
        ],
    ];

    $leaders = [
        [
            'name' => 'Mr. Prabhu Devarajan',
            'role' => 'Chief Executive Officer',
            'initials' => 'PD',
            'bio' => 'Mr. Prabhu leads the company\'s strategy and operations, from the Ceezet factory floor to product development and nationwide sales. He drives Yara\'s focus on smart, customisable products and on building long-term partnerships with schools, businesses and dealers.',
        ],
        [
            'name' => 'Mrs. Chaithaniya Keerthy',
            'role' => 'Chief Financial Officer',
            'initials' => 'CK',
            'bio' => 'Mrs. Chaithaniya oversees finance, planning and compliance across the business. Her disciplined approach to cost, supply chain and investment keeps Yara products competitively priced while funding continued growth in manufacturing.',
        ],
    ];

    $customisation = [
        ['icon' => 'ruler', 'title' => 'Any size, any spec', 'text' => 'TVs from 24" to 100" and panels from 55" to 98", configured with the brightness, memory and ports your project needs.'],
        ['icon' => 'stamp', 'title' => 'Your brand on it', 'text' => 'Custom boot logos, home screens and packaging for institutions, dealers and corporate orders.'],
        ['icon' => 'app-window', 'title' => 'Software pre-loaded', 'text' => 'Education, signage or business apps installed and set up before delivery, ready to use out of the box.'],
        ['icon' => 'cpu', 'title' => 'OPS & hardware add-ons', 'text' => 'Windows/Linux OPS modules, AI cameras and microphones for hybrid classrooms and meeting rooms.'],
        ['icon' => 'move', 'title' => 'Mounting that fits', 'text' => 'Wall brackets, mobile trolleys, kiosks, standees and rotating displays for every space.'],
        ['icon' => 'boxes', 'title' => 'Bulk & project orders', 'text' => 'Dedicated support for schools, government projects and enterprise roll-outs across India.'],
    ];

    $promises = [
        ['icon' => 'wifi', 'title' => 'Smart & connected', 'text' => 'Google TV, Android 14 panels, wireless screen sharing and app ecosystems built in.'],
        ['icon' => 'flag', 'title' => 'Made in India', 'text' => 'Designed and assembled at our own factory in Coimbatore, Tamil Nadu.'],
        ['icon' => 'shield-check', 'title' => 'Reliable warranty', 'text' => 'Comprehensive manufacturer warranty backed by authorised service.'],
        ['icon' => 'headset', 'title' => 'Service that shows up', 'text' => 'Book a service call online and our technicians take it from there.'],
        ['icon' => 'hand-coins', 'title' => 'Honest pricing', 'text' => 'Factory-direct value, with delivery included in the price.'],
        ['icon' => 'heart-handshake', 'title' => 'Customers first', 'text' => 'From demo to installation to after-sales, we stay with you.'],
    ];

    $mark = fn ($file) => asset("images/certifications/{$file}");
    $certifications = [
        ['code' => 'BIS', 'name' => 'Bureau of Indian Standards', 'text' => 'Products tested and certified to Indian safety standards.', 'logo' => $mark('bis.png')],
        ['code' => 'ISO 9001', 'name' => 'Quality Management', 'text' => 'ISO 9001:2015 certified quality processes.', 'logo' => $mark('iso-9001.png')],
        ['code' => 'ISO 14001', 'name' => 'Environmental Management', 'text' => 'Responsible, environment-conscious manufacturing.', 'logo' => $mark('iso-14001.png')],
        ['code' => 'ISO 27001', 'name' => 'Information Security', 'text' => 'Secure handling of customer and business data.', 'logo' => $mark('iso-27001.png')],
        ['code' => 'BEE', 'name' => 'Bureau of Energy Efficiency', 'text' => 'Energy-efficiency rated appliances.', 'logo' => $mark('bee.png')],
        ['code' => 'CE', 'name' => 'Conformité Européenne', 'text' => 'Meets European health, safety and environmental norms.', 'logo' => $mark('ce.png')],
        ['code' => 'RoHS', 'name' => 'RoHS Compliant', 'text' => 'Free from restricted hazardous substances.', 'logo' => $mark('rohs.png')],
        ['code' => 'LMPC', 'name' => 'Legal Metrology', 'text' => 'Registered for packaged commodities.', 'logo' => $mark('lmpc.png')],
        ['code' => 'MSME', 'name' => 'Udyam Registered', 'text' => 'Recognised Indian micro, small & medium enterprise.', 'logo' => $mark('msme.png')],
        ['code' => 'QRO', 'name' => 'Quality Research Organization', 'text' => 'Independently certified quality systems.', 'logo' => $mark('qro.png')],
        ['code' => 'Startup India', 'name' => 'Startup India', 'text' => 'Recognised by DPIIT under the Startup India initiative.', 'logo' => null, 'icon' => 'rocket'],
        ['code' => 'CPCB', 'name' => 'Central Pollution Control Board', 'text' => 'Registered for responsible e-waste management (EPR).', 'logo' => null, 'icon' => 'recycle'],
    ];

    $ticker = ['Smart TVs', 'Google TVs', 'Interactive Flat Panels', 'LED Video Walls', 'Digital Standees', 'Kiosks', 'Air Conditioners', 'Washing Machines', 'Commercial Displays'];
@endphp

@section('content')

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative overflow-hidden bg-gray-950 text-white">

    <div class="about-grid absolute inset-0"></div>
    <div class="about-blob -left-24 top-10 h-80 w-80 bg-brand-600"></div>
    <div class="about-blob -right-20 bottom-0 h-96 w-96 bg-brand-red/60 [animation-delay:-5s]"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 pb-24 pt-16 sm:px-6 lg:grid-cols-2 lg:px-8 lg:pb-28 lg:pt-20">

        <div class="about-intro">

            <nav class="text-sm text-gray-400">
                <a href="{{ route('store.home') }}" class="transition hover:text-white">Home</a>
                <span class="mx-2">/</span>
                <span class="text-white">About Us</span>
            </nav>

            <h1 class="mt-8 text-4xl font-bold leading-[1.05] sm:text-6xl">
                Display Solutions<br>
                to <span class="about-gradient-text">Everyone.</span>
            </h1>

            <p class="mt-6 max-w-xl text-lg leading-8 text-gray-300">
                Yara Electronics designs and manufactures smart TVs, interactive panels, LED video walls and home
                appliances at our own factory in Coimbatore, and customises them for every home, classroom and business we serve.
            </p>

            <div class="mt-9 flex flex-wrap gap-4">
                <a href="{{ route('store.demo.create') }}" class="about-shine inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/40 transition hover:bg-brand-500">
                    Book a Demo
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
                <a href="#factory" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i data-lucide="play" class="h-4 w-4"></i>
                    See our factory
                </a>
            </div>

        </div>


        {{-- Image collage --}}
        <div class="relative mx-auto w-full max-w-lg lg:max-w-none">

            <div class="about-float relative overflow-hidden rounded-3xl shadow-2xl shadow-black/50 ring-1 ring-white/10">
                <img src="{{ asset('images/brand/yara-range-office.jpg') }}" alt="The Yara range together: LED and LCD video walls, 100 inch Centum TV, air conditioner, interactive panel, chiller, stand alone kiosk, washing machine and tower speakers" class="aspect-[4/3] w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/60 via-transparent to-transparent"></div>
                <p class="absolute bottom-5 left-5 text-sm font-medium text-white/90">The Yara range · one brand for home, office &amp; business</p>
            </div>

            <div class="about-float absolute -bottom-8 -right-3 flex items-center gap-3 rounded-2xl bg-white p-4 text-gray-900 shadow-2xl sm:-right-8">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-600 text-white">
                    <i data-lucide="badge-check" class="h-6 w-6"></i>
                </span>
                <span>
                    <span class="block text-sm font-bold">BIS · ISO · BEE</span>
                    <span class="block text-xs text-gray-500">Certified quality</span>
                </span>
            </div>

        </div>

    </div>

    <div class="absolute inset-x-0 bottom-0 h-1.5 bg-gradient-to-r from-brand-600 via-brand-red to-brand-600"></div>

</section>


{{-- =========================================================
     PRODUCT TICKER
========================================================= --}}
<div class="overflow-hidden border-b border-gray-200 bg-white py-5">
    <div class="about-marquee">
        @foreach ([1, 2] as $copy)
            <div class="flex shrink-0 items-center" @if ($copy === 2) aria-hidden="true" @endif>
                @foreach ($ticker as $item)
                    <span class="px-8 font-display text-xl font-semibold text-gray-300 transition hover:text-brand-600 sm:text-2xl">{{ $item }}</span>
                    <span class="h-2 w-2 shrink-0 rotate-45 bg-brand-red"></span>
                @endforeach
            </div>
        @endforeach
    </div>
</div>


{{-- =========================================================
     STATS
========================================================= --}}
<section class="bg-white py-16">

    <div class="mx-auto grid max-w-7xl grid-cols-2 gap-5 px-4 sm:px-6 lg:grid-cols-4 lg:px-8">

        @foreach ($stats as $i => $stat)

            <div data-reveal style="--reveal-delay: {{ $i * 120 }}ms"
                 class="about-shine group rounded-3xl border border-gray-200 bg-white p-6 text-center transition duration-300 hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl sm:p-8">

                <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition group-hover:rotate-6 group-hover:bg-brand-600 group-hover:text-white">
                    <i data-lucide="{{ $stat['icon'] }}" class="h-6 w-6"></i>
                </span>

                <p class="mt-5 font-display text-4xl font-extrabold tabular-nums text-gray-900 sm:text-5xl">
                    <span data-about-count="{{ $stat['value'] }}">{{ number_format($stat['value']) }}</span><span class="text-brand-600">{{ $stat['suffix'] }}</span>
                </p>

                <p class="mt-2 text-sm font-medium text-gray-500">{{ $stat['label'] }}</p>

            </div>

        @endforeach

    </div>

</section>


{{-- =========================================================
     OUR STORY + JOURNEY (wave timeline)
========================================================= --}}
<section class="relative overflow-hidden bg-gray-50 py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid gap-10 lg:grid-cols-5" data-reveal>

            <div class="lg:col-span-2">
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Our Story</p>
                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">
                    From Coimbatore to <span class="text-brand-600">India's screens.</span>
                </h2>
            </div>

            <div class="space-y-5 leading-7 text-gray-600 lg:col-span-3">
                <p>
                    <strong class="text-gray-900">Yara Electronics was founded in 2018</strong> with a distinct mission: to bring
                    top-notch electronic innovation within everyone's reach. Our range covers every part of modern living,
                    from the living-room TV to the classroom, the boardroom and the stage.
                </p>
                <p>
                    Our products are built at <strong class="text-gray-900">Ceezet Electronics</strong>, our own factory in
                    Coimbatore, on a state-of-the-art production line. Every product is crafted by our team of experts to blend
                    high-tech features with everyday usability, shaped around what each customer actually needs.
                </p>
            </div>

        </div>


        {{-- Desktop: the wave. Arcs alternate above / below the line; everything draws in one milestone after another. --}}
        <div class="journey relative mt-20 hidden lg:grid lg:grid-cols-4" data-reveal data-no-auto-reveal>

            <span class="journey-line absolute inset-x-0 top-1/2 h-0.5 -translate-y-1/2 rounded-full bg-gradient-to-r from-gray-200 via-brand-200 to-gray-200"></span>

            @foreach ($timeline as $i => $step)
                @php $up = $i % 2 === 0; @endphp

                <div class="journey-step group relative h-[36rem]" style="--i: {{ $i }}; --c: {{ $step['color'] }}">

                    {{-- half arc --}}
                    <span class="journey-arc absolute left-1/2 w-60 -translate-x-1/2 {{ $up ? 'is-up' : 'is-down' }}"></span>

                    {{-- year circle --}}
                    <span class="journey-node absolute left-1/2 top-1/2 flex h-40 w-40 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-gray-100 shadow-[0_18px_40px_-12px_rgb(0_0_0/0.35)] ring-8 ring-white">
                        <span class="journey-ring absolute inset-2 rounded-full border-2 border-dashed"></span>
                        <span class="relative flex h-28 w-28 flex-col items-center justify-center rounded-full text-white shadow-inner transition duration-500 group-hover:scale-105" style="background: var(--c)">
                            <i data-lucide="{{ $step['icon'] }}" class="h-5 w-5 opacity-80"></i>
                            <span class="font-display text-3xl font-extrabold tabular-nums">{{ $step['year'] }}</span>
                        </span>
                    </span>

                    {{-- label + text: above the arc for "up" steps, below for "down" steps --}}
                    <div class="journey-copy absolute inset-x-3 text-center {{ $up ? 'bottom-[calc(50%+8.25rem)] flex flex-col-reverse' : 'top-[calc(50%+8.25rem)]' }}">
                        <span class="mx-auto inline-block rounded-lg border-2 bg-white px-4 py-1.5 font-display text-lg font-bold shadow-sm" style="color: var(--c); border-color: var(--c)">{{ $step['tag'] }}</span>
                        <p class="{{ $up ? 'mb-3' : 'mt-3' }} text-sm leading-6 text-gray-600">{{ $step['text'] }}</p>
                    </div>

                </div>
            @endforeach

        </div>


        {{-- Phones & tablets: the same journey as a stacked list --}}
        <ol class="mt-14 space-y-5 lg:hidden">
            @foreach ($timeline as $i => $step)
                <li data-reveal style="--reveal-delay: {{ $i * 120 }}ms; --c: {{ $step['color'] }}"
                    class="relative flex gap-5 overflow-hidden rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <span class="absolute inset-y-0 left-0 w-1.5" style="background: var(--c)"></span>
                    <span class="flex h-20 w-20 shrink-0 flex-col items-center justify-center rounded-full text-white ring-4 ring-gray-100" style="background: var(--c)">
                        <i data-lucide="{{ $step['icon'] }}" class="h-4 w-4 opacity-80"></i>
                        <span class="font-display text-xl font-extrabold">{{ $step['year'] }}</span>
                    </span>
                    <span class="min-w-0">
                        <span class="block font-display text-lg font-bold" style="color: var(--c)">{{ $step['tag'] }}</span>
                        <span class="mt-1 block text-sm leading-6 text-gray-600">{{ $step['text'] }}</span>
                    </span>
                </li>
            @endforeach
        </ol>

    </div>

</section>


{{-- =========================================================
     VISION & MISSION
========================================================= --}}
<section class="relative overflow-hidden bg-gray-950 py-24 text-white">

    <div class="about-blob right-0 top-0 h-96 w-96 bg-brand-700"></div>
    <div class="about-grid absolute inset-0 opacity-60"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brand-400">What drives us</p>
            <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Our vision &amp; mission</h2>
        </div>

        <div class="mt-14 grid gap-5 lg:grid-cols-2">

                <div data-reveal style="--reveal-delay: 150ms" class="about-shine group rounded-3xl bg-gradient-to-br from-brand-600 to-brand-800 p-8 shadow-2xl shadow-brand-950/50">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 transition group-hover:scale-110">
                            <i data-lucide="eye" class="h-6 w-6"></i>
                        </span>
                        <h3 class="text-2xl font-bold">Our Vision</h3>
                    </div>
                    <p class="mt-4 leading-7 text-white/90">
                        To make India a proud home of world-class display technology, where every screen that informs,
                        teaches and entertains our people is designed and built by us, and is within everyone's reach.
                    </p>
                </div>

                <div data-reveal style="--reveal-delay: 300ms" class="about-shine group rounded-3xl border border-white/10 bg-white/5 p-8 backdrop-blur">
                    <div class="flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-600 transition group-hover:scale-110">
                            <i data-lucide="target" class="h-6 w-6"></i>
                        </span>
                        <h3 class="text-2xl font-bold">Our Mission</h3>
                    </div>
                    <ul class="mt-5 space-y-3 text-gray-300">
                        @foreach ([
                            'Manufacture smart, reliable products in India with uncompromising quality standards.',
                            'Customise every solution to the real needs of homes, schools and businesses.',
                            'Keep innovation affordable through efficient, factory-direct manufacturing.',
                            'Stand behind every product with responsive service and genuine care.',
                        ] as $point)
                            <li class="flex gap-3">
                                <i data-lucide="circle-check" class="mt-0.5 h-5 w-5 shrink-0 text-brand-400"></i>
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div data-reveal style="--reveal-delay: 450ms" class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:col-span-2">
                    @foreach (['Quality' => 'gem', 'Integrity' => 'scale', 'Innovation' => 'lightbulb', 'Care' => 'heart'] as $value => $icon)
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4 text-center transition hover:-translate-y-1 hover:bg-white/10">
                            <i data-lucide="{{ $icon }}" class="mx-auto h-6 w-6 text-brand-400"></i>
                            <p class="mt-2 text-sm font-semibold">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>

        </div>

    </div>

</section>


{{-- =========================================================
     CUSTOMISED SOLUTIONS — five pillars
========================================================= --}}
@php
    $pillars = [
        ['icon' => 'tv', 'title' => 'Innovative Products', 'text' => 'Products with unique features, customised for a wide range of applications and industries.', 'color' => '#1f2937'],
        ['icon' => 'indian-rupee', 'title' => 'Affordable Prices', 'text' => 'Innovative products at affordable prices, for a market underserved by global electronics players.', 'color' => '#a51d35'],
        ['icon' => 'globe', 'title' => 'Customised Solutions', 'text' => 'Not just hardware: systems integration for remote control and monitoring.', 'color' => '#ed1c24'],
        ['icon' => 'map-pin', 'title' => 'Make in India', 'text' => 'Strategically positioned to lead the Make in India push, serving domestic markets and exports.', 'color' => '#721524'],
        ['icon' => 'headset', 'title' => 'Service Support', 'text' => 'Installation and service support for various brands across South India: a unique proposition.', 'color' => '#4b5563'],
    ];
@endphp

<section class="relative overflow-hidden bg-white py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        {{-- Heading: title on the left, intro on the right, split by a line that draws in --}}
        <div class="pillars-head grid items-end gap-8 lg:grid-cols-[1.4fr_auto_1fr]" data-reveal>
            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Why Yara</p>
                <h2 class="mt-3 text-3xl font-bold leading-tight sm:text-5xl">
                    Customised solutions for the <span class="about-gradient-text">new era of digitisation.</span>
                </h2>
            </div>
            <span class="pillars-head-rule hidden h-24 w-px bg-gradient-to-b from-transparent via-brand-600 to-transparent lg:block"></span>
            <p class="max-w-md text-gray-600 lg:pb-1">
                Five things set every Yara product and project apart, from the idea to the installation and the service that follows.
            </p>
        </div>

        {{-- Five pillars --}}
        <div class="pillars mt-14 grid gap-x-6 gap-y-14 sm:grid-cols-2 lg:grid-cols-5" data-reveal data-no-auto-reveal>
            @foreach ($pillars as $i => $pillar)
                <div class="pillar group text-center" style="--i: {{ $i }}; --c: {{ $pillar['color'] }}">

                    <span class="pillar-bar mx-auto block h-3 w-40 rounded-full" style="background: var(--c)"></span>

                    <p class="pillar-num mt-4 font-display text-4xl font-extrabold tabular-nums" style="color: var(--c)">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</p>

                    <div class="pillar-shape relative mx-auto mt-3 flex h-52 w-44 items-start justify-center pt-12 text-white" style="background: linear-gradient(160deg, color-mix(in srgb, var(--c) 85%, #fff), var(--c))">
                        <span class="pillar-icon flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur transition duration-500 group-hover:scale-110 group-hover:bg-white group-hover:text-[var(--c)]">
                            <i data-lucide="{{ $pillar['icon'] }}" class="h-8 w-8"></i>
                        </span>
                        <span class="pillar-sheen pointer-events-none absolute inset-0"></span>
                    </div>

                    <div class="pillar-copy">
                        <h3 class="mt-6 text-lg font-bold text-gray-900">{{ $pillar['title'] }}</h3>
                        <p class="mx-auto mt-2 max-w-[15rem] text-sm leading-6 text-gray-600">{{ $pillar['text'] }}</p>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Tagline --}}
        <div class="pillars-tag relative mt-16 overflow-hidden rounded-2xl bg-gradient-to-r from-brand-50 via-white to-brand-50 px-6 py-5 text-center ring-1 ring-brand-100" data-reveal>
            <p class="font-display text-lg font-bold text-gray-900 sm:text-xl">
                Tap into the significant potential for display solutions in the
                <span class="text-brand-600">Consumer &amp; Institutional</span> market.
            </p>
            <span class="pillars-tag-line absolute inset-x-0 bottom-0 h-1 bg-gradient-to-r from-brand-700 via-brand-red to-brand-700"></span>
        </div>

    </div>

</section>


{{-- =========================================================
     LEADERSHIP
========================================================= --}}
<section class="bg-white py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Leadership</p>
            <h2 class="mt-3 text-3xl font-bold sm:text-4xl">The people <span class="text-brand-600">behind Yara.</span></h2>
            <p class="mt-4 text-gray-500">Experienced leaders combining manufacturing strength, technology and financial discipline.</p>
        </div>

        <div class="mx-auto mt-14 grid max-w-4xl gap-6 md:grid-cols-2">

            @foreach ($leaders as $i => $leader)

                <article data-reveal style="--reveal-delay: {{ $i * 150 }}ms"
                         class="about-shine group relative overflow-hidden rounded-3xl border border-gray-200 bg-white p-8 text-center transition duration-500 hover:-translate-y-2 hover:border-brand-200 hover:shadow-2xl">

                    <span class="absolute inset-x-0 top-0 h-28 bg-gradient-to-br from-gray-950 to-brand-900 transition-all duration-500 group-hover:h-32"></span>

                    <div class="relative mx-auto mt-6 h-28 w-28">
                        <span class="about-ring opacity-0 transition duration-500 group-hover:opacity-100"></span>
                        <span class="relative flex h-full w-full items-center justify-center rounded-full bg-gradient-to-br from-brand-600 to-brand-red ring-4 ring-white">
                            <span class="font-display text-3xl font-bold text-white">{{ $leader['initials'] }}</span>
                        </span>
                    </div>

                    <h3 class="relative mt-5 text-xl font-bold text-gray-900">{{ $leader['name'] }}</h3>
                    <p class="relative mt-1 text-sm font-semibold uppercase tracking-wider text-brand-600">{{ $leader['role'] }}</p>
                    <p class="relative mt-4 text-sm leading-6 text-gray-600">{{ $leader['bio'] }}</p>

                </article>

            @endforeach

        </div>

    </div>

</section>


{{-- =========================================================
     GROUP OF COMPANIES
========================================================= --}}
<section class="relative overflow-hidden bg-gray-50 py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Our companies</p>
            <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Built here. <span class="text-brand-600">Served by us.</span></h2>
            <p class="mt-4 text-gray-500">From the factory floor to your doorstep, one team takes care of every Yara product.</p>
        </div>

        <div class="relative mx-auto mt-16 grid max-w-4xl gap-6 lg:grid-cols-2">

            {{-- Connector line (desktop) --}}
            <div class="pointer-events-none absolute left-[25%] right-[25%] top-12 hidden h-0.5 overflow-hidden bg-gray-200 lg:block">
                <span class="about-marquee block h-full w-[200%] bg-[linear-gradient(90deg,transparent,var(--color-brand-red),transparent)] bg-[length:50%_100%]"></span>
            </div>

            @foreach ([
                ['name' => 'Yara Electronics', 'tag' => 'Since 2018', 'icon' => 'monitor-smartphone', 'text' => 'Brings Ceezet-built products to homes, schools and businesses, with sales, demos, installation and after-sales service.'],
                ['name' => 'Ceezet Electronics', 'tag' => 'Since 2021', 'icon' => 'factory', 'text' => 'Our manufacturing arm: builds LED TVs from 24" to 100", 55"–98" interactive panels, LED & LCD video walls, digital standees, kiosks, air conditioners, home audio and washing machines, backed by good-quality service.'],
            ] as $i => $company)

                <div data-reveal style="--reveal-delay: {{ $i * 180 }}ms"
                     class="about-shine group relative rounded-3xl bg-white p-8 text-center shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-2 hover:shadow-2xl hover:ring-brand-200">

                    <span class="relative mx-auto flex h-24 w-24 items-center justify-center rounded-3xl bg-gradient-to-br from-gray-950 to-brand-900 text-white shadow-xl transition duration-500 group-hover:rotate-6 group-hover:scale-105">
                        <i data-lucide="{{ $company['icon'] }}" class="h-10 w-10"></i>
                    </span>

                    <span class="mt-6 inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold text-brand-700">{{ $company['tag'] }}</span>
                    <h3 class="mt-3 text-xl font-bold text-gray-900">{{ $company['name'] }}</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">{{ $company['text'] }}</p>

                </div>

            @endforeach

        </div>

    </div>

</section>


{{-- =========================================================
     FACTORY — CEEZET ELECTRONICS
========================================================= --}}
<section id="factory" class="relative scroll-mt-24 overflow-hidden bg-gray-950 py-24 text-white" x-data="{ playing: false }">

    <div class="about-blob -left-20 bottom-10 h-80 w-80 bg-brand-600"></div>

    <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">

        <div data-reveal>

            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brand-400">Our Factory</p>

            <h2 class="mt-3 text-3xl font-bold sm:text-5xl">
                Built at <span class="about-gradient-text">Ceezet Electronics.</span>
            </h2>

            <p class="mt-6 leading-7 text-gray-300">
                Every Yara product is made at Ceezet Electronics, our own manufacturing facility in Coimbatore,
                Tamil Nadu. With a modern production line, pioneering equipment and trained teams, we control
                quality from the first component to the final packed box.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                @foreach ([
                    ['icon' => 'layout-grid', 'title' => 'Video walls & signage', 'text' => 'LED & LCD video walls, standees and kiosks.'],
                    ['icon' => 'monitor', 'title' => '24" to 100" TVs', 'text' => 'The full range of sizes, in-house.'],
                    ['icon' => 'presentation', 'title' => '55" to 98" panels', 'text' => 'Interactive flat panels for education & business.'],
                    ['icon' => 'washing-machine', 'title' => 'Washing machines', 'text' => 'Fully & semi-automatic assembly.'],
                    ['icon' => 'microscope', 'title' => 'Multi-stage QC', 'text' => 'Inspection and testing at every stage.'],
                    ['icon' => 'settings-2', 'title' => 'Built to order', 'text' => 'Custom specs, branding and software.'],
                ] as $i => $item)
                    <div data-reveal style="--reveal-delay: {{ 100 + $i * 90 }}ms" class="flex gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 transition hover:border-brand-400/40 hover:bg-white/10">
                        <i data-lucide="{{ $item['icon'] }}" class="mt-0.5 h-5 w-5 shrink-0 text-brand-400"></i>
                        <span>
                            <span class="block font-semibold">{{ $item['title'] }}</span>
                            <span class="block text-sm text-gray-400">{{ $item['text'] }}</span>
                        </span>
                    </div>
                @endforeach
            </div>

        </div>


        {{-- Factory video (loads only when played) --}}
        <div data-reveal style="--reveal-delay: 200ms" class="relative">

            <div class="absolute -inset-3 rounded-[2rem] bg-gradient-to-br from-brand-600/60 to-brand-red/20 blur-2xl"></div>

            <div class="relative aspect-video overflow-hidden rounded-3xl bg-black shadow-2xl ring-1 ring-white/10">

                <template x-if="playing">
                    <iframe
                        class="h-full w-full"
                        src="https://www.youtube.com/embed/nzUHAuEdKzo?autoplay=1&rel=0"
                        title="Yara Electronics Factory Tour"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen
                    ></iframe>
                </template>

                <button x-show="! playing" type="button" @click="playing = true" class="group absolute inset-0 h-full w-full" aria-label="Play factory tour video">
                    <img src="https://i.ytimg.com/vi/nzUHAuEdKzo/hqdefault.jpg" alt="Ceezet Electronics factory tour" loading="lazy" class="h-full w-full object-cover opacity-80 transition duration-700 group-hover:scale-105 group-hover:opacity-100">
                    <span class="absolute inset-0 bg-gradient-to-t from-gray-950/80 to-transparent"></span>
                    <span class="absolute left-1/2 top-1/2 flex h-20 w-20 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-brand-600 text-white shadow-2xl transition group-hover:scale-110">
                        <span class="about-pulse absolute inset-0 rounded-full"></span>
                        <i data-lucide="play" class="ml-1 h-8 w-8 fill-current"></i>
                    </span>
                    <span class="absolute bottom-5 left-5 text-left">
                        <span class="block text-lg font-bold">Factory Tour</span>
                        <span class="block text-sm text-gray-300">Behind the scenes at Ceezet Electronics</span>
                    </span>
                </button>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     CUSTOMISABLE PRODUCTS
========================================================= --}}
<section class="bg-white py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid gap-12 lg:grid-cols-3">

            <div class="lg:sticky lg:top-28 lg:self-start" data-reveal>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Made for You</p>
                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Good products, <span class="text-brand-600">customised</span> to your needs.</h2>
                <p class="mt-5 leading-7 text-gray-600">
                    Because we build our own products, we can shape them around you, whether that's one TV for your
                    home or a thousand interactive panels for a state-wide education project.
                </p>
                <a href="{{ route('store.contact') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-gray-950 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                    Discuss your requirement
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:col-span-2">
                @foreach ($customisation as $i => $item)
                    <div data-reveal style="--reveal-delay: {{ ($i % 2) * 120 }}ms"
                         class="about-shine group rounded-3xl border border-gray-200 p-7 transition duration-300 hover:-translate-y-1 hover:border-transparent hover:bg-gradient-to-br hover:from-gray-950 hover:to-brand-900 hover:text-white hover:shadow-2xl">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition group-hover:bg-white/15 group-hover:text-white">
                            <i data-lucide="{{ $item['icon'] }}" class="h-6 w-6"></i>
                        </span>
                        <h3 class="mt-5 text-lg font-bold">{{ $item['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-gray-600 transition group-hover:text-gray-300">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>

        </div>


        {{-- Product range from live categories --}}
        @if ($categories->isNotEmpty())

            <div class="mt-24">

                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end" data-reveal>
                    <h3 class="text-2xl font-bold sm:text-3xl">Our product range</h3>
                    <a href="{{ route('store.catalogue') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:underline">
                        Download catalogue
                        <i data-lucide="download" class="h-4 w-4"></i>
                    </a>
                </div>

                <div class="mt-8 grid gap-5 sm:grid-cols-2 {{ match (true) { $categories->count() >= 5 => 'lg:grid-cols-5', $categories->count() === 4 => 'lg:grid-cols-4', default => 'lg:grid-cols-3' } }}">
                    @foreach ($categories as $i => $category)
                        <a href="{{ route('store.category', $category) }}" data-reveal style="--reveal-delay: {{ $i * 100 }}ms"
                           class="group block overflow-hidden rounded-3xl bg-gray-950 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                            {{-- 4:3 like the category art, name underneath so nothing covers the product --}}
                            <span class="block aspect-[4/3] overflow-hidden">
                                @if ($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                                @endif
                            </span>
                            <span class="flex items-center justify-between gap-2 px-5 py-4 text-white">
                                <span class="text-base font-bold">{{ $category->name }}</span>
                                <span class="inline-flex items-center gap-1.5 text-sm text-white/70 transition group-hover:gap-3 group-hover:text-white">
                                    Explore <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </span>
                            </span>
                        </a>
                    @endforeach
                </div>

            </div>

        @endif

    </div>

</section>


{{-- =========================================================
     SMART PRODUCTS & CUSTOMER SATISFACTION
========================================================= --}}
<section class="relative overflow-hidden bg-gray-50 py-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Why Yara</p>
            <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Smart products. <span class="text-brand-600">Happy customers.</span></h2>
            <p class="mt-4 text-gray-500">We measure success by how well our products serve you, long after the day they arrive.</p>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($promises as $i => $item)
                <div data-reveal style="--reveal-delay: {{ ($i % 3) * 120 }}ms"
                     class="group relative overflow-hidden rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl">
                    <span class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-brand-50 transition-all duration-500 group-hover:scale-[6] group-hover:bg-brand-50/70"></span>
                    <span class="relative flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red text-white shadow-lg shadow-brand-600/30 transition group-hover:-rotate-6">
                        <i data-lucide="{{ $item['icon'] }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="relative mt-5 text-lg font-bold text-gray-900">{{ $item['title'] }}</h3>
                    <p class="relative mt-2 text-sm leading-6 text-gray-600">{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     CERTIFICATIONS
========================================================= --}}
<section class="bg-white py-24" x-data="{ zoom: false }">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Certifications</p>
            <h2 class="mt-3 text-3xl font-bold sm:text-4xl">Quality you can <span class="text-brand-600">verify.</span></h2>
            <p class="mt-4 leading-7 text-gray-600">
                Quality, safety and compliance aren't checkboxes for us. They're built into how we design,
                manufacture and deliver every product, across Smart TVs, ACs, washing machines and commercial displays.
            </p>
        </div>

        {{-- logo wall: every mark in its own tile, tap to enlarge --}}
        <div class="mx-auto mt-14 grid max-w-6xl grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($certifications as $i => $cert)
                <button type="button" @click="{{ $cert['logo'] ? 'zoom = ' . $i : '' }}" data-reveal style="--reveal-delay: {{ ($i % 4) * 90 }}ms"
                        class="about-shine group flex flex-col items-center rounded-2xl border border-gray-200 bg-white p-5 text-center transition duration-300 hover:-translate-y-1 hover:border-brand-200 hover:shadow-xl {{ $cert['logo'] ? 'cursor-zoom-in' : 'cursor-default' }}">
                    <span class="flex h-24 w-full items-center justify-center">
                        @if ($cert['logo'])
                            <img src="{{ $cert['logo'] }}" alt="{{ $cert['name'] }} mark" loading="lazy"
                                 class="max-h-full max-w-[85%] object-contain transition duration-500 group-hover:scale-105">
                        @else
                            <span class="flex h-20 w-20 items-center justify-center rounded-full border-2 border-dashed border-brand-200 transition duration-700 group-hover:rotate-[360deg] group-hover:border-brand-600">
                                <span class="flex h-16 w-16 flex-col items-center justify-center rounded-full bg-gradient-to-br from-gray-950 to-brand-800 text-white">
                                    <i data-lucide="{{ $cert['icon'] }}" class="h-5 w-5"></i>
                                    <span class="mt-0.5 font-display text-[9px] font-bold leading-tight">{{ $cert['code'] }}</span>
                                </span>
                            </span>
                        @endif
                    </span>
                    <span class="mt-4 text-sm font-bold text-gray-900">{{ $cert['name'] }}</span>
                    <span class="mt-1 text-xs leading-5 text-gray-500">{{ $cert['text'] }}</span>
                </button>
            @endforeach
        </div>

        {{-- Make in India --}}
        <div class="relative mx-auto mt-14 grid max-w-6xl items-center gap-8 overflow-hidden rounded-3xl bg-gradient-to-r from-[#fff7ed] via-white to-[#ecfdf5] p-8 ring-1 ring-gray-200 sm:p-10 lg:grid-cols-[1.1fr_1fr]" data-reveal>
            <span class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-[#ff9933] via-white to-[#138808]"></span>
            <img src="{{ $mark('make-in-india.png') }}" alt="Make in India" loading="lazy" class="mx-auto w-full max-w-md mix-blend-multiply">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-[#e07b00]">Proudly</p>
                <h3 class="mt-2 text-3xl font-bold sm:text-4xl">Made in <span class="text-[#138808]">India.</span></h3>
                <p class="mt-4 leading-7 text-gray-600">Designed and manufactured at our own factory in Coimbatore, Tamil Nadu, under the Make in India initiative, with local engineering, local service and local jobs.</p>
            </div>
        </div>

    </div>

    {{-- All certificates live on their own page, with downloads --}}
    <div class="mx-auto mt-14 max-w-6xl px-4 sm:px-6 lg:px-8" data-reveal>
        <a href="{{ route('store.certifications') }}"
           class="group flex flex-col items-center justify-between gap-6 overflow-hidden rounded-[2rem] bg-gray-950 p-8 text-white sm:flex-row sm:p-10">
            <span class="flex items-center gap-5">
                <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-brand-600 transition duration-500 group-hover:rotate-6">
                    <i data-lucide="file-badge" class="h-8 w-8"></i>
                </span>
                <span>
                    <span class="block text-2xl font-bold">View &amp; download our certificates</span>
                    <span class="mt-1 block text-gray-400">BIS, ISO, BEE, RoHS, incorporation and more, all in one place.</span>
                </span>
            </span>
            <span class="inline-flex shrink-0 items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition group-hover:bg-brand-600 group-hover:text-white">
                Certifications
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </span>
        </a>
    </div>

    {{-- Lightbox: the tapped mark --}}
    <div x-show="zoom !== false" x-cloak x-transition.opacity @click="zoom = false" @keydown.escape.window="zoom = false"
         class="fixed inset-0 z-[70] flex items-center justify-center bg-gray-950/90 p-4 backdrop-blur-sm">
        @foreach ($certifications as $i => $cert)
            @if ($cert['logo'])
                <figure x-show="zoom === {{ $i }}" class="w-full max-w-lg rounded-3xl bg-white p-8 text-center shadow-2xl sm:p-12">
                    <img src="{{ $cert['logo'] }}" alt="{{ $cert['name'] }} mark" class="mx-auto max-h-[50vh] w-auto max-w-full object-contain">
                    <figcaption class="mt-6 font-bold text-gray-900">{{ $cert['name'] }}</figcaption>
                    <p class="mt-1 text-sm text-gray-500">{{ $cert['text'] }}</p>
                </figure>
            @endif
        @endforeach
        <button type="button" class="absolute right-5 top-5 rounded-full bg-white/10 p-2 text-white hover:bg-white/20" aria-label="Close">
            <i data-lucide="x" class="h-6 w-6"></i>
        </button>
    </div>

</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="bg-white pb-24">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div data-reveal class="relative overflow-hidden rounded-[2rem] bg-gray-950 px-6 py-16 text-center text-white sm:px-16">

            <div class="about-grid absolute inset-0"></div>
            <div class="about-blob -right-10 -top-10 h-72 w-72 bg-brand-600"></div>
            <div class="about-blob -bottom-16 -left-10 h-72 w-72 bg-brand-red/50 [animation-delay:-7s]"></div>

            <div class="relative">
                <h2 class="text-3xl font-bold sm:text-5xl">Let's build your <span class="about-gradient-text">display solution.</span></h2>
                <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300">
                    Tell us about your home, classroom or business. We'll recommend, customise and deliver the right product.
                </p>
                <div class="mt-10 flex flex-wrap justify-center gap-4">
                    <a href="{{ route('store.demo.create') }}" class="about-shine inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/40 transition hover:bg-brand-500">
                        Book a Free Demo
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                    <a href="{{ route('store.contact') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                        <i data-lucide="map-pin" class="h-4 w-4"></i>
                        Visit our showroom
                    </a>
                </div>
            </div>

        </div>

    </div>

</section>

@endsection


@push('scripts')
<script>
    // Stat counters count up when they scroll into view.
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('[data-about-count]');

        if (!counters.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        counters.forEach((el) => (el.textContent = '0'));

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                const el = entry.target;
                const target = parseInt(el.dataset.aboutCount, 10);
                const start = performance.now();

                const tick = (now) => {
                    const progress = Math.min((now - start) / 1800, 1);
                    const eased = 1 - Math.pow(1 - progress, 4);
                    el.textContent = Math.round(target * eased).toLocaleString('en-IN');
                    if (progress < 1) requestAnimationFrame(tick);
                };

                requestAnimationFrame(tick);
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach((el) => observer.observe(el));
    });
</script>
@endpush
