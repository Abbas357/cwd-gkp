<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Str;
use App\Models\Standardization;
use Illuminate\Support\Facades\Mail;
use App\Mail\Standardization\ApprovedMail;

class StandardizationObserver
{
    public function updated(Standardization $Standardization): void
    {
        if ($Standardization->wasChanged('status')) {
            if ($Standardization->status === 'approved') {
                $this->handleApproval($Standardization);
            } elseif ($Standardization->status === 'rejected') {
                $this->handleRejection($Standardization);
            }
        }
    }

    public function updating($Standardization)
    {
        if ($Standardization->isDirty('status')) {
            $Standardization->status_updated_at = now();
            $Standardization->status_updated_by = request()->user()->id ?? null;
        }
        if ($Standardization->isDirty('password')) {
            $Standardization->password_updated_at = now();
        }
    }

    protected function handleApproval(Standardization $Standardization): void
    {
        $Standardization->cards()->update([
            'status' => 'expired',
            'expiry_date' => now(),
        ]);

        if ($Standardization->contractor->email) {
            Mail::to($Standardization->contractor->email)->queue(new ApprovedMail($Standardization));
        }

        Card::create([
            'uuid' => Str::uuid(),
            'cardable_type' => get_class($Standardization),
            'cardable_id' => $Standardization->id,
            'issue_date' => now(),
            'expiry_date' => now()->addYear(),
            'status' => 'active',
        ]);
    }

    protected function handleRejection(Standardization $Standardization): void
    {
        $mailClass = match ($Standardization->status) {
            'deffered_once' => DeferredFirstMail::class,
            'deffered_twice' => DeferredSecondMail::class,
            'deffered_thrice' => DeferredThirdMail::class,
            default => null,
        };

        $contractorEmail = $Standardization->contractor->email;
        if ($mailClass && $contractorEmail) {
            if ($contractorEmail) {
                Mail::to($contractorEmail)->queue(new $mailClass($Standardization, $Standardization->remarks));
            }
        }
    }

}
