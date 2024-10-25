<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MassNewsletterEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $emailContent;
    public $unsubscribeLink;

    public function __construct($emailContent, $unsubscribeLink)
    {
        $this->emailContent = $emailContent;
        $this->unsubscribeLink = $unsubscribeLink;
    }

    public function build()
    {
        return $this->subject('Newsletter Update')
            ->view('emails.newsletter.mass-email')
            ->with([
                'content' => $this->emailContent,
                'unsubscribeLink' => $this->unsubscribeLink,
            ]);
    }
}
