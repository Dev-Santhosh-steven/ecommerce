@extends('layouts.store')

@section('title', 'Yara Store | Smart Technology & Electronics')

@section('content')

{{-- =========================================================
     HERO SECTION (full-screen banner)
========================================================= --}}
<section class="relative h-[calc(100dvh-5rem)] min-h-[520px] w-full overflow-hidden bg-gray-950 text-white">

    <div class="swiper hero-swiper h-full w-full">

        <div class="swiper-wrapper h-full">

            @forelse ($banners as $banner)

                <div class="swiper-slide relative h-full w-full">

                    @if ($banner->video)

                        <video
                            class="hero-video absolute inset-0 h-full w-full object-cover"
                            poster="{{ asset('storage/' . $banner->image) }}"
                            muted
                            playsinline
                            preload="metadata"
                            @if ($banners->count() === 1) loop autoplay @endif
                            aria-label="{{ $banner->title ?? 'Banner video' }}"
                        >
                            <source src="{{ asset('storage/' . $banner->video) }}" type="{{ str_ends_with($banner->video, '.webm') ? 'video/webm' : 'video/mp4' }}">
                        </video>

                    @else

                        <img
                            src="{{ asset('storage/' . $banner->image) }}"
                            alt="{{ $banner->title ?? 'Banner' }}"
                            class="absolute inset-0 h-full w-full object-cover"
                        >

                    @endif

                    {{-- No dark overlay: the banner image/video shows at its true brightness.
                         Text stays readable with a soft shadow on the text itself. --}}

                    <div class="relative flex h-full items-end">


                        <div class="mx-auto w-full max-w-7xl px-4 pb-20 pt-24 sm:px-6 lg:px-8">

                            <div class="hero-copy max-w-2xl">

                                @if ($banner->subtitle)

                                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-black/35 px-4 py-2 text-sm text-white backdrop-blur">
                                        <span class="h-2 w-2 rounded-full bg-brand-red"></span>
                                        {{ $banner->subtitle }}
                                    </div>

                                @endif

                                @if ($banner->title)

                                    <h1 class="text-4xl font-bold leading-[1.05] tracking-tight [text-shadow:0_2px_4px_rgb(0_0_0/0.35),0_4px_24px_rgb(0_0_0/0.45)] sm:text-6xl lg:text-7xl">
                                        {{ $banner->title }}
                                    </h1>

                                @endif

                                @if ($banner->button_text && $banner->button_link)

                                    <div class="mt-9 flex flex-wrap gap-4">

                                        <a href="{{ $banner->button_link }}"
                                           class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">

                                            {{ $banner->button_text }}

                                            <i data-lucide="arrow-right" class="h-4 w-4"></i>

                                        </a>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="swiper-slide relative h-full w-full bg-gray-950">

                    <div class="absolute inset-0">
                        <img src="{{ asset('images/brand/hero-showroom.jpg') }}" alt="" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-r from-gray-950/95 via-gray-950/70 to-brand-900/40"></div>
                        <div class="absolute inset-x-0 bottom-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>
                    </div>

                    <div class="relative flex h-full items-end">

                        <div class="mx-auto w-full max-w-7xl px-4 pb-20 pt-24 sm:px-6 lg:px-8">

                            <div class="hero-copy max-w-2xl">

                                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm text-gray-300">
                                    <span class="h-2 w-2 rounded-full bg-brand-red"></span>
                                    Smart Technology for Modern Spaces
                                </div>

                                <h1 class="text-4xl font-bold leading-[1.05] tracking-tight sm:text-6xl lg:text-7xl">
                                    Technology
                                    <span class="text-brand-400">Built for</span>
                                    Life.
                                </h1>

                                <p class="mt-6 max-w-xl text-lg leading-8 text-gray-400">
                                    Explore next-generation TVs, interactive panels,
                                    commercial displays, audio systems and smart
                                    home appliances.
                                </p>

                                <div class="mt-9 flex flex-wrap gap-4">

                                    <a href="#products"
                                       class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">

                                        Explore Products

                                        <i data-lucide="arrow-right" class="h-4 w-4"></i>

                                    </a>

                                    <a href="#categories"
                                       class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">

                                        View Categories

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @endforelse

        </div>


        {{-- Hero Navigation --}}
        @if ($banners->count() > 1)

            <button
                class="hero-prev absolute left-4 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur transition hover:bg-white/20 sm:left-6"
                aria-label="Previous slide"
            >
                <i data-lucide="arrow-left" class="h-4 w-4"></i>
            </button>

            <button
                class="hero-next absolute right-4 top-1/2 z-10 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/20 bg-white/10 text-white backdrop-blur transition hover:bg-white/20 sm:right-6"
                aria-label="Next slide"
            >
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </button>

            <div class="hero-pagination absolute bottom-8 right-4 z-10 flex w-auto items-center justify-end gap-2 sm:right-6"></div>

        @endif

    </div>


    {{-- Scroll hint --}}
    <div class="pointer-events-none absolute inset-x-0 bottom-6 z-10 flex justify-center">
        <div class="flex animate-bounce flex-col items-center gap-1 text-white/70">
            <span class="text-[11px] font-medium uppercase tracking-wider">Scroll</span>
            <i data-lucide="chevron-down" class="h-5 w-5"></i>
        </div>
    </div>

