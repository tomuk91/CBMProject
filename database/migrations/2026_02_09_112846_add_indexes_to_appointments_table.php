<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Add indexes for commonly queried columns only if they don't exist
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('appointments');
            
            if (!isset($indexesFound['appointments_user_id_index'])) {
                $table->index('user_id');
            }
            if (!isset($indexesFound['appointments_slot_id_index'])) {
                $table->index('slot_id');
            }
            if (!isset($indexesFound['appointments_status_index'])) {
                $table->index('status');
            }
            if (!isset($indexesFound['appointments_appointment_date_index'])) {
                $table->index('appointment_date');
            }
            if (!isset($indexesFound['appointments_user_id_status_index'])) {
                $table->index(['user_id', 'status']);
            }
            if (!isset($indexesFound['appointments_appointment_date_status_index'])) {
                $table->index(['appointment_date', 'status']);
            }
        });
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
