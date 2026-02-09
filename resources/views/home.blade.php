<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="{{ __('messages.meta_description') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#dc2626">
    <title>{{ __('messages.hero_title') }} - {{ config('app.name') }}</title>
    <x-seo-meta 
        :title="__('messages.hero_title')" 
        :description="__('messages.meta_description')" 
        :canonical="route('home')" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Skip Link for Accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: #dc2626;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 0 0 4px 0;
            z-index: 100;
        }
        .skip-link:focus {
            top: 0;
        }
        
        /* Enhanced Focus Indicators */
        *:focus-visible {
            outline: 3px solid #dc2626;
            outline-offset: 2px;
        }
        
        /* Mobile Optimizations */
        @media (max-width: 768px) {
            /* Prevent text size adjustment */
            html {
                -webkit-text-size-adjust: 100%;
                text-size-adjust: 100%;
            }
            
            /* Better hero sizing on mobile */
            .hero-section {
                min-height: 400px;
                height: auto;
            }
            
            /* Improve tap targets */
            button, a {
                min-height: 44px;
                min-width: 44px;
            }
            
            /* Optimize mobile menu */
            #mobileMenu {
                max-height: calc(100vh - 80px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
        
        /* Active states for touch devices */
        @media (hover: none) {
            button:active, a:active {
                transform: scale(0.95);
                transition: transform 0.1s;
            }
        }
        
        /* Scroll Animation Styles */
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-animate.animate-in {
            opacity: 1;
            transform: translateY(0);
        }

        .scroll-animate-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-animate-left.animate-in {
            opacity: 1;
            transform: translateX(0);
        }

        .scroll-animate-right {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-animate-right.animate-in {
            opacity: 1;
            transform: translateX(0);
        }

        .scroll-animate-scale {
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }

        .scroll-animate-scale.animate-in {
            opacity: 1;
            transform: scale(1);
        }

        /* Stagger animation delays for children */
        .stagger-item:nth-child(1) { transition-delay: 0.1s; }
        .stagger-item:nth-child(2) { transition-delay: 0.2s; }
        .stagger-item:nth-child(3) { transition-delay: 0.3s; }
        .stagger-item:nth-child(4) { transition-delay: 0.4s; }
        .stagger-item:nth-child(5) { transition-delay: 0.5s; }
        .stagger-item:nth-child(6) { transition-delay: 0.6s; }
    </style>
</head>
<body class="bg-white dark:bg-gray-900">
    <!-- Skip Link for Keyboard Navigation -->
    <a href="#main-content" class="skip-link">{{ __('messages.skip_to_content') }}</a>
    
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg shadow-sm z-50" role="navigation" aria-label="{{ __('messages.main_navigation') }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center" aria-label="{{ __('messages.go_to_home') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="CBM Auto {{ __('messages.logo_alt') }}" class="h-20 w-auto max-w-none">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#about" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_about') }}</a>
                    <a href="#services" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_services') }}</a>
                    <a href="{{ route('contact.show') }}" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_contact') }}</a>
                    
                    <!-- Language Toggle -->
                    <div class="flex gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg" role="group" aria-label="{{ __('messages.language_selector') }}">
                        <a href="{{ route('language.switch', 'en') }}" 
                           class="px-3 py-1.5 rounded {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition"
                           aria-label="{{ __('messages.switch_to_english') }}"
                           {{ app()->getLocale() == 'en' ? 'aria-current="true"' : '' }}>EN</a>
                        <a href="{{ route('language.switch', 'hu') }}" 
                           class="px-3 py-1.5 rounded {{ app()->getLocale() == 'hu' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition"
                           aria-label="{{ __('messages.switch_to_hungarian') }}"
                           {{ app()->getLocale() == 'hu' ? 'aria-current="true"' : '' }}>HU</a>
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
                <a href="#about" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_about') }}</a>
                <a href="#services" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_services') }}</a>
                <a href="{{ route('contact.show') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_contact') }}</a>
                <div class="flex gap-2 px-4">
                    <a href="{{ route('language.switch', 'en') }}" class="flex-1 text-center px-3 py-2 rounded {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} font-medium">EN</a>
                    <a href="{{ route('language.switch', 'hu') }}" class="flex-1 text-center px-3 py-2 rounded {{ app()->getLocale() == 'hu' ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300' }} font-medium">HU</a>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 bg-gray-800 text-white text-center rounded-lg font-semibold">{{ __('messages.nav_dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">{{ __('messages.nav_login') }}</a>
                    <a href="{{ route('contact.show') }}" class="block px-4 py-2 bg-red-600 text-white text-center rounded-lg font-semibold">{{ __('messages.hero_cta_primary') }}</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main id="main-content" role="main">
        <!-- Hero Section -->
        <section class="hero-section relative h-[400px] sm:h-[500px] md:h-[600px] mt-20 overflow-hidden" aria-label="{{ __('messages.hero_section') }}">
            <!-- Background Image -->
            <div class="absolute inset-0" aria-hidden="true">
                <img src="{{ asset('images/hero-mechanic.jpg') }}" alt="" class="w-full h-full object-cover" loading="eager">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/60 to-black/30"></div>
            </div>
        
        <!-- Hero Content -->
        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center">
            <div class="max-w-2xl text-white py-8">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-4 sm:mb-6">
                    {{ __('messages.hero_main_title') }}
                </h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-gray-200 mb-6 sm:mb-8 leading-relaxed">
                    {{ __('messages.hero_main_description') }}
                </p>
                <a href="{{ Auth::check() ? route('appointments.index') : route('guest.slots') }}" 
                   class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold text-base sm:text-lg transition shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95"
                   aria-label="{{ __('messages.book_appointment_now') }}">
                    {{ __('messages.hero_cta_primary') }}
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-4 sm:px-6 lg:px-8 bg-white dark:bg-gray-900" aria-labelledby="about-heading">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Image -->
                <div class="relative scroll-animate-left">
                    <img src="{{ asset('images/hero-mechanic.jpg') }}" 
                         alt="{{ __('messages.about_image_alt') }}" 
                         class="rounded-2xl shadow-2xl w-full h-[500px] object-cover"
                         loading="lazy">
                </div>
                
                <!-- Content -->
                <div class="scroll-animate-right">
                    <p class="text-red-600 font-bold text-lg mb-4" aria-label="{{ __('messages.section_label') }}">{{ __('messages.about_badge') }}</p>
                    <h2 id="about-heading" class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                    <h3 class="text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        {{ __('messages.about_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-lg leading-relaxed mb-8">
                        {{ __('messages.about_description') }}
                    </p>
                    <a href="{{ route('about') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg">
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
            <div class="text-center mb-16 scroll-animate">
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
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate-scale stagger-item">
                    <div class="aspect-square relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=500&auto=format&fit=crop" 
                             alt="BMW" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold">BMW</h3>
                        <p class="text-sm text-gray-200 mt-1">German Engineering</p>
                    </div>
                </div>
                
                <!-- Mercedes -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate-scale stagger-item">
                    <div class="aspect-square relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?q=80&w=500&auto=format&fit=crop" 
                             alt="Mercedes" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold">Mercedes</h3>
                        <p class="text-sm text-gray-200 mt-1">Luxury Performance</p>
                    </div>
                </div>
                
                <!-- Audi -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate-scale stagger-item">
                    <div class="aspect-square relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1610768764270-790fbec18178?q=80&w=500&auto=format&fit=crop" 
                             alt="Audi" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold">Audi</h3>
                        <p class="text-sm text-gray-200 mt-1">Innovation & Style</p>
                    </div>
                </div>
                
                <!-- Ford -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate-scale stagger-item">
                    <div class="aspect-square relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551830820-330a71b99659?q=80&w=500&auto=format&fit=crop" 
                             alt="Ford" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold">Ford</h3>
                        <p class="text-sm text-gray-200 mt-1">Built Tough</p>
                    </div>
                </div>
                
                <!-- Toyota -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate-scale stagger-item">
                    <div class="aspect-square relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1629897048514-3dd7414fe72a?q=80&w=500&auto=format&fit=crop" 
                             alt="Toyota" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-2xl font-bold">Toyota</h3>
                        <p class="text-sm text-gray-200 mt-1">Reliability First</p>
                    </div>
                </div>
            </div>

            <!-- Plus More Badge -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-900 px-8 py-4 rounded-full shadow-lg">
                    <span class="text-gray-600 dark:text-gray-400 font-medium">And many more brands...</span>
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-white text-xs font-bold">VW</div>
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">H</div>
                        <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-white text-xs font-bold">+20</div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('contact.show') }}" class="inline-flex items-center px-8 py-4 bg-red-600 text-white rounded-xl hover:bg-red-700 font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:scale-105">
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
            <div class="text-center mb-16 scroll-animate">
                <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ __('messages.services_title') }}
                </h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('messages.services_subtitle') }}
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Service 1: Oil Change -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?q=80&w=800&auto=format&fit=crop" 
                             alt="Oil Change Service" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-red-600 text-white p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('messages.service_oil_title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('messages.service_oil_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Service 2: Brake Service -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1625047509168-a7026f36de04?q=80&w=800&auto=format&fit=crop" 
                             alt="Brake Service" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-red-600 text-white p-3 rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('messages.service_brake_title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('messages.service_brake_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Service 3: Engine Diagnostics -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1487754180451-c456f719a1fc?q=80&w=800&auto=format&fit=crop" 
                             alt="Engine Diagnostics" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-red-600 text-white p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('messages.service_engine_title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('messages.service_engine_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Service 4: Tire Service -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1607860108855-64acf2078ed9?q=80&w=800&auto=format&fit=crop" 
                             alt="Tire Service" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-red-600 text-white p-3 rounded-full">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2" fill="none"/>
                                <circle cx="12" cy="12" r="4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('messages.service_tire_title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('messages.service_tire_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Service 5: AC Service -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1621905251189-08b45d6a269e?q=80&w=800&auto=format&fit=crop" 
                             alt="AC Service" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-red-600 text-white p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('messages.service_ac_title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('messages.service_ac_desc') }}
                        </p>
                    </div>
                </div>

                <!-- Service 6: Transmission -->
                <div class="group relative overflow-hidden bg-white dark:bg-gray-900 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 scroll-animate stagger-item">
                    <div class="h-48 overflow-hidden relative">
                        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=800&auto=format&fit=crop" 
                             alt="Transmission Service" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-red-600 text-white p-3 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            {{ __('messages.service_transmission_title') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('messages.service_transmission_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Car Rental Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Image Side -->
                <div class="relative order-2 lg:order-1 scroll-animate-left">
                    <div class="absolute -top-6 -left-6 w-72 h-72 bg-red-200 dark:bg-red-900/30 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-70 animate-blob"></div>
                    <div class="absolute -bottom-6 -right-6 w-72 h-72 bg-blue-200 dark:bg-blue-900/30 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                    <div class="relative">
                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1000&auto=format&fit=crop" 
                             alt="Luxury Car Rental" 
                             class="rounded-2xl shadow-2xl w-full h-auto object-cover">
                        <div class="absolute top-4 right-4 bg-red-600 text-white px-6 py-3 rounded-full font-bold text-sm shadow-lg transform rotate-3 hover:rotate-0 transition">
                            {{ __('messages.rental_coming_soon') }}
                        </div>
                    </div>
                </div>

                <!-- Content Side -->
                <div class="order-1 lg:order-2 scroll-animate-right">
                    <div class="inline-block mb-4">
                        <span class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 px-4 py-2 rounded-full text-sm font-semibold">
                            {{ __('messages.rental_badge') }}
                        </span>
                    </div>
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        {{ __('messages.rental_title') }}
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                        {{ __('messages.rental_description') }}
                    </p>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('messages.rental_feature_1_title') }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('messages.rental_feature_1_desc') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('messages.rental_feature_2_title') }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('messages.rental_feature_2_desc') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('messages.rental_feature_3_title') }}</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('messages.rental_feature_3_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('contact.show') }}" class="inline-flex items-center px-8 py-4 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:scale-105">
                        {{ __('messages.rental_cta') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
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
        // Mobile menu toggle with accessibility support
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const button = document.getElementById('mobile-menu-button');
            const isExpanded = button.getAttribute('aria-expanded') === 'true';
            
            menu.classList.toggle('hidden');
            button.setAttribute('aria-expanded', !isExpanded);
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobileMenu');
            const button = event.target.closest('button');
            const menuButton = document.getElementById('mobile-menu-button');
            
            if (!menu.contains(event.target) && !button && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                if (menuButton) {
                    menuButton.setAttribute('aria-expanded', 'false');
                }
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

        // Scroll Animation Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    // Optionally unobserve after animation
                    // observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe all elements with scroll animation classes
        document.addEventListener('DOMContentLoaded', () => {
            const animatedElements = document.querySelectorAll(
                '.scroll-animate, .scroll-animate-left, .scroll-animate-right, .scroll-animate-scale'
            );
            animatedElements.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
