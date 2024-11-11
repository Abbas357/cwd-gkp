<?php

namespace App\Mail\Newsletter;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $unsubscribeUrl;

    public function __construct($unsubscribeToken)
    {
        $this->unsubscribeUrl = route('newsletter.unsubscribe', ['token' => $unsubscribeToken]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Newsletter Subscribed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.newsletter.confirmation',
            with: ['unsubscribeUrl' => $this->unsubscribeUrl],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
