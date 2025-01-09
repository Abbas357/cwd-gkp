<?php
namespace App\Mail\Contractor;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppliedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $contractor;

    public function __construct($contractor)
    {
        $this->contractor = $contractor;
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
            view: 'emails.contractor.applied',
            with: [
                'owner_name' => $this->contractor->owner_name,
                'contractor_name' => $this->contractor->contractor_name,
                'applied_date' => now()->format('Y-m-d'),
                'pec_number' => $this->contractor->pec_number,
                'email' => $this->contractor->email,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
