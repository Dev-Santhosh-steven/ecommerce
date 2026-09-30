@extends('layouts.store')

@section('title', 'Yara LCD Video Walls | 32" to 100" Panels, Ultra-Narrow Bezel')

@push('styles')
    <meta name="description" content="Yara LCD video walls in any panel size from 32 to 100 inch, with bezels from 3.5 mm down to 0.88 mm. 24/7 rated, built-in splicing, for control rooms, retail, lobbies and studios. Configured and quoted for your space.">
@endpush

@php
    $vw = fn ($file) => asset("storage/products/video-walls/{$file}");
    $lcd = fn ($file) => asset("storage/products/lcd-video-walls/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in an LCD video wall. Please share details and pricing.');

    // No fixed models: LCD video walls are configured for each project, in any panel size from 32" to 100".
    // Panel size (mm) is the 16:9 active area for the diagonal; the bezel is chosen separately.
    $sizes = [
        32 => 'Reception desks, menu boards & small meeting rooms',
        43 => 'Retail displays, info points & counters',
        46 => 'Retail, education & budget-friendly signage walls',
        49 => 'Corporate lobbies, showrooms & experience centres',
        55 => 'Control rooms, command centres & broadcast studios',
        65 => 'Large lobbies, auditoriums & event spaces',
        75 => 'Boardrooms and big-picture brand walls',
        86 => 'Malls, atriums & flagship stores',
        100 => 'Landmark walls with the fewest seams',
    ];
    $panels = collect($sizes)->map(function ($ideal, $inch) {
        $w = round($inch * 25.4 * 16 / sqrt(337), 1);
        $h = round($inch * 25.4 * 9 / sqrt(337), 1);

        return ['name' => "{$inch}\"", 'inch' => $inch, 'w' => $w, 'h' => $h, 'ideal' => $ideal];
    })->values();
    $startPanel = $panels->search(fn ($p) => $p['inch'] === 55);
    $bezels = [3.5, 1.8, 1.7, 0.88];
    $bezelShots = [
        ['file' => 'lcd-46-35-bezel.jpg', 'bezel' => '3.5 mm', 'note' => 'Value walls for retail & education'],
        ['file' => 'lcd-49-18-bezel.jpg', 'bezel' => '1.8 mm', 'note' => 'Lobbies & showrooms'],
        ['file' => 'lcd-55-17-bezel.jpg', 'bezel' => '1.7 mm', 'note' => 'Control rooms & studios'],
        ['file' => 'lcd-55-088-bezel.jpg', 'bezel' => '0.88 mm', 'note' => 'Premium, near-seamless walls'],
    ];
    $details = [
        'Panel Sizes' => 'Any size from 32" to 100"',
        'Bezel-to-Bezel' => '3.5 mm, 1.8 mm, 1.7 mm or 0.88 mm',
        'Resolution (per panel)' => '1920 × 1080 (Full HD)',
        'Brightness' => '500 – 700 cd/m²',
        'Contrast Ratio' => '1200:1',
        'Viewing Angle' => '178° (H) / 178° (V)',
        'Backlight' => 'D-LED',
        'Surface' => 'Anti-glare, haze 25%',
        'Operation' => '24/7 rated',
        'Inputs' => 'HDMI, DVI, VGA, DisplayPort, USB',
        'Outputs' => 'DisplayPort loop-through',
        'Control' => 'RS232 in / out, IR, LAN',
        'Splicing' => 'Built-in processor: full wall, per panel or custom zones',
        'Layouts' => '2 × 2 upwards (up to 10 × 10 per controller)',
        'Mounting' => 'VESA wall bracket, front-service pull-out mount or floor stand',
        'Panel Lifetime' => '60,000 hours',
        'Pricing' => 'Quoted per project',
    ];
    $contents = collect([
        ['label' => 'Cosmos', 'key' => 'cosmos'], ['label' => 'Fluid', 'key' => 'fluid'], ['label' => 'Blossom', 'key' => 'blossom'],
        ['label' => 'Moon stage', 'key' => 'moon'], ['label' => 'Circuit', 'key' => 'circuit'], ['label' => 'Brand', 'key' => 'lcd'],
        ['label' => 'Retail', 'key' => 'aurora'], ['label' => 'Promo', 'key' => 'sale'],
    ])->map(fn ($c) => $c + ['img' => $vw("content-{$c['key']}.jpg")])->values();

    $studio = ['img' => $vw('scene-studio.jpg'), 'alt' => 'Broadcast studio built from video wall screens',
        'screens' => [['quad' => '39.936,43.645 62.300,43.645 62.300,63.549 39.936,63.549', 'aspect' => 1.69]],
        'slides' => array_map(fn ($k) => $vw("content-{$k}.jpg"), ['lcd', 'fluid', 'circuit', 'cosmos'])];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#04070d] text-white">

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative isolate overflow-hidden pb-20 pt-14 sm:pt-20">

    <div class="absolute inset-0 -z-10 overflow-hidden">
        <img src="{{ $vw('scene-studio.jpg') }}" alt="" class="ha-kenburns h-full w-full object-cover opacity-25">
        {{-- screens flickering on around the studio --}}
        @foreach (range(1, 14) as $n)
            <span class="vw-twinkle absolute rounded-sm bg-sky-300 mix-blend-screen blur-[2px]"
                  style="left: {{ ($n * 23) % 92 }}%; top: {{ 18 + ($n * 17) % 55 }}%; width: {{ 4 + $n % 4 }}%; height: {{ 3 + $n % 3 }}%; --t: {{ 2.5 + ($n % 5) * 0.7 }}s; --d: -{{ $n * 0.6 }}s; --o: 0.35"></span>
        @endforeach
        <div class="absolute inset-0 bg-gradient-to-b from-[#04070d]/60 via-[#04070d]/80 to-[#04070d]"></div>
    </div>

    <div class="mx-auto grid max-w-[1500px] items-center gap-12 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:px-10">
        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-sky-300/30 bg-sky-400/10 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-sky-200 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                LCD Video Walls
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.02] sm:text-7xl">
                Panels that<br><span class="bg-gradient-to-r from-sky-300 via-cyan-200 to-indigo-300 bg-clip-text text-transparent">disappear.</span>
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Any panel size from 32" to 100", Full HD in every panel and bezels as thin as 0.88 mm. Build one big, razor-sharp picture for control rooms, stores and lobbies.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="#builder" class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-sky-900/50 transition hover:bg-sky-400">
                    Build your wall
                    <i data-lucide="layout-grid" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Get a quote
                </a>
            </div>
        </div>

        <div class="relative">
            <div class="absolute inset-[8%] rounded-full bg-sky-500/25 blur-[90px]"></div>
            <img src="{{ $lcd('lcd-hero.png') }}" alt="Yara 3 × 3 LCD video wall with 0.88 mm bezels" class="centum-hero-tv relative w-full">
            @foreach ([
                ['scan', '0.88 mm bezel', 'left-0 top-[6%]', '0s'],
                ['monitor', 'Full HD per panel', 'right-0 top-0', '-2s'],
                ['clock', '24/7 rated', 'left-[4%] bottom-[12%]', '-4s'],
                ['layout-grid', '32" to 100" panels', 'right-[3%] bottom-[6%]', '-1s'],
            ] as [$icon, $label, $pos, $delay])
                <span class="cd-chip absolute {{ $pos }} hidden items-center gap-2 rounded-full border border-white/15 bg-black/50 px-4 py-2 text-xs font-semibold shadow-xl backdrop-blur-md sm:inline-flex" style="animation-delay: {{ $delay }}">
                    <i data-lucide="{{ $icon }}" class="h-4 w-4 text-sky-300"></i>
                    {{ $label }}
                </span>
            @endforeach
        </div>
    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#04070d]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara LCD Video Walls</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">32" to 100" panels · 3.5 mm to 0.88 mm bezel · Quoted per project</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#builder" class="transition hover:text-white">Wall builder</a>
            <a href="#bezels" class="transition hover:text-white">Bezels</a>
            <a href="#spaces" class="transition hover:text-white">Spaces</a>
            <a href="#sizes" class="transition hover:text-white">Sizes</a>
            <a href="#compare" class="transition hover:text-white">LED vs LCD</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-sky-500 px-5 py-2.5 text-sm font-semibold transition hover:bg-sky-400">Get a quote</a>
    </div>
