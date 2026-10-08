{{--
    Animated washing-machine category banner: real Yara machines on a deep-water stage, a wave of water sweeping
    behind them, bubbles rising, caustic light rippling and (for front loaders) water spinning in the drum.

    <x-wash-banner :category="$category" />   (washing-machine, fully_automatic, semi-automatic, only-washer)
--}}
@props(['category'])

@php
    $img = fn ($f) => asset("storage/products/washing-machines/banner/{$f}.webp");

    // Each page: its machines (left to right, centre one in front) and a tagline.
    // drum: where the front loader's door glass sits, in % of that image.
    $scenes = [
        'washing-machine' => [
            'eyebrow' => 'Front load · Top load · Semi automatic',
            'line' => 'Cleaner clothes, every wash.',
            'machines' => [['wf80j1gb', 'drum'], ['wa10k1bs'], ['wt70c1mt']],
        ],
        'fully_automatic' => [
            'eyebrow' => 'Front load & top load · 6.5 kg to 10 kg',
            'line' => 'Load it. Start it. Done.',
            'machines' => [['wa65k1rr'], ['wf80j1gb', 'drum'], ['wa10k1bs']],
        ],
        'semi-automatic' => [
            'eyebrow' => 'Twin tub · 7 kg to 11 kg',
            'line' => 'Wash in one tub. Spin dry in the other.',
            'machines' => [['wt80c1bt'], ['wt70c1mt'], ['wt11k1pf']],
        ],
        'only-washer' => [
            'eyebrow' => 'Wash-only · 6.5 kg',
            'line' => 'Compact. Powerful. Easy on water.',
            'machines' => [['ws65k1pf']],
        ],
    ];
    $scene = $scenes[$category->slug] ?? $scenes['washing-machine'];
    $count = count($scene['machines']);

    // Width / height of each cut-out, so the row of machines keeps its shape while it scales.
    $aspect = ['wf80j1gb' => 0.725, 'wa10k1bs' => 0.639, 'wa65k1rr' => 0.609, 'wt70c1mt' => 0.829, 'wt11k1pf' => 0.870, 'ws65k1pf' => 0.698, 'wt80c1bt' => 0.821];
    $rowRatio = collect($scene['machines'])->sum(fn ($m, $i) => $aspect[$m[0]] * (($count === 1 || $i === 1) ? 1 : 0.84 * 0.96));
@endphp

<div {{ $attributes->merge(['class' => 'wash-banner absolute inset-0 isolate overflow-hidden']) }} aria-hidden="true">

    {{-- Deep water --}}
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_70%_90%_at_72%_40%,#0c4a8a_0%,#062a55_38%,#04142c_70%,#0a0a0f_100%)]"></div>
    <div class="wash-caustics absolute inset-0 opacity-40"></div>

    {{-- A wave of water sweeping behind the machines --}}
    <svg class="absolute inset-y-0 right-0 h-full w-[70%]" viewBox="0 0 1000 440" preserveAspectRatio="none">
        <defs>
            <linearGradient id="wash-wave" x1="0" y1="0" x2="1" y2="0">
                <stop offset="0" stop-color="#38bdf8" stop-opacity="0"/>
                <stop offset="0.45" stop-color="#7dd3fc" stop-opacity="0.55"/>
                <stop offset="1" stop-color="#e0f2fe" stop-opacity="0.15"/>
            </linearGradient>
        </defs>
        <path class="wash-wave" d="M -40 300 C 160 180, 320 380, 520 250 S 860 110, 1040 220" fill="none" stroke="url(#wash-wave)" stroke-width="26" stroke-linecap="round"/>
        <path class="wash-wave is-thin" d="M -40 330 C 180 230, 340 410, 540 290 S 880 160, 1040 260" fill="none" stroke="url(#wash-wave)" stroke-width="7" stroke-linecap="round"/>
        <path class="wash-wave is-thin is-late" d="M -40 250 C 140 150, 300 330, 500 210 S 840 70, 1040 170" fill="none" stroke="url(#wash-wave)" stroke-width="4" stroke-linecap="round"/>
    </svg>

    {{-- Rising bubbles --}}
    @foreach (range(1, 22) as $n)
        <span class="wash-bubble" style="left: {{ 42 + ($n * 37) % 56 }}%; width: {{ 5 + $n % 6 * 3 }}px; height: {{ 5 + $n % 6 * 3 }}px; animation-duration: {{ 6 + $n % 5 }}s; animation-delay: -{{ $n * 0.55 }}s"></span>
    @endforeach

    {{-- The machines --}}
    {{-- Fitted into the right of the banner: as tall as it can be without running under the title --}}
    <div class="absolute bottom-[7%] right-[3%] flex max-h-[80%] items-end justify-end sm:right-[5%] {{ $count > 1 ? 'w-[80%] sm:w-[60%] lg:w-[40%] xl:w-[50%]' : 'w-[42%] sm:w-[30%] lg:w-[20%] xl:w-[22%]' }}"
         style="aspect-ratio: {{ round($rowRatio, 3) }}">
        @foreach ($scene['machines'] as $i => $machine)
            @php [$file, $drum] = [$machine[0], ($machine[1] ?? null) === 'drum']; @endphp
            @php $front = $count === 1 || $i === 1; @endphp
            <div class="wash-machine relative shrink-0 {{ $front ? 'z-10 h-full' : 'h-[84%] -mx-[2%] opacity-95' }}"
                 style="animation-delay: {{ 0.15 + $i * 0.15 }}s">
                <img src="{{ $img($file) }}" alt="" class="relative block h-full w-auto drop-shadow-[0_30px_30px_rgba(0,0,0,0.55)]" draggable="false">
                @if ($drum)
                    {{-- Water spinning behind the door glass (the visible part above the sticker) --}}
                    <span class="absolute left-[9.9%] top-[17%] h-[30.4%] w-[81.3%] overflow-hidden">
                        <span class="absolute inset-x-0 top-0 aspect-square rounded-full">
                            <span class="wash-drum absolute inset-[6%] rounded-full"></span>
                            <span class="wash-drum is-back absolute inset-[16%] rounded-full"></span>
                        </span>
                    </span>
                @endif
                {{-- floor shadow and water reflection --}}
                <span class="absolute -bottom-3 left-[8%] right-[8%] h-6 rounded-full bg-black/60 blur-md"></span>
            </div>
        @endforeach
    </div>

    {{-- Below desktop width the title runs over the machines: darken the left so it stays readable --}}
    <div class="absolute inset-0 bg-gradient-to-r from-[#0a0a0f]/90 via-[#0a0a0f]/55 via-50% to-transparent lg:hidden"></div>

