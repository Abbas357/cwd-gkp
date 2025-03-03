<?php

namespace App\Observers;

use App\Models\MachineryAllocation;

class MachineryAllocationObserver
{
    public function creating(MachineryAllocation $MachineryAllocation)
    {
        if ($MachineryAllocation->type === 'Pool' && !$MachineryAllocation->start_date) {
            $MachineryAllocation->start_date = now();
        }
        
        $MachineryAllocation->is_current = 1;
        
        $currentAllocation = MachineryAllocation::where('machinery_id', $MachineryAllocation->machinery_id)
            ->where('is_current', 1)
            ->first();

        if ($currentAllocation) {
            $currentAllocation->end_date = now();
            $currentAllocation->is_current = 0;
            $currentAllocation->save();
        }
    }
}
