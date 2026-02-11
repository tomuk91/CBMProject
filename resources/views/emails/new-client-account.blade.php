<x-mail::message>
# {{ __('messages.email_account_created_title') }}

{{ __('messages.email_greeting', ['name' => $user->name]) }},

{{ __('messages.email_account_created_message', ['app_name' => config('app.name')]) }}

## {{ __('messages.email_get_started') }}

**{{ __('messages.email_email_label') }}:** {{ $user->email }}

{{ __('messages.email_set_password_intro') }}

<x-mail::button :url="$resetUrl">
{{ __('messages.email_set_password') }}
</x-mail::button>

<x-mail::panel>
{{ __('messages.email_reset_link_expiry') }}
</x-mail::panel>

{{ __('messages.email_once_logged_in') }}
- {{ __('messages.email_feature_view_appointments') }}
- {{ __('messages.email_feature_update_vehicle') }}
- {{ __('messages.email_feature_book_new') }}
- {{ __('messages.email_feature_manage_profile') }}

{{ __('messages.email_contact_us') }}

{{ __('messages.email_thanks') }}<br>
{{ config('app.name') }}
</x-mail::message>
