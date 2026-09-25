@extends('layouts.store')

@section('title', ($query !== '' ? 'Search: ' . $query : 'All Products') . ' | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">{{ $query !== '' ? 'Search Results' : 'All Products' }}</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            {{ $query !== '' ? 'Search Results' : 'All Products' }}
        </h1>

        <form action="{{ route('store.search') }}" method="GET" class="relative mt-6 max-w-xl">

            <i data-lucide="search" class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"></i>

            <input
                type="text"
                name="q"
                value="{{ $query }}"
                placeholder="Search for TVs, ACs, washing machines..."
                class="w-full rounded-full border-0 bg-white py-3.5 pl-12 pr-4 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-brand-500"
            >

        </form>

    </div>

</section>


{{-- =========================================================
     RESULTS
========================================================= --}}
<section class="bg-gray-50 py-14" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-8">

            <span class="text-sm text-gray-500">
                {{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}
                @if ($query !== '')
                    found for &ldquo;{{ $query }}&rdquo;
                @endif
            </span>

        </div>

        @if ($products->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-20 text-center text-gray-500">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                    <i data-lucide="search-x" class="h-7 w-7"></i>
                </div>

                <h3 class="mt-4 font-semibold text-gray-900">No products found</h3>
                <p class="mt-1 text-sm text-gray-500">Try a different search term, or browse by category instead.</p>

                <a href="{{ route('store.home') }}#categories" class="mt-5 inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
                    Browse Categories
                </a>

            </div>

        @else

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($products as $product)

                    @include('store.partials.product-card', ['product' => $product])

                @endforeach

            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>

        @endif

    </div>

</section>

@endsection
