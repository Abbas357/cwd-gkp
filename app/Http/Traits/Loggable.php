<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait Loggable
{
    public static function bootLoggable()
    {
        static::updating(function ($model) {
            $changedFields = $model->getDirty();
            $user = request()->user();
            foreach ($changedFields as $field => $newValue) {
                $oldValue = $model->getOriginal($field);
                $action = method_exists($model, 'getLogAction')
                    ? $model->getLogAction($field, $newValue)
                    : 'editing';

                ActivityLog::create([
                    'loggable_id' => $model->id,
                    'loggable_type' => get_class($model),
                    'action' => $action,
                    'field_name' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $newValue,
                    'action_by' => $user->id,
                    'action_at' => now(),
                ]);
            }
        });
    }
}
