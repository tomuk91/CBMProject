<!-- Vehicle Add/Edit Modal -->
<div id="vehicleModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative mx-auto w-full max-w-3xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl px-6 py-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-white shadow-lg">
                        <svg class="h-7 w-7 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                        </svg>
                    </div>
                    <h3 id="vehicleModalTitle" class="text-xl font-bold text-white">{{ __('messages.add_vehicle') }}</h3>
                </div>
                <button onclick="closeVehicleModal()" class="text-white hover:text-red-100 transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Modal Body -->
        <form id="vehicleForm" method="POST" class="p-6 space-y-6">
            @csrf
            <input type="hidden" id="vehicleMethod" name="_method" value="POST">

            <!-- Basic Information -->
            <div>
                <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.basic_information') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="make" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_make') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="make" name="make" required
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                               placeholder="e.g., Toyota">
                    </div>
                    <div>
                        <label for="model" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_model') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="model" name="model" required
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                               placeholder="e.g., Camry">
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_year') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="year" name="year" required maxlength="4"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                               placeholder="e.g., 2020">
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div>
                <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.additional_details') }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="color" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_color') }}
                        </label>
                        <input type="text" id="color" name="color"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                               placeholder="e.g., Silver">
                    </div>
                    <div>
                        <label for="plate" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_plate') }}
                        </label>
                        <input type="text" id="plate" name="plate"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                               placeholder="e.g., ABC-123">
                    </div>
                    <div>
                        <label for="fuel_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_fuel_type') }}
                        </label>
                        <select id="fuel_type" name="fuel_type"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                            <option value="">{{ __('messages.vehicle_select_fuel') }}</option>
                            <option value="petrol">{{ __('messages.vehicle_fuel_petrol') }}</option>
                            <option value="diesel">{{ __('messages.vehicle_fuel_diesel') }}</option>
                            <option value="electric">{{ __('messages.vehicle_fuel_electric') }}</option>
                            <option value="hybrid">{{ __('messages.vehicle_fuel_hybrid') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="transmission" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_transmission') }}
                        </label>
                        <select id="transmission" name="transmission"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                            <option value="">{{ __('messages.vehicle_select_transmission') }}</option>
                            <option value="manual">{{ __('messages.vehicle_transmission_manual') }}</option>
                            <option value="automatic">{{ __('messages.vehicle_transmission_automatic') }}</option>
                            <option value="semi_automatic">{{ __('messages.vehicle_transmission_semi_automatic') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="engine_size" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_engine_size') }}
                        </label>
                        <input type="text" id="engine_size" name="engine_size"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                               placeholder="e.g., 2.0L">
                    </div>
                    <div>
                        <label for="mileage" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.vehicle_mileage') }}
                        </label>
                        <input type="text" id="mileage" name="mileage"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                               placeholder="e.g., 50000">
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('messages.vehicle_notes') }}
                </label>
                <textarea id="notes" name="notes" rows="3"
                          class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                          placeholder="{{ __('messages.vehicle_notes_placeholder') }}"></textarea>
            </div>

            <!-- Primary Vehicle Checkbox -->
            <div class="flex items-center">
                <input type="checkbox" id="is_primary" name="is_primary" value="1"
                       class="h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                <label for="is_primary" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                    {{ __('messages.set_as_primary_vehicle') }}
                </label>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="closeVehicleModal()"
                        class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                    {{ __('messages.action_cancel') }}
                </button>
                <button type="submit"
                        class="px-6 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('messages.vehicle_save') }}
                </button>
            </div>
        </form>
    </div>
</div>
