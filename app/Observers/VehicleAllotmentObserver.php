<?php

namespace App\Observers;

use App\Models\VehicleAllotment;
use Illuminate\Support\Facades\DB;

class VehicleAllotmentObserver
{
    public function creating(VehicleAllotment $allotment): void
    {
        $allotment->is_current = true;
    }

    public function created(VehicleAllotment $allotment): void
    {
        VehicleAllotment::where('vehicle_id', $allotment->vehicle_id)
            ->where('id', '!=', $allotment->id)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'end_date' => DB::raw('CASE WHEN end_date IS NULL THEN CURRENT_DATE ELSE end_date END')
            ]);
    }
}
