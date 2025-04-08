<?php

namespace App\Http\Controllers\Dts;

use Illuminate\Http\Request;
use App\Models\Infrastructure;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInfrastructureRequest;
use App\Models\District;

class InfrastructureController extends Controller
{
    public function index(Request $request)
    {
        $infrastructure = Infrastructure::query();

        if ($request->ajax()) {
            $dataTable = Datatables::of($infrastructure)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.dts.infrastructures.partials.buttons', compact('row'))->render();
                })
                ->addColumn('district', function ($row) {
                    return $row->district ? $row->district->name : '-';
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

        return view('modules.dts.infrastructures.index');
    }
    
    public function infrastructures(Request $request)
    {
        return $this->getApiResults(
            $request, 
            Infrastructure::class, 
            [
                'searchColumns' => ['name', 'type'],
                'withRelations' => ['district'],
                'textFormat' => function($infrastructure) {
                    return $infrastructure->name . 
                        ($infrastructure->district ? ' [' . $infrastructure->district->name . ']' : '');
                },
                'searchRelations' => [
                    'district' => ['name']
                ],
                'orderBy' => 'name',
                'conditions' => $request->has('type') && !empty($request->type) ? ['type' => $request->type] : []
            ]
        );
    }

    public function create()
    {
        $cat = [
            'districts' => request()->user()->districts()->count() > 0
            ? request()->user()->districts()
            : \App\Models\District::all(),
        ];

        $html =  view('modules.dts.infrastructures.partials.create', compact('cat'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }
 
    public function store(StoreInfrastructureRequest $request)
    {
        $inputs = [
            'type', 'name', 'length', 'east_start_coordinate', 'north_start_coordinate', 'east_end_coordinate', 'north_end_coordinate', 'district_id'  
        ];

        $infrastructure = new Infrastructure;
        foreach ($inputs as $input) {
            $infrastructure->$input = $request->$input;
        }
        if ($infrastructure->save()) {
            return response()->json(['success' => $infrastructure->type . ' successfully added']);
        } else {
            return response()->json(['error' => 'Failed to add ' . $infrastructure->type]);
        }
    }

    public function show(Infrastructure $infrastructure)
    {
        return response()->json($infrastructure);
    }

    public function showDetail(Infrastructure $infrastructure)
    {
        $districts = District::all();
        
        if (!$infrastructure) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Infrastructure Detail',
                ],
            ]);
        }

        $html = view('modules.dts.infrastructures.partials.detail', compact('infrastructure', 'districts'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Infrastructure $infrastructure)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $infrastructure->{$request->field} = $request->value;

        if ($infrastructure->isDirty($request->field)) {
            $infrastructure->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }
        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy(Infrastructure $infrastructure)
    {
        if ($infrastructure->delete()) {
            return response()->json(['success' => 'Infrastructure has been deleted successfully.']);
        }
        return response()->json(['error' => 'Error deleting infrastructure.']);
    }
}
