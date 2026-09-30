@extends('layouts.store')

@section('title', 'Yara Commercial Washing Machine | Fully Automatic 10 – 25 kg Washers for Hotels & Hospitals')

@push('styles')
    <meta name="description" content="Yara fully automatic commercial washing machines, 10 to 25 kg: stainless steel drum, 1150 rpm extraction, programmable controls and optional coin operation for hotels, hospitals, laundries and institutions.">
@endpush

@php
    $base = fn ($file) => asset("storage/products/commercial-washers/{$file}");
    $wa = fn ($text) => 'https://wa.me/' . config('services.chatbot.whatsapp') . '?text=' . rawurlencode($text);
    $whatsapp = $wa('Hi Yara, I am interested in your Fully Automatic Commercial Washing Machine. Please share details and pricing.');

    // One entry per model for the capacity picker, straight from the product specifications.
    $models = $products->map(function ($p) use ($wa) {
        $s = $p->specifications ?? [];
        $kg = (int) ($s['Washing Capacity'] ?? 0);

        return [
            'kg' => $kg,
            'model' => $s['Model'] ?? $p->model_number,
            'drum' => $s['Washing Drum Dimension'] ?? '',
            'motor' => $s['Washing Motor Power'] ?? '',
            'dimension' => $s['Dimension'] ?? '',
            'weight' => $s['Gross Weight'] ?? '',
            'url' => route('store.product', $p),
            'enquire' => $wa("Hi Yara, I am interested in the {$kg} kg commercial washer (" . ($s['Model'] ?? $p->model_number) . '). Please share pricing.'),
        ];
    })->values();
    $start = max(0, $models->search(fn ($m) => $m['kg'] === 15));
    $minKg = $models->min('kg');
    $maxKg = $models->max('kg');

    $features = $products->first()->features;

    $cycle = [
        ['icon' => 'droplets', 'step' => 'Wash', 'rpm' => 50, 'text' => 'The drum turns slowly at 50 rpm, tumbling linen through water and detergent without stressing the fabric.'],
        ['icon' => 'waves', 'step' => 'Rinse & drain', 'rpm' => 50, 'text' => 'Optimized drainage empties the drum fast and clean, ready for a fresh rinse.'],
        ['icon' => 'wind', 'step' => 'High extract', 'rpm' => 1150, 'text' => 'The drum spins up to 1150 rpm, pulling out water so linen goes into the dryer nearly dry.'],
    ];

    $places = [
        ['icon' => 'hotel', 'name' => 'Hotels & resorts', 'text' => 'Bed linen, towels and uniforms, load after load.'],
        ['icon' => 'hospital', 'name' => 'Hospitals & clinics', 'text' => 'Hygienic washing for sheets, gowns and scrubs.'],
        ['icon' => 'shirt', 'name' => 'Laundries & laundromats', 'text' => 'Optional coin operation for self-service stores.'],
        ['icon' => 'bed-double', 'name' => 'Hostels & PGs', 'text' => 'Reliable shared laundry for residents.'],
        ['icon' => 'landmark', 'name' => 'Institutions', 'text' => 'Colleges, training centres, factories and more.'],
    ];

    $rows = [
        ['Heating Type', fn ($p) => $p->specifications['Heating Type'] ?? ''],
        ['Washing Capacity', fn ($p) => $p->specifications['Washing Capacity'] ?? ''],
        ['Washing Drum Dimension', fn ($p) => $p->specifications['Washing Drum Dimension'] ?? ''],
        ['Washing Speed', fn ($p) => $p->specifications['Washing Speed'] ?? ''],
        ['High Extract Speed', fn ($p) => $p->specifications['High Extract Speed'] ?? ''],
        ['Rated Voltage', fn ($p) => $p->specifications['Rated Voltage'] ?? ''],
        ['Washing Motor Power', fn ($p) => $p->specifications['Washing Motor Power'] ?? ''],
        ['Dimension', fn ($p) => $p->specifications['Dimension'] ?? ''],
        ['Gross Weight', fn ($p) => $p->specifications['Gross Weight'] ?? ''],
    ];
