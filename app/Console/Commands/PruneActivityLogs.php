<?php

namespace App\Console\Commands;

use App\Models\ActivityLog;
use Illuminate\Console\Command;

class PruneActivityLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:prune {--days=90 : Number of days to retain} {--dry-run : Show count without deleting}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete activity log entries older than the specified retention period';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoff = now()->subDays($days);

        $count = ActivityLog::where('created_at', '<', $cutoff)->count();

        if ($count === 0) {
            $this->info("No activity logs older than {$days} days.");
            return 0;
        }

        $this->info("Found {$count} activity log(s) older than {$days} days.");

        if ($this->option('dry-run')) {
            $this->info('Dry run complete. No records deleted.');
            return 0;
        }

        // Delete in chunks to avoid memory issues on large datasets
        $deleted = 0;
        do {
            $batch = ActivityLog::where('created_at', '<', $cutoff)
                ->limit(1000)
                ->delete();
            $deleted += $batch;
        } while ($batch > 0);

        $this->info("✓ Pruned {$deleted} activity log(s).");

        return 0;
    }
}
