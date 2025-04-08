<?php

namespace App\Http\Controllers\Vehicle;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Category;
use App\Helpers\Database;
use Illuminate\Http\Request;
use App\Helpers\SearchBuilder;
use App\Models\VehicleAllotment;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;

class VehicleController extends Controller
{
    public function all(Request $request)
    {
        $vehicles = Vehicle::query();
        
        $relationMappings = [
            'added_by' => 'user.currentPosting.designation.name',
            'assigned_to' => 'allotment.user.currentPosting.office.name',
            'officer_name' => 'allotment.user.name',
            'office_name' => 'allotment.office.name',
        ];
        
        if ($request->ajax()) {
            $dataTable = Datatables::of($vehicles)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('modules.vehicles.partials.buttons', compact('row'))->render();
                })
                ->addColumn('added_by', function ($row) {
                    return $row->user->currentPosting?->designation->name 
                    ? '<a href="'.route('admin.apps.hr.users.show', $row->user->id).'" target="_blank">'.$row->user->currentPosting?->designation->name .'</a>' 
                    : ($row->user->currentPosting?->designation->name  ?? 'N/A');
                })
                ->addColumn('assigned_to', function ($row) {
                    return view('modules.vehicles.partials.assignment', compact('row'))->render();
                })
                ->addColumn('officer_name', function ($row) {
                    return $row->allotment?->user?->name ?? 'Name not available';
                })
                ->addColumn('office_name', function ($row) {
                    return $row->allotment?->office?->name ?? 'Office not available';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'added_by', 'user', 'assigned_to', 'officer_name']);

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

