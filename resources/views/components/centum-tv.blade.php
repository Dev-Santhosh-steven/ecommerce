{{--
    Yara Centum: thin black bezel, no stand, Yara logo on the chin. Anything in the slot plays on its 16:9 screen.

    <x-centum-tv class="w-full"> <img ...> </x-centum-tv>
--}}
<div {{ $attributes->merge(['class' => 'centum-tv relative']) }} data-no-auto-reveal>

    <div class="rounded-[0.6%] bg-[#0c0c0d] p-[0.55%] pb-0 shadow-[0_40px_80px_-24px_rgba(0,0,0,0.85)] ring-1 ring-[#3b3b40]">

        <div class="centum-tv-screen relative aspect-video overflow-hidden bg-black">
            {{ $slot }}
            {{-- Glass reflection --}}
            <span class="pointer-events-none absolute inset-0 bg-[linear-gradient(125deg,rgb(255_255_255/0.07)_0%,transparent_28%)]"></span>
        </div>

        {{-- Chin with logo (height scales with the TV width) --}}
        <div class="relative pt-[1.5%]">
            <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="" aria-hidden="true"
                 class="absolute left-1/2 top-1/2 h-[45%] -translate-x-1/2 -translate-y-1/2 opacity-80">
        </div>

    </div>

</div>