</section>


{{-- =========================================================
     STATS COUNTERS (edit in Admin → Settings)
========================================================= --}}
@if (! empty($stats))

<section class="bg-white pt-14">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-2 overflow-hidden rounded-3xl bg-white shadow-xl shadow-gray-900/10 ring-1 ring-gray-200 {{ [1 => 'lg:grid-cols-1', 2 => 'lg:grid-cols-2', 3 => 'lg:grid-cols-3', 4 => 'lg:grid-cols-4'][count($stats)] }}">

            @foreach ($stats as $i => $stat)

                <div class="group relative flex flex-col items-center px-4 py-8 text-center sm:px-6 sm:py-10
                            {{ $i % 2 === 1 ? 'border-l border-gray-100' : '' }}
                            {{ $i >= 2 ? 'border-t border-gray-100 lg:border-t-0' : '' }}
                            {{ $i > 0 ? 'lg:border-l lg:border-gray-100' : '' }}">

                    <span class="absolute inset-x-8 top-0 h-1 origin-center scale-x-0 rounded-b-full bg-gradient-to-r from-brand-600 to-brand-red transition duration-500 group-hover:scale-x-100"></span>

                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition duration-300 group-hover:-translate-y-1 group-hover:bg-brand-600 group-hover:text-white">
                        <i data-lucide="{{ $stat['icon'] }}" class="h-6 w-6"></i>
                    </span>

                    <p class="mt-4 font-display text-3xl font-extrabold tabular-nums tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                        <span data-count-to="{{ (int) $stat['value'] }}">{{ number_format((int) $stat['value']) }}</span><span class="text-brand-600">{{ $stat['suffix'] }}</span>
                    </p>

                    <p class="mt-2 text-sm font-medium text-gray-500 sm:text-base">
                        {{ $stat['label'] }}
                    </p>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endif


{{-- =========================================================
     CATEGORY SECTION — expanding panels
========================================================= --}}
@include('store.home.categories')


{{-- =========================================================
     LED VIDEO WALLS + CALCULATOR
========================================================= --}}
@if ($ledCategory)

