{{--
    A TV in a real room: a room photo whose TV screen is replaced by whatever is in the slot, mapped onto the
    screen's four corners in perspective, so the furniture, light and the TV's own bezel stay real.

    <x-tv-room src="..." alt="..." :screen="[[x, y], [x, y], [x, y], [x, y]]" glow="rgba(255,40,80,0.35)">
        <img src="..." class="absolute inset-0 h-full w-full object-cover">
    </x-tv-room>

    screen: the screen's top-left, top-right, bottom-right and bottom-left corners, in % of the photo.
    glow:   optional colour the screen casts back into the room.
--}}
@props(['src', 'alt' => '', 'screen', 'glow' => null])

@php
    $centre = [array_sum(array_column($screen, 0)) / 4, array_sum(array_column($screen, 1)) / 4];
@endphp

<div {{ $attributes->merge(['class' => 'tv-room relative isolate overflow-hidden']) }}
     data-screen='@json($screen)' data-no-auto-reveal>

    <img src="{{ $src }}" alt="{{ $alt }}" class="block h-auto w-full select-none" draggable="false">

    {{-- The screen: laid out at 1600 px wide, then warped onto the photo's screen corners --}}
    <div class="tv-room-screen absolute left-0 top-0 origin-top-left overflow-hidden bg-black opacity-0" style="width: 1600px; height: 900px">
        {{ $slot }}
        {{-- Glass: a soft sheen across the panel --}}
        <span class="pointer-events-none absolute inset-0 bg-[linear-gradient(120deg,rgb(255_255_255/0.08)_0%,transparent_32%,transparent_70%,rgb(255_255_255/0.03)_100%)]"></span>
    </div>

    @if ($glow)
        {{-- Light from the picture falling on the wall and furniture around the TV --}}
        <span class="pointer-events-none absolute inset-0 mix-blend-screen"
              style="background: radial-gradient(ellipse 48% 42% at {{ $centre[0] }}% {{ $centre[1] }}%, {{ $glow }}, transparent 72%)"></span>
    @endif

</div>

@once
    @push('scripts')
        <script>
            // Map each room's screen layer onto its four corners (a projective transform, recomputed on resize).
            (() => {
                const fit = (room) => {
                    const layer = room.querySelector('.tv-room-screen');
                    // Layout size, not getBoundingClientRect(): that one shrinks while the room animates in.
                    const photo = room.querySelector('img');
                    const width = photo.offsetWidth, height = photo.offsetHeight;
                    if (!width || !height) return;

                    const [p0, p1, p2, p3] = JSON.parse(room.dataset.screen).map(([x, y]) => [x / 100 * width, y / 100 * height]);

                    // Lay the layer out at the screen's own shape, so the picture isn't stretched.
                    const W = 1600;
                    const H = Math.round(W * (Math.hypot(p3[0] - p0[0], p3[1] - p0[1]) + Math.hypot(p2[0] - p1[0], p2[1] - p1[1]))
                        / (Math.hypot(p1[0] - p0[0], p1[1] - p0[1]) + Math.hypot(p2[0] - p3[0], p2[1] - p3[1])));
                    layer.style.height = H + 'px';

                    // Unit square -> quad (Heckbert), then scaled to the layer's W x H.
                    const dx1 = p1[0] - p2[0], dx2 = p3[0] - p2[0], dx3 = p0[0] - p1[0] + p2[0] - p3[0];
                    const dy1 = p1[1] - p2[1], dy2 = p3[1] - p2[1], dy3 = p0[1] - p1[1] + p2[1] - p3[1];
                    const den = dx1 * dy2 - dx2 * dy1;
                    const g = (dx3 * dy2 - dx2 * dy3) / den, h = (dx1 * dy3 - dx3 * dy1) / den;
                    const a = p1[0] - p0[0] + g * p1[0], b = p3[0] - p0[0] + h * p3[0], c = p0[0];
                    const d = p1[1] - p0[1] + g * p1[1], e = p3[1] - p0[1] + h * p3[1], f = p0[1];

                    layer.style.transform = `matrix3d(${a / W},${d / W},0,${g / W},${b / H},${e / H},0,${h / H},0,0,1,0,${c},${f},0,1)`;
                    layer.classList.remove('opacity-0');
                };

                // Refit whenever a room changes size (window resize, layout change, photo finishing loading).
                const observer = new ResizeObserver((entries) => entries.forEach((entry) => fit(entry.target.closest('.tv-room'))));
                document.querySelectorAll('.tv-room').forEach((room) => {
                    observer.observe(room.querySelector('img'));
                    fit(room);
                });
            })();
        </script>
    @endpush
@endonce
