<x-app-layout>
    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-[95%] mx-auto sm:px-4 lg:px-6">
            <!-- Header Section -->
            <div class="mb-6 sm:mb-8 mt-4 sm:mt-8 text-center px-4">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3">
                    {{ __('messages.appointments_available') }}
                </h1>
                <p class="text-base sm:text-lg text-gray-600 dark:text-gray-300">
                    {{ __('messages.appointments_select_time') }}
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg">
                    <p class="text-green-800 dark:text-green-200">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg">
                    <p class="text-red-800 dark:text-red-200">{{ session('error') }}</p>
                </div>
            @endif

            <!-- View Toggle -->
            <div class="flex justify-end mb-4 px-4 sm:px-0">
                <div class="inline-flex rounded-lg shadow-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
                    <a href="{{ route('appointments.index') }}" 
                       class="px-4 py-2.5 text-sm font-semibold rounded-l-lg transition-all duration-200 flex items-center gap-2 bg-red-600 text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        {{ __('messages.customer_calendar_list_view') }}
                    </a>
                    <a href="{{ route('appointments.calendar') }}" 
                       class="px-4 py-2.5 text-sm font-semibold rounded-r-lg transition-all duration-200 flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ __('messages.customer_calendar_calendar_view') }}
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
                <form method="GET" action="{{ route('appointments.index') }}" class="flex flex-wrap items-end gap-3 sm:gap-4">
                    <div class="w-full sm:flex-1 sm:min-w-[200px]">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.date_from') }}
                        </label>
                        <input type="date" id="dateFrom" name="date_from" value="{{ request('date_from', now()->format('Y-m-d')) }}" data-min-today class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base">
                    </div>

                    <div class="w-full sm:flex-1 sm:min-w-[200px]">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.date_to') }}
                        </label>
                        <input type="date" id="dateTo" name="date_to" value="{{ request('date_to', now()->addWeeks(2)->format('Y-m-d')) }}" data-min-today class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base">
                    </div>

                    <div class="w-full sm:flex-1 sm:min-w-[200px]">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.filter_time') }}
                        </label>
                        <select name="time_period" class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 text-base">
                            <option value="">{{ __('messages.any_time') }}</option>
                            <option value="morning" {{ request('time_period') == 'morning' ? 'selected' : '' }}>{{ __('messages.morning') }}</option>
                            <option value="afternoon" {{ request('time_period') == 'afternoon' ? 'selected' : '' }}>{{ __('messages.afternoon') }}</option>
                            <option value="evening" {{ request('time_period') == 'evening' ? 'selected' : '' }}>{{ __('messages.evening') }}</option>
                        </select>
                    </div>

                    <div class="w-full sm:w-auto">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white rounded-lg font-semibold transition shadow-sm hover:shadow-md active:scale-95">
                            {{ __('messages.apply_filters') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Calendar View -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-3 sm:p-6">
                @if($availableSlots->isEmpty())
                    <div class="py-20 text-center">
                        <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.no_slots_available') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ __('messages.try_different_filters') }}</p>
                    </div>
                @else
                    @php
                        $slotsByDate = $availableSlots->groupBy(function($slot) {
                            return \Carbon\Carbon::parse($slot->start_time)->format('Y-m-d');
                        });
                    @endphp

                    <div class="space-y-4">
                        @foreach($slotsByDate as $date => $slotsOnDate)
                            @php
                                $dateObj = \Carbon\Carbon::parse($date);
                                $isFirstDate = $loop->first;
                            @endphp
                            <div x-data="{ expanded: {{ $isFirstDate ? 'true' : 'false' }} }" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                <!-- Date Header -->
                                <div @click="expanded = !expanded" class="flex items-center justify-between p-3 sm:p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition rounded-lg active:bg-gray-100 dark:active:bg-gray-600">
                                    <div class="flex items-center">
                                        <div class="bg-red-600 text-white rounded-lg p-2 mr-3 text-center min-w-[55px] sm:min-w-[60px]">
                                            <div class="text-lg sm:text-xl font-bold">{{ $dateObj->format('d') }}</div>
                                            <div class="text-xs uppercase">{{ $dateObj->translatedFormat('M') }}</div>
                                        </div>
                                        <div>
                                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">
                                                {{ $dateObj->translatedFormat('l') }}
                                            </h3>
                                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                                {{ $dateObj->translatedFormat('F j, Y') }} • {{ $slotsOnDate->count() }} {{ $slotsOnDate->count() === 1 ? __('messages.slot') : __('messages.slots') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-gray-400 dark:text-gray-500 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>

                                <!-- Time Slots Grid -->
                                <div x-show="expanded" x-collapse class="px-3 pb-3">
                                    <div class="flex overflow-x-auto gap-2 sm:gap-3 pt-3 -mx-3 px-3 scrollbar-hide">
                                    @foreach($slotsOnDate as $slot)
                                        <a href="{{ route('appointments.show', $slot->id) }}" class="flex-shrink-0 w-[130px] sm:w-[140px] bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-500 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 p-3 sm:p-4 flex flex-col items-center justify-center space-y-2 hover:bg-red-50 dark:hover:bg-red-900/20 active:scale-95 min-h-[44px]">
                                            <div class="flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="flex flex-col items-center justify-center space-y-1">
                                                <span class="text-xl font-bold text-gray-900 dark:text-white">
                                                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">to</span>
                                                <span class="text-xl font-bold text-gray-900 dark:text-white">
                                                    {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                                                </span>
                                            </div>
                                            <div class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">
                                                {{ __('messages.available') }}
                                            </div>
                                        </a>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scroll to Top Button -->
    <div x-data="{ showScroll: false }" 
         @scroll.window="showScroll = (window.pageYOffset > 300)"
         x-show="showScroll" 
         x-transition
         class="fixed bottom-8 right-8 z-40">
        <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                class="bg-red-600 hover:bg-red-700 text-white p-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div>

</x-app-layout>
