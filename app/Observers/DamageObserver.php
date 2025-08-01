<?php

namespace App\Observers;

use App\Models\Damage;
use App\Models\DamageLog;
use Illuminate\Support\Facades\Auth;

class DamageObserver
{
    public function updating(Damage $damage)
    {
        $changes = $damage->getDirty();
        if (count($changes) > 0) {
            $originalValues = $damage->getOriginal();

            DamageLog::create([
                'damage_id' => $damage->id,
                'damage_status' => $originalValues['damage_status'] ?? null,
                'damaged_length' => $originalValues['damaged_length'] ?? null,
                'damage_nature' => $originalValues['damage_nature'] ?? null,
                'approximate_restoration_cost' => $originalValues['approximate_restoration_cost'] ?? null,
                'approximate_rehabilitation_cost' => $originalValues['approximate_rehabilitation_cost'] ?? null,
                'road_status' => $originalValues['road_status'] ?? null,
                'remarks' => $originalValues['remarks'] ?? null,
            ]);
        }
    }
}
