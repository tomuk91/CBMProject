<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.auth_register_title') }}</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('messages.auth_register_subtitle') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>

            <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.auth_have_account') }}
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 font-semibold transition">
                    {{ __('messages.auth_login_link') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
