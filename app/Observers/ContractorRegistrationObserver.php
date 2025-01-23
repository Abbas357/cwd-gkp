<?php

namespace App\Observers;

use App\Models\Card;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\ContractorRegistration;

class ContractorRegistrationObserver
{
    public function updated(ContractorRegistration $contractorRegistration): void
    {
        if (
            $contractorRegistration->wasChanged('status') && 
            $contractorRegistration->status === 'approved'
        ) {
            $contractorRegistration->cards()->update([
                'status' => 'expired',
                'expiry_date' => now()
            ]);

            $card = new Card();
            $card->uuid = Str::uuid();
            $card->cardable_type = get_class($contractorRegistration);
            $card->cardable_id = $contractorRegistration->id;
            $card->issue_date = now();
            $card->expiry_date = now()->addYear();
            $card->status = 'active';
            $card->save();
        }
    }

    public function updating($model)
    {
        if ($model->isDirty('status')) {
            $model->status_updated_at = now();
            $model->status_updated_by = Auth::id() ?? null;
        }
    }
}
