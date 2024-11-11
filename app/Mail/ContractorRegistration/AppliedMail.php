<?php
namespace App\Mail\ContractorRegistration;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppliedMail extends Mailable implements ShouldQueue
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
            subject: 'Contractor Registration Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration.applied',
            with: [
                'owner_name' => $this->registration->owner_name,
                'contractor_name' => $this->registration->contractor_name,
                'applied_date' => now()->format('Y-m-d'),
                'pec_number' => $this->registration->pec_number,
                'email' => $this->registration->email,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
