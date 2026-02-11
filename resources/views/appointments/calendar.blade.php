<x-app-layout>
    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-[95%] mx-auto sm:px-4 lg:px-6">
            <!-- Header Section -->
            <div class="mb-6 sm:mb-8 mt-4 sm:mt-8 text-center px-4">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3">
                    {{ __('messages.appointments_available') }}
                </h1>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-300">
                    {{ __('messages.customer_calendar_subtitle') }}
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

            <!-- View Toggle -->
            <div class="flex justify-end mb-4 px-4 sm:px-0">
                <div class="inline-flex rounded-lg shadow-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <a href="{{ route('appointments.index') }}" 
                       class="px-4 py-2.5 text-sm font-semibold rounded-l-lg transition-all duration-200 flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        {{ __('messages.customer_calendar_list_view') }}
                    </a>
                    <a href="{{ route('appointments.calendar') }}" 
                       class="px-4 py-2.5 text-sm font-semibold rounded-r-lg transition-all duration-200 flex items-center gap-2 bg-red-600 text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('messages.customer_calendar_calendar_view') }}
                    </a>
                </div>
            </div>

            <!-- Calendar Container -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-3 sm:p-6">
                <!-- Legend -->
                <div class="flex flex-wrap gap-4 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-green-600"></span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.customer_calendar_available_slot') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ __('messages.customer_calendar_click_to_book') }}
                    </div>
                </div>

                <div id="customer-calendar"></div>
            </div>
        </div>
    </div>

    <!-- FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/hu.global.min.js"></script>

    <style>
        /* Customer Calendar Styling — Red/Green Theme */
        .fc {
            font-family: inherit;
        }
        
        .fc .fc-button-primary {
            background-color: #dc2626;
            border-color: #dc2626;
            font-size: 0.875rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .fc .fc-button-primary:hover {
            background-color: #b91c1c;
            border-color: #b91c1c;
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }
        
        .fc .fc-button-primary:not(:disabled).fc-button-active,
        .fc .fc-button-primary:not(:disabled):active {
            background-color: #991b1b;
            border-color: #991b1b;
        }
        
        .fc-theme-standard .fc-scrollgrid {
            border-color: #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .fc-theme-standard td, .fc-theme-standard th {
            border-color: #e5e7eb;
        }
        
        .fc .fc-daygrid-day-number {
            padding: 0.5rem;
            font-weight: 600;
            color: #374151;
        }
        
        .fc .fc-col-header-cell {
            background-color: #fef2f2;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            color: #991b1b;
            padding: 0.75rem 0;
        }
        
        .fc .fc-daygrid-day.fc-day-today {
            background-color: #fee2e2 !important;
        }
        
        .fc-event {
            border-radius: 0.375rem;
            padding: 2px 6px;
            border: none;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .fc-event:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.4);
            filter: brightness(1.1);
        }
        
        .fc .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
        }
        
        .fc .fc-button-group {
            gap: 0.25rem;
        }
        
        .fc-timegrid-slot {
            height: 3rem;
        }
        
        .fc-timegrid-event {
            border-radius: 0.375rem;
            padding: 4px;
        }

        /* Day cells with events — subtle green hint */
        .fc .fc-daygrid-day:has(.fc-event) .fc-daygrid-day-number {
            color: #15803d;
        }
        
        /* Dark mode adjustments */
        .dark .fc-theme-standard .fc-scrollgrid,
        .dark .fc-theme-standard td,
        .dark .fc-theme-standard th {
            border-color: #374151;
        }
        
        .dark .fc .fc-col-header-cell {
            background-color: #7f1d1d;
            color: #fecaca;
        }
        
        .dark .fc .fc-daygrid-day.fc-day-today {
            background-color: #7f1d1d !important;
        }
        
        .dark .fc .fc-toolbar-title {
            color: #f3f4f6;
        }
        
        .dark .fc .fc-daygrid-day-number {
            color: #d1d5db;
        }

        .dark .fc .fc-daygrid-day:has(.fc-event) .fc-daygrid-day-number {
            color: #86efac;
        }
        
        /* Mobile optimizations */
        @media (max-width: 640px) {
            .fc .fc-toolbar {
                flex-direction: column;
                gap: 0.5rem;
                align-items: stretch;
            }
            
            .fc .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
                width: 100%;
            }
            
            .fc .fc-button {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
                min-height: 44px;
            }
            
            .fc .fc-toolbar-title {
                font-size: 1.125rem;
                text-align: center;
            }
            
            .fc .fc-daygrid-day-number {
                padding: 0.25rem;
                font-size: 0.875rem;
            }
            
            .fc .fc-col-header-cell {
                padding: 0.5rem 0;
                font-size: 0.625rem;
            }
            
            .fc-event {
                font-size: 0.625rem;
                padding: 1px 2px;
            }
            
            .fc .fc-button-group {
                display: flex;
                gap: 0.25rem;
            }
            
            .fc .fc-timeGridWeek-button,
            .fc .fc-timeGridDay-button {
                display: none;
            }
        }
        
        @media (min-width: 641px) and (max-width: 768px) {
            .fc .fc-toolbar-title {
                font-size: 1.25rem;
            }
            
            .fc .fc-button {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('customer-calendar');
            const isMobile = window.innerWidth < 640;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: '{{ app()->getLocale() }}',
                firstDay: 1,
                initialView: isMobile ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: isMobile ? 'dayGridMonth,listWeek' : 'dayGridMonth,timeGridWeek,listWeek'
                },
                buttonText: {
                    today: '{{ __('messages.customer_calendar_today') }}',
                    month: '{{ __('messages.customer_calendar_month') }}',
                    week: '{{ __('messages.customer_calendar_week') }}',
                    list: '{{ __('messages.customer_calendar_list') }}'
                },
                events: function(info, successCallback, failureCallback) {
                    const params = new URLSearchParams({
                        start: info.startStr,
                        end: info.endStr,
                    });
                    fetch(`{{ route('appointments.calendar.api') }}?${params}`)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.location.href = info.event.url;
                    }
                },
                editable: false,
                droppable: false,
                height: 'auto',
                contentHeight: isMobile ? 500 : 'auto',
                aspectRatio: isMobile ? 1 : 1.8,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                slotMinTime: '06:00:00',
                slotMaxTime: '21:00:00',
                allDaySlot: false,
                nowIndicator: true,
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '09:00',
                    endTime: '17:00'
                },
                dayMaxEvents: isMobile ? 3 : true,
                moreLinkClick: 'popover',
                navLinks: true,
                navLinkDayClick: function(date) {
                    if (isMobile) {
                        calendar.changeView('listWeek', date);
                    } else {
                        calendar.changeView('timeGridWeek', date);
                    }
                },
                // Empty state
                noEventsContent: {
                    html: `<div class="text-center py-8">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400 font-medium">{{ __('messages.customer_calendar_no_slots') }}</p>
                    </div>`
                }
            });

            calendar.render();

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    const nowMobile = window.innerWidth < 640;
                    if ((isMobile && !nowMobile) || (!isMobile && nowMobile)) {
                        location.reload();
                    }
                }, 250);
            });
        });
    </script>

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

</x-app-layout>
