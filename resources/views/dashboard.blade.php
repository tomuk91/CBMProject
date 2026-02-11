<x-app-layout>
    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="mb-6 sm:mb-8 bg-gradient-to-r from-red-600 to-red-700 rounded-xl sm:rounded-2xl shadow-xl overflow-hidden">
                <div class="px-4 py-6 sm:px-8 sm:py-10">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <div class="bg-white/20 backdrop-blur-sm p-3 sm:p-4 rounded-xl">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-white" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white">
                                {{ __('messages.dashboard_welcome') }}, {{ Auth::user()->name }}!
                            </h1>
                            <p class="text-red-100 mt-1 text-sm sm:text-base lg:text-lg">
                                {{ __('messages.dashboard_subtitle') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
                <!-- Quick Stats -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform hover:shadow-xl transition duration-300 active:scale-95">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                <svg class="h-7 w-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.account_status') }}</h3>
                                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('messages.status_confirmed') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform hover:shadow-xl transition duration-300">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                <svg class="h-7 w-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.member_since') }}</h3>
                                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ Auth::user()->created_at->format('M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform hover:shadow-xl transition duration-300">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                <svg class="h-7 w-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_information') }}</h3>
                                <p class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    @if(Auth::user()->primaryVehicle)
                                        {{ Auth::user()->primaryVehicle->make }}
                                    @else
                                        {{ __('messages.not_set') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Upcoming Appointments -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                    <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.dashboard_my_appointments') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($appointments->count() > 0)
                            <div class="space-y-4">
                                @foreach($appointments as $appointment)
                                    <div class="group relative bg-white dark:bg-gray-700/40 rounded-xl border border-gray-200 dark:border-gray-600 hover:border-red-300 dark:hover:border-red-700 hover:shadow-lg transition-all duration-300 overflow-hidden">
                                        {{-- Status accent bar --}}
                                        <div class="absolute top-0 left-0 right-0 h-1
                                            @if($appointment->status->value === 'confirmed') bg-green-500
                                            @elseif($appointment->status->value === 'pending') bg-amber-500
                                            @elseif($appointment->status->value === 'completed') bg-blue-500
                                            @elseif($appointment->status->value === 'cancelled') bg-red-500
                                            @elseif($appointment->status->value === 'no-show') bg-gray-400
                                            @else bg-gray-300
                                            @endif"></div>

                                        <div class="p-5 pt-6">
                                            {{-- Header: Service name + status badge --}}
                                            <div class="flex items-start justify-between gap-3">
                                                <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 leading-tight">
                                                    {{ $appointment->service }}
                                                </h4>
                                                <span class="flex-shrink-0 inline-flex items-center px-2.5 py-1 text-xs font-bold rounded-full
                                                    @if($appointment->status->value === 'confirmed') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                                    @elseif($appointment->status->value === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400
                                                    @elseif($appointment->status->value === 'completed') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                                    @elseif($appointment->status->value === 'cancelled') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                                    @elseif($appointment->status->value === 'no-show') bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-300
                                                    @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300
                                                    @endif">
                                                    {{ ucfirst(str_replace('-', ' ', $appointment->status->value)) }}
                                                </span>
                                            </div>

                                            {{-- Date/time and vehicle info --}}
                                            <div class="mt-3 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5 text-red-500 dark:text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <span class="font-medium">{{ $appointment->appointment_date->format('M j, Y') }}</span>
                                                </span>
                                                <span class="inline-flex items-center">
                                                    <svg class="w-4 h-4 mr-1.5 text-red-500 dark:text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="font-medium">{{ $appointment->appointment_date->format('g:i A') }}</span>
                                                </span>
                                                @if($appointment->vehicle)
                                                    <span class="inline-flex items-center">
                                                        <svg class="w-4 h-4 mr-1.5 text-red-500 dark:text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span class="font-medium">{{ $appointment->vehicle }}</span>
                                                    </span>
                                                @endif
                                            </div>

                                            @if($appointment->notes)
                                                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800 p-2.5 rounded-lg border border-gray-100 dark:border-gray-700">
                                                    {{ Str::limit($appointment->notes, 120) }}
                                                </div>
                                            @endif

                                            {{-- View Details link --}}
                                            <div class="mt-3">
                                                <a href="{{ route('appointments.details', $appointment) }}" class="inline-flex items-center text-xs font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                    </svg>
                                                    {{ __('messages.appointment_view_details') }}
                                                </a>
                                            </div>

                                            {{-- Cancellation warning --}}
                                            @if($appointment->cancellation_requested)
                                                <div class="mt-3 flex items-center text-xs text-yellow-700 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/20 p-2.5 rounded-lg border border-yellow-200 dark:border-yellow-800">
                                                    <svg class="h-4 w-4 mr-1.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ __('messages.cancellation_requested_on') }} {{ $appointment->cancellation_requested_at->format('M j, Y') }}
                                                </div>
                                            @endif

                                            {{-- Action buttons --}}
                                            @if(!$appointment->cancellation_requested && in_array($appointment->status->value, ['confirmed', 'pending']))
                                                <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-600 flex flex-wrap items-center gap-3">
                                                    @if($appointment->status->value === 'confirmed' && $appointment->appointment_date > now()->addHours(24))
                                                        <button onclick="showCancellationModal({{ $appointment->id }})" class="inline-flex items-center text-xs font-semibold text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition">
                                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                            {{ __('messages.request_cancellation') }}
                                                        </button>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Pagination -->
                            <div class="mt-6">
                                {{ $appointments->links() }}
                            </div>
                        @else
                            <div class="text-center py-16">
                                <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-red-50 dark:bg-red-900/20">
                                    <svg class="h-10 w-10 text-red-400 dark:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="mt-5 text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('messages.dashboard_no_upcoming') }}</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-xs mx-auto">{{ __('messages.dashboard_no_upcoming_desc') }}</p>
                                <div class="mt-6">
                                    <a href="{{ route('appointments.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-xl font-semibold text-sm text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition ease-in-out duration-150 shadow-lg hover:shadow-xl">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        {{ __('messages.appointments_book') }}
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Vehicle Information -->
                @if(Auth::user()->primaryVehicle)
                @php
                    $carImageService = app(\App\Services\CarImageService::class);
                    $primaryVehicle = Auth::user()->primaryVehicle;
                    $carImage = $carImageService->getCarImage($primaryVehicle->make, $primaryVehicle->model, $primaryVehicle->year);
                    $manufacturerLogo = $carImageService->getManufacturerLogo($primaryVehicle->make);
                @endphp
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                    <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            {{ __('messages.vehicle_information') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Car Image -->
                        <div class="mb-6 relative rounded-xl overflow-hidden shadow-lg">
                            @if($primaryVehicle->image)
                                <img src="{{ Storage::disk(config('filesystems.default'))->temporaryUrl($primaryVehicle->image, now()->addHours(1)) }}" alt="{{ $primaryVehicle->make }} {{ $primaryVehicle->model }}" class="w-full h-48 object-cover">
                            @else
                                <img src="{{ $carImage }}" alt="{{ $primaryVehicle->make }} {{ $primaryVehicle->model }}" class="w-full h-48 object-cover">
                            @endif
                            @if($manufacturerLogo)
                            <div class="absolute top-4 right-4 bg-white dark:bg-gray-800 p-3 rounded-lg shadow-lg">
                                <img src="{{ $manufacturerLogo }}" alt="{{ $primaryVehicle->make }}" class="h-8">
                            </div>
                            @endif
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">
                                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 flex-1">
                                <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                                    {{ $primaryVehicle->full_name }}
                                </h4>
                                <dl class="mt-3 text-sm text-gray-500 dark:text-gray-400 space-y-2">
                                    @if($primaryVehicle->color)
                                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                        <dt class="font-medium">{{ __('messages.vehicle_color') }}:</dt>
                                        <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ $primaryVehicle->color }}</dd>
                                    </div>
                                    @endif
                                    @if($primaryVehicle->plate)
                                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                        <dt class="font-medium">{{ __('messages.vehicle_plate') }}:</dt>
                                        <dd class="font-bold text-gray-900 dark:text-gray-100 font-mono">{{ $primaryVehicle->plate }}</dd>
                                    </div>
                                    @endif
                                    @if($primaryVehicle->fuel_type)
                                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                        <dt class="font-medium">{{ __('messages.vehicle_fuel_type') }}:</dt>
                                        <dd class="font-semibold text-gray-900 dark:text-gray-100 capitalize">{{ $primaryVehicle->fuel_type }}</dd>
                                    </div>
                                    @endif
                                    @if($primaryVehicle->transmission)
                                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                        <dt class="font-medium">{{ __('messages.vehicle_transmission') }}:</dt>
                                        <dd class="font-semibold text-gray-900 dark:text-gray-100 capitalize">{{ $primaryVehicle->transmission }}</dd>
                                    </div>
                                    @endif
                                    @if($primaryVehicle->engine_size)
                                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                        <dt class="font-medium">{{ __('messages.vehicle_engine_size') }}:</dt>
                                        <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ $primaryVehicle->engine_size }}</dd>
                                    </div>
                                    @endif
                                    @if($primaryVehicle->mileage)
                                    <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700">
                                        <dt class="font-medium">{{ __('messages.vehicle_mileage') }}:</dt>
                                        <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ number_format((float)$primaryVehicle->mileage) }} km</dd>
                                    </div>
                                    @endif
                                </dl>
                                <div class="mt-5">
                                    <a href="{{ route('vehicles.index') }}" class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 transition">
                                        {{ __('messages.vehicle_update') }}
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                    <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            {{ __('messages.vehicle_information') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                            <p class="mt-4 text-base text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_no_info') }}</p>
                            <div class="mt-6">
                                <a href="{{ route('vehicles.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-semibold text-sm transition shadow-lg">
                                    {{ __('messages.vehicle_add') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Service History -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl lg:col-span-2 border border-gray-100 dark:border-gray-700">
                    <div class="px-6 py-6 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-600">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="bg-red-100 dark:bg-red-900/30 p-3 rounded-xl mr-3">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                        {{ __('messages.service_history') }}
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">{{ __('messages.no_service_history_description') }}</p>
                                </div>
                            </div>
                            @if($serviceHistory->count() > 0)
                                <a href="{{ route('profile.service-history') }}" class="text-sm font-semibold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 flex items-center transition">
                                    {{ __('messages.view_all') }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="p-6">
                        @if($serviceHistory->count() > 0)
                            <div class="space-y-3">
                                @foreach($serviceHistory as $service)
                                    <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-red-300 dark:hover:border-red-700 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                                        <!-- Top accent line -->
                                        <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-green-500 to-emerald-500"></div>
                                        
                                        <div class="flex items-center p-4">
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-600 dark:text-green-400 shadow-md group-hover:scale-105 transition-transform duration-300">
                                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                                    <div class="flex-1">
                                                        <h4 class="text-base font-bold text-gray-900 dark:text-gray-100">{{ $service->service }}</h4>
                                                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-1">
                                                            <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center">
                                                                <svg class="inline w-3.5 h-3.5 mr-1 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                                </svg>
                                                                <span class="font-medium">{{ $service->appointment_date->format('M d, Y') }}</span>
                                                            </p>
                                                            @if($service->vehicle_id && $service->vehicle)
                                                                <p class="text-xs text-gray-600 dark:text-gray-400 flex items-center">
                                                                    <svg class="inline w-3.5 h-3.5 mr-1 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                                                    </svg>
                                                                    <span class="font-medium">{{ $service->vehicle->full_name }}</span>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-400 shadow-sm border border-green-200 dark:border-green-700 mt-2 sm:mt-0 self-start sm:self-auto">
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ __('messages.status_completed') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="mt-4 text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('messages.no_service_history') }}</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.no_service_history_description') }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl lg:col-span-2">
                    <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                            </svg>
                            {{ __('messages.dashboard_quick_actions') }}
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <a href="{{ route('appointments.index') }}" class="group flex flex-col items-center p-6 bg-white dark:bg-gray-700/30 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 border-2 border-gray-200 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-400 hover:shadow-xl transition-all">
                                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition">{{ __('messages.appointments_book') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.appointments_schedule') }}</p>
                                </div>
                            </a>

                            <a href="{{ route('profile.edit') }}" class="group flex flex-col items-center p-6 bg-white dark:bg-gray-700/30 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 border-2 border-gray-200 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-400 hover:shadow-xl transition-all">
                                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                    </svg>
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition">{{ __('messages.profile_edit') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.profile_update_info') }}</p>
                                </div>
                            </a>

                            <a href="{{ route('vehicles.index') }}" class="group flex flex-col items-center p-6 bg-white dark:bg-gray-700/30 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 border-2 border-gray-200 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-400 hover:shadow-xl transition-all">
                                <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                </div>
                                <div class="mt-4 text-center">
                                    <p class="text-base font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition">{{ __('messages.vehicle_manage') }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.vehicle_update_details') }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancellation Request Modal -->
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
                <!-- 24-Hour Policy Notice -->
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
                
                <form id="cancellationForm" method="POST" action="">
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
            const modal = document.getElementById('cancellationModal');
            const form = document.getElementById('cancellationForm');
            form.action = `/appointments/${appointmentId}/request-cancellation`;
            modal.classList.remove('hidden');
        }

        function closeCancellationModal() {
            const modal = document.getElementById('cancellationModal');
            const form = document.getElementById('cancellationForm');
            form.reset();
            modal.classList.add('hidden');
        }

        // Close modal on outside click
        document.getElementById('cancellationModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancellationModal();
            }
        });
    </script>
</x-app-layout>