</div>


{{-- =========================================================
     WALL BUILDER
========================================================= --}}
<section id="builder" class="scroll-mt-32 py-24"
         x-data="wallBuilder(@js($panels), @js($contents), @js(config('services.chatbot.whatsapp')), @js($bezels), {{ $startPanel }})">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">Wall builder</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Design your wall <span class="bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent">in seconds.</span></h2>
            <p class="mt-4 text-lg text-gray-400">Pick a panel size from 32" to 100", a bezel and a layout. We'll work out the size, resolution and panel count.</p>
        </div>

        <div class="mt-14 grid gap-8 lg:grid-cols-[1.6fr_1fr]">

            {{-- stage --}}
            <div class="relative flex min-h-[22rem] items-center justify-center overflow-hidden rounded-[2rem] bg-gradient-to-b from-[#0b1220] to-[#05080f] p-6 ring-1 ring-white/10 sm:p-10" x-ref="stage">
                <div class="absolute inset-x-[15%] bottom-6 h-10 rounded-[50%] bg-sky-500/20 blur-2xl"></div>
                <div class="relative grid rounded-md bg-[#0a0a0d] p-[3px] shadow-[0_30px_80px_-20px_rgba(56,189,248,0.35)] ring-1 ring-white/10 transition-all duration-500"
                     :style="stageStyle + `; grid-template-columns: repeat(${cols}, 1fr); grid-template-rows: repeat(${rows}, 1fr); gap: var(--seam)`">
                    <template x-for="k in count" :key="build + '-' + k + '-' + mode + '-' + c">
                        <div class="vw-panel" :style="tileStyle(k - 1)"></div>
                    </template>
                </div>
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="absolute bottom-4 right-5 w-16 opacity-60">
                <span class="absolute left-5 top-4 text-[11px] uppercase tracking-[0.2em] text-gray-500">Seams shown 2× for clarity</span>
            </div>

            {{-- controls --}}
            <div class="space-y-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Panel size</p>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <template x-for="(panel, idx) in panels" :key="panel.inch">
                            <button type="button" @click="p = idx" class="rounded-2xl border px-3 py-2.5 text-center transition"
                                    :class="p === idx ? 'border-sky-400 bg-sky-400/10' : 'border-white/10 hover:border-white/30'">
                                <span class="block font-display text-lg font-bold" x-text="panel.inch + '&quot;'"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Bezel</p>
                    <div class="mt-3 grid grid-cols-4 gap-2">
                        <template x-for="(b, idx) in bezels" :key="b">
                            <button type="button" @click="bi = idx" class="rounded-2xl border px-2 py-2.5 text-center text-sm font-semibold transition"
                                    :class="bi === idx ? 'border-sky-400 bg-sky-400/10' : 'border-white/10 hover:border-white/30'"
                                    x-text="b + ' mm'"></button>
                        </template>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    @foreach (['cols' => 'Columns', 'rows' => 'Rows'] as $axis => $label)
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">{{ $label }}</p>
                            <div class="mt-3 flex items-center justify-between rounded-2xl border border-white/10 p-1.5">
                                <button type="button" @click="step('{{ $axis }}', -1)" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 transition hover:bg-white/15" aria-label="Fewer {{ strtolower($label) }}"><i data-lucide="minus" class="h-4 w-4"></i></button>
                                <span class="font-display text-2xl font-extrabold" x-text="{{ $axis }}"></span>
                                <button type="button" @click="step('{{ $axis }}', 1)" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 transition hover:bg-white/15" aria-label="More {{ strtolower($label) }}"><i data-lucide="plus" class="h-4 w-4"></i></button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-2">
                    @foreach ([[2, 2], [3, 3], [4, 2], [4, 4]] as [$cc, $rr])
                        <button type="button" @click="cols = {{ $cc }}; rows = {{ $rr }}" class="rounded-full px-4 py-1.5 text-xs font-semibold ring-1 transition"
                                :class="cols === {{ $cc }} && rows === {{ $rr }} ? 'bg-white text-gray-900 ring-white' : 'ring-white/15 hover:bg-white/10'">{{ $cc }} × {{ $rr }}</button>
                    @endforeach
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-400">Content</p>
                        <div class="inline-flex rounded-full bg-white/5 p-0.5 text-xs font-semibold ring-1 ring-white/10">
                            <button type="button" @click="mode = 'span'" class="rounded-full px-3 py-1 transition" :class="mode === 'span' ? 'bg-sky-500 text-white' : 'text-gray-400'">One picture</button>
                            <button type="button" @click="mode = 'tiles'" class="rounded-full px-3 py-1 transition" :class="mode === 'tiles' ? 'bg-sky-500 text-white' : 'text-gray-400'">Per panel</button>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-4 gap-2">
                        <template x-for="(ct, idx) in contents" :key="ct.key">
                            <button type="button" @click="c = idx" class="aspect-video overflow-hidden rounded-lg ring-2 transition" :class="c === idx ? 'ring-sky-400' : 'ring-transparent opacity-70 hover:opacity-100'" :aria-label="ct.label">
                                <img :src="ct.img" alt="" class="h-full w-full object-cover" loading="lazy">
                            </button>
                        </template>
                    </div>
                </div>

                <dl class="grid grid-cols-2 gap-3 rounded-2xl bg-white/[0.04] p-5 ring-1 ring-white/10">
                    <div><dt class="text-[11px] uppercase tracking-[0.2em] text-gray-500">Wall size</dt><dd class="mt-1 font-bold"><span x-text="(wMm / 1000).toFixed(2)"></span> × <span x-text="(hMm / 1000).toFixed(2)"></span> m</dd></div>
                    <div><dt class="text-[11px] uppercase tracking-[0.2em] text-gray-500">Diagonal</dt><dd class="mt-1 font-bold"><span x-text="diagonal"></span>"</dd></div>
                    <div><dt class="text-[11px] uppercase tracking-[0.2em] text-gray-500">Resolution</dt><dd class="mt-1 font-bold" x-text="resolution"></dd></div>
                    <div><dt class="text-[11px] uppercase tracking-[0.2em] text-gray-500">Panels</dt><dd class="mt-1 font-bold"><span x-text="count"></span> · <span x-text="area"></span> m²</dd></div>
                </dl>

                <div class="flex flex-wrap gap-3">
                    <a :href="enquiry" target="_blank" rel="noopener noreferrer" class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-sky-500 px-6 py-3.5 text-sm font-semibold transition hover:bg-sky-400">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>
                        Quote this wall
                    </a>
                    <a href="#details" class="inline-flex items-center justify-center rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold transition hover:bg-white/10">Full details</a>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- =========================================================
     BEZELS — close-ups
