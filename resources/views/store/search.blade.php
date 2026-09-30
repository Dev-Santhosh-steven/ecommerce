@extends('layouts.store')

@section('title', ($query !== '' ? 'Search: ' . $query : 'All Products') . ' | Yara Store')

@php
    $parsed = $result->parsed;
    $chips = $parsed->chips();

    // Current search with some parameters changed (null removes one); always back to page 1.
    $searchUrl = function (array $changes) {
        $params = array_merge(request()->except('page'), $changes);

        return route('store.search', array_filter($params, fn ($v) => $v !== null && $v !== []));
    };

    $examples = ['TV under 20k', 'AC for bedroom', 'Washing machine for family of 5', 'Cheapest 55 inch smart TV', 'Smart board for classroom', '1.5 ton 5 star AC'];
@endphp

@section('content')

{{-- =========================================================
     BANNER + SEARCH BOX
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $query !== '' ? 'Search Results' : 'All Products' }}</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            {{ $query !== '' ? 'Search Results' : 'All Products' }}
        </h1>

        <form action="{{ route('store.search') }}" method="GET" class="relative mt-6 max-w-2xl">
            <i data-lucide="search" class="pointer-events-none absolute left-5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"></i>
            <input
                type="text"
                name="q"
                value="{{ $query }}"
                placeholder="Try “TV under 20000” or “AC for bedroom”"
                autocomplete="off"
                class="w-full rounded-full border-0 bg-white py-4 pl-14 pr-32 text-base text-gray-900 shadow-lg focus:outline-none focus:ring-2 focus:ring-brand-500"
            >
            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                Search
            </button>
        </form>

        <div class="mt-4 flex flex-wrap items-center gap-2 text-sm text-gray-300">
            <span>Try:</span>
            @foreach ($examples as $example)
                <a href="{{ route('store.search', ['q' => $example]) }}" class="rounded-full border border-white/20 px-3 py-1 transition hover:border-white/50 hover:bg-white/10 hover:text-white">{{ $example }}</a>
            @endforeach
        </div>

    </div>

</section>


