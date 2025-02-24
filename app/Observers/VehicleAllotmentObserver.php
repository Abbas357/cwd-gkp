<?php

namespace App\Observers;

use App\Models\VehicleAllotment;

class VehicleAllotmentObserver
{
    public function creating(VehicleAllotment $vehicleAllotment)
    {
        if ($vehicleAllotment->type === 'Pool' && !$vehicleAllotment->start_date) {
            $vehicleAllotment->start_date = now();
        }
        
        $vehicleAllotment->is_current = 1;
        
        $currentAllotment = VehicleAllotment::where('vehicle_id', $vehicleAllotment->vehicle_id)
            ->where('is_current', 1)
            ->first();

        if ($currentAllotment) {
            $currentAllotment->end_date = now();
            $currentAllotment->is_current = 0;
            $currentAllotment->save();
        }
    }
}
