<?php

namespace App\Http\Controllers;

use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Models\User;
use App\Mail\AppointmentConfirmation;
use App\Mail\NewAppointmentAdmin;
use App\Mail\CancellationRequested;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        // Filter by date range
        $dateFrom = $request->filled('date_from') ? $request->date_from : now()->format('Y-m-d');
        $dateTo = $request->filled('date_to') ? $request->date_to : now()->addWeeks(2)->format('Y-m-d');
        
        $query->whereBetween('start_time', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        // Filter by day of week (SQLite compatible) - supports multiple days
        if ($request->filled('days') && is_array($request->days)) {
            $query->dayOfWeek($request->days);
        }

        // Filter by time of day (SQLite compatible)
        if ($request->filled('time_period')) {
            $query->timeOfDay($request->time_period);
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
            return DB::transaction(function () use ($request, $slot) {
                // Lock the slot row for update to prevent race conditions
                $lockedSlot = AvailableSlot::where('id', $slot->id)
                    ->lockForUpdate()
                    ->first();

                // Check if slot is still available after locking
                if (!$lockedSlot || $lockedSlot->status !== 'available') {
                    return redirect()->route('appointments.index')
                        ->with('error', 'This appointment slot is no longer available. Please select another slot.');
                }

                // Update user profile with any new information provided
                $user = Auth::user();
                $updateData = [];
                
                if (!$user->name && $request->filled('name')) {
                    $updateData['name'] = $request->name;
                }
                if (!$user->email && $request->filled('email')) {
                    $updateData['email'] = $request->email;
                }
                if (!$user->phone && $request->filled('phone')) {
                    $updateData['phone'] = $request->phone;
                }
                
                if (!empty($updateData)) {
                    $user->update($updateData);
                }

                // Mark slot as pending
                $lockedSlot->update(['status' => 'pending']);

                // Create pending appointment
                $pendingAppointment = PendingAppointment::create([
                    'user_id' => Auth::id(),
                    'available_slot_id' => $lockedSlot->id,
                    'vehicle_id' => $request->vehicle_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'service' => $request->service,
                    'notes' => $request->notes,
                    'status' => 'pending',
                ]);

                // Log appointment booking
                ActivityLog::log(
                    action: 'appointment_requested',
                    description: "User requested appointment for {$request->service}",
                    model: $pendingAppointment,
                    changes: [
                        'slot_start' => $lockedSlot->start_time,
                        'service' => $request->service,
                    ]
                );

                // Create a temporary appointment object for email
                $tempAppointment = (object) [
                    'id' => $pendingAppointment->id,
                    'name' => $pendingAppointment->name,
                    'email' => $pendingAppointment->email,
                    'phone' => $pendingAppointment->phone,
                    'service' => $pendingAppointment->service,
                    'notes' => $pendingAppointment->notes,
                    'appointment_date' => $lockedSlot->start_time,
                    'appointment_end' => $lockedSlot->end_time,
                    'vehicle_id' => $pendingAppointment->vehicle_id,
                    'vehicle' => $pendingAppointment->vehicleDetails ?? null,
                    'status' => 'pending',
                ];

                // Create a temporary appointment object for emails (cast array to object)
                $appointmentForEmail = (object) $tempAppointment;
                
                // Send confirmation email to customer
                Mail::to($pendingAppointment->email)->queue(new AppointmentConfirmation($appointmentForEmail));
                
                // Send notification to all admins
                $admins = User::where('is_admin', true)->get();
                foreach ($admins as $admin) {
                    Mail::to($admin->email)->queue(new NewAppointmentAdmin($appointmentForEmail));
                }

                return redirect()->route('appointments.confirmation')
                    ->with('success', 'Your appointment request has been submitted and is pending approval!');
            });
        } catch (\Exception $e) {
            \Log::error('Appointment submission error: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            return redirect()->back()
                ->with('error', 'An error occurred while submitting your request. Please try again.')
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

    /**
     * Show available slots for guest users
     */
    public function guestSlots(Request $request)
    {
        $query = AvailableSlot::available();

        // Filter by date range
        $dateFrom = $request->filled('date_from') ? $request->date_from : now()->format('Y-m-d');
        $dateTo = $request->filled('date_to') ? $request->date_to : now()->addWeeks(2)->format('Y-m-d');
        
        $query->whereBetween('start_time', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        // Filter by time of day (using scope)
        if ($request->filled('time_period')) {
            $query->timeOfDay($request->time_period);
        }

        $availableSlots = $query->orderBy('start_time', 'asc')->get();
        
        return view('appointments.guest-slots', compact('availableSlots'));
    }

    /**
     * Handle guest slot selection and redirect to login/register
     */
    public function selectGuestSlot(Request $request, $slotId)
    {
        $slot = AvailableSlot::findOrFail($slotId);
        
        if ($slot->status !== 'available') {
            return redirect()->route('guest.slots')
                ->with('error', 'This slot is no longer available. Please select another.');
        }

        // Store the selected slot in session
        session(['selected_slot_id' => $slotId]);
        session(['intended_booking' => true]);

        // Redirect to login with a message
        return redirect()->route('login')
            ->with('info', 'Please login or register to complete your booking for ' . 
                   \Carbon\Carbon::parse($slot->start_time)->format('l, F j \a\t H:i'));
    }

    /**
     * Request cancellation for an appointment
     */
    public function requestCancellation(Request $request, $id)
    {
        $appointment = \App\Models\Appointment::findOrFail($id);

        // Verify the user owns this appointment
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }

        // Can't request cancellation if already cancelled or already requested
        if ($appointment->status === 'cancelled') {
            return redirect()->back()->with('error', __('messages.appointment_already_cancelled'));
        }

        if ($appointment->cancellation_requested) {
            return redirect()->back()->with('error', __('messages.cancellation_already_requested'));
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $appointment->update([
            'cancellation_requested' => true,
            'cancellation_requested_at' => now(),
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        // Log cancellation request
        ActivityLog::log(
            action: 'cancellation_requested',
            description: 'User requested appointment cancellation',
            model: $appointment,
            changes: [
                'reason' => $request->cancellation_reason,
                'appointment_date' => $appointment->appointment_date,
            ]
        );

        // Notify all admins about the cancellation request
        $admins = User::where('is_admin', true)->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new CancellationRequested($appointment));
        }

        return redirect()->back()->with('success', __('messages.cancellation_requested_success'));
    }
}

