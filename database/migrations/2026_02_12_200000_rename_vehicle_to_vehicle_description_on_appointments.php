<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Fixes #7: The 'vehicle' text column collides with the vehicle() BelongsTo
     * relationship. Renaming to 'vehicle_description' resolves the shadowing.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->renameColumn('vehicle', 'vehicle_description');
        });

        // Make the column nullable since not all appointments require a vehicle description
        Schema::table('appointments', function (Blueprint $table) {
            $table->string('vehicle_description')->nullable()->change();
        });

        Schema::table('pending_appointments', function (Blueprint $table) {
            if (Schema::hasColumn('pending_appointments', 'vehicle')) {
                $table->renameColumn('vehicle', 'vehicle_description');
            }
        });

        Schema::table('pending_appointments', function (Blueprint $table) {
            if (Schema::hasColumn('pending_appointments', 'vehicle_description')) {
                $table->string('vehicle_description')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->renameColumn('vehicle_description', 'vehicle');
        });

        Schema::table('pending_appointments', function (Blueprint $table) {
            if (Schema::hasColumn('pending_appointments', 'vehicle_description')) {
                $table->renameColumn('vehicle_description', 'vehicle');
            }
        });
    }
};
