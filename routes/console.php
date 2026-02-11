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

// Auto-generate slots from schedule templates daily at 1:00 AM
Schedule::command('slots:generate')->dailyAt('01:00')->withoutOverlapping();
