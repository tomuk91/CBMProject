<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.calendar_title') }}
                <x-help-hint :text="__('messages.help_calendar')" position="bottom" />
            </h2>
            <div data-tour="calendar-actions" class="flex items-center gap-2 sm:gap-3">
                {{-- Actions Dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button" class="bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm px-4 py-2.5 rounded-lg transition-all duration-200 font-medium flex items-center gap-2 min-h-[44px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                        {{ __('messages.actions') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-1 z-50" x-cloak>
                        <a href="{{ route('admin.appointments.export') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ __('messages.export_appointments') }}
                        </a>
                        <button onclick="document.getElementById('bulkEmailModal').classList.remove('hidden')" class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-4 h-4 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            {{ __('messages.bulk_email') }}
                        </button>
                    </div>
                </div>
                
                {{-- Primary Actions --}}
                <a href="{{ route('admin.appointments.slots') }}" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2.5 rounded-lg transition-all duration-200 font-semibold flex items-center gap-2 min-h-[44px]">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('messages.admin_manage_slots') }}</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen" x-data="{ fullWidth: localStorage.getItem('calendarFullWidth') === 'true' }" x-init="$watch('fullWidth', val => localStorage.setItem('calendarFullWidth', val))">
        <div class="space-y-4 transition-all duration-300 px-2 sm:px-4" :class="fullWidth ? 'max-w-full' : 'max-w-7xl mx-auto lg:px-6'">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
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
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
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

            {{-- Calendar Card --}}
            <div data-tour="calendar-view" class="bg-white dark:bg-gray-800 shadow-lg rounded-xl border border-gray-100 dark:border-gray-700">
                {{-- Toolbar --}}
                <div data-tour="calendar-toolbar" class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        {{-- Left: Filter Toggle & Quick Filters --}}
                        <div class="flex items-center gap-3">
                            <button x-data x-on:click="$dispatch('toggle-filters')" type="button" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                {{ __('messages.filters') }}
                            </button>
                            
                            {{-- Pending Badge --}}
                            @php $pendingCount = \App\Models\PendingAppointment::where('status', 'pending')->count(); @endphp
                            @if($pendingCount > 0)
                                <a href="{{ route('admin.appointments.pending') }}" class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/30 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $pendingCount }} {{ __('messages.pending') }}
                                </a>
                            @endif
                        </div>
                        
                        {{-- Right: Full Width Toggle & Show Cancelled Toggle --}}
                        <div class="flex items-center gap-4">
                            {{-- Full Width Toggle --}}
                            <button @click="fullWidth = !fullWidth; $nextTick(() => window.dispatchEvent(new Event('fullwidth-toggled')))" type="button" class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-lg transition-colors" :class="fullWidth ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600'" :title="fullWidth ? '{{ __('messages.calendar_compact_view') }}' : '{{ __('messages.calendar_full_width') }}'">
                                <svg x-show="!fullWidth" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                <svg x-show="fullWidth" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9V4.5M9 9H4.5M9 9L3.5 3.5M9 15v4.5M9 15H4.5M9 15l-5.5 5.5M15 9h4.5M15 9V4.5M15 9l5.5-5.5M15 15h4.5M15 15v4.5m0-4.5l5.5 5.5"/>
                                </svg>
                            </button>
                            
                            <label for="showCancelledToggle" class="flex items-center cursor-pointer">
                                <span class="mr-2 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.calendar_show_cancelled') }}</span>
                                <div class="relative">
                                    <input type="checkbox" id="showCancelledToggle" class="sr-only peer" checked>
                                    <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-500 peer-checked:bg-blue-600"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Collapsible Filters --}}
                @php
                    $hasActiveFilters = request('search') || (request('status') && request('status') !== 'all') || (request('service') && request('service') !== 'all') || request('date_from') || request('date_to');
                @endphp
                <div x-data="{ filtersOpen: {{ $hasActiveFilters ? 'true' : 'false' }} }" x-on:toggle-filters.window="filtersOpen = !filtersOpen">
                    <div x-show="filtersOpen" x-collapse x-cloak class="px-4 py-4 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
                        <form method="GET" action="{{ route('admin.appointments.calendar') }}" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                                {{-- Search --}}
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.calendar_search') }}</label>
                                    <input type="text" name="search" value="{{ request('search') }}" 
                                           placeholder="{{ __('messages.calendar_search_placeholder') }}"
                                           class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                {{-- Status --}}
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.calendar_filter_status') }}</label>
                                    <select name="status" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                        <option value="all">{{ __('messages.calendar_all_statuses') }}</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Service --}}
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.calendar_filter_service') }}</label>
                                    <select name="service" class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                        <option value="all">{{ __('messages.calendar_all_services') }}</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service }}" {{ request('service') == $service ? 'selected' : '' }}>{{ $service }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Date Range --}}
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.calendar_date_from') }}</label>
                                        <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                               class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.calendar_date_to') }}</label>
                                        <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                               class="w-full text-sm rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            {{-- Filter Actions --}}
                            <div class="flex items-center gap-2 pt-2">
                                <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    {{ __('messages.calendar_filter_btn') }}
                                </button>
                                <a href="{{ route('admin.appointments.calendar') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 rounded-lg transition-colors">
                                    {{ __('messages.calendar_clear_btn') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Calendar --}}
                <div class="p-2 sm:p-4 md:p-6 transition-all duration-300">
                    <div id="calendar" class="transition-all duration-300" :class="fullWidth ? 'expanded-calendar' : ''"></div>
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
                        <button id="markCompleteBtn" onclick="markAsComplete()" class="px-4 py-3 bg-red-600 hover:bg-red-700 active:bg-red-800 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center justify-center min-h-[44px]">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.action_complete') }}
                        </button>
                        <button id="cancelAppointmentBtn" onclick="cancelAppointment()" class="px-4 py-3 bg-red-600 hover:bg-red-700 active:bg-red-800 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center justify-center min-h-[44px]">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.calendar_cancel_appointment') }}
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
                            {{ __('messages.calendar_confirm_reschedule') }}
                        </h3>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 space-y-5">
                    <p class="text-base text-gray-700 dark:text-gray-300">{{ __('messages.calendar_reschedule_confirm_text') }}</p>
                    <div id="rescheduleDetails" class="space-y-3 text-sm">
                        <!-- Details will be inserted here -->
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 rounded-b-xl flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                    <button 
                        type="button"
                        onclick="cancelReschedule()" 
                        class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm min-h-[44px]">
                        {{ __('messages.cancel') }}
                    </button>
                    <button 
                        type="button"
                        onclick="confirmReschedule()" 
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center min-h-[44px]">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('messages.calendar_confirm_reschedule') }}
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
        /* Expanded calendar height - force rows to stretch */
        .expanded-calendar {
            height: 700px;
        }
        
        .expanded-calendar .fc {
            height: 100% !important;
        }
        
        .expanded-calendar .fc-view-harness {
            height: calc(100% - 60px) !important;
        }
        
        .expanded-calendar .fc-daygrid-body {
            height: 100% !important;
        }
        
        .expanded-calendar .fc-scrollgrid-sync-table {
            height: 100% !important;
        }
        
        .expanded-calendar .fc-daygrid-body-balanced .fc-daygrid-day-events {
            min-height: 80px;
        }
        
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
        
        .dark .fc-theme-standard .fc-scrollgrid {
            border-color: #374151;
        }
        
        .dark .fc-theme-standard td, 
        .dark .fc-theme-standard th {
            border-color: #374151;
        }
        
        .dark .fc .fc-col-header-cell-cushion {
            color: #fecaca;
        }
        
        .dark .fc .fc-daygrid-day-top {
            color: #d1d5db;
        }
        
        .dark .fc .fc-list-day-cushion {
            background-color: #1f2937;
            color: #f3f4f6;
        }
        
        .dark .fc .fc-list-event:hover td {
            background-color: #374151;
        }
        
        .dark .fc .fc-list-event-title a {
            color: #f3f4f6;
        }
        
        .dark .fc .fc-list-event-time {
            color: #9ca3af;
        }
        
        .dark .fc .fc-timegrid-slot-label {
            color: #9ca3af;
        }
        
        .dark .fc .fc-timegrid-axis-cushion {
            color: #9ca3af;
        }
        
        .dark .fc .fc-list-empty {
            background-color: #1f2937;
            color: #9ca3af;
        }
        
        /* Additional dark mode text colors */
        .dark .fc,
        .dark .fc-daygrid-day-frame,
        .dark .fc-daygrid-day-events,
        .dark .fc-daygrid-event-harness {
            color: #e5e7eb;
        }
        
        .dark .fc a {
            color: #e5e7eb;
        }
        
        .dark .fc-daygrid-day-number,
        .dark .fc-col-header-cell-cushion,
        .dark .fc-timegrid-slot-label-cushion,
        .dark .fc-list-day-text,
        .dark .fc-list-day-side-text {
            color: #e5e7eb !important;
        }
        
        .dark .fc-daygrid-day {
            background-color: #1f2937;
        }
        
        .dark .fc-daygrid-day.fc-day-other {
            background-color: #111827;
        }
        
        .dark .fc-daygrid-day.fc-day-other .fc-daygrid-day-number {
            color: #6b7280 !important;
        }
        
        .dark .fc-scrollgrid-section-header {
            background-color: #1f2937;
        }
        
        .dark .fc-list-table {
            background-color: #1f2937;
        }
        
        .dark .fc-list-event td {
            border-color: #374151;
        }
        
        .dark .fc-timegrid-divider {
            background-color: #374151;
        }
        
        .dark .fc-timegrid-slot {
            border-color: #374151;
        }
        
        .dark .fc-timegrid-col {
            background-color: #1f2937;
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
                    const params = new URLSearchParams({
                        start: info.startStr,
                        end: info.endStr,
                        search: '{{ request("search") ?? "" }}',
                        status: '{{ request("status") ?? "all" }}',
                        service: '{{ request("service") ?? "all" }}'
                    });
                    fetch(`/admin/appointments/api?${params}`)
                        .then(response => response.json())
                        .then(data => {
                            const showCancelled = document.getElementById('showCancelledToggle').checked;
                            if (!showCancelled) {
                                data = data.filter(event => event.extendedProps.status !== 'cancelled');
                            }
                            successCallback(data);
                        })
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
            
            // Handle toggle for cancelled appointments
            document.getElementById('showCancelledToggle').addEventListener('change', function() {
                calendar.refetchEvents();
            });
            
            // Handle full width toggle - update calendar size and height
            window.addEventListener('fullwidth-toggled', function() {
                setTimeout(function() {
                    const isFullWidth = localStorage.getItem('calendarFullWidth') === 'true';
                    if (isFullWidth) {
                        calendar.setOption('height', 750);
                    } else {
                        calendar.setOption('height', 'auto');
                    }
                    calendar.updateSize();
                }, 350); // Wait for CSS transition to complete
            });
            
            // Apply saved full width setting on load
            if (localStorage.getItem('calendarFullWidth') === 'true') {
                calendar.setOption('height', 750);
            }
            
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
                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">{{ __('messages.customer') }}</p>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">${props.customer}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">${props.service}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg p-3">
                        <p class="text-xs text-red-600 dark:text-red-400 uppercase tracking-wide mb-2 font-semibold">{{ __('messages.calendar_old_date_time') }}</p>
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
                        <p class="text-xs text-green-600 dark:text-green-400 uppercase tracking-wide mb-2 font-semibold">{{ __('messages.calendar_new_date_time') }}</p>
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
                    showToast('{{ __('messages.calendar_appointment_updated') }}', 'success');
                } else {
                    showToast(data.message || '{{ __('messages.calendar_update_failed') }}', 'error');
                    calendar.refetchEvents();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('{{ __('messages.calendar_update_failed') }}', 'error');
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
                            <p class="text-sm font-medium">${props.vehicle ? props.vehicle.replace(/\s*\([^)]*\)\s*$/, '') : '{{ __('messages.calendar_not_available') }}'}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">{{ __('messages.calendar_registration') }}</p>
                            <p class="text-sm font-bold text-red-600 dark:text-red-400">${props.vehicle && props.vehicle.match(/\(([^)]+)\)/) ? props.vehicle.match(/\(([^)]+)\)/)[1] : '{{ __('messages.calendar_not_available') }}'}</p>
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
                        <p class="text-xs text-amber-700 dark:text-amber-400 font-semibold mb-1 uppercase tracking-wide">{{ __('messages.admin_notes') }}</p>
                        <p class="text-sm text-amber-900 dark:text-amber-200">${props.admin_notes}</p>
                    </div>
                    ` : ''}
                </div>
            `;
            document.getElementById('appointmentDetails').innerHTML = detailsHtml;
            
            // Hide/show buttons based on status
            const markCompleteBtn = document.getElementById('markCompleteBtn');
            const cancelBtn = document.getElementById('cancelAppointmentBtn');
            
            if (props.status === 'completed' || props.status === 'cancelled') {
                // Hide both buttons for completed/cancelled appointments
                markCompleteBtn.style.display = 'none';
                cancelBtn.style.display = 'none';
            } else {
                // Show both buttons for active appointments
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
            
            if (!confirm('{{ __('messages.calendar_cancel_confirm') }}')) return;
            
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
                    showToast('{{ __('messages.calendar_appointment_cancelled') }}', 'success');
                    closeModal();
                    // Reload page after short delay to show toast
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    showToast(data.message || '{{ __('messages.calendar_cancel_failed') }}', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('{{ __('messages.calendar_cancel_failed') }}', 'error');
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

        document.getElementById('bulkEmailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                document.getElementById('bulkEmailModal').classList.add('hidden');
            }
        });
    </script>

    <!-- Bulk Email Modal -->
    <div id="bulkEmailModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto w-full max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                        {{ __('messages.bulk_email_title') }}
                    </h3>
                    <button onclick="document.getElementById('bulkEmailModal').classList.add('hidden')" class="text-white hover:text-red-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">

                <form method="POST" action="{{ route('admin.appointments.bulk-email') }}">
                    @csrf
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            {{ __('messages.bulk_email_recipients') }}
                        </label>
                        <div class="space-y-2">
                            <label class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                <input type="radio" name="recipient_type" value="all" checked class="text-red-600 focus:ring-red-500">
                                <span class="ml-3 text-gray-900 dark:text-gray-100">{{ __('messages.bulk_email_all_customers') }}</span>
                            </label>
                            <label class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                <input type="radio" name="recipient_type" value="completed" class="text-red-600 focus:ring-red-500">
                                <span class="ml-3 text-gray-900 dark:text-gray-100">{{ __('messages.bulk_email_completed_only') }}</span>
                            </label>
                            <label class="flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                <input type="radio" name="recipient_type" value="confirmed" class="text-red-600 focus:ring-red-500">
                                <span class="ml-3 text-gray-900 dark:text-gray-100">{{ __('messages.bulk_email_confirmed_only') }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email_subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.email_subject') }}
                        </label>
                        <input type="text" id="email_subject" name="subject" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100"
                               placeholder="{{ __('messages.email_subject_placeholder') }}">
                    </div>

                    <div class="mb-6">
                        <label for="email_message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.email_message') }}
                        </label>
                        <textarea id="email_message" name="message" rows="8" required
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100"
                                  placeholder="{{ __('messages.email_message_placeholder') }}"></textarea>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            {{ __('messages.bulk_email_note') }}
                        </p>
                    </div>

                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                {{ __('messages.bulk_email_warning') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="button" onclick="document.getElementById('bulkEmailModal').classList.add('hidden')"
                                class="flex-1 px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm min-h-[44px]">
                            {{ __('messages.cancel') }}
                        </button>
                        <button type="submit"
                                class="flex-1 px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center min-h-[44px]">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"/>
                            </svg>
                            {{ __('messages.send_email') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.partials.tour', [
        'tourPage' => 'calendar',
        'tourSteps' => [
            [
                'target' => null,
                'title' => __('messages.tour_calendar_welcome_title'),
                'description' => __('messages.tour_calendar_welcome_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
            [
                'target' => '[data-tour="calendar-actions"]',
                'title' => __('messages.tour_calendar_actions_title'),
                'description' => __('messages.tour_calendar_actions_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="calendar-toolbar"]',
                'title' => __('messages.tour_calendar_toolbar_title'),
                'description' => __('messages.tour_calendar_toolbar_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="calendar-view"]',
                'title' => __('messages.tour_calendar_view_title'),
                'description' => __('messages.tour_calendar_view_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
                'position' => 'top',
            ],
            [
                'target' => null,
                'title' => __('messages.tour_calendar_complete_title'),
                'description' => __('messages.tour_calendar_complete_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
        ],
    ])
</x-app-layout>
