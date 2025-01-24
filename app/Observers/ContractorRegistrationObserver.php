<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contractor\ApprovedMail;
use App\Models\ContractorRegistration;
use App\Mail\Contractor\DeferredFirstMail;
use App\Mail\Contractor\DeferredThirdMail;
use App\Mail\Contractor\DeferredSecondMail;

class ContractorRegistrationObserver
{
    public function updated(ContractorRegistration $ContractorRegistration): void
    {
        if ($ContractorRegistration->wasChanged('status')) {
            if ($ContractorRegistration->status === 'approved') {
                $this->handleApproval($ContractorRegistration);
            } elseif (in_array($ContractorRegistration->status, ['deffered_once', 'deffered_twice', 'deffered_thrice'])) {
                $this->handleDeferral($ContractorRegistration);
            }
        }
    }

    public function updating($registration)
    {
        if ($registration->isDirty('status')) {
            $registration->status_updated_at = now();
            $registration->status_updated_by = Auth::id() ?? null;
        }
    }

    protected function handleApproval(ContractorRegistration $ContractorRegistration): void
    {
        $ContractorRegistration->cards()->update([
            'status' => 'expired',
            'expiry_date' => now(),
        ]);

        if ($ContractorRegistration->contractor->email) {
            Mail::to($ContractorRegistration->contractor->email)->queue(new ApprovedMail($ContractorRegistration));
        }

        Card::create([
            'uuid' => Str::uuid(),
            'cardable_type' => get_class($ContractorRegistration),
            'cardable_id' => $ContractorRegistration->id,
            'issue_date' => now(),
            'expiry_date' => now()->addYear(),
            'status' => 'active',
        ]);
    }

    protected function handleDeferral(ContractorRegistration $ContractorRegistration): void
    {
        $mailClass = match ($ContractorRegistration->status) {
            'deffered_once' => DeferredFirstMail::class,
            'deffered_twice' => DeferredSecondMail::class,
            'deffered_thrice' => DeferredThirdMail::class,
            default => null,
        };

        $contractorEmail = $ContractorRegistration->contractor->email;
        if ($mailClass && $contractorEmail) {
            if ($contractorEmail) {
                Mail::to($contractorEmail)->queue(new $mailClass($ContractorRegistration, $ContractorRegistration->remarks));
            }
        }
    }
}
