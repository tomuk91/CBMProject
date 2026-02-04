# Car Service - Google Calendar Integration

A Laravel-based car service booking system that integrates directly with Google Calendar for appointment management. Uses Google Service Account for automatic authentication - no user login required!

## Features

- ✅ Automatic Google Calendar access via Service Account
- ✅ No user authentication needed - customers view YOUR calendar
- ✅ Real-time sync with Google Calendar
- ✅ No database required for appointment storage
- ✅ Automatic booking updates to calendar
- ✅ Customer information stored in calendar events
- ✅ Only shows "Available" slots to customers
- ✅ Email notifications via Google Calendar

## Setup Instructions

### 1. Create Google Service Account

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable the **Google Calendar API**:
   - Go to "APIs & Services" > "Library"
   - Search for "Google Calendar API"
   - Click "Enable"

4. Create a Service Account:
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "Service Account"
   - Give it a name (e.g., "Car Service Calendar")
   - Click "Create and Continue"
   - Skip the optional steps and click "Done"

5. Create and Download Service Account Key:
   - Click on the service account you just created
   - Go to the "Keys" tab
   - Click "Add Key" > "Create new key"
   - Choose "JSON" format
   - Click "Create" - this downloads the credentials file

6. Share Your Google Calendar with the Service Account:
   - Open your Google Calendar (https://calendar.google.com)
   - Click the settings icon next to your calendar
   - Select "Settings and sharing"
   - Scroll to "Share with specific people or groups"
   - Click "Add people and groups"
   - Paste the service account email (found in the JSON file, looks like: `xxx@xxx.iam.gserviceaccount.com`)
   - Give it "Make changes to events" permission
   - Click "Send"

### 2. Configure the Application

1. **Place the credentials file**:
   - Rename the downloaded JSON file to `google-credentials.json`
   - Move it to `storage/app/google-credentials.json`

2. **Update `.env` file**:
   ```env
   GOOGLE_SERVICE_ACCOUNT_JSON=storage/app/google-credentials.json
   GOOGLE_CALENDAR_ID=primary
   ```

   If you want to use a specific calendar (not your primary one), get the Calendar ID:
   - Go to Google Calendar settings
   - Click on the calendar you want to use
   - Scroll down to "Integrate calendar"
   - Copy the "Calendar ID"
   - Update `GOOGLE_CALENDAR_ID` in `.env`

### 3. Run the Application

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## How It Works

### For Business Owners (You)

1. **Create Available Slots**: In your Google Calendar, create events with the title "Available" for time slots you want to offer
2. **Manage Bookings**: When customers book, the calendar events are automatically updated with their information
3. **View All Bookings**: Check your Google Calendar to see all appointments with full client details

### For Customers

1. **View Appointments**: Visit the website to see all available time slots
2. **Book Appointment**: Click on a slot, fill in details (name, email, phone, vehicle, service)
3. **Receive Confirmation**: Get instant confirmation - the slot is now booked in your calendar

### Example Calendar Event Flow

**Before Booking:**
- Title: "Available"
- Description: (empty)

**After Customer Books:**
- Title: "Booked - John Smith"
- Description:
  ```
  Client: John Smith
  Email: john@example.com
  Phone: (555) 123-4567
  Vehicle: 2020 Toyota Camry
  Service: Oil Change
  Notes: Need inspection too
  ```
- Attendees: john@example.com (receives calendar invite)

## Routes

- `/` - Redirects to appointments page
- `/appointments` - View available appointment slots
- `/appointments/{eventId}` - Book specific appointment
- `/appointments/confirmation/success` - Booking confirmation

## Troubleshooting

**Issue**: "Google Service Account credentials file not found"
- Make sure `google-credentials.json` is in `storage/app/`
- Check the path in `.env` matches the file location

**Issue**: "Access denied" or "403 Forbidden"
- Verify you shared your Google Calendar with the service account email
- The service account email is in the JSON file: `client_email` field
- Make sure you gave it "Make changes to events" permission

**Issue**: No available appointments showing
- Verify you have events with "Available" in the title in your Google Calendar
- Ensure the events are in the future
- Check that the calendar ID in `.env` matches your calendar

**Issue**: "Calendar not found"
- If using a specific calendar ID, verify it's correct
- Make sure you shared that specific calendar with the service account
- Try using `primary` as the calendar ID first to test

## Security Notes

- Keep your `google-credentials.json` file secure and never commit it to version control
- The `storage/` directory is already in `.gitignore` by default
- Service accounts are more secure than OAuth for this use case as there's no user token to expire

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
