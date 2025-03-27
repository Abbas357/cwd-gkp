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
                'damage_east_start' => $originalValues['damage_east_start'] ?? null,
                'damage_north_start' => $originalValues['damage_north_start'] ?? null,
                'damage_east_end' => $originalValues['damage_east_end'] ?? null,
                'damage_north_end' => $originalValues['damage_north_end'] ?? null,
                'damage_status' => $originalValues['damage_status'] ?? null,
                'damage_nature' => $originalValues['damage_nature'] ?? null,
                'approximate_restoration_cost' => $originalValues['approximate_restoration_cost'] ?? null,
                'approximate_rehabilitation_cost' => $originalValues['approximate_rehabilitation_cost'] ?? null,
                'road_status' => $originalValues['road_status'] ?? null,
                'remarks' => $originalValues['remarks'] ?? null,
                'user_id' => Auth::id(),
            ]);
        }
    }
}
