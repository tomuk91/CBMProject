<?php

namespace App\Console\Commands;

use App\Enums\AppointmentStatus;
use App\Mail\AppointmentCompleted;
use App\Models\ActivityLog;
use App\Models\Appointment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CompletePassedAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointments:complete-passed {--dry-run : Show what would be updated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark confirmed appointments in the past as completed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $appointments = Appointment::where('status', AppointmentStatus::Confirmed)
            ->where('appointment_date', '<', now()->subDay())
            ->get();

        if ($appointments->isEmpty()) {
            $this->info('No past confirmed appointments found.');
            return 0;
        }

        $this->info("Found {$appointments->count()} past confirmed appointment(s).");

        if ($this->option('dry-run')) {
            foreach ($appointments as $appointment) {
                $this->line("  Would complete: {$appointment->name} - {$appointment->service} ({$appointment->appointment_date})");
            }
            $this->info('Dry run complete. No changes made.');
            return 0;
        }

        $completed = 0;

        foreach ($appointments as $appointment) {
            $appointment->update([
                'status' => AppointmentStatus::Completed,
            ]);

            ActivityLog::log(
                'completed',
                "Auto-completed past appointment for {$appointment->name} - {$appointment->service}",
                $appointment
            );

            // Send follow-up email
            Mail::to($appointment->email)->queue(new AppointmentCompleted($appointment));

            $completed++;
        }

        $this->info("✓ Completed {$completed} appointment(s).");

        return 0;
    }
}
