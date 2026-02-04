<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Send welcome email
        Mail::to($user->email)->send(new WelcomeMail($user));

        Auth::login($user);

        // Check if user was trying to book an appointment
        if (session('intended_booking') && session('selected_slot_id')) {
            $slotId = session('selected_slot_id');
            
            // Clear the booking intent flags
            session()->forget(['intended_booking', 'selected_slot_id']);
            
            // Redirect to booking page with the selected slot
            return redirect()->route('appointments.show', $slotId)
                ->with('success', 'Welcome! Please complete your booking below.');
        }

        return redirect(route('dashboard', absolute: false));
    }
}
