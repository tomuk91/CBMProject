<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Vehicle;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate existing vehicle data from users table to vehicles table
        User::whereNotNull('vehicle_make')
            ->orWhereNotNull('vehicle_model')
            ->orWhereNotNull('vehicle_year')
            ->get()
            ->each(function ($user) {
                // Only create if user has at least make or model
                if ($user->vehicle_make || $user->vehicle_model) {
                    Vehicle::create([
                        'user_id' => $user->id,
                        'make' => $user->vehicle_make,
                        'model' => $user->vehicle_model,
                        'year' => $user->vehicle_year,
                        'color' => $user->vehicle_color,
                        'plate' => $user->vehicle_plate,
                        'notes' => $user->vehicle_notes,
                        'is_primary' => true, // Set as primary since it's their only vehicle
                    ]);
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove all vehicles that were migrated (optional - be careful with this)
        // Vehicle::truncate();
    }
};