@endphp

@section('content')

<div class="overflow-x-clip bg-[#090b10] text-white">

{{-- =========================================================
     HERO
========================================================= --}}
<section class="relative overflow-hidden pb-16 pt-14 sm:pt-20">

    <div class="about-grid absolute inset-0 opacity-50"></div>
    <div class="about-blob -left-32 top-24 h-[30rem] w-[30rem] bg-slate-600/40"></div>
    <div class="about-blob -right-24 bottom-0 h-[26rem] w-[26rem] bg-brand-700/50 [animation-delay:-6s]"></div>

    <div class="relative mx-auto grid max-w-[1500px] items-center gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div class="about-intro text-center lg:text-left">
            <p class="inline-flex items-center gap-3 rounded-full border border-white/15 bg-white/5 py-2 pl-3 pr-5 text-xs font-semibold uppercase tracking-[0.3em] text-gray-300 backdrop-blur">
                <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="h-4 w-auto">
                <span class="h-3 w-px bg-white/25"></span>
                Flagship · Commercial laundry
            </p>
            <h1 class="mt-6 text-5xl font-bold leading-[1.05] sm:text-7xl">
                Commercial <span class="about-gradient-text">Washing Machine</span>
            </h1>
            <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300 sm:text-xl lg:mx-0">
                Built for high-performance laundry operations: a durable stainless steel drum, programmable controls and optimized drainage for efficient, reliable, fabric-friendly cleaning.
            </p>
            <div class="mt-9 flex flex-wrap justify-center gap-4 lg:justify-start">
                <a href="#capacity" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                    Choose your capacity
                    <i data-lucide="arrow-down" class="h-4 w-4"></i>
                </a>
                <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i data-lucide="message-circle" class="h-4 w-4"></i>
                    Enquire now
                </a>
            </div>
            <dl class="mx-auto mt-12 grid max-w-xl grid-cols-3 gap-px overflow-hidden rounded-2xl bg-white/10 lg:mx-0">
                @foreach ([["{$minKg}–{$maxKg} kg", 'Capacity'], ['1150 rpm', 'High extract'], ['SS drum', 'Stainless steel']] as [$v, $l])
                    <div class="bg-[#0d1017] p-4 text-center sm:p-5">
                        <dt class="order-2 text-[11px] font-semibold uppercase tracking-[0.18em] text-gray-400">{{ $l }}</dt>
                        <dd class="font-display text-xl font-extrabold sm:text-2xl">{{ $v }}</dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="relative mx-auto w-full max-w-md lg:max-w-lg">
            <div class="absolute inset-x-[8%] bottom-[4%] top-[18%] rounded-full bg-slate-400/20 blur-3xl"></div>
            <img src="{{ $base('washer-cutout.png') }}" alt="Yara Fully Automatic Commercial Washing Machine" class="centum-hero-tv relative mx-auto w-[82%] drop-shadow-[0_40px_50px_rgba(0,0,0,0.6)]">
        </div>

    </div>

</section>


{{-- =========================================================
     STICKY BAR
========================================================= --}}
<div class="sticky top-[4.25rem] z-40 border-y border-white/10 bg-[#090b10]/85 backdrop-blur-xl">
    <div class="mx-auto flex max-w-[1500px] items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-10">
        <div class="min-w-0">
            <p class="truncate font-display text-base font-bold sm:text-lg">Yara Commercial Washing Machine</p>
            <p class="hidden truncate text-xs text-gray-400 sm:block">SWQ series · {{ $minKg }} – {{ $maxKg }} kg · Price on request</p>
        </div>
        <nav class="hidden items-center gap-6 text-sm text-gray-300 md:flex">
            <a href="#capacity" class="transition hover:text-white">Capacity</a>
            <a href="#features" class="transition hover:text-white">Features</a>
            <a href="#cycle" class="transition hover:text-white">Wash cycle</a>
            <a href="#places" class="transition hover:text-white">Where to use</a>
            <a href="#specs" class="transition hover:text-white">Specs</a>
        </nav>
        <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="shrink-0 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-500">Enquire</a>
    </div>
