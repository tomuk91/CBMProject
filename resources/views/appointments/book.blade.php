<x-app-layout>
    <div class="py-8 bg-gradient-to-br from-gray-50 via-gray-50 to-red-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8">
                <a href="{{ route('appointments.index') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 font-medium transition mb-4 min-h-[44px] active:scale-95">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('messages.action_back') }}
                </a>
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="flex-shrink-0 w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg flex items-center justify-center">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                            {{ __('messages.appointments_book') }}
                        </h1>
                        <p class="mt-1 text-sm sm:text-base text-gray-600 dark:text-gray-400">
                            {{ __('messages.appointments_complete_form') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Form Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Alert Messages -->
                    @if(session('error'))
                        <div class="rounded-xl bg-red-50 dark:bg-red-900/20 p-5 border border-red-200 dark:border-red-800 shadow-sm">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p class="ml-3 text-sm font-medium text-red-800 dark:text-red-200">
                                    {{ session('error') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="rounded-xl bg-red-50 dark:bg-red-900/20 p-5 border border-red-200 dark:border-red-800 shadow-sm">
                            <div class="flex">
                                <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">{{ __('messages.form_errors') }}</p>
                                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Contact Information Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-red-100 dark:from-gray-700 dark:to-gray-700 border-b border-red-100 dark:border-gray-600">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Contact Information</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">How we'll reach you</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <form method="POST" action="{{ route('appointments.store', $slot->id) }}" class="space-y-5">
                                @csrf

                                <!-- Name -->
                                <div>
                                    <label for="name" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ __('messages.profile_name') }} @if(!Auth::user()->name)<span class="text-red-500 ml-1">*</span>@endif
                                    </label>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', Auth::user()->name ?? '') }}" 
                                           {{ Auth::user()->name ? 'readonly' : 'required' }}
                                           inputmode="text"
                                           autocomplete="name"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition shadow-sm hover:border-gray-400 dark:hover:border-gray-500 text-base {{ Auth::user()->name ? 'bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-400 cursor-not-allowed' : '' }}">
                                    @if(Auth::user()->name)
                                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            This information is from your profile and cannot be changed here
                                        </p>
                                    @endif
                                    @error('name')
                                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ __('messages.profile_email') }} @if(!Auth::user()->email)<span class="text-red-500 ml-1">*</span>@endif
                                    </label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', Auth::user()->email ?? '') }}" 
                                           {{ Auth::user()->email ? 'readonly' : 'required' }}
                                           inputmode="email"
                                           autocomplete="email"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition shadow-sm hover:border-gray-400 dark:hover:border-gray-500 text-base {{ Auth::user()->email ? 'bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-400 cursor-not-allowed' : '' }}">
                                    @if(Auth::user()->email)
                                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            This information is from your profile and cannot be changed here
                                        </p>
                                    @endif
                                    @error('email')
                                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        {{ __('messages.profile_phone') }} @if(!Auth::user()->phone)<span class="text-red-500 ml-1">*</span>@endif
                                    </label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', Auth::user()->phone ?? '') }}" 
                                           {{ Auth::user()->phone ? 'readonly' : 'required' }}
                                           placeholder="{{ Auth::user()->phone ? '' : '+36 1 234 5678' }}"
                                           inputmode="tel"
                                           autocomplete="tel"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition shadow-sm hover:border-gray-400 dark:hover:border-gray-500 text-base {{ Auth::user()->phone ? 'bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-400 cursor-not-allowed' : '' }}">
                                    @if(Auth::user()->phone)
                                        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            This information is from your profile and cannot be changed here
                                        </p>
                                    @endif
                                    @error('phone')
                                        <p class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                        </div>
                    </div>

                    <!-- Vehicle & Service Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-red-100 dark:from-gray-700 dark:to-gray-700 border-b border-red-100 dark:border-gray-600">
                            <div class="flex items-center gap-3">
                                <div class="flex-shrink-0 w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center shadow-md">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Vehicle & Service Details</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">What you need serviced</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <!-- Vehicle -->
                            @if(Auth::user()->vehicles->count() > 0)
                            <div>
                                <label for="vehicle_id" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                    {{ __('messages.select_vehicle') }} <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="vehicle_id" 
                                        name="vehicle_id" 
                                        required
                                        onchange="checkVehicleAvailability(this.value)"
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition shadow-sm hover:border-gray-400 dark:hover:border-gray-500">
                                    <option value="">{{ __('messages.select_vehicle_for_appointment') }}</option>
                                    @foreach(Auth::user()->vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" 
                                                {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->full_name }}
                                            @if($vehicle->is_primary) ({{ __('messages.primary') }}) @endif
                                            @if($vehicle->plate) - {{ $vehicle->plate }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div id="vehicle-error" class="hidden mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <span id="vehicle-error-message"></span>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    Don't see your vehicle? 
                                    <button type="button" onclick="openAddVehicleModal()" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-semibold">
                                        {{ __('messages.add_vehicle') }}
                                    </button>
                                </p>
                                @error('vehicle_id')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            @else
                            <div>
                                <label class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                    {{ __('messages.vehicle_information') }} <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="p-5 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-300 dark:border-amber-800 rounded-xl shadow-sm">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <p class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-2">
                                                {{ __('messages.no_vehicles') }}
                                            </p>
                                            <button type="button" onclick="openAddVehicleModal()" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition">
                                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                                                </svg>
                                                {{ __('messages.add_your_first_vehicle') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Service -->
                            <div>
                                <label for="service" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ __('messages.service_required') }} <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="service" 
                                        name="service" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition shadow-sm hover:border-gray-400 dark:hover:border-gray-500">
                                    <option value="">{{ __('messages.service_select') }}</option>
                                    <option value="Oil Change" {{ old('service') == 'Oil Change' ? 'selected' : '' }}>🛢️ {{ __('messages.service_oil_change') }}</option>
                                    <option value="Brake Service" {{ old('service') == 'Brake Service' ? 'selected' : '' }}>🔧 {{ __('messages.service_brake') }}</option>
                                    <option value="Tire Rotation" {{ old('service') == 'Tire Rotation' ? 'selected' : '' }}>🔄 {{ __('messages.service_tire') }}</option>
                                    <option value="General Inspection" {{ old('service') == 'General Inspection' ? 'selected' : '' }}>🔍 {{ __('messages.service_inspection') }}</option>
                                    <option value="Engine Diagnostics" {{ old('service') == 'Engine Diagnostics' ? 'selected' : '' }}>💻 {{ __('messages.service_diagnostics') }}</option>
                                    <option value="Other" {{ old('service') == 'Other' ? 'selected' : '' }}>➕ {{ __('messages.service_other') }}</option>
                                </select>
                                @error('service')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="notes" class="flex items-center text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                    </svg>
                                    {{ __('messages.appointments_notes') }}
                                    <span class="ml-2 text-xs text-gray-500 font-normal">(Optional)</span>
                                </label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="4"
                                          placeholder="{{ __('messages.appointments_notes_placeholder') }}"
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition shadow-sm hover:border-gray-400 dark:hover:border-gray-500">{{ old('notes') }}</textarea>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Let us know about any specific concerns or requests</p>
                                @error('notes')
                                    <p class="mt-1.5 text-sm text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('appointments.index') }}" 
                           class="flex-1 px-6 py-4 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center font-semibold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all border-2 border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500 shadow-sm">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ __('messages.action_cancel') }}
                            </span>
                        </a>
                        <button type="submit" 
                                id="submitButton"
                                class="flex-1 px-6 py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold rounded-xl hover:from-red-700 hover:to-red-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ __('messages.appointments_confirm_booking') }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar Summary -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Selected Slot Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 lg:sticky lg:top-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Your Appointment</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Selected time slot</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Date</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $slot->start_time->format('l, F j, Y') }}</p>
                            </div>
                        </div>
                        
                        <div class="border-t border-gray-200 dark:border-gray-600"></div>
                        
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Time</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $slot->start_time->format('g:i A') }} - {{ $slot->end_time->format('g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-sm text-blue-900 dark:text-blue-200">
                                Fill out the form to confirm your booking. You'll receive a confirmation email once submitted.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-amber-900 dark:text-amber-200 mb-1">Pending Approval</p>
                                <p class="text-sm text-amber-800 dark:text-amber-300">
                                    All bookings require admin approval before confirmation. You will be notified once your appointment is approved.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Card -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white mb-2">Need Help?</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                If you have questions or need to speak with us, feel free to reach out.
                            </p>
                            <div class="space-y-2 text-sm">
                                <a href="tel:+3612345678" class="flex items-center gap-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    +36 1 234 5678
                                </a>
                                <a href="mailto:info@cbmauto.com" class="flex items-center gap-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    info@cbmauto.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('profile.partials.vehicle-modal')
    
    <script>
        let vehicleCheckTimeout = null;
        const submitButton = document.getElementById('submitButton');
        const appointmentForm = submitButton.closest('form');
        
        // Prevent form submission if vehicle is unavailable
        appointmentForm.addEventListener('submit', function(e) {
            const vehicleSelect = document.getElementById('vehicle_id');
            const errorDiv = document.getElementById('vehicle-error');
            
            if (vehicleSelect.value && !errorDiv.classList.contains('hidden')) {
                e.preventDefault();
                alert('{{ __('messages.vehicle_has_outstanding_appointment') }}');
                return false;
            }
        });
        
        function checkVehicleAvailability(vehicleId) {
            const errorDiv = document.getElementById('vehicle-error');
            const errorMessage = document.getElementById('vehicle-error-message');
            
            // Clear any previous timeout
            if (vehicleCheckTimeout) {
                clearTimeout(vehicleCheckTimeout);
            }
            
            // Hide error immediately when changing selection
            errorDiv.classList.add('hidden');
            
            if (!vehicleId) {
                submitButton.disabled = false;
                return;
            }
            
            // Debounce the API call
            vehicleCheckTimeout = setTimeout(() => {
                console.log('Checking vehicle availability for ID:', vehicleId);
                fetch(`/api/check-vehicle-availability/${vehicleId}`)
                    .then(response => {
                        console.log('Response status:', response.status);
                        return response.json();
                    })
                    .then(data => {
                        console.log('API response:', data);
                        if (!data.available) {
                            errorMessage.textContent = data.message;
                            errorDiv.classList.remove('hidden');
                            submitButton.disabled = true;
                        } else {
                            errorDiv.classList.add('hidden');
                            submitButton.disabled = false;
                        }
                    })
                    .catch(error => {
                        console.error('Error checking vehicle availability:', error);
                        submitButton.disabled = false;
                    });
            }, 300);
        }
        
        // Check on page load if vehicle is already selected
        window.addEventListener('DOMContentLoaded', function() {
            const vehicleSelect = document.getElementById('vehicle_id');
            if (vehicleSelect && vehicleSelect.value) {
                checkVehicleAvailability(vehicleSelect.value);
            }
        });
        
        function openAddVehicleModal() {
            document.getElementById('vehicleModalTitle').textContent = '{{ __("messages.add_vehicle") }}';
            document.getElementById('vehicleForm').action = '{{ route("vehicles.store") }}';
            document.getElementById('vehicleMethod').value = 'POST';
            document.getElementById('vehicleForm').reset();
            document.getElementById('vehicleModal').classList.remove('hidden');
        }

        function closeVehicleModal() {
            document.getElementById('vehicleModal').classList.add('hidden');
            document.getElementById('vehicleForm').reset();
        }

        // Reload page after successfully adding a vehicle
        document.getElementById('vehicleForm').addEventListener('submit', function(e) {
            // Form will submit normally, and Laravel will redirect back
            // The vehicle will now be available in the dropdown
        });
    </script>
</x-app-layout>
