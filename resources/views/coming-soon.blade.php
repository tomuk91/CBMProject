<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('messages.coming_soon_title') }} – {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { margin: 0; min-height: 100vh; }
        .lang-toggle { display:flex; gap:0; border-radius:.5rem; overflow:hidden; border:1px solid #374151; }
        .lang-toggle a { padding:.375rem .75rem; font-size:.875rem; font-weight:600; color:#9ca3af; background-color:#111827; transition:all .15s; text-decoration:none; }
        .lang-toggle a:hover { color:#d1d5db; background-color:#1f2937; }
        .lang-toggle a.active { background-color:#dc2626; color:#ffffff; }
    </style>
</head>
<body class="bg-gray-950 text-white flex flex-col items-center justify-center min-h-screen px-6">

    {{-- Language toggle --}}
    <div class="absolute top-4 right-4">
        <div class="lang-toggle">
            <a href="{{ route('language.switch', 'hu') }}" class="{{ app()->getLocale() === 'hu' ? 'active' : '' }}">HU</a>
            <a href="{{ route('language.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">EN</a>
        </div>
    </div>

    <div class="w-full max-w-lg text-center">

        {{-- Logo / Brand --}}
        <div class="mb-10">
            <div class="mb-6">
                <img src="{{ asset('images/logo-white.png') }}" alt="{{ config('app.name') }}" class="h-20 w-auto mx-auto">
            </div>
            <p class="text-red-400 text-sm font-semibold uppercase tracking-widest">{{ __('messages.coming_soon_subtitle') }}</p>
        </div>

        {{-- Coming Soon message --}}
        <div class="mb-10">
            <h2 class="text-2xl font-semibold text-white mb-3">{{ __('messages.coming_soon_title') }}</h2>
            <p class="text-gray-400 leading-relaxed">
                {{ __('messages.coming_soon_body') }}
            </p>
        </div>

        {{-- Contact details --}}
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 mb-10 space-y-5 text-left">

            {{-- Address --}}
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-600/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-1">{{ __('messages.coming_soon_address_label') }}</p>
                    <address class="not-italic text-white font-medium leading-snug">
                        Hunyadi János u. 18<br>
                        Dunakeszi, 2120<br>
                        Hungary
                    </address>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-800"></div>

            {{-- Phone --}}
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-600/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider font-medium mb-1">{{ __('messages.coming_soon_phone_label') }}</p>
                    <a href="tel:+3627546475" class="text-white font-medium hover:text-red-400 transition-colors">
                        +36 27 546 475
                    </a>
                </div>
            </div>
        </div>

        {{-- Admin login button --}}
        @if (Route::has('login'))
            <div class="border-t border-gray-800 pt-8">
                <p class="text-gray-600 text-xs uppercase tracking-widest mb-4 font-medium">{{ __('messages.coming_soon_admin_label') }}</p>
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors shadow-lg shadow-red-900/30 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    {{ __('messages.coming_soon_admin_login') }}
                </a>
            </div>
        @endif

    </div>

    {{-- Footer --}}
    <footer class="mt-16 text-gray-700 text-xs text-center">
        &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('messages.coming_soon_footer') }}
    </footer>

</body>
</html>
