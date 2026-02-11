<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.admin_contact_submissions') }}
            </h2>
        </div>
    </x-slot>

    <div class="flex bg-gray-50 dark:bg-gray-900 min-h-screen">
        @include('admin.partials.sidebar')

        <div class="flex-1 py-4 min-w-0">
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

                {{-- Submissions Table --}}
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.status') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.email') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.admin_message_preview') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{ __('messages.date') }}</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($submissions as $submission)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors {{ !$submission->is_read ? 'bg-red-50/50 dark:bg-red-900/10' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($submission->is_read)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">{{ __('messages.admin_read') }}</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">{{ __('messages.admin_unread') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100 {{ !$submission->is_read ? 'font-bold' : '' }}">{{ $submission->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $submission->email }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">
                                            {{ Str::limit($submission->message, 80) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                            {{ $submission->created_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                            @if(!$submission->is_read)
                                                <form method="POST" action="{{ route('admin.contact-submissions.mark-read', $submission) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">
                                                        {{ __('messages.admin_mark_as_read') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <p class="text-lg font-medium">{{ __('messages.admin_no_submissions') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($submissions->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $submissions->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
