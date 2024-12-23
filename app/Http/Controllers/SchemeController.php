<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SchemeController extends Controller
{
    public function index()
    {
        $schemes = Scheme::all();
        return view('admin.schemes.index', compact('schemes'));
    }

    public function syncSchemesView()
    {
        return view('admin.schemes.sync');
    }

    public function syncSchemes(Request $request)
    {
        $year = $request->input('year');

        $token = $this->getAuthToken();

        $response = Http::withToken($token)->post('https://pcfms.pndkp.gov.pk:9002/api/pcfmsservices/getschemedata', [
            'YearID' => $year,
            'Task' => 'GetCnWData',
            'SchemeCode' => '',
        ]);

        if ($response->successful()) {
            $schemes = $response->json()['Data'];

            foreach ($schemes as $scheme) {
                Scheme::updateOrCreate(
                    ['scheme_code' => $scheme['SchemeCode']],
                    [
                        'adp_number' => $scheme['ADPNumber'],
                        'scheme_name' => $scheme['SchemeName'],
                        'sector_name' => $scheme['SectorName'],
                        'sub_sector_name' => $scheme['SubSectorName'],
                        'local_cost' => $scheme['LocalCost'],
                        'foreign_cost' => $scheme['ForeignCost'],
                        'previous_expenditure' => $scheme['previousExpenditure'],
                        'capital_allocation' => $scheme['CapitalAllocation'],
                        'revenue_allocation' => $scheme['RevenueAllocation'],
                        'total_allocation' => $scheme['TotalAllocation'],
                        'f_allocation' => $scheme['FAllocation'],
                        'tf' => $scheme['TF'],
                        'revised_allocation' => $scheme['RevisedAllocation'],
                        'prog_releases' => $scheme['ProgReleases'],
                        'progressive_exp' => $scheme['ProgressiveExp'],
                    ]
                );
            }

            return response()->json(['message' => 'Data synced successfully!']);
        }

        return response()->json(['error' => 'Failed to sync data.'], 500);
    }

    private function getAuthToken()
    {
        $response = Http::asForm()->post(env('PND_AUTH_URL'), [
            'grant_type' => 'password',
            'UserName' => env('PND_AUTH_USERNAME'),
            'Password' => env('PND_AUTH_PASSWORD'),
        ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to retrieve auth token');
    }

}
