<?php

namespace App\Http\Controllers\dmis;

use App\Models\Damage;
use App\Http\Controllers\Controller;

class DamageLogController extends Controller
{
   public function getLogs($id)
    {
        $damage = Damage::with('logs')->findOrFail($id);
        
        $logs = $damage->logs->map(function ($log) {
            return [
                'id' => $log->id,
                'damaged_length' => $log->damaged_length,
                'damage_status' => $log->damage_status,
                'damage_nature' => $log->damage_nature ? implode(', ', json_decode($log->damage_nature)) : 'N/A',
                'approximate_restoration_cost' => $log->approximate_restoration_cost,
                'approximate_rehabilitation_cost' => $log->approximate_rehabilitation_cost,
                'created_at' => $log->created_at->format('j F Y, h:i A'),
            ];
        });
        
        return response()->json([
            'damage' => [
                'id' => $damage->id,
                'report_date' => $damage->report_date->format('j F Y'),
                'type' => $damage->type,
                'infrastructure_name' => $damage->infrastructure->name ?? 'No Infrastructure',
            ],
            'logs' => $logs
        ]);
    }
}
