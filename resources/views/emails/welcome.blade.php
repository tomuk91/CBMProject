<x-mail::message>
# Welcome to {{ config('app.name') }}!

Hello {{ $user->name }},

Thank you for registering with us! We're excited to have you on board.

You can now book appointments for your vehicle service needs. Our team is here to provide you with the best service possible.

<x-mail::button :url="url('/appointments')">
View Available Appointments
</x-mail::button>

If you have any questions, feel free to reach out to us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
