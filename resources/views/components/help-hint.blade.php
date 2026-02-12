{{-- Help Hint — contextual info tooltip, only shown when help guides are enabled --}}
{{-- Usage: <x-help-hint :text="__('messages.help_hint_xxx')" /> --}}
{{-- Optional: position="top|bottom|left|right" (default: top) --}}
@props(['text', 'position' => 'top'])

@if(Auth::check() && Auth::user()->is_admin && Auth::user()->show_help_guides)
<span x-data="{
        show: false,
        tooltipStyle: {},
        updatePosition() {
            const icon = this.$refs.icon;
            const rect = icon.getBoundingClientRect();
            const pos = '{{ $position }}';
            const tooltipEl = this.$refs.tooltip;
            if (!tooltipEl) return;
            const tw = tooltipEl.offsetWidth || 256;
            const th = tooltipEl.offsetHeight || 60;
            let top, left;
            if (pos === 'right') {
                top = rect.top + (rect.height / 2) - (th / 2);
                left = rect.right + 8;
            } else if (pos === 'left') {
                top = rect.top + (rect.height / 2) - (th / 2);
                left = rect.left - tw - 8;
            } else if (pos === 'bottom') {
                top = rect.bottom + 8;
                left = rect.left + (rect.width / 2) - (tw / 2);
            } else {
                top = rect.top - th - 8;
                left = rect.left + (rect.width / 2) - (tw / 2);
            }
            if (left + tw > window.innerWidth - 8) left = window.innerWidth - tw - 8;
            if (left < 8) left = 8;
            if (top + th > window.innerHeight - 8) top = window.innerHeight - th - 8;
            if (top < 8) top = 8;
            this.tooltipStyle = { top: top + 'px', left: left + 'px' };
        }
      }"
      class="inline-flex items-center help-hint-icon"
      @mouseenter="show = true; $nextTick(() => updatePosition())"
      @mouseleave="show = false"
      @focus="show = true; $nextTick(() => updatePosition())"
      @blur="show = false"
      @click="show = !show; if(show) $nextTick(() => updatePosition())"
      tabindex="0"
      role="button"
      aria-label="{{ __('messages.help_hint_label') }}">
    {{-- Icon --}}
    <span x-ref="icon">
        <svg class="w-4 h-4 text-blue-500 dark:text-blue-400 hover:text-blue-600 dark:hover:text-blue-300 transition-colors cursor-help" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
    </span>
    {{-- Tooltip (fixed position, renders above all containers) --}}
    <template x-teleport="body">
        <div x-show="show"
             x-ref="tooltip"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             x-cloak
             :style="tooltipStyle"
             class="fixed z-[9999] w-64 px-3 py-2 text-xs font-normal text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 rounded-lg shadow-lg border border-gray-200 dark:border-gray-600 leading-relaxed pointer-events-none">
            {{ $text }}
        </div>
    </template>
</span>
@endif
