<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Posting;
use App\Models\Designation;
use App\Models\SanctionedPost;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $currentUser = request()->user();

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
            // New team variables
            'currentUser',
            'directSubordinates',
            'entireTeam',
            'extendedTeam',
            'directSupervisor'
        ));
    }
}