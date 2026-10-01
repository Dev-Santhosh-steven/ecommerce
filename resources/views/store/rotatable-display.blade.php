@extends('layouts.store')

@section('title', 'Yara 27" Rotatable Display | Portable Rotating Screen on Wheels with Battery')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $img = fn ($file) => asset("storage/products/rotatable-display/{$file}");
    $logo = asset('storage/products/centum/yara-logo-light.png');
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the 27" Rotatable Display. Please share details and pricing.');
    $specs = \App\Support\SpecSheet::visible($product->specifications);


    $inside = [
        ['shield-check', 'Google EDLA', 'Certified system'],
        ['cpu', 'Octa-core', 'Processor'],
        ['memory-stick', '6GB + 128GB', 'Memory & storage'],
        ['camera', '16MP', 'Built-in camera'],
        ['volume-2', '2 × 5W', 'Bass stereo speakers'],
        ['wifi', '2.4G / 5G', 'Dual-band Wi-Fi'],
    ];

    $uses = [
        ['building-2', 'Offices', 'Presentations in one room, video calls in the next.'],
        ['laptop', 'Home offices', 'Video calls on the 16MP camera, then roll it away.'],
        ['graduation-cap', 'Online classes', 'Portrait for notes, landscape for lessons.'],
        ['store', 'Retail & showrooms', 'A movable screen for offers and product videos.'],
        ['hotel', 'Hotels & suites', 'Entertainment that moves to the guest.'],
        ['heart-pulse', 'Hospitals & care', 'Bring video calls and information to the patient.'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#09090c] text-white">

{{-- =========================================================
     HERO — the screen turns between landscape and portrait
========================================================= --}}
<section class="relative isolate overflow-hidden"
         x-data="{ p: false, tilt: 0, t: null, init() { this.t = setInterval(() => this.p = ! this.p, 3600) } }">

    <div class="about-grid absolute inset-0 -z-10 opacity-30"></div>
    <div class="absolute right-[-6%] top-[6%] -z-10 h-[40rem] w-[40rem] rounded-full bg-brand-800/45 blur-[130px]"></div>
    <div class="absolute inset-x-0 bottom-0 -z-10 h-40 bg-gradient-to-t from-black/70 to-transparent"></div>

    <div class="mx-auto grid max-w-[1500px] items-center gap-10 px-4 pt-14 sm:px-6 lg:grid-cols-[1.05fr_1fr] lg:px-10 lg:pt-0">

        <div class="about-intro py-6 lg:py-28">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-black/30 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-200 backdrop-blur">
                <img src="{{ $logo }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Rotatable Display
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-7xl">
                Turn it. Tilt it.<br><span class="about-gradient-text">Take it anywhere.</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg text-gray-300 sm:text-xl">
                A 27" Full HD screen on a wheeled stand. Rotate it from landscape to portrait, tilt it 20° and roll it wherever it's needed on its own battery.
            </p>
            <div class="mt-9 flex flex-wrap gap-4">
                <a href="#rotate" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                    Try the rotation
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-black/20 px-7 py-4 text-sm font-semibold backdrop-blur transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <div class="mt-10 flex flex-wrap gap-3">
                @foreach (['27" Full HD', 'Rotates 90°', 'Tilts 20°', '16MP camera', 'On wheels', '9600 mAh', 'Price on request'] as $pill)
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">{{ $pill }}</span>
                @endforeach
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-[19rem] pb-8 pt-10 sm:max-w-[20rem]" data-no-auto-reveal>
            {{-- rotation arrows --}}
            <svg viewBox="0 0 100 100" class="pointer-events-none absolute right-[-4%] top-[3%] z-10 w-[16%] text-white/80" aria-hidden="true">
                <path class="rd-arrow" d="M20 70 A35 35 0 0 1 75 30" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
                <path class="rd-arrow" d="M62 18 L80 30 L64 44" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg viewBox="0 0 100 100" class="pointer-events-none absolute left-[-4%] top-[32%] z-10 w-[16%] rotate-180 text-white/80" aria-hidden="true">
                <path class="rd-arrow" d="M20 70 A35 35 0 0 1 75 30" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
                <path class="rd-arrow" d="M62 18 L80 30 L64 44" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <div class="absolute inset-x-[18%] bottom-8 h-10 rounded-[50%] bg-black/70 blur-xl"></div>
            @include('store.partials.rd-unit', ['rotate' => true, 'camera' => true])

            <p class="mt-2 text-center text-xs font-semibold uppercase tracking-[0.3em] text-gray-400">
                <span x-text="p ? 'Portrait' : 'Landscape'">Landscape</span>
            </p>
        </div>

    </div>
</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#09090c]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara 27" Rotatable Display</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Rotates 90° · Tilts 20° · 16MP camera · On wheels · 9600 mAh · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#rotate" class="transition hover:text-white">Rotate</a>
            <a href="#camera" class="transition hover:text-white">Camera</a>
            <a href="#roll" class="transition hover:text-white">Move</a>
            <a href="#inside" class="transition hover:text-white">Inside</a>
            <a href="#size" class="transition hover:text-white">Size</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     ROTATE & TILT — interactive
========================================================= --}}
<section id="rotate" class="relative scroll-mt-32 overflow-hidden bg-[#f5f3f0] py-24 text-gray-900" x-data="{ p: false, tilt: 0 }">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Rotate &amp; tilt</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Landscape for movies. <span class="text-brand-600">Portrait for everything else.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Turn the screen 90° either way and tilt it 20° forward or back. Try it.</p>
        </div>

        <div class="mt-14 grid items-center gap-12 lg:grid-cols-[1fr_1fr]">

            <div class="relative mx-auto w-full max-w-[22rem]" data-no-auto-reveal>
                <div class="absolute inset-x-[18%] bottom-1 h-8 rounded-[50%] bg-black/25 blur-xl"></div>
                @include('store.partials.rd-unit', ['rotate' => true, 'portrait' => 'screen-horses.jpg'])
            </div>

            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-3">
                    @foreach ([[false, 'rectangle-horizontal', 'Landscape', 'Films, sport and video calls'], [true, 'rectangle-vertical', 'Portrait', 'Reels, recipes, reading and notes']] as [$isP, $icon, $label, $hint])
                        <button type="button" @click="p = {{ $isP ? 'true' : 'false' }}"
                                class="rounded-2xl p-5 text-left transition"
                                :class="p === {{ $isP ? 'true' : 'false' }} ? 'bg-white shadow-lg ring-1 ring-brand-200' : 'bg-white/50 hover:bg-white'">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl transition" :class="p === {{ $isP ? 'true' : 'false' }} ? 'bg-brand-600 text-white' : 'bg-gray-200/70 text-gray-600'">
                                <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                            </span>
                            <span class="mt-3 block text-lg font-bold">{{ $label }}</span>
                            <span class="mt-1 block text-sm text-gray-600">{{ $hint }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-2 font-bold"><i data-lucide="move-vertical" class="h-5 w-5 text-brand-600"></i> Tilt</span>
                        <span class="font-display text-lg font-extrabold tabular-nums" x-text="(tilt > 0 ? '+' : '') + tilt + '°'">0°</span>
                    </div>
                    <input type="range" min="-20" max="20" step="1" x-model.number="tilt" class="mt-4 w-full accent-[#a51d35]" aria-label="Tilt">
                    <div class="mt-1 flex justify-between text-xs text-gray-400"><span>20° back</span><span>20° front</span></div>
                </div>

                <div class="grid grid-cols-3 gap-px overflow-hidden rounded-2xl bg-gray-200 text-center">
                    @foreach ([['90°', 'Clockwise'], ['90°', 'Anticlockwise'], ['20°', 'Tilt front & back']] as [$v, $l])
                        <div class="bg-white p-4">
                            <p class="font-display text-2xl font-extrabold text-brand-600">{{ $v }}</p>
                            <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $l }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
     CAMERA — 16MP camera on top of the screen
