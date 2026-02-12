<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ⚙️ {{ __('messages.admin_settings') }}
            <x-help-hint :text="__('messages.help_settings')" position="bottom" />
        </h2>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-4 lg:px-6 space-y-6">

            {{-- Info banner --}}
            <div data-tour="settings-info" class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-5 py-4 rounded-xl flex items-start shadow-sm">
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
            <div data-tour="settings-links" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-100 dark:border-gray-700">
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

    @include('admin.partials.tour', [
        'tourPage' => 'settings',
        'tourSteps' => [
            [
                'target' => null,
                'title' => __('messages.tour_settings_welcome_title'),
                'description' => __('messages.tour_settings_welcome_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
            [
                'target' => '[data-tour="settings-info"]',
                'title' => __('messages.tour_settings_info_title'),
                'description' => __('messages.tour_settings_info_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>',
                'position' => 'bottom',
            ],
            [
                'target' => '[data-tour="settings-links"]',
                'title' => __('messages.tour_settings_links_title'),
                'description' => __('messages.tour_settings_links_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"/></svg>',
                'position' => 'top',
            ],
            [
                'target' => null,
                'title' => __('messages.tour_settings_complete_title'),
                'description' => __('messages.tour_settings_complete_description'),
                'icon' => '<svg class="w-7 h-7 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
                'position' => 'center',
            ],
        ],
    ])
</x-app-layout>
