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

        <!-- Flatpickr CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
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
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Flatpickr JS -->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        <!-- Initialize Flatpickr -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize all date inputs with Flatpickr
                const dateInputs = document.querySelectorAll('input[type="date"], .datepicker');
                
                dateInputs.forEach(input => {
                    flatpickr(input, {
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'F j, Y',
                        allowInput: true,
                        minDate: input.hasAttribute('data-min-today') ? 'today' : null,
                        theme: 'light',
                        disableMobile: true,
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
    </body>
</html>
