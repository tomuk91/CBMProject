<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
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
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Send welcome email (queued for better performance)
        Mail::to($user->email)->queue(new WelcomeMail($user));

        Auth::login($user);

        // Log user registration (after login so auth()->id() is set)
        ActivityLog::log(
            action: 'user_registered',
            description: 'New user account created',
            model: $user
        );

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
