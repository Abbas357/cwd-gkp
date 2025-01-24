<?php
namespace App\Mail\Contractor;

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
    public $remarks;

    public function __construct($registration, $remarks)
    {
        $this->registration = $registration;
        $this->remarks = $remarks;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Registration Deferred - Second Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contractor.second-deferment',
            with: [
                'name' => $this->registration->contractor->name,
                'firm_name' => $this->registration->contractor->firm_name,
                'pec_number' => $this->registration->pec_number,
                'remarks' => $this->remarks,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
