# Admin Quick Reference Guide

Quick guide for using the admin features in CBM Auto Car Service.

## 📧 Bulk Email System

### How to Send Bulk Emails

1. **Navigate to Calendar:**
   - Login as admin
   - Go to Admin → Calendar

2. **Open Bulk Email:**
   - Click the "Bulk Email" button in the header

3. **Select Recipients:**
   - **All customers**: Everyone with appointments
   - **Completed only**: Customers with completed services
   - **Confirmed only**: Customers with upcoming confirmed appointments

4. **Compose Message:**
   - Enter subject line
   - Write your message
   - Use variables: `{customer_name}`, `{appointment_date}`, `{appointment_time}`

5. **Send:**
   - Review message carefully
   - Click "Send Email"

### Example Email

```
Subject: Special Winter Service Offer

Dear {customer_name},

We hope your vehicle is running smoothly! As a valued customer, we're offering a special 20% discount on winter tire changes.

Your last appointment was on {appointment_date}. We'd love to see you again!

Book now: http://yourdomain.com

Best regards,
CBM Auto Team
```

---

## 📊 Export Features

### Export Appointments

**Where:** Admin → Calendar → "Export Appointments" button

**What you get:**
- CSV file with all appointments
- Includes: customer name, email, phone, vehicle, date, time, status
- Can be opened in Excel or Google Sheets

**Use cases:**
- Reporting and analytics
- Backup customer data
- Import into other systems

### Export Slots

**Where:** Admin → Manage Slots → "Export Slots" button

**What you get:**
- CSV file with all available slots
- Includes: date, start time, end time, status, booked by

**Use cases:**
- Review scheduling patterns
- Plan capacity
- Archive historical availability

---

## 🗓️ Bulk Slot Creation

### Where to Find
Admin → Manage Slots → "Create New Slot" section

### Three Creation Modes

#### 1. Single Slot
**Best for:** One-time special appointments

**Steps:**
1. Select "Single Slot"
2. Choose date and time
3. Click Create

**Example:** Adding an emergency slot for tomorrow at 3 PM

#### 2. Daily Pattern
**Best for:** Creating multiple slots across specific dates

**Steps:**
1. Select "Daily Pattern"
2. Choose multiple dates (e.g., Feb 10, Feb 12, Feb 15)
3. Define time slots (e.g., 9 AM, 11 AM, 2 PM)
4. Click Create

**Example:** Adding extra slots during a busy week

#### 3. Weekly Recurring
**Best for:** Regular weekly schedule

**Steps:**
1. Select "Weekly Recurring"
2. Choose start date
3. Set number of weeks to repeat
4. Select days of week (Mon-Sun)
5. Define time slots
6. Click Create

**Example:** Opening Saturdays for the next 2 months

### Tips for Slot Creation

✅ **Do:**
- Plan ahead for holidays
- Consider staff availability
- Leave buffer time between appointments
- Create enough slots to meet demand

❌ **Don't:**
- Create overlapping slots
- Forget to account for lunch breaks
- Schedule during known busy periods without extra staff

---

## 👤 GDPR User Management

### User Data Export

**Where:** Users can access from Profile → Data & Privacy

**What's included:**
- Personal information (name, email, phone)
- Vehicle details
- Appointment history
- All timestamps

**Format:** JSON file

**When to use:**
- User requests their data
- Compliance with GDPR Article 15 (Right to Access)
- Data portability requests

### Account Deletion

**Where:** Users can request from Profile → Data & Privacy

**What happens:**
1. User clicks "Delete My Account"
2. Must enter password to confirm
3. Must check confirmation box
4. All data is permanently deleted:
   - Personal information
   - Vehicle details
   - Appointment history
   - Account credentials

**Cannot be undone!**

**Compliance:** Fulfills GDPR Article 17 (Right to Erasure)

---

## 📅 Calendar Management

### View Appointments

**Features:**
- Color-coded by status
- Click appointment to see details
- Drag and drop to reschedule
- Filter by status

### Status Colors

