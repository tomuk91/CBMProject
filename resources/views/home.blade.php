<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.hero_title') }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg shadow-sm z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="CBM Auto" class="h-20 w-auto max-w-none">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_about') }}</a>
                    <a href="#services" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_services') }}</a>
                    <a href="#contact" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_contact') }}</a>
                    
                    <!-- Language Toggle -->
                    <div class="flex gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                        <a href="{{ route('language.switch', 'en') }}" class="px-3 py-1.5 rounded {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition">EN</a>
                        <a href="{{ route('language.switch', 'hu') }}" class="px-3 py-1.5 rounded {{ app()->getLocale() == 'hu' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition">HU</a>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600 font-semibold transition">
                            {{ __('messages.nav_dashboard') }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">
                            {{ __('messages.nav_login') }}
                        </a>
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg hover:shadow-xl">
                            {{ __('messages.hero_cta_primary') }}
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700 dark:text-gray-300" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <div class="px-4 py-4 space-y-3">
                <a href="#about" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_about') }}</a>
                <a href="#services" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_services') }}</a>
                <a href="#contact" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_contact') }}</a>
                <div class="flex gap-2 px-4">
                    <a href="{{ route('language.switch', 'en') }}" class="flex-1 text-center px-3 py-2 rounded {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} font-medium">EN</a>
                    <a href="{{ route('language.switch', 'hu') }}" class="flex-1 text-center px-3 py-2 rounded {{ app()->getLocale() == 'hu' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} font-medium">HU</a>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-gray-800 text-white text-center rounded-lg font-semibold">{{ __('messages.nav_dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_login') }}</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 bg-red-600 text-white text-center rounded-lg font-semibold">{{ __('messages.hero_cta_primary') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative h-[600px] mt-20 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero-mechanic.jpg') }}" alt="Professional car service" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/30"></div>
        </div>
        
        <!-- Hero Content -->
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
            <div class="max-w-2xl text-white">
                <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    {{ __('messages.hero_main_title') }}
                </h1>
                <p class="text-xl lg:text-2xl text-gray-200 mb-8 leading-relaxed">
                    {{ __('messages.hero_main_description') }}
                </p>
                <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-8 py-4 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:scale-105">
                    {{ __('messages.hero_cta_primary') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Image -->
                <div class="relative">
                    <img src="{{ asset('images/hero-mechanic.jpg') }}" alt="Our story" class="rounded-2xl shadow-2xl w-full h-[500px] object-cover">
                </div>
                
                <!-- Content -->
                <div>
                    <h2 class="text-red-600 font-bold text-lg mb-4">{{ __('messages.about_badge') }}</h2>
                    <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ __('messages.about_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed mb-8">
                        {{ __('messages.about_description') }}
                    </p>
                    <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg">
                        {{ __('messages.about_cta') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Cars We Service Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-red-600 font-bold text-lg mb-2">{{ __('messages.brands_badge') }}</h3>
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('messages.brands_title') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg max-w-3xl mx-auto">
                    {{ __('messages.brands_description') }}
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-12">
                <!-- BMW -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-md flex items-center justify-center hover:shadow-xl transition group">
                    <span class="text-3xl font-bold text-gray-800 dark:text-gray-300 group-hover:text-red-600 transition">BMW</span>
                </div>
                
                <!-- Mercedes -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-md flex items-center justify-center hover:shadow-xl transition group">
                    <span class="text-3xl font-bold text-gray-800 dark:text-gray-300 group-hover:text-red-600 transition">Mercedes</span>
                </div>
                
                <!-- Audi -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-md flex items-center justify-center hover:shadow-xl transition group">
                    <span class="text-3xl font-bold text-gray-800 dark:text-gray-300 group-hover:text-red-600 transition">Audi</span>
                </div>
                
                <!-- Ford -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-md flex items-center justify-center hover:shadow-xl transition group">
                    <span class="text-3xl font-bold text-gray-800 dark:text-gray-300 group-hover:text-red-600 transition">Ford</span>
                </div>
                
                <!-- Toyota -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-md flex items-center justify-center hover:shadow-xl transition group">
                    <span class="text-3xl font-bold text-gray-800 dark:text-gray-300 group-hover:text-red-600 transition">Toyota</span>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg">
                    {{ __('messages.brands_cta') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('messages.services_title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('messages.services_subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-6 group-hover:bg-red-600 transition">
                        <svg class="w-8 h-8 text-red-600 group-hover:text-white dark:text-red-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('messages.service_oil_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.service_oil_desc') }}
                    </p>
                </div>

                <!-- Service 2 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-6 group-hover:bg-red-600 transition">
                        <svg class="w-8 h-8 text-red-600 group-hover:text-white dark:text-red-400 transition" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('messages.service_brake_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.service_brake_desc') }}
                    </p>
                </div>

                <!-- Service 3 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-6 group-hover:bg-red-600 transition">
                        <svg class="w-8 h-8 text-red-600 group-hover:text-white dark:text-red-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('messages.service_engine_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.service_engine_desc') }}
                    </p>
                </div>

                <!-- Service 4 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-6 group-hover:bg-red-600 transition">
                        <svg class="w-8 h-8 text-red-600 group-hover:text-white dark:text-red-400 transition" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                            <circle cx="12" cy="12" r="4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('messages.service_tire_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.service_tire_desc') }}
                    </p>
                </div>

                <!-- Service 5 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-6 group-hover:bg-red-600 transition">
                        <svg class="w-8 h-8 text-red-600 group-hover:text-white dark:text-red-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('messages.service_ac_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.service_ac_desc') }}
                    </p>
                </div>

                <!-- Service 6 -->
                <div class="bg-gray-50 dark:bg-gray-800 p-8 rounded-xl hover:shadow-xl transition group">
                    <div class="w-14 h-14 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mb-6 group-hover:bg-red-600 transition">
                        <svg class="w-8 h-8 text-red-600 group-hover:text-white dark:text-red-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('messages.service_transmission_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('messages.service_transmission_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact/Footer Section -->
    <footer id="contact" class="bg-gray-900 dark:bg-black text-white py-16 px-4 sm:px-6 lg:px-8">
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
                        <li><a href="#about" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_about') }}</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_services') }}</a></li>
                        <li><a href="{{ route('appointments.index') }}" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_book') }}</a></li>
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

            <div class="border-t border-gray-800 pt-8 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} CBM Auto. {{ __('messages.footer_copyright') }}</p>
            </div>
        </div>
    </footer>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const button = event.target.closest('button');
            
            if (!menu.contains(event.target) && !button && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    document.getElementById('mobileMenu').classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>
