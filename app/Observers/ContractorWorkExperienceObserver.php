<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class ContractorWorkExperienceObserver
{
    public function updating($experience)
    {
        if ($experience->isDirty('status')) {
            $experience->status_updated_at = now();
            $experience->status_updated_by = Auth::id() ?? null;
        }
    }
}
