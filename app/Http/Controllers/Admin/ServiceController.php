<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    public function index()
    {
        $services = config('services.car_services', $this->defaultServices());
        return view('admin.services.index', compact('services'));
    }

    private function defaultServices(): array
    {
        return [
            ['key' => 'oil_change', 'name' => 'Oil Change', 'duration' => 30, 'description' => 'Full oil and filter change'],
            ['key' => 'tire_service', 'name' => 'Tire Service', 'duration' => 45, 'description' => 'Tire rotation, balancing, or replacement'],
            ['key' => 'brake_inspection', 'name' => 'Brake Inspection', 'duration' => 30, 'description' => 'Complete brake system check'],
            ['key' => 'full_service', 'name' => 'Full Service', 'duration' => 120, 'description' => 'Comprehensive vehicle service'],
            ['key' => 'ac_service', 'name' => 'Air Conditioning', 'duration' => 60, 'description' => 'AC system check and regas'],
            ['key' => 'battery_service', 'name' => 'Battery Service', 'duration' => 30, 'description' => 'Battery test and replacement'],
            ['key' => 'diagnostic', 'name' => 'Diagnostic Check', 'duration' => 45, 'description' => 'Computer diagnostic scan'],
            ['key' => 'transmission', 'name' => 'Transmission Service', 'duration' => 90, 'description' => 'Transmission fluid change and check'],
        ];
    }
}
