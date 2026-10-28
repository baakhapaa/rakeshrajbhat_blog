<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $name,
        public string $otp,
        public int $expiresMinutes = 10,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your sign-in code for Rakesh Rajbhat',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.password-reset-otp',
            text: 'emails.password-reset-otp-text',
            with: [
                'name' => $this->name,
                'otp' => $this->otp,
                'expiresMinutes' => $this->expiresMinutes,
                'siteUrl' => rtrim(config('app.url'), '/'),
            ],
        );
    }
}
