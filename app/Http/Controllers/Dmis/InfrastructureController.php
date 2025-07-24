<?php

namespace App\Http\Controllers\dmis;

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
        $type = $request->query('type', 'Road');
        $infrastructure = Infrastructure::query();

        $infrastructure->when($type !== null, function ($query) use ($type) {
            $query->where('type', $type);
        });
        
        $userDistricts = auth_user()->districts();
    
        if ($userDistricts->isNotEmpty()) {
            $districtIds = $userDistricts->pluck('id')->toArray();
            $infrastructure->whereIn('district_id', $districtIds);
        }

        if ($request->ajax()) {
            $dataTable = Datatables::of($infrastructure)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.dmis.infrastructures.partials.buttons', compact('row'))->render();
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

        return view('modules.dmis.infrastructures.index');
    }
    
    public function infrastructures(Request $request)
    {
        $conditions = [];
        $userDistricts = auth_user()->districts();
        
        if ($request->has('type') && !empty($request->type)) {
            $conditions['type'] = $request->type;
        }
        
        if ($request->has('district_id') && !empty($request->district_id)) {
            $conditions['district_id'] = $request->district_id;
        }
        
        if ($userDistricts->count() > 0) {
            $districtIds = $userDistricts->pluck('id')->toArray();
            
            $query = Infrastructure::query();
            
            if (!empty($conditions['type'])) {
                $query->where('type', $conditions['type']);
            }
            
            if (!empty($conditions['district_id'])) {
                if (in_array($conditions['district_id'], $districtIds)) {
                    $query->where('district_id', $conditions['district_id']);
                } else {
                    return response()->json([
                        'results' => [],
                        'pagination' => ['more' => false]
                    ]);
                }
            } else {
                $query->whereIn('district_id', $districtIds);
            }
            
            if ($request->q) {
                $query->where(function($q) use ($request) {
                    $q->orWhere('name', 'like', "%{$request->q}%");
                    $q->orWhere('type', 'like', "%{$request->q}%");
                    $q->orWhereHas('district', function($subQuery) use ($request) {
                        $subQuery->where('name', 'like', "%{$request->q}%");
                    });
                });
            }
            
            $query->with(['district']);
            $query->orderBy('name', 'asc');
            
            $results = $query->paginate(10);
            
            return response()->json([
                'results' => collect($results->items())->map(function($infrastructure) {
                    return [
                        'id' => $infrastructure->id,
                        'text' => $infrastructure->name . 
                            ($infrastructure->district ? ' [' . $infrastructure->district->name . ']' : '')
                    ];
                }),
                'pagination' => [
                    'more' => $results->hasMorePages()
                ]
            ]);
        }
        
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
                'conditions' => $conditions
            ]
        );
    }

    public function create()
    {
        $userDistricts = auth_user()->districts();
        $cat = [
            'districts' => auth_user()->districts()->count() > 0
            ? auth_user()->districts()
            : \App\Models\District::all(),
        ];

        $html =  view('modules.dmis.infrastructures.partials.create', compact('cat'))->render();

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
        $userDistricts = auth_user()->districts();
    
        if ($request->filled('district_id')) {
            $infrastructure->district_id = $request->district_id;
        } else {
            if ($userDistricts->count() === 1) {
                $infrastructure->district_id = $userDistricts->first()->id;
            } else {
                return response()->json(['error' => 'Please select a district']);
            }
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

        $html = view('modules.dmis.infrastructures.partials.detail', compact('infrastructure', 'districts'))->render();
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
