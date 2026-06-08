<?php

namespace App\Mail;

use App\Models\OfferLetter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class OfferLetterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public OfferLetter $offer,
        public string $prefix,
        public string $pdfContent  // raw PDF bytes
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Offer Letter - ' . $this->offer->designation . ' at Axvero',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'offer-letter.mail',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => $this->pdfContent,
                'Appointment_Letter_' . str_replace(' ', '_', $this->offer->full_name) . '.pdf'
            )->withMime('application/pdf'),
        ];
    }
}