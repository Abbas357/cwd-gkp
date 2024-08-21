<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorRegistration extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::updating(function ($contractorRegistration) {
            if ($contractorRegistration->isDirty('defer_status')) {
                $action = 'deferment';
                $oldStatus = $contractorRegistration->getOriginal('defer_status');
                $newStatus = $contractorRegistration->defer_status;

                RegistrationsLog::create([
                    'reg_id' => $contractorRegistration->id,
                    'action' => $action,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'action_at' => now(),
                ]);
            }

            if ($contractorRegistration->isDirty('approval_status')) {
                $action = 'approval';
                $oldStatus = $contractorRegistration->getOriginal('approval_status');
                $newStatus = $contractorRegistration->approval_status;

                RegistrationsLog::create([
                    'reg_id' => $contractorRegistration->id,
                    'action' => $action,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'action_at' => now(),
                ]);
            }
        });
        
    }
}
