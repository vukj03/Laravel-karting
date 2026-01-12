<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Racing+Sans+One&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'heading': ['Racing Sans One', 'cursive'],
                            'body': ['Poppins', 'sans-serif'],
                        },
                        colors: {
                            'kart-red': '#E63946',
                            'kart-blue': '#1D3557',
                            'kart-light': '#F1FAEE',
                            'kart-cyan': '#A8DADC',
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="font-body text-gray-800 bg-kart-light">
        <!-- Navigation -->
        <nav class="sticky top-0 z-50 bg-kart-blue text-white shadow-xl">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-kart-red rounded-full flex items-center justify-center">
                            <i class="fas fa-flag-checkered text-white"></i>
                        </div>
                        <a href="{{ url('/') }}" class="text-3xl font-heading tracking-wide">KART<span class="text-kart-red">CENTER</span></a>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-kart-red rounded hover:bg-red-600 transition font-medium">Login</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-transparent border border-white rounded hover:bg-white hover:text-kart-blue transition font-medium">Register</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Login Container -->
        <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-kart-blue/20 to-kart-red/20 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-3xl shadow-2xl">
                <div>
                    <div class="flex justify-center">
                        <div class="w-20 h-20 bg-kart-red rounded-full flex items-center justify-center mb-6">
                            <i class="fas fa-flag-checkered text-white text-3xl"></i>
                        </div>
                    </div>
                    <h2 class="mt-6 text-center text-4xl font-heading text-gray-900">
                        Welcome Back
                    </h2>
                    <p class="mt-2 text-center text-lg text-gray-600">
                        Sign in to your account
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded-lg">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="mt-8 space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="space-y-4">
                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-envelope mr-2"></i>Email Address
                            </label>
                            <input id="email" name="email" type="email" autocomplete="email" required 
                                   class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-kart-red focus:border-transparent focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                                   placeholder="Enter your email"
                                   value="{{ old('email') }}">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-lock mr-2"></i>Password
                            </label>
                            <div class="relative">
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                       class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-kart-red focus:border-transparent focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                                       placeholder="Enter your password">
                                <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" 
                                   class="h-4 w-4 text-kart-red focus:ring-kart-red border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" class="font-medium text-kart-red hover:text-red-600 transition">
                                    Forgot your password?
                                </a>
                            </div>
                        @endif
                    </div>

                    <div>
                        <button type="submit" 
                                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-lg font-bold rounded-lg text-white bg-kart-red hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-kart-red transition duration-300 transform hover:scale-[1.02]">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-medium text-kart-red hover:text-red-600 transition ml-1">
                                Sign up now
                            </a>
                        </p>
                    </div>

                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">Or continue with</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3">
                        <a href="#" class="w-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            <i class="fab fa-google text-red-500"></i>
                        </a>
                        <a href="#" class="w-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            <i class="fab fa-facebook text-blue-600"></i>
                        </a>
                        <a href="#" class="w-full inline-flex justify-center py-3 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            <i class="fab fa-twitter text-blue-400"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-kart-blue text-white py-10">
            <div class="container mx-auto px-6">
                <div class="text-center">
                    <p>&copy; {{ date('Y') }} KartCenter. All rights reserved. | Designed with <i class="fas fa-heart text-kart-red"></i> for racing enthusiasts</p>
                </div>
            </div>
        </footer>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.getElementById('toggleIcon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            }
        </script>
    </body>
</html>