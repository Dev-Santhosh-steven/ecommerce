{{--
    New Arrivals — edge-to-edge draggable carousel (free scroll with momentum),
    arrow buttons and a draggable progress bar.
--}}
<section id="new-arrivals" class="overflow-hidden bg-white py-20">

    <div class="mx-auto max-w-[1680px] px-4 sm:px-6 lg:px-10">

        <div class="mb-12 flex flex-col justify-between gap-6 sm:flex-row sm:items-end" data-reveal>

            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Just In</p>
                <h2 class="mt-2 text-3xl font-bold sm:text-5xl">New <span class="text-brand-600">Arrivals</span></h2>
                <p class="mt-3 text-gray-500">The latest additions to our range. Drag to explore.</p>
            </div>

            @if ($newArrivals->count() > 1)
                <div class="flex items-center gap-3">
                    <a href="{{ route('store.search') }}" class="mr-2 hidden text-sm font-semibold text-brand-600 hover:text-brand-700 sm:inline-flex sm:items-center sm:gap-2">
                        View all
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>
                    <button type="button" class="arrivals-prev flex h-12 w-12 items-center justify-center rounded-full border border-gray-300 text-gray-700 transition hover:border-gray-950 hover:bg-gray-950 hover:text-white disabled:pointer-events-none disabled:opacity-30" aria-label="Previous products">
                        <i data-lucide="arrow-left" class="h-5 w-5"></i>
                    </button>
                    <button type="button" class="arrivals-next flex h-12 w-12 items-center justify-center rounded-full bg-gray-950 text-white transition hover:bg-brand-600 disabled:pointer-events-none disabled:opacity-30" aria-label="Next products">
                        <i data-lucide="arrow-right" class="h-5 w-5"></i>
                    </button>
                </div>
            @endif

        </div>


        @if ($newArrivals->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 py-16 text-center text-gray-500">
                No products yet. Add some from the admin panel.
            </div>

        @else

            {{-- Slides overflow to the right edge of the screen --}}
            <div class="swiper arrivals-swiper !overflow-visible" data-reveal="right">

                <div class="swiper-wrapper">

                    @foreach ($newArrivals as $i => $product)

                        <div class="swiper-slide !h-auto !w-[78%] sm:!w-[19rem] xl:!w-[21rem]">

                            <div class="relative h-full">

                                @if ($i < 3)
                                    <span class="pointer-events-none absolute -top-3 left-5 z-20 rounded-full bg-gray-950 px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white shadow-lg">
                                        New
                                    </span>
                                @endif

                                @include('store.partials.product-card', ['product' => $product])

                            </div>

                        </div>

                    @endforeach

                    {{-- End card --}}
                    <div class="swiper-slide !h-auto !w-[78%] sm:!w-[19rem] xl:!w-[21rem]">
                        <a href="{{ route('store.search') }}" class="brand-dots group flex h-full min-h-[22rem] flex-col items-center justify-center overflow-hidden rounded-2xl bg-gray-950 p-8 text-center text-white">
                            <span class="flex h-16 w-16 items-center justify-center rounded-full bg-brand-600 transition duration-500 group-hover:scale-110 group-hover:rotate-45">
                                <i data-lucide="arrow-up-right" class="h-7 w-7"></i>
                            </span>
                            <span class="mt-6 font-display text-2xl font-bold">See everything</span>
                            <span class="mt-2 text-sm text-gray-400">Browse our full product range</span>
                        </a>
                    </div>

                </div>

            </div>

            {{-- Progress / scrollbar --}}
            <div class="arrivals-scrollbar relative mt-10 !h-1 overflow-hidden rounded-full bg-gray-200"></div>

        @endif

    </div>

</section>
