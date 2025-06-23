<?php

namespace App\Http\Controllers\Machinery;

use App\Helpers\Database;
use App\Models\Machinery;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMachineryRequest;

class MachineryController extends Controller
{
    protected $statuses = ['functional', 'condemned', 'repairable'];
    protected $fuel_types = ['diesel', 'petrol', 'electric', 'hybrid', 'other'];
    public function all(Request $request)
    {
        $machines = Machinery::query();

        $relationMappings = [
            'added_by' => 'user.currentPosting.designation.name',
            'assigned_to' => 'allocation.user.currentPosting.office.name'
        ];

        if ($request->ajax()) {
            $dataTable = Datatables::of($machines)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.machinery.partials.buttons', compact('row'))->render();
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user->currentPosting?->designation->name
                        ? '<a href="' . route('admin.apps.hr.users.show', $row->user->id) . '" target="_blank">' . $row->user->currentPosting?->designation->name . '</a>'
                        : ($row->user->currentPosting?->designation->name  ?? 'N/A');
                })
                ->addColumn('assigned_to', function ($row) {
                    return $row->allocation->user->currentPosting->office->name ?? 'Pool';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'added_by', 'user']);

            if ($request->input('search.value')) {
                Database::applyRelationalSearch($dataTable, $relationMappings);
            }

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request, $relationMappings) {
                    $sb = new SearchBuilder(
                        $request,
                        $query,
                        [],
                        $relationMappings,
                    );
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('modules.machinery.index');
    }

    public function create()
    {
        $html = view('modules.machinery.partials.create', ['statuses' => $this->statuses, 'fuel_types' => $this->fuel_types])->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreMachineryRequest $request)
    {
        $machinery = new Machinery();
        $machinery->type = $request->type;
        $machinery->functional_status = $request->functional_status;
        $machinery->brand = $request->brand;
        $machinery->model = $request->model;
        $machinery->registration_number = $request->registration_number;
        $machinery->model_year = $request->model_year;
        $machinery->fuel_type = $request->fuel_type;
        $machinery->engine_number = $request->engine_number;
        $machinery->chassis_number = $request->chassis_number;
        $machinery->user_id = $request->user()->id;
        $machinery->remarks = $request->remarks;

        if ($request->hasFile('front_view')) {
            $machinery->addMedia($request->file('front_view'))
                ->toMediaCollection('machinery_front_pictures');
        }

        if ($request->hasFile('side_view')) {
            $machinery->addMedia($request->file('side_view'))
                ->toMediaCollection('machinery_side_pictures');
        }

        if ($machinery->save()) {
            return response()->json(['success' => 'Machinery added successfully.']);
        }

        return response()->json(['error' => 'There was an error adding the machinery.']);
    }

    public function showDetail(Machinery $machinery)
    {
        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Machinery Detail',
                ],
            ]);
        }

        $html = view('modules.machinery.partials.detail', ['machinery' => $machinery, 'statuses' => $this->statuses, 'fuel_types' => $this->fuel_types])->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function machineryHistory(Machinery $machinery)
    {
        $allocations = $machinery->allocations;
        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Machinery History',
                ],
            ]);
        }

        $html = view('modules.machinery.partials.history', compact('machinery', 'allocations'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showMachineDetails(Machinery $machinery)
    {
        $allotments = $machinery->allocations()
            ->with(['user', 'user.currentPosting', 'user.currentPosting.designation', 'user.currentPosting.office'])
            ->orderBy('start_date', 'desc')
            ->get();

        $currentAllotment = $allotments->where('is_current', true)->first();

        if (!$machinery) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Details',
                ],
            ]);
        }

        $html = view('modules.machinery.partials.allotment-detail', compact('vehicle', 'allotments', 'currentAllotment'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Machinery $machinery)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $machinery->{$request->field} = $request->value;

        if ($machinery->isDirty($request->field)) {
            $machinery->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function updateMaintenanceInfo(Request $request, Machinery $machinery)
    {
        $request->validate([
            'operating_hours' => 'required|numeric',
            'fuel_type' => 'nullable|date',
            'next_maintenance_date' => 'nullable|date',
            'maintenance_notes' => 'nullable|string',
        ]);

        $machinery->operating_hours = $request->operating_hours;
        $machinery->fuel_type = $request->fuel_type;
        $machinery->next_maintenance_date = $request->next_maintenance_date;

        if ($request->has('maintenance_notes')) {
            $machinery->remarks = $machinery->remarks . "\n\nMaintenance (" . now()->format('Y-m-d') . "): " . $request->maintenance_notes;
        }

        if ($machinery->save()) {
            return response()->json(['success' => 'Maintenance information updated successfully'], 200);
        }

        return response()->json(['error' => 'Failed to update maintenance information'], 500);
    }

    public function maintenanceDue(Request $request)
    {
        $daysAhead = $request->input('days_ahead', 30);

        $dueMachinery = Machinery::whereNotNull('next_maintenance_date')
            ->where('next_maintenance_date', '<=', now()->addDays($daysAhead))
            ->orderBy('next_maintenance_date')
            ->get();

        return view('modules.machinery.maintenance-due', compact('dueMachinery', 'daysAhead'));
    }

    public function search(Request $request)
    {
        return Machinery::query()
            ->when($request->q, fn($q) => $q->where('asset_tag', 'like', "%{$request->q}%")
                ->orWhere('brand', 'like', "%{$request->q}%")
                ->orWhere('model', 'like', "%{$request->q}%")
                ->orWhere('engine_number', 'like', "%{$request->q}%"))
            ->limit(10)
            ->get()
            ->map(fn($m) => ['id' => $m->id, 'text' => "{$m->brand} - {$m->model} ({$m->asset_tag})"]);
    }

    public function destroy($id)
    {
        $machinery = Machinery::find($id);
        if (request()->user()->isAdmin() && $machinery->delete()) {
            $machinery->allocations()->delete();
            return response()->json(['success' => 'Machinery has been deleted successfully.']);
        }

        return response()->json(['error' => 'You are not authorized to delete the machinery.']);
    }
}
