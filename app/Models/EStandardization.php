<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EStandardization extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::updating(function ($standardization) {
            if ($standardization->isDirty('approval_status')) {
                $action = 'approval';
                $oldStatus = $standardization->getOriginal('approval_status');
                $newStatus = $standardization->approval_status;

                EStandardizationLog::create([
                    'reg_id' => $standardization->id,
                    'action' => $action,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'action_by' => request()->user()->id,
                    'action_at' => now(),
                ]);
            }
        });
    }
}
