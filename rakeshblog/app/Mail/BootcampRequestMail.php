<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BootcampRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $org_name;
    public $district;
    public $contact_person;
    public $contact_email;
    public $contact_phone;
    public $participants;
    public $preferred_date;
    public $audience;
    public $requirements;
    public $id;

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        // Debug: Log the data received
        \Log::info('BootcampRequestMail constructor called with data: ' . json_encode($data));
        
        $this->org_name = $data['org_name'] ?? 'N/A';
        $this->district = $data['district'] ?? 'N/A';
        $this->contact_person = $data['contact_person'] ?? 'N/A';
        $this->contact_email = $data['contact_email'] ?? 'N/A';
        $this->contact_phone = $data['contact_phone'] ?? 'N/A';
        $this->participants = $data['participants'] ?? 'N/A';
        $this->preferred_date = $data['preferred_date'] ?? 'N/A';
        $this->audience = $data['audience'] ?? 'N/A';
        $this->requirements = $data['requirements'] ?? 'No requirements provided';
        $this->id = $data['id'] ?? null;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // Debug: Log that the build method is called
        \Log::info('Building email for: ' . $this->org_name);
        
        return $this->subject('New Bootcamp Request - ' . $this->org_name)
                    ->view('emails.bootcamp-request')
                    ->with([
                        'org_name' => $this->org_name,
                        'district' => $this->district,
                        'contact_person' => $this->contact_person,
                        'contact_email' => $this->contact_email,
                        'contact_phone' => $this->contact_phone,
                        'participants' => $this->participants,
                        'preferred_date' => $this->preferred_date,
                        'audience' => $this->audience,
                        'requirements' => $this->requirements,
                        'id' => $this->id,
                    ]);
    }
}