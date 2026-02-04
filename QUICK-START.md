# Quick Start Guide - New Appointment System

## Getting Started (5 Minutes)

### Step 1: Make Yourself an Admin
```bash
cd /Users/tom.thornton/Desktop/untitled\ folder/car-service
php artisan user:make-admin your-email@example.com
```

### Step 2: Access the System
Open your browser and visit:
- **Customer Booking**: http://localhost:8000/appointments
- **Admin Calendar**: http://localhost:8000/admin/appointments/calendar
- **Pending Requests**: http://localhost:8000/admin/appointments/pending

## Quick Command Reference

```bash
# Make a user an admin
php artisan user:make-admin email@example.com

# Run migrations (if not already done)
php artisan migrate

# Start development server
php artisan serve

# Clear cache if needed
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## User Flow

### Customer Books Appointment:
1. Visit `/appointments`
2. Click "Request an Appointment"
3. Fill form with details and preferred date/time
4. Submit → Status: **Pending**

### Admin Reviews Request:
1. Visit `/admin/appointments/pending`
2. See all pending requests
3. Click "Approve" or "Reject"
4. If approved → Appointment added to calendar

### View Calendar:
1. Visit `/admin/appointments/calendar`
2. Interactive calendar shows all appointments
3. Click events to see details
4. Switch between month/week/day views

## Key URLs

| Purpose | URL | Required Role |
|---------|-----|---------------|
| Home | `/` | Public |
| Customer Dashboard | `/dashboard` | User |
| Book Appointment | `/appointments/create` | User |
| Admin Calendar | `/admin/appointments/calendar` | Admin |
| Pending Requests | `/admin/appointments/pending` | Admin |

## Color Coding in Calendar

- 🔵 **Blue**: Confirmed appointments
- 🟢 **Green**: Completed appointments
- 🔴 **Red**: Cancelled appointments

## Troubleshooting

### "403 Unauthorized" when accessing admin pages?
Make sure you've run the command to make your user an admin:
```bash
php artisan user:make-admin your-email@example.com
```

### Database errors?
Run migrations:
```bash
php artisan migrate
```

### Calendar not loading?
Check browser console for JavaScript errors. The calendar requires internet connection for FullCalendar CDN.

### Changes not showing?
Clear cache:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Next Steps

1. ✅ Make yourself admin
2. ✅ Test customer booking flow
3. ✅ Test admin approval process
4. ✅ Explore calendar features
5. 🔲 Customize email notifications (optional)
6. 🔲 Add more service types (optional)
7. 🔲 Customize appointment durations (optional)

## Support

For detailed information, see: `APPOINTMENT-SYSTEM-CHANGES.md`
