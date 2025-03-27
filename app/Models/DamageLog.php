<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamageLog extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function damage()
    {
        return $this->belongsTo(Damage::class, 'damage_id');
    }
}
