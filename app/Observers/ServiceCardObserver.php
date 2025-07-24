<?php

namespace App\Observers;

use App\Models\ServiceCard;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceCard\RejectedMail;
use App\Mail\ServiceCard\VerifiedMail;

class ServiceCardObserver
{
    public function updated(ServiceCard $ServiceCard): void
    {
        // Check for approval_status changes
        if ($ServiceCard->wasChanged('approval_status')) {
            if ($ServiceCard->approval_status === 'verified') {
                $this->handleApproval($ServiceCard);
            } elseif ($ServiceCard->approval_status === 'rejected') {
                $this->handleRejection($ServiceCard);
            }
        }
    }

    protected function handleApproval(ServiceCard $ServiceCard): void
    {
        // Only handle email sending - let the controller handle the rest
        if ($ServiceCard->user && $ServiceCard->user->email) {
            Mail::to($ServiceCard->user->email)->queue(new VerifiedMail($ServiceCard));
        }
    }

    protected function handleRejection(ServiceCard $ServiceCard): void
    {
        // Send rejection email to the user
        if ($ServiceCard->user && $ServiceCard->user->email) {
            Mail::to($ServiceCard->user->email)->queue(new RejectedMail($ServiceCard, $ServiceCard->remarks));
        }
    }
}