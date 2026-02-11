<x-mail::message>
# {{ __('messages.email_cancelled_title') }}

{{ __('messages.email_greeting', ['name' => $appointment->name]) }},

{{ __('messages.email_cancelled_message', ['app_name' => config('app.name')]) }}

## {{ __('messages.email_appointment_details') }}

**{{ __('messages.email_service_label') }}:** {{ $appointment->service }}

**{{ __('messages.email_scheduled_date_time') }}:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y \\a\\t g:i A') }}

**{{ __('messages.email_vehicle_label') }}:** {{ $appointment->vehicle }}

@if($reason)
<x-mail::panel>
**{{ __('messages.email_cancellation_reason') }}:** {{ $reason }}
</x-mail::panel>
@endif

{{ __('messages.email_cancelled_apology') }}

<x-mail::button :url="url('/appointments')">
{{ __('messages.email_book_new') }}
</x-mail::button>

{{ __('messages.email_questions') }}

{{ __('messages.email_thanks') }}<br>
{{ config('app.name') }}
</x-mail::message>
