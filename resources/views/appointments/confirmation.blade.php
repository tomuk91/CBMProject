<x-app-layout>
    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-4 lg:px-6">
            <!-- Success Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-8 text-center">
                    <!-- Success Icon -->
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full mb-6">
                        <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>

                    <!-- Success Title -->
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                        {{ __('messages.appointments_booking_confirmed') }}
                    </h1>

                    <!-- Success Message -->
                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-xl mx-auto">
                        {{ __('messages.appointments_confirmation_message') }}
                    </p>

                    <!-- Booking Details -->
                    @if(session('booking_details'))
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6 mb-8 text-left max-w-2xl mx-auto">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                {{ __('messages.appointments_booking_details') }}
                            </h2>

                            <div class="space-y-3">
                                <div class="flex border-b border-gray-200 dark:border-gray-700 pb-3">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[120px]">{{ __('messages.profile_name') }}:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ session('booking_details')['name'] }}</span>
                                </div>

                                <div class="flex border-b border-gray-200 dark:border-gray-700 pb-3">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[120px]">{{ __('messages.profile_email') }}:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ session('booking_details')['email'] }}</span>
                                </div>

                                <div class="flex border-b border-gray-200 dark:border-gray-700 pb-3">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[120px]">{{ __('messages.profile_phone') }}:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ session('booking_details')['phone'] }}</span>
                                </div>

                                <div class="flex border-b border-gray-200 dark:border-gray-700 pb-3">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[120px]">{{ __('messages.vehicle_information') }}:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ session('booking_details')['vehicle'] }}</span>
                                </div>

                                <div class="flex border-b border-gray-200 dark:border-gray-700 pb-3">
                                    <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[120px]">{{ __('messages.service_required') }}:</span>
                                    <span class="text-gray-900 dark:text-gray-100">{{ session('booking_details')['service'] }}</span>
                                </div>

                                @if(session('booking_details')['notes'])
                                    <div class="flex">
                                        <span class="font-medium text-gray-700 dark:text-gray-300 min-w-[120px]">{{ __('messages.appointments_notes') }}:</span>
                                        <span class="text-gray-900 dark:text-gray-100">{{ session('booking_details')['notes'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-center max-w-md mx-auto">
                        <a href="{{ route('dashboard') }}" 
                           class="flex-1 px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center font-semibold rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                            {{ __('messages.action_go_dashboard') }}
                        </a>
                        <a href="{{ route('appointments.index') }}" 
                           class="flex-1 px-6 py-3 bg-blue-600 text-white text-center font-semibold rounded-lg hover:bg-blue-700 transition">
                            {{ __('messages.appointments_view_available') }}
                        </a>
                    </div>

                    <!-- Note -->
                    <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <p class="text-sm text-blue-800 dark:text-blue-200 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            {{ __('messages.appointments_arrival_note') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
