<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ⚙️ {{ __('messages.admin_settings') }}
        </h2>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-4 lg:px-6 space-y-6">

            {{-- Info banner --}}
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-5 py-4 rounded-xl flex items-start shadow-sm">
                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm">{{ __('messages.admin_settings_env_note') }}</p>
            </div>

            {{-- Settings card --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.admin_settings_subtitle') }}</h3>
                </div>

                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($settings as $setting)
                        <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $setting['label'] }}</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-lg">{{ $setting['value'] ?: '—' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Quick links --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.admin_settings') }}</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <a href="{{ route('admin.service-types.index') }}" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition group border border-gray-200 dark:border-gray-600">
                        <span class="text-2xl mr-3">🔧</span>
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition">{{ __('messages.service_types_title') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.service_types_manage_desc') }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.schedule-templates.index') }}" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition group border border-gray-200 dark:border-gray-600">
                        <span class="text-2xl mr-3">📅</span>
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition">{{ __('messages.sidebar_schedule_templates') }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.blocked-dates.index') }}" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition group border border-gray-200 dark:border-gray-600">
                        <span class="text-2xl mr-3">🚫</span>
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition">{{ __('messages.sidebar_blocked_dates') }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.blocked_dates_subtitle') }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.appointments.activityLog') }}" class="flex items-center p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700/50 transition group border border-gray-200 dark:border-gray-600">
                        <span class="text-2xl mr-3">📋</span>
                        <div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition">{{ __('messages.sidebar_activity_log') }}</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
