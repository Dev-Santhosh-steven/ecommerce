{{--
    Testimonials spotlight: big image on the left, large quote on the right.
    Autoplays with a progress bar (pauses on hover), with arrows, thumbnails and swipe.
    Managed from Admin → Testimonials. Best image size: portrait 4:5 (e.g. 1080×1350).
--}}
@php
    $count = $testimonials->count();
    $star = 'M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z';
    $average = round($testimonials->avg('rating'), 1);
@endphp

<section id="testimonials" class="relative overflow-hidden bg-gray-950 py-24 text-white" data-no-auto-reveal>

    {{-- Ambient background --}}
    <div class="about-grid absolute inset-0 opacity-70"></div>
    <div class="about-blob -left-32 top-1/4 h-[28rem] w-[28rem] bg-brand-700"></div>
    <div class="about-blob -right-24 -top-10 h-80 w-80 bg-brand-red/40 [animation-delay:-6s]"></div>

    <div
        class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
        x-data="{
            active: 0,
            count: {{ $count }},
            duration: 7000,
            paused: false,
            elapsed: 0,
            last: null,
            touchX: null,
            init() {
                if (this.count < 2 || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                const tick = (now) => {
                    if (this.last !== null && ! this.paused && ! document.hidden) {
                        this.elapsed += now - this.last;
                        if (this.elapsed >= this.duration) this.go(this.active + 1);
                    }
                    this.last = now;
                    requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            },
            go(index) {
                this.active = (index + this.count) % this.count;
                this.elapsed = 0;
            },
            swipe(endX) {
                if (this.touchX === null) return;
                const dx = endX - this.touchX;
                if (Math.abs(dx) > 50) this.go(this.active + (dx < 0 ? 1 : -1));
                this.touchX = null;
            },
        }"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
        @keydown.left="go(active - 1)"
        @keydown.right="go(active + 1)"
    >

        {{-- Heading --}}
        <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>

            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-brand-400">Testimonials</p>
                <h2 class="mt-3 text-3xl font-bold sm:text-5xl">
                    Loved by customers<br class="hidden sm:block">
                    <span class="about-gradient-text">across India.</span>
                </h2>
            </div>

            <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-white/5 px-5 py-4 backdrop-blur">
                <p class="font-display text-4xl font-bold">{{ number_format($average, 1) }}</p>
                <div>
                    <div class="flex gap-0.5">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="h-4 w-4 {{ $i <= round($average) ? 'text-amber-400' : 'text-white/20' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="{{ $star }}"/></svg>
                        @endfor
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Average rating · {{ $count }} {{ Str::plural('review', $count) }}</p>
                </div>
            </div>

        </div>


        <div class="mt-14 grid items-center gap-10 lg:grid-cols-12 lg:gap-16"
             @touchstart.passive="touchX = $event.touches[0].clientX"
             @touchend="swipe($event.changedTouches[0].clientX)">

            {{-- Big image stage --}}
            <div class="relative mx-auto w-full max-w-md lg:col-span-5 lg:max-w-none" data-reveal="left">

                {{-- Offset brand frame --}}
                <div class="absolute -bottom-4 -right-4 left-6 top-6 rounded-[2rem] border-2 border-brand-600/60"></div>

                <div class="relative grid aspect-[4/5] overflow-hidden rounded-[2rem] bg-gray-900 shadow-2xl shadow-black/60 ring-1 ring-white/10">

                    @foreach ($testimonials as $i => $testimonial)

                        <div class="col-start-1 row-start-1 transition-all duration-[1100ms] ease-[cubic-bezier(0.16,1,0.3,1)]"
                             :class="active === {{ $i }} ? 'opacity-100 scale-100 blur-0' : 'pointer-events-none opacity-0 scale-110 blur-md'"
                             @if ($i > 0) style="opacity: 0" @endif
                             :style="''">

                            @if ($testimonial->photo)
                                <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                     alt="{{ $testimonial->name }}"
                                     @if ($i > 0) loading="lazy" @endif
                                     class="h-full w-full object-cover">
                            @else
                                <div class="brand-dots flex h-full w-full items-center justify-center bg-gradient-to-br from-brand-700 via-brand-900 to-gray-950">
                                    <span class="font-display text-8xl font-bold text-white/90">{{ $testimonial->initials }}</span>
                                </div>
                            @endif

                        </div>

                    @endforeach

                    <div class="pointer-events-none col-start-1 row-start-1 bg-gradient-to-t from-gray-950/60 via-transparent to-transparent"></div>

                </div>

                {{-- Floating rating badge --}}
                <div class="about-float absolute -left-3 bottom-10 flex items-center gap-3 rounded-2xl bg-white px-4 py-3 text-gray-900 shadow-2xl sm:-left-8">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-red text-white">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="{{ $star }}"/></svg>
                    </span>
                    <span>
                        @foreach ($testimonials as $i => $testimonial)
                            <span x-show="active === {{ $i }}" @if ($i > 0) x-cloak @endif class="block font-display text-lg font-bold leading-none">{{ $testimonial->rating }}.0 / 5</span>
                        @endforeach
                        <span class="block text-xs text-gray-500">Customer rating</span>
                    </span>
                </div>

                {{-- Counter --}}
                @if ($count > 1)
                    <div class="absolute right-5 top-5 rounded-full bg-gray-950/60 px-3 py-1.5 font-display text-sm font-semibold tabular-nums backdrop-blur">
                        <span x-text="String(active + 1).padStart(2, '0')">01</span>
                        <span class="text-white/50">/ {{ str_pad($count, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                @endif

            </div>


            {{-- Quote --}}
            <div class="lg:col-span-7" data-reveal="right" style="--reveal-delay: 150ms">

                <svg class="h-14 w-14 text-brand-600" viewBox="0 0 48 48" fill="currentColor" aria-hidden="true">
                    <path d="M20 10v6c-4.4 0-7 2.6-7 8h7v14H6V24C6 15 11 10 20 10zm22 0v6c-4.4 0-7 2.6-7 8h7v14H28V24c0-9 5-14 14-14z"/>
                </svg>

                <div class="mt-6 grid">
                    @foreach ($testimonials as $i => $testimonial)

                        <figure class="col-start-1 row-start-1 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                :class="active === {{ $i }} ? 'opacity-100 translate-y-0 blur-0' : 'pointer-events-none opacity-0 translate-y-6 blur-sm'"
                                @if ($i > 0) style="opacity: 0" @endif
                                :style="''"
                                :aria-hidden="active !== {{ $i }}">

                            <div class="flex gap-1" aria-label="{{ $testimonial->rating }} out of 5 stars">
                                @for ($s = 1; $s <= 5; $s++)
                                    <svg class="h-5 w-5 {{ $s <= $testimonial->rating ? 'text-amber-400' : 'text-white/15' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="{{ $star }}"/></svg>
                                @endfor
                            </div>

                            <blockquote class="mt-6 font-display text-2xl font-medium leading-snug text-white sm:text-3xl lg:text-[2.1rem] lg:leading-[1.3]">
                                “{{ $testimonial->message }}”
                            </blockquote>

                            <figcaption class="mt-8 flex items-center gap-4">
                                <span class="h-px w-12 bg-brand-red"></span>
                                <span>
                                    <span class="block text-lg font-bold">{{ $testimonial->name }}</span>
                                    @if ($testimonial->designation || $testimonial->company)
                                        <span class="block text-sm text-gray-400">{{ collect([$testimonial->designation, $testimonial->company])->filter()->implode(' · ') }}</span>
                                    @endif
                                </span>
                            </figcaption>

                        </figure>

                    @endforeach
                </div>


                {{-- Controls --}}
                @if ($count > 1)

                    <div class="mt-12 flex flex-wrap items-center gap-6">

                        <div class="flex gap-3">
                            <button type="button" @click="go(active - 1)" class="flex h-12 w-12 items-center justify-center rounded-full border border-white/20 text-white transition hover:border-brand-500 hover:bg-brand-600" aria-label="Previous testimonial">
                                <i data-lucide="arrow-left" class="h-5 w-5"></i>
                            </button>
                            <button type="button" @click="go(active + 1)" class="flex h-12 w-12 items-center justify-center rounded-full bg-brand-600 text-white transition hover:bg-brand-500" aria-label="Next testimonial">
                                <i data-lucide="arrow-right" class="h-5 w-5"></i>
                            </button>
                        </div>

                        {{-- Thumbnails with autoplay progress --}}
                        <div class="flex flex-1 gap-3 overflow-x-auto pb-1 [scrollbar-width:none]">
                            @foreach ($testimonials as $i => $testimonial)
                                <button type="button" @click="go({{ $i }})"
                                        class="group relative shrink-0 text-left"
                                        :class="active === {{ $i }} ? '' : 'opacity-50 hover:opacity-100'"
                                        aria-label="Show testimonial from {{ $testimonial->name }}">

                                    <span class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-2 pr-4 transition group-hover:bg-white/10">
                                        @if ($testimonial->photo)
                                            <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="" loading="lazy" class="h-11 w-11 rounded-xl object-cover">
                                        @else
                                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-brand-600 text-sm font-bold">{{ $testimonial->initials }}</span>
                                        @endif
                                        <span class="max-w-[8rem] truncate text-sm font-semibold">{{ $testimonial->name }}</span>
                                    </span>

                                    <span class="absolute inset-x-2 -bottom-1 h-0.5 overflow-hidden rounded-full bg-white/10">
                                        <span class="block h-full origin-left bg-brand-red"
                                              :style="active === {{ $i }} ? `transform: scaleX(${Math.min(1, elapsed / duration)})` : 'transform: scaleX(0)'"></span>
                                    </span>

                                </button>
                            @endforeach
                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>
