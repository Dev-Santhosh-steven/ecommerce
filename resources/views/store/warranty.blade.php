@extends('layouts.store')

@section('title', 'Warranty Terms | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Warranty Terms</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Warranty Terms
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            Warranty terms and conditions applicable to products sold under the Yara brand, along
            with the standard warranty period and depreciation schedule.
        </p>

    </div>

</section>


{{-- =========================================================
     TABBED CONTENT
========================================================= --}}
<section class="bg-white py-14" x-data="{ tab: 'terms' }" data-reveal>

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        {{-- Tabs --}}
        <div class="mb-10 flex flex-wrap justify-center gap-2">

            <button
                type="button"
                @click="tab = 'terms'"
                :class="tab === 'terms' ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="rounded-full px-5 py-2.5 text-sm font-medium transition"
            >
                Warranty Terms
            </button>

            <button
                type="button"
                @click="tab = 'annexureA'"
                :class="tab === 'annexureA' ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="rounded-full px-5 py-2.5 text-sm font-medium transition"
            >
                Annexure A &ndash; Warranty Period
            </button>

            <button
                type="button"
                @click="tab = 'annexureB'"
                :class="tab === 'annexureB' ? 'bg-brand-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                class="rounded-full px-5 py-2.5 text-sm font-medium transition"
            >
                Annexure B &ndash; Depreciation Rates
            </button>

        </div>


        {{-- TAB 1: Warranty Terms --}}
        <div x-show="tab === 'terms'" x-cloak>

            <ol class="list-decimal space-y-4 pl-5 text-sm leading-6 text-gray-600 marker:font-semibold marker:text-gray-900">

                <li>
                    Yara Electronics Private Limited, having its registered office at PVG Towers,
                    473 Avinashi Road, Peelamedu, Coimbatore, Tamil Nadu &ndash; 641004, hereinafter
                    referred to as &ldquo;Company&rdquo;, warrants that the products sold under the
                    &ldquo;Yara&rdquo; brand, as mentioned in Annexure A (&ldquo;Product&rdquo;),
                    shall be free from any manufacturing defect for the period mentioned below from
                    the date of purchase on the purchase invoice (&ldquo;Warranty Period&rdquo;) by
                    the end user (&ldquo;Customer&rdquo;), on the following terms and conditions.
                </li>

                <li>
                    The warranty is confined to the first purchaser of the product only and is not
                    transferable. Warranty shall be void if the seal or serial number is tampered
                    with, mutilated, defaced, or damaged.
                </li>

                <li>
                    A valid tax invoice containing the product serial number or proof of purchase is
                    mandatory for claiming warranty service. Quotations, estimates, etc. are not
                    valid.
                </li>

                <li>
                    Repairs under the warranty period shall be carried out by the Company&rsquo;s
                    authorised personnel only. If repairs are carried out by unauthorised persons,
                    the warranty becomes void.
                </li>

                <li>
                    Warranty is not covered if the product fails due to factors including, but not
                    limited to, waterlogging, misuse, mishandling, electrical issues, or damage
                    while in transit to the service centre or the purchaser&rsquo;s residence. The
                    warranty does not cover damage caused by natural disasters, accidents, power
                    surges, or unauthorised modifications.
                </li>

                <li>
                    Normal wear and tear, such as fading, scratches, or cosmetic damage, and
                    consumable parts like batteries, lint filters, cables, or accessories are not
                    covered unless explicitly mentioned in the warranty.
                </li>

                <li>
                    The Company shall not be liable for any loss, cost, expense, inconvenience, or
                    damage that may result from use or inability to use the product, or damage
                    exceeding the purchase price of the product.
                </li>

                <li>
                    The purchaser must ensure proper usage and maintenance of the product as per the
                    user manual to claim warranty. Damage arising from improper handling,
                    installation, or failure to follow operating instructions will not be covered.
                    The product is suitable for residential purposes only and not for commercial or
                    industrial use.
                </li>

                <li>
                    Any defect in the electrical installation or wiring at the site must be
                    rectified by the Customer as per the recommendation of the Company&rsquo;s
                    engineers. The Company is not responsible for any liability, including fire or
                    shocks, arising due to improper wiring or voltage fluctuations at the site.
                </li>

                <li>
                    Where applicable, it is the Customer&rsquo;s responsibility to back up any
                    contents stored in the Product before sending it to the Company&rsquo;s
                    authorised service centre for servicing. The Company shall not be responsible
                    for any damage, modification, loss of data, or loss of any other information
                    stored in the Product.
                </li>

                <li>
                    The Company&rsquo;s obligation under this warranty shall be limited to repair or
                    providing a replacement of parts only; the customer is not entitled to a full
                    product replacement. The maximum claim, if entertained by the Company, will be
                    subject to the maximum retail price or the purchase price of the product,
                    whichever is lower.
                </li>

                <li>
                    While the Company will make every effort to carry out repairs at the earliest
                    opportunity, it is made explicitly clear that the Company is under no obligation
                    to do so within a specified period of time.
                </li>

                <li>
                    The time taken for repair and transit, whether under warranty or otherwise,
                    shall not be excluded from the warranty period.
                </li>

                <li>
                    Any change of address by the original purchaser shall be communicated to the
                    concerned Authorised Service Centre in writing. Relocation and reinstallation of
                    the unit will be carried out on a chargeable basis, and the warranty will be
                    applicable only after inspection and clearance by Authorised Service Centre
                    personnel.
                </li>

                <li>
                    Any changes in the location or ownership of the unit must be intimated in
                    writing to the Company in advance. Only the Company&rsquo;s authorised dealer or
                    service centre shall remove and install units, on a chargeable basis.
                </li>

                <li>
                    Service calls that involve only cleaning of the unit due to dust accumulation,
                    general explanations, or issues with third-party software not being read or
                    installed are not to be construed as manufacturing defects. The Company does not
                    undertake responsibility for the quantity or compatibility of third-party
                    software and applications used by purchasers.
                </li>

                <li>
                    The playability of any software or media that does not conform to the
                    specifications mentioned in the operating manual is not warranted by the
                    Company. The Company is also not responsible for malfunction of third-party or
                    downloaded applications and software.
                </li>

                <li>
                    In the event of unforeseen circumstances where spare parts are not available,
                    the Company&rsquo;s prevailing depreciation rules (Annexure B) shall be binding
                    on the purchaser as a commercial solution in lieu of repairs.
                </li>

                <li>
                    Where the Company offers an <strong class="font-semibold text-gray-900">Extended Warranty</strong>
                    period for any specific product, it is the
                    <strong class="font-semibold text-gray-900">responsibility of the purchaser</strong>
                    to register the warranty card with the nearest Authorised Service Centre within
                    <strong class="font-semibold text-gray-900">2 weeks of purchase</strong>, at the
                    purchaser&rsquo;s cost and risk.
                </li>

                <li>
                    In case of damage to the product or misuse detected by Authorised Service Centre
                    personnel, the warranty conditions are not applicable, and repairs will be
                    carried out subject to availability of parts and on a chargeable basis only.
                </li>

                <li>
                    While carrying out repairs, the Company may use accessories or parts that are
                    new, repaired, or reconditioned.
                </li>

                <li>
                    In the event of repair to any part of the unit, this warranty will continue and
                    remain in force only for the unexpired portion of the warranty period.
                </li>

                <li>
                    Software updates are not included in the warranty. The Company is not
                    responsible for any glitches or product failures arising from software updates
                    not supported by the Company.
                </li>

                <li>
                    The Company guarantees to the purchaser that this product carries a warranty for
                    the period mentioned in Annexure A, commencing from the date of purchase. The
                    Company will repair, free of charge, any parts of the product where the defect
                    is due to faulty material or a manufacturing defect.
                </li>

            </ol>

        </div>


        {{-- TAB 2: Annexure A --}}
        <div x-show="tab === 'annexureA'" x-cloak>

            <h2 class="mb-6 text-center text-xl font-bold tracking-tight text-gray-900">
                Annexure A &ndash; Standard Warranty Period for Yara Products
            </h2>

            <div class="overflow-hidden rounded-2xl border border-gray-200">
                <div class="overflow-x-auto">

                    <table class="w-full min-w-[480px] divide-y divide-gray-200 text-left text-sm">

                        <thead class="bg-gray-950 text-white">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Product</th>
                                <th class="px-4 py-3 font-semibold">Model</th>
                                <th class="px-4 py-3 font-semibold">Warranty Period</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            <tr class="bg-white">
                                <td class="px-4 py-3 text-gray-600">LED TV</td>
                                <td class="px-4 py-3 text-gray-600">Basic Models (B Series)</td>
                                <td class="px-4 py-3 font-medium text-gray-900">1 year comprehensive</td>
                            </tr>
                            <tr class="bg-gray-50">
                                <td class="px-4 py-3 text-gray-600">LED TV</td>
                                <td class="px-4 py-3 text-gray-600">All Other Models</td>
                                <td class="px-4 py-3 font-medium text-gray-900">2 years comprehensive</td>
                            </tr>
                            <tr class="bg-white">
                                <td class="px-4 py-3 text-gray-600">LED TV</td>
                                <td class="px-4 py-3 text-gray-600">Remote Control (all models)</td>
                                <td class="px-4 py-3 font-medium text-gray-900">Not covered (chargeable)</td>
                            </tr>
                        </tbody>

                    </table>

                </div>
            </div>

        </div>


        {{-- TAB 3: Annexure B --}}
        <div x-show="tab === 'annexureB'" x-cloak>

            <h2 class="mb-6 text-center text-xl font-bold tracking-tight text-gray-900">
                Annexure B &ndash; Depreciation Rates for Yara Products
            </h2>

            <div class="overflow-hidden rounded-2xl border border-gray-200">
                <div class="overflow-x-auto">

                    <table class="w-full min-w-[560px] divide-y divide-gray-200 text-left text-sm">

                        <thead class="bg-gray-950 text-white">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Aging from Date of Purchase</th>
                                <th class="px-4 py-3 font-semibold">Basic LED TV (B Series)</th>
                                <th class="px-4 py-3 font-semibold">All Other LED TV</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ([
                                ['Less than 6 months', '0%', '0%'],
                                ['6 months – 12 months', '25%', '10%'],
                                ['12 months – 24 months', '50%', '30%'],
                                ['24 months – 36 months', '75%', '60%'],
                                ['36 months – 48 months', '100%', '85%'],
                                ['48 months – 60 months', '100%', '100%'],
                                ['60 months or more', '100%', '100%'],
                            ] as $row)

                                <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="px-4 py-3 text-gray-600">{{ $row[0] }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $row[1] }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $row[2] }}</td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>
            </div>

        </div>

    </div>

</section>

@endsection
