<x-mail::message>
# Appointment Request Update

Hello {{ $appointment->name }},

Thank you for your interest in booking an appointment with {{ config('app.name') }}.

Unfortunately, we are unable to accommodate your appointment request for the following reason:

<x-mail::panel>
{{ $reason ?: 'The requested time slot is no longer available.' }}
</x-mail::panel>

## Original Request Details

**Service:** {{ $appointment->service }}

**Requested Time:** {{ $appointment->availableSlot ? $appointment->availableSlot->start_time->format('F j, Y \\a\\t g:i A') : 'N/A' }}

**Vehicle:** {{ $appointment->vehicle }}

We would love to help you find an alternative time. Please browse our available appointment slots and submit a new request.

<x-mail::button :url="url('/appointments')">
View Available Appointments
</x-mail::button>

If you have any questions or concerns, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
