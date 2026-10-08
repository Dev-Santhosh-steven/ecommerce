@extends('layouts.store')

@section('title', 'Yara Chillers | Chiller-Based AC for Commercial Spaces')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in a chiller-based AC system for my building. Please arrange a site survey.');
    $poster = fn ($name) => asset("storage/products/chillers/poster-{$name}.jpg");

    $spaces = [
        ['img' => $poster('mall-quick-chill'), 'place' => 'Shopping Malls', 'line' => 'Quick Chill. Built Tough.'],
        ['img' => $poster('office-smart-cooling'), 'place' => 'Corporate Offices', 'line' => 'Smart Cooling. Steady Temperature.'],
        ['img' => $poster('rotunda-energy-saver'), 'place' => 'Atriums & Lobbies', 'line' => 'Future Cooling. Energy Saver.'],
        ['img' => $poster('workspace-less-power'), 'place' => 'Workspaces', 'line' => '50% Less Power. 100% Cooling Power.'],
    ];

    // Hotspots on the studio shot (percent of the 16:9 image).
    $hotspots = [
        ['x' => 51, 'y' => 12, 'title' => 'Ceiling cassette unit', 'text' => '4-way air flow spreads cool air evenly without using floor space.'],
        ['x' => 31, 'y' => 63, 'title' => 'Dual condenser fans', 'text' => 'Air-cooled condenser rejects heat efficiently, even on hot days.'],
        ['x' => 56, 'y' => 50, 'title' => 'Compressors', 'text' => 'The heart of the chiller: built for continuous commercial duty.'],
        ['x' => 58, 'y' => 70, 'title' => 'Smart control panel', 'text' => 'Keeps temperature steady and the system running at its best.'],
        ['x' => 47, 'y' => 82, 'title' => 'Heat exchangers', 'text' => 'Produce the chilled water that feeds every cassette in the building.'],
        ['x' => 72, 'y' => 80, 'title' => 'Pumps & piping', 'text' => 'Circulate chilled water to each floor and back again.'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0a0b0e] text-white">

{{-- =========================================================
     HERO — the chiller with cool air streaming over it
========================================================= --}}
<section class="relative overflow-hidden pb-10 pt-14 sm:pt-20">

    <div class="about-grid absolute inset-0 opacity-50"></div>
    <div class="about-blob -left-32 top-24 h-[30rem] w-[30rem] bg-sky-700/60"></div>
    <div class="about-blob -right-24 top-10 h-[24rem] w-[24rem] bg-brand-700/70 [animation-delay:-6s]"></div>

    {{-- Frost particles --}}
    @foreach (range(1, 18) as $n)
        <span class="chill-flake" style="left: {{ ($n * 53) % 100 }}%; top: {{ 40 + ($n * 29) % 55 }}%; width: {{ 4 + $n % 5 * 2 }}px; height: {{ 4 + $n % 5 * 2 }}px; --dx: {{ ($n % 2 ? 1 : -1) * (20 + $n * 3) }}px; animation-duration: {{ 7 + $n % 6 }}s; animation-delay: -{{ $n * 0.7 }}s"></span>
    @endforeach

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="about-intro text-center">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Commercial Cooling
            </p>
            <h1 class="mt-5 text-5xl font-bold sm:text-7xl">
                Yara <span class="chill-gradient-text">Chillers</span>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-gray-300 sm:text-xl">
                50% Less Energy. 100% Cooling Performance. Centralised chiller cooling for every large building.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-2">
                @foreach ([['hospital', 'Hospitals'], ['school', 'Schools'], ['graduation-cap', 'Colleges'], ['store', 'Retail Stores'], ['shopping-bag', 'Malls']] as [$icon, $place])
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-xs font-semibold text-gray-200 backdrop-blur">
                        <i data-lucide="{{ $icon }}" class="h-4 w-4 text-sky-300"></i>{{ $place }}
                    </span>
                @endforeach
            </div>
        </div>

        {{-- Stage --}}
        <div class="relative mx-auto mt-6 max-w-5xl">

            <p class="pointer-events-none absolute left-1/2 top-0 -translate-x-1/2 select-none font-display text-[20vw] font-extrabold leading-none text-transparent [-webkit-text-stroke:1.5px_rgb(255_255_255/0.08)] lg:text-[15rem]" aria-hidden="true">COOL</p>

            <div class="absolute inset-x-[10%] bottom-[18%] top-[20%] rounded-full bg-sky-500/25 blur-[90px]"></div>

            {{-- Air streams --}}
            <svg class="chill-air pointer-events-none absolute inset-x-0 -top-4 z-10 h-[70%] w-full" viewBox="0 0 1000 420" preserveAspectRatio="none" aria-hidden="true">
                <defs>
                    <linearGradient id="chillAir" x1="0" x2="1">
                        <stop offset="0" stop-color="#7dd3fc" stop-opacity="0"/>
                        <stop offset="0.5" stop-color="#bae6fd" stop-opacity="0.95"/>
                        <stop offset="1" stop-color="#7dd3fc" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <path d="M120 360 C 260 250, 380 330, 520 220 S 800 160, 960 60" stroke="url(#chillAir)" stroke-width="3"/>
                <path d="M60 300 C 220 220, 360 280, 500 170 S 780 110, 940 20" stroke="url(#chillAir)" stroke-width="2"/>
                <path d="M200 400 C 320 300, 460 360, 600 250 S 860 200, 1000 120" stroke="url(#chillAir)" stroke-width="2.5"/>
                <path d="M900 380 C 760 270, 640 330, 500 230 S 220 170, 40 80" stroke="url(#chillAir)" stroke-width="2"/>
                <path d="M960 320 C 820 230, 700 290, 560 190 S 300 120, 100 30" stroke="url(#chillAir)" stroke-width="3"/>
                <path d="M820 410 C 700 320, 560 370, 430 270 S 180 220, 0 150" stroke="url(#chillAir)" stroke-width="1.5"/>
            </svg>

            <img src="{{ asset('storage/products/chillers/chiller-cutout.png') }}" alt="Yara chiller-based AC plant"
                 class="centum-hero-tv relative z-0 mx-auto mt-[12%] w-[92%] drop-shadow-[0_40px_50px_rgba(0,0,0,0.8)]">

            <img src="{{ asset('storage/products/chillers/chiller-cutout.png') }}" alt="" aria-hidden="true"
                 class="chill-reflection relative mx-auto -mt-1 w-[92%]">

            <div class="absolute inset-x-[15%] bottom-[22%] h-8 rounded-full bg-brand-600/40 blur-2xl"></div>

        </div>

        <div class="mt-2 flex flex-wrap justify-center gap-4" data-reveal>
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire now
            </a>
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                <i data-lucide="clipboard-check" class="h-4 w-4"></i>
                Free site survey
            </a>
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0a0b0e]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Chillers</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Chiller Cooling Systems · 2 TR to 500 TR · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#how" class="transition hover:text-white">How it works</a>
            <a href="#compare" class="transition hover:text-white">Why chillers</a>
            <a href="#range" class="transition hover:text-white">Product line</a>
            <a href="#distribution" class="transition hover:text-white">Air distribution</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     BIG NUMBERS
