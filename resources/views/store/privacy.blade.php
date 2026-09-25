@extends('layouts.store')

@section('title', 'Privacy Policy | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Privacy Policy</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Privacy Policy
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            Yara Electronics respects your privacy and is committed to protecting the personal
            information you share with us.
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
                            'overview' => 'Overview',
                            'information-collected' => 'Information We Collect',
                            'collection-retention' => 'Collection & Retention',
                            'use-disclosure' => 'Use & Disclosure',
                            'cookies' => 'Cookies',
                            'linked-sites' => 'Third-Party & Linked Sites',
                            'advertising' => 'Internet-Based Advertising',
                            'governing-law' => 'Governing Law & Disputes',
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

                <section id="overview" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Overview
                    </h2>

                    <p>
                        Yara Electronics respects your privacy and is committed to protecting the
                        personal information that you furnish. In general, you can browse this
                        website without identifying yourself or providing personal information.
                        There are times, however, when we may need personal information from you,
                        and this Privacy Policy describes the information we collect and how we may
                        use it.
                    </p>

                </section>


                <section id="information-collected" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Information We Collect
                    </h2>

                    <p>
                        <span class="font-semibold text-gray-900">Personal information</span> means
                        any information that may be used to identify an individual, including but
                        not limited to your first and last name, email address, mailing and
                        residential address, telephone number, title, birth date, gender, occupation,
                        employer, and other information needed to provide a service you have
                        requested.
                    </p>

                    <p class="mt-3">
                        <span class="font-semibold text-gray-900">Sensitive personal data or
                        information</span> refers to information such as passwords, bank account,
                        credit card, debit card or other payment instrument details, and sexual
                        orientation.
                    </p>

                </section>


                <section id="collection-retention" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Collection &amp; Retention
                    </h2>

                    <p>
                        Yara Electronics may receive personal information and/or sensitive personal
                        data from its customers, business partners, and/or suppliers. We collect and
                        use such information in accordance with this Privacy Policy and the
                        Information Technology (Reasonable Security Practices and Procedures and
                        Sensitive Personal Data or Information) Rules, 2011. We follow these
                        guidelines when collecting and retaining information:
                    </p>

                    <ul class="mt-3 list-disc space-y-2 pl-5">
                        <li>We obtain express and/or implied consent regarding the purpose of use.</li>
                        <li>We collect information only for lawful purposes.</li>
                        <li>We do not retain information for longer than required for that purpose.</li>
                        <li>Providers of information can review the information they have shared with us.</li>
                        <li>We keep the information we hold secure.</li>
                    </ul>

                </section>


                <section id="use-disclosure" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Use &amp; Disclosure
                    </h2>

                    <p>
                        Unless otherwise stated at the point of collection, we may use your personal
                        information to fulfil orders, inform you about product, service, and
                        warranty matters, send marketing communications, and audit or improve the
                        level of service we provide. Regardless of your stated privacy preferences,
                        we reserve the right to contact you regarding a service notification for
                        your registered product, or to issue safety-related notices concerning your
                        appliance.
                    </p>

                    <p class="mt-3">
                        We use aggregate information only as anonymous, grouped data to understand
                        how visitors use our site &mdash; for example, the pages most frequently
                        viewed, or the paths visitors take while navigating the site &mdash; so that
                        we can optimise the experience and count visitors.
                    </p>

                    <p class="mt-3">
                        We may disclose your information to parties who support our operations, such
                        as call centre operators, shippers, service partners, and data analysts.
                        These parties only receive the information they need to perform their role.
                    </p>

                    <p class="mt-3">
                        You have the right to request that Yara Electronics, or any authorised third
                        party acting on our behalf, stop contacting you for newsletters, customer
                        surveys, direct marketing, or market research.
                    </p>

                </section>


                <section id="cookies" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Cookies
                    </h2>

                    <p>
                        This website uses cookies &mdash; small data files placed on your device when
                        you visit certain pages. Cookies help identify you on return visits, load
                        your preferences, and track the pages you have viewed. The only personal
                        information held in a cookie is information you have already provided to us.
                    </p>

                    <p class="mt-3">
                        You can choose whether to accept cookies through your browser settings,
                        although disabling them may limit certain features and functionality of this
                        website.
                    </p>

                </section>


                <section id="linked-sites" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Third-Party &amp; Linked Sites
                    </h2>

                    <p>
                        This website may contain links to sites owned by other companies, or pages
                        maintained by third parties for services such as online purchases. Because
                        Yara Electronics has no control over the privacy practices or content of
                        these linked sites or third-party managed pages, we recommend reviewing the
                        privacy statement of each site you visit. Yara Electronics is not responsible
                        for the content or privacy practices of sites or pages owned or managed by
                        other companies.
                    </p>

                </section>


                <section id="advertising" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Internet-Based Advertising
                    </h2>

                    <p>
                        Yara Electronics allows trusted third parties to place advertisements for our
                        products and services on other sites, and requires that they comply with
                        applicable Indian advertising laws, including the guidelines of the
                        Advertising Standards Council of India. These third parties may use cookies
                        and web beacons to measure the effectiveness of our advertisements and to
                        tailor content and advertising based on your interests, on our site and
                        elsewhere. Information collected and used for this purpose is always
                        anonymous and does not identify you individually.
                    </p>

                </section>


                <section id="governing-law" data-reveal>

                    <h2 class="mb-3 text-xl font-bold tracking-tight text-gray-900">
                        Governing Law &amp; Disputes
                    </h2>

                    <p>
                        This Privacy Policy, and any claims or issues regarding this website, are
                        governed by the laws of India. Any dispute that cannot be resolved amicably
                        shall be subject to the exclusive jurisdiction of the courts of Gurgaon,
                        Haryana.
                    </p>

                    <p class="mt-3">
                        For any questions or grievances relating to this Privacy Policy, please write
                        to our Privacy Office at
                        <a href="mailto:info@yaraelectronics.com" class="font-semibold text-gray-900 underline decoration-gray-300 underline-offset-2 hover:text-gray-700">
                            info@yaraelectronics.com
                        </a>.
                    </p>

                    <p class="mt-6 text-sm text-gray-400">
                        This Privacy Policy was last updated in April 2022. Yara Electronics reserves
                        the right to change this policy at any time; continued use of this website
                        signifies your acceptance of any such changes.
                    </p>

                </section>

            </div>

        </div>

    </div>

</section>

@endsection
