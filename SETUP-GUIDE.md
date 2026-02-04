# Google Calendar Service Account Setup Guide

## Step 1: Create a Google Cloud Project and Service Account

1. **Go to Google Cloud Console**
   - Visit: https://console.cloud.google.com/

2. **Create or Select a Project**
   - Click the project dropdown at the top
   - Click "New Project"
   - Name it "Car Service Booking" (or your preference)
   - Click "Create"

3. **Enable Google Calendar API**
   - In the left sidebar, go to "APIs & Services" > "Library"
   - Search for "Google Calendar API"
   - Click on it and click "Enable"

4. **Create Service Account**
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "Service Account"
   - Service account details:
     - Name: `car-service-calendar`
     - ID: (auto-filled)
     - Description: "Service account for car service booking system"
   - Click "Create and Continue"
   - Skip role assignment (click "Continue")
   - Click "Done"

5. **Create and Download Service Account Key**
   - You'll see your service account in the list
   - Click on the service account email
   - Go to the "Keys" tab
   - Click "Add Key" > "Create new key"
   - Select "JSON" format
   - Click "Create"
   - A JSON file will download automatically - **SAVE THIS FILE!**

6. **Note the Service Account Email**
   - The service account email looks like: `car-service-calendar@your-project.iam.gserviceaccount.com`
   - You'll need this in the next step

## Step 2: Share Your Google Calendar

1. **Open Google Calendar**
   - Go to: https://calendar.google.com

2. **Access Calendar Settings**
   - Find your calendar in the left sidebar (usually "My calendars")
   - Hover over it and click the three dots (⋮)
   - Click "Settings and sharing"

3. **Share with Service Account**
   - Scroll down to "Share with specific people or groups"
   - Click "Add people and groups"
   - Paste the service account email from Step 1.6
   - Change permission from "See all event details" to **"Make changes to events"**
   - **Uncheck "Send email notification"** (service accounts can't read emails)
   - Click "Send"

## Step 3: Configure Your Laravel Application

1. **Move the credentials file**
   ```bash
   cd car-service
   mv ~/Downloads/your-project-xxxxx.json storage/app/google-credentials.json
   ```

2. **Verify the .env configuration**
   ```env
   GOOGLE_SERVICE_ACCOUNT_JSON=storage/app/google-credentials.json
   GOOGLE_CALENDAR_ID=primary
   ```

3. **Test the connection**
   ```bash
   php artisan serve
   ```
   Visit http://localhost:8000/appointments

## Step 4: Create Your First Available Slot

1. **Go to Google Calendar**
   - Visit: https://calendar.google.com

2. **Create an event**
   - Click on a future date/time
   - Title: `Available`
   - Set the date and time you want to offer
   - Click "Save"

3. **View it on your website**
   - Refresh http://localhost:8000/appointments
   - You should see your available slot!

4. **Test booking**
   - Click "Book This Slot"
   - Fill in the form
   - Submit
   - Check your Google Calendar - the event should now show the booking details!

## Troubleshooting

### "credentials file not found"
- Make sure the file is at `storage/app/google-credentials.json`
- Check that the path in `.env` is correct
- Verify the file has proper permissions: `chmod 644 storage/app/google-credentials.json`

### "403 Forbidden" or "Calendar not found"
- Make sure you shared the calendar with the service account email
- Verify the permission is "Make changes to events" not just "See all event details"
- Wait a minute or two after sharing - it can take a moment to propagate

### "No available appointments showing"
- Create events with exactly "Available" in the title
- Make sure the events are in the future
- The event must be in the calendar you shared with the service account

### Service account email not working
- The email is in the JSON file under `client_email`
- Copy it exactly - it looks like: `name@project-id.iam.gserviceaccount.com`
- Make sure there are no extra spaces when pasting

## Security Best Practices

1. **Never commit credentials to git**
   - The `storage/` directory is already in `.gitignore`
   - Double-check before pushing code

2. **Restrict service account permissions**
   - Only share the specific calendar needed
   - Use "Make changes to events" not "Make changes and manage sharing"

3. **Rotate keys periodically**
   - Create new keys every 90 days
   - Delete old keys after updating the application

4. **For production**
   - Store credentials securely (use environment variables or secret management)
   - Consider using Google Cloud Secret Manager
   - Set up monitoring for API usage
