<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Mail\ContactFormSubmitted;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(ContactFormRequest $request)
    {
        // Honeypot protection - if filled, it's a bot
        if ($request->filled('website')) {
            // Silently reject bot submissions
            return redirect()->route('contact.show')
                ->with('success', __('messages.contact_success'));
        }
        
        $validated = $request->validated();

        // Store the submission in the database
        ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
        ]);

        // Send email notification to admin
        Mail::to(config('mail.from.address'))->queue(new ContactFormSubmitted($validated));

        // Send confirmation email to user
        Mail::to($validated['email'])->queue(new \App\Mail\ContactFormConfirmation($validated));

        return redirect()->route('contact.show')->with('success', __('messages.contact_success'));
    }
}
