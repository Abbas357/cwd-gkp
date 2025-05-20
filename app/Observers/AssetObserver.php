<?php

namespace App\Observers;

use App\Models\Asset;
use App\Models\AssetAllotment;

class AssetObserver
{
    public function created(Asset $asset): void
    {
        AssetAllotment::create([
            'type' => 'Pool',
            'start_date' => now(),
            'asset_id' => $asset->id,
            'is_current' => 1,
            'office_id'  => session('office') ?? null,
        ]);
    }
}
