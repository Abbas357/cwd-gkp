<?php
namespace App\Mail\Contractor;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeferredFirstMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $contractor;
    public $deferred_reason;

    public function __construct($contractor, $deferred_reason)
    {
        $this->contractor = $contractor;
        $this->deferred_reason = $deferred_reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contractor Registration Deferred - First Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contractor.first-deferment',
            with: [
                'owner_name' => $this->contractor->owner_name,
                'contractor_name' => $this->contractor->contractor_name,
                'pec_number' => $this->contractor->pec_number,
                'deferred_reason' => $this->deferred_reason,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