========================================================= --}}
<section id="bezels" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Bezel-to-bezel</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">The thinner the line, <span class="text-sky-600">the bigger the picture.</span></h2>
            <p class="mt-4 text-lg text-gray-600">Where four panels meet, shown at real scale and zoomed in. Every bezel is available in any panel size.</p>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($bezelShots as $i => $shot)
                <div class="group overflow-hidden rounded-3xl bg-gray-950 shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl" data-reveal style="--reveal-delay: {{ $i * 110 }}ms">
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ $lcd($shot['file']) }}" alt="{{ $shot['bezel'] }} bezel close-up" loading="lazy" class="h-full w-full object-cover transition duration-[1200ms] group-hover:scale-125">
                    </div>
                    <div class="p-5 text-white">
                        <p class="font-display text-3xl font-extrabold">{{ $shot['bezel'] }}</p>
                        <p class="mt-1 text-sm text-gray-400">{{ $shot['note'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     SPACES
========================================================= --}}
<section id="spaces" class="relative scroll-mt-32 overflow-hidden py-24">
    <div class="about-blob -left-24 top-1/3 h-96 w-96 bg-sky-800/60"></div>
    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-sky-300">Where it shines</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Built for rooms that <span class="bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent">read the screen.</span></h2>
            </div>
            <p class="max-w-md text-gray-300">Dashboards, maps, menus and fine print stay crisp even a step away.</p>
        </div>

        <div class="mt-12 grid gap-5 lg:grid-cols-3">
            <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10 lg:col-span-2" data-reveal>
                @include('store.partials.live-scene', ['scene' => $studio, 'interval' => 3800])
                <figcaption class="pointer-events-none absolute inset-x-0 bottom-0 z-20 bg-gradient-to-t from-black/80 to-transparent p-6 font-semibold">Broadcast & control rooms</figcaption>
            </figure>
            <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10" data-reveal style="--reveal-delay: 120ms">
                <img src="{{ $lcd('lcd-scene-classic.jpg') }}" alt="Yara 3 × 2 LCD video wall" loading="lazy" class="h-full w-full object-cover transition duration-[1200ms] group-hover:scale-105">
                <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-6 font-semibold">Lobbies & showrooms</figcaption>
            </figure>
            <figure class="group relative overflow-hidden rounded-[1.75rem] ring-1 ring-white/10 lg:col-span-2" data-reveal>
                <img src="{{ $lcd('lcd-scene-retail.jpg') }}" alt="Yara LCD video wall in a fashion store" loading="lazy" class="h-full w-full object-cover transition duration-[1200ms] group-hover:scale-105">
                <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-6 font-semibold">Retail & flagship stores</figcaption>
            </figure>
            <figure class="group relative flex items-center overflow-hidden rounded-[1.75rem] bg-gradient-to-b from-[#0b1220] to-[#05080f] p-6 ring-1 ring-white/10" data-reveal style="--reveal-delay: 120ms">
                <img src="{{ $lcd('lcd-4x4.png') }}" alt="Yara 4 × 4 LCD video wall" loading="lazy" class="about-float w-full">
                <figcaption class="absolute inset-x-0 bottom-0 p-6 font-semibold">Command centres · 4 × 4</figcaption>
            </figure>
        </div>
    </div>
</section>


{{-- =========================================================
     SIZES — available from 32" to 100"
========================================================= --}}
<section id="sizes" class="scroll-mt-32 bg-[#f4f4f5] py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Availability</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Available from <span class="text-sky-600">32" to 100".</span></h2>
            <p class="mt-5 text-lg text-gray-600">There are no fixed models: every LCD video wall is built for your space. Choose the panel size, the bezel and the layout, and we'll configure, quote and install it.</p>
        </div>

        <div class="mt-14 grid gap-4 sm:grid-cols-3 lg:grid-cols-9">
            @foreach ($panels as $i => $panel)
                <div class="group flex flex-col items-center rounded-3xl bg-white p-5 text-center shadow-sm ring-1 ring-gray-200 transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:ring-sky-200">
                    {{-- panel drawn to scale against the 100" --}}
                    <div class="flex h-20 w-full items-end justify-center">
                        <span class="block rounded-[3px] bg-gradient-to-br from-gray-800 to-gray-950 ring-2 ring-gray-900 transition group-hover:from-sky-700 group-hover:to-indigo-900"
                              style="width: {{ $panel['inch'] }}%; aspect-ratio: 16 / 9"></span>
                    </div>
                    <p class="mt-4 font-display text-3xl font-extrabold">{{ $panel['inch'] }}<span class="text-sky-600">"</span></p>
                    <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-gray-400">{{ number_format($panel['w'] / 10, 0) }} × {{ number_format($panel['h'] / 10, 0) }} cm</p>
                    <p class="mt-3 text-xs leading-5 text-gray-600">{{ $panel['ideal'] }}</p>
                </div>
            @endforeach
        </div>

        <div id="details" class="mt-20 grid scroll-mt-32 gap-10 lg:grid-cols-[0.8fr_1.2fr]">
            <div data-reveal>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Details</p>
                <h3 class="mt-3 text-3xl font-bold sm:text-4xl">What every Yara LCD video wall includes</h3>
                <p class="mt-4 text-gray-600">The same commercial-grade panel technology across all sizes. Size, bezel and layout are chosen per project; technical drawings, weight and power are shared with your quote.</p>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="mt-8 inline-flex items-center gap-2 rounded-full bg-gray-900 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-sky-600">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Ask for a quote
                </a>
            </div>
            <dl class="grid gap-x-10 rounded-3xl bg-white px-6 py-2 shadow-sm ring-1 ring-gray-200 sm:grid-cols-2" data-reveal>
                @foreach ($details as $key => $value)
                    <div class="flex items-baseline justify-between gap-6 border-b border-gray-100 py-3.5 text-sm">
                        <dt class="text-gray-500">{{ $key }}</dt>
                        <dd class="text-right font-semibold">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
</section>


{{-- =========================================================
     LED vs LCD
========================================================= --}}
<section id="compare" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">LED or LCD?</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Pick the right wall.</h2>
        </div>
        <div class="mt-12 overflow-hidden rounded-3xl ring-1 ring-gray-200" data-reveal>
            <div class="grid grid-cols-3 bg-gray-950 text-sm font-semibold text-white">
                <div class="p-4 sm:p-5"></div>
                <div class="bg-sky-600 p-4 text-center sm:p-5">LCD video wall</div>
                <div class="bg-brand-600 p-4 text-center sm:p-5">LED video wall</div>
            </div>
            @foreach ([
                ['Best viewing distance', 'Close up, from 1 m', 'Mid to far, from about 1.5 m'],
                ['Seams', 'Hairline 0.88–3.5 mm', 'Fully seamless'],
                ['Resolution', 'Full HD per panel, very high density', 'Set by the pixel pitch'],
                ['Size & shape', 'Grids of 32"–100" panels', 'Any size, curves, corners, outdoor'],
                ['Brightness', '500–700 nits (indoor)', 'Up to 7,000 nits (outdoor)'],
                ['Ideal for', 'Control rooms, dashboards, retail', 'Stages, facades, billboards, big halls'],
            ] as $row)
                <div class="grid grid-cols-3 border-t border-gray-100 text-sm">
                    <div class="p-4 font-semibold sm:p-5">{{ $row[0] }}</div>
                    <div class="bg-sky-50/60 p-4 text-center sm:p-5">{{ $row[1] }}</div>
                    <div class="p-4 text-center sm:p-5">{{ $row[2] }}</div>
                </div>
            @endforeach
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('store.ledwalls') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:underline">
                Explore Yara LED Video Walls
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>
</section>


{{-- =========================================================
     CTA
========================================================= --}}
<section class="relative overflow-hidden py-28 text-center">
    <div class="about-grid absolute inset-0 opacity-50"></div>
    <div class="about-blob left-1/2 top-0 h-96 w-96 -translate-x-1/2 bg-sky-700/60"></div>
    <div class="relative mx-auto max-w-3xl px-4" data-reveal>
        <h2 class="text-4xl font-bold sm:text-6xl">Let's build your <span class="bg-gradient-to-r from-sky-300 to-indigo-300 bg-clip-text text-transparent">video wall.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us the space and what you'll show. We'll design the layout, mounting and control, and handle installation.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-sky-500 px-7 py-4 text-sm font-semibold transition hover:bg-sky-400">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Get a quote on WhatsApp
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