========================================================= --}}
<section class="py-24">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="grid grid-cols-2 gap-px overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 lg:grid-cols-4">
            @foreach ([
                ['value' => 50, 'suffix' => '%', 'label' => 'Less energy*', 'count' => true],
                ['value' => 100, 'suffix' => '%', 'label' => 'Cooling performance', 'count' => true],
                ['value' => 500, 'suffix' => ' TR', 'label' => 'Capacity, from 2 TR', 'count' => true],
                ['value' => 7, 'suffix' => '°C', 'label' => 'Chilled water', 'count' => true],
            ] as $i => $stat)
                <div class="group bg-[#0d0f13] p-8 text-center transition duration-500 hover:bg-[#12161c] sm:p-12" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <p class="font-display text-6xl font-extrabold tabular-nums sm:text-7xl">
                        <span class="bg-gradient-to-b from-white to-sky-300 bg-clip-text text-transparent" @if ($stat['count']) data-chill-count="{{ $stat['value'] }}" @endif>{{ $stat['value'] }}</span><span class="text-brand-500">{{ $stat['suffix'] }}</span>
                    </p>
                    <p class="mt-3 text-sm font-medium uppercase tracking-[0.2em] text-gray-400 transition group-hover:text-gray-200">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
        <p class="mt-4 text-center text-xs text-gray-500">*Up to 40–50% lower energy use than conventional split ACs. Actual savings depend on the building, usage and system design.</p>
    </div>
