@extends('layouts.store')

@section('title', 'E-waste Management | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">E-waste Management</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            E-waste Management
        </h1>

    </div>

</section>


{{-- =========================================================
     INTRODUCTION
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-6 text-center text-xl font-bold tracking-tight text-gray-900">
            Introduction
        </h2>

        <div class="space-y-5 text-justify leading-7 text-gray-600">

            <p>
                Electronic waste, or e-waste, is a term for electronic products that have become
                unwanted, non-working or obsolete, and have essentially reached the end of their
                useful life.
            </p>

            <p>
                As per E-waste Rule 2016, e-waste is defined as &lsquo;electrical and electronic
                equipment, whole or in part discarded as waste by the consumer or bulk consumer as
                well as rejects from manufacturing, refurbishment and repair processes&rsquo;.
            </p>

            <p>
                E-waste contains many valuable, recoverable materials such as aluminum, copper,
                gold, silver, plastics, and ferrous metals. In order to conserve natural resources
                and the energy needed to produce new electronic equipment from virgin resources,
                electronic equipment can be refurbished, reused, and recycled instead of being
                landfilled.
            </p>

            <p>
                E-waste also contains toxic and hazardous materials including mercury, lead,
                cadmium, beryllium, chromium, and chemical flame retardants, which have the
                potential to leach into our soil and water.
            </p>

        </div>

    </div>

</section>


{{-- =========================================================
     BENEFITS OF RECYCLING
========================================================= --}}
<section class="bg-gray-50 py-14" data-reveal>

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-8 text-center text-xl font-bold tracking-tight text-gray-900">
            Benefits of Recycling E-waste
        </h2>

        <div class="space-y-4">

            @foreach ([
                ['title' => 'Protects your surroundings', 'text' => 'Safe recycling of outdated electronics promotes sound management of toxic chemicals such as lead and mercury.'],
                ['title' => 'Conserves natural resources', 'text' => 'Recycling recovers valuable materials from old electronics that can be used to make new products. As a result, we save energy, reduce pollution, reduce greenhouse gas emissions, and save resources by extracting fewer raw materials from the earth.'],
                ['title' => 'Helps others', 'text' => 'Donating your used electronics benefits your community by passing on ready-to-use or refurbished equipment to those who need it.'],
                ['title' => 'Saves landfill space', 'text' => 'E-waste is a growing waste stream. By recycling these items, landfill space is conserved.'],
            ] as $benefit)

                <div class="flex gap-4 rounded-2xl border border-gray-200 bg-white p-5">

                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-950 text-white">
                        <i data-lucide="recycle" class="h-5 w-5"></i>
                    </div>

                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $benefit['title'] }}</h3>
                        <p class="mt-1 text-sm leading-6 text-gray-600">{{ $benefit['text'] }}</p>
                    </div>

                </div>

            @endforeach

        </div>

    </div>

</section>


{{-- =========================================================
     RECYCLING PROCESS
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-6 text-center text-xl font-bold tracking-tight text-gray-900">
            Recycling of E-waste
        </h2>

        <p class="text-justify leading-7 text-gray-600">
            The company has tied up with E-waste Recyclers India for collection of all our e-waste
            on a PAN India basis and disposes of the same at their plant at E-50, UPSIDC Industrial
            Area, 98 Km Stone, NH 2, Kosi Kotawan Distt. Mathura, U.P., India. Customers can reach
            or call on Toll Free No.
            <a href="tel:18001025679" class="font-semibold text-gray-900 underline decoration-gray-300 underline-offset-2 hover:text-gray-700">
                1800-102-5679
            </a>.
            Our representatives explain the process of disposal and make customers aware of the
            nearest drop point available, along with information about the incentive offered
            against their end-of-life product. If a customer wants the material collected from
            their doorstep, we send either our logistics team or e-waste solutions team to collect
            the items and channelize the same to our e-waste partner plant for final processing.
        </p>

    </div>

</section>


{{-- =========================================================
     DO'S & DON'TS
========================================================= --}}
<section class="bg-gray-50 py-14" data-reveal>

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-8 text-center text-xl font-bold tracking-tight text-gray-900">
            Do&rsquo;s &amp; Don&rsquo;ts
        </h2>

        <div class="grid gap-6 sm:grid-cols-2">

            {{-- Do's --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6">

                <h3 class="mb-4 flex items-center gap-2 font-semibold text-gray-900">
                    <i data-lucide="check-circle-2" class="h-5 w-5 text-green-600"></i>
                    Do&rsquo;s
                </h3>

                <ul class="space-y-3 text-sm leading-6 text-gray-600">

                    @foreach ([
                        'Always look for information on the catalogue with your product for end-of-life equipment handling.',
                        'Ensure that only Authorized Recyclers repair and handle your electronic products.',
                        'Always call our E-waste Authorized Collection Centres/points to dispose of products that have reached end-of-life.',
                        'Always drop your used electronic products, batteries or any accessories when they reach the end of their life at your nearest Authorized E-Waste Collection Centres/Points.',
                        'Always disconnect the battery from the product, and ensure any glass surface is protected against breakage.',
                    ] as $item)

                        <li class="flex gap-2">
                            <i data-lucide="check" class="mt-0.5 h-4 w-4 shrink-0 text-green-600"></i>
                            <span>{{ $item }}</span>
                        </li>

                    @endforeach

                </ul>

            </div>


            {{-- Don'ts --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6">

                <h3 class="mb-4 flex items-center gap-2 font-semibold text-gray-900">
                    <i data-lucide="x-circle" class="h-5 w-5 text-red-600"></i>
                    Don&rsquo;ts
                </h3>

                <ul class="space-y-3 text-sm leading-6 text-gray-600">

                    @foreach ([
                        'Do not dismantle your electronic products on your own.',
                        'Do not throw electronics in bins having a "Do not Dispose" sign.',
                        'Do not give e-waste to informal (Kabadi) and unorganized sectors like local scrap dealers or rag pickers.',
                        'Do not dispose of your product in garbage bins along with municipal waste that ultimately reaches landfills.',
                    ] as $item)

                        <li class="flex gap-2">
                            <i data-lucide="x" class="mt-0.5 h-4 w-4 shrink-0 text-red-600"></i>
                            <span>{{ $item }}</span>
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    </div>

</section>


{{-- =========================================================
     COLLECTION CENTRES
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-4 text-center text-xl font-bold tracking-tight text-gray-900">
            Collection Centres
        </h2>

        <p class="mx-auto mb-8 max-w-3xl text-center text-sm leading-6 text-gray-600">
            E-waste Recyclers India has signed an agreement with Professional Logistics Pvt. Ltd.
            for reverse logistics, for channelization of e-waste to the facility.
        </p>

        <div class="overflow-hidden rounded-2xl border border-gray-200">

            <div class="max-h-[520px] overflow-y-auto overflow-x-auto">

                <table class="w-full min-w-[720px] divide-y divide-gray-200 text-left text-sm">

                    <thead class="sticky top-0 bg-gray-950 text-white">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Sr.No</th>
                            <th class="px-4 py-3 font-semibold">State</th>
                            <th class="px-4 py-3 font-semibold">Location</th>
                            <th class="px-4 py-3 font-semibold">Address</th>
                            <th class="px-4 py-3 font-semibold">Toll Free Number</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($collectionCentres as $centre)

                            <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-4 py-3 align-top text-gray-500">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 align-top font-medium text-gray-900">{{ $centre['state'] }}</td>
                                <td class="px-4 py-3 align-top text-gray-600">{{ $centre['location'] }}</td>
                                <td class="px-4 py-3 align-top text-gray-600">{{ $centre['address'] }}</td>
                                <td class="px-4 py-3 align-top whitespace-nowrap text-gray-600">1800-102-5679</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</section>

@endsection
