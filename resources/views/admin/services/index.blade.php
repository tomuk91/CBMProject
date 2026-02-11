<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.admin_services') }}
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
                        <h1 class="text-3xl font-bold text-white mb-2">{{ __('messages.admin_services') }}</h1>
                        <p class="text-red-100 text-lg">{{ __('messages.admin_services_subtitle') }}</p>
                    </div>
                </div>

                {{-- Info banner --}}
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-sm text-blue-700 dark:text-blue-300">{{ __('messages.admin_settings_env_note') }}</p>
                    </div>
                </div>

                {{-- Service Cards Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($services as $service)
                        <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                            <div class="h-2 bg-gradient-to-r from-red-500 to-red-600"></div>
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                        {{ __('messages.admin_service_minutes', ['duration' => $service['duration']]) }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-1">{{ $service['name'] }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ $service['description'] }}</p>
                                <div class="flex items-center text-xs text-gray-400 dark:text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ __('messages.admin_service_duration') }}: {{ $service['duration'] }} min
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
