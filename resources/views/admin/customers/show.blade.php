<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.admin_customer_details') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
                {{-- Back link --}}
                <div>
                    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        {{ __('messages.back') }}
                    </a>
                </div>

                {{-- Customer Info Card --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="h-2 bg-gradient-to-r from-red-600 to-red-700"></div>
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <div class="flex-shrink-0 h-16 w-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                <span class="text-red-600 dark:text-red-400 font-bold text-2xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.name') }}</p>
                                    <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.email') }}</p>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.phone') }}</p>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $user->phone ?? '—' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.profile_address') }}</p>
                                    <p class="text-gray-900 dark:text-gray-100">
                                        @if($user->address || $user->city)
                                            {{ $user->address }}{{ $user->city ? ', ' . $user->city : '' }}{{ $user->postal_code ? ' ' . $user->postal_code : '' }}
                                        @else
                                            —
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.admin_customer_since') }}</p>
                                    <p class="text-gray-900 dark:text-gray-100">{{ $user->created_at->format('Y-m-d') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">{{ __('messages.admin_total_bookings') }}</p>
                                    <p class="text-red-600 dark:text-red-400 font-bold text-lg">{{ $user->appointments->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Vehicles --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.admin_customer_vehicles') }}</h3>
                    </div>
                    <div class="p-6">
                        @if($user->vehicles->count())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($user->vehicles as $vehicle)
                                    <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                        <div class="flex items-center gap-3 mb-2">
                                            <div class="p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $vehicle->make }} {{ $vehicle->model }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $vehicle->year }} · {{ $vehicle->plate }}</p>
                                            </div>
                                        </div>
                                        @if($vehicle->is_primary)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">{{ __('messages.primary_vehicle') }}</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">{{ __('messages.no_vehicles') }}</p>
                        @endif
                    </div>
                </div>

                {{-- Appointment History --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.admin_customer_history') }}</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.date') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.service_required') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.appointments_vehicle_info') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($user->appointments as $appointment)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            {{ $appointment->appointment_date->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $appointment->service }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusValue = $appointment->status instanceof \App\Enums\AppointmentStatus ? $appointment->status->value : $appointment->status;
                                                $statusColors = [
                                                    'confirmed' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
                                                    'completed' => 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                                                    'cancelled' => 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
                                                    'pending' => 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$statusValue] ?? 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300' }}">
                                                {{ __('messages.status_' . $statusValue) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $appointment->vehicle }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            {{ __('messages.no_appointments_yet') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</x-app-layout>
