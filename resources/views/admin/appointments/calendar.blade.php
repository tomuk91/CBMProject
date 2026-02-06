<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.calendar_title') }}
            </h2>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.appointments.slots') }}" class="bg-red-600 hover:bg-red-700 active:bg-red-800 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm px-4 sm:px-5 py-3 sm:py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center justify-center sm:justify-start min-h-[44px]">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                    </svg>
                    {{ __('messages.admin_manage_slots') }}
                </a>
                <a href="{{ route('admin.appointments.pending') }}" class="bg-red-700 hover:bg-red-800 active:bg-red-900 dark:bg-red-800 dark:hover:bg-red-900 text-white text-sm px-4 sm:px-5 py-3 sm:py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center justify-center sm:justify-start min-h-[44px]">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('messages.admin_pending_requests') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6 space-y-6">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-500 hover:text-green-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-2 sm:p-4 md:p-6">
                    <!-- Calendar will be rendered here -->
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Details Modal -->
    <div id="appointmentModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
        <div class="relative top-4 sm:top-20 mx-auto p-2 sm:p-1 w-full max-w-lg">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden max-h-[calc(100vh-2rem)] overflow-y-auto">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('messages.appointments_details') }}
                    </h3>
                </div>
                <div class="p-6">
                    <div id="appointmentDetails" class="text-sm text-gray-700 dark:text-gray-300 space-y-3">
                        <!-- Details will be inserted here -->
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 px-4 sm:px-6 py-4 flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                    <div class="flex flex-col sm:flex-row gap-2 order-2 sm:order-1">
                        <button id="markCompleteBtn" onclick="markAsComplete()" class="px-4 py-3 bg-green-600 hover:bg-green-700 active:bg-green-800 dark:bg-green-700 dark:hover:bg-green-800 text-white text-sm rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center justify-center min-h-[44px]">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.action_complete') }}
                        </button>
                        <button id="cancelAppointmentBtn" onclick="cancelAppointment()" class="px-4 py-3 bg-red-600 hover:bg-red-700 active:bg-red-800 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center justify-center min-h-[44px]">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Cancel Appointment
                        </button>
                    </div>
                    <button onclick="closeModal()" class="px-4 py-3 bg-gray-200 hover:bg-gray-300 active:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 text-sm rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md order-1 sm:order-2 min-h-[44px]">
                        {{ __('messages.action_close') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Drag/Drop Confirmation Modal -->
    <div id="rescheduleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full z-50 backdrop-blur-sm">
        <div class="relative top-4 sm:top-20 mx-auto p-2 sm:p-1 w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-white shadow-md">
                            <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            Confirm Reschedule
                        </h3>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 space-y-5">
                    <p class="text-base text-gray-700 dark:text-gray-300">Are you sure you want to reschedule this appointment?</p>
                    <div id="rescheduleDetails" class="space-y-3 text-sm">
                        <!-- Details will be inserted here -->
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 rounded-b-xl flex items-center justify-end gap-3">
                    <button 
                        type="button"
                        onclick="cancelReschedule()" 
                        class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                        Cancel
                    </button>
                    <button 
                        type="button"
                        onclick="confirmReschedule()" 
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Confirm Reschedule
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/hu.global.min.js"></script>

    <style>
        /* Modern Calendar Styling with Red Theme */
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
            border-radius: 0.5rem;
            padding: 2px 4px;
            border: none;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: move;
            transition: all 0.2s;
        }
        
        .fc-event:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3);
        }
        
        .fc-event-dragging {
            opacity: 0.75;
            box-shadow: 0 20px 25px -5px rgba(220, 38, 38, 0.3);
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
            border-radius: 0.5rem;
            padding: 4px;
        }
        
        /* Dark mode adjustments */
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
            
            /* Hide week/day views on mobile, keep month and list */
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
        let calendar;
        let currentAppointmentId = null;
        let pendingReschedule = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // Detect mobile and adjust initial view
            const isMobile = window.innerWidth < 640;
            const isTablet = window.innerWidth >= 640 && window.innerWidth < 1024;
            
            calendar = new FullCalendar.Calendar(calendarEl, {
                locale: '{{ app()->getLocale() }}',
                firstDay: 1, // Monday as first day of week (Hungary convention)
                initialView: isMobile ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: isMobile ? 'dayGridMonth,listWeek' : 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                buttonText: {
                    today: '{{ __('messages.calendar_today') }}',
                    month: '{{ __('messages.calendar_month') }}',
                    week: '{{ __('messages.calendar_week') }}',
                    day: '{{ __('messages.calendar_day') }}',
                    list: '{{ __('messages.calendar_list') }}'
                },
                events: function(info, successCallback, failureCallback) {
                    fetch(`/admin/appointments/api?start=${info.startStr}&end=${info.endStr}`)
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => failureCallback(error));
                },
                eventClick: function(info) {
                    showAppointmentDetails(info.event);
                },
                editable: !isMobile, // Disable drag/drop on mobile
                droppable: !isMobile,
                eventDrop: function(info) {
                    showRescheduleConfirmation(info);
                },
                eventResize: function(info) {
                    showRescheduleConfirmation(info);
                },
                height: 'auto',
                contentHeight: isMobile ? 500 : 'auto',
                aspectRatio: isMobile ? 1 : 1.8,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: true
                },
                slotMinTime: '08:00:00',
                slotMaxTime: '18:00:00',
                allDaySlot: false,
                nowIndicator: true,
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '09:00',
                    endTime: '17:00'
                },
                // Mobile-specific settings
                dayMaxEvents: isMobile ? 2 : true,
                moreLinkClick: 'popover',
                navLinks: true,
                navLinkDayClick: function(date, jsEvent) {
                    if (isMobile) {
                        calendar.changeView('listWeek', date);
                    }
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
                        location.reload(); // Reload to apply proper mobile/desktop config
                    }
                }, 250);
            });
        });

        function showRescheduleConfirmation(info) {
            pendingReschedule = info;
            const event = info.event;
            const props = event.extendedProps;
            
            const oldStart = info.oldEvent.start;
            const newStart = event.start;
            
            const detailsHtml = `
                <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 mb-3">
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Customer</p>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">${props.customer}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">${props.service}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg p-3">
                        <p class="text-xs text-red-600 dark:text-red-400 uppercase tracking-wide mb-2 font-semibold">Old Date & Time</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${oldStart.toLocaleString('{{ app()->getLocale() }}', {
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        })}</p>
                        <p class="text-lg font-bold text-red-600 dark:text-red-400 mt-1">${oldStart.toLocaleString('{{ app()->getLocale() }}', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-lg p-3">
                        <p class="text-xs text-green-600 dark:text-green-400 uppercase tracking-wide mb-2 font-semibold">New Date & Time</p>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${newStart.toLocaleString('{{ app()->getLocale() }}', {
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        })}</p>
                        <p class="text-lg font-bold text-green-600 dark:text-green-400 mt-1">${newStart.toLocaleString('{{ app()->getLocale() }}', {
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</p>
                    </div>
                </div>
            `;
            
            document.getElementById('rescheduleDetails').innerHTML = detailsHtml;
            document.getElementById('rescheduleModal').classList.remove('hidden');
        }

        function confirmReschedule() {
            if (!pendingReschedule) return;
            
            const event = pendingReschedule.event;
            updateAppointmentTime(event);
            closeRescheduleModal();
        }

        function cancelReschedule() {
            if (pendingReschedule) {
                pendingReschedule.revert();
                pendingReschedule = null;
            }
            closeRescheduleModal();
        }

        function closeRescheduleModal() {
            document.getElementById('rescheduleModal').classList.add('hidden');
            pendingReschedule = null;
        }

        function updateAppointmentTime(event) {
            const appointmentId = event.id;
            const newStart = event.start.toISOString();
            const newEnd = event.end ? event.end.toISOString() : event.start.toISOString();
            
            fetch(`/admin/appointments/${appointmentId}/update-time`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    appointment_date: newStart,
                    appointment_end: newEnd
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Appointment updated successfully', 'success');
                } else {
                    showToast(data.message || 'Failed to update appointment', 'error');
                    calendar.refetchEvents();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to update appointment', 'error');
                calendar.refetchEvents();
            });
        }

        function showAppointmentDetails(event) {
            currentAppointmentId = event.id;
            const props = event.extendedProps;
            
            // Show/hide complete button based on status
            const completeBtn = document.getElementById('markCompleteBtn');
            if (props.status === 'completed' || props.status === 'cancelled') {
                completeBtn.style.display = 'none';
            } else {
                completeBtn.style.display = 'flex';
            }
            const detailsHtml = `
                <div class="space-y-3">
                    <div class="pb-3 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">{{ __('messages.customer') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">${props.customer}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.book_client_email') }}</p>
                            <p class="text-sm font-medium">${props.email}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.book_client_phone') }}</p>
                            <p class="text-sm font-medium">${props.phone}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.vehicle_information') }}</p>
                            <p class="text-sm font-medium">${props.vehicle ? props.vehicle.replace(/\s*\([^)]*\)\s*$/, '') : 'N/A'}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Registration</p>
                            <p class="text-sm font-bold text-red-600 dark:text-red-400">${props.vehicle && props.vehicle.match(/\(([^)]+)\)/) ? props.vehicle.match(/\(([^)]+)\)/)[1] : 'N/A'}</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.service') }}</p>
                        <p class="text-sm font-semibold text-blue-600">${props.service}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.time') }}</p>
                        <p class="text-sm font-medium">${event.start.toLocaleString('{{ app()->getLocale() }}', { 
                            weekday: 'short', 
                            year: 'numeric', 
                            month: 'short', 
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.slots_status') }}</p>
                        <span class="inline-flex px-2 py-1 rounded-md text-xs font-semibold ${getStatusClass(props.status)}">${props.status.toUpperCase()}</span>
                    </div>
                    ${props.notes ? `
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.notes') }}</p>
                        <p class="text-sm">${props.notes}</p>
                    </div>
                    ` : ''}
                    ${props.admin_notes ? `
                    <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-3 rounded">
                        <p class="text-xs text-amber-700 dark:text-amber-400 font-semibold mb-1 uppercase tracking-wide">Admin Notes</p>
                        <p class="text-sm text-amber-900 dark:text-amber-200">${props.admin_notes}</p>
                    </div>
                    ` : ''}
                </div>
            `;
            document.getElementById('appointmentDetails').innerHTML = detailsHtml;
            
            // Hide/show buttons based on status
            const markCompleteBtn = document.getElementById('markCompleteBtn');
            const cancelBtn = document.getElementById('cancelAppointmentBtn');
            
            if (props.status === 'completed') {
                // Hide both buttons for completed appointments
                markCompleteBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            } else {
                // Show both buttons for non-completed appointments
                markCompleteBtn.style.display = 'flex';
                cancelBtn.style.display = 'flex';
            }
            
            document.getElementById('appointmentModal').classList.remove('hidden');
        }

        function markAsComplete() {
            if (!currentAppointmentId) return;
            
            if (!confirm('{{ __('messages.confirm_complete_appointment') }}')) return;
            
            fetch(`/admin/appointments/${currentAppointmentId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('{{ __('messages.appointment_completed_success') }}', 'success');
                    closeModal();
                    // Reload page after short delay to show toast
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message || '{{ __('messages.error_generic') }}', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('{{ __('messages.error_generic') }}', 'error');
            });
        }

        function cancelAppointment() {
            if (!currentAppointmentId) return;
            
            if (!confirm('Are you sure you want to cancel this appointment? This action cannot be undone.')) return;
            
            fetch(`/admin/appointments/${currentAppointmentId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('Appointment cancelled successfully', 'success');
                    closeModal();
                    // Reload page after short delay to show toast
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message || 'Failed to cancel appointment', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to cancel appointment: ' + error.message, 'error');
            });
        }

        function closeModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
            currentAppointmentId = null;
        }

        function getStatusClass(status) {
            switch(status) {
                case 'confirmed':
                    return 'bg-blue-100 text-blue-700';
                case 'completed':
                    return 'bg-green-100 text-green-700';
                case 'cancelled':
                    return 'bg-red-100 text-red-700';
                default:
                    return 'bg-gray-100 text-gray-700';
            }
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Close modal when clicking outside
        document.getElementById('appointmentModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.getElementById('rescheduleModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                cancelReschedule();
            }
        });
    </script>
</x-app-layout>
