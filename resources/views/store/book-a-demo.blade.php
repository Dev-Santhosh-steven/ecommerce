@extends('layouts.store')

@section('title', 'Book a Demo | Yara Store')

@section('content')

{{-- =========================================================
     BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Book a Demo</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            Book a Demo
        </h1>

        <p class="mt-3 max-w-2xl text-gray-300">
            See our TVs, ACs and appliances in action before you decide. Tell us a little about
            what you're looking for, and our team will set up a demo at a time that works for you.
        </p>

    </div>

</section>


{{-- =========================================================
     FORM
========================================================= --}}
<section class="bg-gray-50 py-14" data-reveal>

    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

        @if (session('success'))

            <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                <i data-lucide="circle-check" class="mt-0.5 h-5 w-5 shrink-0"></i>
                <p class="text-sm leading-6">{{ session('success') }}</p>
            </div>

        @endif

        <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8">

            <form action="{{ route('store.demo.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Full Name <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Your name"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Organization / Business Name</label>
                        <input
                            type="text"
                            name="organization"
                            value="{{ old('organization') }}"
                            placeholder="Optional"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none"
                        >
                        @error('organization')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Email Address <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none"
                            required
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                        <input
                            type="tel"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="98765 43210"
                            class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none"
                            required
                        >
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <div class="grid gap-6 sm:grid-cols-2">

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Product / Category of Interest</label>
                        <select name="category_id" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none">
                            <option value="">General / Not sure yet</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $prefill['category_id']) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700">Purpose of Demo <span class="text-red-500">*</span></label>
                        <select name="purpose" class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none" required>
                            <option value="">Select purpose</option>
                            @foreach ($purposes as $value => $label)
                                <option value="{{ $value }}" {{ old('purpose', $prefill['purpose']) === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('purpose')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>


                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Preferred Date</label>
                    <input
                        type="date"
                        name="preferred_date"
                        value="{{ old('preferred_date') }}"
                        min="{{ now()->toDateString() }}"
                        class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none sm:w-1/2"
                    >
                    @error('preferred_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Additional Notes</label>
                    <textarea
                        name="message"
                        rows="4"
                        placeholder="Anything specific you'd like us to know or show during the demo?"
                        class="w-full rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm focus:border-brand-500 focus:outline-none"
                    >{{ old('message', $prefill['message']) }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-semibold text-white transition hover:bg-brand-700 sm:w-auto"
                >
                    <i data-lucide="calendar-check" class="h-4 w-4"></i>
                    Request a Demo
                </button>

            </form>

        </div>

    </div>

</section>

@endsection
