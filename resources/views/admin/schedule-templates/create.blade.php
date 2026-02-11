@php
    $dayKeys = ['day_sunday', 'day_monday', 'day_tuesday', 'day_wednesday', 'day_thursday', 'day_friday', 'day_saturday'];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.schedule_template_create_title') }}
            </h2>
            <a href="{{ route('admin.schedule-templates.index') }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 shadow-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                {{ __('messages.schedule_template_back_to_templates') }}
            </a>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-4 lg:px-6 space-y-6">

            {{-- Admin Guidelines --}}
            <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-all duration-200">
                    <div class="flex items-center">
                        <div class="bg-red-100 dark:bg-red-900/30 rounded-lg p-2 mr-3">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">{{ __('messages.schedule_template_guide_title') }}</h3>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" x-collapse>
                    <div class="px-6 pb-5 border-t border-gray-100 dark:border-gray-700">
                        <ul class="mt-4 space-y-2.5 text-sm text-gray-600 dark:text-gray-400">
                            @for ($i = 1; $i <= 6; $i++)
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 text-red-500 dark:text-red-400 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    {{ __("messages.schedule_template_guide_{$i}") }}
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.schedule-templates.store') }}" id="templateForm"
                  class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 space-y-6 border border-gray-100 dark:border-gray-700">
                @csrf

                {{-- Template Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_name') }}</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           placeholder="{{ __('messages.schedule_template_name_placeholder') }}"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Day of Week --}}
                <div>
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_day') }}</label>
                    <select name="day_of_week" id="day_of_week"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                        <option value="">{{ __('messages.schedule_template_day_select') }}</option>
                        @foreach ($dayKeys as $i => $dayKey)
                            <option value="{{ $i }}" {{ (int) old('day_of_week', '') === $i && old('day_of_week') !== null ? 'selected' : '' }}>{{ __('messages.' . $dayKey) }}</option>
                        @endforeach
                    </select>
                    @error('day_of_week')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Start / End Time --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_start_time') }}</label>
                        <input type="time" name="start_time" id="start_time" value="{{ old('start_time', '08:00') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_end_time') }}</label>
                        <input type="time" name="end_time" id="end_time" value="{{ old('end_time', '17:00') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Slot Duration / Break --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="slot_duration_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_duration') }}</label>
                        <select name="slot_duration_minutes" id="slot_duration_minutes"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                            @foreach ([15, 30, 45, 60, 90, 120] as $minutes)
                                <option value="{{ $minutes }}" {{ (int) old('slot_duration_minutes', 60) === $minutes ? 'selected' : '' }}>{{ __('messages.schedule_template_minutes', ['count' => $minutes]) }}</option>
                            @endforeach
                        </select>
                        @error('slot_duration_minutes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="break_between_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_break') }}</label>
                        <select name="break_between_minutes" id="break_between_minutes"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                            @foreach ([0, 5, 10, 15, 30, 45, 60, 90, 120, 180, 240] as $minutes)
                                <option value="{{ $minutes }}" {{ (int) old('break_between_minutes', 0) === $minutes ? 'selected' : '' }}>
                                    @if($minutes >= 60 && $minutes % 60 === 0)
                                        {{ $minutes / 60 }} {{ trans_choice('messages.schedule_template_hours', $minutes / 60) }}
                                    @elseif($minutes >= 60)
                                        {{ floor($minutes / 60) }}h {{ $minutes % 60 }}m
                                    @else
                                        {{ __('messages.schedule_template_minutes', ['count' => $minutes]) }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('break_between_minutes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Active Checkbox --}}
                <div class="flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', '1') ? 'checked' : '' }}
                           class="rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500 dark:bg-gray-700">
                    <label for="is_active" class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.schedule_template_active_desc') }}</label>
                </div>

                {{-- Effective Dates --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="effective_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_effective_from') }} <span class="text-gray-400 font-normal">({{ __('messages.schedule_template_optional') }})</span></label>
                        <input type="date" name="effective_from" id="effective_from" value="{{ old('effective_from') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                        @error('effective_from')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="effective_until" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_effective_until') }} <span class="text-gray-400 font-normal">({{ __('messages.schedule_template_optional') }})</span></label>
                        <input type="date" name="effective_until" id="effective_until" value="{{ old('effective_until') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                        @error('effective_until')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Max Weeks Ahead --}}
                <div>
                    <label for="max_weeks_ahead" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.schedule_template_weeks_ahead') }}</label>
                    <input type="number" name="max_weeks_ahead" id="max_weeks_ahead" value="{{ old('max_weeks_ahead', 4) }}" min="1" max="12"
                           class="w-32 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 shadow-sm focus:border-red-500 focus:ring-red-500">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('messages.schedule_template_weeks_ahead_desc') }}</p>
                    @error('max_weeks_ahead')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" id="previewBtn"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        {{ __('messages.schedule_template_preview') }}
                    </button>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
                        {{ __('messages.schedule_template_create') }}
                    </button>
                </div>
            </form>

            {{-- Slot Preview Area --}}
            <div id="previewArea" class="hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3">{{ __('messages.schedule_template_preview_title') }}</h3>
                <div id="previewContent" class="text-sm text-gray-700 dark:text-gray-300"></div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('previewBtn').addEventListener('click', async function () {
            const form = document.getElementById('templateForm');
            const formData = new FormData(form);
            const previewArea = document.getElementById('previewArea');
            const previewContent = document.getElementById('previewContent');

            previewContent.innerHTML = '<p class="text-gray-500 dark:text-gray-400">{{ __('messages.schedule_template_preview_generating') }}</p>';
            previewArea.classList.remove('hidden');

            try {
                const response = await fetch('{{ route("admin.schedule-templates.preview") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok) {
                    const errors = data.errors ? Object.values(data.errors).flat().join('<br>') : '{{ __('messages.schedule_template_validation_failed') }}';
                    previewContent.innerHTML = '<p class="text-red-600 dark:text-red-400">' + errors + '</p>';
                    return;
                }

                if (data.slots && data.slots.length > 0) {
                    let html = '<p class="mb-3 font-medium text-gray-800 dark:text-gray-200">' + data.total + ' {{ __('messages.schedule_template_preview_count') }}</p>';

                    // Group slots by date
                    const grouped = {};
                    data.slots.forEach(function (slot) {
                        if (!grouped[slot.date]) {
                            grouped[slot.date] = { day: slot.day, slots: [] };
                        }
                        grouped[slot.date].slots.push(slot.time_range);
                    });

                    Object.keys(grouped).forEach(function (date) {
                        const group = grouped[date];
                        html += '<div class="mb-4">';
                        html += '<h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">' + group.day + ' — ' + date + '</h4>';
                        html += '<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">';
                        group.slots.forEach(function (time) {
                            html += '<span class="inline-block px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-xs text-center">' + time + '</span>';
                        });
                        html += '</div></div>';
                    });

                    previewContent.innerHTML = html;
                } else {
                    previewContent.innerHTML = '<p class="text-gray-500 dark:text-gray-400">{{ __('messages.schedule_template_preview_empty') }}</p>';
                }
            } catch (err) {
                previewContent.innerHTML = '<p class="text-red-600 dark:text-red-400">{{ __('messages.schedule_template_preview_error') }}</p>';
            }
        });
    </script>
    @endpush
</x-app-layout>
