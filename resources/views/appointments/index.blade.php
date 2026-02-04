<x-app-layout>
    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold bg-gradient-to-r from-red-600 to-red-700 bg-clip-text text-transparent">
                            {{ __('messages.appointments_available') }}
                        </h1>
                        <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                            {{ __('messages.appointments_select_time') }}
                        </p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-5 py-2.5 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm border border-gray-200 dark:border-gray-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ __('messages.action_back') }}
                    </a>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6 mb-8">
                <form method="GET" action="{{ route('appointments.index') }}" class="space-y-6">
                    <div class="flex items-center mb-4">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-red-50 dark:bg-red-900/20 mr-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('messages.filter_appointments') }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Week Filter -->
                        <div>
                            <label for="week" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.filter_week') }}
                            </label>
                            <select name="week" id="week" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition-all">
                                <option value="">{{ __('messages.all_weeks') }}</option>
                                <option value="0" {{ request('week') == '0' ? 'selected' : '' }}>{{ __('messages.this_week') }}</option>
                                <option value="1" {{ request('week') == '1' ? 'selected' : '' }}>{{ __('messages.next_week') }}</option>
                                <option value="2" {{ request('week') == '2' ? 'selected' : '' }}>{{ __('messages.two_weeks') }}</option>
                                <option value="3" {{ request('week') == '3' ? 'selected' : '' }}>{{ __('messages.three_weeks') }}</option>
                                <option value="4" {{ request('week') == '4' ? 'selected' : '' }}>{{ __('messages.four_weeks') }}</option>
                            </select>
                        </div>

                        <!-- Day Filter -->
                        <div x-data="{
                            open: false,
                            selected: {{ json_encode(request('days', [])) }},
                            options: [
                                { value: '2', label: '{{ __('messages.day_monday') }}' },
                                { value: '3', label: '{{ __('messages.day_tuesday') }}' },
                                { value: '4', label: '{{ __('messages.day_wednesday') }}' },
                                { value: '5', label: '{{ __('messages.day_thursday') }}' },
                                { value: '6', label: '{{ __('messages.day_friday') }}' },
                                { value: '7', label: '{{ __('messages.day_saturday') }}' },
                                { value: '1', label: '{{ __('messages.day_sunday') }}' }
                            ],
                            toggle(value) {
                                if (this.selected.includes(value)) {
                                    this.selected = this.selected.filter(v => v !== value);
                                } else {
                                    this.selected.push(value);
                                }
                            },
                            isSelected(value) {
                                return this.selected.includes(value);
                            },
                            getLabel() {
                                if (this.selected.length === 0) return '{{ __('messages.select_days') }}';
                                if (this.selected.length === 1) {
                                    const opt = this.options.find(o => o.value === this.selected[0]);
                                    return opt ? opt.label : '';
                                }
                                return this.selected.length + ' {{ __('messages.days_selected') }}';
                            }
                        }" class="relative" @click.away="open = false">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.filter_day') }}
                            </label>
                            
                            <!-- Dropdown Button -->
                            <button type="button" @click="open = !open" 
                                class="w-full px-4 py-3 text-left border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 bg-white flex items-center justify-between transition-all">
                                <span x-text="getLabel()" class="text-gray-900 dark:text-gray-100"></span>
                                <svg class="w-5 h-5 text-gray-400" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Hidden inputs for form submission -->
                            <template x-for="value in selected" :key="value">
                                <input type="hidden" name="days[]" :value="value">
                            </template>

                            <!-- Dropdown Menu -->
                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-60 overflow-auto">
                                <template x-for="option in options" :key="option.value">
                                    <div @click="toggle(option.value)" 
                                        class="px-4 py-2 cursor-pointer hover:bg-red-50 dark:hover:bg-red-900/20 flex items-center justify-between transition-colors"
                                        :class="{'bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-400': isSelected(option.value)}">
                                        <span class="text-gray-900 dark:text-gray-100" x-text="option.label"></span>
                                        <svg x-show="isSelected(option.value)" class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Time Period Filter -->
                        <div>
                            <label for="time_period" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.filter_time') }}
                            </label>
                            <select name="time_period" id="time_period" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100 transition-all">
                                <option value="">{{ __('messages.all_times') }}</option>
                                <option value="morning" {{ request('time_period') == 'morning' ? 'selected' : '' }}>{{ __('messages.time_morning') }}</option>
                                <option value="afternoon" {{ request('time_period') == 'afternoon' ? 'selected' : '' }}>{{ __('messages.time_afternoon') }}</option>
                                <option value="evening" {{ request('time_period') == 'evening' ? 'selected' : '' }}>{{ __('messages.time_evening') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-all shadow-md hover:shadow-lg">
                            {{ __('messages.action_apply_filters') }}
                        </button>
                        <a href="{{ route('appointments.index') }}" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all border border-gray-300 dark:border-gray-600">
                            {{ __('messages.action_clear_filters') }}
                        </a>
                        @if(request()->hasAny(['week', 'days', 'time_period']))
                            <span class="flex items-center text-sm text-gray-600 dark:text-gray-400 ml-2">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.filters_active') }}
                            </span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 p-4 border border-green-200 dark:border-green-800">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 p-4 border border-red-200 dark:border-red-800">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800 dark:text-red-200">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            @endif

            @if($availableSlots->count() > 0)
                <!-- Available Slots Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($availableSlots as $slot)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <div class="p-6">
                                <!-- Date -->
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-lg p-3">
                                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $slot->start_time->format('M j, Y') }}
                                        </h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $slot->start_time->format('l') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Time -->
                                <div class="flex items-center mb-6 text-gray-600 dark:text-gray-400">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ $slot->start_time->format('g:i A') }} - {{ $slot->end_time->format('g:i A') }}
                                    </span>
                                </div>

                                <!-- Book Button -->
                                <a href="{{ route('appointments.show', $slot->id) }}" 
                                   class="block w-full px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white text-center text-sm font-bold rounded-lg hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-md hover:shadow-lg">
                                    {{ __('messages.appointments_book_slot') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Slots Available -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 py-16 px-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gray-100 dark:bg-gray-700 mb-6">
                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-3">
                        {{ __('messages.appointments_no_slots') }}
                    </h3>
                    <p class="text-base text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                        {{ __('messages.appointments_check_later') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
