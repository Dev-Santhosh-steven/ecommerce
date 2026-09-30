@csrf

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Customer Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="Ravi Kumar">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Designation</label>
        <input type="text" name="designation" value="{{ old('designation', $testimonial->designation) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="Principal">
        @error('designation')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Company / Organisation</label>
    <input type="text" name="company" value="{{ old('company', $testimonial->company) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="ABC Public School, Coimbatore">
    @error('company')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Testimonial <span class="text-red-500">*</span></label>
    <textarea name="message" rows="5" maxlength="1000" required class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="What the customer said about Yara Electronics...">{{ old('message', $testimonial->message) }}</textarea>
    <p class="mt-1 text-xs text-slate-500">Up to 1000 characters. 2–4 sentences look best on the homepage.</p>
    @error('message')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Photo</label>

    @if ($testimonial->photo)
        <div class="mb-3 flex items-center gap-4">
            <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="{{ $testimonial->name }}" class="h-16 w-16 rounded-full object-cover ring-1 ring-slate-200">
            <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remove_photo" value="1" class="rounded border-slate-300">
                Remove photo
            </label>
        </div>
    @endif

    <input type="file" name="photo" accept="image/png,image/jpeg,image/webp" class="w-full rounded-lg border border-slate-300 px-3 py-2">
    <p class="mt-1 text-xs text-slate-500">
        Optional. Shown large on the homepage, so use a <strong>portrait image, 4:5 ratio</strong> (e.g. 1080&times;1350px):
        the customer, their installation, or the product in use. Keep faces and key details near the centre.
        If empty, the customer's initials are shown instead.
    </p>
    @error('photo')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="grid gap-5 md:grid-cols-3">
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Rating</label>
        <select name="rating" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            @for ($i = 5; $i >= 1; $i--)
                <option value="{{ $i }}" @selected((int) old('rating', $testimonial->rating) === $i)>{{ str_repeat('★', $i) }} ({{ $i }})</option>
            @endfor
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
        <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            <option value="1" @selected(old('status', $testimonial->status ? '1' : '0') == '1')>Active</option>
            <option value="0" @selected(old('status', $testimonial->status ? '1' : '0') == '0')>Inactive</option>
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
    </div>
</div>
