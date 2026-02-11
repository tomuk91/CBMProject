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
            $table->unsignedBigInteger('available_slot_id')->nullable()->after('user_id');
            $table->foreign('available_slot_id')->references('id')->on('available_slots')->nullOnDelete();
            $table->index('available_slot_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['available_slot_id']);
            $table->dropIndex(['available_slot_id']);
            $table->dropColumn('available_slot_id');
        });
    }
};
