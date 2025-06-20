<?php

namespace App\Observers;

use App\Models\Machinery;
use App\Models\MachineryAllocation;

class MachineryObserver
{
    public function created(Machinery $Machinery): void
    {
        MachineryAllocation::create([
            'type' => 'Pool',
            'start_date' => now(),
            'machinery_id' => $Machinery->id,
            'is_current' => 1,
        ]);
    }
}
