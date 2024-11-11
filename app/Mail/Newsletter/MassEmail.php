<?php

namespace App\Mail\Newsletter;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MassEmail extends Mailable implements ShouldQueue
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