<section id="led-walls" class="brand-dots overflow-hidden bg-gray-950 py-20 text-white" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid items-center gap-12 lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]">

            <div>

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em] !text-brand-400">
                    New &middot; LED Video Walls
                </p>

                <h2 class="mt-4 text-4xl font-bold tracking-tight sm:text-5xl">
                    Go big.
                    <span class="text-brand-400">Plan your LED wall in seconds.</span>
                </h2>

                <p class="mt-6 max-w-xl leading-7 text-gray-400">
                    Seamless LED video walls for lobbies, boardrooms, stages, storefronts and highway billboards &mdash;
                    from P1.25 fine-pitch indoor to 7,000-nit outdoor. Enter your wall space and our calculator shows
                    the exact screen size, resolution, power and viewing distance.
                </p>

                <dl class="mt-8 grid grid-cols-3 gap-4 border-y border-white/10 py-6">
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Pixel pitch</dt>
                        <dd class="mt-1 text-xl font-bold">P1.25&ndash;P10</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Brightness</dt>
                        <dd class="mt-1 text-xl font-bold">7,000 nits</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wider text-gray-500">Size</dt>
                        <dd class="mt-1 text-xl font-bold">Any</dd>
                    </div>
                </dl>

                <ol class="mt-8 space-y-3 text-sm text-gray-300">
                    @foreach (['Choose indoor or outdoor', 'Pick a pixel pitch for your viewing distance', 'Enter your wall space — get the full solution'] as $i => $step)
                        <li class="flex items-center gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold">{{ $i + 1 }}</span>
                            {{ $step }}
                        </li>
                    @endforeach
                </ol>

                <div class="mt-9 flex flex-wrap gap-4">

                    <a href="{{ route('store.led-calculator') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">
                        Explore More
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>

                    <a href="{{ route('store.category', $ledCategory) }}"
                       class="inline-flex items-center gap-2 rounded-full border border-white/20 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-white/10">
                        View LED Walls
                    </a>

                </div>

            </div>


            <div class="relative">

                <div class="absolute -inset-10 rounded-full bg-brand-600/10 blur-3xl"></div>

                <div class="relative grid grid-cols-2 gap-4">

                    @foreach ([
                        ['home-outdoor', 'Outdoor billboards', 'Sunlight readable, IP65', 'col-span-2 aspect-[16/9]'],
                        ['home-indoor', 'Indoor & corporate', 'Fine-pitch P1.25–P2.5', 'aspect-[4/3]'],
                        ['home-stage', 'Rental & events', 'Tool-less cabinets', 'aspect-[4/3]'],
                    ] as [$image, $title, $caption, $size])

                        <a href="{{ route('store.led-calculator') }}" class="group relative overflow-hidden rounded-2xl border border-white/10 {{ $size }}">
                            <img src="{{ asset('storage/led-video-walls/' . $image . '.jpg') }}"
                                 alt="{{ $title }} LED video wall"
                                 loading="lazy"
                                 class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent"></div>
                            <div class="absolute bottom-0 p-4 sm:p-5">
                                <p class="font-semibold">{{ $title }}</p>
                                <p class="mt-0.5 text-xs text-gray-300">{{ $caption }}</p>
                            </div>
                        </a>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

</section>

@endif


{{-- =========================================================
     POPULAR PRODUCTS — spotlight
========================================================= --}}
@include('store.home.popular')


{{-- =========================================================
     NEW ARRIVALS — carousel
========================================================= --}}
@include('store.home.new-arrivals')


{{-- =========================================================
     BOOK A DEMO CTA
========================================================= --}}
<section class="bg-white py-16" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="brand-dots relative overflow-hidden rounded-3xl bg-gray-950 px-6 py-14 text-center text-white sm:px-16">

            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>

            <div class="relative">

                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10">
                    <i data-lucide="calendar-check" class="h-7 w-7 text-brand-400"></i>
                </div>

                <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                    See It Before You Buy It
                </h2>

                <p class="mx-auto mt-3 max-w-xl text-gray-400">
                    Book a free, no-obligation demo and experience our TVs, ACs and appliances up
                    close &mdash; at our showroom or wherever suits you.
                </p>

                <a
                    href="{{ route('store.demo.create') }}"
                    class="mt-8 inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500"
                >
                    Book a Demo
                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                </a>

            </div>

        </div>

    </div>

</section>


@include('store.home.solutions')


{{-- =========================================================
     WHY YARA
========================================================= --}}
<section class="bg-gray-50 py-20">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mx-auto max-w-2xl text-center">

            <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                Why Choose Us
            </p>

            <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                Technology you can <span class="text-brand-600">trust.</span>
            </h2>

            <p class="mt-4 text-gray-500">
                We focus on quality products and dependable service from
                purchase to support.
            </p>

        </div>


        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="badge-check" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Quality Products
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Carefully selected electronics for home and business.
                </p>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="shield-check" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Reliable Warranty
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Support and warranty assistance for your products.
                </p>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="truck" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Dependable Delivery
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    Reliable delivery for products and business solutions.
                </p>

            </div>


            <div class="rounded-2xl border border-gray-200 bg-white p-6 text-center">

                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100">

                    <i data-lucide="headphones" class="h-6 w-6"></i>

                </div>

                <h3 class="mt-5 font-semibold">
                    Customer Support
                </h3>

                <p class="mt-2 text-sm leading-6 text-gray-500">
                    We're here to help before and after your purchase.
                </p>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     TESTIMONIALS (managed from Admin → Testimonials)
========================================================= --}}
@if ($testimonials->isNotEmpty())
    @include('store.partials.testimonials')
@endif


{{-- =========================================================
     LATEST BLOG POSTS (managed from Admin → Blog)
========================================================= --}}
@if ($latestPosts->isNotEmpty())

