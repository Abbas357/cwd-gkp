<?php

namespace App\Http\Controllers;

use App\Models\Scheme;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;

class SchemeController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year');
        $scheme_code = $request->input('scheme_code');
        $query = Scheme::query();

        $query->when($year !== null, function ($query) use ($year) {
            $query->where('year', $year);
        });

        $query->when($scheme_code !== null, function ($query) use ($scheme_code) {
            $query->where('scheme_code', $scheme_code);
        });

        if ($request->ajax()) {

            $dataTable =  DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.schemes.partials.buttons', compact('row'))->render();
                })
                ->rawColumns(['action']);
                
            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.schemes.index');
    }

    public function showDetail(Scheme $scheme)
    {
        $html = view('admin.schemes.partials.detail', compact('scheme'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function syncSchemesView()
    {
        return view('admin.schemes.sync');
    }

    public function syncSchemes(Request $request)
    {
        $year = $request->input('year');
        $scheme_code = $request->input('scheme_code');
        $token = $this->getAuthToken();

        $response = Http::withToken($token)->post('https://pcfms.pndkp.gov.pk:9002/api/pcfmsservices/getschemedata', [
            'YearID' => $year,
            'Task' => 'GetCnWData',
            'SchemeCode' => $scheme_code ?? '',
        ]);

        if ($response->successful()) {
            $schemes = $response->json()['Data'];

            foreach ($schemes as $scheme) {
                Scheme::updateOrCreate(
                    [
                        'scheme_code' => $scheme['SchemeCode'],
                        'year' => $year,
                    ],
                    [
                        'uuid' => Str::uuid(),
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

            return redirect()->back()->with('success', 'Data synced successfully!');
        }

        return redirect()->back()->with('error', 'Failed to sync data. Please try again later.');
    }

    private function getAuthToken()
    {
        $response = Http::asForm()->post(config('pnd.auth_url'), [
            'grant_type' => 'password',
            'UserName' => config('pnd.auth_username'),
            'Password' => config('pnd.auth_password'),
        ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        }

        throw new \Exception('Failed to retrieve auth token');
    }

}