========================================================= --}}
<section id="camera" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-grid absolute inset-0 opacity-30"></div>
    <div class="about-blob -right-24 top-10 h-96 w-96 bg-brand-800/50"></div>

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">16MP camera</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Video calls, <span class="about-gradient-text">built right in.</span></h2>
            <p class="mt-5 max-w-lg text-lg text-gray-300">A 16MP camera sits on top of the screen, so the display becomes a video-call screen wherever you roll it. Tilt it 20° to frame yourself perfectly.</p>
            <div class="mt-8 grid max-w-lg gap-3">
                @foreach ([['video', 'Video calls with clients', 'Big-screen calls from any room, without booking a meeting room.'], ['graduation-cap', 'Online classes', 'Teachers and classmates on 27", notes in portrait.'], ['briefcase', 'Work meetings', 'Join from your desk, then roll the screen to the next room.']] as [$icon, $title, $text])
                    <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-red"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                        <span>
                            <span class="block font-bold">{{ $title }}</span>
                            <span class="mt-0.5 block text-sm text-gray-400">{{ $text }}</span>
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- close-up on the top of the screen, camera highlighted --}}
        <div class="relative mx-auto aspect-[4/3] w-full max-w-xl overflow-hidden rounded-[2rem] border border-white/10 bg-gradient-to-b from-[#17161d] to-[#0c0b10]" data-no-auto-reveal>
            <div class="absolute left-1/2 top-[-24%] w-[150%] -translate-x-1/2" x-data="{ p: false, tilt: 0 }">
                @include('store.partials.rd-unit', ['rotate' => true, 'camera' => true, 'casters' => false])
            </div>
            <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-[#0c0b10] to-transparent"></div>
            <div class="absolute bottom-5 left-5 right-5 flex flex-wrap gap-2">
                @foreach (['16MP', 'Video calls', 'Classes', 'Meetings'] as $pill)
                    <span class="rounded-full border border-white/15 bg-black/40 px-3 py-1 text-xs font-semibold text-gray-200 backdrop-blur">{{ $pill }}</span>
                @endforeach
            </div>
        </div>

    </div>
</section>


{{-- =========================================================
     ROLL — scroll to roll the stand from space to space; it turns to portrait on the way
     (scroll-driven like the Centum picture scene: the page script sets the CSS variables)
========================================================= --}}
<section id="roll" class="rd-scrub relative h-[340vh] scroll-mt-32" style="--pos: 0; --turn: 0; --swap: 0; --z1: 1; --z2: 0; --z3: 0; --spin: 0deg">

    <div class="sticky top-0 flex h-screen flex-col overflow-hidden px-4 pb-4 pt-[8.25rem] sm:px-6 lg:px-10">
        <div class="about-blob -left-24 top-24 h-96 w-96 bg-brand-800/50"></div>

        <div class="relative mx-auto w-full max-w-[1500px] text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">On wheels</p>
            <h2 class="mt-1 text-3xl font-bold sm:text-5xl [@media(max-height:760px)]:text-3xl">Your screen <span class="about-gradient-text">follows you.</span></h2>
            <p class="mx-auto mt-2 hidden max-w-2xl text-gray-300 sm:block [@media(max-height:760px)]:hidden">Scroll to roll it from the meeting room to the showroom to reception, turning to portrait on the way.</p>
        </div>

        {{-- the stage --}}
        <div class="relative mx-auto mt-4 min-h-0 w-full max-w-[1500px] flex-1 overflow-hidden rounded-[2rem] border border-white/10 bg-gradient-to-b from-[#15141b] to-[#0c0b10]" data-no-auto-reveal>

            {{-- back wall rooms --}}
            <div class="absolute inset-x-0 top-0 grid h-[62%] grid-cols-3 divide-x divide-white/5">
                @foreach ([['presentation', 'Meeting room', 'Landscape for presentations'], ['store', 'Showroom', 'Turns to portrait for product promos'], ['concierge-bell', 'Reception', 'Portrait welcome signage']] as $k => [$icon, $room, $what])
                    <div class="relative flex flex-col items-center justify-start pt-3 text-center sm:pt-4">
                        <div class="absolute inset-0 bg-[radial-gradient(closest-side,rgba(229,9,20,0.25),transparent)]" style="opacity: var(--z{{ $k + 1 }})"></div>
                        <span class="relative flex h-8 w-8 items-center justify-center rounded-xl border border-white/10 bg-white/5"><i data-lucide="{{ $icon }}" class="h-4 w-4 text-brand-300"></i></span>
                        <p class="relative mt-1 font-display text-sm font-bold sm:text-base">{{ $room }}</p>
                        <p class="relative hidden text-xs text-gray-400 sm:block">{{ $what }}</p>
                    </div>
                @endforeach
            </div>

            {{-- floor --}}
            <div class="absolute inset-x-0 bottom-0 h-[38%] border-t border-white/10 bg-[linear-gradient(to_bottom,#1b1a22,#0e0d12)]">
                <div class="absolute inset-0 opacity-30 [background:repeating-linear-gradient(90deg,transparent_0_80px,rgba(255,255,255,.06)_80px_81px)]"></div>
            </div>
            {{-- the track, lit up as far as the stand has rolled --}}
            <div class="absolute bottom-[13%] left-[14%] right-[14%] h-px bg-white/10"></div>
            <div class="absolute bottom-[13%] left-[14%] h-px w-[72%] origin-left bg-gradient-to-r from-brand-700 to-brand-400 shadow-[0_0_12px_rgba(229,9,20,0.8)]" style="transform: scaleX(var(--pos))"></div>

            {{-- the moving display --}}
            <div class="rd-move absolute bottom-[7%] h-[66%] -translate-x-1/2 [aspect-ratio:800/1440]">
                <div class="absolute inset-x-[12%] -bottom-2 h-5 rounded-[50%] bg-black/80 blur-md"></div>
                <div class="rd-lean">
                    @include('store.partials.rd-unit', ['scrub' => true])
                </div>
            </div>

            {{-- orientation read-out --}}
            <div class="absolute right-4 top-4 hidden rounded-full border border-white/10 bg-black/40 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.25em] backdrop-blur sm:block">
                <span class="relative inline-grid">
                    <span class="col-start-1 row-start-1" style="opacity: calc(1 - var(--swap))">Landscape</span>
                    <span class="col-start-1 row-start-1 text-brand-300" style="opacity: var(--swap)">Portrait</span>
                </span>
            </div>
        </div>
    </div>

</section>

<section class="relative pb-24">
    <div class="mx-auto grid max-w-[1500px] gap-5 px-4 sm:grid-cols-3 sm:px-6 lg:px-10" data-reveal>
        @foreach ([['move', 'Wheeled base', 'Glides across floors with a gentle push.'], ['battery-charging', '9600 mAh battery', 'Watch, call and browse without a cable.'], ['plug-zap', 'Type-C charging', '12V / 2.5A: charge it like your laptop.']] as [$icon, $title, $text])
            <div class="flex items-start gap-4 rounded-3xl border border-white/10 bg-white/[0.04] p-6">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
                <span>
                    <span class="block font-bold">{{ $title }}</span>
                    <span class="mt-1 block text-sm text-gray-400">{{ $text }}</span>
                </span>
            </div>
        @endforeach
    </div>
</section>


{{-- =========================================================
     INSIDE
========================================================= --}}
<section id="inside" class="scroll-mt-32 bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Inside</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">A smart screen, <span class="text-brand-600">not just a monitor.</span></h2>
        </div>
        <div class="mt-14 grid grid-cols-2 gap-5 lg:grid-cols-6">
            @foreach ($inside as [$icon, $value, $label])
                <div class="rounded-3xl bg-white p-6 text-center shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-brand-200">
                    <i data-lucide="{{ $icon }}" class="mx-auto h-7 w-7 text-brand-600"></i>
                    <p class="mt-4 font-display text-xl font-extrabold">{{ $value }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $label }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($product->features as $feature)
                <div class="group rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-brand-200">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red text-white shadow-lg shadow-brand-600/30 transition group-hover:-rotate-6">
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
     SIZE — dimensions on the product
========================================================= --}}
<section id="size" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-grid absolute inset-0 opacity-30"></div>
    <div class="relative mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Dimensions</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Slim where it counts, <span class="about-gradient-text">steady at the base.</span></h2>
            <p class="mt-5 max-w-lg text-lg text-gray-300">A 16 mm thin screen on a 400 mm round base, standing a little over 1.16 m tall.</p>
            <div class="mt-8 grid max-w-lg grid-cols-2 gap-px overflow-hidden rounded-3xl bg-white/10">
                @foreach ([['625 mm', 'Screen width'], ['363.5 mm', 'Screen height'], ['16 mm', 'Screen depth'], ['1162.8 mm', 'Overall height'], ['400 mm', 'Base diameter'], ['27"', 'Screen size']] as [$v, $l])
                    <div class="bg-[#111015] p-5">
                        <p class="font-display text-2xl font-extrabold">{{ $v }}</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-gray-500">{{ $l }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-[24rem]" data-no-auto-reveal>
            <img src="{{ $img('rd-landscape.png') }}" alt="Yara 27 inch Rotatable Display with dimensions" class="w-full" loading="lazy">
            {{-- width --}}
            <div class="absolute left-[4.4%] right-[7.8%] top-[8.5%] flex items-center">
                <span class="h-3 w-px bg-brand-400"></span><span class="h-px flex-1 bg-brand-400"></span><span class="h-3 w-px bg-brand-400"></span>
            </div>
            <span class="absolute left-1/2 top-[4.6%] -translate-x-1/2 rounded-full bg-brand-600 px-2.5 py-0.5 text-xs font-bold">625 mm</span>
            {{-- overall height --}}
            <div class="absolute bottom-[1.4%] right-[-2%] top-[12.2%] flex flex-col items-center">
                <span class="h-px w-3 bg-brand-400"></span><span class="w-px flex-1 bg-brand-400"></span><span class="h-px w-3 bg-brand-400"></span>
            </div>
            <span class="absolute right-[-7%] top-[55%] -translate-y-1/2 rotate-90 whitespace-nowrap rounded-full bg-brand-600 px-2.5 py-0.5 text-xs font-bold">1162.8 mm</span>
            {{-- base --}}
            <div class="absolute bottom-[-2.5%] left-[28.8%] right-[28.8%] flex items-center">
                <span class="h-3 w-px bg-brand-400"></span><span class="h-px flex-1 bg-brand-400"></span><span class="h-3 w-px bg-brand-400"></span>
            </div>
            <span class="absolute bottom-[-7%] left-1/2 -translate-x-1/2 rounded-full bg-brand-600 px-2.5 py-0.5 text-xs font-bold">Ø 400 mm</span>
        </div>

    </div>
