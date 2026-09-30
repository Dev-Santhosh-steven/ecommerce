@extends('layouts.store')

@section('title', ($post->meta_title ?: $post->title) . ' | Yara Electronics')

@push('styles')
    <meta name="description" content="{{ $post->meta_description ?: $post->summary }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->meta_title ?: $post->title }}">
    <meta property="og:description" content="{{ $post->meta_description ?: $post->summary }}">
    @if ($post->cover_image)
        <meta property="og:image" content="{{ asset('storage/' . $post->cover_image) }}">
    @endif
@endpush

@section('content')

{{-- =========================================================
     POST HEADER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">

        <nav class="mb-4 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('store.blog.index') }}" class="hover:text-white">Blog</a>
            @if ($post->category)
                <span class="mx-2">/</span>
                <a href="{{ route('store.blog.index', ['category' => $post->category]) }}" class="hover:text-white">{{ $post->category }}</a>
            @endif
        </nav>

        <h1 class="text-3xl font-bold leading-tight tracking-tight sm:text-5xl">
            {{ $post->title }}
        </h1>

        <p class="mt-5 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-300">

            @if ($post->author)
                <span class="inline-flex items-center gap-1.5">
                    <i data-lucide="user-round" class="h-4 w-4"></i>
                    {{ $post->author }}
                </span>
            @endif

            <span class="inline-flex items-center gap-1.5">
                <i data-lucide="calendar" class="h-4 w-4"></i>
                {{ $post->published_at->format('d F Y') }}
            </span>

            <span class="inline-flex items-center gap-1.5">
                <i data-lucide="clock" class="h-4 w-4"></i>
                {{ $post->reading_time }} min read
            </span>

        </p>

    </div>

</section>


{{-- =========================================================
     POST BODY
========================================================= --}}
<article class="bg-white pb-16">

    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        @if ($post->cover_image)

            <img src="{{ asset('storage/' . $post->cover_image) }}" alt="{{ $post->title }}" class="-mt-6 relative aspect-[16/9] w-full rounded-2xl object-cover shadow-xl ring-1 ring-black/5 sm:-mt-10">

        @endif

        <div class="mx-auto max-w-3xl pt-10">

            @if ($post->excerpt)
                <p class="border-l-4 border-brand-600 pl-5 text-lg leading-8 text-gray-700">
                    {{ $post->excerpt }}
                </p>
            @endif

            {{-- Content is written by admins in the editor and filtered to safe tags on save. --}}
            <div class="blog-content mt-8">
                {!! $post->content !!}
            </div>


            {{-- Share + CTA --}}
            <div class="mt-12 flex flex-col gap-6 rounded-2xl bg-gray-50 p-6 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="font-semibold text-gray-900">Interested in our display solutions?</p>
                    <p class="mt-1 text-sm text-gray-500">Book a free demo and see them in action.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <a href="https://wa.me/?text={{ rawurlencode($post->title . ' ' . route('store.blog.show', $post)) }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white text-gray-600 ring-1 ring-gray-200 transition hover:text-[#25D366]"
                       aria-label="Share on WhatsApp">
                        <i data-lucide="share-2" class="h-4 w-4"></i>
                    </a>

                    <a href="{{ route('store.demo.create') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-brand-500">
                        Book a Demo
                        <i data-lucide="arrow-right" class="h-4 w-4"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

</article>


{{-- =========================================================
     RELATED POSTS
========================================================= --}}
@if ($related->isNotEmpty())

<section class="bg-gray-50 py-16">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-10 flex items-end justify-between gap-4">

            <h2 class="text-2xl font-bold tracking-tight sm:text-3xl">
                More <span class="text-brand-600">articles</span>
            </h2>

            <a href="{{ route('store.blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-600 hover:underline">
                View all
                <i data-lucide="arrow-right" class="h-4 w-4"></i>
            </a>

        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            @foreach ($related as $item)

                @include('store.partials.post-card', ['post' => $item])

            @endforeach

        </div>

    </div>

</section>

@endif

@endsection
