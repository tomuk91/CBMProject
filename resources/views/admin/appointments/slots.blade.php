<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.slots_title') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.appointments.pending') }}" class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm px-5 py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('messages.admin_pending_requests') }}
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

            <!-- Create New Slot Form -->
            <div x-data="{ expanded: {{ $errors->any() || old('start_date') ? 'true' : 'false' }} }" class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div @click="expanded = !expanded" class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 cursor-pointer hover:from-red-700 hover:to-red-800 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                                </svg>
                                {{ __('messages.slots_create') }}
                            </h3>
                            <p class="text-red-100 text-sm mt-1">Create single or multiple slots using bulk patterns</p>
                        </div>
                        <div class="ml-4 p-2 rounded-lg bg-red-700/50 text-white">
                            <svg x-show="!expanded" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                            <svg x-show="expanded" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div x-show="expanded" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="p-6">
                    <form method="POST" action="{{ route('admin.appointments.slots.store') }}" id="slotForm" class="space-y-8">
                        @csrf
                        
                        <!-- Creation Mode Selection -->
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <label class="block text-base font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.create_slot_question') }}
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 border-2 border-transparent has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20">
                                    <input type="radio" name="bulk_type" value="single" {{ old('bulk_type', 'single') == 'single' ? 'checked' : '' }} class="creation-mode text-red-600 focus:ring-red-500" data-mode="single">
                                    <span class="ml-3 text-gray-900 dark:text-gray-100">📌 <strong>{{ __('messages.create_mode_single') }}</strong> - <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.create_mode_single_desc') }}</span></span>
                                </label>
                                <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 border-2 border-transparent has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20">
                                    <input type="radio" name="bulk_type" value="daily" {{ old('bulk_type') == 'daily' ? 'checked' : '' }} class="creation-mode text-red-600 focus:ring-red-500" data-mode="daily">
                                    <span class="ml-3 text-gray-900 dark:text-gray-100">📅 <strong>{{ __('messages.create_mode_daily') }}</strong> - <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.create_mode_daily_desc') }}</span></span>
                                </label>
                                <label class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 border-2 border-transparent has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20">
                                    <input type="radio" name="bulk_type" value="weekly" {{ old('bulk_type') == 'weekly' ? 'checked' : '' }} class="creation-mode text-red-600 focus:ring-red-500" data-mode="weekly">
                                    <span class="ml-3 text-gray-900 dark:text-gray-100">🔄 <strong>{{ __('messages.create_mode_weekly') }}</strong> - <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.create_mode_weekly_desc') }}</span></span>
                                </label>
                            </div>
                        </div>

                        <!-- Basic Information (shown for all modes) -->
                        <div>
                            <h4 class="text-base font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                Basic Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.create_start_date') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="date" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="{{ old('start_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required
                                           class="w-full px-4 py-3 rounded-lg border-2 @error('start_date') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                @php
                                    $oldTime = old('start_time', '09:00');
                                    $timeParts = explode(':', $oldTime);
                                    $oldHour = $timeParts[0] ?? '09';
                                    $oldMinute = $timeParts[1] ?? '00';
                                @endphp
                                <div x-data="{ 
                                    hour: '{{ $oldHour }}', 
                                    minute: '{{ $oldMinute }}',
                                    updateTime() {
                                        document.getElementById('start_time').value = this.hour + ':' + this.minute;
                                    }
                                }" x-init="updateTime()">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.create_start_time') }} <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <select x-model="hour" 
                                                    @change="updateTime()"
                                                    class="w-full px-4 py-3 rounded-lg border-2 @error('start_time') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                                @for($h = 0; $h < 24; $h++)
                                                    <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}">{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="flex items-center justify-center text-2xl font-bold text-gray-500 dark:text-gray-400">
                                            :
                                        </div>
                                        <div class="flex-1">
                                            <select x-model="minute" 
                                                    @change="updateTime()"
                                                    class="w-full px-4 py-3 rounded-lg border-2 @error('start_time') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                                <option value="00">00</option>
                                                <option value="15">15</option>
                                                <option value="30">30</option>
                                                <option value="45">45</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="start_time" name="start_time" value="{{ old('start_time', '09:00') }}" required>
                                    @error('start_time')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="duration" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.create_duration') }} <span class="text-red-600">*</span>
                                    </label>
                                    <select id="duration" 
                                            name="duration" 
                                            required
                                            class="w-full px-4 py-3 rounded-lg border-2 @error('duration') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                        <option value="30" {{ old('duration') == '30' ? 'selected' : '' }}>30 minutes</option>
                                        <option value="60" {{ old('duration', '60') == '60' ? 'selected' : '' }}>1 hour</option>
                                        <option value="90" {{ old('duration') == '90' ? 'selected' : '' }}>1.5 hours</option>
                                        <option value="120" {{ old('duration') == '120' ? 'selected' : '' }}>2 hours</option>
                                    </select>
                                    @error('duration')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Daily/Weekly Specific Fields -->
                        <div id="bulkOptions" class="space-y-4 hidden">
                            <!-- Days Selection (for daily/weekly patterns) -->
                            <div id="daysSelection" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('messages.create_select_days') }} <span class="text-red-600">*</span>
                                </label>
                                <div class="grid grid-cols-7 gap-2">
                                    <label class="flex flex-col items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                        <input type="checkbox" name="selected_days[]" value="1" {{ is_array(old('selected_days')) && in_array('1', old('selected_days')) ? 'checked' : '' }} class="mb-1 text-red-600 focus:ring-red-500">
                                        <span class="text-xs font-semibold">{{ __('messages.day_monday') }}</span>
                                    </label>
                                    <label class="flex flex-col items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                        <input type="checkbox" name="selected_days[]" value="2" {{ is_array(old('selected_days')) && in_array('2', old('selected_days')) ? 'checked' : '' }} class="mb-1 text-red-600 focus:ring-red-500">
                                        <span class="text-xs font-semibold">{{ __('messages.day_tuesday') }}</span>
                                    </label>
                                    <label class="flex flex-col items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                        <input type="checkbox" name="selected_days[]" value="3" {{ is_array(old('selected_days')) && in_array('3', old('selected_days')) ? 'checked' : '' }} class="mb-1 text-red-600 focus:ring-red-500">
                                        <span class="text-xs font-semibold">{{ __('messages.day_wednesday') }}</span>
                                    </label>
                                    <label class="flex flex-col items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                        <input type="checkbox" name="selected_days[]" value="4" {{ is_array(old('selected_days')) && in_array('4', old('selected_days')) ? 'checked' : '' }} class="mb-1 text-red-600 focus:ring-red-500">
                                        <span class="text-xs font-semibold">{{ __('messages.day_thursday') }}</span>
                                    </label>
                                    <label class="flex flex-col items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                        <input type="checkbox" name="selected_days[]" value="5" {{ is_array(old('selected_days')) && in_array('5', old('selected_days')) ? 'checked' : '' }} class="mb-1 text-red-600 focus:ring-red-500">
                                        <span class="text-xs font-semibold">{{ __('messages.day_friday') }}</span>
                                    </label>
                                    <label class="flex flex-col items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                        <input type="checkbox" name="selected_days[]" value="6" {{ is_array(old('selected_days')) && in_array('6', old('selected_days')) ? 'checked' : '' }} class="mb-1 text-red-600 focus:ring-red-500">
                                        <span class="text-xs font-semibold">{{ __('messages.day_saturday') }}</span>
                                    </label>
                                    <label class="flex flex-col items-center p-3 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                        <input type="checkbox" name="selected_days[]" value="0" {{ is_array(old('selected_days')) && in_array('0', old('selected_days')) ? 'checked' : '' }} class="mb-1 text-red-600 focus:ring-red-500">
                                        <span class="text-xs font-semibold">{{ __('messages.day_sunday') }}</span>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Select which days to create slots on</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="bulk_count" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span id="countLabel">Number of Slots</span> <span class="text-red-600">*</span>
                                    </label>
                                    <input type="number" 
                                           id="bulk_count" 
                                           name="bulk_count" 
                                           value="{{ old('bulk_count') }}"
                                           min="1" 
                                           max="30"
                                           class="w-full px-4 py-3 rounded-lg border-2 @error('bulk_count') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                                           placeholder="e.g., 4">
                                    @error('bulk_count')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" id="countHelp"></p>
                                </div>
                                <div>
                                    <label for="bulk_interval" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span id="intervalLabel">Interval (minutes)</span> <span class="text-red-600">*</span>
                                    </label>
                                    <input type="number" 
                                           id="bulk_interval" 
                                           name="bulk_interval" 
                                           value="{{ old('bulk_interval') }}"
                                           min="0" 
                                           max="480"
                                           class="w-full px-4 py-3 rounded-lg border-2 @error('bulk_interval') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                                           placeholder="e.g., 60 (1 hour gap)">
                                    @error('bulk_interval')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2" id="intervalHelp"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Preview -->
                        <div id="previewSection" class="hidden bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-900/30 rounded-xl p-5">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-bold text-red-900 dark:text-red-300 mb-2">📋 Preview:</p>
                                    <p id="previewText" class="text-sm text-red-800 dark:text-red-200"></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <input type="hidden" name="force_create" id="force_create" value="0">
                            <button type="submit" 
                                    class="flex-1 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-6 py-3 rounded-lg transition-all duration-300 font-bold shadow-sm hover:shadow-md flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.create_submit') }}
                            </button>
                            <button type="reset" 
                                    class="px-8 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-all duration-300 font-semibold">
                                {{ __('messages.slots_clear') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                const creationModeRadios = document.querySelectorAll('.creation-mode');
                const bulkOptions = document.getElementById('bulkOptions');
                const previewSection = document.getElementById('previewSection');
                const form = document.getElementById('slotForm');

                // Update UI based on selected mode
                function updateUI() {
                    const mode = document.querySelector('.creation-mode:checked').value;
                    const daysSelection = document.getElementById('daysSelection');
                    
                    // Show/hide bulk options
                    if (mode === 'single') {
                        bulkOptions.classList.add('hidden');
                        daysSelection.classList.add('hidden');
                        previewSection.classList.add('hidden');
                        document.getElementById('bulk_count').removeAttribute('required');
                        document.getElementById('bulk_interval').removeAttribute('required');
                    } else {
                        bulkOptions.classList.remove('hidden');
                        daysSelection.classList.remove('hidden');
                        previewSection.classList.remove('hidden');
                        document.getElementById('bulk_count').setAttribute('required', 'required');
                        document.getElementById('bulk_interval').setAttribute('required', 'required');

                        // Update labels based on mode
                        if (mode === 'daily') {
                            document.getElementById('countLabel').textContent = 'Number of Slots (per day)';
                            document.getElementById('countHelp').textContent = 'How many slots on each selected day';
                            document.getElementById('intervalLabel').textContent = 'Gap Between Slots (minutes)';
                            document.getElementById('intervalHelp').textContent = 'Minutes between when one slot ends and the next begins (e.g., 60 = 1-hour gap)';
                        } else if (mode === 'weekly') {
                            document.getElementById('countLabel').textContent = 'Number of Weeks';
                            document.getElementById('countHelp').textContent = 'How many weeks to repeat this slot';
                            document.getElementById('intervalLabel').textContent = 'Interval (ignored for weekly)';
                            document.getElementById('intervalHelp').textContent = 'Set to any value; slots will repeat weekly on the same day/time';
                        }
                    }

                    updatePreview();
                }

                // Update preview text
                function updatePreview() {
                    const mode = document.querySelector('.creation-mode:checked').value;
                    const date = document.getElementById('start_date').value;
                    const time = document.getElementById('start_time').value;
                    const duration = document.getElementById('duration').value;
                    const count = document.getElementById('bulk_count').value || '?';
                    const interval = document.getElementById('bulk_interval').value || '?';
                    
                    // Get selected days
                    const selectedDays = Array.from(document.querySelectorAll('input[name="selected_days[]"]:checked'))
                        .map(cb => {
                            const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                            return dayNames[parseInt(cb.value)];
                        });

                    let preview = '';
                    if (mode === 'single' && date && time && duration) {
                        const dateObj = new Date(date);
                        const dateStr = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        preview = `Will create 1 slot on ${dateStr} at ${time} for ${duration} minutes`;
                    } else if (mode === 'daily' && date && time && duration && count && interval && selectedDays.length > 0) {
                        const dateObj = new Date(date);
                        const dateStr = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const daysStr = selectedDays.join(', ');
                        preview = `Will create ${count} slots on ${daysStr} starting ${dateStr} at ${time}, spaced ${interval} minutes apart per day`;
                    } else if (mode === 'weekly' && date && time && duration && count && selectedDays.length > 0) {
                        const dateObj = new Date(date);
                        const dateStr = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const daysStr = selectedDays.join(', ');
                        preview = `Will create ${count} recurring slots every ${daysStr} at ${time} for ${duration} minutes, starting ${dateStr}`;
                    }

                    if (preview) {
                        document.getElementById('previewText').textContent = preview;
                    }
                }

                // Event listeners
                creationModeRadios.forEach(radio => {
                    radio.addEventListener('change', updateUI);
                });

                document.getElementById('start_date').addEventListener('change', updatePreview);
                document.getElementById('start_time').addEventListener('change', updatePreview);
                document.getElementById('duration').addEventListener('change', updatePreview);
                document.getElementById('bulk_count').addEventListener('input', updatePreview);
                document.getElementById('bulk_interval').addEventListener('input', updatePreview);
                
                // Add listeners for day checkboxes
                document.querySelectorAll('input[name="selected_days[]"]').forEach(checkbox => {
                    checkbox.addEventListener('change', updatePreview);
                });

                // Initialize UI on page load (in case of validation errors with old values)
                updateUI();

                // Form submission with conflict check
                form.addEventListener('submit', async function(e) {
                    const forceCreate = document.getElementById('force_create').value;
                    
                    // Skip check if already confirmed
                    if (forceCreate === '1') {
                        return true;
                    }
                    
                    e.preventDefault();
                    
                    // Gather form data
                    const formData = new FormData(form);
                    
                    // Check for conflicts via AJAX
                    try {
                        const response = await fetch('{{ route('admin.slots.check-conflicts') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            },
                            body: formData
                        });
                        
                        const data = await response.json();
                        
                        if (data.has_conflicts) {
                            // Show conflict warning modal
                            showConflictModal(data.conflicts, data.will_create);
                        } else {
                            // No conflicts, submit form
                            form.submit();
                        }
                    } catch (error) {
                        console.error('Error checking conflicts:', error);
                        // On error, allow submission
                        form.submit();
                    }
                });
                
                function showConflictModal(conflicts, willCreate) {
                    const modal = document.getElementById('conflictModal');
                    const conflictList = document.getElementById('conflictList');
                    const willCreateText = document.getElementById('willCreateText');
                    
                    // Build conflict list with modern styling
                    conflictList.innerHTML = conflicts.map(conflict => `
                        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-3 rounded-r-lg hover:shadow-md transition-shadow">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                                        <svg class="h-4 w-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-bold text-red-900 dark:text-red-200">${conflict.date}</p>
                                    <div class="mt-1 text-xs text-red-700 dark:text-red-300 space-y-1">
                                        <div class="flex items-center">
                                            <span class="font-medium min-w-[80px]">New slot:</span>
                                            <span>${conflict.new_start} - ${conflict.new_end}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="font-medium min-w-[80px]">Existing:</span>
                                            <span>${conflict.existing_start} - ${conflict.existing_end}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `).join('');
                    
                    willCreateText.textContent = willCreate > 0 
                        ? `${willCreate} non-conflicting slot(s) can still be created.`
                        : 'No slots can be created without conflicts.';
                    
                    modal.classList.remove('hidden');
                }

                // Initial UI setup
                updateUI();
            </script>

            <!-- Conflict Warning Modal -->
            <div id="conflictModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
                <div class="relative mx-auto w-full max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all border border-gray-200 dark:border-gray-700">
                    <!-- Modal Header with Gradient -->
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-t-xl px-6 py-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-white shadow-lg">
                                <svg class="h-7 w-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">
                                    Slot Conflicts Detected
                                </h3>
                                <p class="text-amber-100 text-sm mt-0.5">Some time slots overlap with existing ones</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            The following time slots overlap with existing slots:
                        </p>
                        
                        <!-- Conflicts List -->
                        <div id="conflictList" class="space-y-2 mb-5 max-h-80 overflow-y-auto pr-2">
                            <!-- Conflicts will be inserted here -->
                        </div>
                        
                        <!-- Summary Box -->
                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-r-lg mb-5">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p id="willCreateText" class="text-sm font-medium text-blue-900 dark:text-blue-200">
                                    <!-- Summary text -->
                                </p>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                            Would you like to proceed and create only the non-conflicting slots?
                        </p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 rounded-b-xl flex items-center justify-end gap-3">
                        <button id="cancelConflict" type="button"
                                class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                            Cancel
                        </button>
                        <button id="confirmConflict" type="button"
                                class="px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            Proceed Anyway
                        </button>
                    </div>
                </div>
            </div>

            <script>
                // Modal event listeners - must be after modal HTML
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('slotForm');
                    const modal = document.getElementById('conflictModal');
                    
                    // Modal close handlers
                    document.getElementById('cancelConflict').addEventListener('click', function() {
                        modal.classList.add('hidden');
                        // Reset force_create flag
                        document.getElementById('force_create').value = '0';
                    });
                    
                    document.getElementById('confirmConflict').addEventListener('click', function() {
                        document.getElementById('force_create').value = '1';
                        modal.classList.add('hidden');
                        form.submit();
                    });
                    
                    // Close modal on backdrop click
                    modal.addEventListener('click', function(e) {
                        if (e.target === modal) {
                            modal.classList.add('hidden');
                            document.getElementById('force_create').value = '0';
                        }
                    });
                });
            </script>

            <!-- Available Slots List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.slots_all') }}
                        </h3>
                        <div class="text-red-100 text-sm font-semibold bg-red-700/30 px-4 py-1.5 rounded-full">
                            {{ __('messages.slots_total') }}: {{ $slots->total() }}
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="p-6 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('admin.appointments.slots') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <label for="filter_date_from" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                From Date
                            </label>
                            <input type="date" 
                                   id="filter_date_from" 
                                   name="filter_date_from" 
                                   value="{{ request('filter_date_from') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-sm">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="filter_date_to" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                To Date
                            </label>
                            <input type="date" 
                                   id="filter_date_to" 
                                   name="filter_date_to" 
                                   value="{{ request('filter_date_to') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-sm">
                        </div>
                        <div class="flex-1 min-w-[200px]">
                            <label for="filter_status" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.slots_filter_status') }}
                            </label>
                            <select id="filter_status" 
                                    name="filter_status"
                                    class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-sm">
                                <option value="">{{ __('messages.all') }}</option>
                                <option value="available" {{ request('filter_status') === 'available' ? 'selected' : '' }}>{{ __('messages.status_available') }}</option>
                                <option value="pending" {{ request('filter_status') === 'pending' ? 'selected' : '' }}>{{ __('messages.status_pending') }}</option>
                                <option value="booked" {{ request('filter_status') === 'booked' ? 'selected' : '' }}>{{ __('messages.status_booked') }}</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg transition-all duration-200 text-sm font-semibold shadow-sm hover:shadow-md flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.slots_apply_filters') }}
                            </button>
                            <a href="{{ route('admin.appointments.slots') }}" 
                               class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200 text-sm font-semibold shadow-sm flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.slots_clear') }}
                            </a>
                        </div>
                    </form>
                </div>

                <div class="p-6">
                    @if ($slots->isEmpty())
                        <div class="text-center py-12">
                            <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 font-medium">No time slots created yet.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500">Create your first slot using the form above.</p>
                        </div>
                    @else
                        <!-- Bulk Actions Bar -->
                        <div x-data="{ selectedSlots: [], selectAll: false }" x-init="$watch('selectAll', value => { if(value) { selectedSlots = [...document.querySelectorAll('.slot-checkbox:not(:disabled)')].map(cb => cb.value) } else { selectedSlots = [] } })">
                            <div x-show="selectedSlots.length > 0" x-transition class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-red-900 dark:text-red-100"><span x-text="selectedSlots.length"></span> slot(s) selected</span>
                                </div>
                                <form method="POST" action="{{ route('admin.appointments.slots.bulk-delete') }}" onsubmit="return confirm('Are you sure you want to delete the selected slots? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="slot_ids" x-model="selectedSlots.join(',')">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        Delete Selected
                                    </button>
                                </form>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                                        <tr>
                                            <th class="px-6 py-3.5 w-12">
                                                <input type="checkbox" x-model="selectAll" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            </th>
                                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <a href="{{ route('admin.appointments.slots', array_merge(request()->all(), ['sort' => 'date', 'direction' => request('sort') === 'date' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="flex items-center space-x-1 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                                <span>{{ __('messages.slots_date') }}</span>
                                                @if(request('sort') === 'date')
                                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                        @if(request('direction') === 'asc')
                                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                                        @else
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <a href="{{ route('admin.appointments.slots', array_merge(request()->all(), ['sort' => 'time', 'direction' => request('sort') === 'time' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="flex items-center space-x-1 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                                <span>{{ __('messages.slots_time') }}</span>
                                                @if(request('sort') === 'time')
                                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                        @if(request('direction') === 'asc')
                                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                                        @else
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.slots_duration') }}</th>
                                        <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                            <a href="{{ route('admin.appointments.slots', array_merge(request()->all(), ['sort' => 'status', 'direction' => request('sort') === 'status' && request('direction') === 'asc' ? 'desc' : 'asc'])) }}" 
                                               class="flex items-center space-x-1 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                                <span>{{ __('messages.slots_status') }}</span>
                                                @if(request('sort') === 'status')
                                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                        @if(request('direction') === 'asc')
                                                            <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"/>
                                                        @else
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        @endif
                                                    </svg>
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-6 py-3.5 text-right text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.slots_actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($slots as $slot)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4 w-12">
                                                @if($slot->status === 'available')
                                                    <input type="checkbox" value="{{ $slot->id }}" x-model="selectedSlots" class="slot-checkbox w-4 h-4 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                                @else
                                                    <input type="checkbox" disabled class="slot-checkbox w-4 h-4 text-gray-400 bg-gray-100 border-gray-300 rounded cursor-not-allowed dark:bg-gray-700 dark:border-gray-600">
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $slot->start_time->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                <div class="flex items-center">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $slot->start_time->format('g:i A') }} - {{ $slot->end_time->format('g:i A') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ $slot->start_time->diffInMinutes($slot->end_time) }} min
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                                    @if($slot->status === 'available') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-600/20
                                                    @elseif($slot->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-yellow-600/20
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400 ring-1 ring-gray-600/20
                                                    @endif">
                                                    @if($slot->status === 'available')
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @endif
                                                    {{ ucfirst($slot->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-3">
                                                    @if($slot->status === 'available')
                                                        <button type="button" 
                                                                onclick="openBookingModal({{ $slot->id }}, '{{ $slot->start_time->format('M d, Y') }}', '{{ $slot->start_time->format('g:i A') }} - {{ $slot->end_time->format('g:i A') }}')"
                                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-xs font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                                            </svg>
                                                            {{ __('messages.slots_book') }}
                                                        </button>
                                                        <form method="POST" action="{{ route('admin.appointments.slots.destroy', $slot) }}" 
                                                              onsubmit="return confirm('Are you sure you want to delete this slot?');"
                                                              class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-red-100 dark:bg-gray-700 dark:hover:bg-red-900/30 text-gray-700 hover:text-red-700 dark:text-gray-300 dark:hover:text-red-400 text-xs font-semibold rounded-lg transition-all duration-200 border border-gray-300 dark:border-gray-600 hover:border-red-300 dark:hover:border-red-700">
                                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                                </svg>
                                                                {{ __('messages.action_delete') }}
                                                            </button>
                                                        </form>
                                                    @else
                                                        <span class="text-gray-400 dark:text-gray-600 text-xs italic">No actions available</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>

                            <div class="mt-4">
                                {{ $slots->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Book Appointment Modal -->
            <div id="bookingModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
                <div class="relative mx-auto w-full max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all border border-gray-200 dark:border-gray-700">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl px-6 py-5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-white shadow-lg">
                                    <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ __('messages.book_appointment') }}</h3>
                                    <p class="text-red-100 text-sm mt-0.5" id="modalSlotInfo"></p>
                                </div>
                            </div>
                            <button onclick="closeBookingModal()" class="text-white hover:text-red-100 transition-colors">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <form id="bookingForm" method="POST" action="" class="p-6 space-y-6">
                        @csrf
                        <input type="hidden" name="slot_id" id="booking_slot_id">

                        <!-- Client Type Selection -->
                        <div>
                            <label class="block text-sm font-bold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                {{ __('messages.book_client_type') }}
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                    <input type="radio" name="client_type" value="existing" checked class="text-red-600 focus:ring-red-500 mr-3" onchange="toggleClientFields()">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.book_existing_client') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Select from registered users</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                    <input type="radio" name="client_type" value="new" class="text-red-600 focus:ring-red-500 mr-3" onchange="toggleClientFields()">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.book_new_client') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Register over phone</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Existing Client Selection -->
                        <div id="existingClientFields">
                            <label for="client_search" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.book_search_client') }} <span class="text-red-600">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       id="client_search" 
                                       placeholder="Type name or email to search..."
                                       autocomplete="off"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                <input type="hidden" name="user_id" id="user_id">
                                
                                <!-- Search Results Dropdown -->
                                <div id="client_results" class="hidden absolute z-10 w-full mt-2 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-700 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                                    <div id="results_list" class="py-1">
                                        <!-- Results will be inserted here -->
                                    </div>
                                </div>
                                
                                <!-- Selected Client Display -->
                                <div id="selected_client" class="hidden mt-3 p-4 bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-red-900 dark:text-red-200" id="selected_client_name"></p>
                                            <p class="text-sm text-red-700 dark:text-red-300" id="selected_client_email"></p>
                                        </div>
                                        <button type="button" onclick="clearClientSelection()" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Vehicle Selection for Existing Client -->
                            <div id="client_vehicles_section" class="hidden mt-4">
                                <label for="client_vehicle_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Select Vehicle <span class="text-red-600">*</span>
                                </label>
                                <select id="client_vehicle_id" name="vehicle_id" class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                    <option value="">Select a vehicle...</option>
                                </select>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" id="vehicle_selection_hint">
                                    The client doesn't have any vehicles registered. Vehicle information fields will be shown below.
                                </p>
                            </div>

                            <!-- Manual Vehicle Entry for Existing Client (when no vehicles available) -->
                            <div id="manual_vehicle_entry" class="hidden mt-4">
                                <label for="manual_vehicle" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Vehicle Information <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="manual_vehicle" name="vehicle"
                                       placeholder="e.g., 2020 Honda Civic (ABC123)"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                            </div>

                            <!-- Service Selection for Existing Client -->
                            <div id="client_service_section" class="hidden mt-4">
                                <label for="existing_service" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Service <span class="text-red-600">*</span>
                                </label>
                                <select id="existing_service" name="service" class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                    <option value="">Select a service...</option>
                                    <option value="General Inspection">General Inspection</option>
                                    <option value="Oil Change">Oil Change</option>
                                    <option value="Brake Service">Brake Service</option>
                                    <option value="Tire Service">Tire Service</option>
                                    <option value="Engine Diagnostics">Engine Diagnostics</option>
                                    <option value="Transmission Service">Transmission Service</option>
                                    <option value="Air Conditioning">Air Conditioning</option>
                                    <option value="Battery Service">Battery Service</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- New Client Fields -->
                        <div id="newClientFields" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="new_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.book_client_name') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" id="new_name" name="new_name"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="new_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.book_client_email') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="email" id="new_email" name="new_email"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="new_phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.book_client_phone') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="tel" id="new_phone" name="new_phone"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="new_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.book_temp_password') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" id="new_password" name="new_password" value="{{ Str::random(8) }}"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle and Service Information -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6" id="new_client_vehicle_service">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="new_vehicle" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Vehicle <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" id="new_vehicle" name="new_vehicle" required
                                           placeholder="e.g., 2020 Honda Civic (ABC123)"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="new_service" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        Service <span class="text-red-600">*</span>
                                    </label>
                                    <select id="new_service" name="service" required
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                        <option value="">Select a service...</option>
                                        <option value="General Inspection">General Inspection</option>
                                        <option value="Oil Change">Oil Change</option>
                                        <option value="Brake Service">Brake Service</option>
                                        <option value="Tire Service">Tire Service</option>
                                        <option value="Engine Diagnostics">Engine Diagnostics</option>
                                        <option value="Transmission Service">Transmission Service</option>
                                        <option value="Air Conditioning">Air Conditioning</option>
                                        <option value="Battery Service">Battery Service</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Notes (Optional)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                                      placeholder="Any specific notes or requirements..."></textarea>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="button" onclick="closeBookingModal()"
                                    class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                                {{ __('messages.action_cancel') }}
                            </button>
                            <button type="submit"
                                    class="px-6 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.book_confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function openBookingModal(slotId, date, time) {
                    document.getElementById('bookingModal').classList.remove('hidden');
                    document.getElementById('booking_slot_id').value = slotId;
                    document.getElementById('modalSlotInfo').textContent = `${date} at ${time}`;
                    document.getElementById('bookingForm').action = `/admin/appointments/slots/${slotId}/book`;
                }

                function closeBookingModal() {
                    document.getElementById('bookingModal').classList.add('hidden');
                    document.getElementById('bookingForm').reset();
                    clearClientSelection();
                }

                function toggleClientFields() {
                    const clientType = document.querySelector('input[name="client_type"]:checked').value;
                    const existingFields = document.getElementById('existingClientFields');
                    const newFields = document.getElementById('newClientFields');
                    const userIdInput = document.getElementById('user_id');
                    
                    if (clientType === 'existing') {
                        existingFields.classList.remove('hidden');
                        newFields.classList.add('hidden');
                        userIdInput.setAttribute('required', 'required');
                        // Remove required from new client fields
                        document.getElementById('new_name').removeAttribute('required');
                        document.getElementById('new_email').removeAttribute('required');
                        document.getElementById('new_phone').removeAttribute('required');
                    } else {
                        existingFields.classList.add('hidden');
                        newFields.classList.remove('hidden');
                        userIdInput.removeAttribute('required');
                        // Add required to new client fields
                        document.getElementById('new_name').setAttribute('required', 'required');
                        document.getElementById('new_email').setAttribute('required', 'required');
                        document.getElementById('new_phone').setAttribute('required', 'required');
                    }
                }

                // Client search functionality
                const clientsData = {!! json_encode($users->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'vehicle_make' => $user->vehicle_make,
                        'vehicle_model' => $user->vehicle_model,
                        'vehicle_year' => $user->vehicle_year,
                    ];
                })) !!};

                const clientSearch = document.getElementById('client_search');
                const clientResults = document.getElementById('client_results');
                const resultsList = document.getElementById('results_list');

                clientSearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    
                    if (searchTerm.length === 0) {
                        clientResults.classList.add('hidden');
                        return;
                    }

                    const filtered = clientsData.filter(client => 
                        client.name.toLowerCase().includes(searchTerm) || 
                        client.email.toLowerCase().includes(searchTerm)
                    ).slice(0, 10); // Limit to 10 results

                    if (filtered.length === 0) {
                        resultsList.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">No clients found</div>';
                        clientResults.classList.remove('hidden');
                        return;
                    }

                    resultsList.innerHTML = filtered.map(client => `
                        <button type="button" 
                                onclick='selectClient(${client.id}, ${JSON.stringify(client.name)}, ${JSON.stringify(client.email)}, ${JSON.stringify(client.vehicle_make || "")}, ${JSON.stringify(client.vehicle_model || "")}, ${JSON.stringify(client.vehicle_year || "")})'
                                class="w-full text-left px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="font-medium text-gray-900 dark:text-gray-100">${client.name}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">${client.email}</div>
                        </button>
                    `).join('');

                    clientResults.classList.remove('hidden');
                });

                // Close results when clicking outside
                document.addEventListener('click', function(e) {
                    if (!clientSearch.contains(e.target) && !clientResults.contains(e.target)) {
                        clientResults.classList.add('hidden');
                    }
                });

                function selectClient(id, name, email, make, model, year) {
                    // Set hidden user_id
                    document.getElementById('user_id').value = id;
                    
                    // Show selected client
                    document.getElementById('selected_client_name').textContent = name;
                    document.getElementById('selected_client_email').textContent = email;
                    document.getElementById('selected_client').classList.remove('hidden');
                    
                    // Hide search and results
                    document.getElementById('client_search').value = '';
                    document.getElementById('client_results').classList.add('hidden');
                    document.getElementById('client_search').classList.add('hidden');
                    
                    // Show service section
                    document.getElementById('client_service_section').classList.remove('hidden');
                    document.getElementById('existing_service').setAttribute('required', 'required');
                    
                    // Fetch and display user's vehicles
                    fetchUserVehicles(id);
                }

                async function fetchUserVehicles(userId) {
                    try {
                        const response = await fetch(`/admin/api/users/${userId}/vehicles`);
                        const vehicles = await response.json();
                        
                        const vehicleSelect = document.getElementById('client_vehicle_id');
                        const vehicleSection = document.getElementById('client_vehicles_section');
                        const vehicleHint = document.getElementById('vehicle_selection_hint');
                        const manualEntry = document.getElementById('manual_vehicle_entry');
                        const manualVehicleInput = document.getElementById('manual_vehicle');
                        
                        // Clear existing options
                        vehicleSelect.innerHTML = '<option value="">Select a vehicle...</option>';
                        
                        if (vehicles.length > 0) {
                            // Populate vehicle dropdown
                            vehicles.forEach(vehicle => {
                                const option = document.createElement('option');
                                option.value = vehicle.id;
                                option.textContent = `${vehicle.year} ${vehicle.make} ${vehicle.model}${vehicle.plate ? ' (' + vehicle.plate + ')' : ''}`;
                                vehicleSelect.appendChild(option);
                            });
                            
                            // Show vehicle dropdown section and hide hint
                            vehicleSection.classList.remove('hidden');
                            vehicleHint.classList.add('hidden');
                            vehicleSelect.setAttribute('required', 'required');
                            
                            // Hide manual vehicle entry
                            manualEntry.classList.add('hidden');
                            manualVehicleInput.removeAttribute('required');
                            
                            // Auto-select if only one vehicle
                            if (vehicles.length === 1) {
                                vehicleSelect.value = vehicles[0].id;
                            }
                        } else {
                            // No vehicles found - show manual entry
                            vehicleSection.classList.remove('hidden');
                            vehicleHint.classList.remove('hidden');
                            vehicleSelect.removeAttribute('required');
                            
                            // Show manual vehicle entry and add required
                            manualEntry.classList.remove('hidden');
                            manualVehicleInput.setAttribute('required', 'required');
                        }
                    } catch (error) {
                        console.error('Error fetching vehicles:', error);
                        // On error, show manual entry
                        document.getElementById('client_vehicles_section').classList.add('hidden');
                        document.getElementById('manual_vehicle_entry').classList.remove('hidden');
                        document.getElementById('manual_vehicle').setAttribute('required', 'required');
                    }
                }

                function clearClientSelection() {
                    document.getElementById('user_id').value = '';
                    document.getElementById('selected_client').classList.add('hidden');
                    document.getElementById('client_search').classList.remove('hidden');
                    document.getElementById('client_search').value = '';
                    
                    // Hide vehicle selection section
                    document.getElementById('client_vehicles_section').classList.add('hidden');
                    document.getElementById('client_vehicle_id').innerHTML = '<option value="">Select a vehicle...</option>';
                    document.getElementById('client_vehicle_id').removeAttribute('required');
                    
                    // Hide manual vehicle entry
                    document.getElementById('manual_vehicle_entry').classList.add('hidden');
                    document.getElementById('manual_vehicle').removeAttribute('required');
                    
                    // Hide service section
                    document.getElementById('client_service_section').classList.add('hidden');
                    document.getElementById('existing_service').removeAttribute('required');
                    document.getElementById('existing_service').value = '';
                    
                    // Show and reset manual vehicle fields
                    document.getElementById('manual_vehicle_section').classList.remove('hidden');
                    const vehicleFields = document.querySelectorAll('#vehicle_make, #vehicle_model, #vehicle_year');
                    vehicleFields.forEach(field => {
                        field.value = '';
                        field.setAttribute('required', 'required');
                    });
                }

                // Close modal on backdrop click
                document.getElementById('bookingModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeBookingModal();
                    }
                });
            </script>
        </div>
    </div>
</x-app-layout>
