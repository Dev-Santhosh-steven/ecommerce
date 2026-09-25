@extends('admin.layouts.app')

@section('title', 'LED Modules')

@section('page-title', 'LED Modules')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                LED Modules
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Modules offered in the public
                <a href="{{ route('store.led-calculator') }}" target="_blank" class="underline decoration-slate-300 underline-offset-2 hover:text-slate-900">LED Wall Calculator</a>.
            </p>
        </div>

        <a
            href="{{ route('admin.led-modules.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800"
        >
            <i data-lucide="plus" class="h-5 w-5"></i>

            Add Module
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


    <!-- Modules Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h3 class="font-semibold text-slate-900">
                All Modules
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                {{ $modules->total() }} modules
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px]">

                <thead class="bg-slate-50">

                    <tr>
                        @foreach (['Module', 'Environment', 'Size / Pixels', 'Brightness', 'Cabinet', 'Product', 'Status'] as $heading)
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $heading }}</th>
                        @endforeach
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($modules as $module)

                        <tr class="transition hover:bg-slate-50">

                            <td class="px-6 py-5">
                                <p class="font-semibold text-slate-900">{{ $module->name }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $module->pixel_pitch ? 'P' . rtrim(rtrim(number_format($module->pixel_pitch, 4), '0'), '.') : '' }}
                                    {{ $module->model_number ? '· ' . $module->model_number : '' }}
                                </p>
                            </td>

                            <td class="px-6 py-5">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $module->environment === 'outdoor' ? 'bg-amber-50 text-amber-700' : 'bg-sky-50 text-sky-700' }}">
                                    {{ ucfirst($module->environment) }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ (float) $module->length_mm }} × {{ (float) $module->height_mm }} mm
                                <span class="block text-xs text-slate-500">{{ $module->pixel_width }} × {{ $module->pixel_height }} px</span>
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ $module->brightness_nits ? number_format($module->brightness_nits) . ' nits' : '—' }}
                            </td>

                            <td class="px-6 py-5 text-sm text-slate-700">
                                {{ $module->cabinet_w_mm ? (float) $module->cabinet_w_mm . ' × ' . (float) $module->cabinet_h_mm . ' mm' : '—' }}
                            </td>

                            <td class="px-6 py-5 text-sm">
                                @if ($module->product)
                                    <a href="{{ route('store.product', $module->product) }}" target="_blank" class="text-slate-600 underline decoration-slate-300 underline-offset-2 hover:text-slate-900">
                                        {{ $module->product->sku }}
                                    </a>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-5">
                                @if ($module->is_active)
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

                                    <a
                                        href="{{ route('admin.led-modules.edit', $module) }}"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                        title="Edit module"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.led-modules.destroy', $module) }}"
                                        onsubmit="return confirm('Delete this LED module?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600" title="Delete module">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i data-lucide="grid-3x3" class="h-8 w-8"></i>
                                    </div>
                                    <h3 class="mt-4 font-semibold text-slate-900">No LED modules yet</h3>
                                    <p class="mt-1 text-sm text-slate-500">Add a module to make it available in the calculator.</p>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($modules->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $modules->links() }}
            </div>
        @endif

    </div>

@endsection
