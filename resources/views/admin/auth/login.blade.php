<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Yara Electronics</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        <div class="bg-white rounded-2xl shadow-2xl p-8">

            <div class="text-center mb-8">

                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-xl bg-slate-900 text-white text-xl font-bold">
                    Y
                </div>

                <h1 class="text-2xl font-bold text-slate-900">
                    Yara Electronics
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    Administrator Login
                </p>

            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-lg bg-red-50 border border-red-200 p-4">
                    <p class="text-sm text-red-600">
                        {{ $errors->first() }}
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">

                @csrf

                <div>
                    <label
                        for="email"
                        class="block text-sm font-medium text-slate-700 mb-2"
                    >
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                        placeholder="admin@example.com"
                    >
                </div>

                <div>
                    <label
                        for="password"
                        class="block text-sm font-medium text-slate-700 mb-2"
                    >
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-slate-900 focus:ring-2 focus:ring-slate-900/10"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center gap-2">

                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        class="h-4 w-4 rounded border-slate-300"
                    >

                    <label
                        for="remember"
                        class="text-sm text-slate-600"
                    >
                        Remember me
                    </label>

                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-slate-900 px-4 py-3 font-semibold text-white transition hover:bg-slate-800"
                >
                    Sign In
                </button>

            </form>

        </div>

        <p class="mt-6 text-center text-sm text-slate-500">
            Yara Electronics Admin Panel
        </p>

    </div>

</body>
</html>