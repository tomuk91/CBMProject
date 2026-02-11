<x-mail::message>
# {{ __('messages.email_welcome_title', ['app_name' => config('app.name')]) }}

{{ __('messages.email_greeting', ['name' => $user->name]) }},

{{ __('messages.email_welcome_message') }}

{{ __('messages.email_welcome_services') }}

<x-mail::button :url="url('/appointments')">
{{ __('messages.email_view_available') }}
</x-mail::button>

{{ __('messages.email_welcome_questions') }}

{{ __('messages.email_thanks') }}<br>
{{ config('app.name') }}
</x-mail::message>
