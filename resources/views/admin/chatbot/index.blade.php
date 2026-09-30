@extends('admin.layouts.app')

@section('title', 'Chatbot')

@section('page-title', 'Chatbot')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Chatbot Knowledge Base
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Questions and answers the website chatbot uses. Product questions are answered automatically from your catalogue.
            </p>
        </div>

        <a
            href="{{ route('admin.chatbot.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
        >
            <i data-lucide="plus" class="h-5 w-5"></i>

            Add Answer
        </a>

    </div>


    <!-- Success Message -->
    @if (session('success'))

        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">

            <i data-lucide="circle-check" class="h-5 w-5"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- Stats -->
    <div class="mb-6 grid gap-4 sm:grid-cols-4">

        @php
            $rate = $stats['total'] ? round($stats['answered'] / $stats['total'] * 100) : 0;
        @endphp

        @foreach ([
            ['label' => 'Answers', 'value' => $faqs->total(), 'icon' => 'book-open'],
            ['label' => 'Chats (7 days)', 'value' => $stats['week'], 'icon' => 'messages-square'],
            ['label' => 'Total messages', 'value' => $stats['total'], 'icon' => 'message-circle'],
            ['label' => 'Answered', 'value' => $rate . '%', 'icon' => 'circle-check'],
        ] as $stat)

            <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                    <i data-lucide="{{ $stat['icon'] }}" class="h-5 w-5"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</p>
                    <p class="text-xs text-slate-500">{{ $stat['label'] }}</p>
                </div>
            </div>

        @endforeach

    </div>


    <div class="mb-6 grid gap-6 lg:grid-cols-2">

        <!-- Test the bot -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
            x-data="{
                message: '',
                result: null,
                loading: false,
                async ask() {
                    if (! this.message.trim()) return;
                    this.loading = true;
                    const response = await fetch('{{ route('store.chatbot.message') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ message: this.message }),
                    });
                    this.result = await response.json();
                    this.loading = false;
                },
            }"
        >

            <h3 class="flex items-center gap-2 font-semibold text-slate-900">
                <i data-lucide="flask-conical" class="h-5 w-5 text-slate-500"></i>
                Test the Chatbot
            </h3>

            <p class="mt-1 text-sm text-slate-500">Type a question the way a customer would and see the answer.</p>

            <form @submit.prevent="ask()" class="mt-4 flex gap-2">
                <input type="text" x-model="message" maxlength="300" class="min-w-0 flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none" placeholder="e.g. price of 65 inch panel">
                <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white" :disabled="loading">
                    <span x-show="! loading">Ask</span>
                    <span x-show="loading" x-cloak>…</span>
                </button>
            </form>

            <div x-show="result" x-cloak class="mt-4 rounded-xl bg-slate-50 p-4 text-sm">
                <p class="whitespace-pre-line text-slate-700" x-text="result?.reply"></p>

                <template x-for="product in (result?.products || [])" :key="product.url">
                    <p class="mt-2 text-slate-600">• <span x-text="product.name"></span> <span class="font-semibold" x-text="product.price"></span></p>
                </template>

                <template x-for="link in (result?.links || [])" :key="link.url">
                    <span class="mr-2 mt-3 inline-block rounded-full bg-white px-3 py-1 text-xs font-medium text-slate-700 ring-1 ring-slate-200" x-text="link.label + ' → ' + link.url"></span>
                </template>
            </div>

        </div>


        <!-- Unanswered -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">
                <h3 class="flex items-center gap-2 font-semibold text-slate-900">
                    <i data-lucide="circle-help" class="h-5 w-5 text-amber-500"></i>
                    Unanswered Questions
                </h3>
                <p class="mt-1 text-sm text-slate-500">Visitors asked these and the bot had no answer. Add an answer to train it.</p>
            </div>

            <div class="max-h-80 divide-y divide-slate-100 overflow-y-auto">

                @forelse ($unanswered as $log)

                    <div class="flex items-center gap-3 px-6 py-3">

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-medium text-slate-900">{{ $log->message }}</p>
                            <p class="text-xs text-slate-500">
                                Asked {{ $log->times }} {{ Str::plural('time', $log->times) }} · {{ \Illuminate\Support\Carbon::parse($log->last_asked)->diffForHumans() }}
                            </p>
                        </div>

                        <a href="{{ route('admin.chatbot.create', ['question' => $log->message]) }}"
                           class="shrink-0 rounded-lg bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white hover:bg-slate-800">
                            Add answer
                        </a>

                        <form method="POST" action="{{ route('admin.chatbot.dismiss-log') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="message" value="{{ $log->message }}">
                            <button type="submit" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-700" title="Dismiss">
                                <i data-lucide="x" class="h-4 w-4"></i>
                            </button>
                        </form>

                    </div>

                @empty

                    <p class="px-6 py-10 text-center text-sm text-slate-500">
                        Nothing yet. The chatbot has answered every question so far.
                    </p>

                @endforelse

            </div>

        </div>

    </div>


    <!-- Knowledge base -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[800px]">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Question &amp; Answer</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Keywords</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Used</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($faqs as $faq)

                        <tr class="align-top transition hover:bg-slate-50">

                            <td class="px-6 py-5">
                                <p class="flex items-center gap-2 font-semibold text-slate-900">
                                    {{ $faq->question }}
                                    @if ($faq->show_as_suggestion)
                                        <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-semibold uppercase text-blue-700">Quick reply</span>
                                    @endif
                                </p>
                                <p class="mt-1 max-w-md text-sm text-slate-500 line-clamp-2">{{ $faq->answer }}</p>
                            </td>

                            <td class="px-6 py-5">
                                <p class="max-w-xs text-xs text-slate-500 line-clamp-3">{{ $faq->keywords ?: '—' }}</p>
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ number_format($faq->hits) }}×
                            </td>

                            <td class="px-6 py-5">
                                @if ($faq->status)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center justify-end gap-2">

                                    <a href="{{ route('admin.chatbot.edit', $faq) }}" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" title="Edit answer">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.chatbot.destroy', $faq) }}" onsubmit="return confirm('Delete this answer?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600" title="Delete answer">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-sm text-slate-500">
                                No answers yet. Click <strong>Add Answer</strong> to teach the chatbot.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($faqs->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $faqs->links() }}
            </div>
        @endif

    </div>

@endsection
