<?php

namespace App\Mail;

use App\Models\ContactReply;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public ContactReply $reply)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [new Address(
                Setting::get('contact_email', 'info@networx-solutions.com'),
                Setting::get('site_name', 'Networx Solutions'),
            )],
            subject: $this->reply->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-reply',
            with: [
                'reply' => $this->reply,
                'contactMessage' => $this->reply->contactMessage,
                'signature' => Setting::get('mail_signature'),
            ],
        );
    }
}
