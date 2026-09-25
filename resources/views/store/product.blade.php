@extends('layouts.store')

@section('title', $product->name . ' | Yara Store')

@section('content')

@php
    $whatsappMessage = rawurlencode("Hi, I'm interested in \"{$product->name}\" (" . url()->current() . '). Could you share more details?');
    $groupedAttributes = $product->attributeValues->groupBy(fn ($value) => $value->attribute->name);
    $onSale = $product->sale_price && (float) $product->sale_price < (float) $product->price;
@endphp

{{-- =========================================================
     BREADCRUMB
========================================================= --}}
<div class="border-b border-gray-200 bg-white">

    <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">

        <nav class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('store.home') }}" class="hover:text-gray-900">Home</a>
            <span>/</span>
            <a href="{{ route('store.category', $product->category) }}" class="hover:text-gray-900">{{ $product->category->name }}</a>
            <span>/</span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

    </div>

</div>


{{-- =========================================================
     PRODUCT OVERVIEW
========================================================= --}}
<section class="bg-white py-10" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid gap-10 lg:grid-cols-2">

            {{-- Gallery --}}
            <div
                x-data="{
                    images: {{ $product->images->isNotEmpty() ? $product->images->pluck('image')->map(fn ($img) => asset('storage/' . $img))->toJson() : '[]' }},
                    active: 0,
                    zoomed: false,
                    zoomX: 50,
                    zoomY: 50,
                    handleMove(e) {
                        const rect = e.currentTarget.getBoundingClientRect();
                        this.zoomX = ((e.clientX - rect.left) / rect.width) * 100;
                        this.zoomY = ((e.clientY - rect.top) / rect.height) * 100;
                    },
                }"
            >

                <div
                    class="group relative aspect-square cursor-zoom-in overflow-hidden rounded-2xl border border-gray-200 bg-gray-50"
                    @mousemove="handleMove($event)"
                    @mouseenter="zoomed = true"
                    @mouseleave="zoomed = false"
                >

                    <template x-if="images.length > 0">
                        <img
                            :src="images[active]"
                            :alt="{{ \Illuminate\Support\Js::from($product->name) }}"
                            class="h-full w-full object-contain p-6 transition-transform duration-300 ease-out"
                            :style="zoomed ? `transform: scale(2.1); transform-origin: ${zoomX}% ${zoomY}%;` : ''"
                        >
                    </template>

                    <template x-if="images.length === 0">
                        <div class="flex h-full w-full items-center justify-center text-gray-300">
                            <i data-lucide="image" class="h-16 w-16"></i>
                        </div>
                    </template>

                    <div
                        x-show="images.length > 0 && !zoomed"
                        class="pointer-events-none absolute bottom-3 right-3 flex items-center gap-1.5 rounded-full bg-white/90 px-3 py-1.5 text-xs font-medium text-gray-600 opacity-0 shadow-sm backdrop-blur transition group-hover:opacity-100"
                    >
                        <i data-lucide="zoom-in" class="h-3.5 w-3.5"></i>
                        Hover to zoom
                    </div>

                </div>

                <div class="mt-4 grid grid-cols-5 gap-3" x-show="images.length > 1">

                    <template x-for="(image, index) in images" :key="index">
                        <button
                            type="button"
                            @click="active = index"
                            class="aspect-square overflow-hidden rounded-xl border-2 bg-gray-50 transition"
                            :class="active === index ? 'border-gray-950' : 'border-transparent hover:border-gray-300'"
                        >
                            <img :src="image" class="h-full w-full object-contain p-1.5">
                        </button>
                    </template>

                </div>

            </div>


            {{-- Details --}}
            <div
                x-data="{
                    saved: JSON.parse(localStorage.getItem('yara_wishlist') || '[]').includes({{ $product->id }}),
                    toggle() {
                        let list = JSON.parse(localStorage.getItem('yara_wishlist') || '[]');
                        list = this.saved ? list.filter(id => id !== {{ $product->id }}) : [...list, {{ $product->id }}];
                        localStorage.setItem('yara_wishlist', JSON.stringify(list));
                        this.saved = !this.saved;
                    },
                }"
            >

                <div class="flex items-start justify-between gap-4">

                    <div>
                        @if ($product->brand)
                            <p class="text-sm font-semibold uppercase tracking-wider text-gray-400">
                                {{ $product->brand }}
                            </p>
                        @endif

                        <h1 class="mt-1 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            {{ $product->name }}
                        </h1>
                    </div>

                    <button
                        type="button"
                        @click="toggle()"
                        :class="saved ? 'bg-brand-red text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200'"
                        class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full transition"
                        title="Save to wishlist"
                    >
                        <i data-lucide="heart" class="h-5 w-5" :class="saved ? 'fill-current' : ''"></i>
                    </button>

                </div>


                @if ($groupedAttributes->isNotEmpty())

                    <div class="mt-4 flex flex-wrap gap-2">

                        @foreach ($groupedAttributes as $attributeName => $values)

                            @foreach ($values as $value)

                                <span class="rounded-full border border-gray-200 bg-gray-50 px-3 py-1 text-xs font-medium text-gray-700">
                                    {{ $attributeName }}: {{ $value->value }}
                                </span>

                            @endforeach

                        @endforeach

                    </div>

                @endif


                <div class="mt-6 flex items-baseline gap-3">

                    <span class="text-3xl font-bold text-gray-900">
                        &#8377;{{ number_format($onSale ? $product->sale_price : $product->price, 2) }}
                    </span>

                    @if ($product->price_unit)
                        <span class="text-sm font-medium text-gray-500">/ {{ $product->price_unit }}</span>
                    @endif

                    @if ($onSale)

                        <span class="text-lg text-gray-400 line-through">
                            &#8377;{{ number_format($product->price, 2) }}
                        </span>

                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                            {{ round((1 - $product->sale_price / $product->price) * 100) }}% off
                        </span>

                    @endif

                </div>


                <div class="mt-4">

                    @if ($product->stock_quantity > 0)

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                            In Stock
                        </span>

                    @else

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-500">
                            <span class="h-1.5 w-1.5 rounded-full bg-gray-400"></span>
                            Out of Stock
                        </span>

                    @endif

                </div>


                @if ($product->short_description)

                    <p class="mt-5 leading-7 text-gray-600">
                        {{ $product->short_description }}
                    </p>

                @endif


                <div class="mt-8 flex flex-wrap gap-3">

                    <a
                        href="https://wa.me/919842881500?text={{ $whatsappMessage }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-700"
                    >
                        <i data-lucide="message-circle" class="h-4 w-4"></i>
                        Enquire on WhatsApp
                    </a>

                    <a
                        href="tel:9842881500"
                        class="inline-flex items-center gap-2 rounded-full border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                    >
                        <i data-lucide="phone" class="h-4 w-4"></i>
                        Call to Enquire
                    </a>

                    @if ($product->ledModule?->is_active)

                        <a
                            href="{{ route('store.led-calculator', ['module' => $product->ledModule->id]) }}"
                            class="inline-flex items-center gap-2 rounded-full border border-brand-600 px-6 py-3 text-sm font-semibold text-brand-700 transition hover:bg-brand-50"
                        >
                            <i data-lucide="ruler" class="h-4 w-4"></i>
                            Size My LED Wall
                        </a>

                    @endif

                </div>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     KEY FEATURES
