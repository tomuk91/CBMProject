<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add indexes for commonly queried columns
            // Using if not exists logic via raw SQL for MySQL
        });
        
        // Use raw SQL to safely add indexes only if they don't exist
        $indexes = [
            'appointments_user_id_index' => 'ALTER TABLE appointments ADD INDEX appointments_user_id_index(user_id)',
            'appointments_slot_id_index' => 'ALTER TABLE appointments ADD INDEX appointments_slot_id_index(slot_id)',
            'appointments_status_index' => 'ALTER TABLE appointments ADD INDEX appointments_status_index(status)',
            'appointments_appointment_date_index' => 'ALTER TABLE appointments ADD INDEX appointments_appointment_date_index(appointment_date)',
            'appointments_user_id_status_index' => 'ALTER TABLE appointments ADD INDEX appointments_user_id_status_index(user_id, status)',
            'appointments_appointment_date_status_index' => 'ALTER TABLE appointments ADD INDEX appointments_appointment_date_status_index(appointment_date, status)',
        ];
        
        foreach ($indexes as $indexName => $sql) {
            try {
                DB::statement($sql);
            } catch (\Exception $e) {
                // Index already exists, skip
                if (!str_contains($e->getMessage(), 'Duplicate key name')) {
                    throw $e;
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Drop indexes in reverse order
            $table->dropIndex(['appointment_date', 'status']);
            $table->dropIndex(['user_id', 'status']);
            $table->dropIndex(['appointment_date']);
            $table->dropIndex(['status']);
            $table->dropIndex(['slot_id']);
            $table->dropIndex(['user_id']);
        });
    }
};
