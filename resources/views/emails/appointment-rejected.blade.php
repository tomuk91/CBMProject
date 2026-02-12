<x-mail::message>
# {{ __('messages.email_rejected_title') }}

{{ __('messages.email_greeting', ['name' => $appointment->name]) }},

{{ __('messages.email_rejected_interest', ['app_name' => config('app.name')]) }}

{{ __('messages.email_rejected_reason_intro') }}

<x-mail::panel>
{{ $reason ?: __('messages.email_rejected_default_reason') }}
</x-mail::panel>

## {{ __('messages.email_original_details') }}

**{{ __('messages.email_service_label') }}:** {{ $appointment->service }}

**{{ __('messages.email_requested_time_label') }}:** {{ $appointment->availableSlot ? $appointment->availableSlot->start_time->format('F j, Y \\a\\t g:i A') : 'N/A' }}

**{{ __('messages.email_vehicle_label') }}:** {{ $appointment->vehicle_description }}

{{ __('messages.email_rejected_alternative') }}

<x-mail::button :url="url('/appointments')">
{{ __('messages.email_view_available') }}
</x-mail::button>

{{ __('messages.email_questions') }}

{{ __('messages.email_thanks') }}<br>
{{ config('app.name') }}
</x-mail::message>