</section>


{{-- =========================================================
     HOW IT WORKS — animated chilled-water loop
========================================================= --}}
<section id="how" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="about-blob right-0 top-10 h-96 w-96 bg-sky-800/60"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">How it works</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">One plant. <span class="chill-gradient-text">Every room cool.</span></h2>
            <p class="mt-5 text-lg text-gray-300">Instead of multiple individual air conditioners, a Yara chiller produces chilled water that is circulated through Air Handling Units (AHUs) or Fan Coil Units (FCUs) to cool the whole building evenly.</p>
        </div>

        @php
            $loopNodes = [
                'chiller' => ['icon' => 'factory', 'title' => 'Yara Chiller', 'text' => 'Removes the heat and chills the water'],
                'cassette' => ['icon' => 'wind', 'title' => 'AHUs & FCUs', 'text' => 'Cool the air and spread it evenly'],
            ];
        @endphp

        {{-- Desktop: one closed loop. Chilled water flows out along the top pipe, warm water returns along the bottom. --}}
        <div class="relative mx-auto mt-16 hidden aspect-[1100/340] max-w-6xl md:block" data-reveal="zoom">

            <svg viewBox="0 0 1100 340" class="absolute inset-0 h-full w-full" aria-hidden="true">
                <defs>
                    <filter id="chill-glow" x="-200%" y="-200%" width="500%" height="500%"><feGaussianBlur stdDeviation="4" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
                </defs>

                {{-- Supply: chiller -> cassettes --}}
                <path id="chill-supply" d="M 214 118 H 886" stroke="#0c4a6e" stroke-width="16" fill="none" stroke-linecap="round"/>
                <path class="chill-flow" d="M 214 118 H 886" stroke="#38bdf8" stroke-width="5" fill="none" stroke-linecap="round"/>
                {{-- Return: cassettes -> chiller (drawn right to left, so the dashes run that way) --}}
                <path id="chill-return" d="M 886 222 H 214" stroke="#4c0519" stroke-width="16" fill="none" stroke-linecap="round"/>
                <path class="chill-flow" d="M 886 222 H 214" stroke="#f43f5e" stroke-width="5" fill="none" stroke-linecap="round"/>

                {{-- Water droplets travelling with the flow --}}
                @foreach ([0, 1.4, 2.8] as $delay)
                    <circle r="6" fill="#e0f2fe" filter="url(#chill-glow)" class="chill-drop">
                        <animateMotion dur="4.2s" begin="-{{ $delay }}s" repeatCount="indefinite"><mpath href="#chill-supply"/></animateMotion>
                    </circle>
                    <circle r="6" fill="#ffe4e6" filter="url(#chill-glow)" class="chill-drop">
                        <animateMotion dur="4.2s" begin="-{{ $delay }}s" repeatCount="indefinite"><mpath href="#chill-return"/></animateMotion>
                    </circle>
                @endforeach

                <text x="550" y="94" text-anchor="middle" fill="#7dd3fc" font-size="15" font-weight="600" font-family="inherit">Chilled water out · 7 °C →</text>
                <text x="550" y="258" text-anchor="middle" fill="#fda4af" font-size="15" font-weight="600" font-family="inherit">← Warm water back to be cooled again</text>
            </svg>

            {{-- The loop itself, in the gap between the pipes --}}
            <span class="absolute left-1/2 top-1/2 inline-flex -translate-x-1/2 -translate-y-1/2 items-center gap-2 rounded-full border border-white/10 bg-[#0d1117] px-4 py-2 text-xs font-semibold text-gray-300">
                <i data-lucide="droplets" class="h-4 w-4 text-sky-300"></i>
                Insulated pipes across the building
            </span>

            {{-- The pipes run into the two ends --}}
            @foreach ($loopNodes as $side => $node)
                <div class="absolute top-1/2 flex w-[19.5%] -translate-y-1/2 flex-col items-center rounded-3xl border border-white/10 bg-[#0d1117] px-4 py-6 text-center shadow-[0_0_50px_rgba(56,189,248,0.15)] {{ $side === 'chiller' ? 'left-0' : 'right-0' }}">
                    <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-400/10 text-sky-300 ring-1 ring-sky-300/20">
                        <i data-lucide="{{ $node['icon'] }}" class="h-8 w-8"></i>
                    </span>
                    <p class="mt-4 font-display text-lg font-bold">{{ $node['title'] }}</p>
                    <p class="mt-1 text-sm text-gray-400">{{ $node['text'] }}</p>
                </div>
            @endforeach

        </div>

        {{-- Phones: the same loop, top to bottom --}}
        <div class="mx-auto mt-12 max-w-sm md:hidden" data-reveal>
            @foreach ($loopNodes as $side => $node)
                <div class="flex items-center gap-4 rounded-3xl border border-white/10 bg-[#0d1117] p-5">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-sky-400/10 text-sky-300 ring-1 ring-sky-300/20">
                        <i data-lucide="{{ $node['icon'] }}" class="h-7 w-7"></i>
                    </span>
                    <span>
                        <span class="block font-display text-lg font-bold">{{ $node['title'] }}</span>
                        <span class="block text-sm text-gray-400">{{ $node['text'] }}</span>
                    </span>
                </div>
                @if ($side === 'chiller')
                    <div class="flex items-stretch justify-center gap-6 py-2">
                        <svg viewBox="0 0 120 130" class="h-32 w-28" aria-hidden="true">
                            <path d="M 38 0 V 130" stroke="#0c4a6e" stroke-width="12" stroke-linecap="round"/>
                            <path class="chill-flow" d="M 38 0 V 130" stroke="#38bdf8" stroke-width="4" stroke-linecap="round"/>
                            <path d="M 82 130 V 0" stroke="#4c0519" stroke-width="12" stroke-linecap="round"/>
                            <path class="chill-flow" d="M 82 130 V 0" stroke="#f43f5e" stroke-width="4" stroke-linecap="round"/>
                        </svg>
                        <span class="flex flex-col justify-center gap-3 text-xs font-semibold">
                            <span class="text-sky-300">↓ Chilled water out · 7 °C</span>
                            <span class="text-rose-300">↑ Warm water back to be cooled again</span>
                            <span class="text-gray-400">Insulated pipes across the building</span>
                        </span>
                    </div>
                @endif
            @endforeach
        </div>


        {{-- The cycle in four steps --}}
        <ol class="mx-auto mt-14 grid max-w-6xl gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
            @foreach ([
                ['The chiller', 'removes heat from water using a refrigeration cycle.'],
                ['The chilled water', 'is pumped through insulated pipes across the building.'],
                ['AHUs or FCUs', 'use the chilled water to cool the air and distribute it evenly.'],
                ['Warm water', 'returns to the chiller to be cooled again.'],
            ] as $n => [$lead, $rest])
                <li class="rounded-3xl border border-white/10 bg-white/[0.03] p-6">
                    <span class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-600 font-display text-sm font-bold">{{ $n + 1 }}</span>
                    <p class="mt-4 text-sm leading-6 text-gray-300"><span class="font-semibold text-white">{{ $lead }}</span> {{ $rest }}</p>
                </li>
            @endforeach
        </ol>
        <p class="mx-auto mt-8 max-w-2xl text-center text-gray-400">This centralised approach ensures stable temperature control, higher efficiency and better reliability for large facilities.</p>

    </div>

