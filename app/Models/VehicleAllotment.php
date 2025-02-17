<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleAllotment extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function allottedUser()
    {
        return $this->belongsTo(User::class, 'alloted_to');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
