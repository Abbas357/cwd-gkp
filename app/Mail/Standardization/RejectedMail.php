<?php
namespace App\Mail\Standardization;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $Standardization;
    public $remarks;

    public function __construct($Standardization, $remarks)
    {
        $this->Standardization = $Standardization;
        $this->remarks = $remarks;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Application is rejected',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.standardization.rejected',
            with: [
                'firm_name' => $this->Standardization->firm_name,
                'remarks' => $this->remarks,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
