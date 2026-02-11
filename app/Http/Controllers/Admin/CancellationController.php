<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Mail\AppointmentStatusChanged;
use App\Enums\AppointmentStatus;
use App\Enums\SlotStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CancellationController extends Controller
{
    /**
     * Approve a cancellation request
     */
    public function approveCancellation(Request $request, Appointment $appointment)
    {
        if (!$appointment->cancellation_requested) {
            return redirect()->back()->with('error', __('messages.no_cancellation_request'));
        }

        try {
            DB::beginTransaction();

            // Cancel the appointment
            $appointment->update([
                'status' => AppointmentStatus::Cancelled,
                'cancellation_requested' => false,
            ]);

            // If there's an associated slot, make it available again
            $slot = AvailableSlot::where('start_time', $appointment->appointment_date)
                ->where('end_time', $appointment->appointment_end)
                ->first();
            
            if ($slot) {
                $slot->update(['status' => SlotStatus::Available]);
            }

            DB::commit();

            // Log the cancellation approval action
            ActivityLog::log(
                'cancellation_approved',
                "Approved cancellation request for {$appointment->name} - {$appointment->service}",
                $appointment,
                [
                    'appointment_date' => $appointment->appointment_date->toDateTimeString(),
                    'cancellation_reason' => $appointment->cancellation_reason,
                    'admin_user' => auth()->user()->name,
                ]
            );

            // Send email notification to user about approved cancellation
            try {
                Mail::to($appointment->email)->queue(new AppointmentStatusChanged($appointment, 'confirmed'));
            } catch (\Exception $e) {
                \Log::error('Failed to send cancellation approval email: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', __('messages.cancellation_approved'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error approving cancellation: ' . $e->getMessage());
        }
    }

    /**
     * Deny a cancellation request
     */
    public function denyCancellation(Request $request, Appointment $appointment)
    {
        if (!$appointment->cancellation_requested) {
            return redirect()->back()->with('error', __('messages.no_cancellation_request'));
        }

        $appointment->update([
            'cancellation_requested' => false,
            'cancellation_requested_at' => null,
            'cancellation_reason' => null,
        ]);

        // Log the cancellation denial action
        ActivityLog::log(
            'cancellation_denied',
            "Denied cancellation request for {$appointment->name} - {$appointment->service}",
            $appointment,
            [
                'appointment_date' => $appointment->appointment_date->toDateTimeString(),
                'original_reason' => $appointment->cancellation_reason,
                'admin_user' => auth()->user()->name,
            ]
        );

        // Send email notification to user - status stays confirmed since request was denied
        try {
            Mail::to($appointment->email)->queue(new AppointmentStatusChanged($appointment, $appointment->status));
        } catch (\Exception $e) {
            \Log::error('Failed to send cancellation denial email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', __('messages.cancellation_denied'));
    }
}
