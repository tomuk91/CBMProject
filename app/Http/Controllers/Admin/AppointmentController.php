<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Mail\AppointmentApproved;
use App\Mail\AppointmentRejected;
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
        $upcomingAppointments = Appointment::where('status', 'confirmed')
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

        return view('admin.appointments.dashboard', compact('pendingCount', 'upcomingAppointments', 'availableSlotsCount', 'bookedSlotsCount'));
    }

    /**
     * Display admin calendar
     */
    public function index()
    {
        $appointments = Appointment::with('user')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('admin.appointments.calendar', compact('appointments'));
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

        return view('admin.appointments.pending', compact('pendingAppointments', 'services'));
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

            // Send approval email
            Mail::to($appointment->email)->send(new AppointmentApproved($appointment));

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
        Mail::to($pendingAppointment->email)->send(new AppointmentRejected($pendingAppointment, $request->admin_notes ?? ''));

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
                    Mail::to($pendingAppointment->email)->send(new AppointmentRejected($pendingAppointment, 'Your appointment request was not approved at this time.'));
                    
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

        $appointments = Appointment::with('user')
            ->whereBetween('appointment_date', [$start, $end])
            ->get()
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

            // Send cancellation email to customer
            \Illuminate\Support\Facades\Mail::to($appointment->email)
                ->send(new \App\Mail\AppointmentCancelled($appointment, request()->input('reason', '')));
            
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

        return view('admin.appointments.slots', compact('slots', 'users'));
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
        $willCreateCount = 0;

        if ($request->bulk_type === 'single' || !$request->bulk_type) {
            // Check single slot
            $startDateTime = \Carbon\Carbon::parse($request->start_date . ' ' . $request->start_time);
            $endDateTime = $startDateTime->copy()->addMinutes($duration);

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
            'conflicts' => $conflicts,
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
        $duration = (int) $request->duration;
        $interval = (int) ($request->bulk_interval ?? 60);
        $count = (int) ($request->bulk_count ?? 5);
        $selectedDays = $request->selected_days ?? [];
        $forceCreate = $request->force_create == '1';

        if ($request->bulk_type === 'single' || !$request->bulk_type) {
            // Single slot creation
            $endDateTime = $startDateTime->copy()->addMinutes($duration);

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

        $message = "Created $createdCount available slot(s) successfully.";
        if ($skippedCount > 0) {
            $message .= " Skipped $skippedCount slot(s) due to time conflicts.";
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
     */
    public function bookSlot(Request $request, AvailableSlot $slot)
    {
        if ($slot->status !== 'available') {
            return redirect()->back()
                ->with('error', 'This slot is no longer available.');
        }

        $clientType = $request->input('client_type');
        
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

            // Store the plain password before hashing to send in email
            $temporaryPassword = $request->new_password;

            $user = \App\Models\User::create([
                'name' => $request->new_name,
                'email' => $request->new_email,
                'phone' => $request->new_phone,
                'password' => bcrypt($temporaryPassword),
            ]);

            // Create vehicle for the new user
            $vehicle = \App\Models\Vehicle::create([
                'user_id' => $user->id,
                'make' => $request->new_vehicle_make,
                'model' => $request->new_vehicle_model,
                'year' => $request->new_vehicle_year,
                'plate' => $request->new_vehicle_plate,
            ]);

            $vehicleString = "{$vehicle->year} {$vehicle->make} {$vehicle->model}" . ($vehicle->plate ? " ({$vehicle->plate})" : "");

            // Create pending appointment for new client
            $pendingAppointment = PendingAppointment::create([
                'user_id' => $user->id,
                'available_slot_id' => $slot->id,
                'vehicle_id' => $vehicle->id,
                'name' => $request->new_name,
                'email' => $request->new_email,
                'phone' => $request->new_phone ?? 'Not provided',
                'vehicle' => $vehicleString,
                'service' => $request->service,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // Send welcome email with temporary password
            Mail::to($user->email)->send(new NewClientAccountCreated($user, $temporaryPassword));
        } else {
            // Existing client
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'service' => 'required|string|max:255',
            ]);

            $user = \App\Models\User::find($request->user_id);
            
            // Determine vehicle information
            $vehicleId = null;
            $vehicleString = null;
            
            if ($request->filled('new_vehicle_make') && $request->filled('new_vehicle_model') && $request->filled('new_vehicle_year')) {
                // Create new vehicle for the user
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
                // Using selected vehicle from dropdown
                $vehicleId = $request->vehicle_id;
                $vehicle = \App\Models\Vehicle::find($vehicleId);
                if ($vehicle) {
                    $vehicleString = "{$vehicle->year} {$vehicle->make} {$vehicle->model}" . ($vehicle->plate ? " ({$vehicle->plate})" : "");
                }
            } elseif ($request->filled('vehicle')) {
                // Manual entry (not saved to profile)
                $vehicleString = $request->vehicle;
            }

            // Create pending appointment for existing client
            $pendingAppointment = PendingAppointment::create([
                'user_id' => $user->id,
                'available_slot_id' => $slot->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? 'Not provided',
                'vehicle' => $vehicleString,
                'service' => $request->service,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);
        }

        // Update slot status to pending
        $slot->update(['status' => 'booked']);

        return redirect()->route('admin.appointments.pending')
            ->with('success', 'Appointment request created successfully and is pending approval.');
    }

    /**
     * Get user's vehicles for AJAX
     */
    public function getUserVehicles($userId)
    {
        $vehicles = \App\Models\Vehicle::where('user_id', $userId)->get();
        return response()->json($vehicles);
    }
}
