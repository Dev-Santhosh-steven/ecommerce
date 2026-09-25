@extends('layouts.store')

@section('title', 'LED Wall Calculator | Plan Your LED Video Wall | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            @if ($category)
                <a href="{{ route('store.category', $category) }}" class="hover:text-white">{{ $category->name }}</a>
                <span class="mx-2">/</span>
            @endif
            <span class="text-white">LED Wall Calculator</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            LED Wall <span class="text-brand-400">Calculator</span>
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            Tell us where the screen will go and how much space you have. We&rsquo;ll work out the exact
            LED wall that fits &mdash; size, resolution, power and viewing distance &mdash; in seconds.
        </p>

        <ol class="mt-8 flex flex-wrap gap-3 text-sm">
            @foreach (['Choose indoor or outdoor', 'Pick a pixel pitch', 'Enter your wall space'] as $i => $step)
                <li class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-gray-200 backdrop-blur">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-600 text-[11px] font-bold text-white">{{ $i + 1 }}</span>
                    {{ $step }}
                </li>
            @endforeach
        </ol>

    </div>

</section>


{{-- =========================================================
     CALCULATOR
========================================================= --}}
<section
    class="bg-gray-50 py-10 sm:py-14"
    x-data="ledCalc(@js($modules), @js((int) request('module')), @js(route('store.led-calculator.calculate')))"
>

    <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] lg:px-8">

        {{-- ---------------- Inputs ---------------- --}}
        <form @submit.prevent="calculate()" class="space-y-5 lg:sticky lg:top-28 lg:self-start" novalidate>

            {{-- Step 1: environment --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.15em] text-gray-500">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-600 text-[11px] font-bold text-white">1</span>
                    Where will the screen go?
                </p>

                <div class="mt-4 grid grid-cols-2 gap-2 rounded-xl bg-gray-100 p-1">
                    <button type="button" @click="env = 'indoor'"
                            :class="env === 'indoor' ? 'bg-gray-950 text-white shadow' : 'text-gray-600 hover:text-gray-900'"
                            class="flex items-center justify-center gap-2 rounded-lg px-3 py-2.5 text-sm font-semibold transition">
                        <i data-lucide="building-2" class="h-4 w-4"></i>
                        Indoor
                    </button>
                    <button type="button" @click="env = 'outdoor'"
                            :class="env === 'outdoor' ? 'bg-gray-950 text-white shadow' : 'text-gray-600 hover:text-gray-900'"
                            class="flex items-center justify-center gap-2 rounded-lg px-3 py-2.5 text-sm font-semibold transition">
                        <i data-lucide="sun" class="h-4 w-4"></i>
                        Outdoor
                    </button>
                </div>

                <p class="mt-3 text-xs leading-5 text-gray-500"
                   x-text="env === 'indoor'
                        ? 'Lobbies, boardrooms, retail, stages and control rooms — fine pixel pitch for close viewing.'
                        : 'Billboards, building facades, stadiums and events — high brightness and weatherproof (IP65).'"></p>

                <label class="mt-5 block">
                    <span class="text-sm font-medium text-gray-700">
                        Closest viewer distance
                        <span class="font-normal text-gray-400">(optional)</span>
                    </span>
                    <div class="mt-1.5 flex items-center gap-2">
                        <input type="number" x-model="distance" min="0" step="0.5" inputmode="decimal"
                               :placeholder="distanceUnit === 'ft' ? 'e.g. 10' : 'e.g. 3'"
                               class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                        <span class="w-10 shrink-0 text-sm font-medium text-gray-500" x-text="distanceUnit"></span>
                    </div>
                    <span class="mt-1.5 block text-xs text-gray-500">We&rsquo;ll mark the best-value pixel pitch for that distance.</span>
                </label>

            </div>


            {{-- Step 2: module --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">

                <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.15em] text-gray-500">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-600 text-[11px] font-bold text-white">2</span>
                    Choose the LED module
                </p>

                <div class="mt-4 grid gap-2.5 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">

                    <template x-for="m in filtered" :key="m.id">

                        <button type="button" @click="moduleId = m.id"
                                :class="moduleId === m.id ? 'border-brand-600 ring-2 ring-brand-600/15 bg-brand-50/40' : 'border-gray-200 hover:border-gray-300'"
                                class="relative rounded-xl border bg-white p-3.5 text-left transition">

                            <span class="flex items-start justify-between gap-2">
                                <span class="text-2xl font-bold leading-none tracking-tight text-gray-900" x-text="'P' + trim(m.pixel_pitch)"></span>
                                <span x-show="bestValueId === m.id"
                                      class="rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-emerald-700">Best value</span>
                                <span x-show="tooClose(m)"
                                      class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-amber-700">Too close</span>
                            </span>

                            <span class="mt-1.5 block truncate text-sm font-semibold text-gray-800" x-text="m.name"></span>

                            <span class="mt-1 block text-xs leading-5 text-gray-500">
                                <span x-text="Number(m.brightness_nits).toLocaleString('en-IN') + ' nits'"></span>
                                &middot;
                                <span x-text="'best from ' + distLabel(m.pixel_pitch * 3)"></span>
                            </span>

                        </button>

                    </template>

                </div>

                <p x-show="!filtered.length" class="mt-4 text-sm text-gray-500">No modules available here yet.</p>

            </div>


            {{-- Step 3: space --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-6">

                <div class="flex flex-wrap items-center justify-between gap-3">
                    <p class="flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.15em] text-gray-500">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-brand-600 text-[11px] font-bold text-white">3</span>
                        Your wall space
                    </p>

                    <div class="flex rounded-lg bg-gray-100 p-0.5 text-xs font-semibold">
                        <template x-for="u in ['ft', 'm', 'mm', 'in']" :key="u">
                            <button type="button" @click="unit = u" x-text="u"
                                    :class="unit === u ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                                    class="rounded-md px-3 py-1.5 transition"></button>
                        </template>
                    </div>
                </div>

                <div class="mt-4 flex items-end gap-3">
                    <label class="flex-1">
                        <span class="text-sm font-medium text-gray-700">Max width</span>
                        <input type="number" x-model="width" min="0" step="any" inputmode="decimal" :placeholder="placeholders[unit][0]"
                               class="mt-1.5 w-full rounded-lg border border-gray-300 px-3.5 py-3 text-center text-lg font-semibold focus:border-brand-500 focus:outline-none">
                    </label>
                    <span class="pb-3.5 text-lg font-semibold text-gray-400">&times;</span>
                    <label class="flex-1">
                        <span class="text-sm font-medium text-gray-700">Max height</span>
                        <input type="number" x-model="height" min="0" step="any" inputmode="decimal" :placeholder="placeholders[unit][1]"
                               class="mt-1.5 w-full rounded-lg border border-gray-300 px-3.5 py-3 text-center text-lg font-semibold focus:border-brand-500 focus:outline-none">
                    </label>
                </div>

                <p class="mt-2 text-xs text-gray-500">The wall we suggest will never be bigger than this space.</p>

                <div class="mt-5">
                    <span class="text-sm font-medium text-gray-700">Screen shape <span class="font-normal text-gray-400">(optional)</span></span>
                    <div class="mt-2 flex flex-wrap gap-2">
                        <template x-for="r in ratios" :key="r.value">
                            <button type="button" @click="ratio = r.value"
                                    :class="ratio === r.value ? 'border-gray-950 bg-gray-950 text-white' : 'border-gray-200 text-gray-600 hover:border-gray-400'"
                                    class="rounded-full border px-3.5 py-1.5 text-xs font-semibold transition" :title="r.hint">
                                <span x-text="r.label"></span>
                            </button>
                        </template>
                    </div>

                    <div x-show="ratio" x-cloak class="mt-3 flex items-center gap-3 text-xs">
                        <span class="text-gray-500">Keep my</span>
                        <div class="flex rounded-lg bg-gray-100 p-0.5 font-semibold">
                            <button type="button" @click="lock = 'width'" :class="lock === 'width' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500'" class="rounded-md px-3 py-1.5">width</button>
                            <button type="button" @click="lock = 'height'" :class="lock === 'height' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500'" class="rounded-md px-3 py-1.5">height</button>
                        </div>
                    </div>
                </div>

            </div>


            <div x-show="error" x-cloak class="flex items-start gap-2 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <i data-lucide="circle-alert" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <span x-text="error"></span>
            </div>

            <button type="submit" :disabled="loading"
                    class="flex w-full items-center justify-center gap-2 rounded-full bg-brand-600 px-6 py-4 text-base font-semibold text-white shadow-lg shadow-brand-900/20 transition hover:bg-brand-500 disabled:opacity-60">
                <svg x-show="loading" x-cloak class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"/><path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"/></svg>
                <span x-show="!loading" class="inline-flex"><i data-lucide="calculator" class="h-5 w-5"></i></span>
                <span x-text="loading ? 'Calculating…' : 'Calculate My LED Wall'"></span>
            </button>

        </form>


        {{-- ---------------- Results ---------------- --}}
        <div id="led-results" class="min-w-0 scroll-mt-28">

            {{-- Empty state --}}
            <div x-show="!result" class="brand-dots relative overflow-hidden rounded-3xl bg-gray-950 p-8 text-white sm:p-10">

                <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>

                <div class="relative">

                    <div class="mx-auto aspect-[16/9] max-w-md overflow-hidden rounded-xl border border-white/10 bg-gradient-to-br from-brand-700 via-brand-900 to-gray-900 p-1">
                        <div class="grid h-full w-full grid-cols-8 grid-rows-4 gap-px opacity-80">
                            @for ($i = 0; $i < 32; $i++)
                                <div class="bg-white/[0.06]"></div>
                            @endfor
                        </div>
                    </div>

                    <h2 class="mt-8 text-center text-2xl font-bold tracking-tight">Your LED wall preview appears here</h2>

                    <p class="mx-auto mt-3 max-w-md text-center text-sm leading-6 text-gray-400">
                        Fill in the three steps and press <span class="font-semibold text-white">Calculate</span>. You&rsquo;ll get a to-scale drawing,
                        exact size, resolution, power, weight and the best viewing distance.
                    </p>

                    <div class="mt-8 grid gap-3 sm:grid-cols-3">
                        @foreach ([
                            ['grid-3x3', 'Exact module layout', 'Built from real module sizes — no guesswork.'],
                            ['ruler', 'Always fits', 'Never larger than the space you enter.'],
                            ['eye', 'Viewing guidance', 'Where your audience should stand.'],
                        ] as [$icon, $title, $text])
                            <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                <i data-lucide="{{ $icon }}" class="h-5 w-5 text-brand-400"></i>
                                <p class="mt-3 text-sm font-semibold">{{ $title }}</p>
                                <p class="mt-1 text-xs leading-5 text-gray-400">{{ $text }}</p>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>


            {{-- Result --}}
            <div x-show="result" x-cloak class="space-y-5">

                <div class="overflow-hidden rounded-3xl border border-gray-200 bg-white">

                    {{-- Scenario tabs --}}
                    <div x-show="scenarioKeys.length > 1" class="flex gap-1 border-b border-gray-200 bg-gray-50 p-1.5">
                        <template x-for="key in scenarioKeys" :key="key">
                            <button type="button" @click="active = key"
                                    :class="active === key ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-800'"
                                    class="flex-1 rounded-lg px-3 py-2 text-sm font-semibold transition"
                                    x-text="key === 'recommended' ? 'Largest fit' : 'Closest to ' + ratio"></button>
                        </template>
                    </div>

                    <div class="p-5 sm:p-7" x-show="sc">

                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <span class="rounded-full bg-brand-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-wider text-brand-700"
                                      x-text="active === 'recommended' ? 'Recommended wall' : 'Aspect-ratio match'"></span>
                                <p class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                                    <span x-text="len(sc?.wall_width_mm)"></span>
                                    <span class="text-gray-300">&times;</span>
                                    <span x-text="len(sc?.wall_height_mm)"></span>
                                </p>
                                <p class="mt-1.5 text-sm text-gray-500">
                                    <span x-text="altLen(sc?.wall_width_mm) + ' × ' + altLen(sc?.wall_height_mm)"></span>
                                    &middot;
                                    <span x-text="result?.module?.name"></span>
                                </p>
                            </div>

                            <div class="rounded-2xl bg-gray-950 px-4 py-3 text-right text-white">
                                <p class="text-[11px] uppercase tracking-wider text-gray-400">Diagonal</p>
                                <p class="text-2xl font-bold" x-text="sc ? Math.round(sc.diagonal_in) + '″' : ''"></p>
                            </div>
                        </div>

                        {{-- To-scale preview --}}
                        <div class="mt-6 overflow-hidden rounded-2xl border border-gray-100 bg-gradient-to-b from-gray-50 to-white p-3 sm:p-5">
                            <div class="w-full" x-html="sc ? previewSvg(sc) : ''"></div>
                            <div class="mt-3 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-gray-500">
                                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded-sm bg-gradient-to-br from-brand-500 to-brand-800"></span> LED wall</span>
                                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-3 rounded-sm border border-dashed border-gray-400"></span> Your space</span>
                                <span class="inline-flex items-center gap-1.5"><span class="h-3 w-1.5 rounded-sm bg-gray-400"></span> 1.7 m person for scale</span>
                            </div>
                        </div>

                        {{-- Fit note --}}
                        <div class="mt-4 flex items-start gap-2 rounded-xl px-4 py-3 text-sm"
                             :class="fits ? 'bg-emerald-50 text-emerald-800' : 'bg-amber-50 text-amber-800'">
                            <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path x-show="fits" d="M20 6 9 17l-5-5"/>
                                <path x-show="!fits" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                            </svg>
                            <span x-text="fitNote"></span>
                        </div>

                        {{-- Metrics --}}
                        <dl class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            <template x-for="item in metrics" :key="item.k">
                                <div class="rounded-2xl bg-gray-50 p-4">
                                    <dt class="text-[11px] font-semibold uppercase tracking-wider text-gray-500" x-text="item.k"></dt>
                                    <dd class="mt-1.5 text-lg font-bold leading-tight text-gray-900" x-text="item.v"></dd>
                                    <dd class="mt-0.5 text-xs text-gray-500" x-text="item.s"></dd>
                                </div>
                            </template>
                        </dl>

                        {{-- Viewing distance --}}
                        <div class="mt-6 rounded-2xl border border-gray-200 p-5">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-gray-900">Viewing distance</p>
                                <p class="text-xs text-gray-500">Where your audience should stand</p>
                            </div>

                            <div class="relative mt-5 h-2.5 rounded-full bg-gradient-to-r from-amber-300 via-emerald-400 to-emerald-500">
                                <div class="absolute inset-y-0 left-0 rounded-l-full bg-gray-200" :style="`width: ${viewing.minPct}%`"></div>
                                <div class="absolute -top-1.5 h-5 w-1 -translate-x-1/2 rounded-full bg-gray-900" :style="`left: ${viewing.optPct}%`"></div>
                                <div x-show="viewing.userPct !== null" class="absolute -top-2 h-6 w-6 -translate-x-1/2 rounded-full border-4 border-white bg-brand-600 shadow" :style="`left: ${viewing.userPct}%`"></div>
                            </div>

                            <div class="mt-4 grid grid-cols-3 gap-3 text-center text-xs">
                                <div>
                                    <p class="font-semibold uppercase tracking-wider text-gray-500">Minimum</p>
                                    <p class="mt-1 text-base font-bold text-gray-900" x-text="distLabel(sc?.viewing_distance?.min_m)"></p>
                                </div>
                                <div>
                                    <p class="font-semibold uppercase tracking-wider text-gray-500">Best</p>
                                    <p class="mt-1 text-base font-bold text-emerald-600" x-text="distLabel(sc?.viewing_distance?.optimal_m)"></p>
                                </div>
                                <div>
                                    <p class="font-semibold uppercase tracking-wider text-gray-500">Readable up to</p>
                                    <p class="mt-1 text-base font-bold text-gray-900" x-text="distLabel(sc?.viewing_distance?.max_m)"></p>
                                </div>
                            </div>

                            <p x-show="viewing.userPct !== null" class="mt-4 text-xs text-gray-600" x-text="viewing.note"></p>
                        </div>

                        {{-- Content tip --}}
                        <div class="mt-4 flex items-start gap-3 rounded-2xl bg-gray-950 p-5 text-white">
                            <i data-lucide="clapperboard" class="mt-0.5 h-5 w-5 shrink-0 text-brand-400"></i>
                            <p class="text-sm leading-6 text-gray-300">
                                Design your videos and slides at
                                <span class="font-semibold text-white" x-text="sc ? sc.pixel_width + ' × ' + sc.pixel_height + ' px' : ''"></span>
                                so every pixel maps 1:1 to an LED &mdash; no stretching or blur.
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Budget + next steps --}}
                <div class="grid gap-5 md:grid-cols-2">

                    <div class="rounded-3xl border border-gray-200 bg-white p-6">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Indicative screen budget</p>

                        <template x-if="sc && sc.estimate_inr">
                            <div>
                                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900" x-text="'₹' + Number(sc.estimate_inr).toLocaleString('en-IN')"></p>
                                <p class="mt-1 text-xs text-gray-500" x-text="sc.area_sqft + ' sq ft × list price per sq ft'"></p>
                            </div>
                        </template>

                        <template x-if="!(sc && sc.estimate_inr)">
                            <p class="mt-2 text-lg font-semibold text-gray-900">Price on request</p>
                        </template>

                        <p class="mt-4 text-xs leading-5 text-gray-500">
                            LED panels only. Controller, mounting structure, installation, taxes and freight are quoted
                            separately after a site survey.
                        </p>

                        <a x-show="result?.module?.product_url" :href="result?.module?.product_url"
                           class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-600 hover:text-brand-700 hover:underline">
                            View module details
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    </div>

                    <div class="brand-dots relative overflow-hidden rounded-3xl bg-gray-950 p-6 text-white">
                        <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>

                        <p class="relative text-xs font-semibold uppercase tracking-wider text-brand-400">Next step</p>
                        <p class="relative mt-2 text-xl font-bold">Get an exact quote for this wall</p>
                        <p class="relative mt-2 text-sm leading-6 text-gray-400">
                            Our engineers will confirm the layout, structure and controller &mdash; free, no obligation.
                        </p>

                        <div class="relative mt-5 flex flex-col gap-2.5 sm:flex-row md:flex-col xl:flex-row">
                            <a :href="quoteUrl"
                               class="inline-flex flex-1 items-center justify-center gap-2 rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-500">
                                <i data-lucide="file-text" class="h-4 w-4"></i>
                                Request a Demo
                            </a>
                            <a :href="whatsappUrl" target="_blank" rel="noopener noreferrer"
                               class="inline-flex flex-1 items-center justify-center gap-2 rounded-full border border-white/20 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                                <i data-lucide="message-circle" class="h-4 w-4"></i>
                                WhatsApp
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     GUIDE
========================================================= --}}
<section class="bg-white py-16" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="max-w-2xl">
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Buying Guide</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Understanding your <span class="text-brand-600">results</span></h2>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ([
                ['scan', 'Pixel pitch (P)', 'The gap between LEDs in millimetres. A smaller number means a sharper picture up close — P1.86 for a boardroom, P10 for a highway billboard. Rule of thumb: the closest viewer should be at least 1 metre away for every 1 mm of pitch.'],
                ['sun', 'Brightness (nits)', 'Indoor screens need 600–1,000 nits to look vivid without glare. Outdoor screens need 5,000+ nits to stay readable in direct sunlight, plus IP65 weatherproofing.'],
                ['boxes', 'Modules & cabinets', 'An LED wall is built from small modules mounted in cabinets. Your wall size is always a whole number of modules, so the screen may be slightly smaller than the space you have.'],
            ] as [$icon, $title, $text])
                <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-600 text-white">
                        <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                    </div>
                    <h3 class="mt-5 font-semibold text-gray-900">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-6 text-gray-600">{{ $text }}</p>
                </div>
            @endforeach
        </div>

        @if ($category)
            <div class="mt-10 text-center">
                <a href="{{ route('store.category', $category) }}"
                   class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-800 transition hover:border-brand-600 hover:text-brand-700">
                    Browse all LED video walls
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>
            </div>
        @endif

    </div>

