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
            $table->json('completed_tours')->nullable()->after('has_seen_tour');
        });

        // Migrate existing data
        \DB::table('users')->where('has_seen_tour', true)->update([
            'completed_tours' => json_encode(['dashboard' => true]),
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('has_seen_tour');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('has_seen_tour')->default(false)->after('is_admin');
        });

        \DB::table('users')->whereNotNull('completed_tours')->update([
            'has_seen_tour' => true,
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('completed_tours');
        });
    }
};
