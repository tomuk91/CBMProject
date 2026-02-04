<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.admin_pending_requests') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.appointments.slots') }}" class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm px-5 py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                    </svg>
                    {{ __('messages.admin_manage_slots') }}
                </a>
                <a href="{{ route('admin.appointments.calendar') }}" class="bg-red-700 hover:bg-red-800 dark:bg-red-800 dark:hover:bg-red-900 text-white text-sm px-5 py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('messages.admin_view_calendar') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
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

            <!-- Filters and Search -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <form method="GET" action="{{ route('admin.appointments.pending') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Search -->
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.search') }}
                            </label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('messages.search_placeholder') }}" class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 transition">
                        </div>

                        <!-- Service Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.service') }}</label>
                            <select name="service" class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                <option value="">{{ __('messages.all_services') }}</option>
                                @foreach($services as $service)
                                    <option value="{{ $service }}" {{ request('service') === $service ? 'selected' : '' }}>{{ $service }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.date_from') }}</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.date_to') }}</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg font-semibold transition shadow-sm hover:shadow-md flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.apply_filters') }}
                        </button>
                        @if(request()->hasAny(['search', 'service', 'date_from', 'date_to']))
                            <a href="{{ route('admin.appointments.pending') }}" class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold transition flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    @if ($pendingAppointments->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-100 dark:bg-gray-700/50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            @if(request()->hasAny(['search', 'service', 'date_from', 'date_to']))
                                <p class="text-gray-600 dark:text-gray-400 font-semibold text-lg">
                                    No results found
                                </p>
                                <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">Try adjusting your filters or search term</p>
                            @else
                                <p class="text-gray-600 dark:text-gray-400 font-semibold text-lg">
                                    {{ __('messages.appointments_no_slots') }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-500 text-sm mt-2">All appointments have been reviewed</p>
                            @endif
                        </div>
                    @else
                        <!-- Results Summary and Bulk Actions -->
                        <div x-data="{ selectedRequests: [], selectAll: false, showDetails: {} }" 
                             x-init="$watch('selectAll', value => { if(value) { selectedRequests = {{ $pendingAppointments->pluck('id')->toJson() }} } else { selectedRequests = [] } })">
                            
                            <!-- Bulk Actions Bar -->
                            <div x-show="selectedRequests.length > 0" x-transition class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-red-900 dark:text-red-100"><span x-text="selectedRequests.length"></span> {{ __('messages.requests_selected') }}</span>
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="bulkReject()" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('messages.reject_selected') }}
                                    </button>
                                </div>
                            </div>

                            <!-- Summary Bar -->
                            <div class="mb-4 flex items-center justify-between text-sm">
                                <div class="flex items-center gap-4">
                                    <input type="checkbox" x-model="selectAll" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ __('messages.showing') }} {{ $pendingAppointments->count() }} {{ __('messages.of') }} {{ $pendingAppointments->total() }} {{ __('messages.pending_requests') }}
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    <button @click="Object.keys(showDetails).forEach(key => showDetails[key] = true)" class="text-red-600 dark:text-red-400 hover:text-red-700 font-medium">
                                        {{ __('messages.expand_all') }}
                                    </button>
                                    <span class="text-gray-300 dark:text-gray-600">|</span>
                                    <button @click="showDetails = {}" class="text-red-600 dark:text-red-400 hover:text-red-700 font-medium">
                                        {{ __('messages.collapse_all') }}
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-3">
                            @foreach ($pendingAppointments as $appointment)
                                <div x-data="{ expanded: showDetails[{{ $appointment->id }}] ?? false }" 
                                     x-init="$watch('showDetails[{{ $appointment->id }}]', value => expanded = value ?? false)"
                                     class="border-2 border-gray-100 dark:border-gray-700 rounded-xl hover:border-red-200 dark:hover:border-red-900/30 hover:shadow-lg transition-all duration-300 bg-gradient-to-r from-white to-gray-50/50 dark:from-gray-800 dark:to-gray-800/50">
                                    
                                    <!-- Compact Header (Always Visible) -->
                                    <div class="p-4 flex items-center justify-between cursor-pointer" @click="expanded = !expanded; showDetails[{{ $appointment->id }}] = expanded">
                                        <div class="flex items-center gap-3 flex-1">
                                            <input type="checkbox" 
                                                   value="{{ $appointment->id }}" 
                                                   x-model="selectedRequests" 
                                                   @click.stop
                                                   class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            
                                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-2">
                                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                                </svg>
                                            </div>
                                            
                                            <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-2 items-center">
                                                <div>
                                                    <p class="font-bold text-gray-900 dark:text-gray-100">{{ $appointment->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $appointment->created_at->diffForHumans() }}</p>
                                                </div>
                                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $appointment->service }}
                                                </div>
                                                @if($appointment->availableSlot)
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ $appointment->availableSlot->start_time->format('M d, Y') }}
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ $appointment->availableSlot->start_time->format('g:i A') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="flex gap-2">
                                                <button type="button"
                                                    @click.stop="showApproveModal({{ $appointment->id }}, '{{ $appointment->name }}')"
                                                    class="px-4 py-2 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white text-xs rounded-lg transition font-semibold shadow-sm hover:shadow-md">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                                <button type="button"
                                                    @click.stop="showRejectModal({{ $appointment->id }}, '{{ $appointment->name }}')"
                                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-xs rounded-lg transition font-semibold shadow-sm hover:shadow-md">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Expanded Details -->
                                    <div x-show="expanded" x-collapse class="px-4 pb-4 border-t border-gray-200 dark:border-gray-700">
                                        <div class="pt-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                                        <div class="space-y-3">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('messages.email') }}</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->email }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('messages.phone') }}</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->phone }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('messages.vehicle_information') }}</p>
                                                    @if($appointment->vehicle_id && $appointment->vehicleDetails)
                                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->vehicleDetails->full_name }}</p>
                                                    @elseif($appointment->vehicle)
                                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->vehicle }}</p>
                                                    @else
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">No vehicle selected</p>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($appointment->vehicle_id && $appointment->vehicleDetails && $appointment->vehicleDetails->plate)
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h6v4H7V5zm6 6H7v2h6v-2z" clip-rule="evenodd"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('messages.registration') }}</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->vehicleDetails->plate }}</p>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="space-y-3">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('messages.service') }}</p>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->service }}</p>
                                                </div>
                                            </div>
                                            @if($appointment->availableSlot)
                                                <div class="flex items-start">
                                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('messages.slots_date') }}</p>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->availableSlot->start_time->format('M d, Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start">
                                                    <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <div>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold">{{ __('messages.slots_time') }}</p>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $appointment->availableSlot->start_time->format('g:i A') }} - {{ $appointment->availableSlot->end_time->format('g:i A') }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if ($appointment->notes)
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-5">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 text-gray-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide font-semibold mb-1">{{ __('messages.notes') }}</p>
                                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $appointment->notes }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $pendingAppointments->links() }}
                        </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all border border-gray-200 dark:border-gray-700">
            <form id="approveForm" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-t-xl px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-white shadow-md">
                            <svg class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            {{ __('messages.modal_approve_title') }}
                        </h3>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 space-y-5">
                    <p class="text-base text-gray-700 dark:text-gray-300">
                        {{ __('messages.modal_approve_confirm') }} <strong class="text-green-600 dark:text-green-400" id="approveName"></strong>?
                    </p>
                    <div>
                        <label for="approve_admin_notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.admin_notes') }}
                        </label>
                        <textarea 
                            id="approve_admin_notes" 
                            name="admin_notes" 
                            rows="3"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:focus:ring-green-900/30 transition-all duration-200"
                            placeholder="{{ __('messages.placeholder_admin_notes') }}"></textarea>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 rounded-b-xl flex items-center justify-end gap-3">
                    <button 
                        type="button" 
                        onclick="closeApproveModal()" 
                        class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                        {{ __('messages.action_cancel') }}
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('messages.action_approve') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all border border-gray-200 dark:border-gray-700">
            <form id="rejectForm" method="POST">
                @csrf
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl px-6 py-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-white shadow-md">
                            <svg class="h-6 w-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">
                            {{ __('messages.modal_reject_title') }}
                        </h3>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="p-6 space-y-5">
                    <p class="text-base text-gray-700 dark:text-gray-300">
                        {{ __('messages.modal_reject_confirm') }} <strong class="text-red-600 dark:text-red-400" id="rejectName"></strong>?
                    </p>
                    <div>
                        <label for="reject_admin_notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.rejection_reason') }}
                        </label>
                        <textarea 
                            id="reject_admin_notes" 
                            name="admin_notes" 
                            rows="3"
                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                            placeholder="{{ __('messages.placeholder_rejection_reason') }}"></textarea>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 rounded-b-xl flex items-center justify-end gap-3">
                    <button 
                        type="button" 
                        onclick="closeRejectModal()" 
                        class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                        {{ __('messages.action_cancel') }}
                    </button>
                    <button 
                        type="submit" 
                        class="px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        {{ __('messages.action_reject') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showApproveModal(appointmentId, name) {
            document.getElementById('approveName').textContent = name;
            document.getElementById('approveForm').action = `/admin/appointments/pending/${appointmentId}/approve`;
            document.getElementById('approveModal').classList.remove('hidden');
        }

        function closeApproveModal() {
            document.getElementById('approveModal').classList.add('hidden');
        }

        function showRejectModal(appointmentId, name) {
            document.getElementById('rejectName').textContent = name;
            document.getElementById('rejectForm').action = `/admin/appointments/pending/${appointmentId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        function bulkReject() {
            const selectedRequests = Alpine.raw(document.querySelector('[x-data]').__x.$data.selectedRequests);
            
            if (selectedRequests.length === 0) {
                alert('Please select at least one request to reject.');
                return;
            }

            if (!confirm(`Are you sure you want to reject ${selectedRequests.length} request(s)? This action cannot be undone.`)) {
                return;
            }

            // Create a form to submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.appointments.bulk-reject") }}';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'POST';
            form.appendChild(methodInput);

            const idsInput = document.createElement('input');
            idsInput.type = 'hidden';
            idsInput.name = 'appointment_ids';
            idsInput.value = selectedRequests.join(',');
            form.appendChild(idsInput);

            document.body.appendChild(form);
            form.submit();
        }

        // Close modals when clicking outside
        document.getElementById('approveModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeApproveModal();
        });
        
        document.getElementById('rejectModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeRejectModal();
        });
    </script>
</x-app-layout>
