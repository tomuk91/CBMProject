<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="{{ __('messages.about_meta_description') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#dc2626">
    <title>{{ __('messages.about_page_title') }} - {{ config('app.name') }}</title>
    <x-seo-meta 
        :title="__('messages.about_page_title')" 
        :description="__('messages.about_meta_description')" 
        :canonical="route('about')" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stagger-item:nth-child(1) { animation-delay: 0.1s; }
        .stagger-item:nth-child(2) { animation-delay: 0.2s; }
        .stagger-item:nth-child(3) { animation-delay: 0.3s; }
        .stagger-item:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body class="bg-white dark:bg-gray-900 antialiased">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-md shadow-lg z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('images/logo.png') }}" alt="CBM Auto" class="h-16 w-auto max-w-none">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/#about" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_about') }}</a>
                    <a href="/#services" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_services') }}</a>
                    <a href="{{ route('contact.show') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_contact') }}</a>
                    
                    <!-- Language Toggle -->
                    <div class="flex gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg">
                        <a href="{{ route('language.switch', 'en') }}" 
                           class="px-3 py-1.5 rounded {{ app()->getLocale() === 'en' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium transition">
                            EN
                        </a>
                        <a href="{{ route('language.switch', 'hu') }}" 
                           class="px-3 py-1.5 rounded {{ app()->getLocale() === 'hu' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium transition">
                            HU
                        </a>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg hover:shadow-xl">
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
                        aria-label="{{ __('messages.toggle_mobile_menu') }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
            <div class="px-4 py-4 space-y-3">
                <a href="/#about" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_about') }}</a>
                <a href="/#services" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_services') }}</a>
                <a href="{{ route('contact.show') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_contact') }}</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-red-600 text-white text-center rounded-lg font-semibold">{{ __('messages.nav_dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_login') }}</a>
                    <a href="{{ route('guest.slots') }}" class="block px-4 py-2 bg-red-600 text-white text-center rounded-lg font-semibold">{{ __('messages.hero_cta_primary') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        <!-- Hero Section -->
        <section class="relative bg-gradient-to-br from-red-600 to-red-700 text-white py-20 overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="text-center">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 scroll-animate">
                        {{ __('messages.about_hero_title') }}
                    </h1>
                    <p class="text-xl md:text-2xl text-red-100 max-w-3xl mx-auto scroll-animate">
                        {{ __('messages.about_hero_subtitle') }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Story Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Image -->
                    <div class="relative scroll-animate">
                        <img src="{{ asset('images/hero-mechanic.jpg') }}" 
                             alt="{{ __('messages.about_story_image_alt') }}" 
                             class="rounded-2xl shadow-2xl w-full h-[500px] object-cover"
                             loading="lazy">
                        <div class="absolute -bottom-6 -right-6 bg-red-600 text-white p-8 rounded-2xl shadow-xl">
                            <div class="text-5xl font-bold">15+</div>
                            <div class="text-lg">{{ __('messages.about_years_experience') }}</div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="scroll-animate">
                        <p class="text-red-600 font-bold text-lg mb-4">{{ __('messages.about_badge') }}</p>
                        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                            {{ __('messages.about_story_title') }}
                        </h2>
                        <div class="space-y-4 text-gray-600 dark:text-gray-400 text-lg leading-relaxed">
                            <p>{{ __('messages.about_story_p1') }}</p>
                            <p>{{ __('messages.about_story_p2') }}</p>
                            <p>{{ __('messages.about_story_p3') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Values Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50 dark:bg-gray-800">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 scroll-animate">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('messages.about_values_title') }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        {{ __('messages.about_values_subtitle') }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Value 1: Quality -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                        <div class="bg-red-100 dark:bg-red-900/20 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.about_value_quality') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('messages.about_value_quality_desc') }}</p>
                    </div>

                    <!-- Value 2: Trust -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                        <div class="bg-red-100 dark:bg-red-900/20 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.about_value_trust') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('messages.about_value_trust_desc') }}</p>
                    </div>

                    <!-- Value 3: Expertise -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                        <div class="bg-red-100 dark:bg-red-900/20 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.about_value_expertise') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('messages.about_value_expertise_desc') }}</p>
                    </div>

                    <!-- Value 4: Customer Focus -->
                    <div class="bg-white dark:bg-gray-900 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                        <div class="bg-red-100 dark:bg-red-900/20 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.about_value_customer') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('messages.about_value_customer_desc') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Location Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-900">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16 scroll-animate">
                    <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ __('messages.about_location_title') }}
                    </h2>
                    <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                        {{ __('messages.about_location_subtitle') }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Map -->
                    <div class="rounded-2xl overflow-hidden shadow-2xl scroll-animate h-[400px] md:h-[500px]">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2695.5455857879844!2d19.040235976854754!3d47.497912971177944!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741dc14e8d1e5ad%3A0x24ae0b303e6f6f69!2sBudapest%2C%20Hungary!5e0!3m2!1sen!2sus!4v1702000000000!5m2!1sen!2sus" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            title="{{ __('messages.about_map_title') }}">
                        </iframe>
                    </div>

                    <!-- Contact Info -->
                    <div class="scroll-animate">
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-8 h-full">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">{{ __('messages.about_contact_info') }}</h3>
                            
                            <div class="space-y-6">
                                <!-- Address -->
                                <div class="flex items-start">
                                    <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.about_address_label') }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            1234 Example Street<br>
                                            Budapest, 1051<br>
                                            Hungary
                                        </p>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="flex items-start">
                                    <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.about_phone_label') }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400">+36 1 234 5678</p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="flex items-start">
                                    <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.about_email_label') }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400">info@cbmauto.com</p>
                                    </div>
                                </div>

                                <!-- Hours -->
                                <div class="flex items-start">
                                    <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-lg mr-4">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.about_hours_label') }}</h4>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            {{ __('messages.about_hours_weekday') }}<br>
                                            {{ __('messages.about_hours_weekend') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <div class="mt-8">
                                <a href="{{ route('guest.slots') }}" class="inline-flex items-center px-8 py-4 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:scale-105 w-full justify-center">
                                    {{ __('messages.hero_cta_primary') }}
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-red-600 to-red-700">
            <div class="max-w-4xl mx-auto text-center scroll-animate">
                <h2 class="text-4xl font-bold text-white mb-6">
                    {{ __('messages.about_cta_title') }}
                </h2>
                <p class="text-xl text-red-100 mb-8">
                    {{ __('messages.about_cta_subtitle') }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('guest.slots') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-red-600 rounded-xl hover:bg-gray-100 font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        {{ __('messages.hero_cta_primary') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="{{ route('contact.show') }}" class="inline-flex items-center justify-center px-8 py-4 bg-red-700 text-white rounded-xl hover:bg-red-800 font-semibold text-lg transition shadow-lg hover:shadow-xl border-2 border-white">
                        {{ __('messages.nav_contact') }}
                    </a>
                </div>
            </div>
        </section>
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
                        <li><a href="/#about" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_about') }}</a></li>
                        <li><a href="/#services" class="text-gray-400 hover:text-red-500 transition">{{ __('messages.nav_services') }}</a></li>
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

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
