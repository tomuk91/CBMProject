<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('messages.analytics_dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Period Selector and Export -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <div></div>
                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <!-- Period Selector -->
                    <form method="GET" class="inline">
                        <select name="period" onchange="this.form.submit()" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="7" {{ $period == 7 ? 'selected' : '' }}>{{ __('messages.analytics_last_7_days') }}</option>
                            <option value="30" {{ $period == 30 ? 'selected' : '' }}>{{ __('messages.analytics_last_30_days') }}</option>
                            <option value="90" {{ $period == 90 ? 'selected' : '' }}>{{ __('messages.analytics_last_90_days') }}</option>
                        </select>
                    </form>
                    
                    <!-- Export Button -->
                    <a href="{{ route('admin.analytics.export', ['period' => $period]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        {{ __('messages.analytics_export_csv') }}
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_total_users') }}</p>
                            <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ number_format($stats['total_users']) }}</p>
                            <p class="text-sm text-green-600 dark:text-green-400 mt-1">+{{ $stats['new_users_period'] }} {{ __('messages.analytics_this_period') }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-full">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

            <!-- Pending Appointments -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_pending_approval') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ number_format($stats['pending_appointments']) }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.analytics_awaiting_action') }}</p>
                    </div>
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900/20 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Appointments -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_total_appointments') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ number_format($stats['total_appointments']) }}</p>
                        <p class="text-sm text-green-600 dark:text-green-400 mt-1">+{{ $stats['appointments_period'] }} {{ __('messages.analytics_this_period') }}</p>
                    </div>
                    <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-full">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cancellation Requests -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_cancellation_requests') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ number_format($stats['cancellation_requests']) }}</p>
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ __('messages.analytics_needs_review') }}</p>
                    </div>
                    <div class="p-3 bg-red-100 dark:bg-red-900/20 rounded-full">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Conversion Rate (#44) -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_conversion_rate') }}</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $stats['conversion_rate'] }}%</p>
                        <p class="text-sm text-green-600 dark:text-green-400 mt-1">{{ __('messages.analytics_completed_of_total') }}</p>
                    </div>
                    <div class="p-3 bg-purple-100 dark:bg-purple-900/20 rounded-full">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Appointments Over Time -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.analytics_appointments_over_time') }}</h3>
                <div class="h-64">
                    <canvas id="appointmentsChart"></canvas>
                </div>
            </div>

            <!-- Appointments by Status -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.analytics_appointments_by_status') }}</h3>
                <div class="h-64 flex items-center justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Services & Busy Times -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Services -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.analytics_top_services') }}</h3>
                <div class="space-y-3">
                    @foreach($topServices as $service)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-gray-300">{{ $service->service }}</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($service->count / $topServices->max('count')) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $service->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Busiest Days -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ __('messages.analytics_busiest_days') }}</h3>
                <div class="space-y-3">
                    @foreach($busiestDays as $day)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700 dark:text-gray-300">{{ $day->day_name }}</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ ($day->count / $busiestDays->max('count')) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $day->count }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Performance Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_no_show_rate') }}</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $noShowRate }}%</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.analytics_of_completed') }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_avg_approval_time') }}</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ $avgApprovalTime ? number_format($avgApprovalTime, 1) : '0' }}h</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.analytics_from_request_to_approval') }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('messages.analytics_available_slots') }}</h3>
                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-2">{{ number_format($stats['available_slots']) }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('messages.analytics_ready_to_book') }}</p>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.analytics_recent_activity') }}</h3>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($recentActivity as $activity)
                <div class="px-6 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start gap-3">
                            <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-full">
                                <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $activity->user ? $activity->user->name : __('messages.analytics_system') }} • 
                                    {{ $activity->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-400">
                            {{ str_replace('_', ' ', $activity->action) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                    {{ __('messages.analytics_no_recent_activity') }}
                </div>
                @endforelse
            </div>
        </div>

        <!-- Chart.js Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            const isDark = document.documentElement.classList.contains('dark');
            const labelColor = isDark ? '#9ca3af' : '#6b7280';
            const gridColor = isDark ? '#374151' : '#e5e7eb';

            // Appointments Over Time Chart
    const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
    new Chart(appointmentsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($appointmentsOverTime->pluck('date')) !!},
            datasets: [{
                label: '{{ __('messages.analytics_appointments_label') }}',
                data: {!! json_encode($appointmentsOverTime->pluck('count')) !!},
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: labelColor
                    },
                    grid: {
                        color: gridColor
                    }
                },
                x: {
                    ticks: {
                        color: labelColor
                    },
                    grid: {
                        color: gridColor
                    }
                }
            }
        }
    });

    // Status Pie Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($appointmentsByStatus->keys()) !!},
            datasets: [{
                data: {!! json_encode($appointmentsByStatus->values()) !!},
                backgroundColor: [
                    'rgb(34, 197, 94)',  // green
                    'rgb(59, 130, 246)',  // blue
                    'rgb(251, 191, 36)',  // yellow
                    'rgb(239, 68, 68)',   // red
                    'rgb(156, 163, 175)'  // gray
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: labelColor
                    }
                }
            }
        }
    });
</script>
        </div>
    </div>
</x-app-layout>
