{{-- =========================================================
     BUSINESS SOLUTIONS — real Yara products for business
========================================================= --}}
@php
    $cat = fn ($slug) => asset("storage/categories/{$slug}.jpg");
    $business = [
        ['slug' => 'interactive-panels', 'url' => url('/interactive-panels'), 'name' => 'Interactive Panels', 'tag' => 'Smart classrooms & training', 'icon' => 'presentation'],
        ['slug' => 'led-video-walls', 'url' => url('/led-video-walls'), 'name' => 'LED Video Walls', 'tag' => 'Billboards, stages & facades', 'icon' => 'layout-grid'],
        ['slug' => 'lcd-video-walls', 'url' => url('/lcd-video-walls'), 'name' => 'LCD Video Walls', 'tag' => 'Control rooms & lobbies', 'icon' => 'grid-2x2'],
        ['slug' => 'commercial-displays', 'url' => url('/commercial-displays'), 'name' => 'Commercial Displays', 'tag' => '24/7 digital signage', 'icon' => 'monitor'],
        ['slug' => 't-standees', 'url' => url('/t-standees'), 'name' => 'T-Standees', 'tag' => 'Malls, showrooms & lobbies', 'icon' => 'megaphone'],
        ['slug' => 'a-standees', 'url' => url('/a-standees'), 'name' => 'A-Standees', 'tag' => 'Portable digital posters', 'icon' => 'tablet-smartphone'],
        ['slug' => 'printing-kiosk', 'url' => url('/printing-kiosk'), 'name' => 'Kiosks', 'tag' => 'Self-order & check-in', 'icon' => 'scan-line'],
        ['slug' => 'glass-displays', 'url' => url('/glass-displays'), 'name' => 'Glass Displays', 'tag' => 'Glass-front touch, 24/7', 'icon' => 'scan-line'],
    ];
    $home = [
        ['slug' => 'televisions', 'url' => url('/category/televisions'), 'name' => 'Televisions', 'tag' => '24" to 100" · Google TV, QLED & Anti-Glare', 'eyebrow' => 'Entertainment'],
        ['slug' => 'air-conditioners', 'url' => url('/category/air-conditioners'), 'name' => 'Air Conditioners', 'tag' => '1, 1.5 & 2 Ton inverter split ACs', 'eyebrow' => 'Climate control'],
        ['slug' => 'washing-machine', 'url' => url('/category/washing-machine'), 'name' => 'Washing Machines', 'tag' => 'Fully automatic, semi automatic & washer', 'eyebrow' => 'Home appliances'],
        ['slug' => 'home-audio', 'url' => url('/home-audio'), 'name' => 'Home Audio', 'tag' => 'Tower speakers & soundbars', 'eyebrow' => 'Sound'],
    ];
@endphp
<section id="commercial" class="relative overflow-hidden bg-gray-950 py-24 text-white">
    <div class="about-grid absolute inset-0 opacity-40"></div>
    <div class="about-blob -left-32 top-10 h-[28rem] w-[28rem] bg-brand-800/60"></div>

    <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-end" data-reveal>
            <div class="max-w-2xl">
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em] !text-brand-400">Business Solutions</p>
                <h2 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">Technology that <span class="about-gradient-text">works for your business.</span></h2>
                <p class="mt-5 leading-7 text-gray-400">From smart classrooms to shop-floor signage and mission-critical control rooms: Yara displays built, installed and serviced in India.</p>
            </div>
            <a href="{{ url('/category/commercial-display-solutions') }}" class="inline-flex shrink-0 items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">
                Explore all solutions <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($business as $k => $b)
                <a href="{{ $b['url'] }}" data-reveal style="--reveal-delay: {{ ($k % 4) * 90 }}ms"
                   class="about-shine group relative overflow-hidden rounded-3xl border border-white/10 bg-white/[0.03] transition duration-500 hover:-translate-y-1.5 hover:border-brand-500/50">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="{{ $cat($b['slug']) }}" alt="Yara {{ $b['name'] }}" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                    </div>
                    <div class="flex items-center gap-4 p-5">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-white/5 ring-1 ring-white/10 transition group-hover:bg-brand-600">
                            <i data-lucide="{{ $b['icon'] }}" class="h-5 w-5"></i>
                        </span>
                        <span class="min-w-0">
                            <span class="block font-bold">{{ $b['name'] }}</span>
                            <span class="block truncate text-sm text-gray-400">{{ $b['tag'] }}</span>
                        </span>
                        <i data-lucide="arrow-up-right" class="ml-auto h-5 w-5 shrink-0 text-gray-500 transition group-hover:text-white"></i>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>


{{-- =========================================================
     SMART LIVING — Yara home products
========================================================= --}}
<section class="bg-white py-24">
    <div class="mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">
        <div data-reveal>
            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Smart Living</p>
            <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-5xl">Upgrade your <span class="text-brand-600">home.</span></h2>
            <p class="mt-3 max-w-xl text-gray-500">Yara TVs, ACs, washing machines and speakers, designed for Indian homes and backed by our own service network.</p>
        </div>

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($home as $k => $h)
                <a href="{{ $h['url'] }}" data-reveal style="--reveal-delay: {{ $k * 110 }}ms"
                   class="group relative overflow-hidden rounded-3xl bg-gray-950 shadow-sm transition duration-500 hover:-translate-y-1.5 hover:shadow-2xl">
                    {{-- The category art is landscape (4:3): show all of it at the top, over a blurred copy that fills the tall card --}}
                    <div class="relative aspect-[3/4] w-full overflow-hidden">
                        <img src="{{ $cat($h['slug']) }}" alt="" aria-hidden="true" loading="lazy"
                             class="absolute inset-0 h-full w-full scale-125 object-cover opacity-60 blur-2xl">
                        <img src="{{ $cat($h['slug']) }}" alt="Yara {{ $h['name'] }}" loading="lazy"
                             class="relative aspect-[4/3] w-full object-cover transition duration-700 [mask-image:linear-gradient(to_bottom,black_70%,transparent)] group-hover:scale-105">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 via-40% to-transparent to-65%"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 text-white">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-300">{{ $h['eyebrow'] }}</p>
                        <h3 class="mt-1 text-2xl font-bold">{{ $h['name'] }}</h3>
                        <p class="mt-1 text-sm text-gray-300">{{ $h['tag'] }}</p>
                        <span class="mt-4 inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold backdrop-blur transition group-hover:bg-brand-600">
                            Shop now <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
