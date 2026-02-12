<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Mail\MOTReminderDue;
use App\Services\BatchEmailService;
use Illuminate\Console\Command;

class SendMOTReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:send-mot-reminders {--days=30 : Days before MOT expires to send reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for MOT appointments expiring soon (1 year after completion)';

    /**
     * Execute the console command.
     */
    public function handle(BatchEmailService $batchEmailService)
    {
        $daysAhead = (int) $this->option('days');
        $targetDate = now()->addDays($daysAhead);

        $this->info("Looking for MOT appointments expiring around " . $targetDate->format('Y-m-d'));

        // Find completed MOT appointments where 1 year has passed (or close to it)
        // We'll look for appointments where 1 year - $daysAhead days has passed
        $expiryThreshold = now()->subYear()->addDays($daysAhead);
        
        $appointments = Appointment::with(['user', 'vehicle'])
            ->where('status', 'completed')
            ->where('service', 'MOT Service')
            ->whereNull('reminder_sent_at')
            ->whereBetween('appointment_date', [
                $expiryThreshold->copy()->subDays(1),
                $expiryThreshold->copy()->addDays(1)
            ])
            ->get();

        if ($appointments->isEmpty()) {
            $this->info('No MOT appointments found for renewal reminders.');
            return 0;
        }

        $this->info("Found {$appointments->count()} MOT appointment(s) due for renewal.");

        // Build batch email payload
        $emails = [];
        foreach ($appointments as $appointment) {
            $emails[] = [
                'to' => $appointment->email,
                'mailable' => new MOTReminderDue($appointment),
            ];
        }

        // Send all reminders via Resend batch API (up to 100 per request)
        $this->info('Sending MOT reminders via batch API...');
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
