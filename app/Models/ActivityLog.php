<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $casts = [
        'action_at' => 'datetime',
    ];
    
    protected $guarded = [];

    public function loggable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
