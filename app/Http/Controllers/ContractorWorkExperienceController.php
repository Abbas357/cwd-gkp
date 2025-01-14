<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;
use App\Models\ContractorWorkExperience;

class ContractorWorkExperienceController extends Controller
{
    public function detail(Contractor $Contractor)
    {
        $experience = $Contractor->workExperiences()->get();

        if (!$experience) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load experience detail',
                ],
            ]);
        }
        $html = view('admin.contractors.partials.machinery', compact('experience'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
}