</div>

{{-- Tagline under the category title --}}
@push('wash-banner-text')
    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.25em] text-sky-300">{{ $scene['eyebrow'] }}</p>
@endpush

@once
    @push('styles')
        <style>
            .wash-caustics {
                background:
                    radial-gradient(closest-side, rgb(125 211 252 / 0.35), transparent) 0 0 / 220px 160px,
                    radial-gradient(closest-side, rgb(186 230 253 / 0.25), transparent) 110px 80px / 260px 190px;
                mix-blend-mode: screen;
                animation: wash-caustics 14s linear infinite;
            }
            @keyframes wash-caustics { to { background-position: 220px 160px, 370px 270px; } }

            .wash-wave { stroke-dasharray: 520 900; animation: wash-wave 7s ease-in-out infinite; }
            .wash-wave.is-thin { stroke-dasharray: 260 700; animation-duration: 5.5s; }
            .wash-wave.is-late { animation-delay: -2.5s; }
            @keyframes wash-wave { from { stroke-dashoffset: 1400; } to { stroke-dashoffset: 0; } }

            .wash-bubble {
                position: absolute;
                bottom: -20px;
                border-radius: 9999px;
                background: radial-gradient(circle at 35% 30%, rgb(255 255 255 / 0.95), rgb(186 230 253 / 0.35) 45%, rgb(125 211 252 / 0.1) 70%);
                box-shadow: inset 0 0 0 1px rgb(255 255 255 / 0.35);
                animation: wash-bubble linear infinite;
            }
            @keyframes wash-bubble {
                0% { transform: translate(0, 0) scale(0.6); opacity: 0; }
                10% { opacity: 1; }
                50% { transform: translate(14px, -240px) scale(1); }
                100% { transform: translate(-10px, -520px) scale(1.15); opacity: 0; }
            }

            .wash-drum {
                background: conic-gradient(from 0deg, transparent 0 8%, rgb(125 211 252 / 0.55) 14%, transparent 24% 40%, rgb(224 242 254 / 0.45) 48%, transparent 58% 72%, rgb(56 189 248 / 0.5) 80%, transparent 90%);
                mix-blend-mode: screen;
                filter: blur(3px);
                animation: wash-spin 1.6s linear infinite;
            }
            .wash-drum.is-back { animation-duration: 2.4s; animation-direction: reverse; opacity: 0.7; }
            @keyframes wash-spin { to { transform: rotate(360deg); } }

            .wash-machine { animation: wash-in 1.1s cubic-bezier(0.16, 1, 0.3, 1) both; }
            @keyframes wash-in { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: none; } }

            @media (prefers-reduced-motion: reduce) {
                .wash-caustics, .wash-wave, .wash-bubble, .wash-machine, .wash-drum { animation: none; }
                .wash-bubble { display: none; }
            }
        </style>
    @endpush
@endonce
