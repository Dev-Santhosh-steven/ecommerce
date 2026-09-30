@extends('layouts.store')

@section('title', 'Your cart | Yara Electronics')

@section('content')

<section class="bg-gradient-to-br from-gray-950 via-[#1a0d10] to-brand-950 text-white">
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold sm:text-4xl">Your cart <span class="text-white/50">({{ $summary['count'] }} {{ Str::plural('item', $summary['count']) }})</span></h1>
        {{-- checkout steps --}}
        <ol class="mt-6 flex items-center gap-3 text-xs font-semibold uppercase tracking-wider sm:text-sm">
            @foreach (['Cart', 'Address', 'Payment', 'Done'] as $i => $step)
                <li class="flex items-center gap-3 {{ $i === 0 ? 'text-white' : 'text-white/40' }}">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full {{ $i === 0 ? 'bg-brand-600' : 'bg-white/10' }}">{{ $i + 1 }}</span>
                    {{ $step }}
                    @unless ($loop->last)<span class="h-px w-6 bg-white/20 sm:w-12"></span>@endunless
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="min-h-[50vh] bg-[#f5f3f2] py-10">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        @if ($items->isEmpty())
            <div class="mx-auto max-w-md rounded-3xl bg-white py-16 text-center shadow-sm ring-1 ring-gray-200">
                <span class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-brand-50 text-brand-600"><i data-lucide="shopping-bag" class="h-9 w-9"></i></span>
                <h2 class="mt-5 font-display text-2xl font-bold">Your cart is empty</h2>
                <p class="mt-2 text-gray-500">Explore TVs, ACs, washing machines and more.</p>
                <div class="mt-6 flex justify-center gap-3">
                    <a href="{{ route('store.search') }}" class="rounded-full bg-brand-600 px-6 py-3 text-sm font-semibold text-white hover:bg-brand-700">Start shopping</a>
                    @auth
                        <a href="{{ route('wishlist.index') }}" class="rounded-full border border-gray-300 px-6 py-3 text-sm font-semibold hover:bg-gray-50">Wishlist</a>
                    @else
                        <a href="{{ route('login', ['redirect' => '/cart']) }}" class="rounded-full border border-gray-300 px-6 py-3 text-sm font-semibold hover:bg-gray-50">Sign in</a>
                    @endauth
                </div>
            </div>
        @else
            <div class="grid items-start gap-8 lg:grid-cols-[1fr_380px]">

                {{-- items --}}
                <div class="space-y-4">
                    @guest
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-white p-4 text-sm shadow-sm ring-1 ring-gray-200">
                            <span class="flex items-center gap-2 text-gray-600"><i data-lucide="info" class="h-4 w-4 text-brand-600"></i>Sign in to keep your cart on every device.</span>
                            <a href="{{ route('login', ['redirect' => '/cart']) }}" class="font-semibold text-brand-600 hover:underline">Sign in</a>
                        </div>
                    @endguest

                    @foreach ($items as $item)
                        @php $p = $item->product; $max = min(\App\Services\Cart::MAX_QTY, max(1, (int) $p->stock_quantity)); @endphp
                        <article class="flex gap-5 rounded-3xl bg-white p-5 shadow-sm ring-1 ring-gray-200 sm:p-6">
                            <a href="{{ $p->url() }}" class="h-28 w-28 shrink-0 overflow-hidden rounded-2xl bg-gray-50 ring-1 ring-gray-100 sm:h-36 sm:w-36">
                                @if ($p->primaryImage)
                                    <img src="{{ asset('storage/' . $p->primaryImage->image) }}" alt="{{ $p->name }}" class="h-full w-full object-contain p-2">
                                @endif
                            </a>
                            <div class="flex min-w-0 flex-1 flex-col">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <a href="{{ $p->url() }}" class="line-clamp-2 font-semibold text-gray-900 hover:text-brand-600">{{ $p->name }}</a>
                                        <p class="mt-1 text-xs text-gray-500">{{ $p->model_number }}</p>
                                        <p class="mt-1 text-xs font-semibold {{ $p->stock_quantity > 0 ? 'text-emerald-600' : 'text-brand-600' }}">{{ $p->stock_quantity > 0 ? 'In stock' : 'Out of stock' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-display text-xl font-extrabold">&#8377;{{ number_format($item->lineTotal()) }}</p>
                                        @if ($p->unitPrice() < (float) $p->price)
                                            <p class="text-xs text-gray-400 line-through">&#8377;{{ number_format($p->price * $item->quantity) }}</p>
                                            <p class="text-xs font-semibold text-emerald-600">{{ round((1 - $p->unitPrice() / $p->price) * 100) }}% off</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-auto flex flex-wrap items-center gap-x-5 gap-y-3 pt-4 text-sm">
                                    <form method="POST" action="{{ route('cart.update', $item->id) }}" class="inline-flex items-center rounded-full ring-1 ring-gray-200">
                                        @csrf @method('PATCH')
                                        <button name="quantity" value="{{ $item->quantity - 1 }}" @disabled($item->quantity <= 1) class="flex h-9 w-9 items-center justify-center rounded-full text-gray-600 hover:bg-gray-100 disabled:opacity-30" aria-label="Decrease">&minus;</button>
                                        <span class="w-8 text-center font-semibold">{{ $item->quantity }}</span>
                                        <button name="quantity" value="{{ $item->quantity + 1 }}" @disabled($item->quantity >= $max) class="flex h-9 w-9 items-center justify-center rounded-full text-gray-600 hover:bg-gray-100 disabled:opacity-30" aria-label="Increase">+</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.save-for-later', $item->id) }}">
                                        @csrf
                                        <button class="font-medium text-gray-600 hover:text-brand-600">Save for later</button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                        @csrf @method('DELETE')
                                        <button class="font-medium text-gray-600 hover:text-brand-600">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- summary --}}
                <aside class="lg:sticky lg:top-28">
                    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-500">Price details</h2>
                        <dl class="mt-5 space-y-3 text-sm">
                            <div class="flex justify-between"><dt>Price ({{ $summary['count'] }} {{ Str::plural('item', $summary['count']) }})</dt><dd>&#8377;{{ number_format($summary['mrp']) }}</dd></div>
                            @if ($summary['discount'] > 0)
                                <div class="flex justify-between"><dt>Discount</dt><dd class="text-emerald-600">&minus; &#8377;{{ number_format($summary['discount']) }}</dd></div>
                            @endif
                            <div class="flex justify-between"><dt>Delivery</dt><dd class="font-semibold text-emerald-600">FREE</dd></div>
                            <div class="flex justify-between border-t border-dashed border-gray-200 pt-4 text-base font-bold"><dt>Total amount</dt><dd class="font-display text-2xl">&#8377;{{ number_format($summary['total']) }}</dd></div>
                        </dl>
                        @if ($summary['discount'] > 0)
                            <p class="mt-4 rounded-xl bg-emerald-50 px-4 py-2.5 text-sm font-semibold text-emerald-700">You save &#8377;{{ number_format($summary['discount']) }} on this order</p>
                        @endif

                        <button type="button" disabled
                                class="mt-6 flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-full bg-brand-600/60 py-3.5 text-sm font-semibold text-white">
                            <i data-lucide="lock" class="h-4 w-4"></i> Proceed to checkout
                        </button>
                        <p class="mt-2 text-center text-xs text-gray-500">Online checkout (UPI, cards, net banking, COD) is launching soon. Meanwhile, <a href="https://wa.me/{{ config('services.chatbot.whatsapp') }}" class="font-semibold text-brand-600 hover:underline" target="_blank" rel="noopener">order on WhatsApp</a>.</p>
                    </div>
                    <ul class="mt-4 space-y-2 px-2 text-sm text-gray-600">
                        <li class="flex items-center gap-2"><i data-lucide="shield-check" class="h-4 w-4 text-brand-600"></i>Genuine Yara products with brand warranty</li>
                        <li class="flex items-center gap-2"><i data-lucide="truck" class="h-4 w-4 text-brand-600"></i>Free delivery across India</li>
                        <li class="flex items-center gap-2"><i data-lucide="wrench" class="h-4 w-4 text-brand-600"></i>Installation by our own service team</li>
                    </ul>
                </aside>

            </div>
        @endif

        {{-- saved for later --}}
        @if ($saved->isNotEmpty())
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-900">Saved for later ({{ $saved->count() }})</h2>
                <div class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($saved as $item)
                        @php $p = $item->product; @endphp
                        <article class="flex gap-4 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-gray-200">
                            <a href="{{ $p->url() }}" class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-gray-50">
                                @if ($p->primaryImage)<img src="{{ asset('storage/' . $p->primaryImage->image) }}" alt="{{ $p->name }}" class="h-full w-full object-contain p-1">@endif
                            </a>
                            <div class="min-w-0 flex-1">
                                <a href="{{ $p->url() }}" class="line-clamp-2 text-sm font-semibold hover:text-brand-600">{{ $p->name }}</a>
                                <p class="mt-1 text-sm font-bold">&#8377;{{ number_format($p->unitPrice()) }}</p>
                                <div class="mt-2 flex gap-4 text-sm">
                                    <form method="POST" action="{{ route('cart.move-to-cart', $item->id) }}">@csrf<button class="font-semibold text-brand-600 hover:underline">Move to cart</button></form>
                                    <form method="POST" action="{{ route('cart.remove', $item->id) }}">@csrf @method('DELETE')<button class="text-gray-500 hover:text-brand-600">Remove</button></form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection
