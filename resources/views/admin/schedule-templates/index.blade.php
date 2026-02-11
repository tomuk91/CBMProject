@php
    $dayKeys = ['day_sunday', 'day_monday', 'day_tuesday', 'day_wednesday', 'day_thursday', 'day_friday', 'day_saturday'];
    $grouped = $templates->groupBy('day_of_week')->sortKeys();
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.schedule_templates') }}
            </h2>
            <div data-tour="templates-header-actions" class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.appointments.slots') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    {{ __('messages.schedule_template_back_to_slots') }}
                </a>
                <a href="{{ route('admin.blocked-dates.index') }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/></svg>
                    {{ __('messages.blocked_dates') }}
                </a>
                <a href="{{ route('admin.schedule-templates.create') }}"
                   class="inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
                    {{ __('messages.schedule_template_create') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-6 space-y-6">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)"
                     class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700 dark:hover:text-green-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition
                     class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ session('error') }}
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700 dark:hover:text-red-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                    </button>
                </div>
            @endif

            {{-- Admin Guidelines --}}
            <div data-tour="templates-guidelines" x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
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

            @if ($templates->isEmpty())
                {{-- Empty State --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-12 text-center border border-gray-100 dark:border-gray-700">
                    <svg class="mx-auto h-16 w-16 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.schedule_template_none') }}</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">{{ __('messages.schedule_template_none_desc') }}</p>
                    <a href="{{ route('admin.schedule-templates.create') }}"
                       class="mt-6 inline-flex items-center px-5 py-2.5 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/></svg>
                        {{ __('messages.schedule_template_create_first') }}
                    </a>
                </div>
            @else
                {{-- Bulk Actions --}}
                <div data-tour="templates-bulk-actions" x-data="bulkActions()" x-cloak>
                    {{-- Bulk Action Bar --}}
                    <div x-show="selectedIds.length > 0" x-transition
                         class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl px-4 py-3 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-sm">
                        <span class="text-sm font-semibold text-red-700 dark:text-red-300">
                            <span x-text="selectedIds.length"></span> {{ __('messages.schedule_template_selected') }}
                        </span>
                        <div class="flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('admin.schedule-templates.bulk-activate') }}" class="inline">
                                @csrf
                                <template x-for="id in selectedIds" :key="id">
                                    <input type="hidden" name="template_ids[]" :value="id">
                                </template>
                                <button type="submit" onclick="return confirm('{{ __('messages.schedule_template_confirm_bulk_activate') }}')"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900/40 border border-green-300 dark:border-green-700 rounded-lg hover:bg-green-200 dark:hover:bg-green-900/60 transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    {{ __('messages.schedule_template_bulk_activate') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.schedule-templates.bulk-deactivate') }}" class="inline">
                                @csrf
                                <template x-for="id in selectedIds" :key="id">
                                    <input type="hidden" name="template_ids[]" :value="id">
                                </template>
                                <button type="submit" onclick="return confirm('{{ __('messages.schedule_template_confirm_bulk_deactivate') }}')"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/></svg>
                                    {{ __('messages.schedule_template_bulk_deactivate') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.schedule-templates.bulk-delete') }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <template x-for="id in selectedIds" :key="id">
                                    <input type="hidden" name="template_ids[]" :value="id">
                                </template>
                                <button type="submit" onclick="return confirm('{{ __('messages.schedule_template_confirm_bulk_delete') }}')"
                                        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold text-red-700 dark:text-red-300 bg-red-100 dark:bg-red-900/40 border border-red-300 dark:border-red-700 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/60 transition-all duration-200">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    {{ __('messages.schedule_template_bulk_delete') }}
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Templates Grouped by Day --}}
                    @foreach ($grouped as $dayIndex => $dayTemplates)
                        <div class="mb-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700" @if($loop->first) data-tour="templates-day-group" @endif>
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('messages.' . $dayKeys[$dayIndex]) }}</h3>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700/30">
                                        <tr>
                                            <th class="px-4 py-3 text-left">
                                                <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:bg-gray-700"
                                                       @change="toggleDay({{ $dayIndex }}, $event.target.checked)">
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.schedule_template_name') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.schedule_template_time_window') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.schedule_template_duration') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.schedule_template_break') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.schedule_template_active') }}</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.schedule_template_weeks_ahead') }}</th>
                                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.slots_actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach ($dayTemplates as $template)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150" data-day="{{ $dayIndex }}">
                                                <td class="px-4 py-4">
                                                    <input type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-red-600 focus:ring-red-500 dark:bg-gray-700 template-checkbox"
                                                           value="{{ $template->id }}"
                                                           @change="toggleTemplate({{ $template->id }}, $event.target.checked)">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $template->name }}</div>
                                                    @if ($template->effective_from || $template->effective_until)
                                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                            @if ($template->effective_from)
                                                                {{ __('messages.schedule_template_from_date', ['date' => $template->effective_from->format('M j, Y')]) }}
                                                            @endif
                                                            @if ($template->effective_until)
                                                                {{ $template->effective_from ? ' — ' : '' }}{{ __('messages.schedule_template_until_date', ['date' => $template->effective_until->format('M j, Y')]) }}
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                    {{ \Carbon\Carbon::parse($template->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($template->end_time)->format('H:i') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                    {{ __('messages.schedule_template_minutes', ['count' => $template->slot_duration_minutes]) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                    {{ __('messages.schedule_template_minutes', ['count' => $template->break_between_minutes]) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <form action="{{ route('admin.schedule-templates.toggle', $template) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-all duration-200 {{ $template->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 hover:bg-green-200 dark:hover:bg-green-900/60' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                                                            @if ($template->is_active)
                                                                <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5"></span> {{ __('messages.schedule_template_active') }}
                                                            @else
                                                                <span class="w-2 h-2 bg-gray-400 rounded-full mr-1.5"></span> {{ __('messages.schedule_template_inactive') }}
                                                            @endif
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                                    {{ __('messages.schedule_template_weeks', ['count' => $template->max_weeks_ahead]) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <a href="{{ route('admin.schedule-templates.edit', $template) }}"
                                                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200" title="{{ __('messages.action_edit') }}">
                                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                            {{ __('messages.action_edit') }}
                                                        </a>
                                                        <form action="{{ route('admin.schedule-templates.duplicate', $template) }}" method="POST" class="inline">
                                                            @csrf
                                                            <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200" title="{{ __('messages.schedule_template_duplicate') }}">
                                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                                                {{ __('messages.schedule_template_duplicate') }}
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.schedule-templates.destroy', $template) }}" method="POST" class="inline"
                                                              onsubmit="return confirm('{{ __('messages.schedule_template_confirm_delete') }}')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 dark:text-red-400 bg-white dark:bg-gray-700 border border-red-300 dark:border-red-600/50 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200" title="{{ __('messages.action_delete') }}">
                                                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                {{ __('messages.action_delete') }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>

                <script>
                    function bulkActions() {
                        return {
                            selectedIds: [],
                            toggleTemplate(id, checked) {
                                if (checked) {
                                    if (!this.selectedIds.includes(id)) this.selectedIds.push(id);
                                } else {
                                    this.selectedIds = this.selectedIds.filter(i => i !== id);
                                }
                            },
                            toggleDay(dayIndex, checked) {
                                document.querySelectorAll('tr[data-day="' + dayIndex + '"] .template-checkbox').forEach(cb => {
                                    cb.checked = checked;
                                    const id = parseInt(cb.value);
                                    if (checked) {
                                        if (!this.selectedIds.includes(id)) this.selectedIds.push(id);
                                    } else {
                                        this.selectedIds = this.selectedIds.filter(i => i !== id);
                                    }
                                });
                            }
                        };
                    }
                </script>
            @endif

        </div>
    </div>
    @include('admin.partials.tour', [
        'tourPage' => 'schedule-templates',
        'tourSteps' => [
            [
                'target' => null,
                'title' => __('messages.tour_templates_welcome_title'),
                'description' => __('messages.tour_templates_welcome_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
            [
                'target' => '[data-tour="templates-header-actions"]',
                'title' => __('messages.tour_templates_actions_title'),
                'description' => __('messages.tour_templates_actions_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="templates-guidelines"]',
                'title' => __('messages.tour_templates_guidelines_title'),
                'description' => __('messages.tour_templates_guidelines_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="templates-day-group"]',
                'title' => __('messages.tour_templates_daygroup_title'),
                'description' => __('messages.tour_templates_daygroup_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>',
                'position' => 'top',
            ],
            [
                'target' => '[data-tour="templates-bulk-actions"]',
                'title' => __('messages.tour_templates_bulk_title'),
                'description' => __('messages.tour_templates_bulk_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                'position' => 'top',
            ],
            [
                'target' => null,
                'title' => __('messages.tour_templates_complete_title'),
                'description' => __('messages.tour_templates_complete_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
        ],
    ])
</x-app-layout>
