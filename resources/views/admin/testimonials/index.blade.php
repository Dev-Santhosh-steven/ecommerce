@extends('admin.layouts.app')

@section('title', 'Testimonials')

@section('page-title', 'Testimonials')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Testimonials
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Customer reviews shown on the homepage.
            </p>
        </div>

        <a
            href="{{ route('admin.testimonials.create') }}"
            class="
                inline-flex items-center justify-center gap-2
                rounded-xl bg-slate-900
                px-5 py-3
                text-sm font-semibold text-white
                transition
                hover:bg-slate-800
            "
        >
            <i data-lucide="plus" class="h-5 w-5"></i>

            Add Testimonial
        </a>

    </div>


    <!-- Success Message -->
    @if (session('success'))

        <div
            class="
                mb-6 flex items-center gap-3
                rounded-xl border border-emerald-200
                bg-emerald-50
                px-4 py-3
                text-sm text-emerald-700
            "
        >

            <i data-lucide="circle-check" class="h-5 w-5"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- Testimonials Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h3 class="font-semibold text-slate-900">
                All Testimonials
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                {{ $testimonials->total() }} testimonials
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[800px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Testimonial
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Rating
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Sort
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($testimonials as $testimonial)

                        <tr class="transition hover:bg-slate-50">

                            <!-- Customer -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    @if ($testimonial->photo)

                                        <img
                                            src="{{ asset('storage/' . $testimonial->photo) }}"
                                            alt="{{ $testimonial->name }}"
                                            class="h-11 w-11 shrink-0 rounded-full object-cover"
                                        >

                                    @else

                                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-semibold text-slate-600">
                                            {{ $testimonial->initials }}
                                        </div>

                                    @endif

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            {{ $testimonial->name }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-500">
                                            {{ collect([$testimonial->designation, $testimonial->company])->filter()->implode(', ') ?: '—' }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <!-- Message -->
                            <td class="px-6 py-5">

                                <p class="max-w-sm truncate text-sm text-slate-700">
                                    {{ $testimonial->message }}
                                </p>

                            </td>


                            <!-- Rating -->
                            <td class="px-6 py-5">

                                <span class="whitespace-nowrap text-sm text-amber-500">
                                    {{ str_repeat('★', $testimonial->rating) }}<span class="text-slate-300">{{ str_repeat('★', 5 - $testimonial->rating) }}</span>
                                </span>

                            </td>


                            <!-- Sort -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-700">
                                    {{ $testimonial->sort_order }}
                                </span>

                            </td>


                            <!-- Status -->
                            <td class="px-6 py-5">

                                @if ($testimonial->status)

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


                            <!-- Actions -->
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-2">

                                    <a
                                        href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                        title="Edit testimonial"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this testimonial?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                            title="Delete testimonial"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i data-lucide="message-square-quote" class="h-8 w-8"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-900">
                                        No testimonials yet
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Add your first customer testimonial.
                                    </p>

                                    <a
                                        href="{{ route('admin.testimonials.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                    >
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                        Add Testimonial
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($testimonials->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $testimonials->links() }}
            </div>

        @endif

    </div>

@endsection
