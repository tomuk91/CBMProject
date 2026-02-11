<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AvailableSlot;
use App\Models\BlockedDate;
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
     * Store a newly created blocked date.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|after_or_equal:today|unique:blocked_dates,date',
            'reason' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();

        $blockedDate = BlockedDate::create($validated);

        // Delete any auto-generated available slots on the blocked date
        AvailableSlot::where('source', 'auto')
            ->where('status', 'available')
            ->whereDate('start_time', $blockedDate->date)
            ->delete();

        ActivityLog::log(
            'blocked_date_created',
            "Blocked date added: {$blockedDate->date->format('Y-m-d')}" . ($blockedDate->reason ? " — {$blockedDate->reason}" : ''),
            $blockedDate
        );

        return redirect()->route('admin.blocked-dates.index')
            ->with('success', 'Blocked date added successfully.');
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
