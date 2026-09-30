{{--
    Popular Products — spotlight layout: the Yara Centum 100" (else the first featured product) as a large hero card,
    the next ones arranged around it (4 on laptops, 6 on wide screens).
--}}
@php
    $spotlight = $featuredProducts->first();
    $others = $featuredProducts->slice(1)->take(6)->values();
    $spotlightPrice = $spotlight && $spotlight->sale_price && (float) $spotlight->sale_price < (float) $spotlight->price
        ? $spotlight->sale_price
        : $spotlight?->price;
@endphp

<section id="products" class="bg-gray-50 py-20">

    <div class="mx-auto max-w-[1680px] px-4 sm:px-6 lg:px-10">

        <div class="mb-12 flex flex-col justify-between gap-5 sm:flex-row sm:items-end" data-reveal>

            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Featured</p>
                <h2 class="mt-2 text-3xl font-bold sm:text-5xl">Popular <span class="text-brand-600">Products</span></h2>
                <p class="mt-3 text-gray-500">The products our customers choose most.</p>
            </div>

            <a href="{{ route('store.search') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700">
                View all
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>

        </div>


        @if (! $spotlight)

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-16 text-center text-gray-500">
                No featured products yet. Mark products as &ldquo;Featured&rdquo; from the admin panel to show them here.
            </div>

        @else

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5">

                {{-- Spotlight --}}
                <a href="{{ $spotlight->url() }}" data-reveal="zoom"
                   class="group relative flex flex-col overflow-hidden rounded-[2rem] bg-gray-950 text-white shadow-2xl shadow-gray-900/20 sm:col-span-2 lg:row-span-2">

                    <div class="relative flex-1 overflow-hidden">

                        @if ($spotlight->primaryImage)
                            <img src="{{ asset('storage/' . $spotlight->primaryImage->image) }}" alt="{{ $spotlight->name }}"
                                 class="h-full max-h-[34rem] min-h-[18rem] w-full object-cover transition duration-1000 group-hover:scale-105">
                        @else
                            <div class="flex h-full min-h-[18rem] items-center justify-center bg-gray-900 text-gray-600">
                                <i data-lucide="image" class="h-14 w-14"></i>
                            </div>
                        @endif

                        <span class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/10 to-transparent"></span>

                    </div>

                    <div class="relative -mt-20 p-7 sm:p-9">

                        @if ($spotlight->category)
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-brand-400">{{ $spotlight->category->name }}</p>
                        @endif

                        <h3 class="mt-2 text-2xl font-bold leading-tight sm:text-3xl">{{ $spotlight->name }}</h3>

                        @if ($spotlight->short_description)
                            <p class="mt-3 line-clamp-2 text-gray-300">{{ $spotlight->short_description }}</p>
                        @endif

                        @if ($spotlight->features->isNotEmpty())
                            <div class="mt-5 flex flex-wrap gap-2">
                                @foreach ($spotlight->features->take(3) as $feature)
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-white/5 px-3 py-1.5 text-xs font-medium text-gray-200">
                                        @if ($feature->icon)
                                            <i data-lucide="{{ $feature->icon }}" class="h-3.5 w-3.5 text-brand-400"></i>
                                        @endif
                                        {{ $feature->title }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-7 flex flex-wrap items-center justify-between gap-4 border-t border-white/10 pt-6">
                            <p>
                                @if (! $spotlight->hasPrice())
                                    <span class="font-display text-2xl font-bold">Price on request</span>
                                @elseif ($spotlightPrice)
                                    <span class="font-display text-3xl font-bold">&#8377;{{ number_format($spotlightPrice) }}</span>
                                    @if ($spotlightPrice < $spotlight->price)
                                        <span class="ml-2 text-sm text-gray-500 line-through">&#8377;{{ number_format($spotlight->price) }}</span>
                                    @endif
                                @endif
                            </p>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition group-hover:bg-brand-600 group-hover:text-white">
                                View product
                                <i data-lucide="arrow-right" class="h-4 w-4"></i>
                            </span>
                        </div>

                    </div>

                </a>


                {{-- The rest: 4 on laptops (fills the 2×2 beside the spotlight), 6 on wide screens --}}
                @foreach ($others as $i => $product)
                    <div class="{{ $i >= 4 ? 'lg:max-xl:hidden' : '' }}">
                        @include('store.partials.product-card', ['product' => $product])
                    </div>
                @endforeach

                {{-- Fills the empty slot when there aren't enough products for the layout
                     (2 per row on tablets, 4 beside the spotlight on laptops, 6 on wide screens). --}}
                @php
                    $n = $others->count();
                    $fillerClasses = implode(' ', [
                        'hidden',
                        $n % 2 === 1 ? 'sm:block' : 'sm:hidden',
                        $n < 4 ? 'lg:block' : 'lg:hidden',
                        $n < 6 ? 'xl:block' : 'xl:hidden',
                    ]);
                @endphp

                <a href="{{ route('store.search') }}" class="{{ $fillerClasses }} brand-dots group relative overflow-hidden rounded-2xl bg-gradient-to-br from-brand-600 to-brand-800 p-8 text-white">
                    <span class="flex h-full min-h-[16rem] flex-col justify-between">
                        <span class="flex h-14 w-14 items-center justify-center rounded-full bg-white/15 transition duration-500 group-hover:rotate-45 group-hover:bg-white group-hover:text-brand-700">
                            <i data-lucide="arrow-up-right" class="h-6 w-6"></i>
                        </span>
                        <span>
                            <span class="block font-display text-2xl font-bold leading-tight">Browse the<br>full range</span>
                            <span class="mt-2 block text-sm text-white/80">TVs, panels, LED walls, ACs &amp; more</span>
                        </span>
                    </span>
                </a>

            </div>

        @endif

    </div>

</section>