<section id="blog" class="bg-gray-50 py-20" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-12 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

            <div>

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                    From the Blog
                </p>

                <h2 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">
                    News &amp; <span class="text-brand-600">Insights</span>
                </h2>

                <p class="mt-3 text-gray-500">
                    Guides and stories on display technology.
                </p>

            </div>

            <a href="{{ route('store.blog.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700 hover:underline">

                View all articles

                <i data-lucide="arrow-right" class="h-4 w-4"></i>

            </a>

        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($latestPosts as $post)

                @include('store.partials.post-card', ['post' => $post])

            @endforeach

        </div>

    </div>

</section>

@endif


{{-- =========================================================
     NEWSLETTER / CTA
========================================================= --}}
<section class="bg-white py-20">

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <div class="brand-dots relative overflow-hidden rounded-3xl bg-gray-950 px-6 py-14 text-center text-white sm:px-12">

            <div class="absolute inset-x-0 top-0 h-1.5 bg-gradient-to-r from-brand-600 to-brand-red"></div>

            <div class="relative">

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em] !text-brand-400">
                    Stay Updated
                </p>

                <h2 class="mt-3 text-3xl font-bold sm:text-4xl">
                    Discover what's next in technology.
                </h2>

                <p class="mx-auto mt-4 max-w-xl text-gray-400">
                    Get updates about new products, offers and technology solutions.
                </p>

                <form class="mx-auto mt-8 flex max-w-xl flex-col gap-3 sm:flex-row">

                    <input
                        type="email"
                        placeholder="Enter your email address"
                        class="min-w-0 flex-1 rounded-full border border-white/10 bg-white/10 px-5 py-3.5 text-sm text-white outline-none placeholder:text-gray-500 focus:border-brand-400"
                    >

                    <button
                        type="submit"
                        class="rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500"
                    >
                        Subscribe
                    </button>

                </form>

            </div>

        </div>

    </div>

</section>


@push('scripts')

<script>
    // New Arrivals: free-drag carousel with momentum, arrows and a draggable progress bar.
    document.addEventListener('DOMContentLoaded', function () {
        if (!document.querySelector('.arrivals-swiper')) return;

        new Swiper('.arrivals-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 20,
            grabCursor: true,
            freeMode: { enabled: true, momentum: true, momentumRatio: 0.6, sticky: false },
            mousewheel: { forceToAxis: true },
            navigation: { nextEl: '.arrivals-next', prevEl: '.arrivals-prev' },
            scrollbar: { el: '.arrivals-scrollbar', draggable: true },
            breakpoints: { 1024: { spaceBetween: 24 } },
        });
    });

    // Count each stat up from 0 when the counters scroll into view (runs once).
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('[data-count-to]');
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (!counters.length || reduceMotion) return;

        const format = (n) => n.toLocaleString('en-IN');
        const easeOutExpo = (t) => (t === 1 ? 1 : 1 - Math.pow(2, -10 * t));

        counters.forEach((el) => (el.textContent = '0'));

        const run = (el) => {
            const target = parseInt(el.dataset.countTo, 10);
            const duration = 2200;
            const start = performance.now();

            const tick = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                el.textContent = format(Math.round(target * easeOutExpo(progress)));
                if (progress < 1) requestAnimationFrame(tick);
            };

            requestAnimationFrame(tick);
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                run(entry.target);
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.4 });

        counters.forEach((el) => observer.observe(el));
    });

    document.addEventListener('DOMContentLoaded', function () {

        const heroSwiper = new Swiper('.hero-swiper', {

            loop: true,

            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },

            navigation: {
                nextEl: '.hero-next',
                prevEl: '.hero-prev',
            },

            pagination: {
                el: '.hero-pagination',
                clickable: true,
            },

            effect: 'slide',

            speed: 700,

            on: {
                slideChangeTransitionStart: syncHeroVideo,
            },

        });

        syncHeroVideo(heroSwiper);

        // Pause off-screen videos; on a video slide, hold autoplay until the
        // video finishes, then move on. Falls back to the normal timer if the
        // browser blocks playback (e.g. low-power mode on phones).
        function syncHeroVideo(swiper) {
            swiper.el.querySelectorAll('.hero-video').forEach((video) => {
                video.onended = null;
                video.pause();
            });

            const video = swiper.slides[swiper.activeIndex]?.querySelector('.hero-video');

            if (!video) {
                swiper.autoplay?.start();
                return;
            }

            if (swiper.slides.length <= 1) {
                video.play().catch(() => {});
                return;
            }

            swiper.autoplay.stop();
            video.currentTime = 0;
            video.onended = () => {
                swiper.slideNext();
                swiper.autoplay.start();
            };
            video.play().catch(() => swiper.autoplay.start());
        }

    });
</script>

@endpush

@endsection