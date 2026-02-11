<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Models\BlockedDate;
use App\Models\User;
use App\Mail\AppointmentStatusChanged;
use App\Mail\CancellationRequested;
use App\Mail\NewAppointmentAdmin;
use App\Mail\NewClientAccountCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $pendingCount = PendingAppointment::where('status', 'pending')->count();
        
        // Add cancellation requests to pending count
        $cancellationRequestsCount = Appointment::where('cancellation_requested', true)
            ->where('status', '!=', 'cancelled')
            ->count();
        
        $pendingCount += $cancellationRequestsCount;
        
        // Get today's appointments count
        $todayAppointmentsCount = Appointment::where('status', 'confirmed')
            ->whereDate('appointment_date', today())
            ->count();
        
        $upcomingAppointments = Appointment::with(['user', 'vehicle'])
            ->where('status', 'confirmed')
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->take(5)
            ->get();
        $availableSlotsCount = AvailableSlot::where('status', 'available')
            ->where('start_time', '>=', now())
            ->count();
        $bookedSlotsCount = Appointment::where('status', 'confirmed')
            ->where('appointment_date', '>=', now())
            ->count();

        return view('admin.appointments.dashboard', compact('pendingCount', 'todayAppointmentsCount', 'upcomingAppointments', 'availableSlotsCount', 'bookedSlotsCount'));
    }

    /**
     * Display admin calendar
     */
    public function index(Request $request)
    {
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
        $direction = $request->get('direction', 'asc');
        $query->orderBy($sort, $direction);

        $appointments = $query->get();

        // Get unique services and statuses for filter dropdowns
        $services = Appointment::distinct()->pluck('service')->filter()->sort()->values();
        $statuses = ['pending', 'approved', 'confirmed', 'completed', 'cancelled', 'no-show'];

        return view('admin.appointments.calendar', compact('appointments', 'services', 'statuses'));
    }

    /**
     * Display pending appointments for approval
     */
    public function pending(Request $request)
    {
        $query = PendingAppointment::with(['user', 'availableSlot', 'vehicleDetails'])
            ->where('status', 'pending');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('vehicle', 'like', "%{$search}%");
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
        $direction = $request->get('direction', 'desc');
        
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
            $appointment = Appointment::create([
                'user_id' => $pendingAppointment->user_id,
                'vehicle_id' => $pendingAppointment->vehicle_id,
                'name' => $pendingAppointment->name,
                'email' => $pendingAppointment->email,
                'phone' => $pendingAppointment->phone,
                'vehicle' => $vehicleInfo,
                'service' => $pendingAppointment->service,
                'notes' => $pendingAppointment->notes,
                'admin_notes' => $request->admin_notes,
                'appointment_date' => $slot->start_time,
                'appointment_end' => $slot->end_time,
                'status' => 'confirmed',
            ]);

            // Update slot status to booked
            $slot->update(['status' => 'booked']);

            // Update pending appointment status
            $pendingAppointment->update([
                'status' => 'approved',
                'admin_notes' => $request->admin_notes,
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

            return redirect()->back()
                ->with('success', 'Appointment approved and added to calendar.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to approve appointment: ' . $e->getMessage());
        }
    }

    /**
     * Reject a pending appointment
     */
    public function reject(Request $request, PendingAppointment $pendingAppointment)
    {
        // Make slot available again
        if ($pendingAppointment->availableSlot) {
            $pendingAppointment->availableSlot->update(['status' => 'available']);
        }

        $pendingAppointment->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        // Log activity
        ActivityLog::log(
            'rejected',
            "Rejected appointment for {$pendingAppointment->name} - {$pendingAppointment->service}",
            $pendingAppointment,
            ['reason' => $request->admin_notes]
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

        return redirect()->back()
            ->with('success', 'Appointment rejected and slot made available again.');
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
                        $pendingAppointment->availableSlot->update(['status' => 'available']);
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
                ->with('success', "{$rejectedCount} appointment(s) rejected successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Failed to reject appointments: ' . $e->getMessage());
        }
    }

    /**
     * Get appointments as JSON for calendar view
     */
    public function getAppointments(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = Appointment::with(['user:id,name,email', 'vehicle:id,make,model,year,plate'])
            ->select('id', 'user_id', 'vehicle_id', 'name', 'email', 'phone', 'vehicle', 'service', 'notes', 'appointment_date', 'appointment_end', 'status', 'cancellation_requested')
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
                    'editable' => $appointment->status !== 'completed', // Prevent dragging completed appointments
                    'extendedProps' => [
                        'customer' => $appointment->name,
                        'email' => $appointment->email,
                        'phone' => $appointment->phone,
                        'vehicle' => $appointment->vehicle,
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
            ->with('success', 'Appointment status updated.');
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
            'status' => 'completed',
        ]);

        // Log activity
        ActivityLog::log(
            'completed',
            "Marked appointment as completed for {$appointment->name} - {$appointment->service}",
            $appointment
        );

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
            // Find the associated slot by matching start time
            $slot = AvailableSlot::where('start_time', $appointment->appointment_date)
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
                $slot->update(['status' => 'available']);
            }

            // Check if request expects JSON (AJAX request)
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Appointment cancelled successfully. Customer has been notified by email.'
                ]);
            }

            return redirect()->back()
                ->with('success', 'Appointment cancelled successfully. Customer has been notified by email.');
        } catch (\Exception $e) {
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to cancel appointment: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to cancel appointment.');
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
        return match($status) {
            'confirmed' => '#3b82f6', // blue
            'completed' => '#22c55e', // green
            'cancelled' => '#ef4444', // red
            default => '#6b7280', // gray
        };
    }

    /**
     * Display available slots management page
     */
    public function slots(Request $request)
    {
        // Automatically cleanup old unbooked slots
        AvailableSlot::where('status', 'available')
            ->where('start_time', '<', now())
            ->delete();

        $query = AvailableSlot::query();

        // Hide old and booked slots by default unless toggle is checked
        if (!$request->has('show_old') || !$request->show_old) {
            $query->where('start_time', '>=', now())
                  ->where('status', '!=', 'booked');
        }

        // Apply filters
        if ($request->filled('filter_date_from')) {
            $filterDateFrom = \Carbon\Carbon::parse($request->filter_date_from)->startOfDay();
            $query->where('start_time', '>=', $filterDateFrom);
        }

        if ($request->filled('filter_date_to')) {
            $filterDateTo = \Carbon\Carbon::parse($request->filter_date_to)->endOfDay();
            $query->where('start_time', '<=', $filterDateTo);
        }

        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        // Apply sorting
        $sortField = $request->get('sort', 'date');
        $sortDirection = $request->get('direction', 'asc');

        switch ($sortField) {
            case 'date':
                $query->orderBy('start_time', $sortDirection);
                break;
            case 'time':
                $query->orderBy('start_time', $sortDirection);
                break;
            case 'status':
                $query->orderBy('status', $sortDirection);
                break;
            default:
                $query->orderBy('start_time', 'asc');
        }

        $slots = $query->paginate(20)->withQueryString();
        
        // Get all users for booking dropdown
        $users = \App\Models\User::where('is_admin', false)
            ->orderBy('name')
            ->get();

        // Get blocked dates for the form
        $blockedDates = BlockedDate::where('date', '>=', now()->startOfDay())
            ->orderBy('date')
            ->get();

        return view('admin.appointments.slots', compact('slots', 'users', 'blockedDates'));
    }

    /**
     * Store a new available slot or bulk create slots
     */
    /**
     * Check for slot conflicts before creation
     */
    public function checkSlotConflicts(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'required|integer|min:15|max:480',
            'bulk_type' => 'nullable|in:single,daily,weekly',
            'bulk_count' => 'nullable|integer|min:1|max:30',
            'bulk_interval' => 'nullable|integer|min:15|max:480',
            'selected_days' => 'nullable|array',
        ]);

        $duration = (int) $request->duration;
        $interval = (int) ($request->bulk_interval ?? 60);
        $count = (int) ($request->bulk_count ?? 5);
        $selectedDays = $request->selected_days ?? [];
        
        $conflicts = [];
        $blockedConflicts = [];
        $willCreateCount = 0;

        if ($request->bulk_type === 'single' || !$request->bulk_type) {
            // Check single slot
            $startDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
            $endDateTime = $startDateTime->copy()->addMinutes($duration);

            // Check blocked date first
            if (BlockedDate::isBlocked($startDateTime)) {
                $blockedConflicts[] = [
                    'date' => $startDateTime->format('M d, Y'),
                    'reason' => BlockedDate::where('date', $startDateTime->toDateString())->value('reason') ?? __('messages.slot_blocked_no_reason'),
                ];
            } else {
                $existing = AvailableSlot::where('start_time', '<', $endDateTime)
                    ->where('end_time', '>', $startDateTime)
                    ->first();

                if ($existing) {
                    $conflicts[] = [
                        'date' => $startDateTime->format('M d, Y'),
                        'new_start' => $startDateTime->format('g:i A'),
                        'new_end' => $endDateTime->format('g:i A'),
                        'existing_start' => $existing->start_time->format('g:i A'),
                        'existing_end' => $existing->end_time->format('g:i A'),
                    ];
                } else {
                    $willCreateCount = 1;
                }
            }
        } elseif ($request->bulk_type === 'daily') {
            // Check daily slots
            $startDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
            
            if (empty($selectedDays)) {
                $selectedDays = [$startDateTime->dayOfWeek];
            }
            
            $currentDate = $startDateTime->copy()->startOfDay();
            $endDate = $currentDate->copy()->addWeeks(1);
            
            while ($currentDate <= $endDate) {
                if (in_array($currentDate->dayOfWeek, $selectedDays)) {
                    // Check blocked date for this day
                    if (BlockedDate::isBlocked($currentDate)) {
                        $blockedConflicts[] = [
                            'date' => $currentDate->format('M d, Y'),
                            'reason' => BlockedDate::where('date', $currentDate->toDateString())->value('reason') ?? __('messages.slot_blocked_no_reason'),
                        ];
                        $currentDate->addDay();
                        continue;
                    }

                    for ($i = 0; $i < $count; $i++) {
                        $slotStart = $currentDate->copy()
                            ->setTimeFromTimeString($request->start_time)
                            ->addMinutes($i * ($duration + $interval));
                        $slotEnd = $slotStart->copy()->addMinutes($duration);
                        
                        if ($slotStart->isFuture()) {
                            $existing = AvailableSlot::where('start_time', '<', $slotEnd)
                                ->where('end_time', '>', $slotStart)
                                ->first();

                            if ($existing) {
                                $conflicts[] = [
                                    'date' => $slotStart->format('M d, Y'),
                                    'new_start' => $slotStart->format('g:i A'),
                                    'new_end' => $slotEnd->format('g:i A'),
                                    'existing_start' => $existing->start_time->format('g:i A'),
                                    'existing_end' => $existing->end_time->format('g:i A'),
                                ];
                            } else {
                                $willCreateCount++;
                            }
                        }
                    }
                }
                $currentDate->addDay();
            }
        } elseif ($request->bulk_type === 'weekly') {
            // Check weekly slots
            $startDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
            
            if (empty($selectedDays)) {
                $selectedDays = [$startDateTime->dayOfWeek];
            }
            
            for ($week = 0; $week < $count; $week++) {
                foreach ($selectedDays as $dayOfWeek) {
                    $targetDate = $startDateTime->copy()->addWeeks($week)->startOfWeek();
                    $targetDate->addDays($dayOfWeek);
                    
                    // Check blocked date for this day
                    if (BlockedDate::isBlocked($targetDate)) {
                        $blockedConflicts[] = [
                            'date' => $targetDate->format('M d, Y'),
                            'reason' => BlockedDate::where('date', $targetDate->toDateString())->value('reason') ?? __('messages.slot_blocked_no_reason'),
                        ];
                        continue;
                    }

                    $slotStart = $targetDate->copy()->setTimeFromTimeString($request->start_time);
                    $slotEnd = $slotStart->copy()->addMinutes($duration);
                    
                    if ($slotStart->isFuture()) {
                        $existing = AvailableSlot::where('start_time', '<', $slotEnd)
                            ->where('end_time', '>', $slotStart)
                            ->first();

                        if ($existing) {
                            $conflicts[] = [
                                'date' => $slotStart->format('M d, Y'),
                                'new_start' => $slotStart->format('g:i A'),
                                'new_end' => $slotEnd->format('g:i A'),
                                'existing_start' => $existing->start_time->format('g:i A'),
                                'existing_end' => $existing->end_time->format('g:i A'),
                            ];
                        } else {
                            $willCreateCount++;
                        }
                    }
                }
            }
        }

        return response()->json([
            'has_conflicts' => count($conflicts) > 0,
            'has_blocked' => count($blockedConflicts) > 0,
            'conflicts' => $conflicts,
            'blocked' => $blockedConflicts,
            'will_create' => $willCreateCount,
        ]);
    }

    public function storeSlot(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'required|integer|min:15|max:480',
            'bulk_type' => 'nullable|in:single,daily,weekly',
            'bulk_count' => 'nullable|integer|min:1|max:30',
            'bulk_interval' => 'nullable|integer|min:15|max:480',
            'selected_days' => 'nullable|array',
            'selected_days.*' => 'integer|min:0|max:6',
            'force_create' => 'nullable|in:0,1',
        ]);

        // Check if the slot start time is in the past
        $startDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
        if ($startDateTime->isPast()) {
            return redirect()->back()
                ->with('error', __('messages.error_slot_in_past'))
                ->withInput();
        }

        $createdCount = 0;
        $skippedCount = 0;
        $blockedCount = 0;
        $duration = (int) $request->duration;
        $interval = (int) ($request->bulk_interval ?? 60);
        $count = (int) ($request->bulk_count ?? 5);
        $selectedDays = $request->selected_days ?? [];
        $forceCreate = $request->force_create == '1';

        if ($request->bulk_type === 'single' || !$request->bulk_type) {
            // Single slot creation
            $endDateTime = $startDateTime->copy()->addMinutes($duration);

            // Check blocked date
            if (BlockedDate::isBlocked($startDateTime)) {
                return redirect()->back()
                    ->with('error', __('messages.slot_blocked_date_error', ['date' => $startDateTime->format('M d, Y')]))
                    ->withInput();
            }

            // Check for conflicts only if not forcing
            if (!$forceCreate) {
                $conflict = AvailableSlot::where(function($query) use ($startDateTime, $endDateTime) {
                    $query->where('start_time', '<', $endDateTime)
                          ->where('end_time', '>', $startDateTime);
                })->exists();

                if ($conflict) {
                    return redirect()->back()
                        ->with('error', 'This time slot conflicts with an existing slot. Please choose a different time.');
                }
            }

            AvailableSlot::create([
                'start_time' => $startDateTime,
                'end_time' => $endDateTime,
                'status' => 'available',
            ]);
            $createdCount = 1;
        } elseif ($request->bulk_type === 'daily') {
            // Daily repeating slots - create multiple slots per selected day
            $startDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
            
            // If no days selected, default to the day of start_date
            if (empty($selectedDays)) {
                $selectedDays = [$startDateTime->dayOfWeek];
            }
            
            // Find all dates matching the selected days within a reasonable range (e.g., next 1 week)
            $currentDate = $startDateTime->copy()->startOfDay();
            $endDate = $currentDate->copy()->addWeeks(1);
            
            while ($currentDate <= $endDate) {
                if (in_array($currentDate->dayOfWeek, $selectedDays)) {
                    // Skip blocked dates
                    if (BlockedDate::isBlocked($currentDate)) {
                        $blockedCount++;
                        $currentDate->addDay();
                        continue;
                    }

                    // Create multiple slots on this day
                    for ($i = 0; $i < $count; $i++) {
                        $slotStart = $currentDate->copy()
                            ->setTimeFromTimeString($request->start_time)
                            ->addMinutes($i * ($duration + $interval));
                        $slotEnd = $slotStart->copy()->addMinutes($duration);
                        
                        // Only create if start time is in the future
                        if ($slotStart->isFuture()) {
                            // Check for conflicts
                            $conflict = AvailableSlot::where(function($query) use ($slotStart, $slotEnd) {
                                $query->where('start_time', '<', $slotEnd)
                                      ->where('end_time', '>', $slotStart);
                            })->exists();

                            if (!$conflict) {
                                AvailableSlot::create([
                                    'start_time' => $slotStart,
                                    'end_time' => $slotEnd,
                                    'status' => 'available',
                                ]);
                                $createdCount++;
                            } else {
                                $skippedCount++;
                            }
                        }
                    }
                }
                $currentDate->addDay();
            }
        } elseif ($request->bulk_type === 'weekly') {
            // Weekly repeating slots - create on selected days for N weeks
            $startDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
            
            // If no days selected, default to the day of start_date
            if (empty($selectedDays)) {
                $selectedDays = [$startDateTime->dayOfWeek];
            }
            
            // Create slots for each selected day for the specified number of weeks
            for ($week = 0; $week < $count; $week++) {
                foreach ($selectedDays as $dayOfWeek) {
                    // Find the next occurrence of this day of week from the start date
                    $targetDate = $startDateTime->copy()->addWeeks($week)->startOfWeek();
                    $targetDate->addDays($dayOfWeek); // 0=Sunday, 1=Monday, etc.

                    // Skip blocked dates
                    if (BlockedDate::isBlocked($targetDate)) {
                        $blockedCount++;
                        continue;
                    }
                    
                    $slotStart = $targetDate->copy()->setTimeFromTimeString($request->start_time);
                    $slotEnd = $slotStart->copy()->addMinutes($duration);
                    
                    // Only create if the date is in the future
                    if ($slotStart->isFuture()) {
                        // Check for conflicts
                        $conflict = AvailableSlot::where(function($query) use ($slotStart, $slotEnd) {
                            $query->where('start_time', '<', $slotEnd)
                                  ->where('end_time', '>', $slotStart);
                        })->exists();

                        if (!$conflict) {
                            AvailableSlot::create([
                                'start_time' => $slotStart,
                                'end_time' => $slotEnd,
                                'status' => 'available',
                            ]);
                            $createdCount++;
                        } else {
                            $skippedCount++;
                        }
                    }
                }
            }
        }

        $message = __('messages.slot_created_success', ['count' => $createdCount]);
        if ($skippedCount > 0) {
            $message .= ' ' . __('messages.slot_skipped_conflicts', ['count' => $skippedCount]);
        }
        if ($blockedCount > 0) {
            $message .= ' ' . __('messages.slot_skipped_blocked', ['count' => $blockedCount]);
        }

        // Log activity for slot creation
        if ($createdCount > 0) {
            $bulkType = $request->bulk_type ?? 'single';
            $startDate = \Carbon\Carbon::parse($request->start_date)->format('M d, Y');
            
            if ($bulkType === 'single') {
                $description = "Created 1 slot on {$startDate} at {$request->start_time}";
            } elseif ($bulkType === 'daily') {
                $selectedDays = $request->selected_days ?? [];
                $dayNames = [];
                $dayMap = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                foreach ($selectedDays as $day) {
                    $dayNames[] = $dayMap[$day];
                }
                $daysStr = implode(', ', $dayNames);
                $description = "Created {$createdCount} slots using daily pattern on {$daysStr} starting {$startDate}";
            } else { // weekly
                $selectedDays = $request->selected_days ?? [];
                $dayNames = [];
                $dayMap = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                foreach ($selectedDays as $day) {
                    $dayNames[] = $dayMap[$day];
                }
                $daysStr = implode(', ', $dayNames);
                $description = "Created {$createdCount} slots using weekly pattern on {$daysStr} for {$request->bulk_count} weeks";
            }
            
            ActivityLog::log(
                'created',
                $description,
                null,
                [
                    'slots_created' => $createdCount,
                    'slots_skipped' => $skippedCount,
                    'pattern' => $bulkType,
                    'start_date' => $request->start_date,
                    'start_time' => $request->start_time,
                    'duration' => $request->duration,
                ]
            );
        }

        return redirect()->back()
            ->with('success', $message);
    }

    /**
     * Delete an available slot
     */
    public function destroySlot(AvailableSlot $slot)
    {
        if ($slot->status !== 'available') {
            return redirect()->back()
                ->with('error', 'Cannot delete a slot that is booked or pending.');
        }

        $slot->delete();

        return redirect()->back()
            ->with('success', 'Available slot deleted successfully.');
    }

    /**
     * Bulk delete available slots
     */
    public function bulkDestroySlots(Request $request)
    {
        $request->validate([
            'slot_ids' => 'required|string',
        ]);

        $slotIds = explode(',', $request->slot_ids);
        
        // Only delete slots that are available (not booked or pending)
        $deletedCount = AvailableSlot::whereIn('id', $slotIds)
            ->where('status', 'available')
            ->delete();

        if ($deletedCount > 0) {
            return redirect()->back()
                ->with('success', "{$deletedCount} slot(s) deleted successfully.");
        }

        return redirect()->back()
            ->with('error', 'No available slots were deleted. Cannot delete booked or pending slots.');
    }

    /**
     * Book a slot for a client (admin booking)
     * Creates a confirmed appointment directly — no pending approval step needed.
     */
    public function bookSlot(Request $request, AvailableSlot $slot)
    {
        if ($slot->status !== 'available') {
            return redirect()->back()
                ->with('error', 'This slot is no longer available.');
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
                    'new_password' => 'required|string|min:6',
                    'new_vehicle_make' => 'required|string|max:255',
                    'new_vehicle_model' => 'required|string|max:255',
                    'new_vehicle_year' => 'required|integer|min:1900|max:2100',
                    'new_vehicle_plate' => 'nullable|string|max:20',
                    'service' => 'required|string|max:255',
                ]);

                $temporaryPassword = $request->new_password;

                $user = \App\Models\User::create([
                    'name' => $request->new_name,
                    'email' => $request->new_email,
                    'phone' => $request->new_phone,
                    'password' => bcrypt($temporaryPassword),
                ]);

                $vehicle = \App\Models\Vehicle::create([
                    'user_id' => $user->id,
                    'make' => $request->new_vehicle_make,
                    'model' => $request->new_vehicle_model,
                    'year' => $request->new_vehicle_year,
                    'plate' => $request->new_vehicle_plate,
                ]);

                $vehicleId = $vehicle->id;
                $vehicleString = "{$vehicle->year} {$vehicle->make} {$vehicle->model}" . ($vehicle->plate ? " ({$vehicle->plate})" : "");

                // Send welcome email with temporary password (queued)
                Mail::to($user->email)->queue(new NewClientAccountCreated($user, $temporaryPassword));
            } else {
                // Existing client
                $request->validate([
                    'user_id' => 'required|exists:users,id',
                    'service' => 'required|string|max:255',
                ]);

                $user = \App\Models\User::find($request->user_id);
                
                if ($request->filled('new_vehicle_make') && $request->filled('new_vehicle_model') && $request->filled('new_vehicle_year')) {
                    $vehicle = \App\Models\Vehicle::create([
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
                    $vehicle = \App\Models\Vehicle::find($vehicleId);
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
                'vehicle_id' => $vehicleId,
                'name' => $clientType === 'new' ? $request->new_name : $user->name,
                'email' => $clientType === 'new' ? $request->new_email : $user->email,
                'phone' => $clientType === 'new' ? ($request->new_phone ?? 'Not provided') : ($user->phone ?? 'Not provided'),
                'vehicle' => $vehicleString,
                'service' => $request->service,
                'notes' => $request->notes ? clean($request->notes) : null,
                'admin_notes' => $request->admin_notes,
                'appointment_date' => $slot->start_time,
                'appointment_end' => $slot->end_time,
                'status' => 'confirmed',
                'booked_by_admin' => true,
            ]);

            // Mark slot as booked
            $slot->update(['status' => 'booked']);

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
            Mail::to($appointment->email)->queue(new \App\Mail\AppointmentApproved($appointment));

            return redirect()->route('admin.appointments.calendar')
                ->with('success', "Appointment confirmed directly for {$appointment->name}.");
        });
    }

    /**
     * Get user's vehicles for AJAX
     */
    public function getUserVehicles($userId)
    {
        $vehicles = \App\Models\Vehicle::where('user_id', $userId)->get();
        return response()->json($vehicles);
    }

    /**
     * Export appointments as CSV
     */
    public function exportAppointments(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Appointment::with('user');
        
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
                fputcsv($file, [
                    $appointment->id,
                    $appointment->name,
                    $appointment->email,
                    $appointment->phone,
                    $appointment->vehicle,
                    $appointment->service,
                    $appointment->appointment_date->format('Y-m-d H:i'),
                    $appointment->status,
                    $appointment->notes,
                    $appointment->created_at->format('Y-m-d H:i'),
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
                fputcsv($file, [
                    $slot->id,
                    $slot->start_time->format('Y-m-d H:i'),
                    $slot->end_time->format('Y-m-d H:i'),
                    $slot->start_time->diffInMinutes($slot->end_time),
                    $slot->status,
                    $slot->created_at->format('Y-m-d H:i'),
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
                'status' => 'cancelled',
                'cancellation_requested' => false,
            ]);

            // If there's an associated slot, make it available again
            $slot = AvailableSlot::where('start_time', $appointment->appointment_date)
                ->where('end_time', $appointment->appointment_end)
                ->first();
            
            if ($slot) {
                $slot->update(['status' => 'available']);
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

