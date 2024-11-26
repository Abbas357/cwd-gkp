<?php
namespace App\Mail\ServiceCard;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $service_card;
    public $rejected_reason;

    public function __construct($service_card, $rejected_reason)
    {
        $this->service_card = $service_card;
        $this->rejected_reason = $rejected_reason;
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
            view: 'emails.service_card.rejected',
            with: [
                'name' => $this->service_card->name,
                'father_name' => $this->service_card->father_name,
                'personnel_number' => $this->service_card->personnel_number,
                'rejected_reason' => $this->rejected_reason,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
