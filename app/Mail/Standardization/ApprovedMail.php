<?php
namespace App\Mail\Standardization;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $Standardization;

    public function __construct($Standardization)
    {
        $this->Standardization = $Standardization;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Firm is approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.standardization.approved',
            with: [
                'firm_name' => $this->Standardization->firm_name,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
