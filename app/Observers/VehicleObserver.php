<?php

namespace App\Observers;

use App\Models\Vehicle;
use App\Models\VehicleAllotment;

class VehicleObserver
{
    public function created(Vehicle $vehicle): void
    {
        VehicleAllotment::create([
            'type' => 'Pool',
            'start_date' => now(),
            'vehicle_id' => $vehicle->id,
            'is_current' => 1,
            'office_id'  => session('office') ?? null,
        ]);
    }
}
