@extends('layouts.store')

@section('title', 'Terms & Conditions | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Terms & Conditions</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Terms & Conditions
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            Please read these terms carefully before using this website or purchasing any product.
            By accessing or browsing the site, you agree to be bound by them.
        </p>

    </div>

</section>


{{-- =========================================================
     CONTENT
========================================================= --}}
<section class="bg-white py-14">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="lg:grid lg:grid-cols-[240px_1fr] lg:gap-12">

            {{-- On this page --}}
            <aside class="mb-10 lg:mb-0">

                <div class="lg:sticky lg:top-24">

                    <h2 class="mb-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                        On this page
                    </h2>

                    <nav class="space-y-1 border-l border-gray-200 text-sm">

                        @foreach ([
                            'agreement' => '1. Agreement to Terms',
                            'eligibility' => '2. Eligibility',
                            'privacy' => '3. Privacy',
                            'information' => '4. Information You Provide',
                            'liability' => '5. Product Information & Liability',
                            'ordering-payment' => '6. Ordering & Payment',
                            'payment-security' => '7. Payment Security',
                        ] as $anchor => $label)

                            <a href="#{{ $anchor }}"
                               class="block border-l-2 border-transparent py-1.5 pl-4 text-gray-500 transition hover:border-gray-950 hover:text-gray-950">
                                {{ $label }}
                            </a>

                        @endforeach

                    </nav>

                </div>

            </aside>


            {{-- Sections --}}
            <div class="space-y-12 leading-7 text-gray-600 [&_h2]:scroll-mt-24">

                <section id="agreement" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        1. Agreement to Terms
                    </h2>

                    <p>
                        These Terms and Conditions ("Agreement") are binding on any user or customer
                        who uses this website to purchase products or otherwise access its services.
                        By accessing, browsing, or using this site, you confirm that you have read,
                        understood, and agree to be bound by this Agreement, along with any rules,
                        guidelines, or policies referenced herein.
                    </p>

                    <p class="mt-3">
                        Yara Electronics reserves the right to change the services offered through
                        this website, or these Terms and Conditions, at any time without prior
                        notice. We also reserve the right to deny access to anyone who we believe
                        has violated any term of this Agreement.
                    </p>

                </section>


                <section id="eligibility" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        2. Eligibility
                    </h2>

                    <p>
                        Only individuals who have attained the age of majority are entitled to use
                        this website to purchase products for personal, family, or household use.
                    </p>

                </section>


                <section id="privacy" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        3. Privacy
                    </h2>

                    <p>
                        Our
                        <a href="{{ route('store.privacy') }}" class="font-semibold text-gray-900 underline decoration-gray-300 underline-offset-2 hover:text-gray-700">
                            Privacy Policy
                        </a>
                        governs how we collect, use, and safeguard the information you share with
                        us, and forms an integral part of this Agreement.
                    </p>

                </section>


                <section id="information" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        4. Information You Provide
                    </h2>

                    <ul class="list-disc space-y-2 pl-5">

                        <li>
                            You are responsible for providing accurate information required to
                            process your order. Yara Electronics is not liable for any loss arising
                            from incorrect or fraudulent information supplied by a user, and orders
                            are processed on the basis that the information provided is accurate.
                        </li>

                        <li>
                            We may request additional information to verify or process an order; if
                            so, we will contact you directly.
                        </li>

                        <li>
                            Any sensitive personal information you share with us is handled in
                            accordance with our Privacy Policy and applicable data protection laws,
                            including the Information Technology (Reasonable Security Practices and
                            Procedures and Sensitive Personal Data or Information) Rules, 2011.
                        </li>

                    </ul>

                </section>


                <section id="liability" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        5. Product Information & Liability
                    </h2>

                    <p>
                        Information on this website is provided "as is" and without warranty of any
                        kind. It may contain typographical errors, technical inaccuracies, or other
                        errors, and is subject to change at any time without notice. As part of our
                        policy of continuous product improvement, Yara Electronics reserves the
                        right to modify products without notice. The actual product may differ
                        slightly from the images shown on this website, and Yara Electronics shall
                        not be held responsible for any such deviation.
                    </p>

                </section>


                <section id="ordering-payment" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        6. Ordering & Payment
                    </h2>

                    <ul class="list-disc space-y-2 pl-5">

                        <li>
                            An order is processed only after your payment has been successfully
                            authorized.
                        </li>

                        <li>
                            Accepted payment methods include credit card, debit card, net banking,
                            and other supported online payment modes. We do not accept cheques or
                            money orders. EMI options may be available on select credit cards.
                        </li>

                        <li>
                            The billing name and address must match the details registered with your
                            card issuer. We reserve the right to delay or cancel an order if this
                            information does not match.
                        </li>

                        <li>
                            Payment methods, promotions, and discounts are offered at our discretion
                            and may change without notice.
                        </li>

                        <li>
                            All purchases made on this website are subject to applicable statutory
                            taxes.
                        </li>

                    </ul>

                </section>


                <section id="payment-security" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        7. Payment Security
                    </h2>

                    <p>
                        Card details submitted for payment are transmitted using Secure Socket Layer
                        (SSL) encryption through a Payment Card Industry Data Security Standard
                        (PCI&nbsp;DSS) compliant payment gateway. Yara Electronics does not store any
                        card information on its own servers.
                    </p>

                    <p class="mt-3">
                        By making a payment, you confirm that the card details provided are accurate
                        and that the card is lawfully owned or authorized for your use. This
                        information will not be shared with third parties except where required for
                        fraud verification or by law, regulation, or court order. Yara Electronics is
                        not liable for fraudulent use of a payment card, and the responsibility for
                        proving otherwise rests with the cardholder.
                    </p>

                </section>

            </div>

        </div>

    </div>

</section>

@endsection
