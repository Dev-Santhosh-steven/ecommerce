@csrf

@if (request('question'))
    <input type="hidden" name="from_log" value="{{ request('question') }}">
@endif

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Customer Question <span class="text-red-500">*</span></label>
    <input type="text" name="question" value="{{ old('question', $faq->question) }}" required maxlength="255" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="Do you provide installation?">
    <p class="mt-1 text-xs text-slate-500">Write it the way a customer would ask. Also used as the quick-reply button text.</p>
    @error('question')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Keywords</label>
    <textarea name="keywords" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm focus:border-slate-500 focus:outline-none" placeholder="installation, install, fitting, wall mount, setup">{{ old('keywords', $faq->keywords) }}</textarea>
    <p class="mt-1 text-xs text-slate-500">
        Comma-separated words or phrases customers might use, including common spellings and Tanglish
        (e.g. <em>install, installation, fitting, setup</em>). The more you add, the better the bot recognises the question.
    </p>
    @error('keywords')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium text-slate-700">Chatbot Answer <span class="text-red-500">*</span></label>
    <textarea name="answer" rows="6" required maxlength="3000" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="Yes! Our team installs every panel...">{{ old('answer', $faq->answer) }}</textarea>
    <p class="mt-1 text-xs text-slate-500">Plain text. Line breaks are kept. Keep it short and friendly, 2–4 sentences.</p>
    @error('answer')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div class="grid gap-5 md:grid-cols-2">
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Button Text <span class="font-normal text-slate-400">(optional)</span></label>
        <input type="text" name="button_text" value="{{ old('button_text', $faq->button_text) }}" maxlength="60" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="Book a Demo">
        @error('button_text')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Button Link</label>
        <input type="text" name="button_url" value="{{ old('button_url', $faq->button_url) }}" maxlength="255" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="/book-a-demo  or  https://wa.me/91...  or  tel:+91...">
        @error('button_url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid gap-5 md:grid-cols-3">
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
        <select name="status" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            <option value="1" @selected(old('status', $faq->status ? '1' : '0') == '1')>Active</option>
            <option value="0" @selected(old('status', $faq->status ? '1' : '0') == '0')>Inactive</option>
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Quick Reply Button</label>
        <select name="show_as_suggestion" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            <option value="0" @selected(! old('show_as_suggestion', $faq->show_as_suggestion))>No</option>
            <option value="1" @selected(old('show_as_suggestion', $faq->show_as_suggestion))>Yes, show as a suggestion</option>
        </select>
    </div>

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $faq->sort_order ?? 0) }}" min="0" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
    </div>
</div>
