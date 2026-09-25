@extends('layouts.store')

@section('title', 'Delivery & Returns | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Delivery & Returns</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Delivery & Returns
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            Here's how your order reaches you, and what to do if something isn't right when it
            arrives.
        </p>

    </div>

</section>


{{-- =========================================================
     DELIVERY TIMELINE
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-2 text-center text-xl font-bold tracking-tight text-gray-900">
            How Your Order Is Delivered
        </h2>

        <p class="mx-auto mb-12 max-w-2xl text-center text-sm text-gray-500">
            Estimated delivery is <span class="font-semibold text-gray-900">7&ndash;10 business
            days</span> from purchase, on all days except national and public holidays. Remote
            areas may take a little longer.
        </p>

        <div class="relative grid grid-cols-2 gap-y-10 sm:grid-cols-4">

            <div class="absolute left-0 right-0 top-6 hidden h-px bg-gray-200 sm:block"></div>

            @foreach ([
                ['icon' => 'circle-check-big', 'title' => 'Order Confirmed', 'text' => 'Your payment is verified and the order is placed.'],
                ['icon' => 'settings-2', 'title' => 'Processing', 'text' => 'Your appliance is picked, packed and readied for dispatch.'],
                ['icon' => 'truck', 'title' => 'Dispatched', 'text' => 'Handed over to our logistics partner for delivery.'],
                ['icon' => 'package-check', 'title' => 'Delivered', 'text' => 'Arrives at your doorstep within the estimated window.'],
            ] as $step)

                <div class="relative flex flex-col items-center px-2 text-center">

                    <div class="z-10 mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-950 text-white ring-4 ring-white">
                        <i data-lucide="{{ $step['icon'] }}" class="h-5 w-5"></i>
                    </div>

                    <h3 class="text-sm font-semibold text-gray-900">{{ $step['title'] }}</h3>
                    <p class="mt-1 text-xs leading-5 text-gray-500">{{ $step['text'] }}</p>

                </div>

            @endforeach

        </div>

        <p class="mt-10 text-center text-xs text-gray-400">
            Delivery dates are estimates only. Yara Electronics Private Limited does not guarantee
            delivery within a specific time and is not liable for delays.
        </p>

    </div>

</section>


{{-- =========================================================
     FAQ ACCORDION
========================================================= --}}
<section class="bg-gray-50 py-14" data-reveal>

    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-8 text-center text-xl font-bold tracking-tight text-gray-900">
            Delivery &amp; Returns FAQ
        </h2>

        <div x-data="{ open: 0 }" class="divide-y divide-gray-200 overflow-hidden rounded-2xl border border-gray-200 bg-white">

            @foreach ([
                [
                    'q' => 'Which areas do you deliver to?',
                    'a' => 'We currently deliver within select cities in India, and only to select pin codes within those cities. We do not deliver internationally.',
                ],
                [
                    'q' => 'How long will my delivery take?',
                    'a' => 'Delivery is made within 7&ndash;10 business days of purchase, excluding national and public holidays. Depending on your billing address, remote areas may occasionally take longer than 10 business days. Delivery dates are estimates only and are not guaranteed.',
                ],
                [
                    'q' => 'Will my accessories arrive with my appliance?',
                    'a' => 'Not always. If you&rsquo;ve ordered accessories along with your appliance, they may be dispatched separately and arrive on a different delivery date.',
                ],
                [
                    'q' => 'Are delivery charges included in the price?',
                    'a' => 'Yes. All our appliance prices are inclusive of delivery charges &mdash; there&rsquo;s nothing extra to pay at delivery.',
                ],
                [
                    'q' => 'What if my product arrives damaged?',
                    'a' => null,
                ],
            ] as $i => $faq)

                <div>

                    <button
                        type="button"
                        @click="open = open === {{ $i }} ? null : {{ $i }}"
                        class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition hover:bg-gray-50"
                    >
                        <span class="font-semibold text-gray-900">{{ $faq['q'] }}</span>

                        <span
                            class="inline-flex shrink-0 transition-transform duration-200"
                            :class="open === {{ $i }} ? 'rotate-180' : ''"
                        >
                            <i data-lucide="chevron-down" class="h-5 w-5 text-gray-400"></i>
                        </span>
                    </button>

                    <div
                        x-show="open === {{ $i }}"
                        x-cloak
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="px-6 pb-5 text-sm leading-6 text-gray-600"
                    >

                        @if ($faq['a'])

                            {!! $faq['a'] !!}

                        @else

                            <p>
                                Damaged goods may be returned, subject to Yara Electronics&rsquo;
                                return policy. Reach out to our team and we&rsquo;ll take it from
                                there.
                            </p>

                            <div class="mt-4 flex flex-wrap gap-3">

                                <a href="tel:9842881500"
                                   class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-700">
                                    <i data-lucide="phone" class="h-4 w-4"></i>
                                    Call 98428 81500
                                </a>

                                <a href="mailto:info@yaraelectronics.com"
                                   class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100">
                                    <i data-lucide="mail" class="h-4 w-4"></i>
                                    info@yaraelectronics.com
                                </a>

                            </div>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>

@endsection
