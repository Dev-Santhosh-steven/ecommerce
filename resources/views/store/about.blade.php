@extends('layouts.store')

@section('title', 'About Us | Yara Store')

@section('content')

{{-- =========================================================
     ABOUT BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">About Us</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Welcome To Yara Electronics
        </h1>

    </div>

</section>


{{-- =========================================================
     ABOUT CONTENT
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <div class="space-y-5 text-justify leading-7 text-gray-600">

            <p>
                Yara Electronics emerged with a distinct mission: to bring top-notch electronic
                innovations to consumers' fingertips. Our product collection covers every aspect of
                modern living, and our collection of display devices and home appliances offers
                users exciting ways to connect with technology.
            </p>

            <p>
                Our creations are more than just products; they embody our commitment to bringing
                comfort and convenience into your life. With each product crafted by our team of
                experts, we strive to enable a seamless blend of high-tech features and everyday
                usability.
            </p>

            <p>
                At Yara, we magnificently unveil a state-of-the-art production line and pioneering
                equipment, empowering us to fabricate an astounding 1000 televisions per shift. From
                sleek 24&quot; to expansive 100&quot; screens, and interactive flat panel displays
                spanning an awe-inspiring range of 55&quot; to 98&quot;, our manufacturing prowess
                knows no bounds. In tandem with our unrivaled expertise in crafting cutting-edge TVs
                and Interactive panels, we excel in the meticulous assembly of fully automated and
                semi-automated washing machines.
            </p>

        </div>

    </div>

</section>


{{-- =========================================================
     FACTORY VIDEO
========================================================= --}}
<section class="bg-gray-50 py-14" data-reveal>

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <h2 class="mb-8 text-center text-xl font-bold tracking-tight text-gray-900">
            Our Factory Video
        </h2>

        <div class="aspect-video overflow-hidden rounded-2xl border border-gray-200 shadow-sm">

            <iframe
                class="h-full w-full"
                src="https://www.youtube.com/embed/nzUHAuEdKzo"
                title="Yara Electronics Factory Tour: Behind the Scenes of Cutting-Edge Manufacturing"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
            ></iframe>

        </div>

    </div>

</section>


{{-- =========================================================
     CERTIFICATIONS
========================================================= --}}
<section class="bg-white py-14" data-reveal>

    <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">

        <h2 class="mb-4 text-xl font-bold tracking-tight text-gray-900">
            Our Certifications
        </h2>

        <p class="mx-auto max-w-3xl leading-7 text-gray-600">
            At Yara Electronics, quality, safety, and compliance aren't just checkboxes &mdash;
            they're built into how we design, manufacture, and deliver every product. Our
            certifications reflect our commitment to international standards and Indian regulatory
            requirements across our full range of Smart TVs, ACs, washing machines, and commercial
            display solutions.
        </p>

        <img
            src="https://www.yaraelectronics.com/storage/tinymce/gGBthLry9ZydlfcJNNby3OAv3qLwSC9l7r86h6nB.png"
            alt="Yara Electronics Certifications"
            class="mx-auto mt-8 max-w-full rounded-2xl"
        >

    </div>

</section>

@endsection
