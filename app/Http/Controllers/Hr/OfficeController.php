<?php

namespace App\Http\Controllers\Hr;

use App\Models\Office;
use App\Models\District;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfficeRequest;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $office = Office::with(['parent', 'district']);

        $office->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($office)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.hr.offices.partials.buttons', compact('row'))->render();
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

        return view('modules.hr.offices.index');
    }

    public function offices(Request $request)
    {
        return $this->getApiResults(
            $request, 
            Office::class, 
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
        $offices = Office::where('status', 'Active')->get();
        $districts = District::whereDoesntHave('office')->get();
        $officeTypes = ['Secretariat', 'Provincial', 'Regional', 'Authority', 'Project', 'Divisional', 'District', 'Tehsil'];
        $html =  view('modules.hr.offices.partials.create', compact('offices', 'districts', 'officeTypes'))->render();

        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreOfficeRequest $request)
    {
        try {
            $office = new Office();
            $office->name = $request->name;
            $office->type = $request->type;
            $office->contact_number = $request->contact_number;
            $office->parent_id = $request->parent_id;
            $office->district_id = $request->district_id;
            $office->job_description = $request->job_description;
            $office->save();
            
            return response()->json(['success' => 'Office added successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'There is an error adding the office: ' . $e->getMessage()]);
        }
    }

    public function show(Office $office)
    {
        return response()->json($office->load('district'));
    }

    public function showDetail(Office $office)
    {
        if (!$office) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Office Detail',
                ],
            ]);
        }

        $availableDistricts = District::whereDoesntHave('office')
            ->orWhere('id', $office->district_id)
            ->get();
        $cat = [
            'type' => ['Provincial', 'Regional', 'Divisional', 'District', 'Tehsil'],
            'offices' => Office::where('status', 'Active')->get(),
            'districts' => $availableDistricts,
            'managedDistricts' => $office->getAllManagedDistricts(),
            'officeTypes' => ['Secretariat', 'Provincial', 'Regional', 'Authority', 'Project', 'Divisional', 'District', 'Tehsil'],
        ];

        $html = view('modules.hr.offices.partials.detail', compact('office', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Office $office)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required',
        ]);

        if ($request->field === 'district_id') {
            // Validate that the district isn't already assigned to another office
            if ($request->value) {
                $districtAssigned = Office::where('district_id', $request->value)
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

    public function activateOffice(Request $request, Office $office)
    {
        if ($office->status === 'Active') {
            $office->status = 'Inactive';
            $message = 'Office deactivated successfully.';
        } else {
            $office->status = 'Active';
            $message = 'Office activated successfully.';
        }
        $office->save();
        return response()->json(['success' => $message], 200);
    }

    public function destroy(Office $office)
    {
        if ($office->delete()) {
            return response()->json(['success' => 'Office has been deleted successfully.']);
        }
        return response()->json(['error' => 'Error deleting office.']);
    }
}
