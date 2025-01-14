<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;
use App\Models\ContractorMachinery;

class ContractorMachineryController extends Controller
{
    public function detail(Contractor $Contractor)
    {
        $machinery = $Contractor->machinery()->get();

        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load machinery detail',
                ],
            ]);
        }
        $html = view('admin.contractors.partials.machinery', compact('machinery'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
}
