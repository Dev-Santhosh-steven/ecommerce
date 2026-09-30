{{--
    Neon leaves: the Yara Centum showpiece (16:9, loops every 12 s).

      0 – 1.7 s   the neon tube flickers on and its red light spills over the leaves
      1.7 – 11 s  steady glow that breathes, a hum-flicker at ~6 s, a bright pulse runs along the tubes
      11 – 12 s   the light dims and the loop starts again
      throughout  a slow cinematic push-in

    <x-neon-scene class="absolute inset-0" />
--}}
@php
    $img = fn ($f) => asset("storage/products/centum/{$f}");
@endphp

<div {{ $attributes->merge(['class' => 'neon-scene overflow-hidden bg-black']) }} role="img"
     aria-label="Glowing neon frame over red leaves on the Yara Centum 100 inch 4K screen">
    <div class="neon-zoom absolute inset-0">
        <img src="{{ $img('neon-off.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover" draggable="false">
        <img src="{{ $img('neon-on.jpg') }}" alt="" class="neon-on absolute inset-0 h-full w-full object-cover" draggable="false">
        <img src="{{ $img('neon-tubes.png') }}" alt="" class="neon-glow absolute inset-0 h-full w-full object-cover" draggable="false">
        <img src="{{ $img('neon-tubes.png') }}" alt="" class="neon-sweep absolute inset-0 h-full w-full object-cover" draggable="false">
    </div>
</div>

@once
    <style>
        .neon-scene .neon-zoom { animation: neon-zoom 24s ease-in-out infinite alternate; }
        .neon-scene .neon-on { animation: neon-on 12s linear infinite both; }
        .neon-scene .neon-glow { mix-blend-mode: screen; filter: blur(14px) brightness(1.4); animation: neon-glow 12s ease-in-out infinite both; }
        .neon-scene .neon-sweep {
            mix-blend-mode: screen;
            filter: brightness(1.8) drop-shadow(0 0 6px #ff9fb0);
            -webkit-mask-image: linear-gradient(115deg, transparent 40%, #000 50%, transparent 60%);
            mask-image: linear-gradient(115deg, transparent 40%, #000 50%, transparent 60%);
            -webkit-mask-size: 300% 100%;
            mask-size: 300% 100%;
            animation: neon-sweep 12s ease-in-out infinite both;
        }

        @keyframes neon-zoom { from { transform: scale(1.02); } to { transform: scale(1.1) translate(-1%, -1%); } }
        /* flicker on like a real tube, hum at ~6 s, dim out at the end */
        @keyframes neon-on {
            0%, 7% { opacity: 0; }
            8% { opacity: .85; } 9% { opacity: .1; }
            10.5% { opacity: .9; } 11.5% { opacity: .25; }
            14% { opacity: 1; }
            51% { opacity: 1; } 51.8% { opacity: .55; } 52.6% { opacity: 1; }
            90% { opacity: 1; } 98%, 100% { opacity: 0; }
        }
        @keyframes neon-glow {
            0%, 13% { opacity: 0; }
            18% { opacity: .9; } 30% { opacity: .55; } 42% { opacity: .9; } 54% { opacity: .5; }
            66% { opacity: .9; } 78% { opacity: .6; } 90% { opacity: .8; } 98%, 100% { opacity: 0; }
        }
        @keyframes neon-sweep {
            0%, 20% { -webkit-mask-position: 100% 0; mask-position: 100% 0; opacity: 0; }
            22% { opacity: 1; }
            45% { -webkit-mask-position: 0% 0; mask-position: 0% 0; opacity: 1; }
            47%, 60% { opacity: 0; -webkit-mask-position: 0% 0; mask-position: 0% 0; }
            62% { opacity: 1; -webkit-mask-position: 100% 0; mask-position: 100% 0; }
            85% { opacity: 1; -webkit-mask-position: 0% 0; mask-position: 0% 0; }
            87%, 100% { opacity: 0; -webkit-mask-position: 0% 0; mask-position: 0% 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            .neon-scene * { animation: none !important; }
            .neon-scene .neon-glow { opacity: .7; }
            .neon-scene .neon-sweep { display: none; }
        }
    </style>
@endonce
