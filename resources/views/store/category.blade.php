@extends('layouts.store')

@section('title', $category->name . ' | Yara Store')

@section('content')

{{-- =========================================================
     CATEGORY BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="relative aspect-[21/9] max-h-[420px] w-full overflow-hidden sm:aspect-[3/1]">

        @if ($category->banner)

            <img
                src="{{ asset('storage/' . $category->banner) }}"
                alt="{{ $category->name }}"
                class="h-full w-full object-cover opacity-70"
            >

        @elseif ($category->image)

            <img
                src="{{ asset('storage/' . $category->image) }}"
                alt="{{ $category->name }}"
                class="h-full w-full object-cover opacity-50"
            >

        @endif

        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-950/40 to-transparent"></div>

        <div class="absolute inset-0 flex items-end">

            <div class="mx-auto w-full max-w-7xl px-4 pb-10 sm:px-6 lg:px-8">

                <nav class="mb-3 text-sm text-gray-300">

                    <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>

                    @if ($category->parent)
                        <span class="mx-2">/</span>
                        <a href="{{ route('store.category', $category->parent) }}" class="hover:text-white">{{ $category->parent->name }}</a>
                    @endif

                    <span class="mx-2">/</span>
                    <span class="text-white">{{ $category->name }}</span>

                </nav>

                <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
                    {{ $category->name }}
                </h1>

                @if ($category->description)

                    <p class="mt-3 max-w-2xl text-gray-300">
                        {{ $category->description }}
                    </p>

                @endif

                @if ($hasLedCalculator)

                    <a href="{{ route('store.led-calculator') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-950/30 transition hover:bg-brand-500">
                        <i data-lucide="calculator" class="h-4 w-4"></i>
                        Open the LED Wall Calculator
                    </a>

                @endif

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     SUBCATEGORIES
========================================================= --}}
@if ($category->children->isNotEmpty())

    <section class="bg-white py-14">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-6 text-xl font-bold tracking-tight text-gray-900">
                Shop by Subcategory
            </h2>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">

                @foreach ($category->children as $child)

                    <a href="{{ route('store.category', $child) }}"
                       class="group relative overflow-hidden rounded-2xl bg-gray-100">

                        <div class="aspect-square">

                            @if ($child->image)

                                <img
                                    src="{{ asset('storage/' . $child->image) }}"
                                    alt="{{ $child->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                            @else

                                <div class="flex h-full w-full items-center justify-center bg-gray-200 text-gray-400">
                                    <i data-lucide="layers" class="h-8 w-8"></i>
                                </div>

                            @endif

                        </div>

                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-4 pt-10">

                            <h3 class="text-sm font-semibold text-white">
                                {{ $child->name }}
                            </h3>

                        </div>

                    </a>

                @endforeach

            </div>

        </div>

    </section>

@endif