</section>


{{-- =========================================================
     WHERE TO USE
========================================================= --}}
<section class="bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">At home, <span class="text-brand-600">and well beyond it.</span></h2>
            </div>
            <p class="max-w-md text-gray-600">A screen that comes to the people, instead of people going to the screen.</p>
        </div>
        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($uses as [$icon, $title, $text])
                <div class="group flex items-start gap-5 rounded-3xl bg-[#f6f6f7] p-7 ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:bg-white hover:shadow-xl hover:ring-brand-200">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gray-900 text-white transition group-hover:bg-brand-600">
                        <i data-lucide="{{ $icon }}" class="h-6 w-6"></i>
                    </span>
                    <span>
                        <span class="block text-lg font-bold">{{ $title }}</span>
                        <span class="mt-1 block text-sm leading-6 text-gray-600">{{ $text }}</span>
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     SPECS
========================================================= --}}
<section id="specs" class="scroll-mt-32 bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Specifications</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">{{ $product->name }}</h2>
            <p class="mt-4 text-gray-500">Available in one size: 27". Price on request.</p>
        </div>
        <dl class="mt-12 grid gap-x-12 sm:grid-cols-2" data-reveal>
            @foreach ($specs as $key => $value)
                <div class="flex items-baseline justify-between gap-6 border-b border-gray-200 py-4">
                    <dt class="text-sm text-gray-500">{{ $key }}</dt>
                    <dd class="text-right font-semibold">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
        <div class="mt-10 text-center">
            <a href="{{ route('store.product', $product) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:underline">
                View product page
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative overflow-hidden py-28 text-center">
    <div class="about-grid absolute inset-0 opacity-60"></div>
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-brand-700"></div>
    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <img src="{{ $logo }}" alt="Yara" class="mx-auto h-10 w-auto">
        <h2 class="mt-8 text-4xl font-bold sm:text-6xl">One screen. <span class="about-gradient-text">Every room.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Talk to us about the Yara Rotatable Display for your home, office or business.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                Book a demo
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</section>

