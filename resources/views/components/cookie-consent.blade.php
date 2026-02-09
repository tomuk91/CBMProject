<!-- Cookie Consent Banner -->
<div id="cookieConsent" class="fixed bottom-0 left-0 right-0 bg-gray-900/95 backdrop-blur-md text-white p-4 md:p-6 shadow-2xl z-50 transform transition-transform duration-300" style="transform: translateY(100%);">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex-1">
                <h3 class="font-bold text-lg mb-2">{{ __('messages.cookie_title') }}</h3>
                <p class="text-gray-300 text-sm">
                    {{ __('messages.cookie_message') }}
                    <a href="{{ route('privacy') }}" class="text-red-400 hover:text-red-300 underline">{{ __('messages.cookie_learn_more') }}</a>
                </p>
            </div>
            <div class="flex gap-3 flex-shrink-0">
                <button onclick="acceptCookies()" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition shadow-lg">
                    {{ __('messages.cookie_accept') }}
                </button>
                <button onclick="declineCookies()" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white rounded-lg font-semibold transition">
                    {{ __('messages.cookie_decline') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Check if user has already made a choice
    window.addEventListener('DOMContentLoaded', function() {
        const consent = localStorage.getItem('cookieConsent');
        if (!consent) {
            setTimeout(function() {
                document.getElementById('cookieConsent').style.transform = 'translateY(0)';
            }, 1000);
        }
    });

    function acceptCookies() {
        localStorage.setItem('cookieConsent', 'accepted');
        document.getElementById('cookieConsent').style.transform = 'translateY(100%)';
        
        // Initialize analytics or other tracking here if needed
        console.log('Cookies accepted');
    }

    function declineCookies() {
        localStorage.setItem('cookieConsent', 'declined');
        document.getElementById('cookieConsent').style.transform = 'translateY(100%)';
        console.log('Cookies declined');
    }
</script>
