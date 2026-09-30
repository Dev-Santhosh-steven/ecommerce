{{--
    Shop by Category — full-width expanding panels (desktop) / image cards (mobile).
    Hover or focus a panel to open it; the others collapse to slim strips with vertical titles.
--}}
<section id="categories" class="bg-white py-20" data-no-auto-reveal>

    <div class="mx-auto max-w-[1680px] px-4 sm:px-6 lg:px-10">

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
            <div class="hidden h-[34rem] gap-3 lg:flex xl:h-[38rem]" x-data="{ active: 0 }" data-reveal>

                @foreach ($categories as $i => $category)

                    <a href="{{ route('store.category', $category) }}"
                       @mouseenter="active = {{ $i }}"
                       @focus="active = {{ $i }}"
                       :class="active === {{ $i }} ? '!flex-[4.5]' : ''"
                       @if ($i === 0) style="flex-grow: 4.5" :style="''" @endif
                       class="group relative flex-1 min-w-0 overflow-hidden rounded-3xl bg-gray-900 transition-[flex-grow] duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]">

                        @if ($category->image)
                            {{-- Only the open panel shows the photo; slim strips would show an odd sliver of it --}}
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}"
                                 class="absolute inset-0 h-full w-full object-cover transition duration-1000 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                 :class="active === {{ $i }} ? 'scale-100 opacity-100' : 'scale-110 opacity-0'"
                                 @if ($i > 0) style="opacity: 0" @endif :style="''">
                        @endif

                        {{-- Collapsed strip: a clean dark card with a soft brand glow --}}
                        <span class="absolute inset-0 bg-[radial-gradient(120%_60%_at_50%_100%,rgba(165,29,53,0.55),transparent_70%),linear-gradient(180deg,#17171c,#0b0b0f)] transition duration-700"
                              :class="active === {{ $i }} ? 'opacity-0' : 'opacity-100'"></span>
                        <span class="about-grid absolute inset-0 opacity-30"></span>

                        <span class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/35 to-gray-950/10 transition duration-700"
                              :class="active === {{ $i }} ? 'opacity-90' : 'opacity-0'"></span>

                        {{-- Index --}}
                        <span class="absolute left-1/2 top-7 -translate-x-1/2 font-display text-sm font-bold tracking-widest text-white/60 transition duration-500"
                              :class="active === {{ $i }} ? '!left-6 !translate-x-0' : ''">
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

                        {{-- Expanded: details --}}
                        <div class="absolute inset-x-0 bottom-0 p-8 xl:p-10"
                             :class="active === {{ $i }} ? 'pointer-events-auto' : 'pointer-events-none'">

                            <div class="max-w-lg transition duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                 :class="active === {{ $i }} ? 'opacity-100 translate-y-0 delay-200' : 'opacity-0 translate-y-8'"
                                 @if ($i > 0) style="opacity: 0" @endif :style="''">

                                @if ($category->children_count)
                                    <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                        <span class="h-1.5 w-1.5 rounded-full bg-brand-red"></span>
                                        {{ $category->children_count }} {{ Str::plural('range', $category->children_count) }}
                                    </span>
                                @endif

                                <h3 class="mt-4 text-4xl font-bold leading-tight text-white xl:text-5xl">{{ $category->name }}</h3>

                                @if ($category->description)
                                    <p class="mt-3 line-clamp-2 text-white/80">{{ $category->description }}</p>
                                @endif

                                @if ($category->children->isNotEmpty())
                                    <div class="mt-5 flex flex-wrap gap-2">
                                        @foreach ($category->children->take(4) as $child)
                                            <span class="rounded-full border border-white/25 px-3 py-1 text-xs font-medium text-white/90">{{ $child->name }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <span class="mt-7 inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-gray-900 transition group-hover:bg-brand-600 group-hover:text-white">
                                    Explore {{ $category->name }}
                                    <i data-lucide="arrow-right" class="h-4 w-4"></i>
                                </span>

                            </div>

                        </div>

                    </a>

                @endforeach

            </div>


            {{-- Mobile / tablet: image cards, first one wide --}}
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:hidden">

                @foreach ($categories as $i => $category)

                    <a href="{{ route('store.category', $category) }}"
                       class="group relative overflow-hidden rounded-2xl bg-gray-900 {{ $i === 0 ? 'col-span-2 aspect-[16/10] sm:col-span-3 sm:aspect-[21/9]' : 'aspect-[4/5]' }}">

                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-110">
                        @endif

                        <span class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-950/20 to-transparent"></span>

                        <span class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
                            <span class="block font-display text-lg font-bold text-white {{ $i === 0 ? 'sm:text-2xl' : '' }}">{{ $category->name }}</span>
                            <span class="mt-1 inline-flex items-center gap-1 text-xs font-medium text-white/80">
                                Explore <i data-lucide="arrow-right" class="h-3.5 w-3.5"></i>
                            </span>
                        </span>

                    </a>

                @endforeach

            </div>

        @endif

    </div>

</section>
