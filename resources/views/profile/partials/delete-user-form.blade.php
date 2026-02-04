<section class="space-y-6">
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
        <p class="text-sm text-red-800 dark:text-red-200">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </div>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full justify-center font-semibold"
    >{{ __('Delete Account Permanently') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
            @csrf
            @method('delete')

            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 dark:bg-red-900/50 mb-4 shadow-lg">
                    <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    {{ __('Delete Account?') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('This action cannot be undone. All your data will be permanently deleted.') }}
                </p>
            </div>

            <div class="mb-6">
                <x-input-label for="password" value="{{ __('Confirm your password to continue') }}" class="text-gray-700 dark:text-gray-300 font-semibold mb-2" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200"
                    placeholder="{{ __('Enter your password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="flex gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="flex-1 justify-center px-6 py-3 rounded-lg font-semibold transition-all duration-200">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="flex-1 justify-center bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 px-6 py-3 rounded-lg shadow-md hover:shadow-lg font-semibold transition-all duration-200">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
