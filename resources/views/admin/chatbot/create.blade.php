@extends('admin.layouts.app')

@section('title', 'Add Chatbot Answer')

@section('page-title', 'Add Chatbot Answer')

@section('content')
    <div class="max-w-3xl rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <h1 class="text-2xl font-bold">Teach the Chatbot</h1>
        <p class="mt-1 text-sm text-slate-500">Add a question customers ask and how the chatbot should answer it.</p>

        <form action="{{ route('admin.chatbot.store') }}" method="POST" class="mt-6 space-y-5">
            @include('admin.chatbot._form')

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Save Answer</button>
                <a href="{{ route('admin.chatbot.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700">Cancel</a>
            </div>
        </form>
    </div>
@endsection
