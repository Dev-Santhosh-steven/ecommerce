@extends('layouts.store')

@section('title', 'Yara 8" Industrial Display | Android Touch Panel with Industrial I/O')

@push('styles')
    <meta name="description" content="{{ $product->meta_description }}">
@endpush

@php
    $base = fn ($file) => asset("storage/products/industrial-displays/{$file}");
    $logo = asset('storage/products/centum/yara-logo-light.png');
    $whatsapp = 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode('Hi Yara, I am interested in the 8" Industrial Display. Please share details and pricing.');
    $specs = \App\Support\SpecSheet::visible($product->specifications);

    // Hotspots on ind-rear.png (percent of the image), measured from the drawing.
    $ports = [
        ['x' => 12.8, 'y' => 36.6, 'icon' => 'plug', 'title' => 'DC 12V power in', 'text' => 'Runs on a 12V, 2A supply. The adapter is in the box.'],
        ['x' => 19.1, 'y' => 37.5, 'icon' => 'monitor', 'title' => 'HDMI out', 'text' => 'Mirror the screen to a bigger display on the wall or in a control room.'],
        ['x' => 24.8, 'y' => 38.6, 'icon' => 'headphones', 'title' => 'Earphone out', 'text' => 'Audio alerts and voice prompts through a speaker or headset.'],
        ['x' => 32.8, 'y' => 36.1, 'icon' => 'usb', 'title' => 'USB × 2', 'text' => 'Barcode scanners, keyboards, printers and USB drives.'],
        ['x' => 43.4, 'y' => 36.6, 'icon' => 'network', 'title' => 'LAN (RJ45)', 'text' => 'A wired network connection for steady, reliable data.'],
        ['x' => 54.1, 'y' => 36.1, 'icon' => 'usb', 'title' => 'USB × 2 (blue)', 'text' => 'Two more USB ports, for four in total.'],
        ['x' => 73.1, 'y' => 37.5, 'icon' => 'plug-zap', 'title' => '4 × Phoenix connectors', 'text' => 'Green screw terminals to wire sensors, relays and machine signals straight in.'],
    ];

    $uses = [
        ['factory', 'Factory automation', 'Operator screens on production lines and machines.'],
        ['gauge', 'Machine control (HMI)', 'Start, stop and monitor equipment from a touch panel.'],
        ['warehouse', 'Warehouses & logistics', 'Scan, track and confirm right at the rack or dock.'],
        ['door-open', 'Access & attendance', 'Wall-mounted entry, check-in and attendance points.'],
        ['building-2', 'Smart buildings', 'Room, lighting and energy control panels.'],
        ['stethoscope', 'Labs & clinics', 'Equipment status and data entry in tight spaces.'],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#0b0c10] text-white">

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative isolate overflow-hidden">

    <div class="about-grid absolute inset-0 -z-10 opacity-40"></div>
    <div class="absolute right-[-8%] top-[8%] -z-10 h-[36rem] w-[36rem] rounded-full bg-brand-800/45 blur-[120px]"></div>

    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 py-14 sm:px-6 lg:grid-cols-[1fr_1.15fr] lg:px-10 lg:py-24">

        <div class="about-intro">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-black/30 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-200 backdrop-blur">
                <img src="{{ $logo }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Industrial Displays
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-7xl">
                Built for<br><span class="about-gradient-text">the shop floor.</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg text-gray-300 sm:text-xl">
                An 8" Android touch display in a frameless metal body, with the USB, LAN and Phoenix connectors your machines need.
            </p>
            <div class="mt-9 flex flex-wrap gap-4">
                <a href="#io" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                    Explore the ports
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-black/20 px-7 py-4 text-sm font-semibold backdrop-blur transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <div class="mt-10 flex flex-wrap gap-3">
                @foreach (['8" Touch', 'Android 11', 'Metal body', 'Phoenix I/O', '12V DC', 'Price on request'] as $pill)
                    <span class="rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm text-gray-200">{{ $pill }}</span>
                @endforeach
            </div>
        </div>

        <div class="relative" data-no-auto-reveal>
            <div class="absolute inset-x-[12%] bottom-[-4%] h-12 rounded-[50%] bg-black/60 blur-2xl"></div>
            <img src="{{ $base('ind-front.png') }}" alt="Yara 8 inch Industrial Display" class="centum-hero-tv relative w-full drop-shadow-[0_40px_50px_rgba(0,0,0,0.6)]">
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#0b0c10]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara 8" Industrial Display</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">Android 11 · Touch · Metal body · Industrial I/O · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#io" class="transition hover:text-white">Ports</a>
            <a href="#features" class="transition hover:text-white">Features</a>
            <a href="#uses" class="transition hover:text-white">Where to use</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     I/O TOUR — tap a port
========================================================= --}}
<section id="io" class="relative scroll-mt-32 overflow-hidden bg-[#f5f3f0] py-24 text-gray-900" x-data="{ s: 6 }">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Industrial I/O</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Everything plugs in <span class="text-brand-600">at the back.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Tap a port to see what it's for.</p>
        </div>

        <div class="mt-14 grid items-center gap-12 lg:grid-cols-[1.4fr_1fr]">

            <div class="relative" data-no-auto-reveal>
                <img src="{{ $base('ind-rear.png') }}" alt="Yara Industrial Display rear I/O panel" class="w-full" loading="lazy">
                @foreach ($ports as $k => $p)
                    <button type="button" @click="s = {{ $k }}" class="absolute -translate-x-1/2 -translate-y-1/2" style="left: {{ $p['x'] }}%; top: {{ $p['y'] }}%;" aria-label="{{ $p['title'] }}">
                        <span class="absolute left-1/2 top-1/2 h-9 w-9 -translate-x-1/2 -translate-y-1/2 rounded-full bg-brand-500/40 pd-pulse"></span>
                        <span class="relative block h-5 w-5 rounded-full border-[3px] border-white shadow-lg transition" :class="s === {{ $k }} ? 'bg-brand-600 scale-125' : 'bg-gray-900/70'"></span>
                    </button>
                @endforeach
            </div>

            <div class="space-y-2">
                @foreach ($ports as $k => $p)
                    <button type="button" @click="s = {{ $k }}" class="flex w-full items-start gap-4 rounded-2xl p-4 text-left transition"
                            :class="s === {{ $k }} ? 'bg-white shadow-lg ring-1 ring-brand-200' : 'hover:bg-white/70'">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition" :class="s === {{ $k }} ? 'bg-brand-600 text-white' : 'bg-gray-200/70 text-gray-600'">
                            <i data-lucide="{{ $p['icon'] }}" class="h-5 w-5"></i>
                        </span>
                        <span>
                            <span class="block font-bold">{{ $p['title'] }}</span>
                            <span class="mt-1 block text-sm leading-6 text-gray-600" x-show="s === {{ $k }}" @if ($k !== 6) x-cloak @endif>{{ $p['text'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>

        </div>
    </div>
</section>


{{-- =========================================================
     FEATURES
========================================================= --}}
<section id="features" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-grid absolute inset-0 opacity-40"></div>
    <div class="about-blob -right-24 top-10 h-96 w-96 bg-brand-800/60"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Features</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Small screen. <span class="about-gradient-text">Serious work.</span></h2>
        </div>
        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($product->features as $feature)
                <div class="rounded-3xl border border-white/10 bg-white/[0.04] p-7 transition duration-300 hover:-translate-y-1 hover:border-brand-500/40 hover:bg-white/[0.07]">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red shadow-lg shadow-brand-900/40">
                        <i data-lucide="{{ $feature->icon }}" class="h-6 w-6"></i>
                    </span>
                    <h3 class="mt-5 text-lg font-bold">{{ $feature->title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-400">{{ $feature->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     WHERE TO USE
========================================================= --}}
<section id="uses" class="scroll-mt-32 bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Where to use</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Right where <span class="text-brand-600">the work happens.</span></h2>
            </div>
            <p class="max-w-md text-gray-600">Compact enough for a machine or a cabinet door, connected enough to run the job.</p>
        </div>
        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($uses as [$icon, $title, $text])
                <div class="group flex items-start gap-5 rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-brand-200">
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
<section id="specs" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Specifications</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">{{ $product->name }}</h2>
            <p class="mt-4 text-gray-500">Available in one size: 8". Price on request.</p>
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
        <h2 class="mt-8 text-4xl font-bold sm:text-6xl">Put a screen <span class="about-gradient-text">on the job.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us about your machine or site and we'll help with mounting, wiring and pricing.</p>
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
