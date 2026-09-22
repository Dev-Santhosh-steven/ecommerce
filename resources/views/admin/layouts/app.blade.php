<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Admin Panel') | Yara Electronics
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body
    class="min-h-screen bg-slate-100 text-slate-900"
    x-data="{ sidebarOpen: false }"
>

    <!-- Mobile Overlay -->
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-slate-950/50 lg:hidden"
        style="display: none;"
    ></div>


    <!-- Sidebar -->
    <aside
        class="
            fixed inset-y-0 left-0 z-50
            flex w-64 flex-col
            bg-slate-950 text-white
            transform transition-transform duration-300
            lg:translate-x-0
        "
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >

        <!-- Logo -->
        <div class="flex h-20 items-center border-b border-white/10 px-6">

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-lg font-bold text-slate-950"
            >
                Y
            </div>

            <div class="ml-3">

                <p class="font-semibold">
                    Yara Electronics
                </p>

                <p class="text-xs text-slate-400">
                    Administration
                </p>

            </div>

        </div>


        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-4 py-6">

            <!-- Main -->
            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Main
            </p>

            <a
                href="{{ route('admin.dashboard') }}"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    transition
                    hover:bg-white/10
                "
            >
                <i data-lucide="layout-dashboard" class="h-5 w-5"></i>

                <span>
                    Dashboard
                </span>
            </a>


            <!-- Catalog -->
            <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Catalog
            </p>

            <a
                href="{{ route('admin.categories.index') }}"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    text-slate-300 transition
                    hover:bg-white/10 hover:text-white
                "
            >
                <i data-lucide="layers" class="h-5 w-5"></i>

                <span>
                    Categories
                </span>
            </a>


            <a
                href="{{ route('admin.products.index') }}"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    text-slate-300 transition
                    hover:bg-white/10 hover:text-white
                "
            >
                <i data-lucide="package" class="h-5 w-5"></i>

                <span>
                    Products
                </span>
            </a>


            <!-- Sales -->
            <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Sales
            </p>

            <a
                href="#"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    text-slate-300 transition
                    hover:bg-white/10 hover:text-white
                "
            >
                <i data-lucide="shopping-cart" class="h-5 w-5"></i>

                <span>
                    Orders
                </span>
            </a>


            <a
                href="#"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    text-slate-300 transition
                    hover:bg-white/10 hover:text-white
                "
            >
                <i data-lucide="users" class="h-5 w-5"></i>

                <span>
                    Customers
                </span>
            </a>


            <!-- Content -->
            <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Content
            </p>

            <a
                href="{{ route('admin.theme-sections.index') }}"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    text-slate-300 transition
                    hover:bg-white/10 hover:text-white
                "
            >
                <i data-lucide="layout-template" class="h-5 w-5"></i>

                <span>
                    Homepage
                </span>
            </a>


            <a
                href="{{ route('admin.banners.index') }}"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    text-slate-300 transition
                    hover:bg-white/10 hover:text-white
                "
            >
                <i data-lucide="image" class="h-5 w-5"></i>

                <span>
                    Banners
                </span>
            </a>


            <!-- Settings -->
            <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                System
            </p>

            <a
                href="#"
                class="
                    mb-1 flex items-center gap-3 rounded-xl
                    px-3 py-3 text-sm font-medium
                    text-slate-300 transition
                    hover:bg-white/10 hover:text-white
                "
            >
                <i data-lucide="settings" class="h-5 w-5"></i>

                <span>
                    Settings
                </span>
            </a>

        </nav>


        <!-- Sidebar Bottom -->
        <div class="border-t border-white/10 p-4">

            <div class="flex items-center gap-3 rounded-xl bg-white/5 p-3">

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-sm font-bold text-slate-950"
                >
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-medium">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="truncate text-xs text-slate-400">
                        Administrator
                    </p>

                </div>

            </div>

        </div>

    </aside>


    <!-- Main Area -->
    <div class="min-h-screen lg:pl-64">


        <!-- Top Header -->
        <header
            class="
                sticky top-0 z-30
                flex h-20 items-center
                justify-between
                border-b border-slate-200
                bg-white/95 px-4 backdrop-blur
                sm:px-6
            "
        >

            <div class="flex items-center gap-4">

                <!-- Mobile Menu -->
                <button
                    type="button"
                    @click="sidebarOpen = true"
                    class="
                        rounded-lg p-2
                        text-slate-600
                        hover:bg-slate-100
                        lg:hidden
                    "
                >
                    <i data-lucide="menu" class="h-6 w-6"></i>
                </button>


                <div>

                    <h1 class="text-lg font-semibold text-slate-900">
                        @yield('page-title', 'Dashboard')
                    </h1>

                    <p class="hidden text-sm text-slate-500 sm:block">
                        Manage your Yara Electronics store
                    </p>

                </div>

            </div>


            <!-- Right Side -->
            <div class="flex items-center gap-3">

                <!-- Store -->
                <a
                    href="/"
                    target="_blank"
                    class="
                        hidden items-center gap-2
                        rounded-lg border border-slate-200
                        px-3 py-2 text-sm font-medium
                        text-slate-600
                        transition
                        hover:bg-slate-50
                        sm:flex
                    "
                >
                    <i data-lucide="external-link" class="h-4 w-4"></i>

                    View Store
                </a>


                <!-- Logout -->
                <form
                    method="POST"
                    action="{{ route('admin.logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="
                            flex items-center gap-2
                            rounded-lg bg-slate-900
                            px-3 py-2
                            text-sm font-medium text-white
                            transition
                            hover:bg-slate-800
                        "
                    >

                        <i data-lucide="log-out" class="h-4 w-4"></i>

                        <span class="hidden sm:inline">
                            Logout
                        </span>

                    </button>

                </form>

            </div>

        </header>


        <!-- Page Content -->
        <main class="p-4 sm:p-6 lg:p-8">

            @yield('content')

        </main>

    </div>


    <!-- Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>

    @stack('scripts')

</body>

</html>