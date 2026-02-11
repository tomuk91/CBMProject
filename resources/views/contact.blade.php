<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#dc2626">
    <title>{{ __('messages.contact_title') }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-900">
    <x-public-navigation currentPage="contact" />

    <!-- Contact Form Content -->
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800 pt-24 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                {{ __('messages.contact_title') }}
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-gray-600 dark:text-gray-300">
                {{ __('messages.contact_subtitle') }}
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Contact Info Cards -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">{{ __('messages.contact_email') }}</h3>
                <a href="mailto:info@cbmauto.com" class="text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition">info@cbmauto.com</a>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">{{ __('messages.contact_phone') }}</h3>
                <a href="tel:+3612345678" class="text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition">+36 1 234 5678</a>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg hover:shadow-xl transition">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-lg text-gray-900 dark:text-white mb-2">{{ __('messages.contact_address') }}</h3>
                <p class="text-gray-600 dark:text-gray-300">{{ __('messages.contact_address_value') }}</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-5 sm:p-8 lg:p-12">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-400 rounded">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-400 rounded">
                    <p class="font-medium mb-2">{{ __('messages.contact_error') }}</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Honeypot field - hidden from users, bots will fill it -->
                <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
                
                <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.contact_name') }} <span class="text-red-600" aria-label="{{ __('messages.required_field') }}">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               aria-required="true"
                               aria-describedby="name-hint"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-base"
                               placeholder="{{ __('messages.contact_name_placeholder') }}"
                               inputmode="text"
                               autocomplete="name">
                        @error('name')
                            <p class="text-red-600 text-sm mt-1" id="name-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.contact_email') }} <span class="text-red-600" aria-label="{{ __('messages.required_field') }}">*</span>
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               aria-required="true"
                               aria-describedby="email-hint"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-base"
                               placeholder="{{ __('messages.contact_email_placeholder') }}"
                               inputmode="email"
                               autocomplete="email">
                        @error('email')
                            <p class="text-red-600 text-sm mt-1" id="email-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.contact_phone') }}
                        </label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-base"
                               placeholder="{{ __('messages.contact_phone_placeholder') }}"
                               inputmode="tel"
                               autocomplete="tel">
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('messages.contact_subject') }} <span class="text-red-600" aria-label="{{ __('messages.required_field') }}">*</span>
                        </label>
                        <select id="subject" name="subject" required
                                aria-required="true"
                                aria-describedby="subject-hint"
                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 text-base">
                            <option value="">{{ __('messages.contact_subject_select') }}</option>
                            <option value="service_inquiry" {{ old('subject') == 'service_inquiry' ? 'selected' : '' }}>{{ __('messages.contact_subject_service') }}</option>
                            <option value="booking_inquiry" {{ old('subject') == 'booking_inquiry' ? 'selected' : '' }}>{{ __('messages.contact_subject_booking') }}</option>
                            <option value="general_inquiry" {{ old('subject') == 'general_inquiry' ? 'selected' : '' }}>{{ __('messages.contact_subject_general') }}</option>
                            <option value="feedback" {{ old('subject') == 'feedback' ? 'selected' : '' }}>{{ __('messages.contact_subject_feedback') }}</option>
                            <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>{{ __('messages.contact_subject_other') }}</option>
                        </select>
                        @error('subject')
                            <p class="text-red-600 text-sm mt-1" id="subject-error" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('messages.contact_message') }} <span class="text-red-600" aria-label="{{ __('messages.required_field') }}">*</span>
                    </label>
                    <textarea id="message" name="message" rows="6" required
                              aria-required="true"
                              aria-describedby="message-hint"
                              class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900/30 transition-all duration-200 resize-none text-base"
                              placeholder="{{ __('messages.contact_message_placeholder') }}">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-600 text-sm mt-1" id="message-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                    <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium transition min-h-[44px] flex items-center active:scale-95" aria-label="{{ __('messages.back_to_home') }}">
                        ← {{ __('messages.contact_back') }}
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-semibold rounded-lg transition shadow-lg hover:shadow-xl transform hover:scale-105 active:scale-95 flex items-center justify-center" aria-label="{{ __('messages.submit_contact_form') }}">
                        {{ __('messages.contact_submit') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Additional Info -->
        <div class="mt-12 text-center">
            <p class="text-gray-600 dark:text-gray-400 mb-4">
                {{ __('messages.contact_hours_title') }}
            </p>
            <div class="inline-block bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
                <div class="grid grid-cols-2 gap-6 text-left">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ __('messages.contact_weekdays') }}</p>
                        <p class="text-gray-600 dark:text-gray-300">{{ __('messages.contact_hours_weekday') }}</p>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ __('messages.contact_weekend') }}</p>
                        <p class="text-gray-600 dark:text-gray-300">{{ __('messages.contact_hours_saturday') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-gray-900 dark:bg-black text-white py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto text-center">
        <p class="text-gray-400">&copy; {{ date('Y') }} CBM Auto. {{ __('messages.footer_copyright') }}</p>
    </div>
</footer>

</body>
</html>
