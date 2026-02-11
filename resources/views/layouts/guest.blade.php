<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Toast Notifications -->
        <x-toast-notification />

        <div class="min-h-screen flex">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 40px 40px;"></div>
                </div>
                
                <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                    <a href="/" class="mb-8">
                        <img src="{{ asset('images/logo-white.png') }}" alt="CBM Auto" class="h-24 w-auto max-w-none">
                    </a>
                    <h1 class="text-4xl font-bold mb-4">{{ __('messages.auth_welcome') }}</h1>
                    <p class="text-xl text-gray-300 leading-relaxed">
                        {{ __('messages.auth_description') }}
                    </p>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden text-center mb-8">
                        <a href="/" class="inline-block">
                            <img src="{{ asset('images/logo.png') }}" alt="CBM Auto" class="h-16 w-auto mx-auto max-w-none">
                        </a>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8">
                        {{ $slot }}
                    </div>

                    <!-- Back to Home -->
                    <div class="mt-6 text-center">
                        <a href="/" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-500 transition">
                            ← {{ __('messages.auth_back_home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
