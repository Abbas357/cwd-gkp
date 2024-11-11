<?php
namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $rejected_reason;

    public function __construct($user, $rejected_reason)
    {
        $this->user = $user;
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
            view: 'emails.user.rejected',
            with: [
                'name' => $this->user->name,
                'father_name' => $this->user->father_name,
                'personnel_number' => $this->user->personnel_number,
                'rejected_reason' => $this->rejected_reason,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
