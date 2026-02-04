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
        Schema::table('pending_appointments', function (Blueprint $table) {
            $table->foreignId('available_slot_id')->nullable()->after('id')->constrained('available_slots')->onDelete('set null');
            $table->dropColumn(['requested_date', 'requested_end']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pending_appointments', function (Blueprint $table) {
            $table->dropForeign(['available_slot_id']);
            $table->dropColumn('available_slot_id');
            $table->dateTime('requested_date')->nullable();
            $table->dateTime('requested_end')->nullable();
        });
    }
};
