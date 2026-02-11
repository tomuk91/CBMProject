<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\AvailableSlot;
use App\Models\BlockedDate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class BlockedDateController extends Controller
{
    /**
     * List all blocked dates, separated into upcoming and past.
     */
    public function index()
    {
        $upcomingBlockedDates = BlockedDate::where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();

        $pastBlockedDates = BlockedDate::where('date', '<', now()->toDateString())
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.blocked-dates.index', compact('upcomingBlockedDates', 'pastBlockedDates'));
    }

    /**
     * Store a newly created blocked date (supports single date or date range).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'date_to' => 'nullable|date|after_or_equal:date',
            'reason' => 'nullable|string|max:255',
        ]);

        $startDate = Carbon::parse($validated['date']);
        $endDate = isset($validated['date_to']) ? Carbon::parse($validated['date_to']) : $startDate->copy();

        $period = CarbonPeriod::create($startDate, $endDate);
        $createdCount = 0;
        $appointmentWarningCount = 0;

        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');

            // Skip if already blocked
            if (BlockedDate::where('date', $dateString)->exists()) {
                continue;
            }

            // Check for confirmed appointments on this date (Item #51)
            $confirmedCount = Appointment::where('status', 'confirmed')
                ->whereDate('appointment_date', $dateString)
                ->count();
            $appointmentWarningCount += $confirmedCount;

            $blockedDate = BlockedDate::create([
                'date' => $dateString,
                'reason' => $validated['reason'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Delete any auto-generated available slots on the blocked date
            AvailableSlot::where('source', 'auto')
                ->where('status', 'available')
                ->whereDate('start_time', $dateString)
                ->delete();

            ActivityLog::log(
                'blocked_date_created',
                "Blocked date added: {$dateString}" . ($validated['reason'] ? " — {$validated['reason']}" : ''),
                $blockedDate
            );

            $createdCount++;
        }

        $redirect = redirect()->route('admin.blocked-dates.index')
            ->with('success', __('messages.blocked_dates_range_created', ['count' => $createdCount]));

        if ($appointmentWarningCount > 0) {
            $redirect = $redirect->with('warning', __('messages.blocked_date_has_appointments', ['count' => $appointmentWarningCount]));
        }

        return $redirect;
    }

    /**
     * Remove the specified blocked date.
     */
    public function destroy(BlockedDate $blockedDate)
    {
        $dateFormatted = $blockedDate->date->format('Y-m-d');

        $blockedDate->delete();

        ActivityLog::log(
            'blocked_date_deleted',
            "Blocked date removed: {$dateFormatted}",
        );

        return redirect()->route('admin.blocked-dates.index')
            ->with('success', 'Blocked date removed successfully.');
    }
}
