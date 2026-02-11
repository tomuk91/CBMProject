<x-mail::message>
# Account Created Successfully

Hello {{ $user->name }},

An account has been created for you at {{ config('app.name') }}. You can now access your account and manage your appointments online.

## Get Started

**Email:** {{ $user->email }}

To get started, please set your password by clicking the button below:

<x-mail::button :url="$resetUrl">
Set Your Password
</x-mail::button>

<x-mail::panel>
This password reset link will expire in 60 minutes. If you need a new link, you can request one from the login page.
</x-mail::panel>

Once logged in, you can:
- View your upcoming appointments
- Update your vehicle information
- Book new appointments
- Manage your profile

If you have any questions or need assistance, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
