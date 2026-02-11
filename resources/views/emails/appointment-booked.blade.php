<x-mail::message>
# {{ __('messages.email_booked_title') }}

{{ __('messages.email_greeting', ['name' => $appointment->name]) }},

{{ __('messages.email_booked_message', ['app_name' => config('app.name')]) }}

## {{ __('messages.email_appointment_details') }}

**{{ __('messages.email_service_label') }}:** {{ $appointment->service }}

**{{ __('messages.email_requested_time_label') }}:** {{ $appointment->availableSlot->start_time->format('F j, Y \\a\\t g:i A') }}

**{{ __('messages.email_vehicle_label') }}:** {{ $appointment->vehicle }}

**{{ __('messages.email_phone_label') }}:** {{ $appointment->phone }}

@if($appointment->notes)
**{{ __('messages.email_additional_notes') }}:** {{ $appointment->notes }}
@endif

{{ __('messages.email_booked_pending') }}

<x-mail::button :url="url('/dashboard')">
{{ __('messages.view_dashboard') }}
</x-mail::button>

{{ __('messages.email_questions') }}

{{ __('messages.email_thanks') }}<br>
{{ config('app.name') }}
</x-mail::message>
