<x-mail::message>
# Appointment Request Received

Hello {{ $appointment->name }},

Thank you for requesting an appointment with {{ config('app.name') }}. We have received your request and it is currently pending approval.

## Appointment Details

**Service:** {{ $appointment->service }}

**Requested Time:** {{ $appointment->availableSlot->start_time->format('F j, Y \\a\\t g:i A') }}

**Vehicle:** {{ $appointment->vehicle }}

**Phone:** {{ $appointment->phone }}

@if($appointment->notes)
**Additional Notes:** {{ $appointment->notes }}
@endif

Our team will review your request and send you a confirmation email once your appointment is approved.

<x-mail::button :url="url('/dashboard')">
View Your Dashboard
</x-mail::button>

If you have any questions, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
