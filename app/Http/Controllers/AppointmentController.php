<?php

namespace App\Http\Controllers;

use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Mail\AppointmentBooked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display available appointment slots
     */
    public function index(Request $request)
    {
        $query = AvailableSlot::available();

        // Filter by week
        if ($request->filled('week')) {
            $weekStart = now()->startOfWeek()->addWeeks((int) $request->week);
            $weekEnd = $weekStart->copy()->endOfWeek();
            $query->whereBetween('start_time', [$weekStart, $weekEnd]);
        }

        // Filter by day of week (SQLite compatible) - supports multiple days
        if ($request->filled('days') && is_array($request->days)) {
            $query->where(function($q) use ($request) {
                foreach ($request->days as $day) {
                    // Convert MySQL DAYOFWEEK (1=Sunday, 2=Monday) to SQLite strftime %w (0=Sunday, 1=Monday)
                    $sqliteDay = ((int) $day - 1) % 7;
                    $q->orWhereRaw("CAST(strftime('%w', start_time) AS INTEGER) = ?", [$sqliteDay]);
                }
            });
        }

        // Filter by time of day (SQLite compatible)
        if ($request->filled('time_period')) {
            switch ($request->time_period) {
                case 'morning':
                    $query->whereRaw("CAST(strftime('%H', start_time) AS INTEGER) >= 6 AND CAST(strftime('%H', start_time) AS INTEGER) < 12");
                    break;
                case 'afternoon':
                    $query->whereRaw("CAST(strftime('%H', start_time) AS INTEGER) >= 12 AND CAST(strftime('%H', start_time) AS INTEGER) < 17");
                    break;
                case 'evening':
                    $query->whereRaw("CAST(strftime('%H', start_time) AS INTEGER) >= 17 AND CAST(strftime('%H', start_time) AS INTEGER) < 21");
                    break;
            }
        }

        $availableSlots = $query->orderBy('start_time', 'asc')->get();
        
        return view('appointments.index', compact('availableSlots'));
    }

    /**
     * Show booking form for a specific slot
     */
    public function show(AvailableSlot $slot)
    {
        if ($slot->status !== 'available') {
            return redirect()->route('appointments.index')
                ->with('error', 'This appointment slot is no longer available.');
        }

        return view('appointments.book', compact('slot'));
    }

    /**
     * Process the booking request (creates pending appointment)
     */
    public function store(Request $request, AvailableSlot $slot)
    {
        if ($slot->status !== 'available') {
            return redirect()->route('appointments.index')
                ->with('error', 'This appointment slot is no longer available.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'service' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Mark slot as pending
            $slot->update(['status' => 'pending']);

            // Create pending appointment
            $pendingAppointment = PendingAppointment::create([
                'user_id' => Auth::id(),
                'available_slot_id' => $slot->id,
                'vehicle_id' => $request->vehicle_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'service' => $request->service,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // Send confirmation email
            Mail::to($pendingAppointment->email)->send(new AppointmentBooked($pendingAppointment));

            return redirect()->route('appointments.confirmation')
                ->with('success', 'Your appointment request has been submitted and is pending approval!');
        } catch (\Exception $e) {
            $slot->update(['status' => 'available']);
            \Log::error('Appointment submission error: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->with('error', 'An error occurred while submitting your request: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show booking confirmation page
     */
    public function confirmation()
    {
        if (!session()->has('success')) {
            return redirect()->route('appointments.index');
        }

        return view('appointments.confirmation');
    }
}
