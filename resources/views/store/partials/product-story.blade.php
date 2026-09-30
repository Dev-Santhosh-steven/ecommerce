{{--
    Product page: "About this product" as a numbered story beside a floating showcase, then the
    specifications as headline tiles + grouped cards with tabs and live search.
--}}
@php
    use App\Support\SpecSheet;
    use Illuminate\Support\Str;

    $paragraphs = collect(preg_split("/\n\s*\n/", trim((string) $product->description)))->map(fn ($p) => trim($p))->filter()->values();
    $showcase = $product->images->get(1) ?? $product->images->first();
    $headlines = SpecSheet::headlines($product->specifications, 3);
    $specRows = collect(SpecSheet::visible($product->specifications))->map(fn ($v, $k) => [$k, (string) $v])->values()->all();
    $specTiles = SpecSheet::headlines($product->specifications, 4);
    $specCount = count($specRows);
@endphp

{{-- =========================================================
     ABOUT
========================================================= --}}
@if ($paragraphs->isNotEmpty())

    <section class="relative overflow-hidden bg-gradient-to-b from-[#faf6f6] via-[#f6f3f3] to-white py-20 sm:py-24">
        <div class="pointer-events-none absolute inset-0 opacity-50 [background-image:radial-gradient(circle,rgb(165_29_53/0.12)_1px,transparent_1.6px)] [background-size:22px_22px] [mask-image:linear-gradient(to_bottom,black,transparent_80%)]"></div>
        <div class="pointer-events-none absolute -right-40 top-10 h-[28rem] w-[28rem] rounded-full bg-brand-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-40 bottom-0 h-[24rem] w-[24rem] rounded-full bg-brand-300/15 blur-3xl"></div>

        <div class="relative mx-auto grid max-w-[1500px] gap-14 px-4 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:px-10">

            {{-- story --}}
            <div>
                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]" data-reveal>About this product</p>
                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl" data-reveal>
                    {{ Str::before($product->name, ' · ') }}
                </h2>

                <ol class="relative mt-10 space-y-4" data-reveal>
                    <span class="about-rail absolute bottom-6 left-[2.35rem] top-6 w-px bg-gradient-to-b from-brand-500 via-brand-300 to-transparent"></span>
                    @foreach ($paragraphs as $i => $paragraph)
                        <li class="group relative grid grid-cols-[2.5rem_1fr] gap-5 rounded-2xl border border-white bg-white/80 p-5 shadow-sm shadow-brand-900/5 ring-1 ring-gray-200/70 backdrop-blur transition duration-300 hover:-translate-y-0.5 hover:shadow-lg hover:ring-brand-200 sm:p-6"
                            data-reveal style="--reveal-delay: {{ $i * 120 }}ms">
                            <span class="relative z-10 flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-600 to-brand-red font-display text-xs font-bold text-white shadow-md shadow-brand-600/25">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <p class="self-center text-base leading-7 {{ $i === 0 ? 'font-medium text-gray-900 sm:text-lg sm:leading-8' : 'text-gray-600 sm:text-[17px]' }}">
                                {{ $paragraph }}
                            </p>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- showcase --}}
            <div class="lg:sticky lg:top-28 lg:self-start" data-reveal="right">
                <div class="about-shine relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-gray-950 via-[#1a1012] to-gray-900 p-8 shadow-2xl shadow-gray-900/20 sm:p-10">
                    <div class="about-blob -left-16 -top-16 h-72 w-72 bg-brand-700/60"></div>
                    <div class="about-blob -bottom-20 -right-10 h-72 w-72 bg-brand-red/30 [animation-delay:-6s]"></div>

                    @if ($showcase)
                        <div class="relative flex aspect-[4/3] items-center justify-center">
                            <div class="absolute inset-[18%] rounded-full bg-white/10 blur-3xl"></div>
                            <img src="{{ asset('storage/' . $showcase->image) }}" alt="{{ $product->name }}" loading="lazy"
                                 class="about-float relative max-h-full w-auto max-w-full rounded-xl object-contain drop-shadow-[0_30px_40px_rgba(0,0,0,0.55)]">
                        </div>
                    @endif

                    @if ($product->features->isNotEmpty())
                        <div class="relative mt-6 flex flex-wrap gap-2">
                            @foreach ($product->features->take(3) as $k => $feature)
                                <span class="cd-chip inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-3.5 py-1.5 text-xs font-semibold text-white backdrop-blur" style="animation-delay: -{{ $k * 1.5 }}s">
                                    <i data-lucide="{{ $feature->icon }}" class="h-3.5 w-3.5 text-brand-300"></i>
                                    {{ $feature->title }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    @if ($headlines)
                        <dl class="relative mt-6 grid gap-3 {{ [1 => "grid-cols-1", 2 => "grid-cols-2", 3 => "grid-cols-3"][count($headlines)] ?? "grid-cols-3" }}">
                            @foreach ($headlines as [$label, $value])
                                <div class="rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                                    <dt class="text-[10px] font-semibold uppercase tracking-[0.18em] text-gray-400">{{ $label }}</dt>
                                    <dd class="mt-1.5 break-words font-display text-base font-bold leading-tight text-white">{{ $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    @endif
                </div>
            </div>

        </div>
    </section>

@endif


{{-- =========================================================
     SPECIFICATIONS
========================================================= --}}
@if ($specRows)

    <section class="relative overflow-hidden bg-[#0b0a0a] py-20 text-white sm:py-24"
             x-data="{ q: '', hit(text) { return ! this.q || text.includes(this.q.toLowerCase()) } }">
        <div class="about-grid absolute inset-0 opacity-40"></div>
        <div class="about-blob -left-40 top-1/3 h-[30rem] w-[30rem] bg-brand-800/60"></div>

        <div class="relative mx-auto max-w-[1500px] px-4 sm:px-6 lg:px-10">

            <div class="flex flex-col justify-between gap-6 md:flex-row md:items-end" data-reveal>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-400">Specifications</p>
                    <h2 class="mt-3 text-3xl font-bold sm:text-5xl">Every detail, <span class="about-gradient-text">in the open.</span></h2>
                    <p class="mt-3 text-gray-400">{{ $specCount }} specifications.</p>
                </div>
                <label class="relative block w-full md:w-80">
                    <i data-lucide="search" class="pointer-events-none absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"></i>
                    <input type="search" x-model.debounce.150ms="q" placeholder="Search specs, e.g. HDMI" aria-label="Search specifications"
                           class="w-full rounded-full border border-white/10 bg-white/5 py-3 pl-11 pr-4 text-sm text-white placeholder:text-gray-500 focus:border-brand-500 focus:outline-none focus:ring-0">
                </label>
            </div>

            @if ($specTiles)
                <div class="mt-12 grid grid-cols-2 gap-px overflow-hidden rounded-3xl bg-white/10 {{ ['', 'lg:grid-cols-1', 'lg:grid-cols-2', 'lg:grid-cols-3', 'lg:grid-cols-4'][count($specTiles)] }}">
                    @foreach ($specTiles as $k => [$label, $value])
                        <div class="group bg-[#0f0d0d] p-6 transition duration-500 hover:bg-[#171313] sm:p-8" data-reveal style="--reveal-delay: {{ $k * 110 }}ms">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 transition group-hover:text-brand-300">{{ $label }}</p>
                            <p class="mt-3 break-words font-display text-2xl font-extrabold leading-tight sm:text-3xl">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- all specifications, exactly as entered in the admin panel (no guessed groups) --}}
            <dl class="mt-10 grid gap-x-10 overflow-hidden rounded-3xl border border-white/10 bg-white/[0.04] px-6 py-2 backdrop-blur md:grid-cols-2">
                @foreach ($specRows as [$key, $value])
                    <div class="grid grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] gap-4 border-b border-white/5 py-3.5 text-sm transition hover:bg-white/[0.03]"
                         x-show="hit(@js(Str::lower($key . ' ' . $value)))">
                        <dt class="text-gray-400">{{ $key }}</dt>
                        <dd class="text-right font-medium text-gray-100">{{ $value }}</dd>
                    </div>
                @endforeach
            </dl>

        </div>
    </section>

@endif
