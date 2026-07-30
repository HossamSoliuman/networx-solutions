<?php

namespace App\Mail;

use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HostingerTestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $requestedBy) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Networx Solutions email test',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.hostinger-test',
            with: [
                'siteName' => Setting::get('site_name', 'Networx Solutions'),
                'sentAt' => now(),
            ],
        );
    }
}
