<?php

namespace App\Observers;

class ContractorObserver
{
    public function updating($model) 
    {
        if ($model->isDirty('status')) {
            $model->status_updated_at = now();
            $model->status_updated_by = request()->user()->id ?? null;
        }
        if ($model->isDirty('password')) {
            $model->password_updated_at = now();
        }
    }
}
