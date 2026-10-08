{{--
    Shop by Category — full-width expanding panels (desktop) / image cards (mobile).
    Hover or focus a panel to open it; the others collapse to slim strips with vertical titles.
--}}
<section id="categories" class="bg-white py-20" data-no-auto-reveal>

    <div class="@container mx-auto max-w-[1680px] px-4 sm:px-6 lg:px-10">

        <div class="mb-12 flex flex-col justify-between gap-5 sm:flex-row sm:items-end" data-reveal>

            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">Explore</p>
                <h2 class="mt-2 text-3xl font-bold sm:text-5xl">Shop by <span class="text-brand-600">Category</span></h2>
                <p class="mt-3 max-w-xl text-gray-500">Discover technology for your home, office, business and commercial spaces.</p>
            </div>

            <a href="{{ route('store.search') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700">
                View all products
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>

        </div>


        @if ($categories->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 py-16 text-center text-gray-500">
                No categories yet. Add some from the admin panel.
            </div>

        @else

            @php
                $icons = [
                    'televisions' => 'tv', 'air-conditioners' => 'air-vent', 'washing-machine' => 'washing-machine',
                    'interactive-panels' => 'presentation', 'led-video-walls' => 'layout-grid', 'chillers' => 'snowflake',
                    'lcd-video-walls' => 'grid-2x2', 'commercial-display-solutions' => 'monitor', 'home-audio' => 'speaker',
                ];
            @endphp

            {{-- Desktop: expanding panels --}}
            {{-- Height follows the width, so the open panel's full-width 4:3 picture plus its details fill it. --}}
            <div class="hidden h-[clamp(30rem,calc(27cqw+13.5rem),44rem)] gap-3 lg:flex" x-data="{ active: 0 }" data-reveal>

                @foreach ($categories as $i => $category)

                    <a href="{{ route('store.category', $category) }}"
                       @mouseenter="active = {{ $i }}"
                       @focus="active = {{ $i }}"
                       :class="active === {{ $i }} ? '!flex-[4.5]' : ''"
                       @if ($i === 0) style="flex-grow: 4.5" :style="''" @endif
                       class="group relative flex-1 min-w-0 overflow-hidden rounded-3xl bg-[#0b0b0f] transition-[flex-grow] duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">


                        {{-- Collapsed strip: a clean dark card with a soft brand glow --}}
                        <span class="absolute inset-0 bg-[radial-gradient(120%_60%_at_50%_100%,rgba(165,29,53,0.55),transparent_70%),linear-gradient(180deg,#17171c,#0b0b0f)] transition duration-700"
                              :class="active === {{ $i }} ? 'opacity-0' : 'opacity-100'"></span>
                        <span class="about-grid absolute inset-0 opacity-30"></span>

                        <span class="absolute inset-0 bg-gradient-to-t from-[#0b0b0f] via-[#0b0b0f]/70 via-30% to-transparent to-55% transition duration-700"
                              :class="active === {{ $i }} ? 'opacity-100' : 'opacity-0'"></span>

                        {{-- Index (hidden on the open panel, where the picture's logo sits) --}}
                        <span class="absolute left-1/2 top-7 -translate-x-1/2 font-display text-sm font-bold tracking-widest text-white/60 transition duration-500"
                              :class="active === {{ $i }} ? 'opacity-0' : ''">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>

                        {{-- Collapsed: icon + vertical title --}}
                        <span class="absolute inset-x-0 bottom-8 top-20 flex flex-col items-center justify-between transition duration-500"
                              :class="active === {{ $i }} ? 'opacity-0 translate-y-4' : 'opacity-100 delay-200'">
                            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/10 text-white ring-1 ring-white/15 transition group-hover:bg-brand-600">
                                <i data-lucide="{{ $icons[$category->slug] ?? 'layers' }}" class="h-5 w-5"></i>
                            </span>
                            <span class="whitespace-nowrap font-display text-xl font-semibold text-white [writing-mode:vertical-rl] rotate-180">
                                {{ $category->name }}
                            </span>
                        </span>

                        {{-- Expanded: the picture across the full width at its own 4:3 shape (only the open panel
                             shows it; slim strips would show an odd sliver), fading into the details right below. --}}
                        <div class="absolute inset-0 flex flex-col"
                             :class="active === {{ $i }} ? 'pointer-events-auto' : 'pointer-events-none'">

                            @if ($category->image)
                                <div class="aspect-[4/3] min-h-0 w-full shrink overflow-hidden">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                         class="h-full w-full origin-top object-cover object-top [mask-image:linear-gradient(to_bottom,black_70%,transparent)] transition duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                         :class="active === {{ $i }} ? 'scale-100 opacity-100' : 'scale-105 opacity-0'"
                                         @if ($i > 0) style="opacity: 0" @endif :style="''">
                                </div>
                            @endif

                            {{-- Details centred in the space left under the picture --}}
                            <div class="flex min-h-0 flex-1 flex-col justify-center {{ $category->image ? '-mt-10' : '' }}">
                                <div class="relative max-w-lg shrink-0 px-8 pb-8 xl:px-9 transition duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                     :class="active === {{ $i }} ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-8'"
                                     @if ($i > 0) style="opacity: 0" @endif :style="''">

                                    <h3 class="text-3xl font-bold leading-tight text-white xl:text-4xl">{{ $category->name }}</h3>

                                    @if ($category->description)
                                        <p class="mt-3 line-clamp-2 text-white/80">{{ $category->description }}</p>
                                    @endif

                                    @if ($category->children->isNotEmpty())
                                        <div class="mt-4 flex max-h-7 flex-wrap gap-2 overflow-hidden">
                                            @foreach ($category->children->take(3) as $child)
                                                <span class="rounded-full border border-white/25 px-3 py-1 text-xs font-medium text-white/90">{{ $child->name }}</span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <span class="mt-5 inline-flex items-center gap-2 whitespace-nowrap rounded-full bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition group-hover:bg-brand-600 group-hover:text-white">
                                        {{-- Long names (Commercial Display Solutions) would wrap the button on smaller screens --}}
                                        {{ Str::length($category->name) > 20 ? 'Explore the range' : 'Explore ' . $category->name }}
                                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                    </span>

                                </div>
                            </div>

                        </div>

                    </a>

                @endforeach

            </div>


            {{-- Mobile / tablet: 4:3 picture (the category art's own shape) with the name underneath --}}
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:hidden">

                @foreach ($categories as $category)

                    <a href="{{ route('store.category', $category) }}"
                       class="group block overflow-hidden rounded-2xl bg-gray-950">

                        <span class="block aspect-[4/3] overflow-hidden">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy" class="h-full w-full object-cover transition duration-700 group-hover:scale-105">
                            @endif
                        </span>

                        <span class="flex items-center justify-between gap-2 px-3 py-2.5 sm:px-4 sm:py-3">
                            <span class="font-display text-sm font-bold text-white sm:text-base">{{ $category->name }}</span>
                            <i data-lucide="arrow-right" class="h-4 w-4 shrink-0 text-white/60"></i>
                        </span>

                    </a>

                @endforeach

            </div>

        @endif

    </div>

</section>
