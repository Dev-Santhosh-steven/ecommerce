{{--
    Yara T-Standee: portrait screen, black body panel with the Yara mark, weighted base.
    Proportions follow the product photo (screen 327×560, body panel 312 tall, base 55).

    <x-t-standee class="w-40"> <img ...> </x-t-standee>
--}}
<div {{ $attributes->merge(['class' => 't-standee relative']) }} data-no-auto-reveal>

    {{-- Body --}}
    <div class="relative rounded-[3%_3%_1%_1%/1.6%_1.6%_0.5%_0.5%] bg-gradient-to-b from-[#1b1b1e] to-[#0c0c0e] p-[3.4%] pb-0 shadow-[0_30px_60px_-20px_rgba(0,0,0,0.8)] ring-1 ring-[#34343a]">

        <div class="t-standee-screen relative overflow-hidden bg-black" style="aspect-ratio: 327 / 560">
            {{ $slot }}
            <span class="pointer-events-none absolute inset-0 bg-[linear-gradient(125deg,rgb(255_255_255/0.08)_0%,transparent_30%)]"></span>
        </div>

        {{-- Lower panel with the Yara mark --}}
        <div class="relative flex items-center justify-center" style="aspect-ratio: 327 / 312">
            <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="" aria-hidden="true" class="w-[30%] opacity-85">
        </div>

    </div>

    {{-- Weighted base --}}
    <div class="relative -mt-px mx-[-4%]">
        <div class="h-[0.6em] rounded-t-sm bg-gradient-to-b from-[#2a2a2e] to-[#161618]" style="height: 0; padding-top: 3%"></div>
        <div class="rounded-b-md bg-gradient-to-b from-[#1c1c1f] to-[#0a0a0b]" style="height: 0; padding-top: 5%"></div>
    </div>

</div>
