<?php
namespace App\Mail\Query;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmittedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $public_contact;

    public function __construct($public_contact)
    {
        $this->public_contact = $public_contact;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your message is submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.public_contact.submitted',
            with: [
                'name' => $this->public_contact->name,
                'submission_date' => now()->format('Y-m-d'),
                'cnic' => $this->public_contact->cnic,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
