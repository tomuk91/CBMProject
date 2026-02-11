<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.admin_contact_submissions') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-4 lg:px-6 space-y-6">
                {{-- Search & Filter --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-6">
                    <form method="GET" action="{{ route('admin.contact-submissions.index') }}" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="{{ __('messages.action_search') }}..."
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-red-500 focus:ring-red-500">
                        </div>
                        <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:border-red-500 focus:ring-red-500">
                            <option value="">{{ __('messages.all_actions') }}</option>
                            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>{{ __('messages.admin_unread') }}</option>
                            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>{{ __('messages.admin_read') }}</option>
                        </select>
                        <button type="submit" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                            {{ __('messages.action_search') }}
                        </button>
                    </form>
                </div>

                {{-- Submissions List --}}
                <div class="space-y-4">
                    @forelse($submissions as $submission)
                        <div x-data="{ expanded: false }" class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden {{ !$submission->is_read ? 'ring-2 ring-red-200 dark:ring-red-900/50' : '' }}">
                            {{-- Header row --}}
                            <div class="p-4 sm:p-6 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors" @click="expanded = !expanded">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        {{-- Status badge --}}
                                        @if($submission->is_read)
                                            <span class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">{{ __('messages.admin_read') }}</span>
                                        @else
                                            <span class="flex-shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">{{ __('messages.admin_unread') }}</span>
                                        @endif
                                        {{-- Name --}}
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100 {{ !$submission->is_read ? 'font-bold' : '' }} truncate">{{ $submission->name }}</span>
                                        {{-- Email --}}
                                        <span class="hidden sm:inline text-sm text-gray-500 dark:text-gray-400 truncate">{{ $submission->email }}</span>
                                        {{-- Subject badge --}}
                                        @if($submission->subject)
                                            <span class="hidden md:inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                                {{ __('messages.contact_subject_' . str_replace('_inquiry', '', $submission->subject)) }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-3 flex-shrink-0">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $submission->created_at->diffForHumans() }}</span>
                                        <svg class="w-5 h-5 text-gray-400 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                {{-- Message preview (collapsed) --}}
                                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 truncate" x-show="!expanded">{{ Str::limit($submission->message, 120) }}</p>
                            </div>
                            {{-- Expanded content --}}
                            <div x-show="expanded" x-collapse class="border-t border-gray-200 dark:border-gray-700">
                                <div class="p-4 sm:p-6 space-y-4">
                                    {{-- Contact info --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">{{ __('messages.email') }}</p>
                                            <a href="mailto:{{ $submission->email }}" class="text-red-600 dark:text-red-400 hover:underline">{{ $submission->email }}</a>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">{{ __('messages.phone') }}</p>
                                            <p class="text-gray-900 dark:text-gray-100">{{ $submission->phone ?: '—' }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">{{ __('messages.contact_subject') }}</p>
                                            <p class="text-gray-900 dark:text-gray-100">
                                                @if($submission->subject)
                                                    {{ __('messages.contact_subject_' . str_replace('_inquiry', '', $submission->subject)) }}
                                                @else
                                                    —
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">{{ __('messages.date') }}</p>
                                            <p class="text-gray-900 dark:text-gray-100">{{ $submission->created_at->format('Y-m-d H:i') }}</p>
                                        </div>
                                    </div>
                                    {{-- Full message --}}
                                    <div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-2">{{ __('messages.admin_full_message') }}</p>
                                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-sm text-gray-800 dark:text-gray-200 whitespace-pre-line">{{ $submission->message }}</div>
                                    </div>
                                    {{-- Actions --}}
                                    <div class="flex items-center gap-3">
                                        @if(!$submission->is_read)
                                            <form method="POST" action="{{ route('admin.contact-submissions.mark-read', $submission) }}">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                    {{ __('messages.admin_mark_as_read') }}
                                                </button>
                                            </form>
                                        @endif
                                        <a href="mailto:{{ $submission->email }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            {{ __('messages.admin_reply_email') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-lg font-medium text-gray-500 dark:text-gray-400">{{ __('messages.admin_no_submissions') }}</p>
                        </div>
                    @endforelse

                    @if($submissions->hasPages())
                        <div class="mt-4">
                            {{ $submissions->links() }}
                        </div>
                    @endif
                </div>
            </div>
    </div>
</x-app-layout>
