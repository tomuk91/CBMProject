<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\ActivityLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $section = $request->route()->getName() === 'profile.edit' ? 'overview' : 
                   (str_contains($request->route()->getName(), 'personal-info') ? 'personal-info' :
                   (str_contains($request->route()->getName(), 'vehicle') ? 'vehicle' : 
                   (str_contains($request->route()->getName(), 'security') ? 'security' : 'overview')));
        
        return view('profile.edit', [
            'user' => $request->user()->load('appointments'),
            'section' => $section,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Log profile update
        ActivityLog::log(
            action: 'profile_updated',
            description: 'User updated their profile information',
            model: $request->user()
        );

        return Redirect::back()->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Log account deletion before deleting
        ActivityLog::log(
            action: 'account_deleted',
            description: 'User deleted their account',
            model: $user
        );

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Export user's personal data (GDPR compliance).
     */
    public function exportData(Request $request)
    {
        $user = $request->user()->load(['appointments', 'vehicles']);

        return view('profile.export-data', compact('user'));
    }

    /**
     * Request account deletion (GDPR compliance).
     */
    public function requestDeletion(Request $request): RedirectResponse
    {
        $request->validateWithBag('accountDeletion', [
            'password' => ['required', 'current_password'],
            'confirmation' => ['required', 'accepted'],
        ]);

        $user = $request->user();

        // In a production environment, you might want to:
        // 1. Queue the deletion for X days (e.g., 30 days)
        // 2. Send confirmation email
        // 3. Allow cancellation within grace period
        // 4. Anonymize data instead of deleting

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/')->with('status', 'account-deleted');
    }
}

