<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Models\BlockedDate;
use App\Models\User;
use App\Enums\SlotStatus;
use Illuminate\Http\Request;

class SlotController extends Controller
{
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
        $users = User::where('is_admin', false)
            ->orderBy('name')
            ->get();

        // Get blocked dates for the form
        $blockedDates = BlockedDate::where('date', '>=', now()->startOfDay())
            ->orderBy('date')
            ->get();

        return view('admin.appointments.slots', compact('slots', 'users', 'blockedDates'));
    }

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

    /**
     * Store a new available slot or bulk create slots
     */
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
                'status' => SlotStatus::Available,
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
                                    'status' => SlotStatus::Available,
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
                                'status' => SlotStatus::Available,
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
        if ($slot->status !== SlotStatus::Available) {
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
}
