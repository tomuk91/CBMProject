<x-mail::message>
# {{ __('messages.contact_confirmation_heading', [], 'en') }}

{{ __('messages.contact_confirmation_body', ['name' => $contactData['name']], 'en') }}

{{ __('messages.contact_confirmation_closing', [], 'en') }}

{{ config('app.name') }}
</x-mail::message>
