<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class ContractorMachineryObserver
{
    public function updating($machinery)
    {
        if ($machinery->isDirty('status')) {
            $machinery->status_updated_at = now();
            $machinery->status_updated_by = Auth::id() ?? null;
        }
    }
}
