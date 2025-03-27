<?php

namespace App\Http\Controllers\Dts;

use App\Models\Infrastructure;
use App\Models\District;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInfrastructureRequest;

class InfrastructureController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $office = Infrastructure::query();

        $office->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($office)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.dts.infrastructures.partials.buttons', compact('row'))->render();
                })
                ->editColumn('parent_id', function ($row) {
                    return $row->parent ? $row->parent->name : '-';
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
                'withRelations' => ['parent', 'district'],
                'textFormat' => function($office) {
                    return $office->name . 
                        ($office->type ? ' (' . $office->type . ')' : '') .
                        ($office->parent ? ' - ' . $office->parent->name : '') . 
                        ($office->district ? ' [' . $office->district->name . ']' : '');
                },
                'searchRelations' => [
                    'parent' => ['name'],
                    'district' => ['name']
                ],
                'orderBy' => 'type',
                'conditions' => ['status' => 'Active']
            ]
        );
    }

    public function create()
    {
        $infrastructures = Infrastructure::where('status', 'Active')->get();
        $districts = District::whereDoesntHave('office')->get();
        $html =  view('modules.dts.infrastructures.partials.create', compact('infrastructures', 'districts'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreInfrastructureRequest $request)
    {
        try {
            $office = new Infrastructure();
            $office->name = $request->name;
            $office->type = $request->type;
            $office->parent_id = $request->parent_id;
            $office->district_id = $request->district_id;
            $office->save();
            
            return response()->json(['success' => 'Infrastructure added successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'There is an error adding the office: ' . $e->getMessage()]);
        }
    }

    public function show(Infrastructure $office)
    {
        return response()->json($office->load('district'));
    }

    public function showDetail(Infrastructure $office)
    {
        if (!$office) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Infrastructure Detail',
                ],
            ]);
        }

        $availableDistricts = District::whereDoesntHave('office')
            ->orWhere('id', $office->district_id)
            ->get();

        $cat = [
            'type' => ['Provincial', 'Regional', 'Divisional', 'District', 'Tehsil'],
            'infrastructures' => Infrastructure::where('status', 'Active')->get(),
            'districts' => $availableDistricts,
            'managedDistricts' => $office->getAllManagedDistricts()
        ];

        $html = view('modules.dts.infrastructures.partials.detail', compact('office', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Infrastructure $office)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        if ($request->field === 'district_id') {
            if ($request->value) {
                $districtAssigned = Infrastructure::where('district_id', $request->value)
                    ->where('id', '!=', $office->id)
                    ->exists();
                
                if ($districtAssigned) {
                    return response()->json(['error' => 'This district is already assigned to another office'], 422);
                }
            }
        }

        $office->{$request->field} = $request->value;

        if ($office->isDirty($request->field)) {
            $office->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function destroy(Infrastructure $office)
    {
        if ($office->delete()) {
            return response()->json(['success' => 'Infrastructure has been deleted successfully.']);
        }
        return response()->json(['error' => 'Error deleting office.']);
    }
}
