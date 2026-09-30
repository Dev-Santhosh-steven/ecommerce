@extends('layouts.store')

@section('title', 'My wishlist | Yara Electronics')

@section('content')

<section class="bg-gradient-to-br from-gray-950 via-[#1a0d10] to-brand-950 text-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <nav class="text-sm text-white/60"><a href="{{ route('account.index') }}" class="hover:text-white">My account</a> <span class="mx-2">/</span> <span class="text-white">Wishlist</span></nav>
        <h1 class="mt-3 text-3xl font-bold sm:text-4xl">My wishlist <span class="text-white/50">({{ $items->count() }})</span></h1>
    </div>
</section>

<section class="min-h-[50vh] bg-[#f5f3f2] py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        @if ($items->isEmpty())
            <div class="mx-auto max-w-md py-16 text-center">
                <span class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-brand-50 text-brand-600"><i data-lucide="heart" class="h-9 w-9"></i></span>
                <h2 class="mt-5 font-display text-2xl font-bold">Your wishlist is empty</h2>
                <p class="mt-2 text-gray-500">Tap the heart on any product to save it here.</p>
                <a href="{{ route('store.search') }}" class="mt-6 inline-flex rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700">Browse products</a>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($items as $item)
                    @php $p = $item->product; @endphp
                    <article class="flex flex-col overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:shadow-lg">
                        <a href="{{ $p->url() }}" class="relative block aspect-square bg-gray-50">
                            @if ($p->primaryImage)
                                <img src="{{ asset('storage/' . $p->primaryImage->image) }}" alt="{{ $p->name }}" loading="lazy" class="h-full w-full object-contain p-4">
                            @endif
                        </a>
                        <div class="flex flex-1 flex-col p-5">
                            <a href="{{ $p->url() }}" class="line-clamp-2 font-semibold text-gray-900 hover:text-brand-600">{{ $p->name }}</a>
                            <p class="mt-2">
                                @if ($p->hasPrice())
                                    <span class="text-lg font-bold">&#8377;{{ number_format($p->unitPrice()) }}</span>
                                    @if ($p->unitPrice() < (float) $p->price)
                                        <span class="ml-1 text-sm text-gray-400 line-through">&#8377;{{ number_format($p->price) }}</span>
                                    @endif
                                @else
                                    <span class="font-semibold text-gray-700">Price on request</span>
                                @endif
                            </p>
                            <p class="mt-1 text-xs text-gray-400">Saved {{ $item->created_at->diffForHumans() }}</p>

                            <div class="mt-auto flex gap-2 pt-5">
                                @if ($p->isPurchasable())
                                    <form method="POST" action="{{ route('wishlist.to-cart', $p) }}" class="flex-1">
                                        @csrf
                                        <button class="flex w-full items-center justify-center gap-2 rounded-full bg-brand-600 py-2.5 text-sm font-semibold text-white transition hover:bg-brand-700">
                                            <i data-lucide="shopping-bag" class="h-4 w-4"></i> Move to cart
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ $p->url() }}" class="flex flex-1 items-center justify-center rounded-full bg-gray-900 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800">Enquire</a>
                                @endif
                                <form method="POST" action="{{ route('wishlist.destroy', $p) }}">
                                    @csrf @method('DELETE')
                                    <button class="flex h-10 w-10 items-center justify-center rounded-full ring-1 ring-gray-200 text-gray-500 transition hover:bg-gray-50 hover:text-brand-600" aria-label="Remove from wishlist">
                                        <i data-lucide="trash-2" class="h-4 w-4"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

    </div>
</section>

@endsection
