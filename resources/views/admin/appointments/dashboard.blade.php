<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.dashboard_admin') }}
            </h2>
            <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="flex bg-gray-50 dark:bg-gray-900 min-h-screen">
        {{-- Admin Sidebar --}}
        @include('admin.partials.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 py-4 min-w-0">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 dark:from-red-700 dark:to-red-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-white mb-2">
                                {{ __('messages.admin_welcome') }}
                            </h1>
                            <p class="text-red-100 text-lg">
                                {{ __('messages.admin_dashboard_subtitle') }}
                            </p>
                        </div>
                        <div class="hidden md:block">
                            <svg class="w-24 h-24 text-red-500 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div data-tour="stats" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Pending Requests -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-5xl font-bold text-red-600 dark:text-red-400 mb-2">{{ $pendingCount }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">{{ __('messages.status_pending') }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ __('messages.admin_pending_approvals') }}</p>
                    </div>
                </div>

                <!-- Available Slots -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="h-2 bg-gradient-to-r from-red-600 to-red-700"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-5xl font-bold text-red-600 dark:text-red-400 mb-2">{{ $availableSlotsCount }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">{{ __('messages.status_available') }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ __('messages.admin_available_appointments') }}</p>
                    </div>
                </div>

                <!-- Booked Slots -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="h-2 bg-gradient-to-r from-red-700 to-red-800"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-red-700 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-5xl font-bold text-red-700 dark:text-red-400 mb-2">{{ $bookedSlotsCount }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">{{ __('messages.status_booked') }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ __('messages.admin_bookings_confirmed') }}</p>
                    </div>
                </div>

                <!-- Total Appointments -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="h-2 bg-gradient-to-r from-gray-600 to-gray-700 dark:from-gray-500 dark:to-gray-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-5xl font-bold text-gray-700 dark:text-gray-300 mb-2">{{ $todayAppointmentsCount }}</p>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wider">{{ __('messages.admin_todays_appointments') }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ __('messages.admin_recent_activity') }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quick Actions -->
                <div data-tour="quick-actions" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-700/30 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.admin_quick_actions') }}
                        </h3>
                    </div>
                    <div class="p-5 space-y-3">
                        <a href="{{ route('admin.appointments.slots') }}" class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10 hover:from-red-100 hover:to-red-50 dark:hover:from-red-900/30 dark:hover:to-red-900/20 rounded-xl transition-all duration-300 group border border-red-100 dark:border-red-900/30">
                            <div class="flex items-center">
                                <div class="bg-red-600 dark:bg-red-700 rounded-xl p-3 mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.slots_create') }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ __('messages.admin_manage_slots') }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.schedule-templates.index') }}" class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10 hover:from-red-100 hover:to-red-50 dark:hover:from-red-900/30 dark:hover:to-red-900/20 rounded-xl transition-all duration-300 group border border-red-100 dark:border-red-900/30">
                            <div class="flex items-center">
                                <div class="bg-red-600 dark:bg-red-700 rounded-xl p-3 mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.schedule_templates') }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ __('messages.schedule_templates_subtitle') }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.appointments.pending') }}" class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10 hover:from-red-100 hover:to-red-50 dark:hover:from-red-900/30 dark:hover:to-red-900/20 rounded-xl transition-all duration-300 group border border-red-100 dark:border-red-900/30">
                            <div class="flex items-center">
                                <div class="bg-red-600 dark:bg-red-700 rounded-xl p-3 mr-4 relative group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                    </svg>
                                    @if($pendingCount > 0)
                                    <span class="absolute -top-1 -right-1 flex h-5 w-5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-5 w-5 bg-yellow-500 items-center justify-center text-white text-[10px] font-bold">{{ $pendingCount }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.admin_pending_requests') }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ $pendingCount }} {{ __('messages.admin_pending_approvals') }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.appointments.calendar') }}" class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10 hover:from-red-100 hover:to-red-50 dark:hover:from-red-900/30 dark:hover:to-red-900/20 rounded-xl transition-all duration-300 group border border-red-100 dark:border-red-900/30">
                            <div class="flex items-center">
                                <div class="bg-red-600 dark:bg-red-700 rounded-xl p-3 mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.admin_view_calendar') }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ __('messages.dashboard_view_all') }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <a href="{{ route('admin.appointments.activityLog') }}" class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-red-50/50 dark:from-red-900/20 dark:to-red-900/10 hover:from-red-100 hover:to-red-50 dark:hover:from-red-900/30 dark:hover:to-red-900/20 rounded-xl transition-all duration-300 group border border-red-100 dark:border-red-900/30">
                            <div class="flex items-center">
                                <div class="bg-red-600 dark:bg-red-700 rounded-xl p-3 mr-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.activity_log_title') }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ __('messages.admin_recent_activity') }}</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400 transition" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Upcoming Appointments -->
                <div data-tour="upcoming" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-700/30 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.dashboard_my_appointments') }}
                        </h3>
                    </div>
                    <div class="p-5">
                        @if($upcomingAppointments->isEmpty())
                            <div class="text-center py-12">
                                <div class="bg-gray-100 dark:bg-gray-700/50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 font-semibold">{{ __('messages.appointments_no_slots') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ __('messages.admin_pending_approvals') }}</p>
                            </div>
                        @else
                            <div class="space-y-3 max-h-80 overflow-y-auto">
                                @foreach($upcomingAppointments as $appointment)
                                    <div class="flex items-start p-4 bg-gradient-to-r from-gray-50 to-gray-50/50 dark:from-gray-700/50 dark:to-gray-700/30 rounded-xl hover:from-red-50 hover:to-red-50/50 dark:hover:from-red-900/20 dark:hover:to-red-900/10 transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-red-200 dark:hover:border-red-900/30">
                                        <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3 mr-4">
                                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->name }}</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $appointment->appointment_date->format('M d, Y • g:i A') }}
                                                </span>
                                            </p>
                                            <p class="text-sm text-red-600 dark:text-red-400 font-semibold mt-1.5">{{ $appointment->service }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Navigation Boxes -->
            <div data-tour="nav-cards" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Slots Management -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="h-2 bg-gradient-to-r from-red-600 to-red-700"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $availableSlotsCount }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.slots_title') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">{{ __('messages.admin_manage_slots') }}</p>
                        <a href="{{ route('admin.appointments.slots') }}" class="flex items-center justify-center w-full bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 group-hover:shadow-lg">
                            <span>{{ __('messages.slots_title') }}</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-3 relative group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                @if($pendingCount > 0)
                                <span class="absolute -top-1 -right-1 flex h-6 w-6">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-6 w-6 bg-yellow-500 items-center justify-center text-white text-xs font-bold">{{ $pendingCount }}</span>
                                </span>
                                @endif
                            </div>
                            <span class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $pendingCount }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.admin_pending_requests') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">{{ __('messages.admin_pending_approvals') }}</p>
                        <a href="{{ route('admin.appointments.pending') }}" class="flex items-center justify-center w-full bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 group-hover:shadow-lg">
                            <span>{{ __('messages.admin_pending_requests') }}</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Calendar View -->
                <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                    <div class="h-2 bg-gradient-to-r from-red-700 to-red-800"></div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-3 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-10 h-10 text-red-700 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a1 1 0 001 1h12a1 1 0 001-1V6a2 2 0 00-2-2H4zm0 6a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2v-4a2 2 0 00-2-2H4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="text-4xl font-bold text-red-700 dark:text-red-400">{{ $upcomingAppointments->count() }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.calendar_title') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 text-sm">{{ __('messages.dashboard_view_all') }}</p>
                        <a href="{{ route('admin.appointments.calendar') }}" class="flex items-center justify-center w-full bg-red-700 hover:bg-red-800 dark:bg-red-800 dark:hover:bg-red-900 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 group-hover:shadow-lg">
                            <span>{{ __('messages.admin_view_calendar') }}</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    @include('admin.partials.tour', [
        'tourPage' => 'dashboard',
        'tourSteps' => [
            [
                'target' => null,
                'title' => __('messages.tour_welcome_title'),
                'description' => __('messages.tour_welcome_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>',
                'position' => 'center',
            ],
            [
                'target' => '[data-tour="stats"]',
                'title' => __('messages.tour_stats_title'),
                'description' => __('messages.tour_stats_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="quick-actions"]',
                'title' => __('messages.tour_quick_actions_title'),
                'description' => __('messages.tour_quick_actions_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>',
                'position' => 'right',
            ],
            [
                'target' => '[data-tour="upcoming"]',
                'title' => __('messages.tour_upcoming_title'),
                'description' => __('messages.tour_upcoming_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>',
                'position' => 'left',
            ],
            [
                'target' => '[data-tour="nav-cards"]',
                'title' => __('messages.tour_navigation_title'),
                'description' => __('messages.tour_navigation_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>',
                'position' => 'top',
            ],
            [
                'target' => null,
                'title' => __('messages.tour_complete_title'),
                'description' => __('messages.tour_complete_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
        ],
    ])
</x-app-layout>