<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StandardizationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $standardization;
    public $rejected_reason;

    public function __construct($standardization, $rejected_reason)
    {
        $this->standardization = $standardization;
        $this->rejected_reason = $rejected_reason;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Product is rejected',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.standardization.rejected',
            with: [
                'product_name' => $this->standardization->product_name,
                'firm_name' => $this->standardization->firm_name,
                'specification_details' => $this->standardization->specification_details,
                'rejected_reason' => $this->rejected_reason,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