========================================================= --}}
@if ($product->features->isNotEmpty())

    <section class="bg-gray-50 py-16" data-reveal>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mx-auto mb-12 max-w-2xl text-center">

                <p class="brand-eyebrow text-sm font-semibold uppercase tracking-[0.2em]">
                    Why You'll Love It
                </p>

                <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                    Key Features
                </h2>

            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($product->features as $feature)

                    <div class="rounded-2xl border border-gray-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:shadow-lg">

                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-600 text-white">
                            <i data-lucide="{{ $feature->icon }}" class="h-6 w-6"></i>
                        </div>

                        <h3 class="mt-5 font-semibold text-gray-900">
                            {{ $feature->title }}
                        </h3>

                        @if ($feature->description)

                            <p class="mt-2 text-sm leading-6 text-gray-500">
                                {{ $feature->description }}
                            </p>

                        @endif

                    </div>

                @endforeach

            </div>

        </div>

    </section>

@endif


{{-- =========================================================
     DESCRIPTION
========================================================= --}}
@if ($product->description)

    <section class="bg-white py-14" data-reveal>

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-4 text-xl font-bold tracking-tight text-gray-900">
                About This Product
            </h2>

            <div class="leading-7 text-gray-600">
                {!! nl2br(e($product->description)) !!}
            </div>

        </div>

    </section>

@endif


{{-- =========================================================
     SPECIFICATIONS
========================================================= --}}
@if (!empty($product->specifications))

    <section class="bg-gray-50 py-14" data-reveal>

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-6 text-xl font-bold tracking-tight text-gray-900">
                Specifications
            </h2>

            <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white">

                <dl class="divide-y divide-gray-200">

                    @foreach ($product->specifications as $key => $value)

                        <div class="flex items-center justify-between gap-4 px-5 py-3.5 text-sm">
                            <dt class="text-gray-500">{{ $key }}</dt>
                            <dd class="text-right font-medium text-gray-900">{{ $value }}</dd>
                        </div>

                    @endforeach

                </dl>

            </div>

        </div>

    </section>

@endif


{{-- =========================================================
     RELATED PRODUCTS
========================================================= --}}
@if ($related->isNotEmpty())

    <section class="bg-white py-14" data-reveal>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <h2 class="mb-8 text-xl font-bold tracking-tight text-gray-900">
                You May Also Like
            </h2>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @foreach ($related as $item)

                    @include('store.partials.product-card', ['product' => $item])

                @endforeach

            </div>

        </div>

    </section>

@endif

@endsection
