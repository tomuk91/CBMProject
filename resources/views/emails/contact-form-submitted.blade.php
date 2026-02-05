<x-mail::message>
# New Contact Form Submission

You have received a new contact form submission from your website.

## Contact Details

**Name:** {{ $contactData['name'] }}  
**Email:** {{ $contactData['email'] }}  
**Phone:** {{ $contactData['phone'] ?? 'Not provided' }}  
**Subject:** {{ ucfirst(str_replace('_', ' ', $contactData['subject'])) }}

## Message

<x-mail::panel>
{{ $contactData['message'] }}
</x-mail::panel>

<x-mail::button :url="'mailto:' . $contactData['email']">
Reply to {{ $contactData['name'] }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Website
</x-mail::message>
