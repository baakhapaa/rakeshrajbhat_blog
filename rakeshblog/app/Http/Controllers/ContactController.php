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

        // Send email
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

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }

    /**
     * Send the Bootcamp Request.
     */
    public function sendBootcamp(Request $request)
    {
        // 1. Validate the incoming data
        $validator = Validator::make($request->all(), [
            'org_name' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'required|string|max:20',
            'participants' => 'required|integer|min:1',
            'preferred_date' => 'required|date',
            'audience' => 'nullable|array',
            'requirements' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Prepare the data for the email
        $data = [
            'org_name' => $request->org_name,
            'district' => $request->district,
            'contact_person' => $request->contact_person,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'participants' => $request->participants,
            'preferred_date' => $request->preferred_date,
            'audience' => $request->audience ? implode(', ', $request->audience) : 'Not specified',
            'requirements' => $request->requirements ?? 'No additional requirements',
        ];

        // 3. Send the email
        Mail::send('emails.bootcamp', $data, function ($mail) use ($request) {
            $mail->to('admin@rakeshrajbhat.com')
                 ->subject('New Bootcamp Request: ' . $request->org_name)
                 ->replyTo($request->contact_email, $request->contact_person);
        });

        // 4. Redirect back with a success message
        return redirect()->route('bootcamp')->with('success', 'Your bootcamp request has been sent successfully! We will contact you within 24 hours.');
    }

    /**
     * Send Work With Me request.
     */
    public function sendWorkWithMe(Request $request)
    {
        $type = $request->type;

        // 1. Validate ALL inputs based on which form was submitted
        $validator = Validator::make($request->all(), array_merge([
            'type' => 'required|in:municipality,education,investor,partner,builder',
        ], $this->getValidationRules($type)));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Gather dynamic data based on type
        $data = $this->gatherFormData($type, $request);
        $data['type_label'] = ucwords(str_replace('_', ' ', $type));

        // 3. Send the email
        Mail::send('emails.work-with-me', $data, function ($mail) use ($request, $data) {
            $mail->to('admin@rakeshrajbhat.com')
                 ->subject('New Work With Me Request: ' . $data['type_label'])
                 ->replyTo($request->email ?? 'no-reply@example.com', $request->name ?? 'Sender');
        });

        // 4. Redirect back with success
        return redirect()->route('work-with-me')->with('success', 'Your message has been sent! I\'ll get back to you within 24 hours.');
    }

    /**
     * Helper to define validation rules per form type.
     */
    private function getValidationRules($type)
    {
        $common = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
        ];

        switch ($type) {
            case 'municipality':
                return array_merge($common, [
                    'org_name'          => 'required|string|max:255',
                    'district'          => 'required|string|max:255',
                    'interest'          => 'required|string',
                    'audience'          => 'nullable|array',
                    'participants'      => 'nullable|integer',
                    'preferred_date'    => 'nullable|date',
                    'requirements'      => 'nullable|string',
                ]);
            case 'education':
                return array_merge($common, [
                    'org_name'          => 'required|string|max:255',
                    'interest'          => 'required|string',
                    'target_audience'   => 'required|string',
                    'age_grade'         => 'nullable|string',
                    'participants'      => 'nullable|integer',
                    'preferred_date'    => 'nullable|date',
                    'requirements'      => 'nullable|string',
                ]);
            case 'investor':
                    return array_merge($base, [
                        'org_name'       => $request->organization ?? 'Not specified', // Change this
                        'investor_type'  => $request->investor_type ?? 'Not specified',
                        'exploration'    => $request->exploration ?? 'None',
                        'website'        => $request->website ?? 'Not provided',
                    ]);
            case 'partner':
                return array_merge($common, [
                    'org_name'          => 'required|string|max:255',
                    'website'           => 'nullable|url',
                    'collaboration_type'=> 'nullable|array',
                    'details'           => 'nullable|string',
                ]);
            case 'builder':
                return array_merge($common, [
                    'location'          => 'nullable|string|max:255',
                    'skills'            => 'nullable|string|max:255',
                    'portfolio'         => 'nullable|url',
                    'contribution_reason'=> 'nullable|string',
                ]);
            default:
                return $common;
        }
    }

    /**
     * Helper to gather clean email data per form type.
     */
    private function gatherFormData($type, $request)
    {
        $base = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone ?? 'Not provided',
        ];

        switch ($type) {
            case 'municipality':
                return array_merge($base, [
                    'org_name'       => $request->org_name,
                    'district'       => $request->district,
                    'interest'       => $request->interest,
                    'audience'       => $request->audience ? implode(', ', $request->audience) : 'Not specified',
                    'participants'   => $request->participants ?? 'Not specified',
                    'preferred_date' => $request->preferred_date ?? 'Not specified',
                    'requirements'   => $request->requirements ?? 'None',
                ]);
            case 'education':
                return array_merge($base, [
                    'org_name'       => $request->org_name,
                    'interest'       => $request->interest,
                    'target_audience'=> $request->target_audience,
                    'age_grade'      => $request->age_grade ?? 'Not specified',
                    'participants'   => $request->participants ?? 'Not specified',
                    'preferred_date' => $request->preferred_date ?? 'Not specified',
                    'requirements'   => $request->requirements ?? 'None',
                ]);
                case 'investor':
                return array_merge($base, [
                    'org_name'       => $request->organization ?? 'Not specified', // Change this
                    'investor_type'  => $request->investor_type ?? 'Not specified',
                    'exploration'    => $request->exploration ?? 'None',
                    'website'        => $request->website ?? 'Not provided',
                ]);
            case 'partner':
                return array_merge($base, [
                    'org_name'         => $request->org_name,
                    'website'          => $request->website ?? 'Not provided',
                    'collaboration_type'=> $request->collaboration_type ? implode(', ', $request->collaboration_type) : 'Not specified',
                    'details'          => $request->details ?? 'None',
                ]);
            case 'builder':
                return array_merge($base, [
                    'location'          => $request->location ?? 'Not specified',
                    'skills'            => $request->skills ?? 'Not specified',
                    'portfolio'         => $request->portfolio ?? 'Not provided',
                    'contribution_reason'=> $request->contribution_reason ?? 'None',
                ]);
            default:
                return $base;
        }
    }
}