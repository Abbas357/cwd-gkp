<?php

namespace App\Observers;

use App\Models\Card;
use App\Models\ServiceCard;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceCard\RejectedMail;
use App\Mail\ServiceCard\VerifiedMail;

class ServiceCardObserver
{
    public function updated(ServiceCard $ServiceCard): void
    {
        if ($ServiceCard->wasChanged('status')) {
            if ($ServiceCard->status === 'verified') {
                $this->handleApproval($ServiceCard);
            } elseif ($ServiceCard->status === 'rejected') {
                $this->handleRejection($ServiceCard);
            }
        }
    }

    protected function handleApproval(ServiceCard $ServiceCard): void
    {
        $ServiceCard->cards()->update([
            'status' => 'expired',
            'expiry_date' => now(),
        ]);

        if ($ServiceCard->email) {
            Mail::to($ServiceCard->email)->queue(new VerifiedMail($ServiceCard));
        }

        Card::create([
            'uuid' => Str::uuid(),
            'cardable_type' => get_class($ServiceCard),
            'cardable_id' => $ServiceCard->id,
            'issue_date' => now(),
            'expiry_date' => now()->addYear(),
            'status' => 'active',
        ]);
    }

    protected function handleRejection(ServiceCard $ServiceCard): void
    {
        if ($ServiceCard->email) {
            Mail::to($ServiceCard->email)->queue(new RejectedMail($ServiceCard, $ServiceCard->remarks));
        }
    }
}