</div>

@endsection

@push('scripts')
<script>
    // "On wheels" scene: scroll progress through the tall section drives the roll, the turn to portrait,
    // the content swap, the room highlights and the wheel spin (CSS variables read by the .rd-* rules).
    (() => {
        const scene = document.querySelector('.rd-scrub');
        if (! scene || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const clamp = (v, a = 0, b = 1) => Math.min(b, Math.max(a, v));
        const smooth = (a, b, v) => { const t = clamp((v - a) / (b - a)); return t * t * (3 - 2 * t); };
        let last = null, settle, queued = false;

        const update = () => {
            queued = false;
            const rect = scene.getBoundingClientRect();
            const p = clamp(-rect.top / (rect.height - window.innerHeight));
            const pos = smooth(0.04, 0.96, p);
            const vars = {
                '--pos': pos,
                '--turn': smooth(0.28, 0.72, pos),
                '--swap': smooth(0.42, 0.58, pos),
                '--z1': 1 - smooth(0.22, 0.38, pos),
                '--z2': smooth(0.3, 0.45, pos) * (1 - smooth(0.62, 0.78, pos)),
                '--z3': smooth(0.72, 0.88, pos),
            };
            Object.entries(vars).forEach(([k, v]) => scene.style.setProperty(k, v.toFixed(4)));
            scene.style.setProperty('--spin', `${(pos * 1440).toFixed(1)}deg`);

            // lean against the direction of travel while moving, then settle upright
            if (last !== null && pos !== last) {
                scene.style.setProperty('--lean', `${clamp((last - pos) * 260, -2.2, 2.2).toFixed(2)}deg`);
                clearTimeout(settle);
                settle = setTimeout(() => scene.style.setProperty('--lean', '0deg'), 140);
            }
            last = pos;
        };

        window.addEventListener('scroll', () => { if (! queued) { queued = true; requestAnimationFrame(update); } }, { passive: true });
        update();
    })();
</script>
@endpush
