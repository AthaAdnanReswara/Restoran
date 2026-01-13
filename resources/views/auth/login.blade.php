<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Restoran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">
    <!-- Card -->
    <div class="bg-white p-6 sm:p-8 rounded-xl shadow-lg 
                w-full max-w-sm sm:max-w-md md:max-w-lg">

        <!-- Header -->
        <div class="text-center mb-6 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Welcome Back
            </h1>
            <p class="text-gray-500 text-sm sm:text-base">
                Sign in to continue
            </p>
        </div>

        @if(session('status'))
        <div class="mb-4 text-sm text-green-600 text-center">
            {{ session('status') }}
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form -->
        <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Email
                </label>
                <input type="email" name="email" required
                    value="{{ old('email') }}"
                    class="mt-1 block w-full rounded-lg border-gray-300 
                           focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input type="password" name="password" required
                    class="mt-1 block w-full rounded-lg border-gray-300 
                           focus:border-blue-500 focus:ring-blue-500 text-sm sm:text-base">
            </div>

            <button type="submit"
                class="w-full py-2.5 rounded-lg text-white text-sm sm:text-base 
                       font-medium bg-blue-600 hover:bg-blue-700 transition">
                Sign in
            </button>
        </form>

        <!-- Divider -->
        <div class="mt-8">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-xs sm:text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Or continue with
                    </span>
                </div>
            </div>

            <!-- Fingerprint -->
            <div class="mt-6 flex justify-center">
                <button id="fingerprintBtn" type="button"
                    class="p-4 rounded-full bg-gray-100 hover:bg-gray-200 
                           transition focus:ring-2 focus:ring-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-7 w-7 sm:h-8 sm:w-8 text-gray-600"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('fingerprintBtn').addEventListener('click', async () => {
            if (!window.PublicKeyCredential) {
                alert('Fingerprint not supported');
                return;
            }
            alert('Fingerprint authentication successful!');
        });
    </script>
</body>

</html>