</div>


{{-- =========================================================
     CAPACITY PICKER
========================================================= --}}
<section id="capacity" class="relative scroll-mt-32 overflow-hidden bg-[#f4f5f7] py-24 text-gray-900"
         x-data="{ i: {{ $start }}, m: @js($models), minKg: {{ $minKg }}, maxKg: {{ $maxKg }},
                   get cur() { return this.m[this.i] },
                   get scale() { return 0.74 + 0.26 * (this.cur.kg - this.minKg) / Math.max(1, this.maxKg - this.minKg) } }">

    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Capacity</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">From 10 kg to 25 kg. <span class="text-brand-600">Pick your load.</span></h2>
            <p class="mt-5 text-lg text-gray-600">Five models, one proven design. Choose the drum that matches the laundry you handle every day.</p>
        </div>

        {{-- capacity buttons --}}
        <div class="mx-auto mt-12 flex max-w-3xl flex-wrap justify-center gap-3" role="tablist">
            @foreach ($models as $k => $m)
                <button type="button" @click="i = {{ $k }}" role="tab" :aria-selected="i === {{ $k }}"
                        class="min-w-[5.5rem] rounded-2xl px-5 py-3 text-center transition"
                        :class="i === {{ $k }} ? 'bg-gray-900 text-white shadow-xl' : 'bg-white text-gray-700 ring-1 ring-gray-200 hover:ring-gray-300'">
                    <span class="block font-display text-2xl font-extrabold">{{ $m['kg'] }}<span class="text-sm font-semibold"> kg</span></span>
                    <span class="block text-[11px] font-semibold uppercase tracking-wider" :class="i === {{ $k }} ? 'text-brand-300' : 'text-gray-400'">{{ $m['model'] }}</span>
                </button>
            @endforeach
        </div>

        <div class="mt-14 grid items-center gap-12 lg:grid-cols-2">

            {{-- washer grows with capacity --}}
            <div class="relative flex h-[26rem] items-end justify-center sm:h-[32rem]" data-no-auto-reveal>
                <div class="absolute bottom-6 left-1/2 h-10 w-2/3 -translate-x-1/2 rounded-[50%] bg-black/20 blur-2xl"></div>
                <img src="{{ $base('washer-cutout.png') }}" alt="Yara commercial washer" loading="lazy"
                     class="relative h-full w-auto origin-bottom transition-transform duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                     :style="`transform: scale(${scale})`">
                <span class="absolute right-2 top-4 rounded-2xl bg-white px-5 py-3 shadow-xl ring-1 ring-gray-200 sm:right-8">
                    <span class="block font-display text-4xl font-extrabold text-brand-600" x-text="cur.kg + ' kg'">{{ $models[$start]['kg'] }} kg</span>
                    <span class="block text-xs font-semibold uppercase tracking-wider text-gray-400">per load</span>
                </span>
            </div>

            {{-- specs of the selected model --}}
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-400">Model <span class="text-gray-900" x-text="cur.model">{{ $models[$start]['model'] }}</span></p>
                <h3 class="mt-2 text-3xl font-bold sm:text-4xl"><span x-text="cur.kg">{{ $models[$start]['kg'] }}</span> kg Commercial Washer</h3>

                <dl class="mt-8 grid grid-cols-2 gap-4">
                    @foreach ([['Drum volume', 'drum', 'cylinder'], ['Motor power', 'motor', 'zap'], ['Dimension (W×D×H)', 'dimension', 'ruler'], ['Gross weight', 'weight', 'weight']] as [$label, $key, $icon])
                        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                            <dt class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                <i data-lucide="{{ $icon }}" class="h-4 w-4 text-brand-600"></i>
                                {{ $label }}
                            </dt>
                            <dd class="mt-2 font-display text-xl font-bold" x-text="cur.{{ $key }}">{{ $models[$start][$key] }}</dd>
                        </div>
                    @endforeach
                </dl>

                <ul class="mt-6 flex flex-wrap gap-2 text-sm">
                    @foreach (['Wash 50 rpm', 'Extract 1150 rpm', '220 V', 'Electric heating'] as $pill)
                        <li class="rounded-full bg-white px-3 py-1.5 font-medium text-gray-700 ring-1 ring-gray-200">{{ $pill }}</li>
                    @endforeach
                </ul>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a :href="cur.url" href="{{ $models[$start]['url'] }}" class="inline-flex items-center gap-2 rounded-full bg-gray-900 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-brand-600">
                        View details <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                    <a :href="cur.enquire" href="{{ $models[$start]['enquire'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-6 py-3.5 text-sm font-semibold text-gray-900 transition hover:bg-white">
                        <i data-lucide="message-circle" class="h-4 w-4"></i>
                        Enquire for <span x-text="cur.model">{{ $models[$start]['model'] }}</span>
                    </a>
                </div>
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

        <div class="grid items-end gap-6 lg:grid-cols-2" data-reveal>
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Key features</p>
                <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Engineered for <span class="about-gradient-text">non-stop laundry.</span></h2>
            </div>
            <p class="max-w-lg text-gray-300 lg:justify-self-end">Every part is chosen for heavy daily use, from the stainless steel drum to the safety-linked door.</p>
        </div>

        <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($features as $feature)
                <div class="group rounded-3xl border border-white/10 bg-white/[0.04] p-7 backdrop-blur transition duration-300 hover:-translate-y-1 hover:border-brand-500/40 hover:bg-white/[0.07]">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-red text-white shadow-lg shadow-brand-900/40 transition group-hover:-rotate-6">
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
     WASH CYCLE — drum speed
