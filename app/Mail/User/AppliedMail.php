<?php
namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppliedMail extends Mailable implements ShouldQueue
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
            subject: 'Card Application Submitted',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user.applied',
            with: [
                'name' => $this->user->name,
                'father_name' => $this->user->father_name,
                'personnel_number' => $this->user->personnel_number,
                'applied_date' => now()->format('Y-m-d'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
