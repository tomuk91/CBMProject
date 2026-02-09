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

        // Delete old available slots that have passed
        $oldSlots = AvailableSlot::where('start_time', '<', $cutoffDate)->count();
        AvailableSlot::where('start_time', '<', $cutoffDate)->delete();
        
        if ($oldSlots > 0) {
            $this->info("✓ Deleted {$oldSlots} old slot(s)");
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
