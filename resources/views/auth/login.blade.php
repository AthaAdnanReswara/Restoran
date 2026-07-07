<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Restoran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-purple-700 via-violet-600 to-fuchsia-500">

    <!-- Card -->
    <div class="w-full max-w-md bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl p-8">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gradient-to-r from-purple-600 to-pink-500 flex items-center justify-center shadow-lg">
                <span class="text-3xl">☕</span>
            </div>

            <h1 class="text-3xl font-bold text-gray-800">
                Selamat Datang
            </h1>

            <p class="text-purple-600 font-medium mt-2">
                Purple Cafe & Resto
            </p>

            <p class="text-gray-500 text-sm mt-1">
                Silakan login untuk melanjutkan
            </p>
        </div>

        @if(session('status'))
        <div class="mb-4 rounded-lg bg-green-100 text-green-700 p-3 text-sm">
            {{ session('status') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 p-3 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    placeholder="Masukkan Email"
                    class="w-full rounded-xl border border-purple-200 px-4 py-3 focus:ring-4 focus:ring-purple-300 focus:border-purple-500 outline-none transition">
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Password
                </label>

                <input
                    type="password"
                    name="password"
                    required
                    placeholder="Masukkan Password"
                    class="w-full rounded-xl border border-purple-200 px-4 py-3 focus:ring-4 focus:ring-purple-300 focus:border-purple-500 outline-none transition">
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-purple-600 to-fuchsia-500 text-white font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition duration-300">
                Login
            </button>
        </form>

        <!-- Divider -->
        <div class="flex items-center my-8">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="px-3 text-gray-400 text-sm">
                Purple Cafe
            </span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <!-- Footer -->
        <p class="text-center text-sm text-gray-500">
            © 2026 Purple Cafe & Resto
        </p>

    </div>

</body>

</html>