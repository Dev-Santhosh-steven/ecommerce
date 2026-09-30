@php
    $input = 'w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none';
@endphp

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Title</label>
    <input type="text" name="title" value="{{ old('title', $certification->title) }}" class="{{ $input }}" placeholder="ISO 9001:2015 Quality Management" required>
    @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Issued by</label>
        <input type="text" name="issuer" value="{{ old('issuer', $certification->issuer) }}" class="{{ $input }}" placeholder="Bureau of Indian Standards">
        @error('issuer') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Short code</label>
        <input type="text" name="code" value="{{ old('code', $certification->code) }}" class="{{ $input }}" placeholder="ISO 9001">
        <p class="mt-1 text-xs text-slate-500">Shown on the badge when there is no logo.</p>
    </div>
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Description</label>
    <textarea name="description" rows="2" class="{{ $input }}" placeholder="What this certification means for customers.">{{ old('description', $certification->description) }}</textarea>
    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
    <label class="mb-1 block text-sm font-semibold text-slate-800">Certificate document (downloadable)</label>
    <input type="file" name="file" accept="application/pdf,image/jpeg,image/png,image/webp" class="{{ $input }} bg-white">
    <p class="mt-1 text-xs text-slate-500">PDF, JPG, PNG or WebP, up to 20MB. Visitors download this from the Certifications page.</p>
    @if ($certification->hasFile())
        <div class="mt-3 flex flex-wrap items-center gap-4 text-sm">
            <a href="{{ asset('storage/' . $certification->file) }}" target="_blank" class="inline-flex items-center gap-1.5 font-medium text-emerald-700 hover:underline">
                <i data-lucide="file-check" class="h-4 w-4"></i> Current: {{ $certification->fileLabel() }}
            </a>
            <label class="inline-flex items-center gap-2 text-slate-600">
                <input type="checkbox" name="remove_file" value="1" class="rounded border-slate-300"> Remove document
            </label>
        </div>
    @endif
    @error('file') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Logo (optional)</label>
        <input type="file" name="logo" accept="image/*" class="{{ $input }}">
        @if ($certification->logoUrl())
            <img src="{{ $certification->logoUrl() }}" alt="" class="mt-2 h-12 w-auto object-contain">
        @endif
        @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Icon when there is no logo</label>
        <input type="text" name="icon" value="{{ old('icon', $certification->icon) }}" class="{{ $input }}" placeholder="badge-check">
        <p class="mt-1 text-xs text-slate-500">A <a href="https://lucide.dev/icons" target="_blank" class="underline">Lucide</a> icon name.</p>
    </div>
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
        <select name="status" class="{{ $input }}">
            <option value="1" @selected(old('status', $certification->status ?? true))>Active</option>
            <option value="0" @selected(! old('status', $certification->status ?? true))>Inactive</option>
        </select>
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $certification->sort_order ?? 0) }}" min="0" class="{{ $input }}">
    </div>
</div>
