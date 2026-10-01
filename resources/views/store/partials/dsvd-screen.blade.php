{{--
    One full-screen slide for the Double Side Vertical Display mock-ups (portrait, 570 × 1003).
    Sizes use container units (cqw) so the slide scales with the screen it sits in.
    $slide: beach | departures | news | sale | arrivals
--}}
@php
    $logo = asset('storage/products/centum/yara-logo-light.png');
@endphp

@switch($slide)

    @case('beach')
        <img src="{{ asset('storage/products/double-side-vertical-display/screen-beach.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover">
        @break

    @case('departures')
        <div class="absolute inset-0 flex flex-col bg-gradient-to-b from-[#0a1a3a] to-[#050c1d] p-[6cqw] text-white">
            <div class="flex items-center justify-between border-b border-white/15 pb-[4cqw]">
                <span class="flex items-center gap-[2.5cqw] font-display text-[7.5cqw] font-extrabold tracking-wide">
                    <i data-lucide="plane-takeoff" class="h-[8cqw] w-[8cqw] text-amber-300"></i>
                    Departures
                </span>
                <span class="font-mono text-[6cqw] font-bold text-amber-300">11<span class="dsvd-blink">:</span>47</span>
            </div>
            <div class="mt-[3cqw] grid grid-cols-[1fr_2.2fr_0.9fr] text-[3.6cqw] font-semibold uppercase tracking-wider text-white/45">
                <span>Time</span><span>Destination</span><span class="text-right">Gate</span>
            </div>
            <div class="mt-[1.5cqw] flex-1 space-y-[2.6cqw] font-mono">
                @foreach ([['12:05', 'Mumbai', 'A4', 'Boarding', 'text-emerald-300'], ['12:20', 'Delhi', 'B1', 'On time', 'text-sky-300'], ['12:35', 'Dubai', 'C7', 'On time', 'text-sky-300'], ['12:50', 'Singapore', 'C2', 'Delayed', 'text-amber-300'], ['13:10', 'Bengaluru', 'A2', 'On time', 'text-sky-300'], ['13:25', 'Kolkata', 'B6', 'Gate open', 'text-emerald-300'], ['13:40', 'London', 'D1', 'On time', 'text-sky-300']] as [$t, $city, $gate, $status, $tone])
                    <div class="rounded-[1.5cqw] bg-white/[0.06] px-[3cqw] py-[2.2cqw]">
                        <div class="grid grid-cols-[1fr_2.2fr_0.9fr] items-baseline text-[5cqw] font-bold">
                            <span class="text-amber-200">{{ $t }}</span><span class="truncate">{{ $city }}</span><span class="text-right">{{ $gate }}</span>
                        </div>
                        <p class="mt-[0.6cqw] text-right text-[3.4cqw] font-semibold uppercase {{ $tone }}">{{ $status }}</p>
                    </div>
                @endforeach
            </div>
            <img src="{{ $logo }}" alt="" class="mx-auto mt-[3cqw] h-[4.5cqw] w-auto opacity-60">
        </div>
        @break

    @case('news')
        <div class="absolute inset-0 flex flex-col overflow-hidden bg-gradient-to-b from-[#0d4fb8] via-[#0a3a8c] to-[#061f4f] text-white">
            {{-- globe lines --}}
            <div class="absolute left-1/2 top-[30%] aspect-square w-[130%] -translate-x-1/2 rounded-full opacity-25 [background:repeating-radial-gradient(circle,transparent_0_6%,rgba(255,255,255,.55)_6%_6.4%),repeating-linear-gradient(90deg,transparent_0_9%,rgba(255,255,255,.4)_9%_9.4%)]"></div>
            <div class="relative flex items-center justify-between bg-black/30 px-[5cqw] py-[3cqw] text-[4cqw] font-bold uppercase tracking-[0.2em]">
                <span>Yara News 24</span>
                <span class="flex items-center gap-[1.5cqw] text-[3.6cqw]"><span class="about-pulse h-[2.4cqw] w-[2.4cqw] rounded-full bg-red-500"></span>Live</span>
            </div>
            <div class="relative mt-[16cqw] px-[6cqw]">
                <p class="inline-block -skew-x-12 rounded-[1cqw] bg-[#e11d2e] px-[4cqw] py-[1.2cqw] font-display text-[13cqw] font-extrabold italic leading-none shadow-lg ring-[0.8cqw] ring-white">BREAKING</p>
                <p class="mt-[2cqw] -skew-x-12 font-display text-[19cqw] font-extrabold italic leading-none [text-shadow:0_0.8cqw_0_#0a2a6b]">NEWS</p>
            </div>
            <div class="relative mt-auto bg-gradient-to-t from-black/60 to-transparent px-[6cqw] pb-[5cqw] pt-[10cqw]">
                <p class="text-[3.8cqw] font-semibold uppercase tracking-[0.2em] text-sky-200">Retail · Technology</p>
                <p class="mt-[1.5cqw] font-display text-[6.6cqw] font-bold leading-tight">Two screens, one display: double-sided signage lights up shop windows</p>
            </div>
            <div class="relative overflow-hidden bg-[#e11d2e] py-[2.4cqw] text-[4.2cqw] font-bold">
                <div class="dsvd-ticker flex w-max gap-[8cqw] whitespace-nowrap">
                    @for ($k = 0; $k < 2; $k++)
                        <span>Sunlight-readable · Built for 24/7 · Remote content updates · Full HD on both sides · 43 inch ·</span>
                    @endfor
                </div>
            </div>
        </div>
        @break

    @case('sale')
        <div class="absolute inset-0 flex flex-col items-center justify-center overflow-hidden bg-gradient-to-br from-[#e11d2e] via-[#a51d35] to-[#3b0712] text-center text-white">
            <div class="absolute -left-[20cqw] -top-[20cqw] aspect-square w-[70cqw] rounded-full bg-white/10"></div>
            <div class="absolute -bottom-[25cqw] -right-[15cqw] aspect-square w-[80cqw] rounded-full bg-black/20"></div>
            <p class="relative text-[5cqw] font-bold uppercase tracking-[0.35em] text-amber-200">Festive Sale</p>
            <p class="relative mt-[6cqw] text-[6cqw] font-semibold uppercase tracking-widest">Up to</p>
            <p class="relative font-display text-[40cqw] font-extrabold leading-[0.85]">50<span class="text-[20cqw]">%</span></p>
            <p class="relative font-display text-[16cqw] font-extrabold leading-none">OFF</p>
            <p class="relative mt-[6cqw] text-[5cqw] text-white/85">On TVs, ACs, audio &amp; more</p>
            <span class="relative mt-[8cqw] rounded-full bg-white px-[7cqw] py-[3cqw] text-[4.6cqw] font-bold text-[#a51d35]">Walk in today →</span>
            <img src="{{ $logo }}" alt="" class="absolute bottom-[5cqw] h-[5cqw] w-auto opacity-80">
        </div>
        @break

    @case('arrivals')
        <div class="absolute inset-0 flex flex-col overflow-hidden bg-[#f6f3ee] p-[7cqw] text-gray-900">
            <p class="text-[4cqw] font-bold uppercase tracking-[0.35em] text-[#a51d35]">Just in</p>
            <p class="mt-[2cqw] font-display text-[13cqw] font-extrabold leading-[0.95]">New<br>arrivals</p>
            <p class="mt-[3cqw] text-[4.6cqw] text-gray-600">Smart TVs from 32" to 100", ready to take home today.</p>
            <div class="mt-[7cqw] grid flex-1 grid-cols-2 gap-[4cqw]">
                @foreach ([['from-[#1d3fd8] to-[#b03ad1]', '55" 4K'], ['from-[#f59e0b] to-[#e11d2e]', '65" QLED'], ['from-[#0ea5e9] to-[#10b981]', '75" 4K'], ['from-[#111827] to-[#a51d35]', '100" Centum']] as [$grad, $label])
                    <div class="flex flex-col rounded-[3cqw] bg-white p-[3cqw] shadow-md">
                        <div class="aspect-video rounded-[1.5cqw] bg-gradient-to-br {{ $grad }} ring-[1cqw] ring-gray-900"></div>
                        <p class="mt-auto pt-[2cqw] text-[4.4cqw] font-bold">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
            <div class="mt-[6cqw] flex items-center justify-between">
                <img src="{{ asset('storage/products/centum/yara-logo.png') }}" alt="" class="h-[6cqw] w-auto">
                <span class="text-[4cqw] font-semibold text-[#a51d35]">Ask our team →</span>
            </div>
        </div>
        @break

@endswitch
