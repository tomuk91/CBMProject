{{-- Toast Notification Component --}}
{{-- Automatically displays session flash messages as animated toasts --}}

<div
    x-data="{
        toasts: [],
        addToast(type, message) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, type, message, visible: true });
            setTimeout(() => this.removeToast(id), 5000);
        },
        removeToast(id) {
            const toast = this.toasts.find(t => t.id === id);
            if (toast) toast.visible = false;
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id);
            }, 300);
        }
    }"
    x-init="
        @if(session('success'))
            addToast('success', '{{ str_replace("'", "\\'", session('success')) }}');
        @endif
        @if(session('error'))
            addToast('error', '{{ str_replace("'", "\\'", session('error')) }}');
        @endif
        @if(session('warning'))
            addToast('warning', '{{ str_replace("'", "\\'", session('warning')) }}');
        @endif
        @if(session('info'))
            addToast('info', '{{ str_replace("'", "\\'", session('info')) }}');
        @endif
    "
    class="fixed top-4 right-4 z-[9999] flex flex-col gap-3 w-full max-w-sm px-4 sm:px-0 sm:right-6 sm:top-6 pointer-events-none"
    aria-live="polite"
    aria-label="Notifications"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.visible"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 translate-x-8"
            class="pointer-events-auto w-full rounded-lg shadow-lg ring-1 ring-black/5 dark:ring-white/10 overflow-hidden"
            :class="{
                'bg-white dark:bg-gray-800': true
            }"
            role="alert"
        >
            <div class="p-4">
                <div class="flex items-start gap-3">
                    {{-- Icon --}}
                    <div class="shrink-0 mt-0.5">
                        {{-- Success icon --}}
                        <template x-if="toast.type === 'success'">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        {{-- Error icon --}}
                        <template x-if="toast.type === 'error'">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        {{-- Warning icon --}}
                        <template x-if="toast.type === 'warning'">
                            <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                        </template>
                        {{-- Info icon --}}
                        <template x-if="toast.type === 'info'">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                            </svg>
                        </template>
                    </div>

                    {{-- Message --}}
                    <p
                        class="text-sm font-medium leading-5 flex-1"
                        :class="{
                            'text-green-800 dark:text-green-200': toast.type === 'success',
                            'text-red-800 dark:text-red-200': toast.type === 'error',
                            'text-amber-800 dark:text-amber-200': toast.type === 'warning',
                            'text-blue-800 dark:text-blue-200': toast.type === 'info'
                        }"
                        x-text="toast.message"
                    ></p>

                    {{-- Close button --}}
                    <button
                        @click="removeToast(toast.id)"
                        class="shrink-0 rounded-md p-1 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                        :class="{
                            'text-green-400 hover:text-green-600 focus:ring-green-500': toast.type === 'success',
                            'text-red-400 hover:text-red-600 focus:ring-red-500': toast.type === 'error',
                            'text-amber-400 hover:text-amber-600 focus:ring-amber-500': toast.type === 'warning',
                            'text-blue-400 hover:text-blue-600 focus:ring-blue-500': toast.type === 'info'
                        }"
                        aria-label="Close notification"
                    >
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>

                {{-- Progress bar --}}
                <div class="mt-3 h-1 w-full rounded-full overflow-hidden bg-gray-200 dark:bg-gray-700">
                    <div
                        class="h-full rounded-full transition-all duration-100"
                        :class="{
                            'bg-green-500': toast.type === 'success',
                            'bg-red-500': toast.type === 'error',
                            'bg-amber-500': toast.type === 'warning',
                            'bg-blue-500': toast.type === 'info'
                        }"
                        x-init="$nextTick(() => { $el.style.width = '100%'; setTimeout(() => { $el.style.transition = 'width 5s linear'; $el.style.width = '0%'; }, 50); })"
                    ></div>
                </div>
            </div>

            {{-- Left accent border --}}
            <div
                class="absolute inset-y-0 left-0 w-1"
                :class="{
                    'bg-green-500': toast.type === 'success',
                    'bg-red-500': toast.type === 'error',
                    'bg-amber-500': toast.type === 'warning',
                    'bg-blue-500': toast.type === 'info'
                }"
            ></div>
        </div>
    </template>
</div>
