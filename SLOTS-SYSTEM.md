# Updated Appointment System - Available Slots Workflow

## Overview
The appointment system has been restructured so admins create available time slots first, and customers select from those slots when booking appointments.

## New Workflow

### 1. Admin Creates Available Slots
1. Go to `/admin/appointments/slots`
2. Fill in:
   - **Date**: Select a future date
   - **Start Time**: When the slot starts
   - **Duration**: How long the appointment slot is (30 min, 1 hr, 1.5 hr, 2 hr)
3. Click "Create Slot"
4. Slots appear in the list with status "available"

### 2. Customer Books from Available Slots
1. Customer goes to `/appointments`
2. Sees list of all available time slots
3. Selects a slot and clicks "Book This Slot"
4. Fills out booking form with:
   - Name, email, phone
   - Vehicle information
   - Service type needed
   - Optional notes
5. Request is submitted with status "pending"

### 3. Admin Reviews Pending Requests
1. Go to `/admin/appointments/pending`
2. See all pending appointment requests with:
   - Customer details
   - Selected time slot
   - Service requested
   - Vehicle information
3. Click "Approve" to confirm and add to calendar
4. Click "Reject" to decline and release slot back to available

### 4. View Calendar
1. Go to `/admin/appointments/calendar`
2. See all confirmed appointments
3. Interactive calendar with month/week/day views

## Database Changes

### New Table: `available_slots`
- `id` - Primary key
- `start_time` - When slot starts
- `end_time` - When slot ends
- `status` - available, pending, or booked
- `timestamps` - created_at, updated_at

### Updated Table: `pending_appointments`
- Added `available_slot_id` - Foreign key to available_slots
- Removed `requested_date` and `requested_end` (now from slot)
- Slot information stored in relationship

## URL Structure

| Purpose | URL | Method |
|---------|-----|--------|
| View available slots | `/appointments` | GET |
| Book a slot | `/appointments/{slot}` | GET (show form) |
| Submit booking | `/appointments/{slot}/book` | POST |
| Manage slots | `/admin/appointments/slots` | GET |
| Create slot | `/admin/appointments/slots` | POST |
| Delete slot | `/admin/appointments/slots/{slot}` | DELETE |
| Pending requests | `/admin/appointments/pending` | GET |
| Approve request | `/admin/appointments/pending/{id}/approve` | POST |
| Reject request | `/admin/appointments/pending/{id}/reject` | POST |
| Calendar view | `/admin/appointments/calendar` | GET |

## Quick Steps to Get Started

### 1. Create Admin User
```bash
php artisan user:make-admin your-email@example.com
```

### 2. Create Available Slots
1. Login as admin
2. Go to `/admin/appointments/slots`
3. Create several slots for different dates/times

### 3. Test Customer Booking
1. Go to `/appointments` (as customer)
2. Select an available slot
3. Fill out booking form
4. Submit

### 4. Admin Approval
1. Go to `/admin/appointments/pending`
2. Review the pending booking
3. Click "Approve" to confirm

### 5. View on Calendar
1. Go to `/admin/appointments/calendar`
2. See the confirmed appointment

## Slot Status Flow

```
Admin Creates Slot
        ↓
   AVAILABLE ← (Customer can book)
        ↓
Customer Books
        ↓
   PENDING ← (Admin reviews)
        ↓
    ╱──────╲
   ↙        ↘
BOOKED   AVAILABLE
(approved) (rejected)
```

## Models

### AvailableSlot
- `start_time` - DateTime
- `end_time` - DateTime
- `status` - String (available, pending, booked)
- Scope: `available()` - Returns future available slots only

### PendingAppointment
- Relationship: `availableSlot()` - Belongs to AvailableSlot
- When approved: Creates Appointment with slot times
- When rejected: Slot reverts to available

### Appointment
- Created when admin approves pending appointment
- Uses times from the AvailableSlot

## Admin Features

### Manage Slots Page
- View all slots (past and future)
- Shows slot times and duration
- Shows current status (available/pending/booked)
- Can delete available slots
- Cannot delete pending or booked slots

### Pending Requests Page
- Shows customer details
- Shows selected slot time
- Shows service requested
- Approve with optional notes
- Reject with optional notes

### Calendar View
- All confirmed appointments
- Color-coded by status
- Click for details
- Month/week/day views
