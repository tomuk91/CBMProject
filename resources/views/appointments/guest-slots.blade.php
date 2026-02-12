<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.select_appointment_slot') }} - {{ config('app.name') }}</title>
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white dark:bg-gray-900">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white/95 dark:bg-gray-900/95 backdrop-blur-lg shadow-sm z-50" x-data="{ mobileOpen: false }">
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
                    <a href="/#about" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_about') }}</a>
                    <a href="/#services" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_services') }}</a>
                    <a href="/#contact" class="text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-500 font-medium transition">{{ __('messages.nav_contact') }}</a>
                    
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
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg hover:shadow-xl">
                            {{ __('messages.nav_login') }}
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <button @click="mobileOpen = !mobileOpen" class="md:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none transition">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-1" x-cloak class="md:hidden bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shadow-lg">
            <div class="px-4 py-4 space-y-3">
                <a href="/#about" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium transition">{{ __('messages.nav_about') }}</a>
                <a href="/#services" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium transition">{{ __('messages.nav_services') }}</a>
                <a href="/#contact" class="block px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium transition">{{ __('messages.nav_contact') }}</a>
                
                <div class="flex gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg w-fit">
                    <a href="{{ route('language.switch', 'en') }}" class="px-3 py-1.5 rounded {{ app()->getLocale() == 'en' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition">EN</a>
                    <a href="{{ route('language.switch', 'hu') }}" class="px-3 py-1.5 rounded {{ app()->getLocale() == 'hu' ? 'bg-red-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' }} font-medium text-sm transition">HU</a>
                </div>

                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2.5 bg-gray-800 dark:bg-gray-700 text-white rounded-lg hover:bg-gray-900 dark:hover:bg-gray-600 font-semibold transition text-center">
                        {{ __('messages.nav_dashboard') }}
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold transition shadow-lg text-center">
                        {{ __('messages.nav_login') }}
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 pt-24 pb-8">
        <div class="max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8 mt-8">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">
                    {{ __('messages.select_appointment_slot') }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300">
                    {{ __('messages.guest_slots_description') }}
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg">
                    <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg">
                    <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-lg">
                    <p class="text-blue-800 dark:text-blue-200">{{ session('info') }}</p>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
                <form method="GET" action="{{ route('guest.slots') }}" class="flex flex-col sm:flex-row sm:flex-wrap sm:items-end gap-4">
                    <div class="w-full sm:flex-1 sm:min-w-[200px]">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.date_from') }}
                        </label>
                        <input type="date" id="dateFrom" name="date_from" value="{{ request('date_from', now()->format('Y-m-d')) }}" data-min-today class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    </div>

                    <div class="w-full sm:flex-1 sm:min-w-[200px]">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.date_to') }}
                        </label>
                        <input type="date" id="dateTo" name="date_to" value="{{ request('date_to', now()->addWeeks(2)->format('Y-m-d')) }}" data-min-today class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                    </div>

                    <div class="w-full sm:flex-1 sm:min-w-[200px]">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.filter_time') }}
                        </label>
                        <select name="time_period" class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                            <option value="">{{ __('messages.any_time') }}</option>
                            <option value="morning" {{ request('time_period') == 'morning' ? 'selected' : '' }}>{{ __('messages.morning') }}</option>
                            <option value="afternoon" {{ request('time_period') == 'afternoon' ? 'selected' : '' }}>{{ __('messages.afternoon') }}</option>
                            <option value="evening" {{ request('time_period') == 'evening' ? 'selected' : '' }}>{{ __('messages.evening') }}</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto px-8 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition shadow-sm hover:shadow-md">
                            {{ __('messages.apply_filters') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Calendar View -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                @if($availableSlots->isEmpty())
                    <div class="py-20 text-center">
                        <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.no_slots_available') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('messages.try_different_filters') }}</p>
                    </div>
                @else
                    @php
                        $slotsByDate = $availableSlots->groupBy(function($slot) {
                            return \Carbon\Carbon::parse($slot->start_time)->format('Y-m-d');
                        });
                    @endphp

                    <div class="space-y-4">
                        @foreach($slotsByDate as $date => $slotsOnDate)
                            @php
                                $dateObj = \Carbon\Carbon::parse($date);
                                $isFirstDate = $loop->first;
                            @endphp
                            <div x-data="{ expanded: {{ $isFirstDate ? 'true' : 'false' }} }" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                <!-- Date Header -->
                                <div @click="expanded = !expanded" class="flex items-center justify-between p-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition rounded-lg">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white rounded-lg p-2 mr-3 text-center min-w-[60px]">
                                            <div class="text-xl font-bold">{{ $dateObj->format('d') }}</div>
                                            <div class="text-xs uppercase">{{ $dateObj->translatedFormat('M') }}</div>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ $dateObj->translatedFormat('l') }}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $dateObj->translatedFormat('F j, Y') }} • {{ $slotsOnDate->count() }} {{ $slotsOnDate->count() === 1 ? __('messages.slot') : __('messages.slots') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Time Slots Grid -->
                                <div x-show="expanded" x-collapse class="px-3 pb-3">
                                    <div class="flex overflow-x-auto gap-3 pt-3">
                                    @foreach($slotsOnDate as $slot)
                                        <form action="{{ route('guest.slots.select', $slot->id) }}" method="POST" class="flex-shrink-0">
                                            @csrf
                                            <button type="submit" class="w-[140px] bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-500 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 p-4 flex flex-col items-center justify-center space-y-2 hover:bg-red-50 dark:hover:bg-red-900/20">
                                                <div class="flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                                <div class="flex flex-col items-center justify-center space-y-1">
                                                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">to</span>
                                                    <span class="text-xl font-bold text-gray-900 dark:text-white">
                                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                                    </span>
                                                </div>
                                                <div class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">
                                                    {{ __('messages.available') }}
                                                </div>
                                            </button>
                                        </form>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Pagination --}}
                @if($availableSlots->hasPages())
                    <div class="mt-6">
                        {{ $availableSlots->links() }}
                    </div>
                @endif
            </div>
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <div x-data="{ showScroll: false }" 
         @scroll.window="showScroll = (window.pageYOffset > 300)"
         x-show="showScroll" 
         x-transition
         class="fixed bottom-8 right-8 z-40">
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                class="bg-red-600 hover:bg-red-700 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/hu.js"></script>
    
    <!-- Initialize Flatpickr -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all date inputs with Flatpickr
            const dateInputs = document.querySelectorAll('input[type="date"]');
            const locale = '{{ app()->getLocale() }}';
            
            dateInputs.forEach(input => {
                flatpickr(input, {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'F j, Y',
                    allowInput: true,
                    minDate: input.hasAttribute('data-min-today') ? 'today' : null,
                    theme: 'light',
                    disableMobile: true,
                    locale: locale === 'hu' ? 'hu' : 'default',
                    onReady: function(selectedDates, dateStr, instance) {
                        // Apply custom styling to match red theme
                        instance.calendarContainer.style.setProperty('--flatpickr-primary', '#dc2626');
                        instance.calendarContainer.classList.add('flatpickr-red-theme');
                    }
                });
            });
        });
    </script>

    <style>
        /* Custom Flatpickr Red Theme */
        .flatpickr-red-theme .flatpickr-day.selected,
        .flatpickr-red-theme .flatpickr-day.startRange,
        .flatpickr-red-theme .flatpickr-day.endRange,
        .flatpickr-red-theme .flatpickr-day.selected.inRange,
        .flatpickr-red-theme .flatpickr-day.startRange.inRange,
        .flatpickr-red-theme .flatpickr-day.endRange.inRange,
        .flatpickr-red-theme .flatpickr-day.selected:focus,
        .flatpickr-red-theme .flatpickr-day.startRange:focus,
        .flatpickr-red-theme .flatpickr-day.endRange:focus,
        .flatpickr-red-theme .flatpickr-day.selected:hover,
        .flatpickr-red-theme .flatpickr-day.startRange:hover,
        .flatpickr-red-theme .flatpickr-day.endRange:hover,
        .flatpickr-red-theme .flatpickr-day.endRange.startRange:hover,
        .flatpickr-red-theme .flatpickr-day.selected.startRange:hover,
        .flatpickr-red-theme .flatpickr-day.endRange.startRange:hover {
            background: #dc2626;
            border-color: #dc2626;
        }

        .flatpickr-red-theme .flatpickr-day.today {
            border-color: #dc2626;
        }

        .flatpickr-red-theme .flatpickr-day.today:hover,
        .flatpickr-red-theme .flatpickr-day.today:focus {
            border-color: #dc2626;
            background: #dc2626;
            color: white;
        }

        .flatpickr-red-theme .flatpickr-months .flatpickr-prev-month:hover svg,
        .flatpickr-red-theme .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #dc2626;
        }
    </style>

</body>
</html>
