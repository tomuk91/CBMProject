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
        Schema::table('users', function (Blueprint $table) {
            $table->string('vehicle_fuel_type')->nullable()->after('vehicle_notes');
            $table->string('vehicle_transmission')->nullable()->after('vehicle_fuel_type');
            $table->string('vehicle_engine_size')->nullable()->after('vehicle_transmission');
            $table->integer('vehicle_mileage')->nullable()->after('vehicle_engine_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['vehicle_fuel_type', 'vehicle_transmission', 'vehicle_engine_size', 'vehicle_mileage']);
        });
    }
};
