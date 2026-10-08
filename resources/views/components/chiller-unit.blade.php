{{--
    Clean product-style drawings of the chiller's air-distribution units, with cool air flowing out.
    Sharp at any size and brand-neutral.

    <x-chiller-unit type="ahu|split|cassette|horizontal" class="w-full" />
--}}
@props(['type'])

@php
    $id = 'cu-' . $type;
@endphp

<svg {{ $attributes->merge(['class' => 'chiller-unit']) }} viewBox="0 0 400 220" role="img" aria-label="{{ [
    'ahu' => 'Air handling unit with supply duct',
    'split' => 'Split type indoor fan coil unit on a wall',
    'cassette' => 'Four-way ceiling cassette fan coil unit',
    'horizontal' => 'One-way horizontal cassette fan coil unit in the ceiling',
][$type] }}">
    <defs>
        <linearGradient id="{{ $id }}-body" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#ffffff"/>
            <stop offset="1" stop-color="#e6ebf1"/>
        </linearGradient>
        <linearGradient id="{{ $id }}-steel" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#f1f4f7"/>
            <stop offset="0.5" stop-color="#d5dbe2"/>
            <stop offset="1" stop-color="#b9c1cb"/>
        </linearGradient>
        <linearGradient id="{{ $id }}-air" x1="0" y1="0" x2="0" y2="1">
            <stop offset="0" stop-color="#38bdf8" stop-opacity="0.9"/>
            <stop offset="1" stop-color="#7dd3fc" stop-opacity="0"/>
        </linearGradient>
        <filter id="{{ $id }}-shadow" x="-20%" y="-20%" width="140%" height="160%">
            <feDropShadow dx="0" dy="6" stdDeviation="7" flood-color="#0f172a" flood-opacity="0.16"/>
        </filter>
    </defs>

    @switch($type)

        @case('split')
            {{-- wall --}}
            <rect width="400" height="220" fill="#f6f8fb"/>
            {{-- indoor unit --}}
            <g filter="url(#{{ $id }}-shadow)">
                <rect x="70" y="34" width="260" height="74" rx="18" fill="url(#{{ $id }}-body)" stroke="#d3dae3"/>
            </g>
            <path d="M 82 88 Q 200 100 318 88" fill="none" stroke="#c7d0db" stroke-width="2"/>
            <rect x="96" y="94" width="208" height="8" rx="4" fill="#1f2937" opacity="0.85"/>
            <circle cx="300" cy="56" r="4" fill="#38bdf8"/>
            <text x="284" y="60" text-anchor="end" font-size="11" font-weight="700" fill="#64748b" font-family="inherit">24°</text>
            {{-- cool air --}}
            @foreach ([[120, 0], [165, 0.4], [210, 0.8], [255, 1.2]] as [$x, $d])
                <path class="chiller-air" style="animation-delay: -{{ $d }}s" d="M {{ $x }} 108 C {{ $x - 6 }} 140, {{ $x + 18 }} 165, {{ $x + 4 }} 205" fill="none" stroke="url(#{{ $id }}-air)" stroke-width="3" stroke-linecap="round"/>
            @endforeach
            @break

        @case('cassette')
            {{-- ceiling --}}
            <rect width="400" height="64" fill="#eef2f6"/>
            <rect y="64" width="400" height="156" fill="#f8fafc"/>
            {{-- four-way cassette panel, in perspective --}}
            <g filter="url(#{{ $id }}-shadow)">
                <path d="M 110 52 L 290 52 L 320 88 L 80 88 Z" fill="url(#{{ $id }}-body)" stroke="#d3dae3"/>
            </g>
            <path d="M 128 58 L 272 58 L 278 64 L 122 64 Z" fill="#1f2937" opacity="0.8"/>
            <path d="M 96 76 L 304 76 L 311 82 L 89 82 Z" fill="#1f2937" opacity="0.8"/>
            <path d="M 150 67 L 250 67 L 258 74 L 142 74 Z" fill="#cfd8e2"/>
            @foreach (range(0, 8) as $g)
                <line x1="{{ 156 + $g * 11 }}" y1="68" x2="{{ 152 + $g * 12 }}" y2="73" stroke="#aeb9c6" stroke-width="1"/>
            @endforeach
            {{-- air out on four sides --}}
            @foreach ([[92, 92, 40, 150, 0], [150, 92, 128, 190, 0.5], [250, 92, 272, 190, 1], [308, 92, 360, 150, 1.5]] as [$x1, $y1, $x2, $y2, $d])
                <path class="chiller-air" style="animation-delay: -{{ $d }}s" d="M {{ $x1 }} {{ $y1 }} Q {{ ($x1 + $x2) / 2 }} {{ $y1 + 20 }} {{ $x2 }} {{ $y2 }}" fill="none" stroke="url(#{{ $id }}-air)" stroke-width="3" stroke-linecap="round"/>
            @endforeach
            @break

        @case('horizontal')
            {{-- ceiling --}}
            <rect width="400" height="64" fill="#eef2f6"/>
            <rect y="64" width="400" height="156" fill="#f8fafc"/>
            {{-- one-way cassette: slim body in the ceiling, one long outlet at the front --}}
            <g filter="url(#{{ $id }}-shadow)">
                <path d="M 70 54 L 330 54 L 346 84 L 54 84 Z" fill="url(#{{ $id }}-body)" stroke="#d3dae3"/>
            </g>
            <path d="M 66 74 L 334 74 L 339 81 L 61 81 Z" fill="#1f2937" opacity="0.85"/>
            <path d="M 120 60 L 280 60 L 286 68 L 114 68 Z" fill="#dfe6ee"/>
            @foreach (range(0, 12) as $g)
                <line x1="{{ 124 + $g * 13 }}" y1="61" x2="{{ 120 + $g * 13.6 }}" y2="67" stroke="#b8c3cf" stroke-width="1"/>
            @endforeach
            {{-- air out in one direction --}}
            @foreach ([[110, 0], [170, 0.45], [230, 0.9], [290, 1.35]] as [$x, $d])
                <path class="chiller-air" style="animation-delay: -{{ $d }}s" d="M {{ $x }} 84 C {{ $x + 10 }} 120, {{ $x + 30 }} 150, {{ $x + 34 }} 200" fill="none" stroke="url(#{{ $id }}-air)" stroke-width="3" stroke-linecap="round"/>
            @endforeach
            @break

        @case('ahu')
            {{-- floor --}}
            <rect width="400" height="220" fill="#f6f8fb"/>
            <rect y="186" width="400" height="34" fill="#e9eef3"/>
            {{-- supply duct up and across --}}
            <path d="M 300 70 V 34 H 400" fill="none" stroke="url(#{{ $id }}-steel)" stroke-width="28"/>
            <path class="chiller-air is-duct" d="M 300 66 V 34 H 400" fill="none" stroke="#38bdf8" stroke-width="3" stroke-linecap="round" opacity="0.85"/>
            {{-- AHU body: sections with panels --}}
            <g filter="url(#{{ $id }}-shadow)">
                <rect x="40" y="70" width="290" height="116" rx="6" fill="url(#{{ $id }}-steel)" stroke="#a9b3bf"/>
            </g>
            @foreach ([40, 112, 184, 256] as $x)
                <rect x="{{ $x + 6 }}" y="78" width="60" height="100" rx="3" fill="none" stroke="#a9b3bf"/>
            @endforeach
            {{-- fan section --}}
            <circle cx="148" cy="128" r="30" fill="#dfe5ec" stroke="#9aa5b2"/>
            <g class="chiller-fan" style="transform-origin: 148px 128px">
                @foreach ([0, 72, 144, 216, 288] as $a)
                    <path d="M 148 128 Q 156 108 148 100 Q 140 112 148 128" fill="#8a96a4" transform="rotate({{ $a }} 148 128)"/>
                @endforeach
            </g>
            <circle cx="148" cy="128" r="5" fill="#475569"/>
            {{-- coil section: chilled-water coil --}}
            @foreach (range(0, 7) as $c)
                <line x1="{{ 196 + $c * 6 }}" y1="84" x2="{{ 196 + $c * 6 }}" y2="172" stroke="#38bdf8" stroke-width="2" opacity="0.7"/>
            @endforeach
            {{-- control panel --}}
            <rect x="268" y="90" width="36" height="26" rx="3" fill="#1f2937"/>
            <rect x="272" y="94" width="20" height="10" rx="1" fill="#38bdf8" opacity="0.8"/>
            <circle cx="298" cy="109" r="3" fill="#ef4444"/>
            {{-- base frame --}}
            <rect x="34" y="184" width="302" height="6" rx="2" fill="#64748b"/>
            @break

    @endswitch
</svg>

@once
    @push('styles')
        <style>
            .chiller-unit .chiller-air { stroke-dasharray: 10 12; animation: chiller-air 1.6s linear infinite; }
            .chiller-unit .chiller-air.is-duct { stroke-dasharray: 8 10; animation-duration: 1s; }
            .chiller-unit .chiller-fan { animation: chiller-fan 1.8s linear infinite; }
            @keyframes chiller-air { to { stroke-dashoffset: -44; } }
            @keyframes chiller-fan { to { transform: rotate(360deg); } }
            @media (prefers-reduced-motion: reduce) {
                .chiller-unit .chiller-air, .chiller-unit .chiller-fan { animation: none; }
            }
        </style>
    @endpush
@endonce
