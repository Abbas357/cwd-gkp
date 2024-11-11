<?php
namespace App\Mail\ContractorRegistration;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $registration;

    public function __construct($registration)
    {
        $this->registration = $registration;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Registration is Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration.approved',
            with: [
                'owner_name' => $this->registration->owner_name,
                'contractor_name' => $this->registration->contractor_name,
                'pec_number' => $this->registration->pec_number,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
