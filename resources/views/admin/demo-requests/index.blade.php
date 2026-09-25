@extends('admin.layouts.app')

@section('title', 'Demo Requests')

@section('page-title', 'Demo Requests')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Demo Requests
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Leads submitted through the "Book a Demo" page.
            </p>
        </div>

        @if ($demoRequests->contains('is_read', false))

            <form method="POST" action="{{ route('admin.demo-requests.mark-all-read') }}">
                @csrf

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    <i data-lucide="check-check" class="h-5 w-5"></i>
                    Mark All as Read
                </button>
            </form>

        @endif

    </div>


    <!-- Success Message -->
    @if (session('success'))

        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i data-lucide="circle-check" class="h-5 w-5"></i>
            <span>{{ session('success') }}</span>
        </div>

    @endif


    <!-- Demo Requests Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h3 class="font-semibold text-slate-900">
                    All Requests
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $demoRequests->total() }} {{ \Illuminate\Support\Str::plural('request', $demoRequests->total()) }}
                </p>
            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Contact</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Organization</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Interested In</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Purpose</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Preferred Date</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Submitted</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse ($demoRequests as $demoRequest)

                        <tr class="transition hover:bg-slate-50 {{ !$demoRequest->is_read ? 'bg-indigo-50/40' : '' }}">

                            <td class="px-6 py-5">

                                <div class="flex items-center gap-2">

                                    @unless ($demoRequest->is_read)
                                        <span class="h-2 w-2 shrink-0 rounded-full bg-indigo-500" title="Unread"></span>
                                    @endunless

                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $demoRequest->name }}</p>
                                        <p class="mt-0.5 text-xs text-slate-500">{{ $demoRequest->email }}</p>
                                        <p class="text-xs text-slate-500">{{ $demoRequest->phone }}</p>
                                    </div>

                                </div>

                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ $demoRequest->organization ?: '—' }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ $demoRequest->category->name ?? 'General' }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ \App\Models\DemoRequest::PURPOSES[$demoRequest->purpose] ?? $demoRequest->purpose }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ $demoRequest->preferred_date?->format('d M Y') ?: '—' }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-500">
                                {{ $demoRequest->created_at->diffForHumans() }}
                            </td>

                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-2">

                                    @unless ($demoRequest->is_read)

                                        <form method="POST" action="{{ route('admin.demo-requests.read', $demoRequest) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" title="Mark as read">
                                                <i data-lucide="check" class="h-4 w-4"></i>
                                            </button>
                                        </form>

                                    @endunless

                                    <a href="mailto:{{ $demoRequest->email }}" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" title="Email">
                                        <i data-lucide="mail" class="h-4 w-4"></i>
                                    </a>

                                    <a href="tel:{{ $demoRequest->phone }}" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900" title="Call">
                                        <i data-lucide="phone" class="h-4 w-4"></i>
                                    </a>

                                    <form method="POST" action="{{ route('admin.demo-requests.destroy', $demoRequest) }}" onsubmit="return confirm('Delete this demo request?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600" title="Delete">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                        @if ($demoRequest->message)

                            <tr class="{{ !$demoRequest->is_read ? 'bg-indigo-50/40' : '' }}">
                                <td colspan="7" class="px-6 pb-5 pt-0">
                                    <p class="rounded-lg bg-slate-50 px-4 py-2.5 text-sm text-slate-600">
                                        <span class="font-medium text-slate-500">Note:</span> {{ $demoRequest->message }}
                                    </p>
                                </td>
                            </tr>

                        @endif

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i data-lucide="calendar-check" class="h-8 w-8"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-900">No demo requests yet</h3>
                                    <p class="mt-1 text-sm text-slate-500">Submissions from the "Book a Demo" page will show up here.</p>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($demoRequests->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $demoRequests->links() }}
            </div>

        @endif

    </div>

@endsection
