<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.activity_log_title') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.appointments.slots') }}" class="bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 text-white text-sm px-5 py-2.5 rounded-lg transition-all duration-300 font-semibold shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                    </svg>
                    {{ __('messages.admin_manage_slots') }}
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
            
            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 p-6">
                <form method="GET" action="{{ route('admin.appointments.activityLog') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="action" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.filter_action_type') }}
                        </label>
                        <select name="action" id="action" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30">
                            <option value="">{{ __('messages.all_actions') }}</option>
                            <option value="approved" {{ request('action') == 'approved' ? 'selected' : '' }}>{{ __('messages.action_approved') }}</option>
                            <option value="rejected" {{ request('action') == 'rejected' ? 'selected' : '' }}>{{ __('messages.action_rejected') }}</option>
                            <option value="completed" {{ request('action') == 'completed' ? 'selected' : '' }}>{{ __('messages.action_completed') }}</option>
                            <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>{{ __('messages.action_created') }}</option>
                            <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>{{ __('messages.action_deleted') }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.date_from') }}
                        </label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30">
                    </div>
                    <div>
                        <label for="date_to" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.date_to') }}
                        </label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-300 shadow-sm hover:shadow-md">
                            {{ __('messages.action_filter') }}
                        </button>
                    </div>
                </form>
            </div>

            <!-- Activity Log -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    @if ($activities->isEmpty())
                        <div class="text-center py-16">
                            <div class="bg-gray-100 dark:bg-gray-700/50 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <p class="text-gray-600 dark:text-gray-400 font-semibold text-lg">
                                {{ __('messages.no_activity_yet') }}
                            </p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($activities as $activity)
                                @php
                                    $borderColor = match($activity->action) {
                                        'approved', 'completed' => 'border-green-500',
                                        'rejected', 'deleted' => 'border-red-500',
                                        'created' => 'border-blue-500',
                                        default => 'border-gray-400',
                                    };
                                    $badgeColor = match($activity->action) {
                                        'approved', 'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'rejected', 'deleted' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        'created' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        default => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400',
                                    };
                                @endphp
                                <div class="border-l-4 {{ $borderColor }} bg-gray-50 dark:bg-gray-700/50 rounded-r-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeColor }}">
                                                    {{ strtoupper($activity->action) }}
                                                </span>
                                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $activity->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-gray-900 dark:text-gray-100 font-medium mb-1">
                                                {{ $activity->description }}
                                            </p>
                                            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                @if($activity->user)
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                                        </svg>
                                                        {{ $activity->user->name }}
                                                    </span>
                                                @endif
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ $activity->created_at->format('M d, Y g:i A') }}
                                                </span>
                                                @if($activity->ip_address)
                                                    <span class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                                                        </svg>
                                                        {{ $activity->ip_address }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $activities->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
