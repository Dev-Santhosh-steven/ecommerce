@extends('layouts.store')

@section('title', 'Forgot password | Yara Electronics')

@section('content')

@component('store.auth.shell', ['title' => 'Forgot your password?', 'subtitle' => 'Enter the email on your account and we will send you a link to set a new one.'])

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        @include('store.auth.field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email', 'autofocus' => true])
        <button type="submit" class="w-full rounded-full bg-brand-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700">
            Send reset link
        </button>
    </form>

    <p class="mt-8 text-center text-sm text-gray-500">
        Remembered it? <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:underline">Back to sign in</a>
    </p>

@endcomponent

@endsection
