<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

abstract class Controller
{
    public function slug(string $title): string {
        $new_title = implode(' ', array_slice(explode(' ', $title), 0, 5));
        return Str::slug($new_title) . '-' . substr(uniqid('', true), -6) . '-' . date('Y-m-d');
    }

    public function incrementViews($model, $column = 'views_count', $sessionKeyPrefix = null)
    {
        $ipAddress = request()->ip();
        $modelClass = class_basename(get_class($model));
        $sessionKeyPrefix = $sessionKeyPrefix ?? strtolower($modelClass);
        $sessionKey = $sessionKeyPrefix . '_' . $model->id . '_' . md5($ipAddress);

        if (!session()->has($sessionKey)) {
            $model->increment($column);
            session()->put($sessionKey, true);
        }
    }
}
