@extends('layouts.store')

@section('title', $category->name . ' | Yara Store')

@section('content')

{{-- =========================================================
     CATEGORY BANNER
========================================================= --}}
<section class="relative overflow-hidden bg-gray-950 text-white">

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
     PRODUCTS
========================================================= --}}
<section class="bg-gray-50 py-14">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-8 flex items-center justify-between">

            <h2 class="text-xl font-bold tracking-tight text-gray-900">
                Products
            </h2>

            <span class="text-sm text-gray-500">
                {{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}
            </span>

        </div>

        @if ($products->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 py-16 text-center text-gray-500">
                No products in this category yet.
            </div>

        @else

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($products as $product)

                    <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl">

                        <div class="relative aspect-square overflow-hidden bg-gray-100">

                            @if ($product->primaryImage)

                                <img
                                    src="{{ asset('storage/' . $product->primaryImage->image) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >

                            @else

                                <div class="flex h-full w-full items-center justify-center text-gray-300">
                                    <i data-lucide="image" class="h-10 w-10"></i>
                                </div>

                            @endif

                        </div>

                        <div class="p-5">

                            @if ($product->brand)

                                <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                                    {{ $product->brand }}
                                </p>

                            @endif

                            <h3 class="mt-2 font-semibold text-gray-900">
                                {{ $product->name }}
                            </h3>

                            @if ($product->short_description)

                                <p class="mt-2 line-clamp-2 text-sm text-gray-500">
                                    {{ $product->short_description }}
                                </p>

                            @endif

                            <div class="mt-5 flex items-center justify-between">

                                <span class="text-lg font-bold">
                                    &#8377;{{ number_format($product->sale_price ?? $product->price, 2) }}
                                </span>

                                <button class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-950 text-white transition hover:bg-gray-700">
                                    <i data-lucide="shopping-bag" class="h-4 w-4"></i>
                                </button>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>

        @endif

    </div>

</section>

@endsection
