<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Enums\AppointmentStatus;
use App\Enums\SlotStatus;
use Illuminate\Http\Request;
use App\Mail\AppointmentCompleted;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $pendingCount = Cache::remember('dashboard_pending_count', 60, function () {
            $count = PendingAppointment::where('status', 'pending')->count();
            $count += Appointment::where('cancellation_requested', true)
                ->where('status', '!=', 'cancelled')
                ->count();
            return $count;
        });

        $todayAppointmentsCount = Cache::remember('dashboard_today_count_' . today()->toDateString(), 120, function () {
            return Appointment::where('status', 'confirmed')
                ->whereDate('appointment_date', today())
                ->count();
        });

        $upcomingAppointments = Appointment::with(['user', 'vehicle'])
            ->where('status', 'confirmed')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->take(5)
            ->get();

        $availableSlotsCount = Cache::remember('dashboard_available_slots', 120, function () {
            return AvailableSlot::where('status', 'available')
                ->where('start_time', '>=', now())
                ->count();
        });

        $bookedSlotsCount = Cache::remember('dashboard_booked_slots', 120, function () {
            return Appointment::where('status', 'confirmed')
                ->where('appointment_date', '>=', now())
                ->count();
        });

        return view('admin.appointments.dashboard', compact('pendingCount', 'todayAppointmentsCount', 'upcomingAppointments', 'availableSlotsCount', 'bookedSlotsCount'));
    }

    /**
     * Display admin calendar
     */
    public function index(Request $request)
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = Appointment::with(['user', 'vehicle']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('service', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Service filter
        if ($request->filled('service') && $request->service !== 'all') {
            $query->where('service', $request->service);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('appointment_date', '>=', $request->date_from . ' 00:00:00');
        }
        if ($request->filled('date_to')) {
            $query->where('appointment_date', '<=', $request->date_to . ' 23:59:59');
        }

        // Sorting
        $sort = $request->get('sort', 'appointment_date');
        $allowedSorts = ['appointment_date', 'created_at', 'name', 'service', 'status'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'appointment_date';
        }
        $direction = $request->get('direction', 'asc');
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';
        $query->orderBy($sort, $direction);

        $appointments = $query->get();

        // Get unique services and statuses for filter dropdowns
        $services = Appointment::distinct()->pluck('service')->filter()->sort()->values();
        $statuses = ['pending', 'approved', 'confirmed', 'completed', 'cancelled', 'no-show'];

        return view('admin.appointments.calendar', compact('appointments', 'services', 'statuses'));
    }

    /**
     * Get appointments as JSON for calendar view
     */
    public function getAppointments(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = Appointment::with(['user:id,name,email', 'vehicle:id,make,model,year,plate'])
            ->select('id', 'user_id', 'vehicle_id', 'name', 'email', 'phone', 'vehicle_description', 'service', 'notes', 'appointment_date', 'appointment_end', 'status', 'cancellation_requested')
            ->whereBetween('appointment_date', [$start, $end]);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('service', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Apply service filter
        if ($request->filled('service') && $request->service !== 'all') {
            $query->where('service', $request->service);
        }

        $appointments = $query->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->name . ' - ' . $appointment->service,
                    'start' => $appointment->appointment_date->toIso8601String(),
                    'end' => $appointment->appointment_end->toIso8601String(),
                    'backgroundColor' => $this->getStatusColor($appointment->status),
                    'editable' => !in_array($appointment->status, [AppointmentStatus::Completed, AppointmentStatus::Cancelled]), // Prevent dragging completed/cancelled appointments
                    'extendedProps' => [
                        'customer' => $appointment->name,
                        'email' => $appointment->email,
                        'phone' => $appointment->phone,
                        'vehicle' => $appointment->vehicle_description,
                        'service' => $appointment->service,
                        'notes' => $appointment->notes,
                        'admin_notes' => $appointment->admin_notes,
                        'status' => $appointment->status,
                    ],
                ];
            });

        return response()->json($appointments);
    }

    /**
     * Update appointment status
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:confirmed,completed,cancelled',
        ]);

        $appointment->update([
            'status' => $request->status,
        ]);

        return redirect()->back()
            ->with('success', __('messages.flash_status_updated'));
    }

    /**
     * Update appointment time (for drag and drop)
     */
    public function updateTime(Request $request, Appointment $appointment)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_end' => 'required|date|after:appointment_date',
        ]);

        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_end' => $request->appointment_end,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment time updated successfully.',
        ]);
    }

    /**
     * Mark appointment as completed
     */
    public function complete(Appointment $appointment)
    {
        $appointment->update([
            'status' => AppointmentStatus::Completed,
        ]);

        // Log activity
        ActivityLog::log(
            'completed',
            "Marked appointment as completed for {$appointment->name} - {$appointment->service}",
            $appointment
        );

        // Send completion follow-up email
        Mail::to($appointment->email)->queue(new AppointmentCompleted($appointment));

        // For MOT appointments, reset reminder_sent_at so the yearly reminder can be scheduled
        // This allows the scheduled command to send a reminder 1 year after completion
        if ($appointment->service === 'MOT Service') {
            $appointment->update(['reminder_sent_at' => null]);
            
            // Update the user's MOT next due date
            if ($appointment->user_id) {
                $appointment->user->updateMOTNextDue();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Appointment marked as completed.',
        ]);
    }

    /**
     * Delete an appointment
     */
    public function destroy(Appointment $appointment)
    {
        try {
            // Find the associated slot via FK (fall back to time match for legacy data)
            $slot = $appointment->available_slot_id
                ? AvailableSlot::find($appointment->available_slot_id)
                : AvailableSlot::where('start_time', $appointment->appointment_date)
                    ->where('end_time', $appointment->appointment_end)
                    ->first();

            // Log activity before deletion
            ActivityLog::log(
                'cancelled',
                "Cancelled appointment for {$appointment->name} - {$appointment->service}",
                $appointment,
                ['reason' => request()->input('reason', 'No reason provided')]
            );

            // Send cancellation email to customer (queued)
            \Illuminate\Support\Facades\Mail::to($appointment->email)
                ->queue(new \App\Mail\AppointmentCancelled($appointment, request()->input('reason', '')));
            
            // Delete the appointment
            $appointment->delete();

            // Update slot status back to available if found
            if ($slot) {
                $slot->update(['status' => SlotStatus::Available]);
            }

            // Bust dashboard cache
            Cache::forget('dashboard_pending_count');
            Cache::forget('dashboard_booked_slots');
            Cache::forget('dashboard_available_slots');
            Cache::forget('dashboard_today_count_' . today()->toDateString());

            // Check if request expects JSON (AJAX request)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment cancelled successfully. Customer has been notified by email.'
                ]);
            }

            return redirect()->back()
                ->with('success', __('messages.flash_cancelled_success'));
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel appointment: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', __('messages.flash_cancel_failed'));
        }
    }

    /**
     * Cleanup old available slots that haven't been booked
     */
    public function cleanupOldSlots()
    {
        $deletedCount = AvailableSlot::where('status', 'available')
            ->where('start_time', '<', now())
            ->delete();

        // Bust dashboard cache
        Cache::forget('dashboard_available_slots');

        return response()->json([
            'success' => true,
            'deleted' => $deletedCount,
            'message' => "{$deletedCount} old slot(s) removed.",
        ]);
    }

    /**
     * Display activity log
     */
    public function activityLog(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        // Filter by action type if specified
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by date range if specified
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(50);
        
        return view('admin.appointments.activity-log', compact('activities'));
    }

    /**
     * Get color based on appointment status
     */
    private function getStatusColor($status)
    {
        $value = $status instanceof AppointmentStatus ? $status->value : $status;
        return match($value) {
            'confirmed' => '#3b82f6', // blue
            'completed' => '#22c55e', // green
            'cancelled' => '#ef4444', // red
            default => '#6b7280', // gray
        };
    }

    /**
     * Export appointments as CSV
     */
    /**
     * Export appointments as CSV
     */
    public function exportAppointments(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Appointment::with(['user', 'vehicle']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $appointments = $query->orderBy('appointment_date', 'desc')->get();
        
        $filename = 'appointments_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($appointments) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Customer Name',
                'Email',
                'Phone',
                'Vehicle',
                'Service',
                'Date',
                'Status',
                'Notes',
                'Created At'
            ]);
            
            // Add data rows
            foreach ($appointments as $appointment) {
                // Format vehicle info as a readable string
                $vehicleInfo = '';
                if ($appointment->vehicle) {
                    $vehicle = $appointment->vehicle;
                    $vehicleInfo = trim(sprintf(
                        '%s %s %s (%s)',
                        $vehicle->year ?? '',
                        $vehicle->make ?? '',
                        $vehicle->model ?? '',
                        $vehicle->plate ?? ''
                    ));
                } elseif ($appointment->vehicle_description) {
                    $vehicleInfo = $appointment->vehicle_description;
                }
                
                // Format status as string value
                $statusValue = $appointment->status instanceof \App\Enums\AppointmentStatus 
                    ? $appointment->status->value 
                    : (string) $appointment->status;
                
                fputcsv($file, [
                    $appointment->id,
                    $appointment->name,
                    $appointment->email,
                    $appointment->phone,
                    $vehicleInfo,
                    $appointment->service,
                    $appointment->appointment_date?->format('Y-m-d H:i') ?? '',
                    $statusValue,
                    $appointment->notes,
                    $appointment->created_at?->format('Y-m-d H:i') ?? '',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export available slots as CSV
     */
    public function exportSlots(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = AvailableSlot::query();
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $slots = $query->orderBy('start_time', 'desc')->get();
        
        $filename = 'slots_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($slots) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Start Time',
                'End Time',
                'Duration (min)',
                'Status',
                'Created At'
            ]);
            
            // Add data rows
            foreach ($slots as $slot) {
                // Format status as string value
                $statusValue = $slot->status instanceof \App\Enums\SlotStatus 
                    ? $slot->status->value 
                    : (string) $slot->status;
                
                fputcsv($file, [
                    $slot->id,
                    $slot->start_time?->format('Y-m-d H:i') ?? '',
                    $slot->end_time?->format('Y-m-d H:i') ?? '',
                    $slot->start_time && $slot->end_time ? $slot->start_time->diffInMinutes($slot->end_time) : '',
                    $statusValue,
                    $slot->created_at?->format('Y-m-d H:i') ?? '',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Send bulk emails to customers
     */
    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'recipient_type' => 'required|in:all,upcoming,past',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $query = Appointment::with('user');
        
        if ($request->recipient_type === 'upcoming') {
            $query->where('status', 'confirmed')
                  ->where('appointment_date', '>=', now());
        } elseif ($request->recipient_type === 'past') {
            $query->where('status', 'completed')
                  ->where('appointment_date', '<', now());
        }
        
        $appointments = $query->get();
        $sentCount = 0;
        
        foreach ($appointments as $appointment) {
            try {
                Mail::raw($request->message, function($message) use ($appointment, $request) {
                    $message->to($appointment->email)
                           ->subject($request->subject);
                });
                $sentCount++;
            } catch (\Exception $e) {
                // Log error but continue
                \Log::error('Failed to send bulk email to ' . $appointment->email . ': ' . $e->getMessage());
            }
        }
        
        return redirect()->back()->with('success', "Successfully sent {$sentCount} emails.");
    }

    /**
     * Print daily schedule
     */
    public function printSchedule(Request $request)
    {
        $date = $request->get('date', today()->toDateString());

        $appointments = Appointment::with(['user', 'vehicle'])
            ->whereDate('appointment_date', $date)
            ->whereIn('status', ['confirmed', 'pending'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('admin.appointments.print-schedule', compact('appointments', 'date'));
    }

    /**
     * Notification center
     */
    public function notifications()
    {
        $notifications = collect();

        // Pending appointments
        $pending = PendingAppointment::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn($p) => [
                'type' => 'pending',
                'message' => __('messages.notif_new_booking', ['name' => $p->name, 'service' => $p->service]),
                'time' => $p->created_at,
                'link' => route('admin.appointments.pending'),
            ]);

        // Cancellation requests
        $cancellations = Appointment::where('cancellation_requested', true)
            ->where('status', '!=', 'cancelled')
            ->orderBy('cancellation_requested_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn($a) => [
                'type' => 'cancellation',
                'message' => __('messages.notif_cancel_request', ['name' => $a->name]),
                'time' => $a->cancellation_requested_at,
                'link' => route('admin.appointments.pending'),
            ]);

        // Recent activity
        $recentActivity = ActivityLog::orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(fn($a) => [
                'type' => 'activity',
                'message' => $a->description,
                'time' => $a->created_at,
                'link' => route('admin.appointments.activityLog'),
            ]);

        $notifications = $pending->concat($cancellations)->concat($recentActivity)
            ->sortByDesc('time')
            ->take(20)
            ->values();

        return view('admin.notifications.index', compact('notifications'));
    }
}
