{{-- Admin Sidebar Navigation --}}
<aside x-data="{ sidebarOpen: false }" class="flex-shrink-0">
    {{-- Mobile toggle button --}}
    <button @click="sidebarOpen = !sidebarOpen"
            class="lg:hidden fixed bottom-4 right-4 z-50 bg-red-600 hover:bg-red-700 text-white p-3 rounded-full shadow-lg transition-all duration-300"
            :aria-expanded="sidebarOpen"
            aria-label="{{ __('messages.sidebar_toggle') }}">
        <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg x-show="sidebarOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    {{-- Sidebar overlay for mobile --}}
    <div x-show="sidebarOpen" x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         x-transition:enter="transition-opacity ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>

    {{-- Sidebar panel --}}
    <nav :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
         class="fixed lg:sticky top-0 lg:top-16 left-0 z-50 lg:z-10 w-64 h-screen lg:h-[calc(100vh-4rem)] bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 overflow-y-auto transform transition-transform duration-300 ease-in-out"
         aria-label="{{ __('messages.sidebar_admin_navigation') }}">

        {{-- Sidebar header --}}
        <div class="px-4 py-5 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0 w-10 h-10 bg-red-600 dark:bg-red-700 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ __('messages.sidebar_admin_panel') }}</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('messages.sidebar_management') }}</p>
                </div>
            </div>
        </div>

        {{-- Navigation links --}}
        <div class="px-3 py-4 space-y-1">
            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                {{ __('messages.sidebar_dashboard') }}
            </a>

            {{-- Calendar --}}
            <a href="{{ route('admin.appointments.calendar') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.calendar') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ __('messages.sidebar_calendar') }}
            </a>

            {{-- Pending Requests --}}
            <a href="{{ route('admin.appointments.pending') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.pending') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('messages.sidebar_pending_requests') }}
                @php
                    $sidebarPendingCount = \App\Models\PendingAppointment::where('status', 'pending')->count();
                @endphp
                @if($sidebarPendingCount > 0)
                    <span class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $sidebarPendingCount }}</span>
                @endif
            </a>

            {{-- Slot Management --}}
            <a href="{{ route('admin.appointments.slots') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.slots') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('messages.sidebar_slot_management') }}
            </a>

            {{-- Schedule Templates --}}
            <a href="{{ route('admin.schedule-templates.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.schedule-templates.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                {{ __('messages.sidebar_schedule_templates') }}
            </a>

            {{-- Blocked Dates --}}
            <a href="{{ route('admin.blocked-dates.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.blocked-dates.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                {{ __('messages.sidebar_blocked_dates') }}
            </a>

            {{-- Analytics --}}
            <a href="{{ route('admin.analytics') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.analytics*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                {{ __('messages.sidebar_analytics') }}
            </a>

            {{-- Activity Log --}}
            <a href="{{ route('admin.appointments.activityLog') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.activityLog') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                {{ __('messages.sidebar_activity_log') }}
            </a>
        </div>
    </nav>
</aside>
