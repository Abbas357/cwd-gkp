<?php

namespace App\Observers;

class StandardizationObserver
{
    public function updating($standardization)
    {
        if ($standardization->isDirty('status')) {
            $standardization->status_updated_at = now();
            $standardization->status_updated_by = request()->user()->id ?? null;
        }
        if ($standardization->isDirty('password')) {
            $standardization->password_updated_at = now();
        }
    }
}
