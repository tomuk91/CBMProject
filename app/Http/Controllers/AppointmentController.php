<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\PendingAppointment;
use App\Models\AvailableSlot;
use App\Models\ActivityLog;
use App\Models\User;
use App\Enums\AppointmentStatus;
use App\Enums\SlotStatus;
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
        $availableSlots = $this->getAvailableSlots($request);
        return view('appointments.index', compact('availableSlots'));
    }

    /**
     * Display the calendar view of available slots
     */
    public function calendar()
    {
        return view('appointments.calendar');
    }

    /**
     * Return available slots as JSON for the customer calendar
     */
    public function calendarApi(Request $request)
    {
        $query = AvailableSlot::available();

        if ($request->filled('start')) {
            $query->where('start_time', '>=', $request->start);
        }
        if ($request->filled('end')) {
            $query->where('start_time', '<=', $request->end);
        }

        $slots = $query->orderBy('start_time', 'asc')->get();

        return response()->json($slots->map(function ($slot) {
            return [
                'id' => $slot->id,
                'title' => __('messages.available'),
                'start' => $slot->start_time->toIso8601String(),
                'end' => $slot->end_time->toIso8601String(),
                'url' => route('appointments.show', $slot->id),
                'backgroundColor' => '#16a34a',
                'borderColor' => '#15803d',
                'textColor' => '#ffffff',
            ];
        }));
    }

    /**
     * Show booking form for a specific slot
     */
    public function show(AvailableSlot $slot)
    {
        if ($slot->status !== SlotStatus::Available) {
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
            'vehicle_id' => ['nullable', \Illuminate\Validation\Rule::exists('vehicles', 'id')->where('user_id', auth()->id())],
            'service' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ], [
            'name.required' => __('messages.validation.name_required'),
            'name.max' => __('messages.validation.name_max', ['max' => 255]),
            'email.required' => __('messages.validation.email_required'),
            'email.email' => __('messages.validation.email_valid'),
            'email.max' => __('messages.validation.email_max', ['max' => 255]),
            'phone.required' => __('messages.validation.phone_required'),
            'phone.max' => __('messages.validation.phone_max', ['max' => 20]),
            'service.required' => __('messages.validation.service_required'),
            'service.max' => __('messages.validation.max_length', ['max' => 255]),
            'notes.max' => __('messages.validation.notes_max', ['max' => 1000]),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the vehicle already has an outstanding appointment
        if ($request->vehicle_id) {
            $existingAppointment = Appointment::where('vehicle_id', $request->vehicle_id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();
            
            $existingPendingAppointment = PendingAppointment::where('vehicle_id', $request->vehicle_id)
                ->where('status', 'pending')
                ->exists();

            if ($existingAppointment || $existingPendingAppointment) {
                return redirect()->back()
                    ->with('error', __('messages.vehicle_has_outstanding_appointment'))
                    ->withInput();
            }
        }

        try {
            return DB::transaction(function () use ($request, $slot) {
                // Lock the slot row for update to prevent race conditions
                $lockedSlot = AvailableSlot::where('id', $slot->id)
                    ->lockForUpdate()
                    ->first();

                // Check if slot is still available after locking
                if (!$lockedSlot || $lockedSlot->status !== SlotStatus::Available) {
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
                $lockedSlot->update(['status' => SlotStatus::Pending]);

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
                    ->with('success', 'Your appointment request has been submitted and is pending approval!')
                    ->with('booking_details', [
                        'name' => $pendingAppointment->name,
                        'email' => $pendingAppointment->email,
                        'phone' => $pendingAppointment->phone,
                        'vehicle' => $pendingAppointment->vehicleDetails ?? null,
                        'service' => $request->service,
                        'notes' => $pendingAppointment->notes,
                        'start_time' => $lockedSlot->start_time->toIso8601String(),
                        'end_time' => $lockedSlot->end_time->toIso8601String(),
                    ]);
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
        $availableSlots = $this->getAvailableSlots($request);
        return view('appointments.guest-slots', compact('availableSlots'));
    }

    /**
     * Handle guest slot selection and redirect to login/register
     */
    public function selectGuestSlot(Request $request, $slotId)
    {
        $slot = AvailableSlot::findOrFail($slotId);
        
        if ($slot->status !== SlotStatus::Available) {
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
     * Display appointment details for the customer
     */
    public function showDetails(Appointment $appointment)
    {
        // Ensure user owns this appointment
        if ($appointment->user_id !== auth()->id()) {
            abort(403);
        }

        $linkedVehicle = $appointment->vehicle_id ? \App\Models\Vehicle::find($appointment->vehicle_id) : null;

        return view('appointments.show', compact('appointment', 'linkedVehicle'));
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
        if ($appointment->status === AppointmentStatus::Cancelled) {
            return redirect()->back()->with('error', __('messages.appointment_already_cancelled'));
        }

        if ($appointment->cancellation_requested) {
            return redirect()->back()->with('error', __('messages.cancellation_already_requested'));
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ], [
            'cancellation_reason.required' => __('messages.validation.required'),
            'cancellation_reason.max' => __('messages.validation.max_length', ['max' => 500]),
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

        // Notify all admins about the cancellation request (cached for 1 hour)
        $admins = cache()->remember('admin_users', 3600, function() {
            return User::where('is_admin', true)->get();
        });
        foreach ($admins as $admin) {
            Mail::to($admin->email)->queue(new CancellationRequested($appointment));
        }

        return redirect()->back()->with('success', __('messages.cancellation_requested_success'));
    }

    /**
     * Check if vehicle has outstanding appointments (API endpoint)
     */
    public function checkVehicleAvailability($vehicleId)
    {
        // Verify vehicle belongs to the authenticated user
        $vehicle = Auth::user()->vehicles()->find($vehicleId);
        
        if (!$vehicle) {
            return response()->json(['available' => true]);
        }

        // Check appointments table (both vehicle_id foreign key and vehicle text field)
        $existingAppointment = Appointment::where('user_id', Auth::id())
            ->where(function($query) use ($vehicleId, $vehicle) {
                $query->where('vehicle_id', $vehicleId)
                      ->orWhere('vehicle', 'like', '%' . $vehicle->plate . '%');
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
        
        $existingPendingAppointment = PendingAppointment::where('vehicle_id', $vehicleId)
            ->where('status', 'pending')
            ->exists();

        $hasOutstanding = $existingAppointment || $existingPendingAppointment;

        return response()->json([
            'available' => !$hasOutstanding,
            'message' => $hasOutstanding ? __('messages.vehicle_has_outstanding_appointment') : null
        ]);
    }

    /**
     * Get available slots based on request filters (shared by index and guestSlots)
     */
    private function getAvailableSlots(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $query = AvailableSlot::available();

        $dateFrom = $request->filled('date_from') ? $request->date_from : now()->format('Y-m-d');
        $dateTo = $request->filled('date_to') ? $request->date_to : now()->addWeek()->format('Y-m-d');

        $query->whereBetween('start_time', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59']);

        if ($request->filled('days') && is_array($request->days)) {
            $query->dayOfWeek($request->days);
        }

        if ($request->filled('time_period')) {
            $query->timeOfDay($request->time_period);
        }

        return $query->orderBy('start_time', 'asc')->get();
    }
}

