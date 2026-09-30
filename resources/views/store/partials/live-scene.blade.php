{{--
    A photo with live, animated content pinned onto its screen(s).
    $scene = [
        'img'     => url of the photo,
        'fg'      => optional url of a foreground cut-out (things standing in front of the screen),
        'alt'     => alt text,
        'screens' => [ ['quad' => 'x,y x,y x,y x,y' (%), 'aspect' => float, 'part' => [x0, x1] (optional)]
                       or ['box' => 'x0,y0,x1,y1' (%), 'clip' => 'polygon(...)'] ],
        'slides'  => [urls],
    ]
    $interval / $delay — optional timing (ms); $eager — load the photo straight away (above the fold)
--}}
@php
    $slides = $scene['slides'];
    $bug = asset('storage/products/centum/yara-logo-light.png');
@endphp

<div class="relative overflow-hidden" data-no-auto-reveal
     x-data="liveScreen({ count: {{ count($slides) }}, interval: {{ $interval ?? 4500 }}, delay: {{ $delay ?? 0 }} })">
    <img src="{{ $scene['img'] }}" alt="{{ $scene['alt'] }}" loading="{{ ($eager ?? false) ? 'eager' : 'lazy' }}" class="block w-full select-none" @load="layout()">

    @foreach ($scene['screens'] as $screen)
        <div class="vw-screen"
             @isset($screen['quad']) data-quad="{{ $screen['quad'] }}" data-aspect="{{ $screen['aspect'] ?? 16 / 9 }}" @endisset
             @isset($screen['box']) data-box="{{ $screen['box'] }}" style="clip-path: {{ $screen['clip'] }}" @endisset>
            @foreach ($slides as $k => $slide)
                <img src="{{ $slide }}" alt="" loading="lazy" draggable="false"
                     class="vw-slide {{ isset($screen['part']) ? 'is-part' : '' }}"
                     @isset($screen['part'])
                         style="--part-w: {{ 100 / ($screen['part'][1] - $screen['part'][0]) }}%; --part-x: -{{ $screen['part'][0] / ($screen['part'][1] - $screen['part'][0]) * 100 }}%"
                     @endisset
                     :class="i === {{ $k }} && 'is-on'">
            @endforeach
            @unless (isset($screen['part']) && $screen['part'][0] == 0)
                <img src="{{ $bug }}" alt="" class="vw-bug">
            @endunless
        </div>
    @endforeach

    @if (! empty($scene['fg']))
        <img src="{{ $scene['fg'] }}" alt="" loading="lazy" class="pointer-events-none absolute inset-0 z-10 h-full w-full">
    @endif
</div>
