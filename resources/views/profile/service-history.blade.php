<x-app-layout>
    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <!-- Header -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    {{ __('messages.action_back') }} {{ __('messages.nav_dashboard') }}
                </a>
            </div>

            <div class="flex gap-4">
                <!-- Sidebar Navigation -->
                <div class="w-64 flex-shrink-0">
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50">
                            <h2 class="text-base font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                {{ __('messages.profile_title') }}
                            </h2>
                        </div>
                        <nav class="p-2 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                {{ __('messages.admin_overview') }}
                            </a>

                            <a href="{{ route('profile.personal-info') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                {{ __('messages.profile_personal_info') }}
                            </a>

                            <a href="{{ route('vehicles.index') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                                {{ __('messages.vehicle_management') }}
                            </a>

                            <a href="{{ route('profile.service-history') }}" class="bg-red-50 dark:bg-red-900/20 text-gray-900 dark:text-gray-100 border-l-4 border-red-600 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.service_history') }}
                            </a>

                            <a href="{{ route('profile.security') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.profile_security') }}
                            </a>

                            <a href="#" onclick="event.preventDefault(); window.location.href = '{{ route('profile.edit') }}#gdpr-section';" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.gdpr_title') }}
                            </a>
                        </nav>

                        <div class="border-t border-gray-200 dark:border-gray-700 p-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-3 py-2.5 text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-md transition">
                                    <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ __('messages.nav_logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-2xl border border-gray-100 dark:border-gray-700">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-red-600 via-red-700 to-red-800 px-8 py-10">
                            <div class="flex items-center">
                                <div class="bg-white/20 backdrop-blur-lg p-4 rounded-2xl mr-5 shadow-xl">
                                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-3xl font-bold text-white">
                                        {{ __('messages.service_history') }}
                                    </h1>
                                    <p class="text-red-100 mt-2 text-lg">{{ __('messages.service_history_subtitle') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-8">
                            @if($serviceHistory->count() > 0)
                                <div class="space-y-3">
                                    @foreach($serviceHistory as $service)
                                        <div class="group relative bg-gradient-to-br from-white to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-lg border-2 border-gray-200 dark:border-gray-600 hover:border-red-300 dark:hover:border-red-700 shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
                                            <!-- Accent bar -->
                                            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-green-500 via-emerald-500 to-green-600"></div>
                                            
                                            <div class="flex items-center p-5">
                                                <div class="flex-shrink-0">
                                                    <div class="flex items-center justify-center h-12 w-12 rounded-lg bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/30 dark:to-emerald-900/30 text-green-600 dark:text-green-400 shadow-lg group-hover:scale-105 transition-transform duration-300">
                                                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="ml-4 flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <div class="flex-1">
                                                            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $service->service }}</h3>
                                                            <div class="flex items-center gap-4 mt-2">
                                                                <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                                                    <svg class="inline w-4 h-4 mr-1.5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                    <span class="font-semibold">{{ $service->appointment_date->format('M d, Y • g:i A') }}</span>
                                                                </p>
                                                                @if($service->vehicle_id && $service->vehicle)
                                                                    <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center">
                                                                        <svg class="inline w-4 h-4 mr-1.5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                                                        </svg>
                                                                        <span class="font-semibold">{{ $service->vehicle->full_name }}</span>
                                                                        @if($service->vehicle->plate)
                                                                            <span class="ml-2 text-xs px-2 py-0.5 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 rounded font-mono font-bold shadow-sm border border-gray-300 dark:border-gray-500">{{ $service->vehicle->plate }}</span>
                                                                        @endif
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 dark:from-green-900/30 dark:to-emerald-900/30 dark:text-green-400 shadow-md border border-green-200 dark:border-green-700">
                                                            <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                            {{ __('messages.status_completed') }}
                                                        </span>
                                                    </div>
                                                    
                                                    @if($service->notes)
                                                        <div class="mt-3 p-3 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-l-4 border-blue-500 rounded-lg shadow-sm">
                                                            <p class="text-xs font-bold text-blue-700 dark:text-blue-400 uppercase mb-1 flex items-center">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                                </svg>
                                                                {{ __('messages.customer_notes') }}
                                                            </p>
                                                            <p class="text-sm text-blue-900 dark:text-blue-200">{{ $service->notes }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if($serviceHistory->count() >= 10)
                                    <div class="mt-8 text-center">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 px-6 py-3 rounded-xl inline-block">{{ __('messages.showing_recent_services', ['count' => 10]) }}</p>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-16">
                                    <svg class="mx-auto h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h3 class="mt-4 text-xl font-bold text-gray-900 dark:text-gray-100">{{ __('messages.no_service_history') }}</h3>
                                    <p class="mt-2 text-gray-500 dark:text-gray-400">{{ __('messages.no_service_history_description') }}</p>
                                    <div class="mt-8">
                                        <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg transition">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ __('messages.appointments_book') }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
