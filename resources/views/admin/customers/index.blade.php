<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.admin_customers') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-4 lg:px-6 space-y-6">
                {{-- Search --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <form method="GET" action="{{ route('admin.customers.index') }}" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="{{ __('messages.action_search') }}..."
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-red-500 focus:ring-red-500">
                        </div>
                        <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                            {{ __('messages.action_search') }}
                        </button>
                        @if(request('search'))
                            <a href="{{ route('admin.customers.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 rounded-lg font-medium transition-colors text-center">
                                {{ __('messages.action_clear_filters') }}
                            </a>
                        @endif
                    </form>
                </div>

                {{-- Customers Table --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    @php
                                        $sortDir = request('direction') === 'asc' ? 'desc' : 'asc';
                                    @endphp
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        <a href="{{ route('admin.customers.index', array_merge(request()->except('sort', 'direction'), ['sort' => 'name', 'direction' => request('sort') === 'name' ? $sortDir : 'asc'])) }}" class="flex items-center gap-1 hover:text-red-600 dark:hover:text-red-400">
                                            {{ __('messages.name') }}
                                            @if(request('sort') === 'name')
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M5 5l7 7 7-7' }}"/></svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        <a href="{{ route('admin.customers.index', array_merge(request()->except('sort', 'direction'), ['sort' => 'email', 'direction' => request('sort') === 'email' ? $sortDir : 'asc'])) }}" class="flex items-center gap-1 hover:text-red-600 dark:hover:text-red-400">
                                            {{ __('messages.email') }}
                                            @if(request('sort') === 'email')
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M5 5l7 7 7-7' }}"/></svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        {{ __('messages.phone') }}
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        <a href="{{ route('admin.customers.index', array_merge(request()->except('sort', 'direction'), ['sort' => 'created_at', 'direction' => request('sort') === 'created_at' ? $sortDir : 'desc'])) }}" class="flex items-center gap-1 hover:text-red-600 dark:hover:text-red-400">
                                            {{ __('messages.admin_customer_since') }}
                                            @if(request('sort', 'created_at') === 'created_at')
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="{{ request('direction', 'desc') === 'asc' ? 'M5 15l7-7 7 7' : 'M5 5l7 7 7-7' }}"/></svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                        <a href="{{ route('admin.customers.index', array_merge(request()->except('sort', 'direction'), ['sort' => 'appointments_count', 'direction' => request('sort') === 'appointments_count' ? $sortDir : 'desc'])) }}" class="flex items-center gap-1 hover:text-red-600 dark:hover:text-red-400">
                                            {{ __('messages.admin_total_bookings') }}
                                            @if(request('sort') === 'appointments_count')
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="{{ request('direction') === 'asc' ? 'M5 15l7-7 7 7' : 'M5 5l7 7 7-7' }}"/></svg>
                                            @endif
                                        </a>
                                    </th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($customers as $customer)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                                    <span class="text-red-600 dark:text-red-400 font-semibold text-sm">{{ strtoupper(substr($customer->name, 0, 1)) }}</span>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $customer->name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $customer->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $customer->phone ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $customer->created_at->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                                {{ $customer->appointments_count }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">
                                                {{ __('messages.appointment_view_details') }} →
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <p class="text-lg font-medium">{{ __('messages.admin_no_customers') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($customers->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $customers->links() }}
                        </div>
                    @endif
                </div>
            </div>
    </div>
</x-app-layout>
