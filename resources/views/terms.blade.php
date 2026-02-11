<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ __('messages.terms_of_service') }} - {{ config('app.name') }}</title>
    <x-seo-meta 
        :title="__('messages.terms_of_service')" 
        :description="__('messages.terms_description')" 
        :canonical="route('terms')" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 antialiased">
    <x-public-navigation currentPage="terms" />

    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-red-600 to-red-700 text-white py-20 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="javascript:history.back()" class="inline-flex items-center text-red-100 hover:text-white mb-6 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('messages.back') }}
            </a>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ __('messages.terms_of_service') }}</h1>
            <p class="text-xl text-red-100">{{ __('messages.terms_last_updated') }}: February 9, 2026</p>
        </div>
    </div>

    <!-- Main Content -->
    <main class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-8">{{ __('messages.terms_of_service') }}</h1>
            
            <div class="prose dark:prose-invert max-w-none space-y-8">
                <section>
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-8">
                        {{ __('messages.terms_last_updated') }}: {{ now()->format('F j, Y') }}
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_acceptance') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('messages.terms_acceptance_text') }}
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_services') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('messages.terms_services_text') }}</p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_appointments') }}</h2>
                    <ul class="list-disc pl-6 text-gray-600 dark:text-gray-400 space-y-2">
                        <li>{{ __('messages.terms_appointments_booking') }}</li>
                        <li>{{ __('messages.terms_appointments_cancellation') }}</li>
                        <li>{{ __('messages.terms_appointments_noshow') }}</li>
                        <li>{{ __('messages.terms_appointments_changes') }}</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_payment') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('messages.terms_payment_text') }}
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_warranty') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('messages.terms_warranty_text') }}
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_liability') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('messages.terms_liability_text') }}
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_user_conduct') }}</h2>
                    <ul class="list-disc pl-6 text-gray-600 dark:text-gray-400 space-y-2">
                        <li>{{ __('messages.terms_conduct_accurate') }}</li>
                        <li>{{ __('messages.terms_conduct_respect') }}</li>
                        <li>{{ __('messages.terms_conduct_property') }}</li>
                        <li>{{ __('messages.terms_conduct_laws') }}</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_termination') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('messages.terms_termination_text') }}
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_governing_law') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('messages.terms_governing_law_text') }}
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.terms_contact') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ __('messages.terms_contact_text') }}
                    </p>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-6 mt-4">
                        <p class="text-gray-900 dark:text-white font-semibold mb-2">{{ config('app.name') }}</p>
                        <p class="text-gray-600 dark:text-gray-400">Email: info@cbmauto.com</p>
                        <p class="text-gray-600 dark:text-gray-400">Phone: +36 1 234 5678</p>
                        <p class="text-gray-600 dark:text-gray-400">Address: 1234 Example Street, Budapest, 1051, Hungary</p>
                    </div>
                </section>

                <section class="pt-8 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('messages.terms_changes_text') }}
                    </p>
                </section>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-black text-white py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <!-- About -->
                <div>
                    <img src="{{ asset('images/logo-white.png') }}" alt="CBM Auto" class="h-16 w-auto mb-4">
                    <p class="text-gray-400 leading-relaxed">
                        {{ __('messages.footer_about_text') }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4">{{ __('messages.footer_quick_links') }}</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}#about" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_about') }}</a></li>
                        <li><a href="{{ route('home') }}#services" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_services') }}</a></li>
                        <li><a href="{{ route('contact.show') }}" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_contact') }}</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_dashboard') }}</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_login') }}</a></li>
                        @endauth
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4">{{ __('messages.footer_contact') }}</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li>Email: info@cbmauto.com</li>
                        <li>Phone: +36 1 234 5678</li>
                        <li>Address: Budapest, Hungary</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm">
                    <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} CBM Auto. {{ __('messages.footer_copyright') }}</p>
                    <div class="flex gap-6">
                        <a href="{{ route('privacy') }}" class="hover:text-red-500 transition">{{ __('messages.privacy_policy') }}</a>
                        <a href="{{ route('terms') }}" class="hover:text-red-500 transition">{{ __('messages.terms_of_service') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <x-cookie-consent />
</body>
</html>