</section>


@push('scripts')
<script>
window.ledCalc = function (modules, preselectId, endpoint) {
    const MM = { mm: 1, m: 1000, ft: 304.8, in: 25.4 };

    return {
        modules,
        env: 'indoor',
        moduleId: null,
        distance: '',
        unit: 'ft',
        width: '',
        height: '',
        ratio: '',
        lock: 'width',
        loading: false,
        error: '',
        result: null,
        active: 'recommended',
        space: { w: 0, h: 0 },
        request: null,

        placeholders: { ft: ['12', '7'], m: ['3.6', '2.1'], mm: ['3600', '2100'], in: ['144', '84'] },
        ratios: [
            { value: '', label: 'Any', hint: 'Use as much of the space as possible' },
            { value: '16:9', label: '16:9', hint: 'Widescreen video' },
            { value: '4:3', label: '4:3', hint: 'Presentations' },
            { value: '21:9', label: '21:9', hint: 'Ultra-wide / stage' },
            { value: '1:1', label: '1:1', hint: 'Square' },
            { value: '9:16', label: '9:16', hint: 'Portrait / signage' },
        ],

        init() {
            const pre = this.modules.find((m) => m.id === preselectId);
            if (pre) {
                this.env = pre.environment;
                this.moduleId = pre.id;
            }
            this.$watch('env', () => {
                if (this.module && this.module.environment !== this.env) this.moduleId = null;
            });
        },

        get filtered() { return this.modules.filter((m) => m.environment === this.env); },
        get module() { return this.modules.find((m) => m.id === this.moduleId) || null; },
        get distanceUnit() { return ['ft', 'in'].includes(this.unit) ? 'ft' : 'm'; },
        get distanceM() {
            const d = parseFloat(this.distance);
            if (!d || d <= 0) return null;
            return this.distanceUnit === 'ft' ? d * 0.3048 : d;
        },

        // The coarsest pitch that still looks seamless at the viewer's distance (1 mm pitch per 1 m).
        get bestValueId() {
            const d = this.distanceM;
            if (!d) return null;
            const ok = this.filtered.filter((m) => m.pixel_pitch && m.pixel_pitch <= d);
            if (!ok.length) return null;
            return ok.reduce((a, b) => (b.pixel_pitch > a.pixel_pitch ? b : a)).id;
        },
        tooClose(m) { return !!this.distanceM && m.pixel_pitch > this.distanceM; },

        get scenarioKeys() { return this.result ? Object.keys(this.result.suggestions) : []; },
        get sc() { return this.result ? this.result.suggestions[this.active] || null : null; },

        trim(n) { return String(parseFloat(n)); },

        len(mm) {
            if (!mm) return '';
            switch (this.unit) {
                case 'mm': return Math.round(mm).toLocaleString('en-IN') + ' mm';
                case 'm': return (mm / 1000).toFixed(2) + ' m';
                case 'in': return Math.round(mm / 25.4) + '″';
                default: return this.feetInches(mm);
            }
        },
        altLen(mm) {
            if (!mm) return '';
            return ['ft', 'in'].includes(this.unit) ? (mm / 1000).toFixed(2) + ' m' : this.feetInches(mm);
        },
        feetInches(mm) {
            let ft = Math.floor(mm / 304.8);
            let inch = Math.round((mm - ft * 304.8) / 25.4);
            if (inch === 12) { ft += 1; inch = 0; }
            return ft + '′ ' + inch + '″';
        },
        distLabel(m) {
            if (m === undefined || m === null || isNaN(m)) return '';
            if (this.distanceUnit === 'ft') return (m / 0.3048).toFixed(m < 3 ? 1 : 0) + ' ft';
            return (m < 10 ? parseFloat(m.toFixed(1)) : Math.round(m)) + ' m';
        },

        async calculate() {
            this.error = '';
            if (!this.moduleId) { this.error = 'Please choose an LED module in step 2.'; return; }
            const w = parseFloat(this.width), h = parseFloat(this.height);
            if (!(w > 0) || !(h > 0)) { this.error = 'Please enter both the width and the height of your wall space.'; return; }

            this.loading = true;
            try {
                const res = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        module_id: this.moduleId, width: w, height: h, unit: this.unit,
                        aspect_ratio: this.ratio || null, lock_axis: this.ratio ? this.lock : null,
                    }),
                });
                const data = await res.json();
                if (!res.ok) {
                    this.error = data.error || Object.values(data.errors || {})[0]?.[0] || 'Something went wrong. Please try again.';
                    return;
                }
                this.space = { w: w * MM[this.unit], h: h * MM[this.unit] };
                this.request = { w, h, unit: this.unit, ratio: this.ratio };
                this.result = data;
                this.active = data.suggestions.aspect_match && this.ratio ? 'aspect_match' : 'recommended';
                this.$nextTick(() => document.getElementById('led-results').scrollIntoView({ behavior: 'smooth', block: 'start' }));
            } catch (e) {
                this.error = 'Could not reach the calculator. Please check your connection and try again.';
            } finally {
                this.loading = false;
            }
        },

        get fits() {
            const sc = this.sc;
            return !!sc && sc.wall_width_mm <= this.space.w + 0.5 && sc.wall_height_mm <= this.space.h + 0.5;
        },
        get fitNote() {
            const sc = this.sc;
            if (!sc) return '';
            if (!this.fits) {
                return 'Your space is smaller than a single module, so the smallest possible wall is shown. Try a bigger space or a smaller-pitch module.';
            }
            const spareW = this.space.w - sc.wall_width_mm, spareH = this.space.h - sc.wall_height_mm;
            const fmt = (mm) => (['ft', 'in'].includes(this.unit) ? Math.round(mm / 25.4) + '″' : Math.round(mm / 10) + ' cm');
            if (spareW < 5 && spareH < 5) return 'A perfect fit — the wall uses your full space.';
            return `Fits your space with ${fmt(spareW)} to spare in width and ${fmt(spareH)} in height — handy for the frame and trims.`;
        },

        get metrics() {
            const sc = this.sc, m = this.result?.module;
            if (!sc || !m) return [];
            const px = sc.pixel_width * sc.pixel_height;
            const grade = sc.pixel_width >= 3840 && sc.pixel_height >= 2160 ? '4K UHD or better'
                : sc.pixel_width >= 1920 && sc.pixel_height >= 1080 ? 'Full HD or better'
                : sc.pixel_width >= 1280 && sc.pixel_height >= 720 ? 'HD class' : (px / 1e6).toFixed(2) + ' megapixels';
            const list = [
                { k: 'Resolution', v: sc.pixel_width + ' × ' + sc.pixel_height, s: grade },
                { k: 'Screen area', v: sc.area_sqft + ' sq ft', s: sc.area_m2 + ' m²' },
                { k: 'LED modules', v: sc.total_tiles.toLocaleString('en-IN'), s: sc.tiles_x + ' across × ' + sc.tiles_y + ' high' },
            ];
            // Cabinet count is whole cabinets only (ERP rule); say so when the wall has partial-cabinet edges.
            const cabExact = sc.total_cabinets
                && Math.abs(sc.wall_width_mm - sc.cabinets_x * m.cabinet_w_mm) < 1
                && Math.abs(sc.wall_height_mm - sc.cabinets_y * m.cabinet_h_mm) < 1;
            const cabSize = this.trim(m.cabinet_w_mm) + '×' + this.trim(m.cabinet_h_mm) + ' mm';
            list.push(!sc.total_cabinets
                ? { k: 'Cabinets', v: '—', s: 'Confirmed at site survey' }
                : cabExact
                    ? { k: 'Cabinets', v: sc.total_cabinets, s: sc.cabinets_x + ' × ' + sc.cabinets_y + ' of ' + cabSize }
                    : { k: 'Cabinets', v: sc.total_cabinets + '+', s: sc.cabinets_x + ' × ' + sc.cabinets_y + ' full ' + cabSize + ' + edge modules' });
            if (sc.power_max_kw) list.push({ k: 'Power', v: sc.power_avg_kw + ' kW avg', s: 'up to ' + sc.power_max_kw + ' kW peak' });
            if (sc.weight_kg) list.push({ k: 'Module weight', v: '≈ ' + Math.round(sc.weight_kg).toLocaleString('en-IN') + ' kg', s: 'excl. cabinets & structure' });
            if (m.brightness_nits) list.push({ k: 'Brightness', v: Number(m.brightness_nits).toLocaleString('en-IN') + ' nits', s: m.environment === 'outdoor' ? 'sunlight readable' : 'indoor optimised' });
            if (m.refresh_rate) list.push({ k: 'Refresh rate', v: m.refresh_rate, s: 'flicker-free on camera' });
            return list;
        },

        get viewing() {
            const vd = this.sc?.viewing_distance;
            if (!vd) return { minPct: 0, optPct: 0, userPct: null, note: '' };
            const d = this.distanceM;
            const scale = Math.max(vd.optimal_m * 2.5, d ? d * 1.15 : 0);
            const pct = (x) => Math.min(100, Math.max(0, (x / scale) * 100));
            let note = '';
            if (d) {
                note = d < vd.min_m
                    ? `At ${this.distLabel(d)} viewers may notice individual pixels — choose a smaller pixel pitch for a seamless picture.`
                    : d < vd.optimal_m
                        ? `At ${this.distLabel(d)} the picture looks seamless. It looks its very best from ${this.distLabel(vd.optimal_m)}.`
                        : `At ${this.distLabel(d)} your audience gets a crisp, seamless picture.`;
            }
            return { minPct: pct(vd.min_m), optPct: pct(vd.optimal_m), userPct: d ? pct(d) : null, note };
        },

        get summary() {
            const sc = this.sc, m = this.result?.module;
            if (!sc || !m) return '';
            return [
                'LED wall enquiry (from the website calculator)',
                `Module: ${m.name} (${m.environment})`,
                `Available space: ${this.request.w} × ${this.request.h} ${this.request.unit}` + (this.request.ratio ? `, shape ${this.request.ratio}` : ''),
                `Suggested wall: ${this.feetInches(sc.wall_width_mm)} × ${this.feetInches(sc.wall_height_mm)} (${sc.wall_width_mm} × ${sc.wall_height_mm} mm)`,
                `Layout: ${sc.tiles_x} × ${sc.tiles_y} = ${sc.total_tiles} modules` + (sc.total_cabinets ? `, ${sc.total_cabinets} cabinets` : ''),
                `Resolution: ${sc.pixel_width} × ${sc.pixel_height} px · Area: ${sc.area_sqft} sq ft`,
            ].join('\n');
        },
        get quoteUrl() {
            const q = new URLSearchParams({ category: 'led-video-walls', purpose: 'business', message: this.summary });
            return @js(route('store.demo.create')) + '?' + q.toString();
        },
        get whatsappUrl() {
            return 'https://wa.me/919842881500?text=' + encodeURIComponent('Hi Yara, I would like a quote for this LED wall.\n\n' + this.summary);
        },

        // To-scale drawing: the user's space (dashed), the LED wall with its module grid, and a person for scale.
        previewSvg(sc) {
            const m = this.result.module;
            const W = sc.wall_width_mm, H = sc.wall_height_mm;
            const SW = Math.max(this.space.w, W), SH = Math.max(this.space.h, H);
            const person = 1700, personW = 480;
            const floor = Math.max(SH, person);
            const unitSize = Math.max(SW, floor);
            const fs = unitSize * 0.034;
            const pad = unitSize * 0.05;
            const gap = Math.max(personW * 0.8, unitSize * 0.04);

            const spaceX = 0, spaceY = floor - this.space.h;
            const wx = (this.space.w - W) / 2, wy = spaceY + (this.space.h - H) / 2;

            const vbX = -(personW + gap + pad);
            const vbY = Math.min(spaceY, wy) - fs * 2.6;
            const vbW = SW - vbX + pad + fs * 6.5;
            const vbH = floor - vbY + pad;

            let grid = '';
            const dense = sc.tiles_x > 64 || sc.tiles_y > 64;
            const stepX = dense && m.cabinet_w_mm ? m.cabinet_w_mm : m.length_mm;
            const stepY = dense && m.cabinet_h_mm ? m.cabinet_h_mm : m.height_mm;
            if (!dense || m.cabinet_w_mm) {
                for (let x = wx + stepX; x < wx + W - 1; x += stepX) grid += `M${x} ${wy}V${wy + H}`;
                for (let y = wy + stepY; y < wy + H - 1; y += stepY) grid += `M${wx} ${y}H${wx + W}`;
            }

            const px = vbX + pad, py = floor;
            const s = person / 1700;
            const personPath = `M${px + 270 * s} ${py - 1700 * s} a${110 * s} ${110 * s} 0 1 1 0.1 0 Z`
                + `M${px + 90 * s} ${py - 1450 * s} h${300 * s} a${60 * s} ${60 * s} 0 0 1 ${60 * s} ${60 * s} v${560 * s} h-${70 * s} v${830 * s} h-${120 * s} v-${520 * s} h-${40 * s} v${520 * s} h-${120 * s} v-${830 * s} h-${70 * s} v-${560 * s} a${60 * s} ${60 * s} 0 0 1 ${60 * s} -${60 * s} Z`;

            const label = (x, y, text, anchor = 'middle', extra = '') =>
                `<text x="${x}" y="${y}" font-size="${fs}" font-weight="600" fill="#414042" text-anchor="${anchor}" ${extra}>${text}</text>`;

            return `<svg viewBox="${vbX} ${vbY} ${vbW} ${vbH}" class="h-auto w-full max-h-[420px]" role="img" aria-label="To-scale preview of the LED wall" font-family="Poppins, sans-serif">
                <defs>
                    <linearGradient id="ledFill" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0" stop-color="#e24a63"/><stop offset=".45" stop-color="#a51d35"/><stop offset="1" stop-color="#33070f"/>
                    </linearGradient>
                    <radialGradient id="ledGlow" cx=".3" cy=".25" r=".8">
                        <stop offset="0" stop-color="#fff" stop-opacity=".35"/><stop offset="1" stop-color="#fff" stop-opacity="0"/>
                    </radialGradient>
                </defs>
                <line x1="${vbX}" y1="${floor}" x2="${vbX + vbW}" y2="${floor}" stroke="#d1d2d4" stroke-width="2" vector-effect="non-scaling-stroke"/>
                <rect x="${spaceX}" y="${spaceY}" width="${this.space.w}" height="${this.space.h}" fill="#f6f6f7" stroke="#a7a9ac" stroke-width="1.5" stroke-dasharray="6 5" vector-effect="non-scaling-stroke"/>
                <rect x="${wx}" y="${wy}" width="${W}" height="${H}" fill="url(#ledFill)"/>
                <rect x="${wx}" y="${wy}" width="${W}" height="${H}" fill="url(#ledGlow)"/>
                <path d="${grid}" stroke="#000" stroke-opacity=".28" stroke-width="1" vector-effect="non-scaling-stroke" fill="none"/>
                <rect x="${wx}" y="${wy}" width="${W}" height="${H}" fill="none" stroke="#1b1919" stroke-width="2.5" vector-effect="non-scaling-stroke"/>
                <text x="${wx + W / 2}" y="${wy + H / 2}" font-size="${Math.min(H * 0.28, W * 0.16)}" font-weight="700" fill="#fff" fill-opacity=".92" text-anchor="middle" dominant-baseline="central">yara</text>
                <path d="${personPath}" fill="#a7a9ac"/>
                <line x1="${wx}" y1="${wy - fs * 1.2}" x2="${wx + W}" y2="${wy - fs * 1.2}" stroke="#414042" stroke-width="1.2" vector-effect="non-scaling-stroke"/>
                <line x1="${wx}" y1="${wy - fs * 1.6}" x2="${wx}" y2="${wy - fs * 0.8}" stroke="#414042" stroke-width="1.2" vector-effect="non-scaling-stroke"/>
                <line x1="${wx + W}" y1="${wy - fs * 1.6}" x2="${wx + W}" y2="${wy - fs * 0.8}" stroke="#414042" stroke-width="1.2" vector-effect="non-scaling-stroke"/>
                ${label(wx + W / 2, wy - fs * 1.6, this.len(W))}
                <line x1="${wx + W + fs * 0.9}" y1="${wy}" x2="${wx + W + fs * 0.9}" y2="${wy + H}" stroke="#414042" stroke-width="1.2" vector-effect="non-scaling-stroke"/>
                ${label(wx + W + fs * 1.4, wy + H / 2, this.len(H), 'start', 'dominant-baseline="central"')}
            </svg>`;
        },
    };
};
</script>
@endpush

@endsection
