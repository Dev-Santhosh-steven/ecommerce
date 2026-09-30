@extends('layouts.store')

@section('title', 'Sign in | Yara Electronics')

@section('content')

@component('store.auth.shell', ['title' => 'Sign in', 'subtitle' => 'Welcome back. Sign in with your email or mobile number.'])

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-5" x-data="{ busy: false }" @submit="busy = true">
        @csrf
        {{-- hearts saved while signed out, merged into the account on sign-in --}}
        <input type="hidden" name="wishlist" x-init="$el.value = JSON.parse(localStorage.getItem('yara_wishlist') || '[]').join(',')">

        @include('store.auth.field', ['name' => 'login', 'label' => 'Email or mobile number', 'autocomplete' => 'username', 'placeholder' => 'you@example.com or 98xxxxxxxx', 'autofocus' => true])

        <div>
            @include('store.auth.field', ['name' => 'password', 'label' => 'Password', 'type' => 'password', 'autocomplete' => 'current-password'])
            <div class="mt-3 flex items-center justify-between text-sm">
                <label class="inline-flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-gray-300 text-brand-600 focus:ring-brand-500" checked>
                    Keep me signed in
                </label>
                <a href="{{ route('password.request') }}" class="font-semibold text-brand-600 hover:underline">Forgot password?</a>
            </div>
        </div>

        <button type="submit" :disabled="busy"
                class="flex w-full items-center justify-center gap-2 rounded-full bg-brand-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700 disabled:opacity-70">
            <span x-show="!busy">Sign in</span>
            <span x-show="busy" x-cloak>Signing in…</span>
        </button>
    </form>

    <div class="my-8 flex items-center gap-4 text-xs uppercase tracking-wider text-gray-400">
        <span class="h-px flex-1 bg-gray-200"></span>New to Yara?<span class="h-px flex-1 bg-gray-200"></span>
    </div>

    <a href="{{ route('register') }}" class="flex w-full items-center justify-center rounded-full border border-gray-300 py-3.5 text-sm font-semibold text-gray-900 transition hover:bg-gray-50">
        Create your account
    </a>

@endcomponent

@endsection
