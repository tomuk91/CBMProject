<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Vehicle;
use App\Mail\AppointmentApproved;
use App\Mail\NewClientAccountCreated;
use App\Enums\AppointmentStatus;
use App\Enums\SlotStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AdminBookingController extends Controller
{
    /**
     * Book a slot for a client (admin booking)
     * Creates a confirmed appointment directly — no pending approval step needed.
     */
    public function bookSlot(Request $request, AvailableSlot $slot)
    {
        if ($slot->status !== SlotStatus::Available) {
            return redirect()->back()
                ->with('error', __('messages.flash_admin_slot_unavailable'));
        }

        $clientType = $request->input('client_type');
        
        return DB::transaction(function () use ($request, $slot, $clientType) {
            $vehicleId = null;
            $vehicleString = null;

            if ($clientType === 'new') {
                // Create new user for new clients
                $request->validate([
                    'new_name' => 'required|string|max:255',
                    'new_email' => 'required|email|unique:users,email',
                    'new_phone' => 'required|string|max:20',
                    'new_vehicle_make' => 'required|string|max:255',
                    'new_vehicle_model' => 'required|string|max:255',
                    'new_vehicle_year' => 'required|integer|min:1900|max:2100',
                    'new_vehicle_plate' => 'nullable|string|max:20',
                    'service' => 'required|string|max:255',
                ]);

                $user = User::create([
                    'name' => $request->new_name,
                    'email' => $request->new_email,
                    'phone' => $request->new_phone,
                    'password' => bcrypt(\Illuminate\Support\Str::random(32)),
                ]);

                $vehicle = Vehicle::create([
                    'user_id' => $user->id,
                    'make' => $request->new_vehicle_make,
                    'model' => $request->new_vehicle_model,
                    'year' => $request->new_vehicle_year,
                    'plate' => $request->new_vehicle_plate,
                ]);

                $vehicleId = $vehicle->id;
                $vehicleString = "{$vehicle->year} {$vehicle->make} {$vehicle->model}" . ($vehicle->plate ? " ({$vehicle->plate})" : "");

                // Generate password reset token and URL
                $token = Password::broker()->createToken($user);
                $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($user->email));

                // Send welcome email with password reset link (queued)
                Mail::to($user->email)->queue(new NewClientAccountCreated($user, $resetUrl));
            } else {
                // Existing client
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'service' => 'required|string|max:255',
                ]);

                $user = User::find($request->user_id);
                
                if ($request->filled('new_vehicle_make') && $request->filled('new_vehicle_model') && $request->filled('new_vehicle_year')) {
                    $vehicle = Vehicle::create([
                        'user_id' => $user->id,
                        'make' => $request->new_vehicle_make,
                        'model' => $request->new_vehicle_model,
                        'year' => $request->new_vehicle_year,
                        'plate' => $request->new_vehicle_plate,
                    ]);
                    $vehicleId = $vehicle->id;
                    $vehicleString = "{$vehicle->year} {$vehicle->make} {$vehicle->model}" . ($vehicle->plate ? " ({$vehicle->plate})" : "");
                } elseif ($request->filled('vehicle_id')) {
                    $vehicleId = $request->vehicle_id;
                    $vehicle = Vehicle::find($vehicleId);
                    if ($vehicle) {
                        $vehicleString = "{$vehicle->year} {$vehicle->make} {$vehicle->model}" . ($vehicle->plate ? " ({$vehicle->plate})" : "");
                    }
                } elseif ($request->filled('vehicle')) {
                    $vehicleString = $request->vehicle;
                }
            }

            // Create confirmed appointment directly (skip pending step for admin bookings)
            $appointment = Appointment::create([
                'user_id' => $user->id,
                'available_slot_id' => $slot->id,
                'vehicle_id' => $vehicleId,
                'name' => $clientType === 'new' ? $request->new_name : $user->name,
                'email' => $clientType === 'new' ? $request->new_email : $user->email,
                'phone' => $clientType === 'new' ? ($request->new_phone ?? 'Not provided') : ($user->phone ?? 'Not provided'),
                'vehicle' => $vehicleString,
                'service' => $request->service,
                'notes' => $request->notes ? strip_tags(clean($request->notes)) : null,
                'admin_notes' => $request->admin_notes ? strip_tags(clean($request->admin_notes)) : null,
                'appointment_date' => $slot->start_time,
                'appointment_end' => $slot->end_time,
                'status' => AppointmentStatus::Confirmed,
                'booked_by_admin' => true,
            ]);

            // Mark slot as booked
            $slot->update(['status' => SlotStatus::Booked]);

            // Log activity
            ActivityLog::log(
                'admin_booked',
                "Admin booked appointment for {$appointment->name} - {$appointment->service}",
                $appointment,
                [
                    'client_type' => $clientType,
                    'appointment_date' => $slot->start_time->toDateTimeString(),
                    'service' => $appointment->service,
                    'admin_user' => auth()->user()?->name,
                ]
            );

            // Send confirmation email to client
            Mail::to($appointment->email)->queue(new AppointmentApproved($appointment));

            return redirect()->route('admin.appointments.calendar')
                ->with('success', "Appointment confirmed directly for {$appointment->name}.");
        });
    }

    /**
     * Get user's vehicles for AJAX
     */
    public function getUserVehicles($userId)
    {
        $vehicles = Vehicle::where('user_id', $userId)->get();
        return response()->json($vehicles);
    }
}
