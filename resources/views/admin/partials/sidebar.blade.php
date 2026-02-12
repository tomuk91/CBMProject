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
         data-tour="sidebar"
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
            {{-- OVERVIEW SECTION --}}
            <div class="px-3 pt-2 pb-1">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('messages.sidebar_section_overview') }}</p>
            </div>

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.dashboard') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                {{ __('messages.sidebar_dashboard') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_dashboard')" position="right" /></span>
            </a>

            {{-- APPOINTMENTS SECTION --}}
            <div class="px-3 pt-4 pb-1" data-tour="sidebar-appointments">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('messages.sidebar_section_appointments') }}</p>
            </div>

            {{-- Calendar --}}
            <a href="{{ route('admin.appointments.calendar') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.calendar') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ __('messages.sidebar_calendar') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_calendar')" position="right" /></span>
            </a>

            {{-- Pending Requests --}}
            <a href="{{ route('admin.appointments.pending') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.pending') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ __('messages.sidebar_pending_requests') }}
                <span class="ml-auto flex items-center gap-1">
                    <x-help-hint :text="__('messages.help_pending')" position="right" />
                    @php
                        $sidebarPendingCount = \App\Models\PendingAppointment::where('status', 'pending')->count();
                    @endphp
                    @if($sidebarPendingCount > 0)
                        <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $sidebarPendingCount }}</span>
                    @endif
                </span>
            </a>

            {{-- Slot Management --}}
            <a href="{{ route('admin.appointments.slots') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.slots') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('messages.sidebar_slot_management') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_slots')" position="right" /></span>
            </a>

            {{-- Schedule Templates --}}
            <a href="{{ route('admin.schedule-templates.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.schedule-templates.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                {{ __('messages.sidebar_schedule_templates') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_schedule_templates')" position="right" /></span>
            </a>

            {{-- Blocked Dates --}}
            <a href="{{ route('admin.blocked-dates.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.blocked-dates.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                </svg>
                {{ __('messages.sidebar_blocked_dates') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_blocked_dates')" position="right" /></span>
            </a>

            {{-- Service Types --}}
            <a href="{{ route('admin.service-types.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.service-types.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('messages.sidebar_service_types') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_service_types')" position="right" /></span>
            </a>

            {{-- REPORTS SECTION --}}
            <div class="px-3 pt-4 pb-1" data-tour="sidebar-reports">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('messages.sidebar_section_reports') }}</p>
            </div>

            {{-- Analytics --}}
            <a href="{{ route('admin.analytics') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.analytics*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                {{ __('messages.sidebar_analytics') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_analytics')" position="right" /></span>
            </a>

            {{-- Activity Log --}}
            <a href="{{ route('admin.appointments.activityLog') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.appointments.activityLog') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                {{ __('messages.sidebar_activity_log') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_activity_log')" position="right" /></span>
            </a>

            {{-- SYSTEM SECTION --}}
            <div class="px-3 pt-4 pb-1" data-tour="sidebar-system">
                <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ __('messages.sidebar_section_system') }}</p>
            </div>

            {{-- Settings --}}
            <a href="{{ route('admin.settings') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.settings') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('messages.admin_settings') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_settings')" position="right" /></span>
            </a>

            {{-- Customers --}}
            <a href="{{ route('admin.customers.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.customers.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ __('messages.sidebar_customers') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_customers')" position="right" /></span>
            </a>

            {{-- Contact Submissions --}}
            <a href="{{ route('admin.contact-submissions.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.contact-submissions.*') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                {{ __('messages.sidebar_contact_submissions') }}
                <span class="ml-auto flex items-center gap-1">
                    <x-help-hint :text="__('messages.help_contact_submissions')" position="right" />
                    @php
                        $unreadSubmissions = \App\Models\ContactSubmission::where('is_read', false)->count();
                    @endphp
                    @if($unreadSubmissions > 0)
                        <span class="inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $unreadSubmissions }}</span>
                    @endif
                </span>
            </a>

            {{-- Notifications --}}
            <a href="{{ route('admin.notifications') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200
                      {{ request()->routeIs('admin.notifications') ? 'bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 border-l-4 border-red-600 dark:border-red-500 pl-2' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-red-600 dark:hover:text-red-400' }}">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                {{ __('messages.sidebar_notifications') }}
                <span class="ml-auto"><x-help-hint :text="__('messages.help_notifications')" position="right" /></span>
            </a>

        </div>
    </nav>
</aside>
