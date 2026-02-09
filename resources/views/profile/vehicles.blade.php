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

                            <a href="{{ route('vehicles.index') }}" class="bg-red-50 dark:bg-red-900/20 text-gray-900 dark:text-gray-100 border-l-4 border-red-600 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
                                <svg class="mr-3 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                </svg>
                                {{ __('messages.vehicle_management') }}
                            </a>

                            <a href="{{ route('profile.service-history') }}" class="text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 group flex items-center px-3 py-2.5 text-sm font-medium rounded-r-md transition">
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
                <div class="flex-1 space-y-4">
                    <!-- Page Header -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl border border-gray-100 dark:border-gray-700">
                        <div class="bg-gradient-to-r from-red-600 via-red-700 to-red-800 px-8 py-10">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="bg-white/20 backdrop-blur-lg p-4 rounded-2xl mr-5 shadow-xl">
                                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h1 class="text-3xl font-bold text-white">
                                            {{ __('messages.vehicle_management') }}
                                        </h1>
                                        <p class="text-red-100 mt-2 text-lg">{{ __('messages.vehicle_manage_description') }}</p>
                                    </div>
                                </div>
                                <button onclick="openAddVehicleModal()" 
                                        class="px-6 py-3 bg-white hover:bg-gray-50 text-red-600 font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                                    </svg>
                                    {{ __('messages.add_vehicle') }}
                                </button>
                            </div>
                        </div>

                        <!-- Stats Summary -->
                        <div class="grid grid-cols-3 divide-x divide-gray-200 dark:divide-gray-700">
                            <div class="px-6 py-4 text-center">
                                <div class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $vehicles->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.total_vehicles') }}</div>
                            </div>
                            <div class="px-6 py-4 text-center">
                                <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $vehicles->where('is_primary', true)->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.primary_vehicle') }}</div>
                            </div>
                            <div class="px-6 py-4 text-center">
                                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $vehicles->pluck('make')->unique()->count() }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ __('messages.different_makes') }}</div>
                            </div>
                        </div>
                    </div>

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-green-800 dark:text-green-200 font-medium">{{ session('success') }}</p>
                        <button @click="show = false" class="text-green-500 hover:text-green-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div x-data="{ show: true }" x-show="show" x-transition class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-red-800 dark:text-red-200 font-medium">{{ session('error') }}</p>
                        <button @click="show = false" class="text-red-500 hover:text-red-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if($vehicles->count() > 0)
                @php
                    $carImageService = app(\App\Services\CarImageService::class);
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($vehicles as $vehicle)
                        @php
                            $carImage = $carImageService->getCarImage($vehicle->make, $vehicle->model, $vehicle->year);
                            $manufacturerLogo = $carImageService->getManufacturerLogo($vehicle->make);
                        @endphp
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <!-- Car Image -->
                            <div class="relative h-48 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                @if($vehicle->image)
                                    <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->full_name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ $carImage }}" alt="{{ $vehicle->full_name }}" class="w-full h-full object-cover">
                                @endif
                                
                                <!-- Manufacturer Logo Overlay -->
                                @if($manufacturerLogo)
                                <div class="absolute top-3 right-3 bg-white dark:bg-gray-800 p-2 rounded-lg shadow-lg">
                                    <img src="{{ $manufacturerLogo }}" alt="{{ $vehicle->make }}" class="h-6 w-auto">
                                </div>
                                @endif
                                
                                <!-- Primary Badge -->
                                @if($vehicle->is_primary)
                                <div class="absolute top-3 left-3">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-green-500 text-white shadow-lg">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ __('messages.primary') }}
                                    </span>
                                </div>
                                @endif
                                
                                <!-- Action Buttons Overlay -->
                                <div class="absolute bottom-3 right-3 flex items-center space-x-2">
                                    <button onclick="openEditVehicleModal({{ $vehicle->id }})" class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition-all">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </button>
                                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete_vehicle') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-gray-700 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition-all">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Card Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                                    {{ $vehicle->full_name }}
                                </h3>
                                
                                <div class="space-y-3 text-sm">
                                    @if($vehicle->color)
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-rose-50 dark:bg-rose-900/20 mr-3">
                                                <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium">{{ $vehicle->color }}</span>
                                        </div>
                                    @endif
                                    @if($vehicle->plate)
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 mr-3">
                                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm1 3h12v8a1 1 0 01-1 1H5a1 1 0 01-1-1V7z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="font-mono font-semibold">{{ $vehicle->plate }}</span>
                                        </div>
                                    @endif
                                    @if($vehicle->fuel_type)
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-green-50 dark:bg-green-900/20 mr-3">
                                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="capitalize">{{ __('messages.vehicle_fuel_' . $vehicle->fuel_type) }}</span>
                                        </div>
                                    @endif
                                    @if($vehicle->transmission)
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-900/20 mr-3">
                                                <svg class="w-4 h-4 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z"/>
                                                </svg>
                                            </div>
                                            <span class="capitalize">{{ __('messages.vehicle_transmission_' . $vehicle->transmission) }}</span>
                                        </div>
                                    @endif
                                    @if($vehicle->mileage)
                                        <div class="flex items-center text-gray-600 dark:text-gray-400">
                                            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/20 mr-3">
                                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <span class="font-semibold">{{ number_format($vehicle->mileage) }} km</span>
                                        </div>
                                    @endif
                                </div>
                                
                                @if(!$vehicle->is_primary)
                                    <form action="{{ route('vehicles.set-primary', $vehicle) }}" method="POST" class="mt-5">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2.5 bg-gradient-to-r from-gray-100 to-gray-50 hover:from-red-50 hover:to-red-100 dark:from-gray-700 dark:to-gray-700 dark:hover:from-red-900/20 dark:hover:to-red-900/20 text-gray-800 dark:text-gray-200 hover:text-red-600 dark:hover:text-red-400 font-semibold rounded-lg transition-all duration-200 border border-gray-200 dark:border-gray-600 hover:border-red-300 dark:hover:border-red-600">
                                            {{ __('messages.set_as_primary') }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('messages.no_vehicles') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ __('messages.no_vehicles_description') }}</p>
                    <button onclick="openAddVehicleModal()" class="inline-flex items-center px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"/>
                        </svg>
                        {{ __('messages.add_your_first_vehicle') }}
                    </button>
                </div>
            @endif
                </div>
            </div>
        </div>
    </div>

    @include('profile.partials.vehicle-modal')
    
    <script>
        // Auto-open modal if there are validation errors
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('vehicleModal').classList.remove('hidden');
            });
        @endif

        function openAddVehicleModal() {
            document.getElementById('vehicleModalTitle').textContent = '{{ __("messages.add_vehicle") }}';
            document.getElementById('vehicleForm').action = '{{ route("vehicles.store") }}';
            document.getElementById('vehicleMethod').value = 'POST';
            document.getElementById('vehicleForm').reset();
            document.getElementById('imagePreviewContainer').classList.add('hidden');
            document.getElementById('vehicleModal').classList.remove('hidden');
        }

        function openEditVehicleModal(vehicleId) {
            // Fetch vehicle data and populate form
            fetch(`/api/vehicles/${vehicleId}`)
                .then(response => response.json())
                .then(vehicle => {
                    document.getElementById('vehicleModalTitle').textContent = '{{ __("messages.edit_vehicle") }}';
                    document.getElementById('vehicleForm').action = `/vehicles/${vehicleId}`;
                    document.getElementById('vehicleMethod').value = 'PUT';
                    
                    // Populate form fields
                    document.getElementById('make').value = vehicle.make;
                    document.getElementById('model').value = vehicle.model;
                    document.getElementById('year').value = vehicle.year;
                    document.getElementById('color').value = vehicle.color || '';
                    document.getElementById('plate').value = vehicle.plate || '';
                    document.getElementById('fuel_type').value = vehicle.fuel_type || '';
                    document.getElementById('transmission').value = vehicle.transmission || '';
                    document.getElementById('engine_size').value = vehicle.engine_size || '';
                    document.getElementById('mileage').value = vehicle.mileage || '';
                    document.getElementById('notes').value = vehicle.notes || '';
                    document.getElementById('is_primary').checked = vehicle.is_primary;
                    
                    // Show current image if exists
                    if (vehicle.image) {
                        document.getElementById('imagePreview').src = `/storage/${vehicle.image}`;
                        document.getElementById('imagePreviewContainer').classList.remove('hidden');
                    } else {
                        document.getElementById('imagePreviewContainer').classList.add('hidden');
                    }
                    
                    document.getElementById('vehicleModal').classList.remove('hidden');
                });
        }

        function closeVehicleModal() {
            document.getElementById('vehicleModal').classList.add('hidden');
            document.getElementById('vehicleForm').reset();
            document.getElementById('imagePreviewContainer').classList.add('hidden');
        }

        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('imagePreviewContainer').classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>