========================================================= --}}
<section id="cycle" class="relative scroll-mt-32 overflow-hidden bg-white py-24 text-gray-900"
         x-data="{ s: 0, t: null, start() { clearInterval(this.t); this.t = setInterval(() => this.s = (this.s + 1) % 3, 3200) }, pick(k) { this.s = k; this.start() } }"
         x-init="start()">

    <div class="mx-auto grid max-w-[1500px] items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:px-10">

        <div data-reveal="left">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Wash cycle</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Gentle when it washes. <span class="text-brand-600">Fast when it spins.</span></h2>

            <ol class="mt-10 space-y-3">
                @foreach ($cycle as $k => $c)
                    <li>
                        <button type="button" @click="pick({{ $k }})" class="flex w-full items-start gap-5 rounded-2xl p-4 text-left transition" :class="s === {{ $k }} ? 'bg-brand-50' : 'hover:bg-gray-50'">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl transition" :class="s === {{ $k }} ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/30' : 'bg-gray-100 text-gray-500'">
                                <i data-lucide="{{ $c['icon'] }}" class="h-6 w-6"></i>
                            </span>
                            <span>
                                <span class="flex items-baseline gap-3">
                                    <span class="text-lg font-bold">{{ $c['step'] }}</span>
                                    <span class="font-display text-sm font-bold text-brand-600">{{ $c['rpm'] }} rpm</span>
                                </span>
                                <span class="mt-1 block text-sm leading-6 text-gray-600">{{ $c['text'] }}</span>
                            </span>
                        </button>
                    </li>
                @endforeach
            </ol>
        </div>

        {{-- drum dial: spins slow for wash/rinse, fast for extract --}}
        <div class="relative mx-auto aspect-square w-full max-w-md" data-reveal="right">
            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-gray-200 to-gray-400 shadow-2xl"></div>
            <div class="absolute inset-[7%] rounded-full bg-gradient-to-br from-gray-700 to-gray-900"></div>
            <div class="absolute inset-[13%] overflow-hidden rounded-full bg-[radial-gradient(circle_at_40%_35%,#5b6474,#1c2129_70%)] ring-4 ring-gray-500/40">
                <div class="cw-drum absolute inset-[6%] rounded-full" :style="`animation-duration: ${s === 2 ? '0.35s' : '4s'}`"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-sky-300/10 to-sky-400/25 transition-opacity duration-700" :class="s === 2 ? 'opacity-0' : 'opacity-100'"></div>
            </div>
            <div class="absolute inset-x-0 -bottom-4 text-center">
                <span class="inline-flex items-baseline gap-2 rounded-full bg-gray-900 px-6 py-3 text-white shadow-xl">
                    <span class="font-display text-3xl font-extrabold" x-text="s === 2 ? '1150' : '50'">50</span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">rpm</span>
                </span>
            </div>
        </div>

    </div>

