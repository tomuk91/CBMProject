<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Auth::user()->vehicles()->latest()->get();
        return view('profile.vehicles', compact('vehicles'));
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
        
        // If this is the first vehicle, make it primary
        if (Auth::user()->vehicles()->count() === 0) {
            $validated['is_primary'] = true;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $disk = config('filesystems.default');
                
                // Store file with public visibility
                $path = $file->store('vehicles', ['disk' => $disk, 'visibility' => 'public']);
                
                if (!$path) {
                    throw new \Exception(__('messages.image_upload_failed'));
                }
                
                $validated['image'] = $path;
            } catch (\Exception $e) {
                \Log::error('Vehicle image upload failed', [
                    'error' => $e->getMessage(),
                    'user_id' => Auth::id(),
                ]);
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', __('messages.image_upload_failed'));
            }
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

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $disk = config('filesystems.default');
                
                // Delete old image if exists
                if ($vehicle->image) {
                    Storage::disk($disk)->delete($vehicle->image);
                }
                
                // Store file with public visibility
                $path = $file->store('vehicles', ['disk' => $disk, 'visibility' => 'public']);
                
                if (!$path) {
                    throw new \Exception(__('messages.image_upload_failed'));
                }
                
                $validated['image'] = $path;
            } catch (\Exception $e) {
                \Log::error('Vehicle image upload failed', [
                    'error' => $e->getMessage(),
                    'vehicle_id' => $vehicle->id,
                    'user_id' => Auth::id(),
                ]);
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', __('messages.image_upload_failed'));
            }
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
