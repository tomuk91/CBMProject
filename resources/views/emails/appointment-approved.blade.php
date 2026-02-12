<x-mail::message>
# {{ __('messages.email_approved_title') }}

{{ __('messages.email_greeting', ['name' => $appointment->name]) }},

{{ __('messages.email_approved_message', ['app_name' => config('app.name')]) }}

## {{ __('messages.email_appointment_details') }}

**{{ __('messages.email_service_label') }}:** {{ $appointment->service }}

**{{ __('messages.email_date_time_label') }}:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y \\a\\t g:i A') }}

**{{ __('messages.email_duration_label') }}:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->diffInMinutes(\Carbon\Carbon::parse($appointment->appointment_end)) }} {{ __('messages.email_minutes') }}

**{{ __('messages.email_vehicle_label') }}:** {{ $appointment->vehicle_description }}

**{{ __('messages.email_phone_label') }}:** {{ $appointment->phone }}

@if($appointment->notes)
**{{ __('messages.email_additional_notes') }}:** {{ $appointment->notes }}
@endif

<x-mail::panel>
{{ __('messages.email_arrive_early') }}
</x-mail::panel>

<x-mail::button :url="url('/appointments')">
{{ __('messages.email_view_appointments') }}
</x-mail::button>

{{ __('messages.email_reschedule_notice') }}

{{ __('messages.email_thanks') }}<br>
{{ config('app.name') }}
</x-mail::message>
