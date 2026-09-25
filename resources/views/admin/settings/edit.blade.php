@extends('admin.layouts.app')

@section('title', 'Settings')

@section('page-title', 'Settings')

@section('content')

    <div class="mx-auto max-w-2xl">

        @if (session('success'))

            <div class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <i data-lucide="circle-check" class="h-5 w-5"></i>
                <span>{{ session('success') }}</span>
            </div>

        @endif

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

            <h1 class="text-2xl font-bold">Site Branding</h1>
            <p class="mt-1 text-sm text-slate-500">
                Upload the logo shown in the site header and footer.
            </p>

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div>

                    <label class="mb-1 block text-sm font-medium text-slate-700">Logo</label>

                    @if ($setting->logo)

                        <div class="mb-3 flex h-20 items-center rounded-lg border border-slate-200 bg-slate-50 px-4">
                            <img src="{{ asset('storage/' . $setting->logo) }}" alt="Current logo" class="h-12 w-auto">
                        </div>

                    @endif

                    <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml,image/webp" class="w-full rounded-lg border border-slate-300 px-3 py-2">

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Recommended: a wide, transparent-background PNG or SVG, roughly
                        <strong>400&times;120px</strong> (or any similar wide rectangle &mdash;
                        avoid a perfect square). It's displayed at about 40px tall, so SVG or a
                        sharp PNG keeps it crisp on retina screens. PNG/JPG/SVG/WEBP, up to 2MB.
                    </p>

                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-medium text-white">Save Settings</button>
                </div>

            </form>

        </div>

    </div>

@endsection
