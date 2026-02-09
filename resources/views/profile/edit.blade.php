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
                            <a href="{{ route('profile.edit') }}" class="{{ !isset($section) || $section === 'overview' ? 'bg-red-50 dark:bg-red-900/20 text-gray-900 dark:text-gray-100 border-l-4 border-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                                {{ __('messages.admin_overview') }}
                            </a>

                            <a href="{{ route('profile.personal-info') }}" class="{{ isset($section) && $section === 'personal-info' ? 'bg-red-50 dark:bg-red-900/20 text-gray-900 dark:text-gray-100 border-l-4 border-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                </svg>
                                {{ __('messages.profile_personal_info') }}
                            </a>

                            <a href="{{ route('vehicles.index') }}" class="{{ request()->routeIs('vehicles.index') ? 'bg-red-50 dark:bg-red-900/20 text-gray-900 dark:text-gray-100 border-l-4 border-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                                {{ __('messages.vehicle_management') }}
                            </a>

                            <a href="{{ route('profile.security') }}" class="{{ isset($section) && $section === 'security' ? 'bg-red-50 dark:bg-red-900/20 text-gray-900 dark:text-gray-100 border-l-4 border-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }} group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                                {{ __('messages.profile_security') }}
                            </a>

                            <a href="#" onclick="event.preventDefault(); document.getElementById('gdpr-section').scrollIntoView({behavior: 'smooth'});" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
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
                <div class="flex-1 space-y-4">
                    @if(!isset($section) || $section === 'overview')
                        <!-- Welcome Banner -->
                        <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl shadow-xl overflow-hidden">
                            <div class="px-6 py-10">
                                <div class="flex items-center">
                                    <div class="bg-white/20 p-4 rounded-xl">
                                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-5">
                                        <h1 class="text-3xl font-bold text-white">{{ __('messages.dashboard_welcome') }}, {{ $user->name }}!</h1>
                                        <p class="text-red-100 text-lg mt-1">{{ __('messages.profile_manage_info') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform hover:shadow-lg transition duration-300">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                            <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-5 flex-1">
                                            <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ __('messages.dashboard_total_appointments') }}</p>
                                            <p class="text-3xl font-bold text-red-700 dark:text-red-300">{{ $user->appointments->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform hover:shadow-lg transition duration-300">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                            <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-5 flex-1">
                                            <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ __('messages.status_completed') }}</p>
                                            <p class="text-3xl font-bold text-red-700 dark:text-red-300">{{ $user->appointments->where('status', 'completed')->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transform hover:shadow-lg transition duration-300">
                                <div class="p-6">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                            <svg class="h-7 w-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-5 flex-1">
                                            <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ __('messages.status_pending') }}</p>
                                            <p class="text-3xl font-bold text-red-700 dark:text-red-300">{{ $user->appointments->where('status', 'pending')->count() }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Information Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                            <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                    </svg>
                                    {{ __('messages.profile_overview') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.profile_quick_overview') }}</p>
                            </div>

                            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                                <a href="{{ route('profile.personal-info') }}" class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition cursor-pointer">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.profile_name') }}</dt>
                                            <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</dd>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </a>
                                <a href="{{ route('profile.personal-info') }}" class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition cursor-pointer">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.profile_email') }}</dt>
                                            <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-gray-100">{{ $user->email }}</dd>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </a>
                                <a href="{{ route('profile.personal-info') }}" class="block px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition cursor-pointer">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.profile_phone') }}</dt>
                                            <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-gray-100">{{ $user->phone ?? __('messages.not_set') }}</dd>
                                        </div>
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </a>
                                <div class="px-6 py-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.account_status') }}</dt>
                                            <dd class="mt-1">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    {{ __('messages.status_active') }}
                                                </span>
                                            </dd>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-6 py-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('messages.member_since') }}</dt>
                                            <dd class="mt-1 text-base font-semibold text-gray-900 dark:text-gray-100">{{ $user->created_at->locale(app()->getLocale())->translatedFormat('F j, Y') }}</dd>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Information Card -->
                        @if($user->primaryVehicle)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 bg-red-50 dark:bg-red-900/20 rounded-xl p-3">
                                        <svg class="h-8 w-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                        </svg>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-sm font-medium text-red-600 dark:text-red-400">{{ __('messages.vehicle_information') }}</h3>
                                        <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                                            {{ $user->primaryVehicle->full_name }}
                                        </h4>
                                        <dl class="mt-3 space-y-2">
                                            @if($user->primaryVehicle->color)
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-2 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('messages.vehicle_color') }}: <span class="font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $user->primaryVehicle->color }}</span>
                                            </div>
                                            @endif
                                            @if($user->primaryVehicle->plate)
                                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 mr-2 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L5 10.274zm10 0l-.818 2.552c.25.112.526.174.818.174.292 0 .569-.062.818-.174L15 10.274z" clip-rule="evenodd"/>
                                                </svg>
                                                {{ __('messages.vehicle_plate') }}: <span class="font-mono font-semibold text-gray-900 dark:text-gray-100 ml-1">{{ $user->primaryVehicle->plate }}</span>
                                            </div>
                                            @endif
                                        </dl>
                                        <a href="{{ route('vehicles.index') }}" class="mt-4 inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 transition">
                                            {{ __('messages.vehicle_manage') }}
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600">
                            <div class="p-6 text-center">
                                <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.vehicle_no_info') }}</h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.vehicle_add_description') }}</p>
                                <a href="{{ route('profile.vehicle') }}" class="mt-4 inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-lg transition shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    {{ __('messages.vehicle_add') }}
                                </a>
                            </div>
                        </div>
                        @endif
                    @elseif($section === 'personal-info')
                        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                            <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                    </svg>
                                    {{ __('messages.profile_personal_info') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.profile_update_info') }}</p>
                            </div>
                            <div class="p-6">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    @elseif($section === 'vehicle')
                        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                            <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                    </svg>
                                    {{ __('messages.vehicle_information') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.vehicle_update_details') }}</p>
                            </div>
                            <div class="p-6">
                                @include('profile.partials.update-vehicle-information-form')
                            </div>
                        </div>
                    @elseif($section === 'security')
                        <div class="space-y-4">
                            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                                <div class="px-6 py-5 bg-gray-50 dark:bg-gray-700/50">
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('messages.profile_change_password') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.profile_password_desc') }}</p>
                                </div>
                                <div class="p-6">
                                    @include('profile.partials.update-password-form')
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border-2 border-red-200 dark:border-red-900">
                                <div class="px-6 py-4 bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-b border-red-200 dark:border-red-900">
                                    <h2 class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('messages.profile_delete_account') }}
                                    </h2>
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ __('messages.profile_delete_desc') }}</p>
                                </div>
                                <div class="p-6">
                                    @include('profile.partials.delete-user-form')
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- GDPR Data Management Section -->
                    <div id="gdpr-section" class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700">
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center mb-6">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('messages.gdpr_title') }}</h2>
                            </div>

                            <p class="text-gray-600 dark:text-gray-400 mb-8">
                                {{ __('messages.gdpr_description') }}
                            </p>

                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Export Data -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
                                    <div class="flex items-start">
                                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.gdpr_export_title') }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                {{ __('messages.gdpr_export_description') }}
                                            </p>
                                            <a href="{{ route('profile.export-data') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition shadow-sm">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                {{ __('messages.gdpr_export_button') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Account -->
                                <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-6 border border-red-200 dark:border-red-800">
                                    <div class="flex items-start">
                                        <svg class="w-8 h-8 text-red-600 dark:text-red-400 mr-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ __('messages.gdpr_delete_title') }}</h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                                {{ __('messages.gdpr_delete_description') }}
                                            </p>
                                            <button onclick="document.getElementById('deletionModal').classList.remove('hidden')" 
                                                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition shadow-sm">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                {{ __('messages.gdpr_delete_button') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                                <div class="flex">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                        {{ __('messages.gdpr_warning') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Deletion Confirmation Modal -->
    <div id="deletionModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
        <div class="relative mx-auto w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('messages.gdpr_delete_confirm_title') }}</h3>
                    <button onclick="document.getElementById('deletionModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <p class="text-sm text-red-800 dark:text-red-200">
                        {{ __('messages.gdpr_delete_warning') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('profile.request-deletion') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.profile_password') }}
                        </label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-gray-100">
                    </div>

                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="confirmation" value="1" required
                                   class="mt-1 w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                {{ __('messages.gdpr_delete_checkbox') }}
                            </span>
                        </label>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('deletionModal').classList.add('hidden')"
                                class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white rounded-lg font-semibold transition">
                            {{ __('messages.cancel') }}
                        </button>
                        <button type="submit"
                                class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition">
                            {{ __('messages.gdpr_delete_confirm') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
