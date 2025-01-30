<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Str;
use App\Models\Standardization;
use Illuminate\Support\Facades\Mail;
use App\Mail\Standardization\ApprovedMail;
use App\Mail\Standardization\RejectedMail;
use App\Mail\Standardization\BlacklistedMail;

class StandardizationObserver
{
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

    public function updated(Standardization $Standardization): void
    {
        if ($Standardization->wasChanged('status')) {
            if ($Standardization->status === 'approved') {
                $this->handleApproval($Standardization);
            } elseif (in_array($Standardization->status, ['rejected', 'blacklisted'])) {
                $this->handleRejection($Standardization);
            }
        }
    }

    protected function handleApproval(Standardization $Standardization): void
    {
        $Standardization->cards()->update([
            'status' => 'expired',
            'expiry_date' => now(),
        ]);

        if ($Standardization->email) {
            Mail::to($Standardization->email)->queue(new ApprovedMail($Standardization));
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
            'rejected' => RejectedMail::class,
            'blacklisted' => BlacklistedMail::class,
            default => null,
        };

        $email = $Standardization->email;
        if ($mailClass && $email) {
            if ($email) {
                Mail::to($email)->queue(new $mailClass($Standardization, $Standardization->remarks));
            }
        }
    }

}