</section>


{{-- =========================================================
     INSIDE — hotspots on the branded studio shot
========================================================= --}}
<section id="inside" class="scroll-mt-32 bg-white py-24 text-gray-900">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Engineered inside & out</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Built tough. <span class="text-brand-600">Built smart.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Hover or tap the points to explore the system.</p>
        </div>

        <div class="relative mx-auto mt-12 max-w-6xl overflow-hidden rounded-[2rem] shadow-2xl ring-1 ring-gray-200" data-reveal="zoom" x-data="{ open: null }">

            <img src="{{ asset('storage/products/chillers/chiller-studio.jpg') }}" alt="Yara chiller plant with ceiling cassette unit" loading="lazy" class="w-full">

            @foreach ($hotspots as $h => $spot)
                <div class="chill-hotspot absolute" style="left: {{ $spot['x'] }}%; top: {{ $spot['y'] }}%"
                     @mouseenter="open = {{ $h }}" @mouseleave="open = null">
                    <button type="button" @click="open = open === {{ $h }} ? null : {{ $h }}"
                            class="dot relative flex h-7 w-7 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-brand-600 text-white ring-4 ring-white/80"
                            aria-label="{{ $spot['title'] }}">
                        <i data-lucide="plus" class="h-4 w-4 transition" :class="open === {{ $h }} ? 'rotate-45' : ''"></i>
                    </button>
                    <div x-show="open === {{ $h }}" x-cloak x-transition.opacity.scale.origin.top
                         class="absolute left-1/2 top-5 z-10 w-56 -translate-x-1/2 rounded-2xl bg-gray-950/95 p-4 text-white shadow-2xl backdrop-blur">
                        <p class="font-bold">{{ $spot['title'] }}</p>
                        <p class="mt-1 text-xs leading-5 text-gray-300">{{ $spot['text'] }}</p>
                    </div>
                </div>
            @endforeach

        </div>

    </div>

