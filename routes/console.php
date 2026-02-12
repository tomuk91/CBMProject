<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule cleanup of old slots every hour
Schedule::command('slots:cleanup')->hourly()->withoutOverlapping();

// Send appointment reminders 24 hours before appointment
Schedule::command('appointments:send-reminders --hours=24')->hourly()->withoutOverlapping();

// Send MOT reminders 30 days before MOT expires (1 year after completion)
Schedule::command('appointments:send-mot-reminders --days=30')->dailyAt('05:00')->withoutOverlapping();

// Auto-generate slots from schedule templates daily at 1:00 AM
Schedule::command('slots:generate')->dailyAt('01:00')->withoutOverlapping();

// Backup database daily at 2:00 AM
Schedule::command('db:backup')->dailyAt('02:00')->withoutOverlapping();

// Auto-complete past confirmed appointments daily at 3:00 AM
Schedule::command('appointments:complete-passed')->dailyAt('03:00')->withoutOverlapping();

// Prune activity logs older than 90 days weekly on Sundays at 4:00 AM
Schedule::command('logs:prune --days=90')->weeklyOn(0, '04:00')->withoutOverlapping();
