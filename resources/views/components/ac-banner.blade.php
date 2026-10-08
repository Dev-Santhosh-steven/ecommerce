{{--
    Air-conditioner category banner: the Yara inverter split AC (indoor unit high on the wall, outdoor unit below)
    with soft cool air flowing from the louvre and the room temperature settling from 30° to 24° on load.
    Calm by design: slow, low-contrast motion only.

    <x-ac-banner :category="$category" />   (air-conditioners, inverter-ac)
--}}
@props(['category'])

@php
    $img = fn ($f) => asset("storage/products/air-conditioners/banner/{$f}.webp");
    $eyebrow = 'Inverter split ACs · 1, 1.5 & 2 ton · 3 & 5 star';
@endphp

<div {{ $attributes->merge(['class' => 'ac-banner absolute inset-0 isolate overflow-hidden']) }} aria-hidden="true">

    {{-- Cool room light --}}
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_65%_85%_at_74%_30%,#123a63_0%,#0b2240_42%,#08111f_75%,#0a0a0f_100%)]"></div>
    <div class="about-grid absolute inset-0 opacity-25"></div>

    {{-- The split AC, fitted into the right of the banner --}}
    <div class="absolute bottom-[6%] right-[4%] top-[10%] w-[78%] sm:w-[56%] lg:w-[42%] xl:w-[40%]">

        {{-- Indoor unit on the wall --}}
        <div class="ac-unit absolute right-0 top-0 w-[78%]">
            <img src="{{ $img('indoor') }}" alt="" class="relative block w-full drop-shadow-[0_24px_30px_rgba(0,0,0,0.45)]" draggable="false">

            {{-- Display: settles from 30 to 24 (drawn in the photo's own 900 x 291 coordinates, so it scales with it) --}}
            <svg class="pointer-events-none absolute inset-0 h-full w-full" viewBox="0 0 900 291">
                <text x="442" y="124" text-anchor="end" font-size="31" font-weight="600" fill="#ffffff" fill-opacity="0.92"
                      style="font-variant-numeric: tabular-nums; filter: drop-shadow(0 0 3px rgb(186 230 253 / 0.9))" data-ac-temp>24</text>
            </svg>

            {{-- Cool air from the louvre: a soft haze drifting down and fading --}}
            <svg class="pointer-events-none absolute left-[3%] top-[88%] h-[150%] w-[94%]" viewBox="0 0 400 200" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="ac-air" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0" stop-color="#e0f2fe" stop-opacity="0.5"/>
                        <stop offset="0.6" stop-color="#7dd3fc" stop-opacity="0.12"/>
                        <stop offset="1" stop-color="#7dd3fc" stop-opacity="0"/>
                    </linearGradient>
                    <filter id="ac-soft" x="-20%" y="-20%" width="140%" height="140%"><feGaussianBlur stdDeviation="7"/></filter>
                </defs>
                @foreach ([0, 1.5, 3] as $d)
                    <path class="ac-air" style="animation-delay: -{{ $d }}s" filter="url(#ac-soft)"
                          d="M 18 0 L 382 0 C 392 60, 360 130, 380 200 L 20 200 C 40 130, 8 60, 18 0 Z" fill="url(#ac-air)"/>
                @endforeach
            </svg>
        </div>

        {{-- Outdoor unit --}}
        <div class="ac-unit is-late absolute bottom-0 left-[4%] w-[40%]">
            <img src="{{ $img('outdoor') }}" alt="" class="relative block w-full drop-shadow-[0_20px_24px_rgba(0,0,0,0.5)]" draggable="false">
            <span class="absolute -bottom-2 left-[6%] right-[6%] h-4 rounded-full bg-black/55 blur-md"></span>
        </div>

    </div>

    {{-- Below desktop width the title runs over the units: darken the left so it stays readable --}}
    <div class="absolute inset-0 bg-gradient-to-r from-[#0a0a0f]/90 via-[#0a0a0f]/55 via-50% to-transparent lg:hidden"></div>

</div>

@push('category-banner-text')
    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.25em] text-sky-300">{{ $eyebrow }}</p>
@endpush

@once
    @push('styles')
        <style>
            .ac-unit { animation: ac-in 1s cubic-bezier(0.16, 1, 0.3, 1) 0.1s both; }
            .ac-unit.is-late { animation-delay: 0.3s; }
            @keyframes ac-in { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: none; } }

            .ac-air { transform-origin: top center; animation: ac-air 4.5s ease-out infinite; }
            @keyframes ac-air {
                0% { transform: translateY(-14%) scaleY(0.55); opacity: 0; }
                30% { opacity: 0.75; }
                100% { transform: translateY(18%) scaleY(1.05); opacity: 0; }
            }

            @media (prefers-reduced-motion: reduce) {
                .ac-unit, .ac-air { animation: none; }
                .ac-air { opacity: 0.35; }
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            // The room cools down: the display counts from 30 to 24 once.
            document.querySelectorAll('[data-ac-temp]').forEach((el) => {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                let t = 30;
                el.textContent = t;
                setTimeout(function step() {
                    el.textContent = --t;
                    if (t > 24) setTimeout(step, 380);
                }, 1300);
            });
        </script>
    @endpush
@endonce
