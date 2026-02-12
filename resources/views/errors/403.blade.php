<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — {{ config('app.name', 'CBM Auto') }}</title>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <a href="/" class="mb-8">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto">
        </a>

        <div class="text-center max-w-md">
            <p class="text-7xl font-bold text-red-600">403</p>
            <h1 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.error_403_title') }}</h1>
            <p class="mt-3 text-gray-600 dark:text-gray-400">{{ __('messages.error_403_description') }}</p>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    ← {{ __('messages.go_back') }}
                </a>
                <a href="/" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-medium rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                    {{ __('messages.go_home') }}
                </a>
            </div>
        </div>

        <p class="mt-12 text-xs text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </div>
</body>
</html>
