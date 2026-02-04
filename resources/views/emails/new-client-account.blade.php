<x-mail::message>
# Account Created Successfully

Hello {{ $user->name }},

An account has been created for you at {{ config('app.name') }}. You can now access your account and manage your appointments online.

## Your Login Credentials

**Email:** {{ $user->email }}  
**Temporary Password:** {{ $temporaryPassword }}

<x-mail::panel>
**Important:** For security reasons, please change your password after your first login.
</x-mail::panel>

<x-mail::button :url="url('/login')">
Login to Your Account
</x-mail::button>

Once logged in, you can:
- View your upcoming appointments
- Update your vehicle information
- Book new appointments
- Manage your profile

If you have any questions or need assistance, please don't hesitate to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
