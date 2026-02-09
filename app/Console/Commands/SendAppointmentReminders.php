<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Mail\AppointmentReminder24Hours;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendAppointmentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-reminders {--hours=24 : Hours before appointment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for upcoming appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hoursAhead = (int) $this->option('hours');
        $targetTime = now()->addHours($hoursAhead);

        $this->info("Looking for appointments around " . $targetTime->format('Y-m-d H:i'));

        // Get appointments within 30-minute window
        $appointments = Appointment::with(['user', 'vehicle'])
            ->where('status', 'confirmed')
            ->whereBetween('appointment_date', [
                $targetTime->copy()->subMinutes(30),
                $targetTime->copy()->addMinutes(30)
            ])
            ->get();

        if ($appointments->isEmpty()) {
            $this->info('No appointments found for reminders.');
            return 0;
        }

        $this->info("Found {$appointments->count()} appointment(s) to remind.");

        $bar = $this->output->createProgressBar($appointments->count());
        $bar->start();

        $sent = 0;
        $failed = 0;

        foreach ($appointments as $appointment) {
            try {
                Mail::to($appointment->email)->queue(new AppointmentReminder24Hours($appointment));
                $sent++;
            } catch (\Exception $e) {
                \Log::error("Failed to send reminder for appointment {$appointment->id}: " . $e->getMessage());
                $failed++;
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✓ Sent: {$sent}");
        if ($failed > 0) {
            $this->error("✗ Failed: {$failed}");
        }

        return 0;
    }
}
