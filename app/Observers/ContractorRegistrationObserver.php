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
    public function updated(ContractorRegistration $contractor_registration): void
    {
        if ($contractor_registration->wasChanged('status')) {
            if ($contractor_registration->status === 'approved') {
                $this->handleApproval($contractor_registration);
            } elseif (in_array($contractor_registration->status, ['deffered_once', 'deffered_twice', 'deffered_thrice'])) {
                $this->handleDeferral($contractor_registration);
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

    protected function handleApproval(ContractorRegistration $contractor_registration): void
    {
        $contractor_registration->cards()->update([
            'status' => 'expired',
            'expiry_date' => now(),
        ]);

        if ($contractor_registration->contractor->email) {
            Mail::to($contractor_registration->contractor->email)->queue(new ApprovedMail($contractor_registration));
        }

        Card::create([
            'uuid' => Str::uuid(),
            'cardable_type' => get_class($contractor_registration),
            'cardable_id' => $contractor_registration->id,
            'issue_date' => now(),
            'expiry_date' => now()->addYear(),
            'status' => 'active',
        ]);
    }

    protected function handleDeferral(ContractorRegistration $contractor_registration): void
    {
        $mailClass = match ($contractor_registration->status) {
            'deffered_once' => DeferredFirstMail::class,
            'deffered_twice' => DeferredSecondMail::class,
            'deffered_thrice' => DeferredThirdMail::class,
            default => null,
        };

        $contractorEmail = $contractor_registration->contractor->email;
        if ($mailClass && $contractorEmail) {
            if ($contractorEmail) {
                Mail::to($contractorEmail)->queue(new $mailClass($contractor_registration, $contractor_registration->remarks));
            }
        }
    }
}