{{-- =========================================================
     RESULTS
========================================================= --}}
<section class="bg-gray-50 py-12">

    <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

        {{-- What we understood --}}
        @if ($query !== '' && ($chips || $parsed->corrected))
            <div class="rounded-2xl border border-gray-200 bg-white p-5">

                @if ($parsed->corrected)
                    <p class="text-sm text-gray-600">
                        Showing results for <strong class="text-gray-900">{{ $parsed->corrected }}</strong>.
                    </p>
                @endif

                @if ($chips)
                    <div class="flex flex-wrap items-center gap-2 {{ $parsed->corrected ? 'mt-3' : '' }}">
                        <span class="text-sm font-medium text-gray-500">We understood:</span>
                        @foreach ($chips as $key => $label)
                            <a href="{{ $key === 'category' && $category ? $searchUrl(['category' => null]) : $searchUrl(['drop' => [...$drop, $key]]) }}"
                               class="group inline-flex items-center gap-1.5 rounded-full bg-brand-50 px-3 py-1.5 text-sm font-medium text-brand-700 ring-1 ring-brand-100 transition hover:bg-brand-100"
                               title="Remove">
                                {{ $label }}
                                <i data-lucide="x" class="h-3.5 w-3.5 opacity-60 group-hover:opacity-100"></i>
                            </a>
                        @endforeach
                        @if ($drop || $category)
                            <a href="{{ route('store.search', ['q' => $query]) }}" class="text-sm font-medium text-gray-500 underline-offset-2 hover:text-gray-900 hover:underline">Reset</a>
                        @endif
                    </div>
                @endif

            </div>
        @endif


        {{-- Quick answer from the help centre --}}
        @if ($result->answer)
            <div class="flex gap-4 rounded-2xl border border-brand-100 bg-white p-6 shadow-sm">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-600 text-white">
                    <i data-lucide="message-circle-question" class="h-5 w-5"></i>
                </span>
                <div class="min-w-0">
                    <p class="font-semibold text-gray-900">{{ $result->answer->question }}</p>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ $result->answer->answer }}</p>
                    @if ($result->answer->button_text && $result->answer->button_url)
                        <a href="{{ str_starts_with($result->answer->button_url, '/') ? url($result->answer->button_url) : $result->answer->button_url }}"
                           @if (! str_starts_with($result->answer->button_url, '/')) target="_blank" rel="noopener noreferrer" @endif
                           class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700">
                            {{ $result->answer->button_text }}
                            <i data-lucide="arrow-right" class="h-4 w-4"></i>
                        </a>
                    @endif
                </div>
            </div>
        @endif


        {{-- Notes: what we relaxed, what we don't make --}}
        @foreach ($result->notes as $note)
            <div class="flex items-start gap-3 rounded-2xl border border-amber-200 bg-amber-50 px-5 py-4 text-sm text-amber-900">
                <i data-lucide="info" class="mt-0.5 h-4 w-4 shrink-0"></i>
                <p>{{ $note }}</p>
            </div>
        @endforeach


        @if ($products->total() > 0)

            {{-- Toolbar --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-sm text-gray-500">
                    {{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}
                    @if ($query !== '' && ! $result->fallback)
                        for &ldquo;{{ $query }}&rdquo;
                    @endif
                </p>

                <form action="{{ route('store.search') }}" method="GET" class="flex items-center gap-2">
                    @foreach (request()->except(['sort', 'page']) as $name => $value)
                        @foreach ((array) $value as $v)
                            <input type="hidden" name="{{ is_array($value) ? $name . '[]' : $name }}" value="{{ $v }}">
                        @endforeach
                    @endforeach
                    <label for="sort" class="text-sm text-gray-500">Sort by</label>
                    <select id="sort" name="sort" onchange="this.form.submit()"
                            class="rounded-full border-gray-300 bg-white py-2 pl-4 pr-9 text-sm font-medium text-gray-900 focus:border-brand-500 focus:ring-brand-500">
                        @foreach ($sorts as $value => $label)
                            <option value="{{ $value }}" @selected($currentSort === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>

            </div>

            {{-- Narrow by category --}}
            @if (count($result->facets) > 1 || $category)
                <div class="flex flex-wrap gap-2">
                    <a href="{{ $searchUrl(['category' => null]) }}"
                       class="rounded-full px-4 py-2 text-sm font-medium ring-1 transition {{ $category ? 'bg-white text-gray-700 ring-gray-200 hover:ring-gray-300' : 'bg-gray-900 text-white ring-gray-900' }}">
                        All
                    </a>
                    @foreach ($result->facets as $facet)
                        <a href="{{ $searchUrl(['category' => $facet['slug']]) }}"
                           class="rounded-full px-4 py-2 text-sm font-medium ring-1 transition {{ $category === $facet['slug'] ? 'bg-gray-900 text-white ring-gray-900' : 'bg-white text-gray-700 ring-gray-200 hover:ring-gray-300' }}">
                            {{ $facet['name'] }} <span class="ml-1 text-xs opacity-60">{{ $facet['count'] }}</span>
                        </a>
                    @endforeach
                </div>
            @endif

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal>
                @foreach ($products as $product)
                    @include('store.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <div>
                {{ $products->links() }}
            </div>

        @elseif (! $result->answer && ! $result->pages)

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center text-gray-500">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                    <i data-lucide="search-x" class="h-7 w-7"></i>
                </div>
                <h3 class="mt-4 font-semibold text-gray-900">No products found</h3>
                <p class="mx-auto mt-1 max-w-md text-sm text-gray-500">
                    Search the way you'd ask in a shop: a product, a budget, a size or a room.
                </p>
                <div class="mt-5 flex flex-wrap justify-center gap-2">
                    @foreach ($examples as $example)
                        <a href="{{ route('store.search', ['q' => $example]) }}" class="rounded-full bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-brand-50 hover:text-brand-700">{{ $example }}</a>
                    @endforeach
                </div>
            </div>

        @endif


        {{-- Pages, guides and articles --}}
        @if ($result->pages)
            <div>
                <h2 class="text-lg font-bold text-gray-900">Pages &amp; guides</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($result->pages as $page)
                        <a href="{{ $page['url'] }}" class="group flex gap-3 rounded-2xl border border-gray-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-lg">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-600 transition group-hover:bg-brand-600 group-hover:text-white">
                                <i data-lucide="{{ $page['icon'] }}" class="h-5 w-5"></i>
                            </span>
                            <span class="min-w-0">
                                <span class="block text-xs font-semibold uppercase tracking-wider text-brand-600">{{ $page['kind'] }}</span>
                                <span class="mt-0.5 block font-semibold leading-snug text-gray-900">{{ $page['title'] }}</span>
                                @if ($page['summary'])
                                    <span class="mt-1 block text-sm leading-5 text-gray-500">{{ $page['summary'] }}</span>
                                @endif
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

</section>

@endsection
