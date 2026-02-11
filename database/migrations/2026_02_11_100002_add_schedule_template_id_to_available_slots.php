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
        Schema::table('available_slots', function (Blueprint $table) {
            $table->foreignId('schedule_template_id')->nullable()->constrained('schedule_templates')->nullOnDelete();
            $table->string('source')->default('manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('available_slots', function (Blueprint $table) {
            $table->dropConstrainedForeignId('schedule_template_id');
            $table->dropColumn('source');
        });
    }
};
