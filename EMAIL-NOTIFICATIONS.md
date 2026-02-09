# Email Notification System

## Overview
The application now has a complete email notification system for appointments.

## Email Types

### 1. **Appointment Confirmation** (Customer)
- **Sent when**: Customer submits a new appointment request
- **Recipients**: Customer
- **Mailable**: `AppointmentConfirmation`
- **Template**: `emails/appointment-confirmation.blade.php`
- **Content**: Confirms receipt, shows pending status, includes appointment details

### 2. **New Appointment** (Admin)
- **Sent when**: Customer submits a new appointment request
- **Recipients**: All admins
- **Mailable**: `NewAppointmentAdmin`
- **Template**: `emails/new-appointment-admin.blade.php`
- **Content**: Notifies admin of new request requiring approval

### 3. **Status Changed** (Customer)
- **Sent when**: Admin approves, rejects, confirms, completes, or cancels appointment
- **Recipients**: Customer
- **Mailable**: `AppointmentStatusChanged`
- **Template**: `emails/appointment-status-changed.blade.php`
- **Content**: Shows old status → new status, provides context for each status

### 4. **Cancellation Requested** (Admin)
- **Sent when**: Customer requests to cancel their appointment
- **Recipients**: All admins
- **Mailable**: `CancellationRequested`
- **Template**: `emails/cancellation-requested.blade.php`
- **Content**: Notifies admin of cancellation request with reason

### 5. **24-Hour Reminder** (Customer)
- **Sent when**: Automated command runs (24 hours before appointment)
- **Recipients**: Customer
- **Mailable**: `AppointmentReminder24Hours`
- **Template**: `emails/appointment-reminder.blade.php`
- **Content**: Friendly reminder about tomorrow's appointment

## Configuration

### Mail Settings (.env)

For **development/testing**:
```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@cbmauto.com"
MAIL_FROM_NAME="${APP_NAME}"
```

For **production** (example with SMTP):
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@cbmauto.com"
MAIL_FROM_NAME="CBM Auto"
```

### Queue Configuration

Emails are queued for better performance. Ensure your queue is running:

```bash
# Start the queue worker
php artisan queue:work

# Or use supervisor in production to keep it running
```

If queue is not set up, emails will fail silently. Check your `.env`:
```env
QUEUE_CONNECTION=database  # or redis, sync, etc.
```

## Automated Reminders

### Schedule Setup

The reminder command is designed to run every hour. Add to your scheduler in `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Send 24-hour reminders every hour
    $schedule->command('appointments:send-reminders --hours=24')
        ->hourly()
        ->withoutOverlapping();
}
```

### Run the Scheduler

**Development:**
```bash
php artisan schedule:work
```

**Production (crontab):**
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Manual Testing

Send reminders manually:
```bash
# Send reminders for appointments 24 hours from now
php artisan appointments:send-reminders

# Send reminders for appointments 48 hours from now
php artisan appointments:send-reminders --hours=48
```

## Translations

All email content is translated in both English and Hungarian:
- `lang/en/messages.php` - English translations
- `lang/hu/messages.php` - Hungarian translations

Key translation prefixes:
- `email_*` - Email-specific translations
- `status_*` - Appointment status names

## Customization

### Styling

All email templates use inline CSS for email client compatibility. Key design elements:
- Red theme (`#dc2626`) for brand consistency
- Responsive design (max-width: 600px)
- Clear call-to-action buttons
- Status badges with color coding

### Adding New Email Types

1. Create Mailable class:
```bash
php artisan make:mail YourNewEmail
```

2. Create Blade template:
```bash
resources/views/emails/your-new-email.blade.php
```

3. Add translations to both language files

4. Send the email:
```php
Mail::to($user->email)->queue(new YourNewEmail($data));
```

## Testing Emails

### View in Log
With `MAIL_MAILER=log`, check `storage/logs/laravel.log` for email content.

### Preview in Browser
Create a route to preview emails:
```php
Route::get('/email-preview', function() {
    $appointment = Appointment::first();
    return new AppointmentConfirmation($appointment);
});
```

### Use Mailtrap
Sign up at https://mailtrap.io/ for a fake SMTP server perfect for testing.

## Troubleshooting

**Emails not sending?**
1. Check queue is running: `php artisan queue:work`
2. Check mail configuration in `.env`
3. Look for errors in `storage/logs/laravel.log`
4. Test queue jobs: `php artisan queue:failed`

**Wrong language in emails?**
- Emails use the app's locale setting
- User's locale preference is set by `SetLocale` middleware
- Check `config/app.php` for default locale

**Styling broken in email client?**
- Use inline CSS only (already done)
- Test in multiple email clients
- Avoid complex layouts or external images

## Production Checklist

- [ ] Update `MAIL_FROM_ADDRESS` to your domain
- [ ] Set up proper SMTP credentials
- [ ] Configure queue to use Redis or database
- [ ] Set up supervisor for queue workers
- [ ] Add cron job for scheduler
- [ ] Test all email types
- [ ] Add email logging/monitoring
- [ ] Consider rate limiting for email sending

## Future Enhancements

- SMS reminders (via Twilio/Vonage)
- Email templates in admin panel
- Unsubscribe functionality
- Email delivery tracking
- A/B testing for email content
- Rich HTML templates with images
