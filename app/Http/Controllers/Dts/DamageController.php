<?php

namespace App\Http\Controllers\Dts;

use App\Models\Damage;
use Illuminate\Http\Request;
use App\Models\Infrastructure;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreDamageRequest;
use App\Http\Controllers\Dts\Enum\RoadStatus;
use App\Http\Controllers\Dts\Enum\DamageNature;
use App\Http\Controllers\Dts\Enum\DamageStatus;
use App\Http\Controllers\Dts\Enum\InfrastructureType;

class DamageController extends Controller
{
    public function index(Request $request)
    {
        $damage = Damage::query();

        if ($request->ajax()) {
            $dataTable = Datatables::of($damage)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.dts.damages.partials.buttons', compact('row'))->render();
                })
                ->addColumn('name', function ($row) {
                    return $row->infrastructure?->name;
                })
                ->editColumn('user', function ($row) {
                    return $row->user ? $row->user->currentPosting->office->name : '-';
                })
                ->editColumn('report_date', function ($row) {
                    return $row->report_date->format('j, F Y');
                })
                ->editColumn('damage_nature', function ($row) {
                    return implode(', ', json_decode($row->damage_nature)) ?? '-';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
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

        return view('modules.dts.damages.index');
    }

    public function create()
    {
        $cat = [
            'infrastructure_type' => array_map(function ($case) {
                return $case->value;
            }, InfrastructureType::cases()),
            'damage_status'  => array_map(function ($case) {
                return $case->value;
            }, DamageStatus::cases()),
            'road_status'    => array_map(function ($case) {
                return $case->value;
            }, RoadStatus::cases()),
            'damage_nature'  => array_map(function ($case) {
                return $case->value;
            }, DamageNature::cases()),
        ];

        $html =  view('modules.dts.damages.partials.create', compact('cat'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreDamageRequest $request)
    {
        $inputs = [
            'report_date',
            'type',
            'infrastructure_id',
            'damaged_length',
            'damage_east_start',
            'damage_north_start',
            'damage_east_end',
            'damage_north_end',
            'damage_status',
            'approximate_restoration_cost',
            'approximate_rehabilitation_cost',
            'road_status',
            'remarks'
        ];

        $damage = new Damage();
        foreach ($inputs as $input) {
            $damage->$input = $request->$input;
        }
        $damage->activity = $this->currentActivity();
        $damage->session = $this->currentSession();
        $damage->damage_nature = json_encode($request->damage_nature);
        $damage->user_id = Auth::id();

        if ($damage->save()) {
            return response()->json(['success' => 'Damage added successfully']);
        } else {
            return response()->json(['error' => 'There is an error adding the damage']);
        }
    }

    public function show(Damage $damage)
    {
        return response()->json($damage);
    }

    public function showDetail(Damage $damage)
    {
        if (!$damage) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Damage Detail',
                ],
            ]);
        }

        $cat = [
            'infrastructure_type' => array_map(function ($case) {
                return $case->value;
            }, InfrastructureType::cases()),
            'damage_status'  => array_map(function ($case) {
                return $case->value;
            }, DamageStatus::cases()),
            'road_status'    => array_map(function ($case) {
                return $case->value;
            }, RoadStatus::cases()),
            'damage_nature'  => array_map(function ($case) {
                return $case->value;
            }, DamageNature::cases()),
        ];

        $html = view('modules.dts.damages.partials.detail', compact('damage', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Damage $damage)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $damage->{$request->field} = $request->value;

        if ($damage->isDirty($request->field)) {
            $damage->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }
        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy(Damage $damage)
    {
        if ($damage->delete()) {
            return response()->json(['success' => 'Damage has been deleted successfully.']);
        }
        return response()->json(['error' => 'Error deleting damage.']);
    }

    private function currentActivity()
    {
        // $setting = \App\Models\Setting::first();
        // if ($setting) {
        //     return $setting->app_activity;
        // }
        return 'Monsoon';
    }

    private function currentSession()
    {
        // $setting = \App\Models\Setting::first();
        // if ($setting) {
        //     return $setting->app_session;
        // }
        return date('Y');
    }

    private function saveInfrastructure($request)
    {
        if ($request->filled('missing_infrastructure')) {
            $infrastructure = new Infrastructure();
            $infrastructure->type = $request->type;
            $infrastructure->name = $request->missing_infrastructure;
        } else {
            $infrastructure = Infrastructure::find($request->infrastructure_id);
            Damage::where('infrastructure_id', $infrastructure->id)->update(['total_length' => $request->total_length]);
        }
        $infrastructure->length = $request->total_length;
        $infrastructure->east_start_coordinate = $request->east_start_coordinate;
        $infrastructure->north_start_coordinate = $request->north_start_coordinate;
        $infrastructure->east_end_coordinate = $request->east_end_coordinate;
        $infrastructure->north_end_coordinate = $request->north_end_coordinate;
        $infrastructure->district_id = request()->user()->district->id;
        $infrastructure->save();

        return $infrastructure;
    }
}
