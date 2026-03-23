<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\CarMake;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VehicleController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $vehicles = Auth::user()->vehicles()->latest()->get();
        $carMakes = CarMake::active()->orderBy('name')->get(['id', 'name']);
        return view('profile.vehicles', compact('vehicles', 'carMakes'));
    }

    public function store(StoreVehicleRequest $request)
    {
        // Check if user already has 4 vehicles
        if (Auth::user()->vehicles()->count() >= 4) {
            return redirect()->back()
                ->with('error', __('messages.vehicle_limit_reached'));
        }

        $validated = $request->validated();

        // If this is set as primary, unset all other primary vehicles
        if ($request->boolean('is_primary')) {
            Auth::user()->vehicles()->update(['is_primary' => false]);
        }

        $validated['user_id'] = Auth::id();
        
        // Sanitize free-text fields
        if (isset($validated['notes'])) {
            $validated['notes'] = strip_tags(clean($validated['notes']));
        }

        // If this is the first vehicle, make it primary
        if (Auth::user()->vehicles()->count() === 0) {
            $validated['is_primary'] = true;
        }

        Vehicle::create($validated);

        return redirect()->back()->with('success', __('messages.vehicle_added_successfully'));
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $validated = $request->validated();

        // If this is set as primary, unset all other primary vehicles
        if ($request->boolean('is_primary')) {
            Auth::user()->vehicles()->where('id', '!=', $vehicle->id)->update(['is_primary' => false]);
        }

        // Sanitize free-text fields
        if (isset($validated['notes'])) {
            $validated['notes'] = strip_tags(clean($validated['notes']));
        }

        $vehicle->update($validated);

        return redirect()->back()->with('success', __('messages.vehicle_updated_successfully'));
    }

    public function destroy(Vehicle $vehicle)
    {
        $this->authorize('delete', $vehicle);

        // Only block deletion if there are active (pending/confirmed) appointments
        $activeAppointments = $vehicle->appointments()
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $activePending = $vehicle->pendingAppointments()
            ->where('status', 'pending')
            ->count();

        if ($activeAppointments > 0 || $activePending > 0) {
            return redirect()->back()->with('error', __('messages.vehicle_has_active_appointments'));
        }

        $wasPrimary = $vehicle->is_primary;
        
        // Delete image file if exists
        if ($vehicle->image) {
            Storage::disk(config('filesystems.default'))->delete($vehicle->image);
        }
        
        $vehicle->delete();

        // If this was the primary vehicle, make the first remaining vehicle primary
        if ($wasPrimary) {
            $firstVehicle = Auth::user()->vehicles()->first();
            if ($firstVehicle) {
                $firstVehicle->update(['is_primary' => true]);
            }
        }

        return redirect()->back()->with('success', __('messages.vehicle_deleted_successfully'));
    }

    public function setPrimary(Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        // Unset all other primary vehicles
        Auth::user()->vehicles()->update(['is_primary' => false]);
        
        // Set this vehicle as primary
        $vehicle->update(['is_primary' => true]);

        return redirect()->back()->with('success', __('messages.vehicle_set_as_primary'));
    }
}
