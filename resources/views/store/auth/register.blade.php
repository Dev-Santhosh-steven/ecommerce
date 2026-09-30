@extends('layouts.store')

@section('title', 'Create your account | Yara Electronics')

@section('content')

@component('store.auth.shell', ['title' => 'Create your account', 'subtitle' => 'It takes less than a minute.'])

    <form method="POST" action="{{ route('register.submit') }}" class="space-y-5" x-data="{ busy: false, pw: '' }" @submit="busy = true">
        @csrf
        {{-- hearts saved while signed out, merged into the account on sign-in --}}
        <input type="hidden" name="wishlist" x-init="$el.value = JSON.parse(localStorage.getItem('yara_wishlist') || '[]').join(',')">

        @include('store.auth.field', ['name' => 'name', 'label' => 'Full name', 'autocomplete' => 'name', 'placeholder' => 'Your name', 'autofocus' => true])

        <div class="grid gap-5 sm:grid-cols-2">
            @include('store.auth.field', ['name' => 'phone', 'label' => 'Mobile number', 'type' => 'tel', 'inputmode' => 'numeric', 'autocomplete' => 'tel-national', 'prefix' => '+91', 'placeholder' => '98xxxxxxxx'])
            @include('store.auth.field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email', 'placeholder' => 'you@example.com'])
        </div>

        <div @input="if ($event.target.name === 'password') pw = $event.target.value">
            @include('store.auth.field', ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'autocomplete' => 'new-password'])
            {{-- strength meter --}}
            @php
                $rules = [['8 or more characters', 'pw.length >= 8'], ['A letter', '/[A-Za-z]/.test(pw)'], ['A number', '/\\d/.test(pw)']];
            @endphp
            <ul class="mt-3 flex flex-wrap gap-2 text-xs">
                @foreach ($rules as [$label, $test])
                    <li class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 transition" :class="{{ $test }} ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500'">
                        <span class="h-1.5 w-1.5 rounded-full" :class="{{ $test }} ? 'bg-emerald-500' : 'bg-gray-400'"></span>{{ $label }}
                    </li>
                @endforeach
            </ul>
        </div>

        @include('store.auth.field', ['name' => 'password_confirmation', 'label' => 'Confirm password', 'type' => 'password', 'autocomplete' => 'new-password'])

        <div>
            <label class="flex items-start gap-3 text-sm text-gray-600">
                <input type="checkbox" name="terms" value="1" @checked(old('terms')) class="mt-0.5 h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                <span>I agree to the <a href="{{ route('store.terms') }}" target="_blank" class="font-semibold text-brand-600 hover:underline">Terms &amp; Conditions</a> and <a href="{{ route('store.privacy') }}" target="_blank" class="font-semibold text-brand-600 hover:underline">Privacy Policy</a>.</span>
            </label>
            @error('terms')<p class="mt-1.5 text-sm text-brand-600">{{ $message }}</p>@enderror
        </div>

        <button type="submit" :disabled="busy"
                class="flex w-full items-center justify-center gap-2 rounded-full bg-brand-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700 disabled:opacity-70">
            <span x-show="!busy">Create account</span>
            <span x-show="busy" x-cloak>Creating your account…</span>
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-gray-500">
        Already have an account? <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:underline">Sign in</a>
    </p>

@endcomponent

@endsection
