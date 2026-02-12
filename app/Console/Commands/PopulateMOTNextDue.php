<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Console\Command;

class PopulateMOTNextDue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:populate-mot-next-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate MOT Next Due field for all users based on their completed MOT appointments';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Populating MOT Next Due dates for all users...');

        // Get all users
        $users = User::all();
        $updated = 0;
        $unknown = 0;

        foreach ($users as $user) {
            // Find the most recent completed MOT appointment for this user
            $lastMOT = Appointment::where('user_id', $user->id)
                ->where('service', 'MOT Service')
                ->where('status', 'completed')
                ->orderBy('appointment_date', 'desc')
                ->first();

            if ($lastMOT) {
                // Calculate next due date (1 year from completion)
                $nextDue = \Carbon\Carbon::parse($lastMOT->appointment_date)->addYear()->format('Y-m-d');
                $user->update(['mot_next_due' => $nextDue]);
                $this->line("  ✓ {$user->name} - Next MOT due: {$nextDue}");
                $updated++;
            } else {
                // No MOT found, set to Unknown
                $user->update(['mot_next_due' => 'Unknown']);
                $this->line("  - {$user->name} - No MOT history");
                $unknown++;
            }
        }

        $this->info("✓ Completed: {$updated} users updated with MOT due dates, {$unknown} set to Unknown");

        return 0;
    }
}
