<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('messages.auth_login_title') }}</h2>
        <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('messages.auth_login_subtitle') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 font-medium transition" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="space-y-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>

            <div class="text-center text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.auth_no_account') }}
                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 font-semibold transition">
                    {{ __('messages.auth_register_link') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
