<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReceived extends Mailable
{
    use Queueable, SerializesModels;

    // Note: do NOT name this property "$message" — that variable is reserved
    // by Laravel inside mail views for the underlying Mail\Message instance.
    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Contact Message: ' . $this->contactMessage->subject,
            replyTo: [new Address($this->contactMessage->email, $this->contactMessage->full_name)],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.contact');
    }
}
