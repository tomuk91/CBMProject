@php $s = $serviceType ?? null; @endphp

{{-- Name --}}
<div>
    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.service_types_field_name') }} <span class="text-red-500">*</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $s?->name) }}" required maxlength="255"
           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
           placeholder="{{ __('messages.service_types_field_name_placeholder') }}">
    @error('name')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Icon & Duration row --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.service_types_field_icon') }}</label>
        <input type="text" name="icon" id="icon" value="{{ old('icon', $s?->icon ?? '🔧') }}" maxlength="10"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
               placeholder="🔧">
        @error('icon')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="estimated_duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.service_types_field_duration') }}</label>
        <input type="text" name="estimated_duration" id="estimated_duration" value="{{ old('estimated_duration', $s?->estimated_duration) }}" maxlength="50"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
               placeholder="1-2 hrs">
        @error('estimated_duration')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Description --}}
<div>
    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.service_types_field_description') }}</label>
    <textarea name="description" id="description" rows="3" maxlength="1000"
              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
              placeholder="{{ __('messages.service_types_field_description_placeholder') }}">{{ old('description', $s?->description) }}</textarea>
    @error('description')
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

{{-- Price range --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label for="price_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.service_types_field_price_from') }}</label>
        <input type="number" name="price_from" id="price_from" value="{{ old('price_from', $s?->price_from) }}" min="0" step="100"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
               placeholder="0">
        @error('price_from')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="price_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.service_types_field_price_to') }}</label>
        <input type="number" name="price_to" id="price_to" value="{{ old('price_to', $s?->price_to) }}" min="0" step="100"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
               placeholder="0">
        @error('price_to')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>
</div>

{{-- Sort Order & Active --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('messages.service_types_field_sort_order') }}</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $s?->sort_order ?? 0) }}" min="0"
               class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition"
               placeholder="0">
        @error('sort_order')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-end pb-1">
        <label class="flex items-center cursor-pointer">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $s?->is_active ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 text-red-600 border-gray-300 dark:border-gray-600 rounded focus:ring-red-500 dark:bg-gray-900 transition">
            <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('messages.service_types_field_active') }}</span>
        </label>
    </div>
</div>
