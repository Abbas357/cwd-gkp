<?php

namespace App\Observers;

use App\Models\VehicleAllotment;

class VehicleAllotmentObserver
{
    public function creating(VehicleAllotment $vehicleAllotment)
    {
        if ($vehicleAllotment->type === 'Pool') {
            $vehicleAllotment->start_date = now();
        }
        
        $latestAllotment = VehicleAllotment::where('vehicle_id', $vehicleAllotment->vehicle_id)
            ->whereNull('end_date')
            ->latest('created_at')
            ->first();

        if ($latestAllotment) {
            $latestAllotment->end_date = now();
            $latestAllotment->save();
        }
    }
}
