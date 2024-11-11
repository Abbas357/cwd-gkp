<?php
namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RenewedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your card is Renewed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user.verified',
            with: [
                'name' => $this->user->name,
                'father_name' => $this->user->father_name,
                'personnel_number' => $this->user->personnel_number,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
