<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.car-makes.index') }}"
               class="text-gray-500 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.car_make_edit_title', ['name' => $carMake->name]) }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 space-y-6">

            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                     x-init="setTimeout(() => show = false, 5000)"
                     class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4 flex items-center justify-between shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-green-500 hover:text-green-700 ml-4">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif

            {{-- Edit Make --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.car_make_details') }}</h3>
                </div>
                <form action="{{ route('admin.car-makes.update', $carMake) }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    @if ($errors->hasBag('default') || (!$errors->hasBag('model') && $errors->any()))
                        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 rounded-lg">
                            <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.car_make_name') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $carMake->name) }}" required
                               class="w-full px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1"
                               @checked(old('is_active', $carMake->is_active))
                               class="h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('messages.car_make_active') }}
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.car-makes.index') }}"
                           class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-semibold rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 transition-all text-sm">
                            {{ __('messages.action_cancel') }}
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-all text-sm shadow-md">
                            {{ __('messages.car_make_save') }}
                        </button>
                    </div>
                </form>
            </div>

            {{-- Models for this Make --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ __('messages.car_models_for_make', ['make' => $carMake->name]) }}</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.car_models_manage_desc') }}</p>
                    </div>
                </div>

                {{-- Add Model Form --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/30">
                    <form action="{{ route('admin.car-makes.models.store', $carMake) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                        @csrf

                        @error('name', 'model')
                            <p class="w-full text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror

                        <input type="text" name="name" value="{{ old('name') }}"
                               class="flex-1 px-4 py-2.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all text-sm"
                               placeholder="{{ __('messages.car_model_name_placeholder') }}" required>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors text-sm shadow-sm whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ __('messages.car_model_add') }}
                        </button>
                    </form>
                </div>

                {{-- Models List --}}
                @if($carMake->carModels->isEmpty())
                    <div class="px-6 py-8 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('messages.car_models_empty') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.model_name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('messages.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($carMake->carModels as $model)
                                    <tr x-data="{ editing: false }" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors duration-150">
                                        <td class="px-6 py-3">
                                            <form x-show="editing" x-cloak
                                                  action="{{ route('admin.car-makes.models.update', [$carMake, $model]) }}"
                                                  method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="name" value="{{ $model->name }}" required
                                                       class="flex-1 px-3 py-1.5 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 text-sm transition-all">
                                                <button type="submit"
                                                        class="px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition-colors">
                                                    {{ __('messages.action_save') }}
                                                </button>
                                                <button type="button" @click="editing = false"
                                                        class="px-3 py-1.5 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 text-gray-700 dark:text-gray-200 text-xs font-medium rounded-lg transition-colors">
                                                    {{ __('messages.action_cancel') }}
                                                </button>
                                            </form>
                                            <span x-show="!editing" class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $model->name }}</span>
                                        </td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $model->is_active
                                                    ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300'
                                                    : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                                                {{ $model->is_active ? __('messages.active') : __('messages.inactive') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-right space-x-2">
                                            <button type="button"
                                                    @click="editing = true"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 rounded-lg transition-colors">
                                                {{ __('messages.action_edit') }}
                                            </button>
                                            <form action="{{ route('admin.car-makes.models.destroy', [$carMake, $model]) }}" method="POST" class="inline"
                                                  onsubmit="return confirm('{{ __('messages.car_model_delete_confirm', ['name' => $model->name]) }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 rounded-lg transition-colors">
                                                    {{ __('messages.action_delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
