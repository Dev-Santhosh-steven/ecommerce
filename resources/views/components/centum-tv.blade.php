{{--
    Yara Centum: thin black bezel, no stand, Yara logo on the chin. Anything in the slot plays on its 16:9 screen.
    A brushed-metal rim and a soft red backlight keep its edges visible on the dark page.

    <x-centum-tv class="w-full"> <img ...> </x-centum-tv>
--}}
<div {{ $attributes->merge(['class' => 'centum-tv relative isolate']) }} data-no-auto-reveal>

    {{-- Red backlight on the wall behind the TV --}}
    <span class="pointer-events-none absolute -inset-x-[5%] -inset-y-[8%] -z-10 rounded-[4%] bg-[radial-gradient(ellipse_at_center,rgb(229_9_20/0.55)_35%,rgb(165_29_53/0.22)_62%,transparent_78%)] blur-3xl"></span>

    {{-- Brushed-metal rim, lit from above --}}
    <div class="rounded-[0.8%] bg-[linear-gradient(160deg,#a3a6ae_0%,#4a4c53_22%,#26272c_55%,#36383e_80%,#868991_100%)] p-[1.5px] shadow-[0_40px_80px_-24px_rgba(0,0,0,0.9),0_0_0_1px_rgb(255_255_255/0.04)]">

        <div class="rounded-[0.7%] bg-[#0c0c0d] p-[0.55%] pb-0 shadow-[inset_0_1px_0_rgb(255_255_255/0.14)]">

            <div class="centum-tv-screen relative aspect-video overflow-hidden bg-black ring-1 ring-black">
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

</div>
