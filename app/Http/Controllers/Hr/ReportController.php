<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Posting;
use App\Models\District;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\SanctionedPost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function vacancyReport(Request $request)
    {
        // Get filter parameters
        $filters = [
            'office_id' => $request->query('office_id'),
            'designation_id' => $request->query('designation_id'),
            'status' => $request->query('status', 'Active'),
            'level' => $request->query('level'),
            'district_id' => $request->query('district_id'),
            'bps' => $request->query('bps'),
            'vacancy_status' => $request->query('vacancy_status', 'all') // all, filled, vacant
        ];

        $perPage = $request->query('per_page', 10);
        
        // Base query for sanctioned posts
        $sanctionedPostsQuery = SanctionedPost::query()
            ->with(['office', 'designation'])
            ->where('status', $filters['status']);
        
        // Apply filters
        if ($filters['office_id']) {
            $sanctionedPostsQuery->where('office_id', $filters['office_id']);
        }
        
        if ($filters['designation_id']) {
            $sanctionedPostsQuery->where('designation_id', $filters['designation_id']);
        }
        
        if ($filters['level']) {
            $sanctionedPostsQuery->whereHas('office', function($q) use ($filters) {
                $q->where('level', $filters['level']);
            });
        }
        
        if ($filters['district_id']) {
            $sanctionedPostsQuery->whereHas('office', function($q) use ($filters) {
                $q->where('district_id', $filters['district_id']);
            });
        }
        
        if ($filters['bps']) {
            $sanctionedPostsQuery->whereHas('designation', function($q) use ($filters) {
                $q->where('bps', $filters['bps']);
            });
        }
        
        // Filter by vacancy status if specified
        if ($filters['vacancy_status'] !== 'all') {
            $sanctionedPostsQuery->addSelect([
                'filled_positions' => Posting::selectRaw('COUNT(*)')
                    ->whereColumn('office_id', 'sanctioned_posts.office_id')
                    ->whereColumn('designation_id', 'sanctioned_posts.designation_id')
                    ->where('is_current', true)
            ])->having(
                $filters['vacancy_status'] === 'filled' ? 
                    DB::raw('filled_positions >= total_positions') : 
                    DB::raw('filled_positions < total_positions')
            );
        }
        
        // Get paginated results
        $sanctionedPosts = $sanctionedPostsQuery->paginate($perPage);
        
        // Add vacancy information to each sanctioned post
        $sanctionedPosts->getCollection()->transform(function ($post) {
            $post->filled_positions = Posting::where('office_id', $post->office_id)
                ->where('designation_id', $post->designation_id)
                ->where('is_current', true)
                ->count();
            
            $post->vacant_positions = $post->total_positions - $post->filled_positions;
            
            return $post;
        });
        
        // Calculate summary statistics
        $totalSanctioned = SanctionedPost::where('status', 'Active')->sum('total_positions');
        $totalFilled = Posting::where('is_current', true)->count();
        $totalVacant = $totalSanctioned - $totalFilled;
        $vacancyRate = $totalSanctioned > 0 ? ($totalVacant / $totalSanctioned) * 100 : 0;
        
        // Get offices, designations, and districts for filtering
        $offices = Office::where('status', 'Active')->get();
        $designations = Designation::where('status', 'Active')->get();
        $districts = District::all();
        
        // Get BPS values for filtering
        $bpsValues = [];
        for ($i = 1; $i <= 22; $i++) {
            $bpsValues[] = sprintf("BPS-%02d", $i);
        }
        
        // Get office hierarchy levels for filtering
        $officeLevels = ['Provincial', 'Regional', 'Divisional', 'District', 'SubDivisional'];
        
        return view('modules.hr.reports.vacancy', compact(
            'sanctionedPosts', 
            'filters', 
            'offices', 
            'designations', 
            'districts',
            'bpsValues',
            'officeLevels',
            'totalSanctioned',
            'totalFilled',
            'totalVacant',
            'vacancyRate',
            'perPage'
        ));
    }
    
    /**
     * Display the employee directory report
     */
    public function employeeDirectory(Request $request)
    {
        // Get filter parameters
        $filters = [
            'office_id' => $request->query('office_id'),
            'designation_id' => $request->query('designation_id'),
            'status' => $request->query('status', 'Active'),
            'bps' => $request->query('bps'),
            'district_id' => $request->query('district_id'),
            'search' => $request->query('search'),
            'posting_type' => $request->query('posting_type'),
            'include_subordinates' => $request->boolean('include_subordinates', false),
        ];

        $perPage = $request->query('per_page', 10);
        
        // Base query for users with current posting
        $usersQuery = User::query()
            ->withoutGlobalScope('active')
            ->with(['currentPosting.office', 'currentPosting.designation', 'profile'])
            ->when($filters['status'], function($q) use ($filters) {
                $q->where('status', $filters['status']);
            });
        
        // Apply filters
        if ($filters['search']) {
            $usersQuery->where(function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('cnic', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('profile', function($sq) use ($filters) {
                      $sq->where('mobile_number', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }
        
        if ($filters['office_id']) {
            $usersQuery->whereHas('currentPosting', function($q) use ($filters) {
                $q->where('office_id', $filters['office_id']);
                
                if ($filters['include_subordinates']) {
                    $office = Office::find($filters['office_id']);
                    if ($office) {
                        $descendantIds = $office->getAllDescendants()->pluck('id')->push($office->id);
                        $q->whereIn('office_id', $descendantIds);
                    }
                }
            });
        }
        
        if ($filters['designation_id']) {
            $usersQuery->whereHas('currentPosting', function($q) use ($filters) {
                $q->where('designation_id', $filters['designation_id']);
            });
        }
        
        if ($filters['district_id']) {
            $usersQuery->whereHas('currentPosting.office', function($q) use ($filters) {
                $q->where('district_id', $filters['district_id']);
            });
        }
        
        if ($filters['bps']) {
            $usersQuery->whereHas('currentPosting.designation', function($q) use ($filters) {
                $q->where('bps', $filters['bps']);
            });
        }

        if ($filters['posting_type']) {
            $usersQuery->whereHas('currentPosting', function($q) use ($filters) {
                $q->where('type', $filters['posting_type']);
            });
        }
        
        // Get paginated results
        $users = $usersQuery->paginate($perPage);
        
        // Get offices, designations, and districts for filtering
        $offices = Office::where('status', 'Active')->get();
        $allOffices = $offices; // This was the missing line
        $designations = Designation::where('status', 'Active')->get();
        $districts = District::all();
        
        // Get BPS values for filtering
        $bpsValues = [];
        for ($i = 1; $i <= 22; $i++) {
            $bpsValues[] = sprintf("BPS-%02d", $i);
        }
        
        // Get posting types for filtering
        $postingTypes = ['Appointment', 'Transfer', 'Promotion', 'Deputation', 'Additional-Charge', 'OSD'];
        
        return view('modules.hr.reports.employee-directory', compact(
            'users', 
            'filters', 
            'offices', 
            'allOffices', // Now included in the compact array
            'designations', 
            'districts',
            'bpsValues',
            'postingTypes',
            'perPage'
        ));
    }
    
    /**
     * Display the office strength report
     */
    public function officeStrength(Request $request)
    {
        // Get filter parameters
        $filters = [
            'office_id' => $request->query('office_id'),
            'level' => $request->query('level'),
            'district_id' => $request->query('district_id'),
            'show_details' => $request->boolean('show_details', false),
        ];

        $perPage = $request->query('per_page', 15);
        
        // Base query for offices
        $officesQuery = Office::query()
            ->where('status', 'Active')
            ->with(['district']);
            
        // Apply filters
        if ($filters['office_id']) {
            $officesQuery->where('id', $filters['office_id']);
        }
        
        if ($filters['level']) {
            $officesQuery->where('level', $filters['level']);
        }
        
        if ($filters['district_id']) {
            $officesQuery->where('district_id', $filters['district_id']);
        }
        
        // Get paginated results
        $offices = $perPage === 'all' ? 
            $officesQuery->get() : 
            $officesQuery->paginate($perPage);
        
        // Add strength information to each office
        $officesToProcess = $perPage === 'all' ? $offices : $offices->getCollection();
        
        $officesToProcess->transform(function ($office) use ($filters) {
            // Get sanctioned posts count
            $office->sanctioned_positions = SanctionedPost::where('office_id', $office->id)
                ->where('status', 'Active')
                ->sum('total_positions');
            
            // Get filled positions count
            $office->filled_positions = Posting::where('office_id', $office->id)
                ->where('is_current', true)
                ->count();
            
            // Calculate vacancy
            $office->vacant_positions = $office->sanctioned_positions - $office->filled_positions;
            
            // Get staff details if requested
            if ($filters['show_details']) {
                $office->staff = User::whereHas('currentPosting', function($q) use ($office) {
                    $q->where('office_id', $office->id)
                      ->where('is_current', true);
                })
                ->with(['currentPosting.designation'])
                ->get()
                ->sortByDesc(function($user) {
                    // Sort by BPS (higher first)
                    if (!$user->currentPosting || !$user->currentPosting->designation) {
                        return 0;
                    }
                    
                    $bps = $user->currentPosting->designation->bps;
                    preg_match('/(\d+)/', $bps, $matches);
                    return isset($matches[1]) ? (int)$matches[1] : 0;
                })
                ->values();
            }
            
            return $office;
        });
        
        if ($perPage !== 'all') {
            $offices->setCollection($officesToProcess);
        }
        
        // Calculate summary statistics
        $totalOffices = Office::where('status', 'Active')->count();
        $totalSanctioned = SanctionedPost::where('status', 'Active')->sum('total_positions');
        $totalFilled = Posting::where('is_current', true)->count();
        $totalVacant = $totalSanctioned - $totalFilled;
        
        // Get offices and districts for filtering
        $allOffices = Office::where('status', 'Active')->get();
        $districts = District::all();
        
        // Get office hierarchy levels for filtering
        $officeLevels = ['Provincial', 'Regional', 'Divisional', 'District', 'SubDivisional'];
        
        return view('modules.hr.reports.office-strength', compact(
            'offices', 
            'filters', 
            'allOffices', 
            'districts',
            'officeLevels',
            'totalOffices',
            'totalSanctioned',
            'totalFilled',
            'totalVacant',
            'perPage'
        ));
    }
    
    /**
     * Display the posting history report
     */
    public function postingHistory(Request $request)
    {
        // Get filter parameters
        $filters = [
            'user_id' => $request->query('user_id'),
            'office_id' => $request->query('office_id'),
            'designation_id' => $request->query('designation_id'),
            'posting_type' => $request->query('posting_type'),
            'date_from' => $request->query('date_from'),
            'date_to' => $request->query('date_to'),
            'is_current' => $request->query('is_current'),
        ];

        $perPage = $request->query('per_page', 15);
        
        // Base query for postings
        $postingsQuery = Posting::query()
            ->with(['user', 'office', 'designation']);
            
        // Apply filters
        if ($filters['user_id']) {
            $postingsQuery->where('user_id', $filters['user_id']);
        }
        
        if ($filters['office_id']) {
            $postingsQuery->where('office_id', $filters['office_id']);
        }
        
        if ($filters['designation_id']) {
            $postingsQuery->where('designation_id', $filters['designation_id']);
        }
        
        if ($filters['posting_type']) {
            $postingsQuery->where('type', $filters['posting_type']);
        }
        
        if ($filters['date_from']) {
            $postingsQuery->where('start_date', '>=', $filters['date_from']);
        }
        
        if ($filters['date_to']) {
            $postingsQuery->where(function($q) use ($filters) {
                $q->where('start_date', '<=', $filters['date_to'])
                  ->orWhere('end_date', '<=', $filters['date_to']);
            });
        }
        
        if ($filters['is_current'] !== null) {
            $postingsQuery->where('is_current', $filters['is_current']);
        }
        
        // Order by most recent first
        $postingsQuery->orderBy('start_date', 'desc');
        
        // Get paginated results
        $postings = $postingsQuery->paginate($perPage);
        
        // Add duration calculation to each posting
        $postings->getCollection()->transform(function ($posting) {
            $startDate = $posting->start_date;
            $endDate = $posting->end_date ?: now();
            
            $diff = $startDate->diff($endDate);
            $posting->duration_years = $diff->y;
            $posting->duration_months = $diff->m;
            $posting->duration_days = $diff->d;
            
            return $posting;
        });
        
        // Get users, offices, and designations for filtering
        $users = User::all();
        $offices = Office::where('status', 'Active')->get();
        $designations = Designation::where('status', 'Active')->get();
        
        // Get posting types for filtering
        $postingTypes = ['Appointment', 'Transfer', 'Promotion', 'Deputation', 'Additional-Charge', 'OSD', 'Retirement', 'Termination'];
        
        return view('modules.hr.reports.posting-history', compact(
            'postings', 
            'filters', 
            'users', 
            'offices', 
            'designations',
            'postingTypes',
            'perPage'
        ));
    }
    
    /**
     * Display the service length report
     */
    public function serviceLengthReport(Request $request)
    {
        // Get filter parameters
        $filters = [
            'office_id' => $request->query('office_id'),
            'designation_id' => $request->query('designation_id'),
            'min_years' => $request->query('min_years'),
            'max_years' => $request->query('max_years'),
            'bps' => $request->query('bps'),
        ];

        $perPage = $request->query('per_page', 15);
        
        // Base query for users with active status
        $usersQuery = User::query()
            ->where('status', 'Active')
            ->with(['currentPosting.office', 'currentPosting.designation', 'postings']);
            
        // Apply filters
        if ($filters['office_id']) {
            $usersQuery->whereHas('currentPosting', function($q) use ($filters) {
                $q->where('office_id', $filters['office_id']);
            });
        }
        
        if ($filters['designation_id']) {
            $usersQuery->whereHas('currentPosting', function($q) use ($filters) {
                $q->where('designation_id', $filters['designation_id']);
            });
        }
        
        if ($filters['bps']) {
            $usersQuery->whereHas('currentPosting.designation', function($q) use ($filters) {
                $q->where('bps', $filters['bps']);
            });
        }
        
        // Get all users first (we'll paginate after calculating service length)
        $allUsers = $usersQuery->get();
        
        // Calculate service length for each user
        $allUsers->transform(function ($user) use ($filters) {
            // Get first posting date as service start date
            $firstPosting = $user->postings->sortBy('start_date')->first();
            $user->service_start_date = $firstPosting ? $firstPosting->start_date : null;
            
            if ($user->service_start_date) {
                $serviceDiff = $user->service_start_date->diff(now());
                $user->service_years = $serviceDiff->y;
                $user->service_months = $serviceDiff->m;
                $user->service_days = $serviceDiff->d;
                
                // Calculate total service in days for sorting
                $user->service_days_total = $user->service_start_date->diffInDays(now());
            } else {
                $user->service_years = 0;
                $user->service_months = 0;
                $user->service_days = 0;
                $user->service_days_total = 0;
            }
            
            return $user;
        });
        
        // Filter by service length if specified
        if ($filters['min_years'] !== null) {
            $allUsers = $allUsers->filter(function ($user) use ($filters) {
                return $user->service_years >= (int)$filters['min_years'];
            });
        }
        
        if ($filters['max_years'] !== null) {
            $allUsers = $allUsers->filter(function ($user) use ($filters) {
                return $user->service_years <= (int)$filters['max_years'];
            });
        }
        
        // Sort by service length (longest first)
        $allUsers = $allUsers->sortByDesc('service_days_total')->values();
        
        // Manual pagination
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $perPage;
        
        if ($perPage === 'all') {
            $users = $allUsers;
            $paginatedUsers = $allUsers;
        } else {
            $paginatedUsers = $allUsers->slice($offset, $perPage)->values();
            
            // Create a paginator manually
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedUsers,
                $allUsers->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        
        // Get offices and designations for filtering
        $offices = Office::where('status', 'Active')->get();
        $designations = Designation::where('status', 'Active')->get();
        
        // Get BPS values for filtering
        $bpsValues = [];
        for ($i = 1; $i <= 22; $i++) {
            $bpsValues[] = sprintf("BPS-%02d", $i);
        }
        
        // Calculate summary statistics
        $avgServiceYears = $allUsers->avg('service_years');
        $maxServiceYears = $allUsers->max('service_years');
        $minServiceYears = $allUsers->min('service_years');
        
        // Group users by service length ranges
        $serviceLengthRanges = [
            '0-5' => $allUsers->filter(function($u) { return $u->service_years >= 0 && $u->service_years <= 5; })->count(),
            '6-10' => $allUsers->filter(function($u) { return $u->service_years >= 6 && $u->service_years <= 10; })->count(),
            '11-15' => $allUsers->filter(function($u) { return $u->service_years >= 11 && $u->service_years <= 15; })->count(),
            '16-20' => $allUsers->filter(function($u) { return $u->service_years >= 16 && $u->service_years <= 20; })->count(),
            '21+' => $allUsers->filter(function($u) { return $u->service_years >= 21; })->count(),
        ];
        
        return view('modules.hr.reports.service-length', compact(
            'users', 
            'filters', 
            'offices', 
            'designations',
            'bpsValues',
            'avgServiceYears',
            'maxServiceYears',
            'minServiceYears',
            'serviceLengthRanges',
            'perPage'
        ));
    }
    
    /**
     * Display the retirement forecast report
     */
    public function retirementForecast(Request $request)
    {
        // Get filter parameters
        $filters = [
            'office_id' => $request->query('office_id'),
            'designation_id' => $request->query('designation_id'),
            'bps' => $request->query('bps'),
            'years_range' => $request->query('years_range', 5), // Default 5 years forecast
        ];

        $perPage = $request->query('per_page', 15);
        
        // Standard retirement age is 60 years
        $retirementAge = 60;
        
        // Base query for users with active status
        $usersQuery = User::query()
            ->where('status', 'Active')
            ->with(['currentPosting.office', 'currentPosting.designation', 'profile']);
            
        // Apply filters
        if ($filters['office_id']) {
            $usersQuery->whereHas('currentPosting', function($q) use ($filters) {
                $q->where('office_id', $filters['office_id']);
            });
        }
        
        if ($filters['designation_id']) {
            $usersQuery->whereHas('currentPosting', function($q) use ($filters) {
                $q->where('designation_id', $filters['designation_id']);
            });
        }
        
        if ($filters['bps']) {
            $usersQuery->whereHas('currentPosting.designation', function($q) use ($filters) {
                $q->where('bps', $filters['bps']);
            });
        }
        
        // Get all users (we'll filter and paginate after calculating retirement dates)
        $allUsers = $usersQuery->get();
        
        // Calculate retirement date for each user
        $now = Carbon::now();
        $forecastEndDate = $now->copy()->addYears($filters['years_range']);
        
        $filteredUsers = $allUsers->filter(function ($user) use ($retirementAge, $now, $forecastEndDate) {
            // Get date of birth from profile
            if (!$user->profile || !$user->profile->date_of_birth) {
                $user->retirement_date = null;
                $user->years_to_retirement = null;
                return false; // Skip users without DOB
            }
            
            $dob = Carbon::parse($user->profile->date_of_birth);
            $retirementDate = $dob->copy()->addYears($retirementAge);
            
            $user->retirement_date = $retirementDate;
            $user->years_to_retirement = $now->diffInYears($retirementDate);
            $user->months_to_retirement = $now->diffInMonths($retirementDate) % 12;
            
            // Keep only users retiring within the forecast period
            return $retirementDate->lte($forecastEndDate);
        })->values();
        
        // Sort by retirement date (soonest first)
        $filteredUsers = $filteredUsers->sortBy('retirement_date')->values();
        
        // Manual pagination
        $page = $request->query('page', 1);
        $offset = ($page - 1) * $perPage;
        
        if ($perPage === 'all') {
            $users = $filteredUsers;
            $paginatedUsers = $filteredUsers;
        } else {
            $paginatedUsers = $filteredUsers->slice($offset, $perPage)->values();
            
            // Create a paginator manually
            $users = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedUsers,
                $filteredUsers->count(),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );
        }
        
        // Get offices and designations for filtering
        $offices = Office::where('status', 'Active')->get();
        $designations = Designation::where('status', 'Active')->get();
        
        // Get BPS values for filtering
        $bpsValues = [];
        for ($i = 1; $i <= 22; $i++) {
            $bpsValues[] = sprintf("BPS-%02d", $i);
        }
        
        // Group by retirement year for chart
        $retirementsByYear = [];
        foreach ($filteredUsers as $user) {
            $year = $user->retirement_date->year;
            if (!isset($retirementsByYear[$year])) {
                $retirementsByYear[$year] = 0;
            }
            $retirementsByYear[$year]++;
        }
        
        // Sort by year
        ksort($retirementsByYear);
        
        // Calculate retirement by designation for chart
        $retirementsByDesignation = [];
        foreach ($filteredUsers as $user) {
            $designation = $user->currentPosting->designation->name ?? 'Unknown';
            if (!isset($retirementsByDesignation[$designation])) {
                $retirementsByDesignation[$designation] = 0;
            }
            $retirementsByDesignation[$designation]++;
        }
        
        // Sort by count (highest first)
        arsort($retirementsByDesignation);
        
        // Limit to top 10 designations
        $retirementsByDesignation = array_slice($retirementsByDesignation, 0, 10);
        
        return view('modules.hr.reports.retirement-forecast', compact(
            'users', 
            'filters', 
            'offices', 
            'designations',
            'bpsValues',
            'retirementsByYear',
            'retirementsByDesignation',
            'perPage'
        ));
    }

    public function officeStaff(Request $request)
    {
        // Validate input
        $request->validate([
            'office_id' => 'required|exists:offices,id'
        ]);
        
        // Get office details
        $office = Office::findOrFail($request->office_id);
        
        // Get staff members
        $staff = User::whereHas('currentPosting', function($q) use ($office) {
                $q->where('office_id', $office->id)
                ->where('is_current', true);
            })
            ->with(['currentPosting.designation', 'profile'])
            ->get()
            ->sortByDesc(function($user) {
                // Sort by BPS (higher first)
                if (!$user->currentPosting || !$user->currentPosting->designation) {
                    return 0;
                }
                
                $bps = $user->currentPosting->designation->bps;
                preg_match('/(\d+)/', $bps, $matches);
                return isset($matches[1]) ? (int)$matches[1] : 0;
            })
            ->values();
        
        // Return the view for the modal content
        return view('modules.hr.reports.partials.office-staff-list', compact('staff', 'office'));
    }
}