<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Mail\AppointmentReminder24Hours;
use App\Services\BatchEmailService;
use Illuminate\Console\Command;

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
    public function handle(BatchEmailService $batchEmailService)
    {
        $hoursAhead = (int) $this->option('hours');
        $targetTime = now()->addHours($hoursAhead);

        $this->info("Looking for appointments around " . $targetTime->format('Y-m-d H:i'));

        // Get appointments within 30-minute window that haven't been reminded yet
        $appointments = Appointment::with(['user', 'vehicle'])
            ->where('status', 'confirmed')
            ->whereNull('reminder_sent_at')
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

        // Build batch email payload
        $emails = [];
        foreach ($appointments as $appointment) {
            $emails[] = [
                'to' => $appointment->email,
                'mailable' => new AppointmentReminder24Hours($appointment),
            ];
        }

        // Send all reminders via Resend batch API (up to 100 per request)
        $this->info('Sending reminders via batch API...');
        $result = $batchEmailService->sendBatch($emails);

        // Mark reminders as sent to prevent duplicates
        Appointment::whereIn('id', $appointments->pluck('id'))
            ->update(['reminder_sent_at' => now()]);

        $this->info("✓ Sent: {$result['sent']}");
        if ($result['failed'] > 0) {
            $this->error("✗ Failed: {$result['failed']}");
        }

        return 0;
    }
}
