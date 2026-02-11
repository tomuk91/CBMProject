<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Dark Mode Script (must be in head to prevent flash) -->
        <script>
            // Check for saved theme preference or default to light mode
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        
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
            @media (max-width: 640px) {
                /* Prevent text size adjustment on orientation change */
                html {
                    -webkit-text-size-adjust: 100%;
                    text-size-adjust: 100%;
                }
                
                /* Improve tap targets */
                button, a, input, select, textarea {
                    min-height: 44px;
                }
                
                /* Better spacing for mobile */
                body {
                    font-size: 16px; /* Prevents iOS zoom on input focus */
                }
            }
            
            /* Active state for mobile */
            @media (hover: none) {
                button:active, a:active {
                    opacity: 0.7;
                    transform: scale(0.98);
                }
            }
        </style>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Skip Link for Keyboard Navigation -->
        <a href="#main-content" class="skip-link">{{ __('messages.skip_to_content') }}</a>

        <!-- Toast Notifications -->
        <x-toast-notification />
        
        <div class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main id="main-content" role="main" aria-label="{{ __('messages.main_content') }}" class="flex-1">
                @if(Auth::check() && Auth::user()->is_admin && request()->routeIs('admin.*') && !request()->routeIs('admin.appointments.print-schedule'))
                    <div class="flex bg-gray-50 dark:bg-gray-900 min-h-full">
                        @include('admin.partials.sidebar')
                        <div class="flex-1 min-w-0">
                            {{ $slot }}
                        </div>
                    </div>
                @else
                    {{ $slot }}
                @endif
            </main>

            <!-- Footer -->
            <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.all_rights_reserved') }}</p>
                        <div class="flex gap-4">
                            <a href="{{ route('privacy') }}" class="hover:text-red-600 dark:hover:text-red-400 transition">{{ __('messages.privacy_policy') }}</a>
                            <a href="{{ route('terms') }}" class="hover:text-red-600 dark:hover:text-red-400 transition">{{ __('messages.terms_of_service') }}</a>
                            <a href="{{ route('contact.show') }}" class="hover:text-red-600 dark:hover:text-red-400 transition">{{ __('messages.footer_contact') }}</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/hu.js"></script>
        
        <!-- Dark Mode Toggle Script -->
        <script>
            // Desktop theme toggle
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Mobile theme toggle
            const themeToggleMobileBtn = document.getElementById('theme-toggle-mobile');
            const themeToggleMobileDarkIcon = document.getElementById('theme-toggle-mobile-dark-icon');
            const themeToggleMobileLightIcon = document.getElementById('theme-toggle-mobile-light-icon');

            // Function to update all toggle buttons
            function updateThemeIcons(isDark) {
                if (isDark) {
                    themeToggleLightIcon?.classList.remove('hidden');
                    themeToggleDarkIcon?.classList.add('hidden');
                    themeToggleMobileLightIcon?.classList.remove('hidden');
                    themeToggleMobileDarkIcon?.classList.add('hidden');
                    if (themeToggleBtn) themeToggleBtn.setAttribute('aria-pressed', 'true');
                    if (themeToggleMobileBtn) themeToggleMobileBtn.setAttribute('aria-pressed', 'true');
                } else {
                    themeToggleDarkIcon?.classList.remove('hidden');
                    themeToggleLightIcon?.classList.add('hidden');
                    themeToggleMobileDarkIcon?.classList.remove('hidden');
                    themeToggleMobileLightIcon?.classList.add('hidden');
                    if (themeToggleBtn) themeToggleBtn.setAttribute('aria-pressed', 'false');
                    if (themeToggleMobileBtn) themeToggleMobileBtn.setAttribute('aria-pressed', 'false');
                }
            }

            // Function to toggle theme
            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    updateThemeIcons(false);
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    updateThemeIcons(true);
                }
            }

            // Show the correct icon on page load
            const isDarkMode = localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
            updateThemeIcons(isDarkMode);

            // Add event listeners to both buttons
            themeToggleBtn?.addEventListener('click', toggleTheme);
            themeToggleMobileBtn?.addEventListener('click', toggleTheme);
        </script>
        
        <!-- Initialize Flatpickr -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize all date inputs with Flatpickr
                const dateInputs = document.querySelectorAll('input[type="date"], .datepicker');
                const locale = '{{ app()->getLocale() }}';
                
                dateInputs.forEach(input => {
                    // Check for min date from either data attribute or native min attribute
                    let minDateValue = null;
                    if (input.hasAttribute('data-min-today')) {
                        minDateValue = 'today';
                    } else if (input.hasAttribute('min')) {
                        minDateValue = input.getAttribute('min');
                    }
                    
                    flatpickr(input, {
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'F j, Y',
                        allowInput: true,
                        minDate: minDateValue,
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

                // Initialize datetime inputs with time picker
                const datetimeInputs = document.querySelectorAll('.datetimepicker');
                
                datetimeInputs.forEach(input => {
                    flatpickr(input, {
                        enableTime: true,
                        dateFormat: 'Y-m-d H:i',
                        altInput: true,
                        altFormat: 'F j, Y at h:i K',
                        time_24hr: false,
                        allowInput: true,
                        minDate: input.hasAttribute('data-min-today') ? 'today' : null,
                        theme: 'light',
                        disableMobile: true,
                        locale: locale === 'hu' ? 'hu' : 'default',
                        onReady: function(selectedDates, dateStr, instance) {
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
            .flatpickr-red-theme .flatpickr-day.selected.prevMonthDay,
            .flatpickr-red-theme .flatpickr-day.startRange.prevMonthDay,
            .flatpickr-red-theme .flatpickr-day.endRange.prevMonthDay,
            .flatpickr-red-theme .flatpickr-day.selected.nextMonthDay,
            .flatpickr-red-theme .flatpickr-day.startRange.nextMonthDay,
            .flatpickr-red-theme .flatpickr-day.endRange.nextMonthDay {
                background: #dc2626;
                border-color: #dc2626;
            }

            .flatpickr-red-theme .flatpickr-day:hover {
                background: #fecaca;
                border-color: #fecaca;
            }

            .flatpickr-red-theme .flatpickr-day.today {
                border-color: #dc2626;
            }

            .flatpickr-red-theme .flatpickr-day.today:hover,
            .flatpickr-red-theme .flatpickr-day.today:focus {
                border-color: #dc2626;
                background: #fecaca;
                color: #1f2937;
            }

            .flatpickr-red-theme .flatpickr-months .flatpickr-month {
                background: #dc2626;
            }

            .flatpickr-red-theme .flatpickr-current-month .flatpickr-monthDropdown-months,
            .flatpickr-red-theme .flatpickr-current-month input.cur-year {
                color: white !important;
                font-weight: 600;
            }

            .flatpickr-red-theme .flatpickr-months .flatpickr-prev-month svg,
            .flatpickr-red-theme .flatpickr-months .flatpickr-next-month svg {
                fill: white !important;
            }

            .flatpickr-red-theme .flatpickr-months .flatpickr-prev-month:hover svg,
            .flatpickr-red-theme .flatpickr-months .flatpickr-next-month:hover svg {
                fill: #fecaca;
            }

            .flatpickr-red-theme .flatpickr-current-month .flatpickr-monthDropdown-months:hover,
            .flatpickr-red-theme .flatpickr-current-month .numInputWrapper:hover {
                background: #b91c1c;
            }

            /* Dark mode support */
            .dark .flatpickr-calendar {
                background: #1f2937;
                border-color: #374151;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            }

            .dark .flatpickr-months {
                background: #7f1d1d;
            }

            .dark .flatpickr-current-month .flatpickr-monthDropdown-months,
            .dark .flatpickr-current-month input.cur-year {
                background: transparent;
                color: white;
            }

            .dark .flatpickr-weekdays {
                background: #374151;
            }

            .dark .flatpickr-weekday {
                color: #d1d5db;
            }

            .dark .flatpickr-day {
                color: #d1d5db;
            }

            .dark .flatpickr-day:hover {
                background: #374151;
                border-color: #374151;
            }

            .dark .flatpickr-day.today {
                border-color: #dc2626;
                color: #dc2626;
            }

            .dark .flatpickr-day.selected {
                background: #dc2626;
                border-color: #dc2626;
                color: white;
            }
        </style>

        @stack('scripts')
    </body>
</html>
