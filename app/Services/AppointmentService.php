<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Mail\AppointmentApproved;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentService
{
    /**
     * Approve a pending appointment
     */
    public function approvePendingAppointment(PendingAppointment $pendingAppointment, ?string $adminNotes = null): Appointment
    {
        return DB::transaction(function () use ($pendingAppointment, $adminNotes) {
            $slot = $pendingAppointment->availableSlot;

            if (!$slot || $slot->status !== 'available') {
                throw new \Exception('Slot is no longer available');
            }

            // Determine vehicle information
            $vehicleInfo = $pendingAppointment->vehicle;
            if ($pendingAppointment->vehicleDetails) {
                $vehicle = $pendingAppointment->vehicleDetails;
                $vehicleInfo = "{$vehicle->year} {$vehicle->make} {$vehicle->model} ({$vehicle->plate})";
            }

            // Create confirmed appointment
            $appointment = Appointment::create([
                'user_id' => $pendingAppointment->user_id,
                'vehicle_id' => $pendingAppointment->vehicle_id,
                'name' => $pendingAppointment->name,
                'email' => $pendingAppointment->email,
                'phone' => $pendingAppointment->phone,
                'vehicle' => $vehicleInfo,
                'service' => $pendingAppointment->service,
                'notes' => clean($pendingAppointment->notes), // Sanitize notes
                'admin_notes' => $adminNotes,
                'appointment_date' => $slot->start_time,
                'appointment_end' => $slot->end_time,
                'status' => 'confirmed',
            ]);

            // Update slot and pending appointment
            $slot->update(['status' => 'booked']);
            $pendingAppointment->update([
                'status' => 'approved',
                'admin_notes' => $adminNotes,
            ]);

            // Log activity
            ActivityLog::log(
                'approved',
                "Approved appointment for {$pendingAppointment->name} - {$pendingAppointment->service}",
                $appointment
            );

            // Queue approval email
            Mail::to($appointment->email)->queue(new AppointmentApproved($appointment));

            return $appointment;
        });
    }

    /**
     * Cancel an appointment and free up the slot
     */
    public function cancelAppointment(Appointment $appointment, ?string $reason = null): void
    {
        DB::transaction(function () use ($appointment, $reason) {
            // Find and free the slot
            $slot = AvailableSlot::where('start_time', $appointment->appointment_date)
                ->where('end_time', $appointment->appointment_end)
                ->first();

            if ($slot) {
                $slot->update(['status' => 'available']);
            }

            // Log cancellation
            ActivityLog::log(
                'cancelled',
                "Cancelled appointment for {$appointment->name} - {$appointment->service}",
                $appointment,
                [
                    'reason' => $reason ?? 'No reason provided',
                    'appointment_date' => $appointment->appointment_date->toDateTimeString(),
                    'service' => $appointment->service,
                    'admin_user' => auth()->user()?->name,
                ]
            );

            // Soft delete the appointment
            $appointment->delete();
        });
    }

    /**
     * Get upcoming appointments for reminders
     */
    public function getAppointmentsForReminders(int $hoursAhead = 24): \Illuminate\Database\Eloquent\Collection
    {
        $targetTime = now()->addHours($hoursAhead);
        
        return Appointment::with(['user'])
            ->where('status', 'confirmed')
            ->whereBetween('appointment_date', [
                $targetTime->copy()->subMinutes(30),
                $targetTime->copy()->addMinutes(30)
            ])
            ->get();
    }
}
