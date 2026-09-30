@extends('layouts.store')

@section('title', 'My account | Yara Electronics')

@section('content')

<section class="bg-gradient-to-br from-gray-950 via-[#1a0d10] to-brand-950 text-white">
    <div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-12 sm:flex-row sm:items-center sm:px-6 lg:px-8">
        <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-brand-600 font-display text-2xl font-bold shadow-lg shadow-brand-900/50">
            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
        </span>
        <div class="min-w-0 flex-1">
            <p class="text-sm text-white/60">Hello,</p>
            <h1 class="truncate text-3xl font-bold">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-white/60">Member since {{ $user->created_at->format('F Y') }}</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="inline-flex items-center gap-2 rounded-full border border-white/20 px-5 py-2.5 text-sm font-semibold transition hover:bg-white/10">
                <i data-lucide="log-out" class="h-4 w-4"></i> Sign out
            </button>
        </form>
    </div>
</section>

<section class="bg-[#f5f3f2] py-10">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

        {{-- quick links --}}
        <div class="grid gap-4 sm:grid-cols-3">
            @foreach ([
                [route('wishlist.index'), 'heart', 'My wishlist', $user->wishlist_items_count . ' saved ' . Str::plural('item', $user->wishlist_items_count)],
                [route('cart.index'), 'shopping-bag', 'My cart', $cartCount . ' ' . Str::plural('item', $cartCount) . ' in your cart'],
                ['#', 'package', 'My orders', 'Coming soon with online checkout'],
            ] as [$href, $icon, $title, $text])
                <a href="{{ $href }}" class="group flex items-center gap-4 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-lg hover:ring-brand-200">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600 transition group-hover:bg-brand-600 group-hover:text-white">
                        <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>
                    </span>
                    <span>
                        <span class="block font-bold text-gray-900">{{ $title }}</span>
                        <span class="text-sm text-gray-500">{{ $text }}</span>
                    </span>
                </a>
            @endforeach
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-2">

            {{-- profile --}}
            <form method="POST" action="{{ route('account.profile') }}" class="space-y-5 rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 sm:p-8">
                @csrf @method('PUT')
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Profile</h2>
                    <p class="text-sm text-gray-500">Your contact details for orders and delivery.</p>
                </div>
                @include('store.auth.field', ['name' => 'name', 'label' => 'Full name', 'value' => $user->name, 'autocomplete' => 'name'])
                @include('store.auth.field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => $user->email, 'autocomplete' => 'email'])
                @include('store.auth.field', ['name' => 'phone', 'label' => 'Mobile number', 'type' => 'tel', 'prefix' => '+91', 'value' => $user->phone, 'inputmode' => 'numeric', 'autocomplete' => 'tel-national'])
                <button class="rounded-full bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">Save changes</button>
            </form>

            {{-- password --}}
            <form method="POST" action="{{ route('account.password') }}" class="space-y-5 rounded-3xl bg-white p-7 shadow-sm ring-1 ring-gray-200 sm:p-8">
                @csrf @method('PUT')
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Password</h2>
                    <p class="text-sm text-gray-500">Use at least 8 characters with a letter and a number.</p>
                </div>
                @php $errors = $errors->getBag('password')->any() ? $errors->getBag('password') : $errors; @endphp
                @include('store.auth.field', ['name' => 'current_password', 'label' => 'Current password', 'type' => 'password', 'autocomplete' => 'current-password'])
                @include('store.auth.field', ['name' => 'password', 'label' => 'New password', 'type' => 'password', 'autocomplete' => 'new-password'])
                @include('store.auth.field', ['name' => 'password_confirmation', 'label' => 'Confirm new password', 'type' => 'password', 'autocomplete' => 'new-password'])
                <button class="rounded-full bg-gray-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-600">Change password</button>
            </form>

        </div>

        @if ($wishlist->isNotEmpty())
            <div class="mt-10">
                <div class="flex items-end justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Recently saved</h2>
                    <a href="{{ route('wishlist.index') }}" class="text-sm font-semibold text-brand-600 hover:underline">View all</a>
                </div>
                <div class="mt-5 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($wishlist as $product)
                        @include('store.partials.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection
