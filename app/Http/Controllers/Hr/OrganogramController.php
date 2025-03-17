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
    public function index()
    {
        $topOffices = Office::where('name', 'Secretary C&W')
            ->orWhereIn('type', ['Regional', 'Secretariat'])
            ->where('parent_id', 2)
            ->get();
            
        return view('modules.hr.users.organogram', compact('topOffices'));
    }
    
    public function getData(Request $request)
    {
        $rootOfficeId = $request->input('office_id');
        $officeType = $request->input('office_type', 'both');
        
        $defaultDepth = 2;
        $depth = $request->input('depth', $defaultDepth);
        
        if ($rootOfficeId) {
            $rootOffice = Office::find($rootOfficeId);
        } else {
            $rootOffice = Office::where('name', 'Secretary C&W')->first();
        }
        
        if (!$rootOffice) {
            return response()->json(['error' => 'No valid office found for organogram.'], 404);
        }
        
        $organogramData = $this->buildOrgChartData($rootOffice, 0, $depth, $officeType);
        
        return response()->json($organogramData);
    }
    
    private function buildOrgChartData($office, $currentDepth = 0, $maxDepth = 2, $officeType = 'both')
    {
        if ($maxDepth > 0 && $currentDepth > $maxDepth) {
            return null;
        }
        
        $officeHead = User::whereHas('currentPosting', function($query) use ($office) {
            $query->where('office_id', $office->id)
                ->where('is_current', true);
        })
        ->with(['currentDesignation', 'currentOffice'])
        ->get();
        
        $sortedUsers = $officeHead->sortByDesc(function($user) {
            if (!$user->currentDesignation || !$user->currentDesignation->bps) {
                return 0;
            }
            
            preg_match('/(\d+)/', $user->currentDesignation->bps, $matches);
            return isset($matches[1]) ? (int)$matches[1] : 0;
        });
        
        $officeHead = $sortedUsers->first();
        
        $usersCount = User::whereHas('currentPosting', function($query) use ($office) {
            $query->where('office_id', $office->id)
                ->where('is_current', true);
        })->count();
        
        $nodeData = [
            'id' => 'office_' . $office->id,
            'name' => $office->name,
            'title' => $office->type ?? 'Office',
            'office_id' => $office->id,
            'office_type' => $office->type,
            'className' => 'level-' . $currentDepth . ' type-' . strtolower(str_replace(' ', '-', $office->type ?? 'unknown')),
            'users_count' => $usersCount > 0 ? $usersCount : null
        ];
        
        if ($officeHead) {
            $nodeData['head'] = [
                'id' => $officeHead->id,
                'name' => $officeHead->name,
                'title' => optional($officeHead->currentDesignation)->name ?? 'No Designation',
                'bps' => optional($officeHead->currentDesignation)->bps ?? '',
                'image' => getProfilePic($officeHead)
            ];
        }
        
        // Filter child offices based on office_type parameter
        $childOfficesQuery = Office::where('parent_id', $office->id)
            ->where('status', 'Active');
            
        if ($officeType == 'secretariat') {
            $childOfficesQuery->where('type', 'Secretariat');
        } elseif ($officeType == 'field') {
            $childOfficesQuery->where(function($query) {
                $query->where('type', '!=', 'Secretariat')
                      ->orWhereNull('type');
            });
        }
        
        $childOffices = $childOfficesQuery->get();
            
        if ($childOffices->isNotEmpty() && ($maxDepth === 0 || $currentDepth < $maxDepth)) {
            $childrenData = [];
            
            foreach ($childOffices as $childOffice) {
                $childData = $this->buildOrgChartData($childOffice, $currentDepth + 1, $maxDepth, $officeType);
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
    
    public function getUserHierarchy(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::with(['currentDesignation', 'currentOffice'])->findOrFail($userId);
        
        $userData = $this->buildUserHierarchyData($user);
        
        return response()->json($userData);
    }
    
    private function buildUserHierarchyData($user)
    {
        $supervisor = $user->getDirectSupervisor();
        
        $subordinates = $user->getSubordinates()->take(6);
        
        $userData = [
            'id' => 'user_' . $user->id,
            'name' => $user->name,
            'title' => optional($user->currentDesignation)->name ?? 'No Designation',
            'office' => optional($user->currentOffice)->name ?? 'No Office',
            'image' => getProfilePic($user),
            'id' => $user->id,
            'className' => 'selected-user'
        ];
        
        if ($supervisor) {
            $userData['parent'] = 'user_' . $supervisor->id;
            
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
            
            return $supervisorData;
        }
        
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