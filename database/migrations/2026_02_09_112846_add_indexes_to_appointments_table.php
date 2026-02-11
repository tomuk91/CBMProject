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
            // Add indexes for commonly queried columns (DB-agnostic)
            if (!Schema::hasIndex('appointments', 'appointments_user_id_index')) {
                $table->index('user_id', 'appointments_user_id_index');
            }
            if (!Schema::hasIndex('appointments', 'appointments_status_index')) {
                $table->index('status', 'appointments_status_index');
            }
            if (!Schema::hasIndex('appointments', 'appointments_appointment_date_index')) {
                $table->index('appointment_date', 'appointments_appointment_date_index');
            }
            if (!Schema::hasIndex('appointments', 'appointments_user_id_status_index')) {
                $table->index(['user_id', 'status'], 'appointments_user_id_status_index');
            }
            if (!Schema::hasIndex('appointments', 'appointments_appointment_date_status_index')) {
                $table->index(['appointment_date', 'status'], 'appointments_appointment_date_status_index');
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
