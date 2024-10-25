<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StandardizationAppliedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $standardization;

    public function __construct($standardization)
    {
        $this->standardization = $standardization;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contractor standardization Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.standardization.applied',
            with: [
                'product_name' => $this->standardization->product_name,
                'firm_name' => $this->standardization->firm_name,
                'specification_details' => $this->standardization->specification_details,
                'applied_date' => now()->format('Y-m-d'),
                'email' => $this->standardization->email,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
