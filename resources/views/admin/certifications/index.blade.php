@extends('admin.layouts.app')

@section('title', 'Certifications')

@section('page-title', 'Certifications')

@section('content')

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Certifications</h2>
            <p class="mt-1 text-sm text-slate-500">
                Certificates shown on the public Certifications page. Upload the document (PDF or image) to make it downloadable.
            </p>
        </div>

        <a href="{{ route('admin.certifications.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            <i data-lucide="plus" class="h-5 w-5"></i>
            Add Certification
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <i data-lucide="circle-check" class="h-5 w-5"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <h3 class="font-semibold text-slate-900">All Certifications</h3>
            <p class="mt-1 text-sm text-slate-500">
                {{ $certifications->total() }} certifications ·
                {{ $certifications->getCollection()->filter->hasFile()->count() }} with a downloadable document on this page
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px]">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Certification</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Document</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Sort</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($certifications as $certification)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-slate-100">
                                        @if ($certification->logoUrl())
                                            <img src="{{ $certification->logoUrl() }}" alt="" class="max-h-10 max-w-10 object-contain">
                                        @else
                                            <i data-lucide="{{ $certification->icon ?: 'award' }}" class="h-5 w-5 text-slate-500"></i>
                                        @endif
                                    </span>
                                    <div>
                                        <p class="font-semibold text-slate-900">{{ $certification->title }}</p>
                                        <p class="text-sm text-slate-500">{{ $certification->issuer }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-sm">
                                @if ($certification->hasFile())
                                    <a href="{{ asset('storage/' . $certification->file) }}" target="_blank" class="inline-flex items-center gap-1.5 font-medium text-emerald-700 hover:underline">
                                        <i data-lucide="file-check" class="h-4 w-4"></i>
                                        {{ $certification->fileLabel() }}
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-amber-600">
                                        <i data-lucide="file-warning" class="h-4 w-4"></i>
                                        Not uploaded
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">{{ $certification->sort_order }}</td>

                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $certification->status ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $certification->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.certifications.edit', $certification) }}" class="rounded-lg border border-slate-200 p-2 text-slate-600 transition hover:bg-slate-100" title="Edit">
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>
                                    <form action="{{ route('admin.certifications.destroy', $certification) }}" method="POST" onsubmit="return confirm('Delete this certification and its uploaded document?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-red-200 p-2 text-red-600 transition hover:bg-red-50" title="Delete">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No certifications yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-slate-200 px-6 py-4">
            {{ $certifications->links() }}
        </div>

    </div>

@endsection
