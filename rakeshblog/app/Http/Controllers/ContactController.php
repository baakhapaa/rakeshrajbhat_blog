<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Send the contact message.
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Send email (uncomment when mail is configured)
        
        Mail::send('emails.contact', [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'user_message' => $request->message,
        ], function ($mail) use ($request) {
            $mail->to('admin@rakeshrajbhat.com')
                ->subject('New Contact Message: ' . $request->subject)
                ->replyTo($request->email, $request->name);
        });
       

        // For now, just store in session
        session()->flash('contact_success', 'Thank you for your message! We will get back to you soon.');

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
}