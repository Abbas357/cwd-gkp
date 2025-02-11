<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUser extends Model
{
    use HasFactory;
    
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    public function vehicleAllotments()
    {
        return $this->hasMany(VehicleAllotment::class, 'user_id');
    }
}
