<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $casts = [
        'action_at' => 'datetime',
    ];
    
    protected $fillable = [
        'loggable_id', 'loggable_type', 'action', 'field_name',
        'old_value', 'new_value', 'action_by', 'action_at'
    ];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
