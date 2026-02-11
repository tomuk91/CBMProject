<x-app-layout>
    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Back link --}}
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('messages.appointment_back_to_dashboard') }}
                </a>
            </div>

            {{-- Header Card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden mb-6">
                {{-- Status accent bar --}}
                <div class="h-1.5
                    @if($appointment->status->value === 'confirmed') bg-green-500
                    @elseif($appointment->status->value === 'pending') bg-amber-500
                    @elseif($appointment->status->value === 'completed') bg-blue-500
                    @elseif($appointment->status->value === 'cancelled') bg-red-500
                    @elseif($appointment->status->value === 'no-show') bg-gray-400
                    @else bg-gray-300
                    @endif">
                </div>

                <div class="px-6 py-6 sm:px-8 sm:py-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $appointment->service }}
                            </h1>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ __('messages.appointment_id') }}: #{{ $appointment->id }}
                            </p>
                        </div>
                        <span class="self-start sm:self-auto inline-flex items-center px-3.5 py-1.5 text-sm font-bold rounded-full
                            @if($appointment->status->value === 'confirmed') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                            @elseif($appointment->status->value === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                            @elseif($appointment->status->value === 'completed') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                            @elseif($appointment->status->value === 'cancelled') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                            @elseif($appointment->status->value === 'no-show') bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-300
                            @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                            @endif">
                            @if($appointment->status->value === 'pending')
                                {{ __('messages.status_pending') }}
                            @elseif($appointment->status->value === 'confirmed')
                                {{ __('messages.status_confirmed') }}
                            @elseif($appointment->status->value === 'completed')
                                {{ __('messages.status_completed') }}
                            @elseif($appointment->status->value === 'cancelled')
                                {{ __('messages.status_cancelled') }}
                            @elseif($appointment->status->value === 'no-show')
                                {{ __('messages.status_no_show') }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            {{-- Cancellation Request Banner --}}
            @if($appointment->cancellation_requested)
                <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-5">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-bold text-yellow-800 dark:text-yellow-300">
                                {{ __('messages.appointment_cancellation_pending') }}
                            </h3>
                            <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-400">
                                {{ __('messages.appointment_cancellation_pending_desc') }}
                            </p>
                            @if($appointment->cancellation_reason)
                                <div class="mt-3 p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg">
                                    <p class="text-xs font-semibold text-yellow-800 dark:text-yellow-300">{{ __('messages.appointment_cancellation_reason_label') }}:</p>
                                    <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-400">{{ $appointment->cancellation_reason }}</p>
                                </div>
                            @endif
                            @if($appointment->cancellation_requested_at)
                                <p class="mt-2 text-xs text-yellow-600 dark:text-yellow-500">
                                    {{ __('messages.appointment_cancellation_requested_at') }}: {{ $appointment->cancellation_requested_at->format('M j, Y \a\t g:i A') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Service Details --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            {{ __('messages.appointment_service_details') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_service_name') }}</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->service }}</dd>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_date_label') }}</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->appointment_date->format('l, M j, Y') }}</dd>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_time_label') }}</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $appointment->appointment_date->format('g:i A') }}
                                    @if($appointment->appointment_end)
                                        – {{ $appointment->appointment_end->format('g:i A') }}
                                    @endif
                                </dd>
                            </div>
                            @if($appointment->appointment_end)
                                <div class="flex justify-between items-center py-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_duration') }}</dt>
                                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $appointment->appointment_date->diffInMinutes($appointment->appointment_end) }} {{ __('messages.appointment_minutes') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                {{-- Vehicle Information --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            {{ __('messages.appointment_vehicle_info') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($linkedVehicle)
                            <dl class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_vehicle_name') }}</dt>
                                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $linkedVehicle->full_name }}</dd>
                                </div>
                                @if($linkedVehicle->plate)
                                    <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_vehicle_plate') }}</dt>
                                        <dd class="text-sm font-bold font-mono text-gray-900 dark:text-gray-100">{{ $linkedVehicle->plate }}</dd>
                                    </div>
                                @endif
                                @if($linkedVehicle->color)
                                    <div class="flex justify-between items-center py-2">
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_color') }}</dt>
                                        <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100 capitalize">{{ $linkedVehicle->color }}</dd>
                                    </div>
                                @endif
                            </dl>
                        @elseif($appointment->vehicle)
                            {{-- Legacy text-only vehicle field --}}
                            <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                                {{ $appointment->vehicle }}
                            </div>
                        @else
                            <div class="text-center py-6">
                                <svg class="mx-auto h-10 w-10 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.appointment_no_vehicle_linked') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ __('messages.appointment_contact_info') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_contact_name') }}</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->name }}</dd>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_contact_email') }}</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->email }}</dd>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_contact_phone') }}</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->phone }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                {{-- Status Information --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('messages.appointment_status_info') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <dl class="space-y-4">
                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_current_status') }}</dt>
                                <dd>
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full
                                        @if($appointment->status->value === 'confirmed') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                        @elseif($appointment->status->value === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                        @elseif($appointment->status->value === 'completed') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                        @elseif($appointment->status->value === 'cancelled') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                        @elseif($appointment->status->value === 'no-show') bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-300
                                        @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                        @endif">
                                        @if($appointment->status->value === 'pending')
                                            {{ __('messages.status_pending') }}
                                        @elseif($appointment->status->value === 'confirmed')
                                            {{ __('messages.status_confirmed') }}
                                        @elseif($appointment->status->value === 'completed')
                                            {{ __('messages.status_completed') }}
                                        @elseif($appointment->status->value === 'cancelled')
                                            {{ __('messages.status_cancelled') }}
                                        @elseif($appointment->status->value === 'no-show')
                                            {{ __('messages.status_no_show') }}
                                        @endif
                                    </span>
                                </dd>
                            </div>

                            {{-- Status description --}}
                            <div class="py-2 border-b border-gray-100 dark:border-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    @if($appointment->status->value === 'pending')
                                        {{ __('messages.appointment_status_pending_desc') }}
                                    @elseif($appointment->status->value === 'confirmed')
                                        {{ __('messages.appointment_status_confirmed_desc') }}
                                    @elseif($appointment->status->value === 'completed')
                                        {{ __('messages.appointment_status_completed_desc') }}
                                    @elseif($appointment->status->value === 'cancelled')
                                        {{ __('messages.appointment_status_cancelled_desc') }}
                                    @elseif($appointment->status->value === 'no-show')
                                        {{ __('messages.appointment_status_no_show_desc') }}
                                    @endif
                                </p>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_created_at') }}</dt>
                                <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $appointment->created_at->format('M j, Y \a\t g:i A') }}</dd>
                            </div>

                            @if($appointment->booked_by_admin)
                                <div class="flex justify-between items-center py-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.appointment_booked_by_admin') }}</dt>
                                    <dd>
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('messages.appointment_booked_by_admin') }}
                                        </span>
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Notes Section --}}
            @if($appointment->notes)
                <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            {{ __('messages.appointment_notes') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $appointment->notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Admin Notes Section --}}
            @if($appointment->admin_notes)
                <div class="mt-6 bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                    <div class="px-6 py-4 bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ __('messages.appointment_admin_notes') }}
                        </h2>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $appointment->admin_notes }}</p>
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-semibold rounded-xl border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('messages.appointment_back_to_dashboard') }}
                </a>

                @if(!$appointment->cancellation_requested && in_array($appointment->status->value, ['confirmed', 'pending']))
                    @if($appointment->status->value === 'confirmed' && $appointment->appointment_date > now()->addHours(24))
                        <button onclick="showCancellationModal({{ $appointment->id }})" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{ __('messages.request_cancellation') }}
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- Cancellation Request Modal --}}
    @if(!$appointment->cancellation_requested && $appointment->status->value === 'confirmed' && $appointment->appointment_date > now()->addHours(24))
        <div id="cancellationModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
            <div class="relative mx-auto w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700">
                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">{{ __('messages.request_cancellation') }}</h3>
                        <button onclick="closeCancellationModal()" class="text-white hover:text-red-100">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    {{-- 24-Hour Policy Notice --}}
                    <div class="mb-4 p-3 bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">{{ __('messages.cancellation_policy_title') }}</p>
                                <p class="text-xs text-blue-700 dark:text-blue-400 mt-1">{{ __('messages.cancellation_policy_24_hours') }}</p>
                            </div>
                        </div>
                    </div>

                    <form id="cancellationForm" method="POST" action="{{ route('appointments.requestCancellation', $appointment) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.cancellation_reason') }}
                            </label>
                            <textarea
                                id="cancellation_reason"
                                name="cancellation_reason"
                                rows="4"
                                required
                                maxlength="500"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100"
                                placeholder="{{ __('messages.cancellation_reason_placeholder') }}"></textarea>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-end gap-3">
                            <button
                                type="button"
                                onclick="closeCancellationModal()"
                                class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm min-h-[44px]">
                                {{ __('messages.cancel') }}
                            </button>
                            <button
                                type="submit"
                                class="px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg min-h-[44px]">
                                {{ __('messages.request_cancellation') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function showCancellationModal(appointmentId) {
                document.getElementById('cancellationModal').classList.remove('hidden');
            }

            function closeCancellationModal() {
                const modal = document.getElementById('cancellationModal');
                document.getElementById('cancellationForm').reset();
                modal.classList.add('hidden');
            }

            document.getElementById('cancellationModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCancellationModal();
                }
            });
        </script>
    @endif
</x-app-layout>
