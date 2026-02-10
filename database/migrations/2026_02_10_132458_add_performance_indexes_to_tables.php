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
        // Add indexes to pending_appointments table
        $this->addIndexSafely('pending_appointments', 'pending_appointments_status_index', 'status');
        $this->addIndexSafely('pending_appointments', 'pending_appointments_user_id_status_index', 'user_id, status');
        $this->addIndexSafely('pending_appointments', 'pending_appointments_vehicle_id_index', 'vehicle_id');
        
        // Add indexes to available_slots table
        $this->addIndexSafely('available_slots', 'available_slots_status_index', 'status');
        $this->addIndexSafely('available_slots', 'available_slots_start_time_index', 'start_time');
        $this->addIndexSafely('available_slots', 'available_slots_status_start_time_index', 'status, start_time');
        
        // Add indexes to vehicles table
        $this->addIndexSafely('vehicles', 'vehicles_user_id_index', 'user_id');
        $this->addIndexSafely('vehicles', 'vehicles_is_primary_index', 'is_primary');
        
        // Add index to appointments for vehicle_id
        $this->addIndexSafely('appointments', 'appointments_vehicle_id_index', 'vehicle_id');
        $this->addIndexSafely('appointments', 'appointments_vehicle_id_status_index', 'vehicle_id, status');
        $this->addIndexSafely('appointments', 'appointments_cancellation_requested_index', 'cancellation_requested');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_appointments', function (Blueprint $table) {
            $table->dropIndex('pending_appointments_status_index');
            $table->dropIndex('pending_appointments_user_id_status_index');
            $table->dropIndex('pending_appointments_vehicle_id_index');
        });
        
        Schema::table('available_slots', function (Blueprint $table) {
            $table->dropIndex('available_slots_status_index');
            $table->dropIndex('available_slots_start_time_index');
            $table->dropIndex('available_slots_status_start_time_index');
        });
        
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropIndex('vehicles_user_id_index');
            $table->dropIndex('vehicles_is_primary_index');
        });
        
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('appointments_vehicle_id_index');
            $table->dropIndex('appointments_vehicle_id_status_index');
            $table->dropIndex('appointments_cancellation_requested_index');
        });
    }
    
    /**
     * Safely add index only if it doesn't exist
     */
    private function addIndexSafely(string $table, string $indexName, string $columns): void
    {
        try {
            DB::statement("ALTER TABLE {$table} ADD INDEX {$indexName}({$columns})");
        } catch (\Exception $e) {
            // Index already exists, skip
            if (!str_contains($e->getMessage(), 'Duplicate key name')) {
                throw $e;
            }
        }
    }
};
