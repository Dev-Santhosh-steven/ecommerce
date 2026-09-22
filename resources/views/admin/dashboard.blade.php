@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    <div class="mb-8">

        <h2 class="text-2xl font-bold text-slate-900">
            Welcome back, {{ auth()->user()->name }}
        </h2>

        <p class="mt-1 text-slate-500">
            Here's what's happening with your store.
        </p>

    </div>


    <!-- Statistics -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">


        <!-- Products -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Products
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $productCount }}
                    </p>

                </div>

                <div class="rounded-xl bg-slate-100 p-3">

                    <i
                        data-lucide="package"
                        class="h-6 w-6 text-slate-700"
                    ></i>

                </div>

            </div>

        </div>


        <!-- Categories -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Categories
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $categoryCount }}
                    </p>

                </div>

                <div class="rounded-xl bg-slate-100 p-3">

                    <i
                        data-lucide="layers"
                        class="h-6 w-6 text-slate-700"
                    ></i>

                </div>

            </div>

        </div>


        <!-- Orders -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Orders
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        0
                    </p>

                </div>

                <div class="rounded-xl bg-slate-100 p-3">

                    <i
                        data-lucide="shopping-cart"
                        class="h-6 w-6 text-slate-700"
                    ></i>

                </div>

            </div>

        </div>


        <!-- Customers -->
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Customers
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        0
                    </p>

                </div>

                <div class="rounded-xl bg-slate-100 p-3">

                    <i
                        data-lucide="users"
                        class="h-6 w-6 text-slate-700"
                    ></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Getting Started -->
    <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="flex items-start gap-4">

            <div class="rounded-xl bg-slate-900 p-3 text-white">

                <i
                    data-lucide="rocket"
                    class="h-6 w-6"
                ></i>

            </div>

            <div>

                <h3 class="text-lg font-semibold text-slate-900">
                    Your store administration is ready
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Start by creating your product categories and products.
                    You will later be able to control the homepage directly
                    from the Content section.
                </p>

            </div>

        </div>

    </div>

@endsection