</section>


{{-- =========================================================
     WHERE TO USE
========================================================= --}}
<section id="places" class="relative scroll-mt-32 overflow-hidden py-24"
         x-data="{ a: 0, n: {{ count($places) }}, t: null,
                   start() { clearInterval(this.t); this.t = setInterval(() => this.a = (this.a + 1) % this.n, 2800) },
                   pick(k) { this.a = k; this.start() } }"
         x-init="start()">

    <div class="about-grid absolute inset-0 opacity-30"></div>
    <div class="about-blob -left-24 top-10 h-96 w-96 bg-slate-600/40"></div>
    <div class="about-blob -right-24 bottom-0 h-96 w-96 bg-brand-800/50 [animation-delay:-5s]"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="mx-auto max-w-2xl text-center" data-reveal>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Where to use</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Wherever the laundry <span class="about-gradient-text">never stops.</span></h2>
        </div>

        <div class="mt-14 grid items-center gap-8 lg:grid-cols-[1fr_1.2fr_1fr]">

            {{-- places, left column (first half) --}}
            @foreach ([array_slice($places, 0, 3, true), array_slice($places, 3, null, true)] as $col => $group)
                <div class="grid gap-4 {{ $col === 0 ? 'lg:order-1' : 'lg:order-3' }}">
                    @foreach ($group as $k => $p)
                        <button type="button" @click="pick({{ $k }})" @mouseenter="pick({{ $k }})"
                                class="group relative flex items-start gap-4 overflow-hidden rounded-3xl border p-5 text-left backdrop-blur transition duration-500 {{ $col === 0 ? 'lg:flex-row-reverse lg:text-right' : '' }}"
                                :class="a === {{ $k }} ? 'border-brand-500/60 bg-brand-600/15 shadow-[0_20px_60px_-20px_rgba(237,28,36,0.45)]' : 'border-white/10 bg-white/[0.04] hover:border-white/25'">
                            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl transition duration-500"
                                  :class="a === {{ $k }} ? 'bg-brand-600 text-white scale-110' : 'bg-white/10 text-brand-300'">
                                <i data-lucide="{{ $p['icon'] }}" class="h-6 w-6"></i>
                            </span>
                            <span>
                                <span class="block font-bold">{{ $p['name'] }}</span>
                                <span class="mt-1 block text-sm text-gray-400">{{ $p['text'] }}</span>
                            </span>
                            <span class="absolute inset-x-0 bottom-0 h-0.5 origin-left bg-brand-red" :class="a === {{ $k }} ? 'centum-thumb-progress [animation-duration:2.8s]' : 'scale-x-0'"></span>
                        </button>
                    @endforeach
                </div>
            @endforeach

            {{-- the washer, with bubbles rising around it --}}
            <div class="relative mx-auto aspect-square w-full max-w-md lg:order-2" data-no-auto-reveal>
                <div class="cw-halo absolute inset-[12%] rounded-full"></div>
                <div class="pointer-events-none absolute inset-0 overflow-hidden rounded-full [mask-image:radial-gradient(circle,black_55%,transparent_72%)]">
                    @foreach (range(1, 16) as $b)
                        <span class="cw-bubble" style="--x: {{ ($b * 37) % 92 + 2 }}%; --s: {{ 10 + ($b * 13) % 34 }}px; --d: {{ 4 + ($b % 5) * 1.3 }}s; --delay: -{{ $b * 0.7 }}s"></span>
                    @endforeach
                </div>
                <img src="{{ $base('washer-cutout.png') }}" alt="Yara commercial washing machine" loading="lazy"
                     class="about-float relative mx-auto mt-[9%] w-[62%] drop-shadow-[0_40px_45px_rgba(0,0,0,0.65)]">
                <div class="absolute bottom-[4%] left-1/2 h-6 w-1/2 -translate-x-1/2 rounded-[50%] bg-black/50 blur-xl"></div>

                {{-- the highlighted place, as a badge over the machine --}}
                <div class="absolute left-1/2 top-[2%] -translate-x-1/2">
                    @foreach ($places as $k => $p)
                        <span x-show="a === {{ $k }}" x-transition.opacity.duration.400ms @if ($k > 0) x-cloak @endif
                              class="inline-flex items-center gap-2 whitespace-nowrap rounded-full border border-white/15 bg-black/60 px-4 py-2 text-xs font-semibold shadow-xl backdrop-blur-md">
                            <i data-lucide="{{ $p['icon'] }}" class="h-4 w-4 text-brand-300"></i>
                            {{ $p['name'] }}
                        </span>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     SPECS — all models side by side
