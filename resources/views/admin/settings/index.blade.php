<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.admin_settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex bg-gray-50 dark:bg-gray-900 min-h-screen">
        @include('admin.partials.sidebar')

        <div class="flex-1 py-4 min-w-0">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
                {{-- Header --}}
                <div class="bg-gradient-to-r from-red-600 to-red-700 dark:from-red-700 dark:to-red-800 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-white mb-2">{{ __('messages.admin_settings') }}</h1>
                        <p class="text-red-100 text-lg">{{ __('messages.admin_settings_subtitle') }}</p>
                    </div>
                </div>

                {{-- Env note --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-blue-700 dark:text-blue-300">{{ __('messages.admin_settings_env_note') }}</p>
                    </div>
                </div>

                {{-- Settings Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- App Name --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.admin_settings_app_name') }}</p>
                            </div>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $settings['app_name'] }}</p>
                        </div>
                    </div>

                    {{-- Timezone --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.admin_settings_timezone') }}</p>
                            </div>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $settings['timezone'] }}</p>
                        </div>
                    </div>

                    {{-- Locale --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.admin_settings_locale') }}</p>
                            </div>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $settings['locale'] }}</p>
                        </div>
                    </div>

                    {{-- Mail From Address --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.admin_settings_mail_from') }}</p>
                            </div>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $settings['mail_from'] ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Mail From Name --}}
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.admin_settings_mail_name') }}</p>
                            </div>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $settings['mail_from_name'] ?? '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
