<?php

namespace App\Http\Controllers\Hr;

use App\Models\User;
use App\Models\Office;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrganogramController extends Controller
{
    /**
     * Display the organogram view
     */
    public function index()
    {
        // Get top-level offices (no parent)
        $topOffices = Office::whereNull('parent_id')
            ->where('status', 'Active')
            ->get();
            
        return view('modules.hr.users.organogram', compact('topOffices'));
    }
    
    /**
     * Get hierarchy data for the organogram
     */
    public function getData(Request $request)
    {
        // Get the office to use as root
        $rootOfficeId = $request->input('office_id');
        $depth = $request->input('depth', 2); // Default to 2 levels of depth
        
        if ($rootOfficeId) {
            $rootOffice = Office::find($rootOfficeId);
        } else {
            // If no specific office is requested, use the first top-level office
            $rootOffice = Office::whereNull('parent_id')
                ->where('status', 'Active')
                ->first();
        }
        
        if (!$rootOffice) {
            return response()->json(['error' => 'No valid office found for organogram.'], 404);
        }
        
        // Build the organogram data
        $organogramData = $this->buildOrgChartData($rootOffice, 0, $depth);
        
        return response()->json($organogramData);
    }
    
    /**
     * Build organogram data structure for a specific office
     * 
     * @param Office $office The office to build data for
     * @param int $currentDepth Current depth level
     * @param int $maxDepth Maximum depth to traverse (0 for unlimited)
     * @return array The organized data
     */
    private function buildOrgChartData($office, $currentDepth = 0, $maxDepth = 2)
    {
        // Stop recursion if we've gone too deep
        if ($maxDepth > 0 && $currentDepth > $maxDepth) {
            return null;
        }
        
        // Get office head (user with highest designation)
        $officeHead = User::whereHas('currentPosting', function($query) use ($office) {
            $query->where('office_id', $office->id)
                  ->where('is_current', true);
        })
        ->with(['currentDesignation', 'currentOffice'])
        ->get()
        ->sortByDesc(function($user) {
            // Sort by designation BPS (higher first)
            return $user->currentDesignation ? 
                (is_numeric($user->currentDesignation->bps) ? 
                    intval($user->currentDesignation->bps) : 0) : 0;
        })
        ->first();
        
        // Get total users in this office
        $usersCount = User::whereHas('currentPosting', function($query) use ($office) {
            $query->where('office_id', $office->id)
                  ->where('is_current', true);
        })->count();
        
        // Build node data
        $nodeData = [
            'id' => 'office_' . $office->id,
            'name' => $office->name,
            'title' => $office->type ?? 'Office',
            'office_id' => $office->id,
            'className' => 'level-' . $currentDepth,
            'users_count' => $usersCount > 0 ? $usersCount : null
        ];
        
        // Add office head if available
        if ($officeHead) {
            $nodeData['head'] = [
                'id' => $officeHead->id,
                'name' => $officeHead->name,
                'title' => optional($officeHead->currentDesignation)->name ?? 'No Designation',
                'bps' => optional($officeHead->currentDesignation)->bps ?? '',
                'image' => getProfilePic($officeHead)
            ];
        }
        
        // Get child offices
        $childOffices = Office::where('parent_id', $office->id)
            ->where('status', 'Active')
            ->get();
            
        // Add children recursively (if not at max depth)
        if ($childOffices->isNotEmpty() && ($maxDepth === 0 || $currentDepth < $maxDepth)) {
            $childrenData = [];
            
            foreach ($childOffices as $childOffice) {
                $childData = $this->buildOrgChartData($childOffice, $currentDepth + 1, $maxDepth);
                if ($childData) {
                    $childrenData[] = $childData;
                }
            }
            
            if (!empty($childrenData)) {
                $nodeData['children'] = $childrenData;
            }
        }
        
        return $nodeData;
    }
    
    /**
     * Get user hierarchy data for the organogram
     */
    public function getUserHierarchy(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::with(['currentDesignation', 'currentOffice'])->findOrFail($userId);
        
        // Build the user data hierarchy
        $userData = $this->buildUserHierarchyData($user);
        
        return response()->json($userData);
    }
    
    /**
     * Build user hierarchy data for organogram
     * 
     * @param User $user The user to build hierarchy for
     * @return array The organized data
     */
    private function buildUserHierarchyData($user)
    {
        // Get the direct supervisor
        $supervisor = $user->getDirectSupervisor();
        
        // Get direct subordinates
        $subordinates = $user->getSubordinates()->take(6);
        
        // Create the user node
        $userData = [
            'id' => 'user_' . $user->id,
            'name' => $user->name,
            'title' => optional($user->currentDesignation)->name ?? 'No Designation',
            'office' => optional($user->currentOffice)->name ?? 'No Office',
            'image' => getProfilePic($user),
            'id' => $user->id,
            'className' => 'selected-user'
        ];
        
        // If there's a supervisor, add as parent
        if ($supervisor) {
            $userData['parent'] = 'user_' . $supervisor->id;
            
            // Create supervisor node
            $supervisorData = [
                'id' => 'user_' . $supervisor->id,
                'name' => $supervisor->name,
                'title' => optional($supervisor->currentDesignation)->name ?? 'No Designation',
                'office' => optional($supervisor->currentOffice)->name ?? 'No Office',
                'image' => getProfilePic($supervisor),
                'id' => $supervisor->id,
                'className' => 'supervisor-node',
                'children' => [$userData]
            ];
            
            // Return with supervisor as root
            return $supervisorData;
        }
        
        // If there are subordinates, add as children
        if ($subordinates->isNotEmpty()) {
            $childrenData = [];
            
            foreach ($subordinates as $subordinate) {
                $childrenData[] = [
                    'id' => 'user_' . $subordinate->id,
                    'name' => $subordinate->name,
                    'title' => optional($subordinate->currentDesignation)->name ?? 'No Designation',
                    'office' => optional($subordinate->currentOffice)->name ?? 'No Office',
                    'image' => getProfilePic($subordinate),
                    'id' => $subordinate->id,
                    'className' => 'subordinate-node'
                ];
            }
            
            if (!empty($childrenData)) {
                $userData['children'] = $childrenData;
            }
        }
        
        return $userData;
    }
}