<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class ContractorHumanResourceObserver
{
    public function updating($resource)
    {
        if ($resource->isDirty('status')) {
            $resource->status_updated_at = now();
            $resource->status_updated_by = Auth::id() ?? null;
        }
    }
}
