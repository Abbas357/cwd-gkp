<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserHierarchyController extends Controller
{
    public function getUserHierarchy(Request $request)
    {
        $userUuid = $request->input('user_uuid');
        
        if (!$userUuid) {
            return response()->json(['error' => 'User UUID is required'], 400);
        }
        
        $user = User::where('uuid', $userUuid)
            ->with(['currentPosting.office', 'currentPosting.designation'])
            ->first();
            
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $hierarchyData = $this->buildUserHierarchyData($user);
        
        return response()->json($hierarchyData);
    }
    
    private function buildUserHierarchyData($user)
    {
        $office = $user->currentPosting?->office;
        
        if (!$office) {
            return $this->createUserNode($user, true);
        }
        
        $supervisor = null;
        $parentOffice = $office->parent;
        
        if ($parentOffice) {
            $supervisor = User::whereHas('currentPosting', function($query) use ($parentOffice) {
                $query->where('office_id', $parentOffice->id)
                    ->where('is_current', true);
            })
            ->with(['currentDesignation', 'currentOffice'])
            ->first();
        }
        
        $subordinateOffices = Office::where('parent_id', $office->id)
            ->where('status', 'Active')
            ->get();
            
        $subordinates = collect();
        
        foreach ($subordinateOffices as $subOffice) {
            $officeHead = User::whereHas('currentPosting', function($query) use ($subOffice) {
                $query->where('office_id', $subOffice->id)
                    ->where('is_current', true);
            })
            ->with(['currentDesignation', 'currentOffice'])
            ->first();
            
            if ($officeHead) {
                $subordinates->push($officeHead);
            }
        }
        
        if ($user->currentPosting?->designation?->bps) {
            $sameOfficeLowerRank = User::whereHas('currentPosting', function($query) use ($office, $user) {
                $query->where('office_id', $office->id)
                    ->where('is_current', true)
                    ->whereHas('designation', function($q) use ($user) {
                        $q->whereRaw('CAST(SUBSTRING(bps, 1, 2) AS UNSIGNED) < ?', 
                            [intval(substr($user->currentPosting->designation->bps, 0, 2))]);
                    });
            })
            ->with(['currentDesignation', 'currentOffice'])
            ->get();
            
            $subordinates = $subordinates->merge($sameOfficeLowerRank);
        }
        
        $userData = $this->createUserNode($user, true);
        $children = [];
        
        foreach ($subordinates->take(6) as $subordinate) {
            $children[] = $this->createUserNode($subordinate);
        }
        
        if (!empty($children)) {
            $userData['children'] = $children;
        }
        
        if ($supervisor) {
            $supervisorData = $this->createUserNode($supervisor);
            $supervisorData['children'] = [$userData];
            return $supervisorData;
        }
        
        return $userData;
    }

    private function createUserNode($user, $isMainUser = false)
    {
        $className = $isMainUser ? 'selected-user' : '';
        
        return [
            'id' => 'user_' . $user->id,
            'user_id' => $user->id,
            'uuid' => $user->uuid,
            'name' => $user->name,
            'title' => optional($user->currentOffice)->name ?? 'No Designation',
            'image' => $this->getUserImage($user),
            'className' => $className,
        ];
    }
 
    private function getUserImage($user)
    {
        return $user->getFirstMediaUrl('profile_pictures', 'small') ?: asset('admin/images/default-avatar.jpg');
    }
}