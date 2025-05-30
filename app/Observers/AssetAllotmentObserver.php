<?php

namespace App\Observers;

use App\Models\AssetAllotment;
use Illuminate\Support\Facades\DB;

class AssetAllotmentObserver
{
    public function creating(AssetAllotment $allotment): void
    {
        $allotment->is_current = true;
    }

    public function created(AssetAllotment $allotment): void
    {
        AssetAllotment::where('asset_id', $allotment->asset_id)
            ->where('id', '!=', $allotment->id)
            ->where('is_current', true)
            ->update([
                'is_current' => false,
                'end_date' => DB::raw('CASE WHEN end_date IS NULL THEN CURRENT_DATE ELSE end_date END')
            ]);
    }
}
