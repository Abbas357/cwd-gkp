<?php
namespace App\Mail\ContractorRegistration;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeferredSecondMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $registration;
    public $deferred_reason;

    public function __construct($registration, $deferred_reason)
    {
        $this->registration = $registration;
        $this->deferred_reason = $deferred_reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contractor Registration Deferred - Second Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration.second-deferment',
            with: [
                'owner_name' => $this->registration->owner_name,
                'contractor_name' => $this->registration->contractor_name,
                'pec_number' => $this->registration->pec_number,
                'deferred_reason' => $this->deferred_reason,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
