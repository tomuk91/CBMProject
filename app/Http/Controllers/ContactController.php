<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function submit(Request $request)
    {
        // Honeypot protection - if filled, it's a bot
        if ($request->filled('website')) {
            // Silently reject bot submissions
            return redirect()->route('contact.show')
                ->with('success', __('messages.contact_success'));
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[\p{L}\s\-\']+$/u',
            'email' => 'required|email:rfc,dns|max:255',
            'phone' => 'nullable|string|max:20|regex:/^[+]?[0-9\s\-()]+$/',
            'subject' => 'required|string|in:appointment,service,general,other',
            'message' => 'required|string|max:2000|min:10',
        ], [
            'name.required' => __('messages.validation.name_required'),
            'name.max' => __('messages.validation.name_max', ['max' => 255]),
            'name.regex' => __('messages.validation.name_regex'),
            'email.required' => __('messages.validation.email_required'),
            'email.email' => __('messages.validation.email_valid'),
            'email.max' => __('messages.validation.email_max', ['max' => 255]),
            'phone.max' => __('messages.validation.phone_max', ['max' => 20]),
            'phone.regex' => __('messages.validation.phone_format'),
            'subject.required' => __('messages.validation.required'),
            'subject.in' => __('messages.validation.subject_invalid'),
            'message.required' => __('messages.validation.required'),
            'message.max' => __('messages.validation.max_length', ['max' => 2000]),
            'message.min' => __('messages.validation.message_min', ['min' => 10]),
        ]);

        // Send email notification to admin
        Mail::to(config('mail.from.address'))->queue(new ContactFormSubmitted($validated));

        // Send confirmation email to user
        // Mail::to($validated['email'])->send(new ContactFormConfirmation($validated));

        return redirect()->route('contact.show')->with('success', __('messages.contact_success'));
    }
}
