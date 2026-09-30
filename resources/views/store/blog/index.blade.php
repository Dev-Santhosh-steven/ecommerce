@extends('layouts.store')

@section('title', ($category ? $category . ' | ' : '') . 'Blog | Yara Electronics')

@section('content')

{{-- =========================================================
     BLOG BANNER
========================================================= --}}
<section class="brand-banner relative overflow-hidden text-white">

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">

        <nav class="mb-3 text-sm text-gray-300">
            <a href="{{ route('store.home') }}" class="hover:text-white">Home</a>
            <span class="mx-2">/</span>
            <span class="text-white">Blog</span>
        </nav>

        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl">
            News &amp; Insights
        </h1>

        <p class="mt-4 max-w-2xl text-gray-300">
            Guides, product stories and ideas on display technology for classrooms, businesses and homes.
        </p>

    </div>

</section>


{{-- =========================================================
     POSTS
========================================================= --}}
<section class="bg-gray-50 py-14">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        @if ($categories->isNotEmpty())

            <div class="mb-10 flex flex-wrap gap-2">

                <a href="{{ route('store.blog.index') }}"
                   class="rounded-full px-4 py-2 text-sm font-medium transition {{ $category ? 'bg-white text-gray-700 ring-1 ring-gray-200 hover:ring-brand-300' : 'bg-brand-600 text-white' }}">
                    All
                </a>

                @foreach ($categories as $item)

                    <a href="{{ route('store.blog.index', ['category' => $item]) }}"
                       class="rounded-full px-4 py-2 text-sm font-medium transition {{ $category === $item ? 'bg-brand-600 text-white' : 'bg-white text-gray-700 ring-1 ring-gray-200 hover:ring-brand-300' }}">
                        {{ $item }}
                    </a>

                @endforeach

            </div>

        @endif


        @if ($posts->isEmpty())

            <div class="rounded-2xl border border-dashed border-gray-300 bg-white py-20 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">
                    <i data-lucide="newspaper" class="h-7 w-7"></i>
                </div>

                <h2 class="mt-4 font-semibold text-gray-900">No articles yet</h2>

                <p class="mt-1 text-sm text-gray-500">Check back soon for news and guides.</p>

            </div>

        @else

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($posts as $post)

                    @include('store.partials.post-card', ['post' => $post])

                @endforeach

            </div>

            @if ($posts->hasPages())

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>

            @endif

        @endif

    </div>

</section>

@endsection
