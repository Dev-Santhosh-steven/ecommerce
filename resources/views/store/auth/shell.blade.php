{{--
    Split card used by every customer auth screen: brand panel on the left, the form ($slot) on the right.
    Usage: @component('store.auth.shell', ['title' => '...', 'subtitle' => '...']) ... form ... @endcomponent
--}}
<section class="relative overflow-hidden bg-[#f5f3f2] py-12 sm:py-20">
    <div class="pointer-events-none absolute -left-40 top-0 h-[28rem] w-[28rem] rounded-full bg-brand-500/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -right-40 bottom-0 h-[28rem] w-[28rem] rounded-full bg-brand-300/15 blur-3xl"></div>

    <div class="relative mx-auto grid max-w-5xl overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-gray-900/10 ring-1 ring-gray-200 lg:grid-cols-[0.9fr_1.1fr]">

        {{-- brand panel --}}
        <div class="relative hidden overflow-hidden bg-gradient-to-br from-gray-950 via-[#1a0d10] to-brand-950 p-10 text-white lg:flex lg:flex-col">
            <div class="about-grid absolute inset-0 opacity-40"></div>
            <div class="about-blob -bottom-20 -right-20 h-80 w-80 bg-brand-700/60"></div>

            <img src="{{ asset('storage/products/centum/yara-logo-light.png') }}" alt="Yara" class="relative h-10 w-auto self-start">

            <div class="relative mt-auto">
                <h2 class="text-3xl font-bold leading-tight">Technology<br>to <span class="about-gradient-text">everyone.</span></h2>
                <ul class="mt-8 space-y-4 text-sm text-gray-300">
                    @foreach ([['heart', 'Save products to your wishlist on every device'], ['shopping-bag', 'Keep your cart when you switch phone or laptop'], ['truck', 'Free delivery and easy tracking'], ['shield-check', 'Made in India, backed by our own service network']] as [$icon, $text])
                        <li class="flex items-center gap-3">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/10"><i data-lucide="{{ $icon }}" class="h-4 w-4 text-brand-300"></i></span>
                            {{ $text }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- form --}}
        <div class="p-7 sm:p-12">
            <h1 class="font-display text-3xl font-bold text-gray-900">{{ $title }}</h1>
            @isset($subtitle)
                <p class="mt-2 text-gray-500">{{ $subtitle }}</p>
            @endisset

            @if (session('status'))
                <div class="mt-6 flex items-start gap-3 rounded-2xl bg-emerald-50 p-4 text-sm text-emerald-800 ring-1 ring-emerald-200">
                    <i data-lucide="check-circle-2" class="mt-0.5 h-4 w-4 shrink-0"></i>{{ session('status') }}
                </div>
            @endif

            <div class="mt-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>