</section>


{{-- =========================================================
     SPACES — marketing posters
========================================================= --}}
<section id="spaces" class="relative scroll-mt-32 overflow-hidden py-24">

    <div class="about-blob -left-24 top-1/3 h-96 w-96 bg-brand-800/70"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">Commercial-ready</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Built for every <span class="chill-gradient-text">big space.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Fast cooling performance powered by Yara technology, engineered for busy commercial environments.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($spaces as $i => $space)
                <figure class="group relative overflow-hidden rounded-[1.75rem] bg-black ring-1 ring-white/10" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <img src="{{ $space['img'] }}" alt="{{ $space['line'] }} Yara chillers in {{ strtolower($space['place']) }}" loading="lazy"
                         class="aspect-[4/5] w-full object-cover transition duration-[1200ms] ease-[cubic-bezier(0.16,1,0.3,1)] group-hover:scale-105">
                    <figcaption class="absolute inset-x-0 bottom-0 translate-y-full bg-gradient-to-t from-black/90 to-black/0 p-5 pt-12 transition duration-500 group-hover:translate-y-0">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-300">{{ $space['place'] }}</p>
                        <p class="mt-1 font-display text-lg font-bold">{{ $space['line'] }}</p>
                    </figcaption>
                </figure>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     FEATURES
========================================================= --}}
<section class="bg-[#f4f6f8] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Why choose Yara chillers</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Efficient. Reliable. <span class="text-brand-600">Modular.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Engineered for efficient, reliable and scalable cooling in schools, hospitals, malls, retail outlets and large facilities, with consistent performance and long-term reliability.</p>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($product->features as $feature)
                <div class="about-shine group rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-sky-200">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 to-sky-700 text-white shadow-lg shadow-sky-600/30 transition duration-500 group-hover:rotate-6">
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
     WHY CHILLERS — comparison
