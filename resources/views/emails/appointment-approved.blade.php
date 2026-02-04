<x-mail::message>
# Appointment Confirmed! ✓

Hello {{ $appointment->name }},

Great news! Your appointment with {{ config('app.name') }} has been confirmed.

## Appointment Details

**Service:** {{ $appointment->service }}

**Date & Time:** {{ $appointment->appointment_date->format('F j, Y \\a\\t g:i A') }}

**Duration:** {{ $appointment->appointment_date->diffInMinutes($appointment->appointment_end) }} minutes

**Vehicle:** {{ $appointment->vehicle }}

**Phone:** {{ $appointment->phone }}

@if($appointment->notes)
**Additional Notes:** {{ $appointment->notes }}
@endif

<x-mail::panel>
Please arrive 5-10 minutes early to ensure we can start on time.
</x-mail::panel>

<x-mail::button :url="url('/appointments')">
View Your Appointments
</x-mail::button>

If you need to reschedule or cancel, please contact us as soon as possible.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
