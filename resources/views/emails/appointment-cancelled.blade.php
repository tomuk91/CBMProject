<x-mail::message>
# Appointment Cancelled

Hello {{ $appointment->name }},

We regret to inform you that your appointment with {{ config('app.name') }} has been cancelled.

## Appointment Details

**Service:** {{ $appointment->service }}

**Scheduled Date & Time:** {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y \\a\\t g:i A') }}

**Vehicle:** {{ $appointment->vehicle }}

@if($reason)
<x-mail::panel>
**Reason for Cancellation:** {{ $reason }}
</x-mail::panel>
@endif

We apologize for any inconvenience this may cause. If you would like to reschedule, please feel free to book a new appointment at your convenience.

<x-mail::button :url="url('/appointments')">
Book New Appointment
</x-mail::button>

If you have any questions or concerns, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