- 🟢 **Green**: Confirmed
- 🟡 **Yellow**: Pending
- 🔵 **Blue**: Completed
- 🔴 **Red**: Cancelled

### Quick Actions

From appointment modal:
- Mark as Complete
- Cancel Appointment
- View customer details
- Reschedule (drag & drop)

---

## 📋 Pending Requests

**Where:** Admin → Pending Requests

**What you see:**
- All new appointment requests
- Awaiting your confirmation

**Actions:**
1. Review appointment details
2. Approve or Reject
3. Customer receives email notification

**Best practice:** Review and respond within 24 hours

---

## 🎯 Best Practices

### Email Communication

✅ **Do:**
- Use professional language
- Include call-to-action
- Personalize with variables
- Test with small group first
- Check email deliverability

❌ **Don't:**
- Send too frequently (max 1-2 per month)
- Use ALL CAPS
- Include suspicious links
- Send without proofreading

### Slot Management

✅ **Do:**
- Create slots 2-4 weeks in advance
- Update during holidays
- Monitor booking patterns
- Adjust based on demand

❌ **Don't:**
- Create slots too far in advance (>3 months)
- Forget to account for staff vacations
- Double-book appointments

### Data Management

✅ **Do:**
- Export data regularly for backup
- Respect customer privacy
- Process deletion requests promptly
- Keep records of data requests

❌ **Don't:**
- Share customer data externally
- Ignore GDPR requests
- Keep data longer than necessary

---

## 🔧 Troubleshooting

### Bulk Email Not Sending

**Check:**
1. Email settings in .env are correct
2. MAIL_FROM_ADDRESS is valid
3. Check logs: `storage/logs/laravel.log`
4. Test with single email first

### Export Not Working

**Check:**
1. Sufficient disk space
2. Storage directory is writable
3. Check browser download settings

### Slots Not Appearing

**Check:**
1. Date is in the future
2. Slot hasn't been deleted
3. Clear browser cache
4. Check slot status (available vs booked)

### Redis Issues

**Check:**
1. Redis service is running: `redis-cli ping`
2. Check REDIS_HOST in .env
3. Clear cache: `php artisan cache:clear`

---

## 📞 Need Help?

### Quick Commands

**Clear cache:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**Check system:**
```bash
php artisan about
```

**View logs:**
```bash
tail -f storage/logs/laravel.log
```

### Common Issues

| Problem | Solution |
|---------|----------|
| 500 Error | Check logs, clear cache |
| Emails not sending | Verify MAIL settings in .env |
| Can't log in | Clear browser cookies |
| Slow performance | Enable Redis caching |
| Missing data | Check database connection |

---

## 📈 Analytics & Reporting

### Key Metrics to Track

1. **Appointments per week**
2. **Conversion rate** (pending → confirmed)
3. **Cancellation rate**
4. **Popular time slots**
5. **Customer retention**

### How to Get Data

1. Export appointments to CSV
2. Open in Excel/Google Sheets
3. Use pivot tables for analysis
4. Create charts and graphs

### Monthly Report Checklist

- [ ] Total appointments
- [ ] Revenue (if tracked)
- [ ] Customer satisfaction
- [ ] Most popular services
- [ ] Peak booking times
- [ ] No-show rate
- [ ] Average response time

---

## 🎓 Training Resources

### For New Admins

1. **Week 1:** Learn appointment management
2. **Week 2:** Practice slot creation
3. **Week 3:** Learn bulk operations
4. **Week 4:** Handle customer requests

### Video Tutorials

Consider creating screen recordings for:
- Creating slots (all modes)
- Sending bulk emails
- Managing appointments
- Handling GDPR requests

### Documentation

Keep this guide handy and refer to:
- [IMPLEMENTATION-CHECKLIST.md](IMPLEMENTATION-CHECKLIST.md) - Setup guide
- [DOCKER-GUIDE.md](DOCKER-GUIDE.md) - Deployment guide
- Laravel docs - For advanced features

---

*Last updated: February 9, 2026*
