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
            // Add indexes for commonly queried columns
            $table->index('user_id');
            $table->index('slot_id');
            $table->index('status');
            $table->index('appointment_date');
            $table->index(['user_id', 'status']); // Composite index for user appointments by status
            $table->index(['appointment_date', 'status']); // Composite index for date filtering with status
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
