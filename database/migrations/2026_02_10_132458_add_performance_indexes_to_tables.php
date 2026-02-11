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
        Schema::table('pending_appointments', function (Blueprint $table) {
            if (!Schema::hasIndex('pending_appointments', 'pending_appointments_status_index')) {
                $table->index('status', 'pending_appointments_status_index');
            }
            if (!Schema::hasIndex('pending_appointments', 'pending_appointments_user_id_status_index')) {
                $table->index(['user_id', 'status'], 'pending_appointments_user_id_status_index');
            }
            if (!Schema::hasIndex('pending_appointments', 'pending_appointments_vehicle_id_index')) {
                $table->index('vehicle_id', 'pending_appointments_vehicle_id_index');
            }
        });

        // Add indexes to available_slots table
        Schema::table('available_slots', function (Blueprint $table) {
            if (!Schema::hasIndex('available_slots', 'available_slots_status_index')) {
                $table->index('status', 'available_slots_status_index');
            }
            if (!Schema::hasIndex('available_slots', 'available_slots_start_time_index')) {
                $table->index('start_time', 'available_slots_start_time_index');
            }
            if (!Schema::hasIndex('available_slots', 'available_slots_status_start_time_index')) {
                $table->index(['status', 'start_time'], 'available_slots_status_start_time_index');
            }
        });

        // Add indexes to vehicles table
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasIndex('vehicles', 'vehicles_user_id_index')) {
                $table->index('user_id', 'vehicles_user_id_index');
            }
            if (!Schema::hasIndex('vehicles', 'vehicles_is_primary_index')) {
                $table->index('is_primary', 'vehicles_is_primary_index');
            }
        });

        // Add index to appointments for vehicle_id
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasIndex('appointments', 'appointments_vehicle_id_index')) {
                $table->index('vehicle_id', 'appointments_vehicle_id_index');
            }
            if (!Schema::hasIndex('appointments', 'appointments_vehicle_id_status_index')) {
                $table->index(['vehicle_id', 'status'], 'appointments_vehicle_id_status_index');
            }
            if (!Schema::hasIndex('appointments', 'appointments_cancellation_requested_index')) {
                $table->index('cancellation_requested', 'appointments_cancellation_requested_index');
            }
        });
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
};
