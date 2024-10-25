<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QueryDroppedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $public_contact;
    public $remarks;

    public function __construct($public_contact, $remarks)
    {
        $this->public_contact = $public_contact;
        $this->remarks = $remarks;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Complaint / Message is Dropped',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.public_contact.dropped',
            with: [
                'name' => $this->public_contact->name,
                'submission_date' => now()->format('Y-m-d'),
                'cnic' => $this->public_contact->cnic,
                'remarks' => $this->remarks,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
