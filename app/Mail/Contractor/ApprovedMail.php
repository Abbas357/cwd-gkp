<?php
namespace App\Mail\Contractor;

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
            view: 'emails.contractor.approved',
            with: [
                'name' => $this->registration->contractor->name,
                'firm_name' => $this->registration->contractor->firm_name,
                'pec_number' => $this->registration->pec_number,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