{{-- =========================================================
     PRODUCTS + FILTERS
========================================================= --}}
<section class="bg-gray-50 py-14" x-data="{ mobileFiltersOpen: false }">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="lg:grid lg:grid-cols-[260px_1fr] lg:items-start lg:gap-10">

            {{-- Mobile backdrop --}}
            <div
                x-show="mobileFiltersOpen"
                x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @click="mobileFiltersOpen = false"
                class="fixed inset-0 z-40 bg-black/50 lg:hidden"
            ></div>

            {{-- Filters --}}
            <aside
                x-cloak
                :class="mobileFiltersOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-50 w-80 max-w-[85vw] overflow-y-auto bg-white transition-transform duration-300 lg:static lg:z-auto lg:mb-0 lg:w-auto lg:max-w-none lg:translate-x-0 lg:overflow-visible lg:bg-transparent lg:transition-none lg:sticky lg:top-24"
            >

                <div class="flex items-center justify-between border-b border-gray-200 p-5 lg:hidden">

                    <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">
                        Filters
                    </h2>

                    <button type="button" @click="mobileFiltersOpen = false" class="rounded-full p-1.5 text-gray-500 hover:bg-gray-100">
                        <i data-lucide="x" class="h-5 w-5"></i>
                    </button>

                </div>

                <form id="category-filters" method="GET" action="{{ route('store.category', $category) }}" class="space-y-8 p-5 lg:rounded-2xl lg:border lg:border-gray-200 lg:bg-white">

                    <div class="hidden items-center justify-between lg:flex">

                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-900">
                            Filters
                        </h2>

                        @if (!empty($selectedValueIds) || $priceMin !== null || $priceMax !== null)

                            <a href="{{ route('store.category', $category) }}" class="text-xs font-medium text-gray-500 underline hover:text-gray-900">
                                Clear all
                            </a>

                        @endif

                    </div>


                    {{-- Price --}}
                    <div>

                        <h3 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Price
                        </h3>

                        <div class="flex items-center gap-2">

                            <input
                                type="number"
                                name="price_min"
                                value="{{ $priceMin }}"
                                placeholder="{{ $priceBounds->min_price ? number_format($priceBounds->min_price, 0) : 'Min' }}"
                                min="0"
                                class="w-full rounded-lg border border-gray-300 px-2.5 py-2 text-sm focus:border-brand-500 focus:outline-none"
                            >

                            <span class="text-gray-400">&ndash;</span>

                            <input
                                type="number"
                                name="price_max"
                                value="{{ $priceMax }}"
                                placeholder="{{ $priceBounds->max_price ? number_format($priceBounds->max_price, 0) : 'Max' }}"
                                min="0"
                                class="w-full rounded-lg border border-gray-300 px-2.5 py-2 text-sm focus:border-brand-500 focus:outline-none"
                            >

                        </div>

                        <button
                            type="submit"
                            class="mt-3 w-full rounded-lg bg-brand-600 py-2 text-sm font-semibold text-white transition hover:bg-brand-700"
                        >
                            Apply Price
                        </button>

                    </div>


                    {{-- Attribute filters --}}
                    @foreach ($filterAttributes as $attribute)

                        @if ($attribute->values->isNotEmpty())

                            <div>

                                <h3 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    {{ $attribute->name }}
                                </h3>

                                <div class="space-y-2">

                                    @foreach ($attribute->values as $value)

                                        <label class="flex cursor-pointer items-center gap-2.5 text-sm text-gray-700">

                                            <input
                                                type="checkbox"
                                                name="attributes[]"
                                                value="{{ $value->id }}"
                                                onchange="this.form.submit()"
                                                {{ in_array($value->id, $selectedValueIds) ? 'checked' : '' }}
                                                class="h-4 w-4 rounded border-gray-300 text-gray-950 focus:ring-gray-500"
                                            >

                                            {{ $value->value }}

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    @endforeach

                    <button
                        type="submit"
                        class="w-full rounded-lg bg-brand-600 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700 lg:hidden"
                    >
                        Show {{ $products->total() }} {{ \Illuminate\Support\Str::plural('result', $products->total()) }}
                    </button>

                </form>

            </aside>


            {{-- Product grid --}}
            <div>

                <div class="mb-4 flex items-center justify-between gap-3">

                    <div>

                        <h2 class="text-xl font-bold tracking-tight text-gray-900">
                            Products
                        </h2>

                        <span class="text-sm text-gray-500">
                            {{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}
                        </span>

                    </div>

                    <div class="flex items-center gap-2">

                        <button
                            type="button"
                            @click="mobileFiltersOpen = true"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50 lg:hidden"
                        >
                            <i data-lucide="sliders-horizontal" class="h-4 w-4"></i>
                            Filters
                        </button>

                        <div class="relative">

                            <i data-lucide="arrow-up-down" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>

                            <select
                                name="sort"
                                form="category-filters"
                                onchange="document.getElementById('category-filters').submit()"
                                class="cursor-pointer appearance-none rounded-lg border border-gray-300 bg-white py-2.5 pl-9 pr-8 text-sm text-gray-700 focus:border-brand-500 focus:outline-none"
                            >
                                <option value="default" {{ $sort === 'default' ? 'selected' : '' }}>Sort: Featured</option>
                                <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                            </select>

                        </div>

                    </div>

                </div>


                @if ($selectedAttributeValues->isNotEmpty() || $priceMin !== null || $priceMax !== null)

                    <div class="mb-6 flex flex-wrap items-center gap-2">

                        @foreach ($selectedAttributeValues as $value)

                            <a
                                href="{{ route('store.category', array_merge(['category' => $category], request()->except('page') , ['attributes' => array_values(array_diff($selectedValueIds, [$value->id]))])) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-brand-700"
                            >
                                {{ $value->attribute->name }}: {{ $value->value }}
                                <i data-lucide="x" class="h-3 w-3"></i>
                            </a>

                        @endforeach

                        @if ($priceMin !== null || $priceMax !== null)

                            <a
                                href="{{ route('store.category', array_merge(['category' => $category], request()->except(['page', 'price_min', 'price_max']))) }}"
                                class="inline-flex items-center gap-1.5 rounded-full bg-brand-600 px-3 py-1.5 text-xs font-medium text-white transition hover:bg-brand-700"
                            >
                                Price: &#8377;{{ $priceMin ?? $priceBounds->min_price }} &ndash; &#8377;{{ $priceMax ?? $priceBounds->max_price }}
                                <i data-lucide="x" class="h-3 w-3"></i>
                            </a>

                        @endif

                    </div>

                @endif

                @if ($products->isEmpty())

                    <div class="rounded-2xl border border-dashed border-gray-300 py-16 text-center text-gray-500">
                        No products match the selected filters.
                    </div>

                @else

                    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">

                        @foreach ($products as $product)

                            @include('store.partials.product-card', ['product' => $product])

                        @endforeach

                    </div>

                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>

</section>

@endsection
