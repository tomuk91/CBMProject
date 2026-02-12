<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add composite indexes for frequently queried patterns.
     * Sprint 6: Performance & Security (#72)
     */
    public function up(): void
    {
        // Appointments: status + appointment_date (dashboard, calendar, reminders)
        Schema::table('appointments', function (Blueprint $table) {
            if (!Schema::hasIndex('appointments', 'appointments_status_date_index')) {
                $table->index(['status', 'appointment_date'], 'appointments_status_date_index');
            }
            if (!Schema::hasIndex('appointments', 'appointments_user_id_status_index')) {
                $table->index(['user_id', 'status'], 'appointments_user_id_status_index');
            }
        });

        // Activity logs: action + created_at (activity log page filtering)
        Schema::table('activity_logs', function (Blueprint $table) {
            if (!Schema::hasIndex('activity_logs', 'activity_logs_action_created_index')) {
                $table->index(['action', 'created_at'], 'activity_logs_action_created_index');
            }
        });

        // Contact submissions: is_read (admin inbox filtering)
        Schema::table('contact_submissions', function (Blueprint $table) {
            if (!Schema::hasIndex('contact_submissions', 'contact_submissions_is_read_index')) {
                $table->index('is_read', 'contact_submissions_is_read_index');
            }
        });

        // Schedule templates: is_active + day_of_week (slot generation)
        Schema::table('schedule_templates', function (Blueprint $table) {
            if (!Schema::hasIndex('schedule_templates', 'schedule_templates_active_day_index')) {
                $table->index(['is_active', 'day_of_week'], 'schedule_templates_active_day_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('appointments_status_date_index');
            $table->dropIndex('appointments_user_id_status_index');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('activity_logs_action_created_index');
        });

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropIndex('contact_submissions_is_read_index');
        });

        Schema::table('schedule_templates', function (Blueprint $table) {
            $table->dropIndex('schedule_templates_active_day_index');
        });
    }
};
