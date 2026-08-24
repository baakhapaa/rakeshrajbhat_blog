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
        return $this->subject('New Bootcamp Request - ' . $this->org_name)
                    ->view('emails.bootcamp-request');
    }
}