========================================================= --}}
<section id="specs" class="scroll-mt-32 bg-white py-24 text-gray-900">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

        <div class="text-center" data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Technical parameters</p>
            <h2 class="mt-3 text-4xl font-bold sm:text-5xl">Compare the <span class="text-brand-600">SWQ series</span></h2>
        </div>

        <div class="mt-12 overflow-x-auto rounded-3xl ring-1 ring-gray-200" data-reveal>
            <table class="w-full min-w-[760px] text-sm">
                <thead>
                    <tr class="bg-gray-900 text-white">
                        <th class="px-5 py-4 text-left font-semibold">Model</th>
                        @foreach ($products as $p)
                            <th class="px-5 py-4 text-center font-display text-base font-bold">
                                <a href="{{ route('store.product', $p) }}" class="transition hover:text-brand-300">{{ $p->model_number }}</a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $r => [$label, $get])
                        <tr class="{{ $r % 2 ? 'bg-gray-50' : 'bg-white' }}">
                            <th class="px-5 py-3.5 text-left font-medium text-gray-500">{{ $label }}</th>
                            @foreach ($products as $p)
                                <td class="px-5 py-3.5 text-center font-semibold">{{ $get($p) }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($products as $p)
                <a href="{{ route('store.product', $p) }}" class="group flex items-center gap-4 rounded-2xl p-3 ring-1 ring-gray-200 transition hover:shadow-lg hover:ring-brand-200">
                    @if ($p->primaryImage)
                        <img src="{{ asset('storage/' . $p->primaryImage->image) }}" alt="{{ $p->name }}" loading="lazy" class="h-16 w-16 rounded-xl object-cover">
                    @endif
                    <span class="min-w-0">
                        <span class="block font-bold">{{ $p->specifications['Washing Capacity'] ?? '' }}</span>
                        <span class="block text-xs text-gray-500">{{ $p->model_number }} · View details</span>
                    </span>
                    <i data-lucide="arrow-right" class="ml-auto h-4 w-4 shrink-0 text-gray-400 transition group-hover:translate-x-0.5 group-hover:text-brand-600"></i>
                </a>
            @endforeach
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
        <h2 class="text-4xl font-bold sm:text-6xl">Cleaner linen. <span class="about-gradient-text">Faster turnaround.</span></h2>
        <p class="mx-auto mt-5 max-w-xl text-lg text-gray-300">Tell us how much laundry you handle each day and we'll recommend the right capacity, installation and coin option.</p>
        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <a href="{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-7 py-4 text-sm font-semibold text-white shadow-lg shadow-brand-950/50 transition hover:bg-brand-500">
                <i data-lucide="message-circle" class="h-4 w-4"></i>
                Enquire on WhatsApp
            </a>
            <a href="{{ route('store.demo.create') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-7 py-4 text-sm font-semibold text-white transition hover:bg-white/10">
                Book a demo
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>
    </div>

</section>

</div>

@endsection
