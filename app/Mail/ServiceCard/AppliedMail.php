<?php
namespace App\Mail\ServiceCard;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppliedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $service_card;

    public function __construct($service_card)
    {
        $this->service_card = $service_card;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Card Application Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.service_card.applied',
            with: [
                'name' => $this->service_card->name,
                'father_name' => $this->service_card->father_name,
                'personnel_number' => $this->service_card->personnel_number,
                'applied_date' => now()->format('Y-m-d'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