========================================================= --}}
<section id="compare" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Why chillers</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Better than conventional ACs.</h2>
            <p class="mt-4 text-gray-500">Built for efficiency, reliability and longevity.</p>
        </div>

        <div class="mt-12 overflow-hidden rounded-3xl ring-1 ring-gray-200" data-reveal>
            <div class="grid grid-cols-[0.8fr_1fr_1fr] bg-gray-950 text-sm font-semibold text-white">
                <div class="p-4 sm:p-5"></div>
                <div class="p-4 text-center text-gray-400 sm:p-5">Conventional split AC</div>
                <div class="bg-brand-600 p-4 text-center sm:p-5">Yara chiller cooling system</div>
            </div>
            @foreach ([
                ['Units', 'Multiple AC units required', 'Single centralised cooling plant'],
                ['Energy', 'Higher electricity consumption', 'Up to 40–50% lower energy usage'],
                ['Maintenance', 'Difficult across many units', 'Centralised maintenance'],
                ['Cooling', 'Uneven in large spaces', 'Uniform temperature distribution'],
                ['Duty', 'Shorter lifespan under heavy load', 'Designed for continuous operation'],
                ['Noise', 'High noise levels', 'Quieter indoor operation'],
                ['Leaks', 'Complex leakage diagnosis', 'Easy leak detection: water is circulated'],
            ] as $row)
                <div class="grid grid-cols-[0.8fr_1fr_1fr] border-t border-gray-100 text-sm">
                    <div class="p-4 font-semibold sm:p-5">{{ $row[0] }}</div>
                    <div class="p-4 text-center text-gray-500 sm:p-5">{{ $row[1] }}</div>
                    <div class="flex items-center justify-center gap-2 bg-brand-50/60 p-4 text-center font-semibold text-gray-900 sm:p-5">
                        <i data-lucide="circle-check" class="hidden h-4 w-4 shrink-0 text-brand-600 sm:block"></i>
                        {{ $row[2] }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>


{{-- =========================================================
     PRODUCT LINE — ECGC, ECHC and ECAS series (Yara Chiller Catalogue)
========================================================= --}}
@php
    $chillerImg = fn ($name) => asset("storage/products/chillers/{$name}.jpg");
    $ecgc = [
        // capacity, compressors, tank, max power
        ['12.5 TR', '44 kW', '1 or 2', '750 L', '12'],
        ['15 TR', '53 kW', '1 or 2', '750 L', '14.5'],
        ['20 TR', '70 kW', '1 or 2', '1250 L', '22'],
        ['25 TR', '88 kW', '1 or 2', '1250 L', '24.5'],
        ['30 TR', '105 kW', '2', '1250 L', '32'],
        ['45 TR', '158 kW', '2', '1250 L', '42'],
    ];
@endphp
<section id="range" class="scroll-mt-32 bg-[#f4f6f8] py-24 text-gray-900">
    <div class="mx-auto max-w-[1300px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Product line</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">From 2 TR <span class="text-brand-600">to 500 TR.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Three series, air-cooled or water-cooled, for air conditioning and process cooling.</p>
        </div>

        {{-- ECGC --}}
        <article class="mt-14 overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-gray-200" data-reveal>
            <div class="grid items-center gap-8 p-6 sm:p-10 lg:grid-cols-[1fr_1.1fr]">
                <div>
                    <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-sky-700">ECGC Series</span>
                    <h3 class="mt-4 text-3xl font-bold">General chillers, 12.5 TR to 45 TR</h3>
                    <p class="mt-4 leading-7 text-gray-600">Small to medium capacity chillers used across industries for process cooling down to 7 °C, and for air-conditioning applications.</p>
                    <div class="mt-6 flex flex-wrap gap-2 text-xs font-semibold text-gray-700">
                        @foreach (['Scroll compressor', 'BTHE heat exchanger', 'Air-cooled condenser', 'DTC / PLC controls', 'R407C refrigerant', '7 °C nominal', 'Adjustable −7 °C to 20 °C'] as $chip)
                            <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5">{{ $chip }}</span>
                        @endforeach
                    </div>
                </div>
                <img src="{{ $chillerImg('series-ecgc') }}" alt="Yara ECGC series chillers" loading="lazy" class="w-full rounded-2xl">
            </div>

            <div class="overflow-x-auto border-t border-gray-100">
                <table class="w-full min-w-[720px] text-sm">
                    <thead>
                        <tr class="bg-gray-950 text-white">
                            <th class="p-4 text-left font-semibold">Nominal cooling capacity</th>
                            @foreach ($ecgc as [$tr, $kw])
                                <th class="p-4 text-center font-semibold">{{ $tr }}<span class="block text-xs font-medium text-gray-400">{{ $kw }}</span></th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([2 => 'No. of compressors', 3 => 'Tank capacity', 4 => 'Power max (kW)*'] as $col => $label)
                            <tr class="border-t border-gray-100 {{ $loop->even ? 'bg-gray-50/70' : '' }}">
                                <th class="p-4 text-left font-medium text-gray-500">{{ $label }}</th>
                                @foreach ($ecgc as $row)
                                    <td class="p-4 text-center font-semibold">{{ $row[$col] }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="border-t border-gray-100">
                            <th class="p-4 text-left font-medium text-gray-500">All models</th>
                            <td colspan="6" class="p-4 text-center text-gray-700">Scroll compressor · BTHE · Air-cooled · DTC / PLC · R407C · 7 °C nominal, adjustable −7 °C to 20 °C · Pump to suit the process</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <p class="px-6 pb-6 pt-3 text-xs text-gray-500 sm:px-10">*Power may vary with the number of compressors, pump capacity and agitators. DTC = digital temperature controller; BTHE = brazed plate heat exchanger.</p>
        </article>

        {{-- ECHC and ECAS --}}
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            @foreach ([
                ['img' => 'series-echc-ac', 'tag' => 'ECHC-AC · ECAS-AC', 'title' => 'Air-cooled, 2 TR to 200 TR', 'range' => '2 TR (7 kW) → 40 TR (140 kW) → 200 TR (700 kW)', 'text' => 'Higher-capacity air-cooled chillers that need no cooling tower, for buildings and plants of every size.'],
                ['img' => 'series-echc-wc', 'tag' => 'ECHC-WC · ECAS-WC', 'title' => 'Water-cooled, up to 500 TR', 'range' => '10 TR (35 kW) → 40 TR (140 kW) → 500 TR (1750 kW)', 'text' => 'Water-cooled chillers for the largest loads, from 10 TR all the way to 500 TR (1750 kW).'],
            ] as $series)
                <article class="flex flex-col overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-gray-200" data-reveal>
                    <img src="{{ $chillerImg($series['img']) }}" alt="Yara {{ $series['tag'] }} series chillers" loading="lazy" class="aspect-[4/1] w-full object-cover">
                    <div class="flex flex-1 flex-col p-6 sm:p-8">
                        <span class="self-start rounded-full bg-sky-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-sky-700">{{ $series['tag'] }}</span>
                        <h3 class="mt-4 text-2xl font-bold">{{ $series['title'] }}</h3>
                        <p class="mt-3 leading-7 text-gray-600">{{ $series['text'] }}</p>
                        <p class="mt-auto pt-5 text-sm font-semibold text-sky-700">{{ $series['range'] }}</p>
                    </div>
                </article>
            @endforeach
        </div>

        <article class="mt-6 grid gap-6 rounded-[2rem] bg-gray-950 p-6 text-white sm:p-10 lg:grid-cols-[auto_1fr] lg:items-center" data-reveal>
            <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-sky-400/10 text-sky-300 ring-1 ring-sky-300/20">
                <i data-lucide="drafting-compass" class="h-8 w-8"></i>
            </span>
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-300">ECAS Series · Application-specific</span>
                <h3 class="mt-2 text-2xl font-bold">Custom-made chillers, −50 °C to +20 °C</h3>
                <p class="mt-3 leading-7 text-gray-300">Built for a specific application in ranges such as 11, 32, 43 and 54 TR: chemical chillers and water chillers (11 °C to 20 °C), from 2 TR (7 kW) up to 500 TR (1750 kW), air-cooled or water-cooled.</p>
            </div>
        </article>

    </div>
</section>


{{-- =========================================================
     AIR DISTRIBUTION — AHUs and FCUs (Yara Chiller Catalogue)
========================================================= --}}
<section id="distribution" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1300px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Air distribution</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Flexible cooling <span class="text-brand-600">for every space.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Chiller systems deliver cooling through Air Handling Units (AHUs) or Fan Coil Units (FCUs), depending on the building layout and cooling requirement.</p>
        </div>

        {{-- AHU --}}
        <article class="mt-14 grid overflow-hidden rounded-[2rem] bg-[#f4f6f8] ring-1 ring-gray-200 lg:grid-cols-2" data-reveal>
            <div class="p-6 sm:p-10">
                <span class="inline-flex rounded-full bg-brand-600 px-3 py-1 text-xs font-bold uppercase tracking-wider text-white">Air Handling Units (AHU)</span>
                <h3 class="mt-4 text-3xl font-bold">Ideal for large halls</h3>
                <ul class="mt-6 space-y-3 text-gray-700">
                    @foreach ([
                        'Custom-engineered air distribution for centralised cooling in large spaces',
                        'Suited to large halls, auditoriums, malls, hospitals and institutional buildings',
                        'High airflow capacity for centralised cooling',
                        'Works seamlessly with the chiller through chilled-water coils',
                        'Energy-efficient cooling for large-scale applications',
                    ] as $point)
                        <li class="flex gap-3"><i data-lucide="circle-check" class="mt-0.5 h-5 w-5 shrink-0 text-brand-600"></i>{{ $point }}</li>
                    @endforeach
                </ul>
                <p class="mt-6 inline-flex rounded-full bg-white px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-gray-200">Custom made for each site</p>
            </div>
            <img src="{{ $chillerImg('ahu') }}" alt="Air handling unit fed by a Yara chiller" loading="lazy" class="h-full min-h-64 w-full object-cover">
        </article>

        {{-- FCUs --}}
        <div class="mt-14 text-center" data-reveal>
            <h3 class="text-2xl font-bold sm:text-3xl">Fan Coil Units (FCU)</h3>
            <p class="mx-auto mt-3 max-w-2xl text-gray-600">Localised cooling with chilled water from the chiller: compact, efficient and suited to individual rooms or smaller zones.</p>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach ([
                ['img' => 'fcu-split', 'title' => 'Split type indoor FCU', 'points' => ['Installed inside rooms', 'Ideal for classrooms, hospital rooms and offices'], 'cap' => 'Up to 2 TR per unit'],
                ['img' => 'fcu-cassette', 'title' => 'Cassette type FCU', 'points' => ['Ceiling-mounted design', 'Uniform air distribution'], 'cap' => 'Up to 4 TR per unit'],
                ['img' => 'fcu-horizontal', 'title' => 'Horizontal cassette FCU', 'points' => ['Lower installation cost', 'One-way air flow, suited to small offices'], 'cap' => 'Up to 4 TR per unit'],
            ] as $n => $fcu)
                <article class="flex flex-col overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200" data-reveal style="--reveal-delay: {{ $n * 110 }}ms">
                    <img src="{{ $chillerImg($fcu['img']) }}" alt="{{ $fcu['title'] }}" loading="lazy" class="aspect-[2/1] w-full object-cover">
                    <div class="flex flex-1 flex-col p-6">
                        <h4 class="text-lg font-bold"><span class="mr-2 text-brand-600">{{ $n + 1 }}</span>{{ $fcu['title'] }}</h4>
                        <ul class="mt-3 space-y-2 text-sm text-gray-600">
                            @foreach ($fcu['points'] as $point)
                                <li class="flex gap-2"><i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-brand-600"></i>{{ $point }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-auto pt-5"><span class="inline-flex rounded-full bg-brand-50 px-3 py-1.5 text-sm font-bold text-brand-700">Capacity: {{ $fcu['cap'] }}</span></p>
                    </div>
                </article>
            @endforeach
        </div>

    </div>
</section>


{{-- =========================================================
     SPECS
========================================================= --}}
<section id="specs" class="scroll-mt-32 bg-[#f4f6f8] py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">System overview</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">{{ $product->name }}</h2>
            <p class="mt-3 text-gray-500">Every system is designed for your site. Ask our team for detailed capacity and technical data.</p>
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

    <div class="about-grid absolute inset-0 opacity-50"></div>
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-sky-700/60"></div>

    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Cool your building <span class="chill-gradient-text">the smarter way.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Book a free site survey. We'll size, design and install the right chiller system for your space.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                Book a site survey
            </a>
        </div>
    </div>

</section>

</div>

@endsection


@push('scripts')
<script>
    // Count-up numbers.
    document.addEventListener('DOMContentLoaded', function () {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseInt(el.dataset.chillCount, 10);
                const start = performance.now();
                const tick = (now) => {
                    const t = Math.min((now - start) / 1600, 1);
                    el.textContent = Math.round(target * (1 - Math.pow(1 - t, 4)));
                    if (t < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
                observer.unobserve(el);
            });
        }, { threshold: 0.6 });

        document.querySelectorAll('[data-chill-count]').forEach((el) => { el.textContent = '0'; observer.observe(el); });
    });
</script>
@endpush
