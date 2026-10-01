{{--
    The Yara Rotatable Display: the real stand photo with an HTML screen that rotates on the pole's pivot.

    $rotate   bool    bind the screen to Alpine state `p` (portrait) and `tilt` (degrees) on a parent x-data
    $portrait string  image shown when the screen is turned to portrait
    $scrub    bool    driven by scroll instead: reads CSS variables set on a parent .rd-scrub section
                      (--turn 0..1 rotation, --swap 0..1 landscape→portrait content, --z3 0..1 second portrait
                      image, --spin wheel angle)
    $casters  bool    show the wheels under the base
    $camera   bool    highlight the 16MP camera with a pulsing ring and label (hidden in portrait)
--}}
@php
    $img = fn ($file) => asset("storage/products/rotatable-display/{$file}");
    $rotate = $rotate ?? false;
    $scrub = $scrub ?? false;
    $portrait = $portrait ?? 'screen-tigers.jpg';
    $casters = $casters ?? true;
    $camera = $camera ?? false;
@endphp

<div class="rd-unit">
    <img src="{{ $img('rd-stand.png') }}" alt="" aria-hidden="true" class="absolute inset-0 h-full w-full" draggable="false">

    @if ($casters)
        @foreach ([36, 50, 64] as $cx)
            <span class="rd-caster" style="left: {{ $cx }}%; @if ($scrub) rotate: var(--spin, 0deg); @endif"></span>
        @endforeach
    @endif

    <div class="rd-panel {{ $scrub ? 'rd-panel-scrub' : '' }}"
         @if ($rotate) :style="`--rd-rot: ${p ? -90 : 0}deg; --rd-tilt: ${tilt}deg`" @endif
         @if ($scrub) style="--rd-rot: calc(var(--turn, 0) * -90deg)" @endif>
        {{-- white bezel --}}
        <div class="absolute inset-0 rounded-[2.2%/3.8%] bg-gradient-to-b from-white to-[#e9ebef] shadow-[0_30px_60px_rgba(0,0,0,0.45)] ring-1 ring-black/10"></div>
        {{-- camera --}}
        <span class="absolute left-1/2 top-0 h-[3.6%] w-[9%] -translate-x-1/2 -translate-y-[60%] rounded-full bg-[#202126] shadow">
            <span class="absolute left-1/2 top-1/2 h-[60%] w-[18%] -translate-x-1/2 -translate-y-1/2 rounded-full bg-[radial-gradient(circle_at_35%_35%,#6b8cff,#0d1020_70%)]"></span>
        </span>
        @if ($camera)
            <span class="pointer-events-none absolute left-1/2 top-0 z-10 -translate-x-1/2 -translate-y-1/2 transition-opacity duration-500"
                  @if ($rotate) :class="p ? 'opacity-0' : 'opacity-100'" @endif>
                <span class="absolute left-1/2 top-1/2 h-8 w-8 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-brand-400 about-pulse"></span>
                <span class="absolute bottom-[140%] left-1/2 -translate-x-1/2 whitespace-nowrap rounded-full bg-brand-600 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-lg sm:text-xs">
                    16MP camera
                </span>
            </span>
        @endif

        {{-- screen --}}
        <div class="absolute inset-[1.6%_1.1%] overflow-hidden rounded-[1%/1.7%] bg-black">
            @if ($scrub)
                <img src="{{ $img('screen-city.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" style="opacity: calc(1 - var(--swap, 0))">
                <div class="rd-portrait" style="opacity: var(--swap, 0)">
                    <img src="{{ $img('screen-tigers.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                    <img src="{{ $img('screen-horses.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" style="opacity: var(--z3, 0)" loading="lazy">
                </div>
            @else
                <img src="{{ $img('screen-city.jpg') }}" alt="" class="rd-layer absolute inset-0 h-full w-full object-cover"
                     @if ($rotate) :class="p ? 'opacity-0' : 'opacity-100'" @endif>
                @if ($rotate)
                    <div class="rd-portrait rd-layer opacity-0" :class="p ? 'opacity-100' : 'opacity-0'">
                        <img src="{{ $img($portrait) }}" alt="" class="h-full w-full object-cover">
                    </div>
                @endif
            @endif
            <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(120deg,rgba(255,255,255,0.16),transparent_38%)]"></div>
        </div>
    </div>
</div>
