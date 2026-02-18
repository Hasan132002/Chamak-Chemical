<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Chamak Chemicals</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #60a5fa 100%);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Decorative Circles -->
    <div class="absolute top-0 left-0 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>

    <!-- Login Card -->
    <div class="relative w-full max-w-md animate-fade-in">
        <!-- Logo & Title -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-4">
                <i class="fas fa-flask text-4xl text-blue-600"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-white mb-2">Chamak Chemicals</h1>
            <p class="text-blue-100 text-lg">Admin Panel Login</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-3xl shadow-2xl p-8">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                </div>
            @endif

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <span class="font-semibold">Login failed!</span> Please check your credentials.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-blue-500 mr-2"></i>Email Address
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('email') border-red-500 @enderror"
                        placeholder="admin@example.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>Password
                    </label>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition @error('password') border-red-500 @enderror"
                        placeholder="Enter your password"
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                        >
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800 font-semibold">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full py-4 text-white font-bold text-lg rounded-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200"
                    style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In to Admin Panel
                </button>
            </form>

            <!-- Divider -->
            <div class="flex items-center my-6">
                <div class="flex-1 border-t border-gray-300"></div>
                <span class="px-4 text-sm text-gray-500">or</span>
                <div class="flex-1 border-t border-gray-300"></div>
            </div>

            <!-- Back to Website -->
            <a
                href="{{ route('home') }}"
                class="block w-full py-3 text-center text-gray-700 font-semibold rounded-xl border-2 border-gray-300 hover:bg-gray-50 transition"
            >
                <i class="fas fa-home mr-2"></i>Back to Website
            </a>
        </div>

        <!-- Footer -->
        <p class="text-center text-white text-sm mt-6">
            <i class="fas fa-shield-alt mr-1"></i>
            Secure Admin Access Only
        </p>
    </div>
</body>
</html>
