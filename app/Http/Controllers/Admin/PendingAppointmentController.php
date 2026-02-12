<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Mail\AppointmentStatusChanged;
use App\Mail\AppointmentRejected;
use App\Enums\SlotStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PendingAppointmentController extends Controller
{
    /**
     * Display pending appointments for approval
     */
    public function pending(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = PendingAppointment::with(['user', 'availableSlot', 'vehicleDetails'])
            ->where('status', 'pending');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('vehicle_description', 'like', "%{$search}%");
            });
        }

        // Service filter
        if ($request->filled('service')) {
            $query->where('service', $request->service);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereHas('availableSlot', function($q) use ($request) {
                $q->where('start_time', '>=', $request->date_from . ' 00:00:00');
            });
        }
        if ($request->filled('date_to')) {
            $query->whereHas('availableSlot', function($q) use ($request) {
                $q->where('start_time', '<=', $request->date_to . ' 23:59:59');
            });
        }

        // Sorting
        $sort = $request->get('sort', 'created_at');
        $allowedSorts = ['created_at', 'name', 'date', 'service', 'status'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        $direction = $request->get('direction', 'desc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'desc';
        
        if ($sort === 'name') {
            $query->orderBy('name', $direction);
        } elseif ($sort === 'date') {
            $query->whereHas('availableSlot')->with(['availableSlot' => function($q) use ($direction) {
                $q->orderBy('start_time', $direction);
            }]);
        } else {
            $query->orderBy('created_at', $direction);
        }

        $pendingAppointments = $query->paginate(20)->appends($request->except('page'));
        
        // Get unique services for filter dropdown
        $services = PendingAppointment::where('status', 'pending')
            ->distinct()
            ->pluck('service')
            ->filter()
            ->sort()
            ->values();

        // Get cancellation requests with eager loading to prevent N+1 queries
        $cancellationRequests = Appointment::with(['user', 'vehicle'])
            ->where('cancellation_requested', true)
            ->where('status', '!=', 'cancelled')
            ->orderBy('cancellation_requested_at', 'desc')
            ->get();

        return view('admin.appointments.pending', compact('pendingAppointments', 'services', 'cancellationRequests'));
    }

    /**
     * Approve a pending appointment and add to calendar
     */
    public function approve(Request $request, PendingAppointment $pendingAppointment)
    {
        try {
            DB::beginTransaction();

            $slot = $pendingAppointment->availableSlot;

            // Determine vehicle information
            $vehicleInfo = $pendingAppointment->vehicle;
            if ($pendingAppointment->vehicle_id && $pendingAppointment->vehicleDetails) {
                $vehicle = $pendingAppointment->vehicleDetails;
                $vehicleInfo = "{$vehicle->year} {$vehicle->make} {$vehicle->model} ({$vehicle->plate})";
            }

            // Create the confirmed appointment
            $sanitizedAdminNotes = $request->admin_notes ? strip_tags(clean($request->admin_notes)) : null;

            $appointment = Appointment::create([
                'user_id' => $pendingAppointment->user_id,
                'available_slot_id' => $slot->id,
                'vehicle_id' => $pendingAppointment->vehicle_id,
                'name' => $pendingAppointment->name,
                'email' => $pendingAppointment->email,
                'phone' => $pendingAppointment->phone,
                'vehicle_description' => $vehicleInfo,
                'service' => $pendingAppointment->service,
                'notes' => $pendingAppointment->notes ? strip_tags(clean($pendingAppointment->notes)) : null,
                'admin_notes' => $sanitizedAdminNotes,
                'appointment_date' => $slot->start_time,
                'appointment_end' => $slot->end_time,
                'status' => 'confirmed',
            ]);

            // Update slot status to booked
            $slot->update(['status' => SlotStatus::Booked]);

            // Update pending appointment status
            $pendingAppointment->update([
                'status' => 'approved',
                'admin_notes' => $sanitizedAdminNotes,
            ]);

            // Log activity
            ActivityLog::log(
                'approved',
                "Approved appointment for {$pendingAppointment->name} - {$pendingAppointment->service}",
                $appointment
            );

            // Send approval email (queued for better performance)
            Mail::to($appointment->email)->queue(new AppointmentStatusChanged($appointment, 'pending'));

            DB::commit();

            // Bust dashboard cache
            Cache::forget('dashboard_pending_count');
            Cache::forget('dashboard_booked_slots');
            Cache::forget('dashboard_available_slots');
            Cache::forget('dashboard_today_count_' . today()->toDateString());

            return redirect()->back()
                ->with('success', __('messages.flash_appointment_approved'));
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to approve appointment: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                ->with('error', __('messages.flash_approve_failed'));
        }
    }

    /**
     * Reject a pending appointment
     */
    public function reject(Request $request, PendingAppointment $pendingAppointment)
    {
        // Make slot available again
        if ($pendingAppointment->availableSlot) {
            $pendingAppointment->availableSlot->update(['status' => SlotStatus::Available]);
        }

        $pendingAppointment->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes ? strip_tags(clean($request->admin_notes)) : null,
        ]);

        // Log activity
        ActivityLog::log(
            'rejected',
            "Rejected appointment for {$pendingAppointment->name} - {$pendingAppointment->service}",
            $pendingAppointment,
            ['reason' => $request->admin_notes]
        );

        // Send rejection email
        Mail::to($pendingAppointment->email)->queue(new AppointmentRejected($pendingAppointment, $request->admin_notes ?? ''));

        // Bust dashboard cache
        Cache::forget('dashboard_pending_count');
        Cache::forget('dashboard_available_slots');

        return redirect()->back()
            ->with('success', __('messages.flash_appointment_rejected'));
    }

    /**
     * Bulk approve pending appointments
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'appointment_ids' => 'required|string',
        ]);

        $appointmentIds = explode(',', $request->appointment_ids);
        $approvedCount = 0;
        $failedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($appointmentIds as $id) {
                $pendingAppointment = PendingAppointment::find($id);

                if ($pendingAppointment && $pendingAppointment->status === 'pending') {
                    try {
                        $slot = $pendingAppointment->availableSlot;

                        // Determine vehicle information
                        $vehicleInfo = $pendingAppointment->vehicle;
                        if ($pendingAppointment->vehicle_id && $pendingAppointment->vehicleDetails) {
                            $vehicle = $pendingAppointment->vehicleDetails;
                            $vehicleInfo = "{$vehicle->year} {$vehicle->make} {$vehicle->model} ({$vehicle->plate})";
                        }

                        // Create the confirmed appointment
                        $appointment = Appointment::create([
                            'user_id' => $pendingAppointment->user_id,
                            'available_slot_id' => $slot->id,
                            'vehicle_id' => $pendingAppointment->vehicle_id,
                            'name' => $pendingAppointment->name,
                            'email' => $pendingAppointment->email,
                            'phone' => $pendingAppointment->phone,
                            'vehicle_description' => $vehicleInfo,
                            'service' => $pendingAppointment->service,
                            'notes' => $pendingAppointment->notes ? strip_tags(clean($pendingAppointment->notes)) : null,
                            'admin_notes' => 'Bulk approved by admin',
                            'appointment_date' => $slot->start_time,
                            'appointment_end' => $slot->end_time,
                            'status' => 'confirmed',
                        ]);

                        // Update slot status to booked
                        $slot->update(['status' => SlotStatus::Booked]);

                        // Update pending appointment status
                        $pendingAppointment->update([
                            'status' => 'approved',
                            'admin_notes' => 'Bulk approved by admin',
                        ]);

                        // Log activity
                        ActivityLog::log(
                            'approved',
                            "Bulk approved appointment for {$pendingAppointment->name} - {$pendingAppointment->service}",
                            $appointment
                        );

                        // Send approval email
                        Mail::to($appointment->email)->queue(new AppointmentStatusChanged($appointment, 'pending'));

                        $approvedCount++;
                    } catch (\Exception $e) {
                        $failedCount++;
                    }
                }
            }

            DB::commit();

            return redirect()->back()
                ->with('success', __('messages.bulk_approve_success', ['count' => $approvedCount]));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('messages.flash_bulk_failed'));
        }
    }

    /**
     * Bulk reject pending appointments
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'appointment_ids' => 'required|string',
        ]);

        $appointmentIds = explode(',', $request->appointment_ids);
        $rejectedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($appointmentIds as $id) {
                $pendingAppointment = PendingAppointment::find($id);
                
                if ($pendingAppointment && $pendingAppointment->status === 'pending') {
                    // Make slot available again
                    if ($pendingAppointment->availableSlot) {
                        $pendingAppointment->availableSlot->update(['status' => SlotStatus::Available]);
                    }

                    $pendingAppointment->update([
                        'status' => 'rejected',
                        'admin_notes' => 'Bulk rejected by admin',
                    ]);

                    // Log activity
                    ActivityLog::log(
                        'rejected',
                        "Bulk rejected appointment for {$pendingAppointment->name} - {$pendingAppointment->service}",
                        $pendingAppointment,
                        ['reason' => 'Bulk rejection']
                    );

                    // Send rejection email
                    $tempAppointment = (object) [
                        'name' => $pendingAppointment->name,
                        'email' => $pendingAppointment->email,
                        'phone' => $pendingAppointment->phone,
                        'service' => $pendingAppointment->service,
                        'notes' => $pendingAppointment->notes,
                        'appointment_date' => $pendingAppointment->availableSlot->start_time ?? now(),
                        'status' => 'rejected',
                    ];
                    Mail::to($pendingAppointment->email)->queue(new AppointmentStatusChanged($tempAppointment, 'pending'));
                    
                    $rejectedCount++;
                }
            }

            DB::commit();

            return redirect()->back()
                ->with('success', __('messages.flash_bulk_reject_success', ['count' => $rejectedCount]));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', __('messages.flash_bulk_failed'));
        }
    }
}
