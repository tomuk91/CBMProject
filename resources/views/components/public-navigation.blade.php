@props(['currentPage' => ''])

@php
    $isHome = $currentPage === 'home';
    $aboutLink = $isHome ? '#about' : route('home') . '#about';
    $servicesLink = $isHome ? '#services' : route('home') . '#services';
@endphp

<nav class="fixed top-0 left-0 right-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg shadow-sm z-50" role="navigation" aria-label="{{ __('messages.main_navigation') }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center" aria-label="{{ __('messages.go_to_home') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="CBM Auto" class="h-16 w-auto max-w-none">
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ $aboutLink }}" class="{{ $currentPage === 'about' ? 'text-red-600 dark:text-red-500 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500' }} font-medium transition">{{ __('messages.nav_about') }}</a>
                <a href="{{ $servicesLink }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_services') }}</a>
                <a href="{{ route('contact.show') }}" class="{{ $currentPage === 'contact' ? 'text-red-600 dark:text-red-500 font-semibold' : 'text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500' }} font-medium transition">{{ __('messages.nav_contact') }}</a>
                
                <!-- Language Toggle -->
                <div class="flex gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg" role="group" aria-label="{{ __('messages.language_selector') }}">
                    <a href="{{ route('language.switch', 'en') }}" 
                       class="px-3 py-1.5 rounded {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition"
                       aria-label="{{ __('messages.switch_to_english') }}"
                       {!! app()->getLocale() == 'en' ? 'aria-current="true"' : '' !!}>EN</a>
                    <a href="{{ route('language.switch', 'hu') }}" 
                       class="px-3 py-1.5 rounded {{ app()->getLocale() == 'hu' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition"
                       aria-label="{{ __('messages.switch_to_hungarian') }}"
                       {!! app()->getLocale() == 'hu' ? 'aria-current="true"' : '' !!}>HU</a>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600 font-semibold transition">
                        {{ __('messages.nav_dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">
                        {{ __('messages.nav_login') }}
                    </a>
                    <a href="{{ route('guest.slots') }}" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg hover:shadow-xl">
                        {{ __('messages.hero_cta_primary') }}
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-gray-700 dark:text-gray-300" 
                    onclick="toggleMobileMenu()" 
                    aria-label="{{ __('messages.toggle_mobile_menu') }}"
                    aria-expanded="false"
                    aria-controls="mobileMenu"
                    id="mobile-menu-button">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900" role="navigation" aria-label="{{ __('messages.mobile_navigation') }}">
        <div class="px-4 py-4 space-y-3">
            <a href="{{ $aboutLink }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_about') }}</a>
            <a href="{{ $servicesLink }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_services') }}</a>
            <a href="{{ route('contact.show') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_contact') }}</a>
            <div class="flex gap-2 px-4">
                <a href="{{ route('language.switch', 'en') }}" class="flex-1 text-center px-3 py-2 rounded {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} font-medium">EN</a>
                <a href="{{ route('language.switch', 'hu') }}" class="flex-1 text-center px-3 py-2 rounded {{ app()->getLocale() == 'hu' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} font-medium">HU</a>
            </div>
            @auth
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-gray-800 text-white text-center rounded-lg font-semibold">{{ __('messages.nav_dashboard') }}</a>
            @else
                <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_login') }}</a>
                <a href="{{ route('guest.slots') }}" class="block px-4 py-2 bg-red-600 text-white text-center rounded-lg font-semibold">{{ __('messages.hero_cta_primary') }}</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        const button = document.getElementById('mobile-menu-button');
        menu.classList.toggle('hidden');
        if (button) {
            button.setAttribute('aria-expanded', !menu.classList.contains('hidden'));
        }
    }
</script>
