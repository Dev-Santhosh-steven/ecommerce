@extends('admin.layouts.app')

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold">Theme Sections</h1>
            <p class="mt-2 text-slate-600">Customize homepage content and blocks.</p>
        </div>

        <a href="{{ route('admin.theme-sections.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Add Section</a>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Page</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Type</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($themeSections as $themeSection)
                    <tr>
                        <td class="px-4 py-3 text-sm">{{ $themeSection->page }}</td>
                        <td class="px-4 py-3 text-sm">{{ $themeSection->name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $themeSection->type }}</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.theme-sections.edit', $themeSection) }}" class="text-blue-600">Edit</a>
                                <form action="{{ route('admin.theme-sections.destroy', $themeSection) }}" method="POST" onsubmit="return confirm('Delete this section?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">No theme sections found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
