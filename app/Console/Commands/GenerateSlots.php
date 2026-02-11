<?php

namespace App\Console\Commands;

use App\Services\SlotGenerationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GenerateSlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slots:generate {--weeks= : Number of weeks ahead to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-generate available slots from active schedule templates';

    /**
     * Execute the console command.
     */
    public function handle(SlotGenerationService $service): int
    {
        $weeks = $this->option('weeks') ? (int) $this->option('weeks') : null;

        $this->info('Generating slots from active schedule templates...');

        $result = $service->generateAll($weeks);

        $this->info("Slot generation complete:");
        $this->info("  Created: {$result['created']}");
        $this->info("  Skipped (overlap): {$result['skipped']}");
        $this->info("  Blocked dates: {$result['blocked']}");

        Log::info('Slot auto-generation completed', $result);

        return self::SUCCESS;
    }
}
