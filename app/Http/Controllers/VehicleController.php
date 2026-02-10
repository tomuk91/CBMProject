<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Auth::user()->vehicles()->latest()->get();
        return view('profile.vehicles', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'color' => 'nullable|string|max:255',
            'plate' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'mileage' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_primary' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'image.image' => 'The file must be an image (JPEG, PNG, JPG, or GIF).',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);

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
                
                \Log::info('Image upload attempt', [
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'original_name' => $file->getClientOriginalName(),
                    'disk' => $disk,
                    'r2_config' => [
                        'bucket' => config('filesystems.disks.r2.bucket'),
                        'endpoint' => config('filesystems.disks.r2.endpoint'),
                        'region' => config('filesystems.disks.r2.region'),
                    ]
                ]);
                
                $path = $file->store('vehicles', $disk);
                
                if (!$path) {
                    throw new \Exception('Failed to store file. Path returned: ' . var_export($path, true));
                }
                
                $validated['image'] = $path;
                
                \Log::info('Image upload successful', [
                    'path' => $path,
                    'disk' => $disk,
                    'url' => Storage::disk($disk)->url($path)
                ]);
            } catch (\Exception $e) {
                \Log::error('Image upload error', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                    'disk' => $disk ?? 'unknown',
                ]);
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        Vehicle::create($validated);

        return redirect()->back()->with('success', __('messages.vehicle_added_successfully'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        // Ensure the vehicle belongs to the authenticated user
        if ($vehicle->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|string|max:4',
            'color' => 'nullable|string|max:255',
            'plate' => 'nullable|string|max:255',
            'fuel_type' => 'nullable|string|max:255',
            'transmission' => 'nullable|string|max:255',
            'engine_size' => 'nullable|string|max:255',
            'mileage' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'is_primary' => 'sometimes|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // If this is set as primary, unset all other primary vehicles
        if ($request->boolean('is_primary')) {
            Auth::user()->vehicles()->where('id', '!=', $vehicle->id)->update(['is_primary' => false]);
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                $disk = config('filesystems.default');
                
                \Log::info('Image upload attempt (update)', [
                    'vehicle_id' => $vehicle->id,
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'disk' => $disk,
                ]);
                
                // Delete old image if exists
                if ($vehicle->image) {
                    Storage::disk($disk)->delete($vehicle->image);
                }
                
                $path = $file->store('vehicles', $disk);
                
                if (!$path) {
                    throw new \Exception('Failed to store file. Path returned: ' . var_export($path, true));
                }
                
                $validated['image'] = $path;
                
                \Log::info('Image upload successful (update)', [
                    'path' => $path,
                    'url' => Storage::disk($disk)->url($path)
                ]);
            } catch (\Exception $e) {
                \Log::error('Image upload error (update)', [
                    'message' => $e->getMessage(),
                    'vehicle_id' => $vehicle->id,
                ]);
                
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Failed to upload image: ' . $e->getMessage());
            }
        }

        $vehicle->update($validated);

        return redirect()->back()->with('success', __('messages.vehicle_updated_successfully'));
    }

    public function destroy(Vehicle $vehicle)
    {
        // Ensure the vehicle belongs to the authenticated user
        if ($vehicle->user_id !== Auth::id()) {
            abort(403);
        }

        // Don't allow deletion if there are appointments linked to this vehicle
        if ($vehicle->appointments()->count() > 0) {
            return redirect()->back()->with('error', __('messages.vehicle_has_appointments'));
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
        // Ensure the vehicle belongs to the authenticated user
        if ($vehicle->user_id !== Auth::id()) {
            abort(403);
        }

        // Unset all other primary vehicles
        Auth::user()->vehicles()->update(['is_primary' => false]);
        
        // Set this vehicle as primary
        $vehicle->update(['is_primary' => true]);

        return redirect()->back()->with('success', __('messages.vehicle_set_as_primary'));
    }
}
