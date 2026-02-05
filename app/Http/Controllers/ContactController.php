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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string|max:2000',
        ]);

        // Send email notification to admin
        Mail::to('info@cbmauto.com')->send(new ContactFormSubmitted($request->all()));

        // Send confirmation email to user
        // Mail::to($request->email)->send(new ContactFormConfirmation($request->all()));

        return redirect()->route('contact.show')->with('success', __('messages.contact_success'));
    }
}
