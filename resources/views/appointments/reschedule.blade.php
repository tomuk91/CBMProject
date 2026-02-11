<x-app-layout>
    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('appointments.details', $appointment) }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition mb-4">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {{ __('messages.back_to_details') }}
                </a>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.reschedule_appointment') }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.reschedule_select_new_slot') }}</p>
            </div>

            <!-- Flash Messages -->
            @if(session('error'))
                <div class="mb-6 rounded-xl bg-red-50 dark:bg-red-900/20 p-4 border border-red-200 dark:border-red-800">
                    <div class="flex">
                        <svg class="h-5 w-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Current Appointment Info -->
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-4 mb-6">
                <h3 class="text-sm font-semibold text-amber-800 dark:text-amber-300 mb-2">{{ __('messages.current_appointment') }}</h3>
                <p class="text-gray-900 dark:text-white font-medium">{{ $appointment->service }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ \Carbon\Carbon::parse($appointment->appointment_date)->translatedFormat('l, F j, Y \a\t H:i') }}</p>
            </div>

            <!-- Available Slots -->
            @if($availableSlots->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('messages.no_slots_available') }}</h3>
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
                        @php $dateObj = \Carbon\Carbon::parse($date); @endphp
                        <div x-data="{ expanded: {{ $loop->first ? 'true' : 'false' }} }" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm">
                            <div @click="expanded = !expanded" class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition rounded-xl">
                                <div class="flex items-center">
                                    <div class="bg-red-600 text-white rounded-lg p-2 mr-3 text-center min-w-[55px]">
                                        <div class="text-lg font-bold">{{ $dateObj->format('d') }}</div>
                                        <div class="text-xs uppercase">{{ $dateObj->translatedFormat('M') }}</div>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 dark:text-white">{{ $dateObj->translatedFormat('l') }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $slotsOnDate->count() }} {{ $slotsOnDate->count() === 1 ? __('messages.slot') : __('messages.slots') }}</p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-gray-400 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                            <div x-show="expanded" x-collapse class="px-4 pb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($slotsOnDate as $slot)
                                        <form method="POST" action="{{ route('appointments.processReschedule', $appointment) }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                                            <button type="submit" class="px-4 py-3 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-500 rounded-lg transition-all hover:bg-red-50 dark:hover:bg-red-900/20 active:scale-95" onclick="return confirm('{{ __('messages.confirm_reschedule_slot') }}')">
                                                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400 block">{{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</span>
                                            </button>
                                        </form>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
