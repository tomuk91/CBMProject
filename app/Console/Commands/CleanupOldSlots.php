<?php

namespace App\Console\Commands;

use App\Models\AvailableSlot;
use App\Models\PendingAppointment;
use Illuminate\Console\Command;

class CleanupOldSlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slots:cleanup {--days=7 : Delete slots older than this many days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old available slots and expired pending appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = now()->subDays($days);

        $this->info("Cleaning up slots and pending appointments older than {$days} days...");

        // Delete old available slots that have passed and are not booked/pending
        // (preserves booked slots for historical records)
        $oldAvailableSlots = AvailableSlot::where('status', 'available')
            ->where('start_time', '<', now())
            ->count();
        AvailableSlot::where('status', 'available')
            ->where('start_time', '<', now())
            ->delete();

        if ($oldAvailableSlots > 0) {
            $this->info("✓ Deleted {$oldAvailableSlots} expired available slot(s)");
        }

        // Delete very old slots (booked/pending) past the cutoff for cleanup
        $veryOldSlots = AvailableSlot::where('start_time', '<', $cutoffDate)->count();
        AvailableSlot::where('start_time', '<', $cutoffDate)->delete();

        if ($veryOldSlots > 0) {
            $this->info("✓ Deleted {$veryOldSlots} old slot(s) past {$days}-day cutoff");
        }

        // Delete old pending appointments (older than 7 days)
        $oldPending = PendingAppointment::where('status', 'pending')
            ->where('created_at', '<', $cutoffDate)
            ->count();
        
        PendingAppointment::where('status', 'pending')
            ->where('created_at', '<', $cutoffDate)
            ->delete();
        
        if ($oldPending > 0) {
            $this->info("✓ Deleted {$oldPending} old pending appointment(s)");
        }

        if ($oldSlots === 0 && $oldPending === 0) {
            $this->info('✓ No old data to clean up');
        }

        return 0;
    }
}
