<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.slots_title') }}
            </h2>
            <div data-tour="slots-header-actions" class="flex flex-wrap gap-2 sm:gap-3">
                <a href="{{ route('admin.schedule-templates.index') }}" class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-xs sm:text-sm px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('messages.schedule_templates') }}</span>
                </a>
                <a href="{{ route('admin.slots.export') }}" class="bg-green-600 hover:bg-green-700 dark:bg-green-700 dark:hover:bg-green-800 text-white text-xs sm:text-sm px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('messages.export_slots') }}</span>
                </a>
                <a href="{{ route('admin.appointments.pending') }}" class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-xs sm:text-sm px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('messages.admin_pending_requests') }}</span>
                </a>
                <a href="{{ route('admin.appointments.calendar') }}" class="bg-red-700 hover:bg-red-800 dark:bg-red-800 dark:hover:bg-red-900 text-white text-xs sm:text-sm px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 sm:mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="hidden sm:inline">{{ __('messages.admin_view_calendar') }}</span>
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

            @if ($errors->any())
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-red-800 dark:text-red-200 font-semibold">{{ __('messages.admin_form_errors') }}</p>
                            </div>
                            <ul class="list-disc list-inside text-red-700 dark:text-red-300 text-sm space-y-1 ml-8">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button @click="show = false" class="text-red-500 hover:text-red-700 ml-4">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Create New Slot Form -->
            <div data-tour="slots-create-form" x-data="slotCreator()" class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div @click="expanded = !expanded" class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 cursor-pointer hover:from-red-700 hover:to-red-800 transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                                </svg>
                                {{ __('messages.slots_create') }}
                            </h3>
                            <p class="text-red-100 text-sm mt-1">{{ __('messages.create_slot_description') }}</p>
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

                    {{-- Blocked Dates Banner --}}
                    @if($blockedDates->isNotEmpty())
                        <div class="mb-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h4 class="text-sm font-bold text-amber-800 dark:text-amber-200">{{ __('messages.slot_blocked_dates_warning') }}</h4>
                                    <p class="text-xs text-amber-700 dark:text-amber-300 mt-1">{{ __('messages.slot_blocked_dates_will_skip') }}</p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach($blockedDates->take(10) as $bd)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/40 text-amber-800 dark:text-amber-200 ring-1 ring-amber-300 dark:ring-amber-700">
                                                🚫 {{ $bd->date->format('M d, Y') }}
                                                @if($bd->reason) — {{ $bd->reason }} @endif
                                            </span>
                                        @endforeach
                                        @if($blockedDates->count() > 10)
                                            <span class="text-xs text-amber-600 dark:text-amber-400 self-center">+{{ $blockedDates->count() - 10 }} {{ __('messages.more') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.appointments.slots.store') }}" id="slotForm" class="space-y-6">
                        @csrf

                        {{-- Step 1: Creation Mode --}}
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <label class="block text-base font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-600 text-white text-xs font-bold mr-2.5">1</span>
                                {{ __('messages.create_slot_question') }}
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <label class="relative flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 border-2 border-transparent has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20 group">
                                    <input type="radio" name="bulk_type" value="single" x-model="mode" {{ old('bulk_type', 'single') == 'single' ? 'checked' : '' }} class="mt-1 text-red-600 focus:ring-red-500">
                                    <div class="ml-3">
                                        <p class="font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                            <span class="text-lg mr-1.5">📌</span> {{ __('messages.create_mode_single') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('messages.create_mode_single_desc') }}</p>
                                    </div>
                                </label>
                                <label class="relative flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 border-2 border-transparent has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20 group">
                                    <input type="radio" name="bulk_type" value="daily" x-model="mode" {{ old('bulk_type') == 'daily' ? 'checked' : '' }} class="mt-1 text-red-600 focus:ring-red-500">
                                    <div class="ml-3">
                                        <p class="font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                            <span class="text-lg mr-1.5">📅</span> {{ __('messages.create_mode_daily') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('messages.create_mode_daily_desc') }}</p>
                                    </div>
                                </label>
                                <label class="relative flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 border-2 border-transparent has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/20 group">
                                    <input type="radio" name="bulk_type" value="weekly" x-model="mode" {{ old('bulk_type') == 'weekly' ? 'checked' : '' }} class="mt-1 text-red-600 focus:ring-red-500">
                                    <div class="ml-3">
                                        <p class="font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                            <span class="text-lg mr-1.5">🔄</span> {{ __('messages.create_mode_weekly') }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('messages.create_mode_weekly_desc') }}</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Step 2: Basic Information --}}
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <label class="block text-base font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-600 text-white text-xs font-bold mr-2.5">2</span>
                                {{ __('messages.slot_basic_info') }}
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label for="start_date" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.create_start_date') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="date" 
                                           id="start_date" 
                                           name="start_date" 
                                           x-model="startDate"
                                           value="{{ old('start_date') }}"
                                           min="{{ date('Y-m-d') }}"
                                           required
                                           class="w-full px-4 py-3 rounded-lg border-2 @error('start_date') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    {{-- Blocked date inline warning --}}
                                    <div x-show="isDateBlocked" x-transition class="mt-2 flex items-center p-2.5 bg-amber-50 dark:bg-amber-900/20 border border-amber-300 dark:border-amber-700 rounded-lg">
                                        <svg class="w-4 h-4 text-amber-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-xs font-medium text-amber-800 dark:text-amber-200" x-text="blockedReason"></span>
                                    </div>
                                </div>
                                @php
                                    $oldTime = old('start_time', '09:00');
                                    $timeParts = explode(':', $oldTime);
                                    $oldHour = $timeParts[0] ?? '09';
                                    $oldMinute = $timeParts[1] ?? '00';
                                @endphp
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.create_start_time') }} <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <div class="flex-1">
                                            <select x-model="hour" @change="updateHiddenTime()"
                                                    class="w-full px-4 py-3 rounded-lg border-2 @error('start_time') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                                @for($h = 0; $h < 24; $h++)
                                                    <option value="{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}" {{ $oldHour == str_pad($h, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>{{ str_pad($h, 2, '0', STR_PAD_LEFT) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="flex items-center justify-center text-2xl font-bold text-gray-500 dark:text-gray-400">:</div>
                                        <div class="flex-1">
                                            <select x-model="minute" @change="updateHiddenTime()"
                                                    class="w-full px-4 py-3 rounded-lg border-2 @error('start_time') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                                <option value="00" {{ $oldMinute == '00' ? 'selected' : '' }}>00</option>
                                                <option value="15" {{ $oldMinute == '15' ? 'selected' : '' }}>15</option>
                                                <option value="30" {{ $oldMinute == '30' ? 'selected' : '' }}>30</option>
                                                <option value="45" {{ $oldMinute == '45' ? 'selected' : '' }}>45</option>
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="start_time" name="start_time" :value="hour + ':' + minute" required>
                                    @error('start_time')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="duration" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.create_duration') }} <span class="text-red-600">*</span>
                                    </label>
                                    <select id="duration" name="duration" x-model="duration" required
                                            class="w-full px-4 py-3 rounded-lg border-2 @error('duration') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                        <option value="30" {{ old('duration') == '30' ? 'selected' : '' }}>30 {{ __('messages.schedule_template_minutes', ['count' => '']) }}</option>
                                        <option value="60" {{ old('duration', '60') == '60' ? 'selected' : '' }}>1 {{ trans_choice('messages.schedule_template_hours', 1) }}</option>
                                        <option value="90" {{ old('duration') == '90' ? 'selected' : '' }}>1h 30m</option>
                                        <option value="120" {{ old('duration') == '120' ? 'selected' : '' }}>2 {{ trans_choice('messages.schedule_template_hours', 2) }}</option>
                                    </select>
                                    @error('duration')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Step 3: Pattern Settings (daily/weekly only) --}}
                        <div x-show="mode !== 'single'" x-transition class="border-b border-gray-200 dark:border-gray-700 pb-6">
                            <label class="block text-base font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-red-600 text-white text-xs font-bold mr-2.5">3</span>
                                {{ __('messages.slot_pattern_settings') }}
                            </label>

                            {{-- Day selection --}}
                            <div class="mb-5">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                    {{ __('messages.create_select_days') }} <span class="text-red-600">*</span>
                                </label>
                                <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                                    @php
                                        $dayKeys = [
                                            1 => 'day_monday', 2 => 'day_tuesday', 3 => 'day_wednesday',
                                            4 => 'day_thursday', 5 => 'day_friday', 6 => 'day_saturday', 0 => 'day_sunday'
                                        ];
                                    @endphp
                                    @foreach($dayKeys as $val => $key)
                                        <label class="flex flex-col items-center p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200 active:scale-95">
                                            <input type="checkbox" name="selected_days[]" value="{{ $val }}" {{ is_array(old('selected_days')) && in_array((string)$val, old('selected_days')) ? 'checked' : '' }} class="mb-1.5 w-4 h-4 text-red-600 focus:ring-red-500 rounded">
                                            <span class="text-xs font-bold text-center text-gray-700 dark:text-gray-300">{{ __('messages.'.$key) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ __('messages.slot_select_days_help') }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="bulk_count" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        <span x-text="mode === 'daily' ? '{{ __('messages.slot_count_daily_label') }}' : '{{ __('messages.slot_count_weekly_label') }}'"></span>
                                        <span class="text-red-600">*</span>
                                    </label>
                                    <input type="number" id="bulk_count" name="bulk_count" 
                                           value="{{ old('bulk_count') }}"
                                           min="1" max="30" x-bind:required="mode !== 'single'"
                                           class="w-full px-4 py-3 rounded-lg border-2 @error('bulk_count') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                                           placeholder="e.g., 4">
                                    @error('bulk_count')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5" x-text="mode === 'daily' ? '{{ __('messages.slot_count_daily_help') }}' : '{{ __('messages.slot_count_weekly_help') }}'"></p>
                                </div>
                                <div x-show="mode === 'daily'" x-transition>
                                    <label for="bulk_interval" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.slot_interval_label') }} <span class="text-red-600">*</span>
                                    </label>
                                    <select id="bulk_interval" name="bulk_interval"
                                            class="w-full px-4 py-3 rounded-lg border-2 @error('bulk_interval') border-red-500 dark:border-red-500 @else border-gray-300 dark:border-gray-600 @enderror dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                        <option value="0" {{ old('bulk_interval') == '0' ? 'selected' : '' }}>{{ __('messages.schedule_template_minutes', ['count' => 0]) }} ({{ __('messages.slot_interval_help') }})</option>
                                        <option value="15" {{ old('bulk_interval') == '15' ? 'selected' : '' }}>15 {{ __('messages.schedule_template_minutes', ['count' => '']) }}</option>
                                        <option value="30" {{ old('bulk_interval') == '30' ? 'selected' : '' }}>30 {{ __('messages.schedule_template_minutes', ['count' => '']) }}</option>
                                        <option value="60" {{ old('bulk_interval', '60') == '60' ? 'selected' : '' }}>1 {{ trans_choice('messages.schedule_template_hours', 1) }}</option>
                                        <option value="90" {{ old('bulk_interval') == '90' ? 'selected' : '' }}>1h 30m</option>
                                        <option value="120" {{ old('bulk_interval') == '120' ? 'selected' : '' }}>2 {{ trans_choice('messages.schedule_template_hours', 2) }}</option>
                                    </select>
                                    @error('bulk_interval')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1.5">{{ __('messages.slot_interval_help') }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Live Preview --}}
                        <div x-show="previewText" x-transition class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-bold text-blue-800 dark:text-blue-200">{{ __('messages.slot_preview_label') }}</p>
                                    <p class="text-sm text-blue-700 dark:text-blue-300 mt-1" x-text="previewText"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="flex gap-4 pt-2">
                            <input type="hidden" name="force_create" id="force_create" value="0">
                            <button type="submit" 
                                    class="flex-1 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white px-6 py-3 rounded-lg transition-all duration-300 font-bold shadow-sm hover:shadow-md flex items-center justify-center"
                                    :class="{ 'opacity-50 cursor-not-allowed': isDateBlocked && mode === 'single' }"
                                    :disabled="isDateBlocked && mode === 'single'">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.create_submit') }}
                            </button>
                            <button type="reset" @click="resetForm()"
                                    class="px-8 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 rounded-lg transition-all duration-300 font-semibold">
                                {{ __('messages.slots_clear') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function slotCreator() {
                    return {
                        expanded: {{ $errors->any() || old('start_date') ? 'true' : 'false' }},
                        mode: '{{ old('bulk_type', 'single') }}',
                        startDate: '{{ old('start_date', '') }}',
                        hour: '{{ $oldHour }}',
                        minute: '{{ $oldMinute }}',
                        duration: '{{ old('duration', '60') }}',
                        blockedDates: {!! json_encode($blockedDates->mapWithKeys(fn($bd) => [$bd->date->format('Y-m-d') => $bd->reason ?? ''])->toArray()) !!},
                        isDateBlocked: false,
                        blockedReason: '',

                        init() {
                            this.updateHiddenTime();
                            this.checkBlockedDate();

                            this.$watch('startDate', () => this.checkBlockedDate());
                            this.$watch('mode', () => this.updatePreview());
                            this.$watch('hour', () => this.updatePreview());
                            this.$watch('minute', () => this.updatePreview());
                            this.$watch('duration', () => this.updatePreview());

                            // Form submission with conflict check
                            const form = document.getElementById('slotForm');
                            form.addEventListener('submit', async (e) => {
                                const forceCreate = document.getElementById('force_create').value;
                                if (forceCreate === '1') return true;
                                e.preventDefault();

                                const formData = new FormData(form);
                                try {
                                    const response = await fetch('{{ route('admin.slots.check-conflicts') }}', {
                                        method: 'POST',
                                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                                        body: formData
                                    });
                                    const data = await response.json();

                                    if (data.has_conflicts || data.has_blocked) {
                                        this.showConflictModal(data);
                                    } else {
                                        form.submit();
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    form.submit();
                                }
                            });
                        },

                        updateHiddenTime() {
                            const el = document.getElementById('start_time');
                            if (el) el.value = this.hour + ':' + this.minute;
                        },

                        checkBlockedDate() {
                            if (this.startDate && this.blockedDates[this.startDate] !== undefined) {
                                this.isDateBlocked = true;
                                const reason = this.blockedDates[this.startDate];
                                this.blockedReason = '⚠️ {{ __('messages.slot_blocked_badge') }}: ' + (reason || '{{ __('messages.slot_blocked_no_reason') }}');
                            } else {
                                this.isDateBlocked = false;
                                this.blockedReason = '';
                            }
                            this.updatePreview();
                        },

                        get previewText() {
                            if (!this.startDate) return '';
                            const d = new Date(this.startDate + 'T00:00:00');
                            const dateStr = d.toLocaleDateString('{{ app()->getLocale() }}', { month: 'short', day: 'numeric', year: 'numeric' });
                            const time = this.hour + ':' + this.minute;

                            const selectedDays = Array.from(document.querySelectorAll('input[name="selected_days[]"]:checked'))
                                .map(cb => ['{{ __("messages.day_sun") }}','{{ __("messages.day_mon") }}','{{ __("messages.day_tue") }}','{{ __("messages.day_wed") }}','{{ __("messages.day_thu") }}','{{ __("messages.day_fri") }}','{{ __("messages.day_sat") }}'][parseInt(cb.value)]);

                            if (this.mode === 'single') {
                                return '{{ __("messages.slots_preview_single") }}'.replace(':date', dateStr).replace(':time', time).replace(':duration', this.duration);
                            } else if (this.mode === 'daily') {
                                const count = document.getElementById('bulk_count')?.value || '?';
                                const interval = document.getElementById('bulk_interval')?.value || '?';
                                if (selectedDays.length === 0) return '';
                                return '{{ __("messages.slots_preview_daily") }}'.replace(':count', count).replace(':days', selectedDays.join(', ')).replace(':date', dateStr).replace(':time', time).replace(':interval', interval);
                            } else if (this.mode === 'weekly') {
                                const count = document.getElementById('bulk_count')?.value || '?';
                                if (selectedDays.length === 0) return '';
                                return '{{ __("messages.slots_preview_weekly") }}'.replace(':days', selectedDays.join(', ')).replace(':time', time).replace(':duration', this.duration).replace(':count', count).replace(':date', dateStr);
                            }
                            return '';
                        },

                        updatePreview() {
                            // Reactive trigger — previewText is a computed getter
                        },

                        resetForm() {
                            this.mode = 'single';
                            this.startDate = '';
                            this.hour = '09';
                            this.minute = '00';
                            this.duration = '60';
                            this.isDateBlocked = false;
                            this.blockedReason = '';
                        },

                        showConflictModal(data) {
                            const modal = document.getElementById('conflictModal');
                            const conflictList = document.getElementById('conflictList');
                            const willCreateText = document.getElementById('willCreateText');

                            let html = '';

                            // Show blocked date warnings
                            if (data.blocked && data.blocked.length > 0) {
                                html += data.blocked.map(b => `
                                    <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-500 p-3 rounded-r-lg">
                                        <div class="flex items-center">
                                            <span class="text-amber-500 mr-2">🚫</span>
                                            <div>
                                                <p class="text-sm font-bold text-amber-900 dark:text-amber-200">${b.date}</p>
                                                <p class="text-xs text-amber-700 dark:text-amber-300">{{ __('messages.slot_blocked_badge') }}: ${b.reason}</p>
                                            </div>
                                        </div>
                                    </div>
                                `).join('');
                            }

                            // Show time conflicts
                            if (data.conflicts && data.conflicts.length > 0) {
                                html += data.conflicts.map(conflict => `
                                    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-3 rounded-r-lg">
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
                                                        <span class="font-medium min-w-[80px]">{{ __('messages.slot_conflict_new') }}:</span>
                                                        <span>${conflict.new_start} - ${conflict.new_end}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="font-medium min-w-[80px]">{{ __('messages.slot_conflict_existing') }}:</span>
                                                        <span>${conflict.existing_start} - ${conflict.existing_end}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `).join('');
                            }

                            conflictList.innerHTML = html;

                            let summary = '';
                            if (data.will_create > 0) {
                                summary = '{{ __('messages.slots_will_create') }}'.replace(':count', data.will_create);
                            } else {
                                summary = '{{ __('messages.slots_none_can_be_created') }}';
                            }
                            willCreateText.textContent = summary;
                            modal.classList.remove('hidden');
                        }
                    }
                }
            </script>

            <!-- Conflict Warning Modal -->
            <div id="conflictModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
                <div class="relative mx-auto w-full max-w-2xl bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all border border-gray-200 dark:border-gray-700">
                    <!-- Modal Header -->
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 rounded-t-xl px-6 py-5">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-white shadow-lg">
                                <svg class="h-7 w-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">{{ __('messages.slot_conflict_detected') }}</h3>
                                <p class="text-amber-100 text-sm mt-0.5">{{ __('messages.slot_conflict_subtitle') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('messages.slot_conflict_list_title') }}</p>
                        
                        <div id="conflictList" class="space-y-2 mb-5 max-h-80 overflow-y-auto pr-2"></div>
                        
                        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 p-4 rounded-r-lg mb-5">
                            <div class="flex items-start">
                                <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p id="willCreateText" class="text-sm font-medium text-blue-900 dark:text-blue-200"></p>
                            </div>
                        </div>
                        
                        <p class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ __('messages.slot_conflict_proceed') }}</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 rounded-b-xl flex items-center justify-end gap-3">
                        <button id="cancelConflict" type="button"
                                class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                            {{ __('messages.cancel') }}
                        </button>
                        <button id="confirmConflict" type="button"
                                class="px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.proceed_anyway') }}
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
            <div data-tour="slots-list" class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 dark:border-gray-700">
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
                <div data-tour="slots-filters" class="p-4 sm:p-6 bg-gray-50 dark:bg-gray-900/50 border-b border-gray-200 dark:border-gray-700">
                    <form method="GET" action="{{ route('admin.appointments.slots') }}" class="flex flex-col sm:flex-row sm:flex-wrap gap-4 sm:items-end">
                        <div class="w-full sm:flex-1 sm:min-w-[200px]">
                            <label for="filter_date_from" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.filter_from_date') }}
                            </label>
                            <input type="date" 
                                   id="filter_date_from" 
                                   name="filter_date_from" 
                                   value="{{ request('filter_date_from') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-sm">
                        </div>
                        <div class="w-full sm:flex-1 sm:min-w-[200px]">
                            <label for="filter_date_to" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.filter_to_date') }}
                            </label>
                            <input type="date" 
                                   id="filter_date_to" 
                                   name="filter_date_to" 
                                   value="{{ request('filter_date_to') }}"
                                   min="{{ date('Y-m-d') }}"
                                   class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-sm">
                        </div>
                        <div class="w-full sm:flex-1 sm:min-w-[200px]">
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
                        <div class="flex flex-wrap gap-3 items-center w-full sm:w-auto">
                            <label class="inline-flex items-center cursor-pointer group">
                                <input type="hidden" name="show_old" value="0">
                                <input type="checkbox" 
                                       id="show_old" 
                                       name="show_old" 
                                       value="1"
                                       {{ request('show_old') ? 'checked' : '' }}
                                       onchange="this.form.submit()"
                                       class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-300 dark:bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors whitespace-nowrap">
                                    <i class="fas fa-history mr-1.5 text-gray-500 dark:text-gray-400"></i>
                                    {{ __('messages.show_old_booked_slots') }}
                                </span>
                            </label>
                            <div class="h-6 w-px bg-gray-300 dark:bg-gray-600"></div>
                            <button type="submit" 
                                    class="flex-1 sm:flex-none px-5 py-2.5 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white rounded-lg transition-all duration-200 text-sm font-semibold shadow-sm hover:shadow-md flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.slots_apply_filters') }}
                            </button>
                            <a href="{{ route('admin.appointments.slots') }}" 
                               class="flex-1 sm:flex-none px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200 text-sm font-semibold shadow-sm flex items-center justify-center">
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
                            <p class="mt-4 text-lg text-gray-600 dark:text-gray-400 font-medium">{{ __('messages.slot_empty_title') }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.slot_empty_subtitle') }}</p>
                        </div>
                    @else
                        <!-- Bulk Actions Bar -->
                        <div x-data="{ selectedSlots: [], selectAll: false }" x-init="$watch('selectAll', value => { if(value) { selectedSlots = [...document.querySelectorAll('.slot-checkbox:not(:disabled)')].map(cb => cb.value) } else { selectedSlots = [] } })">
                            <div x-show="selectedSlots.length > 0" x-transition class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-semibold text-red-900 dark:text-red-100"><span x-text="selectedSlots.length"></span> {{ __('messages.slot_selected_count') }}</span>
                                </div>
                                <form method="POST" action="{{ route('admin.appointments.slots.bulk-delete') }}" onsubmit="return confirm('Are you sure you want to delete the selected slots? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="slot_ids" x-model="selectedSlots.join(',')">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm font-semibold rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('messages.slot_delete_selected') }}
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
                                                @if($slot->status->value === 'available')
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
                                                    @if($slot->status->value === 'available') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 ring-1 ring-green-600/20
                                                    @elseif($slot->status->value === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 ring-1 ring-yellow-600/20
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400 ring-1 ring-gray-600/20
                                                    @endif">
                                                    @if($slot->status->value === 'available')
                                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @endif
                                                    {{ ucfirst($slot->status->value) }}
                                                </span>
                                                @if($slot->source === 'auto')
                                                    <span class="ml-1 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400" title="{{ __('messages.slot_auto_generated_title') }}">
                                                        ⚡ {{ __('messages.slot_auto_label') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-3">
                                                    @if($slot->status->value === 'available')
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
                                                        <span class="text-gray-400 dark:text-gray-600 text-xs italic">{{ __('messages.slot_no_actions') }}</span>
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
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.admin_select_from_registered') }}</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border-2 border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 has-[:checked]:border-red-600 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-red-900/30 transition-all duration-200">
                                    <input type="radio" name="client_type" value="new" class="text-red-600 focus:ring-red-500 mr-3" onchange="toggleClientFields()">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.book_new_client') }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.admin_register_over_phone') }}</p>
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
                                       placeholder="{{ __('messages.slot_search_client_placeholder') }}"
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
                                    {{ __('messages.select_vehicle') }} <span class="text-red-600">*</span>
                                </label>
                                <select id="client_vehicle_id" name="vehicle_id" onchange="displayVehicleDetails()" class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                    <option value="">{{ __('messages.admin_select_a_vehicle') }}</option>
                                    <option value="add_new">+ {{ __('messages.admin_add_new_vehicle') }}</option>
                                </select>
                                
                                <!-- Vehicle Details Display -->
                                <div id="vehicle_details_display" class="hidden mt-3 p-4 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-lg">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                        <div>
                                            <p class="text-xs text-blue-700 dark:text-blue-300 font-semibold">{{ __('messages.book_vehicle_make') }}</p>
                                            <p class="text-sm text-blue-900 dark:text-blue-100" id="detail_make"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-700 dark:text-blue-300 font-semibold">{{ __('messages.book_vehicle_model') }}</p>
                                            <p class="text-sm text-blue-900 dark:text-blue-100" id="detail_model"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-700 dark:text-blue-300 font-semibold">{{ __('messages.book_vehicle_year') }}</p>
                                            <p class="text-sm text-blue-900 dark:text-blue-100" id="detail_year"></p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-blue-700 dark:text-blue-300 font-semibold">{{ __('messages.registration') }}</p>
                                            <p class="text-sm text-blue-900 dark:text-blue-100" id="detail_plate"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add New Vehicle Form (for existing client) -->
                            <div id="add_new_vehicle_form" class="hidden mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 border-2 border-gray-200 dark:border-gray-600 rounded-lg">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ __('messages.admin_add_new_vehicle') }}</h4>
                                    <button type="button" onclick="cancelAddVehicle()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.book_vehicle_make') }} *</label>
                                        <input type="text" id="new_vehicle_make" name="new_vehicle_make" 
                                               class="w-full px-3 py-2 text-sm rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.book_vehicle_model') }} *</label>
                                        <input type="text" id="new_vehicle_model" name="new_vehicle_model"
                                               class="w-full px-3 py-2 text-sm rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.book_vehicle_year') }} *</label>
                                        <input type="number" id="new_vehicle_year" name="new_vehicle_year" min="1900" max="2100"
                                               class="w-full px-3 py-2 text-sm rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.registration') }}</label>
                                        <input type="text" id="new_vehicle_plate" name="new_vehicle_plate"
                                               class="w-full px-3 py-2 text-sm rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">{{ __('messages.admin_vehicle_saved_to_profile') }}</p>
                            </div>

                            <!-- Manual Vehicle Entry (when no vehicle selected or no vehicles) -->
                            <div id="manual_vehicle_entry" class="hidden mt-4">
                                <label for="manual_vehicle" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.vehicle_information') }} <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="manual_vehicle" name="vehicle"
                                       placeholder="e.g., 2020 Honda Civic (ABC123)"
                                       class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.admin_vehicle_manual_hint') }}</p>
                            </div>

                            <!-- Service Selection for Existing Client -->
                            <div id="client_service_section" class="hidden mt-4">
                                <label for="existing_service" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.service') }} <span class="text-red-600">*</span>
                                </label>
                                <select id="existing_service" name="service" class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                    <option value="">{{ __('messages.admin_select_a_service') }}</option>
                                    <option value="General Inspection">{{ __('messages.service_inspection') }}</option>
                                    <option value="Oil Change">{{ __('messages.service_oil_change') }}</option>
                                    <option value="Brake Service">{{ __('messages.service_brake') }}</option>
                                    <option value="Tire Service">{{ __('messages.service_tire_service') }}</option>
                                    <option value="Engine Diagnostics">{{ __('messages.service_diagnostics') }}</option>
                                    <option value="Transmission Service">{{ __('messages.service_transmission_service') }}</option>
                                    <option value="Air Conditioning">{{ __('messages.service_air_conditioning') }}</option>
                                    <option value="Battery Service">{{ __('messages.service_battery_service') }}</option>
                                    <option value="Other">{{ __('messages.service_other') }}</option>
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
                                    <div class="flex items-start gap-2 p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800">
                                        <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm text-blue-700 dark:text-blue-300">
                                            {{ __('messages.admin_password_auto_generated') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle and Service Information for New Clients -->
                        <div class="hidden border-t border-gray-200 dark:border-gray-700 pt-6" id="new_client_vehicle_service">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.vehicle_information') }}</h4>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="new_client_vehicle_make" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.book_vehicle_make') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" id="new_client_vehicle_make" name="new_vehicle_make"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="new_client_vehicle_model" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.book_vehicle_model') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="text" id="new_client_vehicle_model" name="new_vehicle_model"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="new_client_vehicle_year" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.book_vehicle_year') }} <span class="text-red-600">*</span>
                                    </label>
                                    <input type="number" id="new_client_vehicle_year" name="new_vehicle_year" min="1900" max="2100"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                                <div>
                                    <label for="new_client_vehicle_plate" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                        {{ __('messages.registration') }}
                                    </label>
                                    <input type="text" id="new_client_vehicle_plate" name="new_vehicle_plate"
                                           class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="new_service" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('messages.service') }} <span class="text-red-600">*</span>
                                </label>
                                <select id="new_service" name="service" disabled
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200">
                                    <option value="">{{ __('messages.admin_select_a_service') }}</option>
                                    <option value="General Inspection">{{ __('messages.service_inspection') }}</option>
                                    <option value="Oil Change">{{ __('messages.service_oil_change') }}</option>
                                    <option value="Brake Service">{{ __('messages.service_brake') }}</option>
                                    <option value="Tire Service">{{ __('messages.service_tire_service') }}</option>
                                    <option value="Engine Diagnostics">{{ __('messages.service_diagnostics') }}</option>
                                    <option value="Transmission Service">{{ __('messages.service_transmission_service') }}</option>
                                    <option value="Air Conditioning">{{ __('messages.service_air_conditioning') }}</option>
                                    <option value="Battery Service">{{ __('messages.service_battery_service') }}</option>
                                    <option value="Other">{{ __('messages.service_other') }}</option>
                                </select>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.admin_notes_optional') }}
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                      class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                                      placeholder="{{ __('messages.admin_notes_placeholder') }}"></textarea>
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
                    document.getElementById('modalSlotInfo').textContent = '{{ __('messages.slots_modal_slot_info') }}'.replace(':date', date).replace(':time', time);
                    document.getElementById('bookingForm').action = `/admin/appointments/slots/${slotId}/book`;
                }

                function closeBookingModal() {
                    document.getElementById('bookingModal').classList.add('hidden');
                    document.getElementById('bookingForm').reset();
                    clearClientSelection();
                }

                // Initialize client fields on page load
                toggleClientFields();
                
                // Form submission handler (with optional debugging)
                document.getElementById('bookingForm')?.addEventListener('submit', function(e) {
                    // Form will submit normally
                });

                function toggleClientFields() {
                    const clientType = document.querySelector('input[name="client_type"]:checked').value;
                    const existingFields = document.getElementById('existingClientFields');
                    const newFields = document.getElementById('newClientFields');
                    const newClientVehicleService = document.getElementById('new_client_vehicle_service');
                    const userIdInput = document.getElementById('user_id');
                    
                    if (clientType === 'existing') {
                        existingFields.classList.remove('hidden');
                        newFields.classList.add('hidden');
                        newClientVehicleService.classList.add('hidden');
                        userIdInput.setAttribute('required', 'required');
                        // Disable and remove required from new client fields to prevent submission
                        document.getElementById('new_name').removeAttribute('required');
                        document.getElementById('new_name').disabled = true;
                        document.getElementById('new_email').removeAttribute('required');
                        document.getElementById('new_email').disabled = true;
                        document.getElementById('new_phone').removeAttribute('required');
                        document.getElementById('new_phone').disabled = true;
                        document.getElementById('new_client_vehicle_make').removeAttribute('required');
                        document.getElementById('new_client_vehicle_make').disabled = true;
                        document.getElementById('new_client_vehicle_model').removeAttribute('required');
                        document.getElementById('new_client_vehicle_model').disabled = true;
                        document.getElementById('new_client_vehicle_year').removeAttribute('required');
                        document.getElementById('new_client_vehicle_year').disabled = true;
                        document.getElementById('new_client_vehicle_plate').disabled = true;
                        document.getElementById('new_service').removeAttribute('required');
                        document.getElementById('new_service').disabled = true;
                        // Enable existing client service field
                        document.getElementById('existing_service').disabled = false;
                    } else {
                        existingFields.classList.add('hidden');
                        newFields.classList.remove('hidden');
                        newClientVehicleService.classList.remove('hidden');
                        userIdInput.removeAttribute('required');
                        // Enable and add required to new client fields
                        document.getElementById('new_name').setAttribute('required', 'required');
                        document.getElementById('new_name').disabled = false;
                        document.getElementById('new_email').setAttribute('required', 'required');
                        document.getElementById('new_email').disabled = false;
                        document.getElementById('new_phone').setAttribute('required', 'required');
                        document.getElementById('new_phone').disabled = false;
                        document.getElementById('new_client_vehicle_make').setAttribute('required', 'required');
                        document.getElementById('new_client_vehicle_make').disabled = false;
                        document.getElementById('new_client_vehicle_model').setAttribute('required', 'required');
                        document.getElementById('new_client_vehicle_model').disabled = false;
                        document.getElementById('new_client_vehicle_year').setAttribute('required', 'required');
                        document.getElementById('new_client_vehicle_year').disabled = false;
                        document.getElementById('new_client_vehicle_plate').disabled = false;
                        document.getElementById('new_service').setAttribute('required', 'required');
                        document.getElementById('new_service').disabled = false;
                        // Disable existing client service field
                        document.getElementById('existing_service').disabled = true;
                    }
                }

                // Client search functionality
                const clientsData = {!! json_encode($users->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => e($user->name),
                        'email' => e($user->email),
                        'vehicle_make' => e($user->vehicle_make),
                        'vehicle_model' => e($user->vehicle_model),
                        'vehicle_year' => e($user->vehicle_year),
                    ];
                }), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};

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
                        resultsList.innerHTML = '<div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.admin_no_clients_found') }}</div>';
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

                // Store vehicles data globally for later use
                let currentUserVehicles = [];

                async function fetchUserVehicles(userId) {
                    try {
                        const response = await fetch(`/admin/api/users/${userId}/vehicles`);
                        const vehicles = await response.json();
                        currentUserVehicles = vehicles; // Store for later use
                        
                        const vehicleSelect = document.getElementById('client_vehicle_id');
                        const vehicleSection = document.getElementById('client_vehicles_section');
                        const manualEntry = document.getElementById('manual_vehicle_entry');
                        const manualVehicleInput = document.getElementById('manual_vehicle');
                        
                        // Clear existing options except first two
                        vehicleSelect.innerHTML = '<option value="">{{ __('messages.admin_select_a_vehicle') }}</option><option value="add_new">+ {{ __('messages.admin_add_new_vehicle') }}</option>';
                        
                        if (vehicles.length > 0) {
                            // Populate vehicle dropdown
                            vehicles.forEach(vehicle => {
                                const option = document.createElement('option');
                                option.value = vehicle.id;
                                option.textContent = `${vehicle.year} ${vehicle.make} ${vehicle.model}${vehicle.plate ? ' (' + vehicle.plate + ')' : ''}`;
                                option.dataset.make = vehicle.make;
                                option.dataset.model = vehicle.model;
                                option.dataset.year = vehicle.year;
                                option.dataset.plate = vehicle.plate || 'N/A';
                                vehicleSelect.appendChild(option);
                            });
                            
                            // Show vehicle dropdown section
                            vehicleSection.classList.remove('hidden');
                            
                            // Auto-select if only one vehicle and display its details
                            if (vehicles.length === 1) {
                                vehicleSelect.value = vehicles[0].id;
                                displayVehicleDetails();
                            }
                        } else {
                            // No vehicles found - show vehicle section with manual entry option
                            vehicleSection.classList.remove('hidden');
                            manualEntry.classList.remove('hidden');
                        }
                        
                        vehicleSelect.setAttribute('required', 'required');
                    } catch (error) {
                        console.error('Error fetching vehicles:', error);
                        // On error, show manual entry
                        document.getElementById('client_vehicles_section').classList.remove('hidden');
                        document.getElementById('manual_vehicle_entry').classList.remove('hidden');
                    }
                }

                function displayVehicleDetails() {
                    const vehicleSelect = document.getElementById('client_vehicle_id');
                    const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];
                    const vehicleDetailsDisplay = document.getElementById('vehicle_details_display');
                    const addNewVehicleForm = document.getElementById('add_new_vehicle_form');
                    const manualEntry = document.getElementById('manual_vehicle_entry');
                    
                    if (vehicleSelect.value === 'add_new') {
                        // Show add new vehicle form
                        vehicleDetailsDisplay.classList.add('hidden');
                        addNewVehicleForm.classList.remove('hidden');
                        manualEntry.classList.add('hidden');
                        vehicleSelect.removeAttribute('required');
                        
                        // Make new vehicle fields required
                        document.getElementById('new_vehicle_make').setAttribute('required', 'required');
                        document.getElementById('new_vehicle_model').setAttribute('required', 'required');
                        document.getElementById('new_vehicle_year').setAttribute('required', 'required');
                    } else if (vehicleSelect.value) {
                        // Display vehicle details
                        document.getElementById('detail_make').textContent = selectedOption.dataset.make || 'N/A';
                        document.getElementById('detail_model').textContent = selectedOption.dataset.model || 'N/A';
                        document.getElementById('detail_year').textContent = selectedOption.dataset.year || 'N/A';
                        document.getElementById('detail_plate').textContent = selectedOption.dataset.plate || 'N/A';
                        
                        vehicleDetailsDisplay.classList.remove('hidden');
                        addNewVehicleForm.classList.add('hidden');
                        manualEntry.classList.add('hidden');
                        
                        // Remove required from new vehicle fields
                        document.getElementById('new_vehicle_make').removeAttribute('required');
                        document.getElementById('new_vehicle_model').removeAttribute('required');
                        document.getElementById('new_vehicle_year').removeAttribute('required');
                    } else {
                        // No selection - show manual entry if no vehicles exist
                        vehicleDetailsDisplay.classList.add('hidden');
                        addNewVehicleForm.classList.add('hidden');
                        if (currentUserVehicles.length === 0) {
                            manualEntry.classList.remove('hidden');
                        }
                    }
                }

                function cancelAddVehicle() {
                    const vehicleSelect = document.getElementById('client_vehicle_id');
                    const addNewVehicleForm = document.getElementById('add_new_vehicle_form');
                    const manualEntry = document.getElementById('manual_vehicle_entry');
                    
                    // Reset selection
                    vehicleSelect.value = '';
                    addNewVehicleForm.classList.add('hidden');
                    
                    // Clear new vehicle form
                    document.getElementById('new_vehicle_make').value = '';
                    document.getElementById('new_vehicle_model').value = '';
                    document.getElementById('new_vehicle_year').value = '';
                    document.getElementById('new_vehicle_plate').value = '';
                    
                    // Remove required from new vehicle fields
                    document.getElementById('new_vehicle_make').removeAttribute('required');
                    document.getElementById('new_vehicle_model').removeAttribute('required');
                    document.getElementById('new_vehicle_year').removeAttribute('required');
                    
                    // Show manual entry if no vehicles exist
                    if (currentUserVehicles.length === 0) {
                        manualEntry.classList.remove('hidden');
                    }
                    
                    vehicleSelect.setAttribute('required', 'required');
                }

                function clearClientSelection() {
                    document.getElementById('user_id').value = '';
                    document.getElementById('selected_client').classList.add('hidden');
                    document.getElementById('client_search').classList.remove('hidden');
                    document.getElementById('client_search').value = '';
                    
                    // Hide vehicle selection section
                    document.getElementById('client_vehicles_section').classList.add('hidden');
                    document.getElementById('client_vehicle_id').innerHTML = '<option value="">{{ __('messages.admin_select_a_vehicle') }}</option><option value="add_new">+ {{ __('messages.admin_add_new_vehicle') }}</option>';
                    document.getElementById('client_vehicle_id').removeAttribute('required');
                    
                    // Hide vehicle details and forms
                    document.getElementById('vehicle_details_display').classList.add('hidden');
                    document.getElementById('add_new_vehicle_form').classList.add('hidden');
                    
                    // Hide manual vehicle entry
                    document.getElementById('manual_vehicle_entry').classList.add('hidden');
                    document.getElementById('manual_vehicle').removeAttribute('required');
                    
                    // Hide service section
                    document.getElementById('client_service_section').classList.add('hidden');
                    document.getElementById('existing_service').removeAttribute('required');
                    document.getElementById('existing_service').value = '';
                    
                    // Reset current user vehicles
                    currentUserVehicles = [];
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
    @include('admin.partials.tour', [
        'tourPage' => 'slots',
        'tourSteps' => [
            [
                'target' => null,
                'title' => __('messages.tour_slots_welcome_title'),
                'description' => __('messages.tour_slots_welcome_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
            [
                'target' => '[data-tour="slots-header-actions"]',
                'title' => __('messages.tour_slots_actions_title'),
                'description' => __('messages.tour_slots_actions_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="slots-create-form"]',
                'title' => __('messages.tour_slots_create_title'),
                'description' => __('messages.tour_slots_create_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="slots-list"]',
                'title' => __('messages.tour_slots_list_title'),
                'description' => __('messages.tour_slots_list_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>',
                'position' => 'top',
            ],
            [
                'target' => '[data-tour="slots-filters"]',
                'title' => __('messages.tour_slots_filters_title'),
                'description' => __('messages.tour_slots_filters_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => null,
                'title' => __('messages.tour_slots_complete_title'),
                'description' => __('messages.tour_slots_complete_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
        ],
    ])
</x-app-layout>
