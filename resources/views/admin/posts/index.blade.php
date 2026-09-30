@extends('admin.layouts.app')

@section('title', 'Blog')

@section('page-title', 'Blog')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Blog Posts
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Articles shown on the website blog.
            </p>
        </div>

        <a
            href="{{ route('admin.posts.create') }}"
            class="
                inline-flex items-center justify-center gap-2
                rounded-xl bg-slate-900
                px-5 py-3
                text-sm font-semibold text-white
                transition
                hover:bg-slate-800
            "
        >
            <i data-lucide="plus" class="h-5 w-5"></i>

            New Post
        </a>

    </div>


    <!-- Success Message -->
    @if (session('success'))

        <div
            class="
                mb-6 flex items-center gap-3
                rounded-xl border border-emerald-200
                bg-emerald-50
                px-4 py-3
                text-sm text-emerald-700
            "
        >

            <i data-lucide="circle-check" class="h-5 w-5"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- Posts Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h3 class="font-semibold text-slate-900">
                All Posts
            </h3>

            <p class="mt-1 text-sm text-slate-500">
                {{ $posts->total() }} posts
            </p>

        </div>


        <div class="overflow-x-auto">

            <table class="w-full min-w-[800px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Post
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Category
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Publish Date
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($posts as $post)

                        <tr class="transition hover:bg-slate-50">

                            <!-- Post -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    @if ($post->cover_image)

                                        <img
                                            src="{{ asset('storage/' . $post->cover_image) }}"
                                            alt=""
                                            class="h-12 w-20 shrink-0 rounded-xl object-cover"
                                        >

                                    @else

                                        <div class="flex h-12 w-20 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                                            <i data-lucide="newspaper" class="h-5 w-5"></i>
                                        </div>

                                    @endif

                                    <div class="min-w-0">

                                        <p class="max-w-sm truncate font-semibold text-slate-900">
                                            {{ $post->title }}
                                        </p>

                                        <p class="mt-0.5 max-w-sm truncate text-xs text-slate-500">
                                            /blog/{{ $post->slug }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <!-- Category -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-700">
                                    {{ $post->category ?: '—' }}
                                </span>

                            </td>


                            <!-- Date -->
                            <td class="px-6 py-5">

                                <span class="whitespace-nowrap text-sm text-slate-700">
                                    {{ $post->published_at?->format('d M Y, h:i A') ?? '—' }}
                                </span>

                            </td>


                            <!-- Status -->
                            <td class="px-6 py-5">

                                @if ($post->isLive())

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        Published
                                    </span>

                                @elseif ($post->is_published)

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>
                                        Scheduled
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        Draft
                                    </span>

                                @endif

                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-2">

                                    @if ($post->isLive())

                                        <a
                                            href="{{ route('store.blog.show', $post) }}"
                                            target="_blank"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                            title="View on website"
                                        >
                                            <i data-lucide="external-link" class="h-4 w-4"></i>
                                        </a>

                                    @endif

                                    <a
                                        href="{{ route('admin.posts.edit', $post) }}"
                                        class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                                        title="Edit post"
                                    >
                                        <i data-lucide="pencil" class="h-4 w-4"></i>
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.posts.destroy', $post) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this post?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg p-2 text-slate-500 transition hover:bg-red-50 hover:text-red-600"
                                            title="Delete post"
                                        >
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="flex flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                                        <i data-lucide="newspaper" class="h-8 w-8"></i>
                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-900">
                                        No blog posts yet
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Write your first article.
                                    </p>

                                    <a
                                        href="{{ route('admin.posts.create') }}"
                                        class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                                    >
                                        <i data-lucide="plus" class="h-4 w-4"></i>
                                        New Post
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($posts->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $posts->links() }}
            </div>

        @endif

    </div>

@endsection
