<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function envelope(): Envelope
    {
        $service = $this->booking->service_type ?: 'United Universe Express';

        return new Envelope(
            subject: 'New Booking Request: ' . $service,
            replyTo: [new Address($this->booking->email, $this->booking->name)],
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.booking');
    }
}
