<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Posting;
use App\Models\Setting;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\SanctionedPost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'hr';

    public function index()
    {
        $currentUser = auth_user();

        // Team data
        $directSubordinates = $currentUser->getSubordinates();
        $entireTeam = $currentUser->getEntireTeam();
        $directSupervisor = $currentUser->getDirectSupervisor();

        $extendedTeam = $entireTeam->filter(function($member) use ($directSubordinates) {
            return !$directSubordinates->contains('id', $member->id);
        });

        $sanctionedPostsData = SanctionedPost::where('status', 'Active')
            ->selectRaw('SUM(total_positions) as total_positions')
            ->first();
            
        $filledPositionsCount = Posting::where('is_current', true)->count();
        
        $totalPositions = $sanctionedPostsData->total_positions ?? 0;
        $filledPositions = $filledPositionsCount;
        $vacantPositions = $totalPositions - $filledPositions;
        
        // Get top vacancies
        $topVacancies = SanctionedPost::where('status', 'Active')
            ->withCount(['currentPostings as filled_positions'])
            ->with(['office', 'designation'])
            ->select([
                'sanctioned_posts.*',
                DB::raw('(total_positions - (SELECT COUNT(*) FROM postings WHERE 
                    postings.office_id = sanctioned_posts.office_id AND 
                    postings.designation_id = sanctioned_posts.designation_id AND 
                    postings.is_current = 1)) as vacant_positions')
            ])
            ->orderByRaw('vacant_positions DESC')
            ->limit(10)
            ->get();
            
        // Other dashboard data
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'Active')->count();
        $totalOffices = Office::count();
        $totalDesignations = Designation::count();
        
        // Recent postings
        $recentPostings = Posting::with(['user', 'office', 'designation'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('modules.hr.users.vacancy-widget', compact(
            'totalPositions', 
            'filledPositions', 
            'vacantPositions',
            'topVacancies',
            'totalUsers',
            'activeUsers',
            'totalOffices',
            'totalDesignations',
            'recentPostings',
            'currentUser',
            'directSubordinates',
            'entireTeam',
            'extendedTeam',
            'directSupervisor'
        ));
    }

    public function settings()
    {
        $this->initIfNeeded();
        // $years = $this->years();
        // $activityTypes = [
        //     'Monsoon',
        //     'Flood',
        //     'Earthquake',
        //     'Landslide',
        //     'Snowfall',
        //     'Avalanche',
        // ];

        // return view('modules.hr.settings', compact('activityTypes', 'years'));
        return view('modules.hr.settings');
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

        return redirect()->route('admin.apps.hr.settings.index')
            ->with('success', 'HR settings updated successfully.');
    }

    public function init()
    {
        Setting::set('appName', 'Human Resource & Management Information System', $this->module);

        Setting::set('posting_type', [
            'Appointment', 'Deputation', 'Transfer', 'Mutual', 'Additional-Charge', 'Promotion', 'Suspension', 'OSD', 'Out-Transfer', 'Retirement', 'Termination'
        ], $this->module, 'category', 'List of Posting Types');

        Setting::set('office_type', [
            'Secretariat', 'Provincial', 'Regional', 'Authority', 'Project', 'Divisional', 'District', 'Tehsil'
        ], $this->module, 'category', 'List of Office Types');

        return redirect()->route('admin.apps.hr.settings.index')
            ->with('success', 'HR module initiated with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $appName = setting('appName', $this->module, null);
        if ($appName === null) {
            $this->init();
        }
    }
}