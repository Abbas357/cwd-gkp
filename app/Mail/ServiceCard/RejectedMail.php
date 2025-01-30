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
    public $remarks;

    public function __construct($service_card, $remarks)
    {
        $this->service_card = $service_card;
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
            view: 'emails.service_card.rejected',
            with: [
                'name' => $this->service_card->name,
                'father_name' => $this->service_card->father_name,
                'personnel_number' => $this->service_card->personnel_number,
                'remarks' => $this->remarks,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
