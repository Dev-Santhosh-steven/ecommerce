<article class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg">

    <a href="{{ route('store.blog.show', $post) }}" class="relative block aspect-[16/9] overflow-hidden bg-gray-100">

        @if ($post->cover_image)

            <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">

        @else

            <div class="brand-dots flex h-full w-full items-center justify-center bg-gray-950 text-brand-400">
                <i data-lucide="newspaper" class="h-10 w-10"></i>
            </div>

        @endif

        @if ($post->category)

            <span class="absolute left-4 top-4 rounded-full bg-white/95 px-3 py-1 text-xs font-semibold text-brand-700 shadow-sm">
                {{ $post->category }}
            </span>

        @endif

    </a>

    <div class="flex flex-1 flex-col p-6">

        <p class="flex items-center gap-3 text-xs text-gray-500">
            <span>{{ $post->published_at->format('d M Y') }}</span>
            <span class="h-1 w-1 rounded-full bg-gray-300"></span>
            <span>{{ $post->reading_time }} min read</span>
        </p>

        <h3 class="mt-3 text-lg font-bold leading-snug text-gray-900 transition group-hover:text-brand-600">
            <a href="{{ route('store.blog.show', $post) }}">
                {{ $post->title }}
            </a>
        </h3>

        <p class="mt-3 line-clamp-3 flex-1 text-sm leading-6 text-gray-500">
            {{ $post->summary }}
        </p>

        <a href="{{ route('store.blog.show', $post) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:text-brand-700">
            Read more
            <i data-lucide="arrow-right" class="h-4 w-4 transition group-hover:translate-x-1"></i>
        </a>

    </div>

</article>
