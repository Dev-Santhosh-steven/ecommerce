@extends('layouts.store')

@section('title', 'Set a new password | Yara Electronics')

@section('content')

@component('store.auth.shell', ['title' => 'Set a new password'])

    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        @include('store.auth.field', ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'autocomplete' => 'email', 'value' => $email])
        @include('store.auth.field', ['name' => 'password', 'label' => 'New password', 'type' => 'password', 'autocomplete' => 'new-password', 'hint' => 'At least 8 characters, with a letter and a number.'])
        @include('store.auth.field', ['name' => 'password_confirmation', 'label' => 'Confirm new password', 'type' => 'password', 'autocomplete' => 'new-password'])
        <button type="submit" class="w-full rounded-full bg-brand-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700">
            Save new password
        </button>
    </form>

@endcomponent

@endsection