        return view('modules.vehicles.index');
    }

    private function getDistribution($field)
    {
        return Vehicle::selectRaw("$field, COUNT(*) as count")
            ->whereNotNull($field)
            ->groupBy($field)
            ->orderBy('count', 'desc')
            ->get();
    }

    public function index(Request $request)
    {
        $totalVehicles = Vehicle::count();

        $functionalVehicles = Vehicle::where('functional_status', 'Functional')->count();
        $nonFunctionalVehicles = Vehicle::where('functional_status', 'Non-Functional')->count();
        $condemnedVehicles = Vehicle::where('functional_status', 'Condemned')->count();

        $allotedVehicles = VehicleAllotment::whereIn('type', ['Permanent', 'Temporary', 'Pool'])
            ->where('is_current', 1)
            ->where(function ($query) {
                $query->whereNotNull('user_id')
                    ->orWhereNotNull('office_id');
            })
            ->count();

        $permanentAlloted = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Permanent')
            ->count();

        $temporaryAlloted = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Temporary')
            ->count();

        $totalPoolVehicles = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Pool')
            ->count();

        $officePoolCount = VehicleAllotment::where('is_current', 1)
            ->where('type', 'Pool')
            ->where(function($q) {
                $q->whereNotNull('office_id')
                ->orWhereNotNull('user_id');
            })
            ->count();

        $departmentPoolCount = $totalPoolVehicles - $officePoolCount;

        $personalAllotmentCount = VehicleAllotment::where('is_current', 1)
            ->whereIn('type', ['Permanent', 'Temporary'])
            ->whereNotNull('user_id')
            ->whereNull('office_id')
            ->count();

        $distributions = [
            'type' => $this->getDistribution('type'),
            'color' => $this->getDistribution('color'),
            'fuel_type' => $this->getDistribution('fuel_type'),
            'registration_status' => $this->getDistribution('registration_status'),
            'brand' => $this->getDistribution('brand'),
            'model_year' => $this->getDistribution('model_year')
        ];

        $modelYearAllocation = Vehicle::selectRaw('
            model_year,
            COUNT(*) as total,
            SUM(CASE WHEN vehicles.id IN (SELECT vehicle_id FROM vehicle_allotments WHERE is_current = 1) THEN 1 ELSE 0 END) as allocated
        ')
            ->whereNotNull('model_year')
            ->groupBy('model_year')
            ->orderBy('model_year', 'desc')
            ->limit(10)
            ->get();

        $currentYear = date('Y');
        $vehicleAgeGroups = Vehicle::selectRaw('
            CASE 
                WHEN model_year >= ? THEN "New (0-2 years)"
                WHEN model_year >= ? THEN "Recent (3-5 years)"
                WHEN model_year >= ? THEN "Mature (6-10 years)"
                ELSE "Aging (10+ years)"
            END as age_group,
            COUNT(*) as count
        ', [$currentYear - 2, $currentYear - 5, $currentYear - 10])
            ->whereNotNull('model_year')
            ->groupBy('age_group')
            ->get();

        $topBrands = Vehicle::selectRaw('brand, COUNT(*) as count')
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $nonFunctionalByBrand = Vehicle::selectRaw('brand, COUNT(*) as count')
            ->whereIn('functional_status', ['Non-Functional', 'Condemned'])
            ->whereNotNull('brand')
            ->groupBy('brand')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $recentAllotments = VehicleAllotment::with(['vehicle', 'user', 'office'])
            ->latest()
            ->take(5)
            ->get();

        $vehiclesNeedingAttention = Vehicle::where('functional_status', 'Non-Functional')
            ->orWhere('functional_status', 'Condemned')
            ->with(['allotment.user', 'allotment.office'])
            ->take(5)
            ->get();

        $fuelTypeStats = Vehicle::selectRaw('fuel_type, COUNT(*) as count')
            ->whereNotNull('fuel_type')
            ->groupBy('fuel_type')
            ->get();

        $functionalPercentage = $totalVehicles > 0 ? ($functionalVehicles / $totalVehicles) * 100 : 0;
        $allotedPercentage = $totalVehicles > 0 ? ($allotedVehicles / $totalVehicles) * 100 : 0;
        $poolPercentage = $totalVehicles > 0 ? ($totalPoolVehicles / $totalVehicles) * 100 : 0;

        $yearWiseRegistrations = Vehicle::selectRaw('YEAR(created_at) as year, COUNT(*) as count')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $brandWiseStatus = Vehicle::selectRaw('brand, functional_status, COUNT(*) as count')
            ->whereNotNull('brand')
            ->whereNotNull('functional_status')
            ->groupBy('brand', 'functional_status')
            ->get()
            ->groupBy('brand');

        return view('modules.vehicles.dashboard', compact(
            'totalVehicles',
            'functionalVehicles',
            'nonFunctionalVehicles',
            'condemnedVehicles',
            'allotedVehicles',
            'permanentAlloted',
            'temporaryAlloted',
            'departmentPoolCount',
            'officePoolCount',
            'personalAllotmentCount',
            'distributions',
            'modelYearAllocation',
            'vehicleAgeGroups',
            'topBrands',
            'nonFunctionalByBrand',
            'recentAllotments',
            'vehiclesNeedingAttention',
            'fuelTypeStats',
            'functionalPercentage',
            'allotedPercentage',
            'poolPercentage',
            'yearWiseRegistrations',
            'brandWiseStatus',
        ));
    }

    public function create()
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => Category::where('type', 'vehicle_type')->get(),
            'vehicle_functional_status' => Category::where('type', 'vehicle_functional_status')->get(),
            'vehicle_color' => Category::where('type', 'vehicle_color')->get(),
            'fuel_type' => Category::where('type', 'fuel_type')->get(),
            'vehicle_registration_status' => Category::where('type', 'vehicle_registration_status')->get(),
            'vehicle_brand' => Category::where('type', 'vehicle_brand')->get(),
        ];

        $html = view('modules.vehicles.partials.create', compact('cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function store(StoreVehicleRequest $request)
    {
        $vehicle = new Vehicle();
        $vehicle->type = $request->type;
        $vehicle->functional_status = $request->functional_status;
        $vehicle->color = $request->color;
        $vehicle->registration_number = $request->registration_number;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->brand = $request->brand;
        $vehicle->model = $request->model;
        $vehicle->model_year = $request->model_year;
        $vehicle->registration_status = $request->registration_status;
        $vehicle->chassis_number = $request->chassis_number;
        $vehicle->engine_number = $request->engine_number;
        $vehicle->user_id = $request->user()->id;
        $vehicle->remarks = $request->remarks;

        session(['office' => $request->office]);

        if ($request->hasFile('front_view')) {
            $vehicle->addMedia($request->file('front_view'))
                ->toMediaCollection('vehicle_front_pictures');
        }

        if ($request->hasFile('side_view')) {
            $vehicle->addMedia($request->file('side_view'))
                ->toMediaCollection('vehicle_side_pictures');
        }

        if ($request->hasFile('rear_view')) {
            $vehicle->addMedia($request->file('rear_view'))
                ->toMediaCollection('vehicle_rear_pictures');
        }

        if ($request->hasFile('interior_view')) {
            $vehicle->addMedia($request->file('interior_view'))
                ->toMediaCollection('vehicle_interior_pictures');
        }

        if ($vehicle->save()) {
            session()->forget('office');
            return response()->json(['success' => 'Vehicle added successfully.']);
        }

        return response()->json(['error' => 'There was an error adding the vehicle.']);
    }

    public function showDetail(Vehicle $vehicle)
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => Category::where('type', 'vehicle_type')->get(),
            'vehicle_functional_status' => Category::where('type', 'vehicle_functional_status')->get(),
            'vehicle_color' => Category::where('type', 'vehicle_color')->get(),
            'fuel_type' => Category::where('type', 'fuel_type')->get(),
            'vehicle_registration_status' => Category::where('type', 'vehicle_registration_status')->get(),
            'vehicle_brand' => Category::where('type', 'vehicle_brand')->get(),
        ];

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Detail',
                ],
            ]);
        }

        $html = view('modules.vehicles.partials.detail', compact('vehicle', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function vehicleHistory(Vehicle $vehicle)
    {
        $allotments = $vehicle->allotments;

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle History',
                ],
            ]);
        }

        $html = view('modules.vehicles.partials.history', compact('vehicle', 'allotments'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function showVehicleDetails(Vehicle $vehicle)
    {
        // Load vehicle allotments with relations
        $allotments = $vehicle->allotments()
            ->with(['user', 'user.currentPosting', 'user.currentPosting.designation', 'user.currentPosting.office'])
            ->orderBy('start_date', 'desc')
            ->get();
            
        // Get current allotment if exists
        $currentAllotment = $allotments->where('is_current', true)->first();

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Vehicle Details',
                ],
            ]);
        }

        $html = view('modules.vehicles.partials.allotment-detail', compact('vehicle', 'allotments', 'currentAllotment'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        $vehicle->{$request->field} = $request->value;

        if ($vehicle->isDirty($request->field)) {
            $vehicle->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }

    public function uploadFile(Request $request, Vehicle $vehicle)
    {
        $file = $request->file;
        $collection = $request->collection;
        $vehicle->addMedia($file)->toMediaCollection($collection);
        if ($vehicle->save()) {
            return response()->json(['success' => 'File Updated']);
        }
        return response()->json(['error' => 'Error Uploading File']);
    }

    public function reports(Request $request)
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => Category::where('type', 'vehicle_type')->get(),
            'vehicle_functional_status' => Category::where('type', 'vehicle_functional_status')->get(),
            'vehicle_color' => Category::where('type', 'vehicle_color')->get(),
            'fuel_type' => Category::where('type', 'fuel_type')->get(),
            'vehicle_registration_status' => Category::where('type', 'vehicle_registration_status')->get(),
            'vehicle_brand' => Category::where('type', 'vehicle_brand')->get(),
            'allotment_status' => ['Office Pool', 'Department Pool', 'Personal Permanent', 'Personal Temporary'],
        ];

        $filters = [
            'user_id' => null,
            'vehicle_id' => null,
            'type' => null,
            'status' => null,
            'color' => null,
            'fuel_type' => null,
            'registration_status' => null,
            'brand' => null,
            'model_year' => null,
        ];

        $filters = array_merge($filters, $request->only(array_keys($filters)));

        $include_subordinates = $request->boolean('include_subordinates', false);
        $show_history = $request->boolean('show_history', false);
        
        $perPage = $request->input('per_page', 10);
        $showAll = $perPage === 'all';
        
        if (!$showAll && is_string($perPage)) {
            $perPage = (int) $perPage;
        }

        $query = VehicleAllotment::query()
            ->with(['vehicle', 'user', 'office'])
            ->when(!$show_history, fn($q) => $q->where('is_current', true))
            ->when(request('allotment_status'), function($q) {
                $status = request('allotment_status');
                
                return match ($status) {
                    'Office Pool' => $q->where('type', 'Pool')->whereNotNull('office_id')->whereNull('user_id'),
                    'Department Pool' => $q->where('type', 'Pool')->whereNull('office_id')->whereNull('user_id'),
                    'Personal Permanent' => $q->where('type', 'Permanent')->whereNotNull('user_id'),
                    'Personal Temporary' => $q->where('type', 'Temporary')->whereNotNull('user_id'),
                    default => $q,
                };
            });

            if ($filters['user_id']) {
                $user = User::find($filters['user_id']);
                $userOfficeId = $user->currentPosting?->office_id;
                
                if ($include_subordinates) {
                    // Get all subordinate users
                    $subordinates = $user->getSubordinates();
                    $subordinateUserIds = $subordinates->pluck('id')->toArray();
                    $allUserIds = array_merge([$user->id], $subordinateUserIds);
                    
                    // Get all offices under user's control
                    $userOffice = $user->currentOffice;
                    $subordinateOfficeIds = [];
                    
                    if ($userOffice) {
                        // Get all descendant offices
                        $descendantOffices = $userOffice->getAllDescendants();
                        $subordinateOfficeIds = $descendantOffices->pluck('id')->toArray();
                        
                        // Include user's own office
                        if ($userOfficeId) {
                            $subordinateOfficeIds[] = $userOfficeId;
                        }
                    }
                    
                    $query->where(function($q) use ($allUserIds, $subordinateOfficeIds) {
                        // Personal assignments to user or subordinates
                        $q->whereIn('user_id', $allUserIds);
                        
                        // Office assignments to user's office or subordinate offices
                        if (!empty($subordinateOfficeIds)) {
                            $q->orWhereIn('office_id', $subordinateOfficeIds);
                        }
                    });
                } else {
                    // Only vehicles assigned to this specific user or their office
                    $query->where(function($q) use ($user, $userOfficeId) {
                        // Direct personal assignment
                        $q->where('user_id', $user->id);
                        
                        // Office assignment to user's office
                        if ($userOfficeId) {
                            $q->orWhere('office_id', $userOfficeId);
                        }
                    });
                }
            }

        if ($filters['vehicle_id']) {
            $query->where('vehicle_id', $filters['vehicle_id']);
        }  

        $query->whereHas('vehicle', function ($q) use ($filters, $cat) {
            if ($filters['status']) {
                $status = $cat['vehicle_functional_status']->firstWhere('id', $filters['status']);
                $q->where('functional_status', $status->name ?? '');
            }

            if ($filters['type']) {
                $type = $cat['vehicle_type']->firstWhere('id', $filters['type']);
                $q->where('type', $type->name ?? '');
            }

            if ($filters['model_year']) {
                $q->where('model_year', $filters['model_year']);
            }

            $additionalFilters = [
                'color' => 'vehicle_color',
                'fuel_type' => 'fuel_type',
                'registration_status' => 'vehicle_registration_status',
                'brand' => 'vehicle_brand'
            ];
            
            foreach ($additionalFilters as $field => $categoryType) {
                if ($filters[$field]) {
                    $category = $cat[$categoryType]->firstWhere('id', $filters[$field]);
                    $q->where($field, $category->name ?? '');
                }
            }
        });

        $totalCount = $query->count();
        
        if ($showAll) {
            $allotments = $query->latest()->get();
        } else {
            try {
                $allotments = $query->latest()->paginate($perPage);
                $allotments->appends($request->except('page'));
            } catch (\Exception $e) {
                $perPage = 10;
                $allotments = $query->latest()->paginate($perPage);
                $allotments->appends($request->except('page'));
            }
        }
        
        $paginationOptions = [
            10 => '10 per page',
            50 => '50 per page',
            100 => '100 per page',
            'all' => 'Show All'
        ];

        return view('modules.vehicles.reports', compact('cat', 'allotments', 'filters', 'totalCount', 'perPage', 'paginationOptions'));
    }

    public function search(Request $request)
    {
        return Vehicle::query()
            ->when($request->q, fn($q) => $q->where('registration_number', 'like', "%{$request->q}%")
                ->orWhere('engine_number', 'like', "%{$request->q}%")
                ->orWhere('chassis_number', 'like', "%{$request->q}%"))
            ->limit(10)
            ->get()
            ->map(fn($v) => ['id' => $v->id, 'text' => "{$v->brand} - {$v->model}"]);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        if (request()->user()->isAdmin() && $vehicle->delete()) {
            $vehicle->allotments()->delete();
            return response()->json(['success' => 'Vehicle has been deleted successfully.']);
        }

        return response()->json(['error' => 'You are not authorized to delete the vehicle.']);
    }
}
