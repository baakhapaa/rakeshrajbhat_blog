<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BootcampRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\BootcampRequestMail;
use Illuminate\Support\Facades\Log;

class BootcampController extends Controller
{
    /**
     * Show the bootcamp booking page
     */
    public function index()
    {
        return view('partials.bootcamp');
    }

    /**
     * Handle bootcamp request submission
     */
    public function submit(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'org_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'participants' => 'required|integer|min:1',
            'preferred_date' => 'required|date|after:today',
            'audience' => 'nullable|array',
            'audience.*' => 'string',
            'requirements' => 'nullable|string',
        ]);

        // Prepare email data
        $emailData = [
            'org_name' => $validated['org_name'],
            'district' => $validated['district'],
            'contact_person' => $validated['contact_person'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'participants' => $validated['participants'],
            'preferred_date' => $validated['preferred_date'],
            'audience' => implode(', ', $validated['audience'] ?? []),
            'requirements' => $validated['requirements'] ?? 'No requirements provided',
        ];

        // Log the email data for debugging
        Log::info('Bootcamp Email Data: ' . json_encode($emailData));

        // Store in database
        try {
            $bootcampRequest = BootcampRequest::create([
                'org_name' => $validated['org_name'],
                'district' => $validated['district'],
                'contact_person' => $validated['contact_person'],
                'contact_email' => $validated['contact_email'],
                'contact_phone' => $validated['contact_phone'],
                'participants' => $validated['participants'],
                'preferred_date' => $validated['preferred_date'],
                'audience' => implode(', ', $validated['audience'] ?? []),
                'requirements' => $validated['requirements'] ?? '',
                'status' => 'pending'
            ]);
            
            $emailData['id'] = $bootcampRequest->id;
            Log::info('✅ Bootcamp request saved with ID: ' . $bootcampRequest->id);
            
        } catch (\Exception $e) {
            Log::error('❌ Failed to save bootcamp request: ' . $e->getMessage());
        }

        // Send email notification
        try {
            $adminEmail = config('mail.admin_email', 'admin@rakeshrajbhat.com.np');
            Log::info('📧 Sending email to: ' . $adminEmail);
            
            // Send email using the Mail class
            Mail::to($adminEmail)->send(new BootcampRequestMail($emailData));
            
            Log::info('✅ Email sent successfully!');
            
        } catch (\Exception $e) {
            Log::error('❌ Failed to send bootcamp request email: ' . $e->getMessage());
            Log::error('❌ Error details: ' . $e->getTraceAsString());
        }

        // Return with success message
        return redirect()->route('bootcamp')
            ->with('success', 'Thank you! We have received your bootcamp request. Our team will contact you within 24 hours.');
    }
}