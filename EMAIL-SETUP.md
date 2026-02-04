# Email System Setup Guide

## Overview
The application now sends automatic emails for the following events:
1. **User Registration** - Welcome email when a new user signs up
2. **Appointment Booking** - Confirmation email when user submits an appointment request
3. **Appointment Approved** - Notification when admin approves an appointment
4. **Appointment Rejected** - Notification when admin rejects an appointment with reason

## Mail Configuration

### Development (Using Log Driver)
By default, the application uses the `log` driver which writes emails to the Laravel log file instead of sending them:

```env
MAIL_MAILER=log
```

Emails will be written to: `storage/logs/laravel.log`

### Production (Using SMTP)
To send actual emails, update your `.env` file with SMTP settings:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourapp.com
MAIL_FROM_NAME="${APP_NAME}"
```

#### Popular Email Services:

**Gmail:**
- Host: `smtp.gmail.com`
- Port: `587`
- You'll need to create an [App Password](https://support.google.com/accounts/answer/185833)

**Mailgun:**
- Host: `smtp.mailgun.org`
- Port: `587`
- Get credentials from [Mailgun Dashboard](https://www.mailgun.com/)

**SendGrid:**
- Host: `smtp.sendgrid.net`
- Port: `587`
- Username: `apikey`
- Password: Your SendGrid API Key

**Mailtrap (Testing):**
- Host: `smtp.mailtrap.io`
- Port: `2525`
- Perfect for testing without sending real emails

## Email Templates

All email templates use Laravel's Markdown format and are located in:
```
resources/views/emails/
├── welcome.blade.php              # New user welcome
├── appointment-booked.blade.php   # Booking confirmation
├── appointment-approved.blade.php # Approval notification
└── appointment-rejected.blade.php # Rejection notification
```

## Testing Emails

### Test in Log Mode
1. Ensure `.env` has `MAIL_MAILER=log`
2. Perform an action (register, book appointment, etc.)
3. Check `storage/logs/laravel.log` for the email content

### Test with Mailtrap
1. Sign up at [Mailtrap.io](https://mailtrap.io)
2. Update `.env` with Mailtrap credentials
3. All emails will be caught by Mailtrap inbox
4. View them in your browser without sending to real users

## Customizing Email Templates

To customize the appearance:

1. **Publish Laravel mail components:**
   ```bash
   php artisan vendor:publish --tag=laravel-mail
   ```

2. **Edit the email templates** in `resources/views/emails/`

3. **Customize colors/styling** in `resources/views/vendor/mail/html/themes/default.css`

## Email Mailable Classes

Located in `app/Mail/`:
- `WelcomeMail.php` - Welcome email with user data
- `AppointmentBooked.php` - Booking confirmation with appointment details
- `AppointmentApproved.php` - Approval notification
- `AppointmentRejected.php` - Rejection notification with reason

## Troubleshooting

### Emails not sending in production
- Check SMTP credentials are correct
- Verify `MAIL_FROM_ADDRESS` is set
- Check firewall allows outbound SMTP connections
- View Laravel logs for error messages

### Gmail not working
- Enable "Less secure app access" or use App Password
- Check 2FA settings
- Verify correct port (587 for TLS, 465 for SSL)

### Queue for better performance
To send emails asynchronously:

1. Update mailable to implement `ShouldQueue`:
   ```php
   class WelcomeMail extends Mailable implements ShouldQueue
   ```

2. Run queue worker:
   ```bash
   php artisan queue:work
   ```

## Email Flow

### User Registration
1. User fills registration form
2. User account created
3. **Welcome email sent** to user
4. User logged in automatically

### Appointment Booking
1. User selects slot and fills form
2. Pending appointment created
3. **Booking confirmation email sent** to user
4. Admin sees pending request in dashboard

### Appointment Approval
1. Admin reviews pending appointment
2. Admin clicks "Approve"
3. Appointment added to calendar
4. **Approval email sent** to user with appointment details

### Appointment Rejection
1. Admin reviews pending appointment
2. Admin enters rejection reason
3. Slot made available again
4. **Rejection email sent** to user with reason and link to rebook

## Next Steps

Consider adding emails for:
- Appointment reminders (24 hours before)
- Appointment completed
- Password reset (Laravel includes by default)
- Appointment cancellation
- Admin notifications when new booking received
