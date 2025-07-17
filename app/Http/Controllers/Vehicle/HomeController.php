<?php

namespace App\Http\Controllers\Vehicle;

use App\Models\User;
use App\Models\Setting;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\VehicleAllotment;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'vehicle';

    private function getDistribution($field)
    {
        return Vehicle::selectRaw("$field, COUNT(*) as count")
            ->whereNotNull($field)
            ->groupBy($field)
            ->orderBy('count', 'desc')
            ->get();
    }

    /**
     * Get vehicle allocation data for officer hierarchy chart
     */
    private function getOfficerVehicleAllocation($selectedUserId = null)
    {
        if (!$selectedUserId) {
            // Get top level officers if no specific user selected
            $topOfficers = User::whereHas('currentPosting', function($query) {
                $query->where('is_current', true);
            })
            ->whereHas('currentDesignation')
            ->with(['currentDesignation', 'currentOffice'])
            ->get()
            ->sortByDesc(function($user) {
                return isset($user->currentDesignation->bps) && is_numeric($user->currentDesignation->bps)
                    ? (int) $user->currentDesignation->bps
                    : 0;
            })
            ->take(10); // Limit to top 10 officers

            $chartData = [];
            foreach ($topOfficers as $officer) {
                $userVehicles = $this->calculateUserVehiclesAllocation($officer);
                $officeVehicles = $this->calculateOfficeVehiclesAllocation($officer);
                
                $chartData[] = [
                    'officer_id' => $officer->id,
                    'officer_name' => $officer->name,
                    'designation' => optional($officer->currentDesignation)->name ?? 'No Designation',
                    'office' => optional($officer->currentOffice)->name ?? 'No Office',
                    'user_vehicles' => $userVehicles,
                    'office_vehicles' => $officeVehicles
                ];
            }

            return $chartData;
        } else {
            // Get subordinates of selected user
            $selectedUser = User::find($selectedUserId);
            if (!$selectedUser) {
                return [];
            }

            $subordinates = $selectedUser->getSubordinates();
            $directSubordinates = $subordinates->filter(function($subordinate) use ($selectedUser) {
                $supervisor = $subordinate->getDirectSupervisor();
                return $supervisor && $supervisor->id === $selectedUser->id;
            });

            $chartData = [];
            foreach ($directSubordinates as $subordinate) {
                $userVehicles = $this->calculateUserVehiclesAllocation($subordinate);
                $officeVehicles = $this->calculateOfficeVehiclesAllocation($subordinate);
                
                $chartData[] = [
                    'officer_id' => $subordinate->id,
                    'officer_name' => $subordinate->name,
                    'designation' => optional($subordinate->currentDesignation)->name ?? 'No Designation',
                    'office' => optional($subordinate->currentOffice)->name ?? 'No Office',
                    'user_vehicles' => $userVehicles,
                    'office_vehicles' => $officeVehicles
                ];
            }

            return $chartData;
        }
    }

    /**
     * Calculate total vehicles allocated to users (officer + subordinates)
     */
    private function calculateUserVehiclesAllocation($officer)
    {
        // Get direct vehicles allocated to this officer (user_id allocation)
        $directVehicles = VehicleAllotment::where('is_current', 1)
            ->where('user_id', $officer->id)
            ->count();

        // Get subordinates and their vehicles
        $subordinates = $officer->getSubordinates();
        $subordinateVehicles = 0;
        
        foreach ($subordinates as $subordinate) {
            $subordinateVehicles += VehicleAllotment::where('is_current', 1)
                ->where('user_id', $subordinate->id)
                ->count();
        }

        return $directVehicles + $subordinateVehicles;
    }

    /**
     * Calculate total vehicles allocated to offices (officer's office + subordinate offices)
     */
    private function calculateOfficeVehiclesAllocation($officer)
    {
        $officeVehicles = 0;
        
        // Get vehicles allocated to officer's current office
        if ($officer->currentOffice) {
            $officeVehicles += VehicleAllotment::where('is_current', 1)
                ->where('office_id', $officer->currentOffice->id)
                ->count();
        }

        // Get subordinates and their office vehicles
        $subordinates = $officer->getSubordinates();
        
        foreach ($subordinates as $subordinate) {
            if ($subordinate->currentOffice) {
                $officeVehicles += VehicleAllotment::where('is_current', 1)
                    ->where('office_id', $subordinate->currentOffice->id)
                    ->count();
            }
        }

        return $officeVehicles;
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

        // Get officer vehicle allocation data
        $selectedUserId = $request->input('selected_officer') ?? 4;
        $officerVehicleData = $this->getOfficerVehicleAllocation($selectedUserId);
        
        // Get all users for the select dropdown
        $allUsers = User::whereHas('currentPosting', function($query) {
            $query->where('is_current', true);
        })
        ->with(['currentDesignation', 'currentOffice'])
        ->orderBy('name')
        ->get();

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
            'officerVehicleData',
            'allUsers',
            'selectedUserId'
        ));
    }

    public function reports(Request $request)
    {
        $cat = [
            'users' => User::all(),
            'vehicle_type' => category('vehicle_type', 'vehicle'),
            'vehicle_functional_status' => category('vehicle_functional_status', 'vehicle'),
            'vehicle_color' => category('vehicle_color', 'vehicle'),
            'fuel_type' => category('fuel_type', 'vehicle'),
            'vehicle_registration_status' => category('vehicle_registration_status', 'vehicle'),
            'vehicle_brand' => category('vehicle_brand', 'vehicle'),
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
                    $subordinates = $user->getSubordinates();
                    $subordinateUserIds = $subordinates->pluck('id')->toArray();
                    $allUserIds = array_merge([$user->id], $subordinateUserIds);
                    
                    $userOffice = $user->currentOffice;
                    $subordinateOfficeIds = [];
                    
                    if ($userOffice) {
                        $descendantOffices = $userOffice->getAllDescendants();
                        $subordinateOfficeIds = $descendantOffices->pluck('id')->toArray();
                        
                        if ($userOfficeId) {
                            $subordinateOfficeIds[] = $userOfficeId;
                        }
                    }
                    
                    $query->where(function($q) use ($allUserIds, $subordinateOfficeIds) {
                        $q->whereIn('user_id', $allUserIds);
                        
                        if (!empty($subordinateOfficeIds)) {
                            $q->orWhereIn('office_id', $subordinateOfficeIds);
                        }
                    });
                } else {
                    $query->where(function($q) use ($user, $userOfficeId) {
                        $q->where('user_id', $user->id);
                        
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

    public function settings()
    {
        $this->initIfNeeded();
        return view('modules.vehicles.settings');
    }

    public function update(Request $request)
    {
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $data) {
                if (!isset($data['value']) && $data['type'] !== 'boolean') {
                    continue;
                }

                Setting::set(
                    $key,
                    $data['value'],
                    $this->module,
                    'string',
                    $key . ' for ' . $this->module
                );
            }
        }

        if ($request->has('categories')) {
            foreach ($request->categories as $key => $data) {
                if (!isset($data['value']) || !is_array($data['value'])) {
                    continue;
                }
                $items = array_values(array_filter($data['value']));
                Setting::set(
                    $key,
                    $items,
                    $this->module,
                    'category',
                    $data['description'] ?? null
                );
            }
        }

        return redirect()->route('admin.apps.vehicles.settings.index')
            ->with('success', 'Vehicle settings updated successfully.');
    }
    
    public function init()
    {
        Setting::set('appName', 'Vehicle Management System', $this->module);

        Setting::set('vehicle_type', [
            'Vigo', 'Single Cabin', 'Pick up', 'Motorcycle', 'Jeep', 'Double Cabin', 'Car'
            ], $this->module, 'category', 'Vehicle Type');

        Setting::set('vehicle_functional_status', [
            'Non-Functional', 'Functional', 'Condemned'
            ], $this->module, 'category', 'Vehicle Functional Status');

        Setting::set('vehicle_color', [
            'Yellow', 'White', 'Silver', 'Red', 'Orange', 'Metallic', 'Green', 'Green', 'Gray', 'Brown', 'Blue', 'Black', 'N/A'
            ], $this->module, 'category', 'Vehicle Color');

        Setting::set('fuel_type', [
            'Petrol + CNG', 'Petrol', 'Diesel', 'CNG', 'N/A'
            ], $this->module, 'category', 'Vehicle Fuel Type');

        Setting::set('vehicle_registration_status', [
            'Un-Registered', 'Registered', 'In-Progress'
            ], $this->module, 'category', 'Vehicle Registration Status');

        Setting::set('vehicle_brand', [
            'Yamaha', 'Toyota', 'Suzuki', 'Nissan', 'Mitsubishi', 'Mercedes-Benz', 'Mazda', 'Kia', 'Jeep', 'Indus Car', 'Hyundai', 'Honda', 'Ford', 'Chevrolet', 'BMW', 'Audi'
            ], $this->module, 'category', 'Vehicle Brand');

        return redirect()->route('admin.apps.vehicles.settings.index')
            ->with('success', 'Vehicle Management System module initiated with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $appName = setting('appName', $this->module, null);
        if ($appName === null) {
            $this->init();
        }
    }
}
