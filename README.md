# CBM Auto — Car Service Booking System

A full-featured car service appointment booking system built with **Laravel 12**, featuring an admin dashboard, multi-language support (EN/HU), email notifications, and a responsive dark-mode UI.

## Features

### Customer-Facing
- 🗓 **Appointment Booking** — browse available slots on an interactive calendar and book with one click
- 🚗 **Vehicle Management** — register multiple vehicles with photos (stored on Cloudflare R2)
- 📧 **Email Notifications** — confirmation, reminders (1 h & 24 h), approval/rejection, and cancellation emails via Resend
- 📱 **Responsive Design** — Tailwind CSS + Alpine.js, fully mobile-optimised with dark mode
- 🌍 **Multi-Language** — English and Hungarian (`/language/en`, `/language/hu`)
- 🔒 **GDPR Compliance** — personal data export and account deletion
- ♿ **Accessibility** — skip-to-content link, ARIA labels, keyboard navigation, focus indicators

### Admin Panel
- 📊 **Dashboard** — pending appointments, today's schedule, quick stats with cached counts
- 📅 **Calendar Management** — drag-and-drop calendar (FullCalendar), manual slot creation, bulk operations
- ⏰ **Schedule Templates** — recurring weekly schedules with automatic slot generation
- ✅ **Approval Workflow** — review, approve, or reject pending bookings; bulk approve/reject
- 🚫 **Blocked Dates** — block specific dates (holidays, closures) from slot generation
- 📈 **Analytics** — booking trends, service breakdown, customer stats, CSV export
- 👥 **Customer Directory** — view customers, their vehicles, and service history
- 📬 **Contact Submissions** — manage messages from the contact form
- 📧 **Bulk Email** — send announcements to customers
- 🖨 **Print Schedule** — printable daily/weekly schedule view
- 📋 **Activity Log** — full audit trail of all admin actions
- 🎓 **Guided Tours** — interactive onboarding for new admins

### Security & Performance
- 🔐 **Authentication** — Laravel Breeze with email verification and secure sessions
- 🛡 **Security Headers** — CSP, HSTS, X-Content-Type-Options, CORP, COOP, Permissions-Policy
- 🧹 **Input Sanitisation** — HTMLPurifier on all user-submitted text
- ⚡ **Rate Limiting** — throttle on login, registration, contact form, booking, and admin bulk operations
- 🏎 **Performance** — eager loading, N+1 prevention (local), dashboard caching, composite DB indexes
- 🐢 **Slow Query Logging** — queries > 500 ms logged in production

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Framework | Laravel 12 (PHP 8.4) |
| Frontend | Tailwind CSS 3, Alpine.js 3, Vite 7 |
| Database | MySQL 8 (production), SQLite (testing) |
| Cache / Sessions | Redis |
| Email | Resend |
| File Storage | Cloudflare R2 (vehicle images) |
| Calendar UI | FullCalendar 6 |
| Date Picker | Flatpickr |
| Testing | PHPUnit — 118 tests, 269 assertions |
| CI | GitHub Actions |
| Deployment | Docker (Supervisor: Apache + queue worker + scheduler) |

## Quick Start

### Prerequisites
- PHP ≥ 8.4
- Composer
- Node.js ≥ 18 & npm
- MySQL 8 or SQLite
- Redis

### Local Setup

```bash
# Clone & install
git clone <repo-url> car-service && cd car-service
composer install
npm install && npm run build

# Environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --seed

# Run
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000).

### Docker Setup

```bash
docker compose up -d
```

Services: **app** (PHP 8.4 + Apache), **db** (MySQL 8), **redis** (Redis 8).  
See [DOCKER-GUIDE.md](DOCKER-GUIDE.md) for full Docker documentation.

## Environment Variables

Copy `.env.example` and configure these key variables:

| Variable | Description |
|----------|-------------|
| `APP_NAME` | Application name (default: `CBM Auto`) |
| `DB_CONNECTION` | `mysql` for production, `sqlite` for local |
| `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | MySQL connection |
| `REDIS_HOST`, `REDIS_PORT` | Redis for cache & sessions |
| `MAIL_MAILER` | `resend` for production, `log` for local |
| `RESEND_API_KEY` | Resend API key for emails |
| `R2_ACCESS_KEY_ID`, `R2_SECRET_ACCESS_KEY`, `R2_BUCKET`, `R2_ENDPOINT` | Cloudflare R2 for vehicle images |
| `GOOGLE_CALENDAR_ID` | Optional Google Calendar integration |
| `ADMIN_EMAIL`, `ADMIN_PASSWORD`, `ADMIN_NAME` | Auto-created admin account (Docker) |

See `.env.example` for the full list including business info, hours, and SEO settings.

## Admin Access

The first admin account is created automatically by the database seeder or Docker entrypoint. To manually create one:

```bash
php artisan tinker
>>> User::create(['name'=>'Admin','email'=>'admin@example.com','password'=>bcrypt('password'),'is_admin'=>true,'email_verified_at'=>now()]);
```

## Testing

```bash
php artisan test
```

Tests use an in-memory SQLite database (configured in `phpunit.xml`). The suite covers:

- Booking flow (guest → login → book → approve/reject)
- Admin CRUD (appointments, slots, schedule templates, blocked dates)
- Authentication flow (login, register, email verification)
- Service classes (AppointmentService, SlotGenerationService)
- Email mailables
- Form request validation
- Middleware (admin, locale, security headers)

## Scheduled Commands

| Command | Schedule | Purpose |
|---------|----------|---------|
| `slots:generate` | Daily at 01:00 | Auto-generate slots from active templates |
| `slots:cleanup` | Hourly | Remove expired available slots |
| `appointments:send-reminders` | Hourly | Send 1 h and 24 h email reminders |

In production, ensure `php artisan schedule:run` executes every minute (handled by Supervisor in Docker).

## Project Structure

```
app/
├── Console/Commands/    # Artisan commands (slot generation, cleanup, reminders)
├── Enums/               # AppointmentStatus, SlotStatus
├── Http/
│   ├── Controllers/     # Web + Admin controllers
│   ├── Middleware/       # IsAdmin, SetLocale, SecurityHeaders, LogFailedLogins
│   └── Requests/        # Form request validation
├── Mail/                # 15 mailable classes
├── Models/              # Eloquent models
├── Services/            # AppointmentService, SlotGenerationService, CarImageService, etc.
└── View/                # View composers
```

## License

MIT
