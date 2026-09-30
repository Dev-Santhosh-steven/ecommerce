@csrf

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.css">
    <style>
        /* Tailwind's reset strips list/heading styles inside the editor. */
        trix-editor { min-height: 22rem; max-height: 70vh; overflow-y: auto; }
        trix-editor h1 { font-size: 1.35rem; font-weight: 700; margin: .75rem 0 .25rem; }
        trix-editor ul { list-style: disc; padding-left: 1.5rem; }
        trix-editor ol { list-style: decimal; padding-left: 1.5rem; }
        trix-editor blockquote { border-left: 3px solid #cbd5e1; padding-left: .75rem; color: #475569; }
        trix-editor a { color: #A51D35; text-decoration: underline; }
        trix-editor img { max-width: 100%; height: auto; border-radius: .5rem; }
        trix-toolbar .trix-button-group--file-tools { display: flex; }
    </style>
@endpush

<div class="grid gap-6 lg:grid-cols-3">

    {{-- Main column --}}
    <div class="space-y-5 lg:col-span-2">

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-lg focus:border-slate-500 focus:outline-none" placeholder="How interactive panels are changing classrooms">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Short Summary</label>
            <textarea name="excerpt" rows="2" maxlength="500" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="One or two sentences shown on the blog list and home page.">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Content <span class="text-red-500">*</span></label>
            <input id="post-content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
            <trix-editor input="post-content" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-800 focus:border-slate-500 focus:outline-none"></trix-editor>
            <p class="mt-1 text-xs text-slate-500">Use the toolbar for headings, bold, lists and links. Drag &amp; drop or paste images straight into the text (max 4&nbsp;MB each).</p>
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

    </div>


    {{-- Side column --}}
    <div class="space-y-5">

        <div class="rounded-xl border border-slate-200 p-4">
            <h3 class="mb-3 text-sm font-semibold text-slate-900">Publish</h3>

            <label class="mb-1 block text-sm font-medium text-slate-700">Status</label>
            <select name="is_published" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
                <option value="1" @selected(old('is_published', $post->is_published ? '1' : '0') == '1')>Published</option>
                <option value="0" @selected(old('is_published', $post->is_published ? '1' : '0') == '0')>Draft</option>
            </select>

            <label class="mb-1 mt-4 block text-sm font-medium text-slate-700">Publish Date</label>
            <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">
            <p class="mt-1 text-xs text-slate-500">Leave empty to publish now. A future date schedules the post.</p>
            @error('published_at')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="rounded-xl border border-slate-200 p-4">
            <h3 class="mb-3 text-sm font-semibold text-slate-900">Cover Image</h3>

            @if ($post->cover_image)
                <img src="{{ asset('storage/' . $post->cover_image) }}" alt="" class="mb-3 aspect-video w-full rounded-lg object-cover">
                <label class="mb-3 inline-flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remove_cover_image" value="1" class="rounded border-slate-300">
                    Remove cover image
                </label>
            @endif

            <input type="file" name="cover_image" accept="image/png,image/jpeg,image/webp" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <p class="mt-1 text-xs text-slate-500">Recommended 1600&times;900px (16:9), under 1&nbsp;MB.</p>
            @error('cover_image')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="rounded-xl border border-slate-200 p-4">
            <h3 class="mb-3 text-sm font-semibold text-slate-900">Details</h3>

            <label class="mb-1 block text-sm font-medium text-slate-700">Category</label>
            <input type="text" name="category" value="{{ old('category', $post->category) }}" list="post-categories" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none" placeholder="Interactive Panels">
            <datalist id="post-categories">
                @foreach (\App\Models\Post::whereNotNull('category')->distinct()->orderBy('category')->pluck('category') as $existingCategory)
                    <option value="{{ $existingCategory }}">
                @endforeach
            </datalist>

            <label class="mb-1 mt-4 block text-sm font-medium text-slate-700">Author</label>
            <input type="text" name="author" value="{{ old('author', $post->author) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">

            <label class="mb-1 mt-4 block text-sm font-medium text-slate-700">URL Slug</label>
            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 font-mono text-sm focus:border-slate-500 focus:outline-none" placeholder="auto-from-title">
            <p class="mt-1 text-xs text-slate-500">Leave empty to create it from the title.</p>
            @error('slug')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="rounded-xl border border-slate-200 p-4">
            <h3 class="mb-3 text-sm font-semibold text-slate-900">SEO <span class="font-normal text-slate-400">(optional)</span></h3>

            <label class="mb-1 block text-sm font-medium text-slate-700">Meta Title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" maxlength="255" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">

            <label class="mb-1 mt-4 block text-sm font-medium text-slate-700">Meta Description</label>
            <textarea name="meta_description" rows="3" maxlength="500" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-slate-500 focus:outline-none">{{ old('meta_description', $post->meta_description) }}</textarea>
        </div>

    </div>

</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/trix@2.1.15/dist/trix.umd.min.js"></script>
    <script>
        // Upload images dropped/pasted into the editor and swap in the stored URL.
        document.addEventListener('trix-attachment-add', function (event) {
            const attachment = event.attachment;

            if (!attachment.file) {
                return;
            }

            const data = new FormData();
            data.append('file', attachment.file);
            data.append('_token', '{{ csrf_token() }}');

            fetch('{{ route('admin.posts.upload-image') }}', {
                method: 'POST',
                body: data,
                headers: { 'Accept': 'application/json' },
            })
                .then((response) => response.ok ? response.json() : Promise.reject(response))
                .then((result) => attachment.setAttributes({ url: result.url, href: result.url }))
                .catch(() => {
                    alert('Image upload failed. Use a JPG, PNG or WebP under 4 MB.');
                    attachment.remove();
                });
        });

        // Only images are supported in the editor.
        document.addEventListener('trix-file-accept', function (event) {
            if (!event.file.type.startsWith('image/')) {
                event.preventDefault();
            }
        });
    </script>
@endpush
