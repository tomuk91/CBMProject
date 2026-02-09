<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--keep=7 : Number of days to keep backups}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the database and clean up old backups';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database backup...');

        $databasePath = database_path('database.sqlite');
        
        if (!file_exists($databasePath)) {
            $this->error('Database file not found!');
            return 1;
        }

        // Create backups directory if it doesn't exist
        $backupDir = storage_path('app/backups');
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        // Generate backup filename with timestamp
        $timestamp = now()->format('Y-m-d_His');
        $backupFile = $backupDir . '/database_backup_' . $timestamp . '.sqlite';

        // Copy the database file
        if (copy($databasePath, $backupFile)) {
            $fileSize = round(filesize($backupFile) / 1024, 2);
            $this->info("✓ Backup created successfully: database_backup_{$timestamp}.sqlite ({$fileSize} KB)");
            
            // Clean up old backups
            $this->cleanupOldBackups($backupDir, $this->option('keep'));
            
            return 0;
        } else {
            $this->error('✗ Failed to create backup!');
            return 1;
        }
    }

    /**
     * Clean up old backup files
     */
    protected function cleanupOldBackups($backupDir, $keepDays)
    {
        $this->info("Cleaning up backups older than {$keepDays} days...");
        
        $files = glob($backupDir . '/database_backup_*.sqlite');
        $cutoffTime = now()->subDays($keepDays)->timestamp;
        $deletedCount = 0;

        foreach ($files as $file) {
            if (filemtime($file) < $cutoffTime) {
                if (unlink($file)) {
                    $deletedCount++;
                }
            }
        }

        if ($deletedCount > 0) {
            $this->info("✓ Deleted {$deletedCount} old backup(s)");
        } else {
            $this->info('✓ No old backups to clean up');
        }
    }
}
