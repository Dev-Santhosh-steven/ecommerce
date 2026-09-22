@extends('admin.layouts.app')

@section('title', 'Categories')

@section('page-title', 'Categories')

@section('content')

    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h2 class="text-2xl font-bold text-slate-900">
                Categories
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage your product categories and subcategories.
            </p>
        </div>

        <a
            href="{{ route('admin.categories.create') }}"
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

            Add Category
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


    <!-- Error Message -->
    @if (session('error'))

        <div
            class="
                mb-6 flex items-center gap-3
                rounded-xl border border-red-200
                bg-red-50
                px-4 py-3
                text-sm text-red-700
            "
        >

            <i data-lucide="circle-alert" class="h-5 w-5"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    <!-- Categories Table -->
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <!-- Table Header -->
        <div
            class="
                flex flex-col gap-3
                border-b border-slate-200
                px-6 py-5
                sm:flex-row sm:items-center sm:justify-between
            "
        >

            <div>

                <h3 class="font-semibold text-slate-900">
                    All Categories
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $categories->total() }} categories
                </p>

            </div>

        </div>


        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="w-full min-w-[800px]">

                <thead class="bg-slate-50">

                    <tr>

                        <th
                            class="
                                px-6 py-4
                                text-left
                                text-xs font-semibold uppercase tracking-wider
                                text-slate-500
                            "
                        >
                            Category
                        </th>

                        <th
                            class="
                                px-6 py-4
                                text-left
                                text-xs font-semibold uppercase tracking-wider
                                text-slate-500
                            "
                        >
                            Parent
                        </th>

                        <th
                            class="
                                px-6 py-4
                                text-left
                                text-xs font-semibold uppercase tracking-wider
                                text-slate-500
                            "
                        >
                            Slug
                        </th>

                        <th
                            class="
                                px-6 py-4
                                text-left
                                text-xs font-semibold uppercase tracking-wider
                                text-slate-500
                            "
                        >
                            Sort
                        </th>

                        <th
                            class="
                                px-6 py-4
                                text-left
                                text-xs font-semibold uppercase tracking-wider
                                text-slate-500
                            "
                        >
                            Status
                        </th>

                        <th
                            class="
                                px-6 py-4
                                text-right
                                text-xs font-semibold uppercase tracking-wider
                                text-slate-500
                            "
                        >
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse ($categories as $category)

                        <tr class="transition hover:bg-slate-50">

                            <!-- Category -->
                            <td class="px-6 py-5">

                                <div class="flex items-center gap-3">

                                    @if ($category->image)

                                        <img
                                            src="{{ asset('storage/' . $category->image) }}"
                                            alt="{{ $category->name }}"
                                            class="h-12 w-12 rounded-xl object-cover"
                                        >

                                    @else

                                        <div
                                            class="
                                                flex h-12 w-12
                                                items-center justify-center
                                                rounded-xl
                                                bg-slate-100
                                                text-slate-500
                                            "
                                        >
                                            <i
                                                data-lucide="layers"
                                                class="h-5 w-5"
                                            ></i>
                                        </div>

                                    @endif


                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            {{ $category->name }}
                                        </p>

                                        @if ($category->description)

                                            <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                                {{ $category->description }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            <!-- Parent -->
                            <td class="px-6 py-5">

                                @if ($category->parent)

                                    <span class="text-sm text-slate-700">
                                        {{ $category->parent->name }}
                                    </span>

                                @else

                                    <span class="text-sm text-slate-400">
                                        Main Category
                                    </span>

                                @endif

                            </td>


                            <!-- Slug -->
                            <td class="px-6 py-5">

                                <code
                                    class="
                                        rounded-lg
                                        bg-slate-100
                                        px-2 py-1
                                        text-xs text-slate-600
                                    "
                                >
                                    {{ $category->slug }}
                                </code>

                            </td>


                            <!-- Sort -->
                            <td class="px-6 py-5">

                                <span class="text-sm text-slate-700">
                                    {{ $category->sort_order }}
                                </span>

                            </td>


                            <!-- Status -->
                            <td class="px-6 py-5">

                                @if ($category->status)

                                    <span
                                        class="
                                            inline-flex items-center gap-1.5
                                            rounded-full
                                            bg-emerald-50
                                            px-3 py-1.5
                                            text-xs font-semibold
                                            text-emerald-700
                                        "
                                    >

                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                        Active

                                    </span>

                                @else

                                    <span
                                        class="
                                            inline-flex items-center gap-1.5
                                            rounded-full
                                            bg-slate-100
                                            px-3 py-1.5
                                            text-xs font-semibold
                                            text-slate-600
                                        "
                                    >

                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                        Inactive

                                    </span>

                                @endif

                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-end gap-2">

                                    <!-- Edit -->
                                    <a
                                        href="{{ route('admin.categories.edit', $category) }}"
                                        class="
                                            rounded-lg p-2
                                            text-slate-500
                                            transition
                                            hover:bg-slate-100
                                            hover:text-slate-900
                                        "
                                        title="Edit category"
                                    >
                                        <i
                                            data-lucide="pencil"
                                            class="h-4 w-4"
                                        ></i>
                                    </a>


                                    <!-- Toggle Status -->
                                    <form
                                        method="POST"
                                        action="{{ route('admin.categories.toggle-status', $category) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="
                                                rounded-lg p-2
                                                text-slate-500
                                                transition
                                                hover:bg-slate-100
                                                hover:text-slate-900
                                            "
                                            title="{{ $category->status ? 'Disable category' : 'Enable category' }}"
                                        >

                                            @if ($category->status)

                                                <i
                                                    data-lucide="eye-off"
                                                    class="h-4 w-4"
                                                ></i>

                                            @else

                                                <i
                                                    data-lucide="eye"
                                                    class="h-4 w-4"
                                                ></i>

                                            @endif

                                        </button>

                                    </form>


                                    <!-- Delete -->
                                    <form
                                        method="POST"
                                        action="{{ route('admin.categories.destroy', $category) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this category?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="
                                                rounded-lg p-2
                                                text-slate-500
                                                transition
                                                hover:bg-red-50
                                                hover:text-red-600
                                            "
                                            title="Delete category"
                                        >

                                            <i
                                                data-lucide="trash-2"
                                                class="h-4 w-4"
                                            ></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-16 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div
                                        class="
                                            flex h-16 w-16
                                            items-center justify-center
                                            rounded-2xl
                                            bg-slate-100
                                            text-slate-400
                                        "
                                    >

                                        <i
                                            data-lucide="layers-3"
                                            class="h-8 w-8"
                                        ></i>

                                    </div>

                                    <h3 class="mt-4 font-semibold text-slate-900">
                                        No categories yet
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Create your first product category.
                                    </p>

                                    <a
                                        href="{{ route('admin.categories.create') }}"
                                        class="
                                            mt-5
                                            inline-flex items-center gap-2
                                            rounded-xl bg-slate-900
                                            px-4 py-2.5
                                            text-sm font-semibold text-white
                                            hover:bg-slate-800
                                        "
                                    >

                                        <i data-lucide="plus" class="h-4 w-4"></i>

                                        Add Category

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <!-- Pagination -->
        @if ($categories->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">

                {{ $categories->links() }}

            </div>

        @endif

    </div>

@endsection