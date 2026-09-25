@php
    $onSale = $product->sale_price && (float) $product->sale_price < (float) $product->price;
@endphp

<a
    href="{{ route('store.product', $product) }}"
    class="group relative block overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl"
>

    <div class="relative aspect-square overflow-hidden bg-gray-100">

        @if ($onSale)

            <span class="absolute left-4 top-4 z-10 rounded-full bg-brand-red px-3 py-1 text-xs font-semibold text-white">
                Sale
            </span>

        @endif

        <button
            type="button"
            x-data="{ saved: JSON.parse(localStorage.getItem('yara_wishlist') || '[]').includes({{ $product->id }}) }"
            @click.stop.prevent="
                let list = JSON.parse(localStorage.getItem('yara_wishlist') || '[]');
                list = saved ? list.filter(id => id !== {{ $product->id }}) : [...list, {{ $product->id }}];
                localStorage.setItem('yara_wishlist', JSON.stringify(list));
                saved = !saved;
            "
            :class="saved ? 'bg-brand-red text-white' : 'bg-white text-gray-700 hover:bg-brand-600 hover:text-white'"
            class="absolute right-4 top-4 z-10 rounded-full p-2 shadow-sm transition"
            title="Save to wishlist"
        >
            <i data-lucide="heart" class="h-4 w-4" :class="saved ? 'fill-current' : ''"></i>
        </button>

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

            <span class="flex items-baseline gap-2">

                <span class="text-lg font-bold text-gray-900">
                    &#8377;{{ number_format($onSale ? $product->sale_price : $product->price, 2) }}
                </span>

                @if ($product->price_unit)
                    <span class="text-xs font-medium text-gray-500">/ {{ $product->price_unit }}</span>
                @endif

                @if ($onSale)

                    <span class="text-xs text-gray-400 line-through">
                        &#8377;{{ number_format($product->price, 2) }}
                    </span>

                @endif

            </span>

            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-brand-600 text-white transition group-hover:bg-brand-700">
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </span>

        </div>

    </div>

</a>
