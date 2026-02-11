<section>
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-semibold text-red-800 dark:text-red-200">{{ __('messages.form_errors') }}</h3>
                    <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <!-- Hidden fields for required user data -->
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">

        <!-- Basic Vehicle Information -->
        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-5">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.vehicle_basic_info') }}</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="vehicle_make" :value="__('messages.vehicle_make')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                        </div>
                        <x-text-input id="vehicle_make" name="vehicle_make" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition" :value="old('vehicle_make', $user->vehicle_make)" :placeholder="__('messages.vehicle_make_placeholder')" />
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_make_example') }}</p>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_make')" />
                </div>

                <div>
                    <x-input-label for="vehicle_model" :value="__('messages.vehicle_model')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <x-text-input id="vehicle_model" name="vehicle_model" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition" :value="old('vehicle_model', $user->vehicle_model)" :placeholder="__('messages.vehicle_model_placeholder')" />
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_model_example') }}</p>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_model')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <x-input-label for="vehicle_year" :value="__('messages.vehicle_year')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <x-text-input id="vehicle_year" name="vehicle_year" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition" :value="old('vehicle_year', $user->vehicle_year)" :placeholder="__('messages.vehicle_year_placeholder')" maxlength="4" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_year')" />
                </div>

                <div>
                    <x-input-label for="vehicle_color" :value="__('messages.vehicle_color')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <x-text-input id="vehicle_color" name="vehicle_color" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition" :value="old('vehicle_color', $user->vehicle_color)" :placeholder="__('messages.vehicle_color_placeholder')" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_color')" />
                </div>

                <div>
                    <x-input-label for="vehicle_plate" :value="__('messages.vehicle_plate')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm3 5a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <x-text-input id="vehicle_plate" name="vehicle_plate" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition font-mono uppercase" :value="old('vehicle_plate', $user->vehicle_plate)" :placeholder="__('messages.vehicle_plate_placeholder')" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_plate')" />
                </div>
            </div>
        </div>

        <!-- Technical Specifications -->

        <!-- Technical Specifications -->
        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-5">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.vehicle_technical_specs') }}</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="vehicle_fuel_type" :value="__('messages.vehicle_fuel_type')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <select id="vehicle_fuel_type" name="vehicle_fuel_type" class="pl-10 mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition">
                            <option value="">{{ __('messages.vehicle_select_fuel') }}</option>
                            <option value="petrol" {{ old('vehicle_fuel_type', $user->vehicle_fuel_type) == 'petrol' ? 'selected' : '' }}>⛽ {{ __('messages.vehicle_fuel_petrol') }}</option>
                            <option value="diesel" {{ old('vehicle_fuel_type', $user->vehicle_fuel_type) == 'diesel' ? 'selected' : '' }}>🛢️ {{ __('messages.vehicle_fuel_diesel') }}</option>
                            <option value="electric" {{ old('vehicle_fuel_type', $user->vehicle_fuel_type) == 'electric' ? 'selected' : '' }}>⚡ {{ __('messages.vehicle_fuel_electric') }}</option>
                            <option value="hybrid" {{ old('vehicle_fuel_type', $user->vehicle_fuel_type) == 'hybrid' ? 'selected' : '' }}>🔋 {{ __('messages.vehicle_fuel_hybrid') }}</option>
                        </select>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_fuel_type_hint') }}</p>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_fuel_type')" />
                </div>

                <div>
                    <x-input-label for="vehicle_transmission" :value="__('messages.vehicle_transmission')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                            </svg>
                        </div>
                        <select id="vehicle_transmission" name="vehicle_transmission" class="pl-10 mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition">
                            <option value="">{{ __('messages.vehicle_select_transmission') }}</option>
                            <option value="manual" {{ old('vehicle_transmission', $user->vehicle_transmission) == 'manual' ? 'selected' : '' }}>🎮 {{ __('messages.vehicle_transmission_manual') }}</option>
                            <option value="automatic" {{ old('vehicle_transmission', $user->vehicle_transmission) == 'automatic' ? 'selected' : '' }}>🤖 {{ __('messages.vehicle_transmission_automatic') }}</option>
                            <option value="semi-automatic" {{ old('vehicle_transmission', $user->vehicle_transmission) == 'semi-automatic' ? 'selected' : '' }}>⚙️ {{ __('messages.vehicle_transmission_semi_automatic') }}</option>
                        </select>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_transmission_hint') }}</p>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_transmission')" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <x-input-label for="vehicle_engine_size" :value="__('messages.vehicle_engine_size')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <x-text-input id="vehicle_engine_size" name="vehicle_engine_size" type="text" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition" :value="old('vehicle_engine_size', $user->vehicle_engine_size)" :placeholder="__('messages.vehicle_engine_size_placeholder')" />
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_engine_size_hint') }}</p>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_engine_size')" />
                </div>

                <div>
                    <x-input-label for="vehicle_mileage" :value="__('messages.vehicle_mileage')" class="text-gray-700 dark:text-gray-300 font-medium" />
                    <div class="relative mt-2">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <x-text-input id="vehicle_mileage" name="vehicle_mileage" type="number" class="pl-10 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 dark:focus:border-red-500 dark:focus:ring-red-500 transition" :value="old('vehicle_mileage', $user->vehicle_mileage)" :placeholder="__('messages.vehicle_mileage_placeholder')" min="0" step="1" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">km</span>
                        </div>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_mileage_hint') }}</p>
                    <x-input-error class="mt-2" :messages="$errors->get('vehicle_mileage')" />
                </div>
            </div>
        </div>

        <!-- Additional Notes -->
        <!-- Additional Notes -->
        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center mb-5">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.vehicle_additional_notes') }}</h3>
            </div>
            
            <div>
                <x-input-label for="vehicle_notes" :value="__('messages.vehicle_notes')" class="text-gray-700 dark:text-gray-300 font-medium" />
                <textarea 
                    id="vehicle_notes" 
                    name="vehicle_notes" 
                    rows="5"
                    class="mt-2 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-500 focus:ring-red-500 dark:focus:ring-red-500 rounded-lg shadow-sm transition resize-none"
                    placeholder="{{ __('messages.vehicle_notes_placeholder') }}"
                    maxlength="1000"
                    x-data="{ 
                        count: {{ old('vehicle_notes', $user->vehicle_notes) ? strlen(old('vehicle_notes', $user->vehicle_notes)) : 0 }},
                        max: 1000
                    }"
                    x-on:input="count = $event.target.value.length"
                >{{ old('vehicle_notes', $user->vehicle_notes) }}</textarea>
                <div class="flex justify-between items-center mt-2">
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_notes_hint') }}</p>
                    <span 
                        class="text-xs font-medium"
                        x-data="{ count: {{ old('vehicle_notes', $user->vehicle_notes) ? strlen(old('vehicle_notes', $user->vehicle_notes)) : 0 }} }"
                        x-text="count + ' / 1000'"
                        :class="count > 900 ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400'"
                        @input.window="if ($event.target.id === 'vehicle_notes') count = $event.target.value.length"
                    ></span>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('vehicle_notes')" />
            </div>
        </div>

        <!-- Current Vehicle Summary -->
        @if($user->vehicle_make || $user->vehicle_model)
            <div class="bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 border-2 border-red-200 dark:border-red-800 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center h-14 w-14 rounded-xl bg-red-600 text-white shadow-lg">
                            <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 flex-1">
                        <h4 class="text-base font-bold text-red-900 dark:text-red-100">{{ __('messages.vehicle_currently_saved') }}</h4>
                        <p class="mt-2 text-xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $user->vehicle_year }} {{ $user->vehicle_make }} {{ $user->vehicle_model }}
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2 text-sm">
                            @if($user->vehicle_color)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white dark:bg-gray-800 border border-red-200 dark:border-red-800 text-gray-700 dark:text-gray-300 shadow-sm">
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $user->vehicle_color }}
                                </span>
                            @endif
                            @if($user->vehicle_plate)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white dark:bg-gray-800 border border-red-200 dark:border-red-800 text-gray-700 dark:text-gray-300 font-mono text-sm font-bold shadow-sm">
                                    🚗 {{ $user->vehicle_plate }}
                                </span>
                            @endif
                            @if($user->vehicle_fuel_type)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white dark:bg-gray-800 border border-red-200 dark:border-red-800 text-gray-700 dark:text-gray-300 capitalize shadow-sm">
                                    @if($user->vehicle_fuel_type === 'electric') ⚡
                                    @elseif($user->vehicle_fuel_type === 'hybrid') 🔋
                                    @elseif($user->vehicle_fuel_type === 'diesel') 🛢️
                                    @else ⛽
                                    @endif
                                    {{ $user->vehicle_fuel_type }}
                                </span>
                            @endif
                            @if($user->vehicle_transmission)
                                <span class="inline-flex items-center px-3 py-1 rounded-lg bg-white dark:bg-gray-800 border border-red-200 dark:border-red-800 text-gray-700 dark:text-gray-300 capitalize shadow-sm">
                                    @if($user->vehicle_transmission === 'manual') 🎮
                                    @elseif($user->vehicle_transmission === 'automatic') 🤖
                                    @else ⚙️
                                    @endif
                                    {{ str_replace('-', ' ', $user->vehicle_transmission) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                @if (session('status') === 'profile-updated')
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform scale-90"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-90"
                        x-init="setTimeout(() => show = false, 4000)"
                        class="inline-flex items-center px-4 py-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg"
                    >
                        <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-green-800 dark:text-green-200">{{ __('messages.saved_successfully') }}</span>
                    </div>
                @endif
            </div>

            <x-primary-button class="px-6 py-2.5 shadow-lg hover:shadow-xl transition-all duration-200">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z"/>
                </svg>
                {{ __('messages.vehicle_save') }}
            </x-primary-button>
        </div>
    </form>
</section>
