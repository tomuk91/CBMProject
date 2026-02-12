<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Oil Change',
                'icon' => '🛢️',
                'description' => 'Complete oil change with filter replacement',
                'estimated_duration' => '30-45 min',
                'price_from' => 8000,
                'price_to' => 15000,
                'sort_order' => 1,
            ],
            [
                'name' => 'Brake Service',
                'icon' => '🔧',
                'description' => 'Complete brake inspection and repair',
                'estimated_duration' => '1-2 hrs',
                'price_from' => 15000,
                'price_to' => 45000,
                'sort_order' => 2,
            ],
            [
                'name' => 'Tire Service',
                'icon' => '🔄',
                'description' => 'Tire rotation, balancing, and replacement',
                'estimated_duration' => '30-60 min',
                'price_from' => 5000,
                'price_to' => 20000,
                'sort_order' => 3,
            ],
            [
                'name' => 'General Inspection',
                'icon' => '🔍',
                'description' => 'Full vehicle inspection and diagnostics report',
                'estimated_duration' => '1-2 hrs',
                'price_from' => 10000,
                'price_to' => 25000,
                'sort_order' => 4,
            ],
            [
                'name' => 'Engine Diagnostics',
                'icon' => '💻',
                'description' => 'Computer-based engine analysis and troubleshooting',
                'estimated_duration' => '1-2 hrs',
                'price_from' => 8000,
                'price_to' => 20000,
                'sort_order' => 5,
            ],
            [
                'name' => 'Transmission Service',
                'icon' => '⚙️',
                'description' => 'Transmission fluid change and inspection',
                'estimated_duration' => '2-3 hrs',
                'price_from' => 20000,
                'price_to' => 60000,
                'sort_order' => 6,
            ],
            [
                'name' => 'Air Conditioning',
                'icon' => '❄️',
                'description' => 'A/C system inspection, recharge, and repair',
                'estimated_duration' => '1-2 hrs',
                'price_from' => 10000,
                'price_to' => 35000,
                'sort_order' => 7,
            ],
            [
                'name' => 'Battery Service',
                'icon' => '🔋',
                'description' => 'Battery testing, replacement, and electrical check',
                'estimated_duration' => '30-60 min',
                'price_from' => 5000,
                'price_to' => 30000,
                'sort_order' => 8,
            ],
            [
                'name' => 'Other',
                'icon' => '➕',
                'description' => 'Custom or other service — please describe in notes',
                'estimated_duration' => null,
                'price_from' => null,
                'price_to' => null,
                'sort_order' => 99,
            ],
        ];

        foreach ($services as $service) {
            ServiceType::firstOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
