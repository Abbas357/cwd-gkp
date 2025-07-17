<?php

namespace App\Http\Controllers\Site;

use App\Models\User;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrganogramController extends Controller
{
    public function index()
    {
        $topOffices = Office::where('name', 'Secretary C&W')
            ->orWhereIn('type', ['Regional', 'Secretariat'])
            ->where('parent_id', 2)
            ->get();

        return view('site.users.organogram', compact('topOffices'));
    }

    public function data(Request $request)
    {
        $rootOfficeId = $request->input('office_id');
        $officeType = $request->input('office_type', 'both');
        $depth = $request->input('depth');

        if ($rootOfficeId) {
            $rootOffice = Office::find($rootOfficeId);
        } else {
            $rootOffice = Office::where('name', 'Secretary C&W')->first();
        }

        if (!$rootOffice) {
            return response()->json(['error' => 'No valid office found for organogram.'], 404);
        }

        if ($depth === null) {
            if ($officeType == 'secretariat') {
                $depth = 0;
            } else {
                $depth = 1;
            }
        } else {
            $depth = (int) $depth;
        }

        $organogramData = $this->buildOrgChartData($rootOffice, 0, $depth, $officeType);

        return response()->json($organogramData);
    }

    private function buildOrgChartData($office, $currentDepth = 0, $maxDepth = 2, $officeType = 'both')
    {
        $currentOfficeType = strtolower($office->type ?? '');

        if ($officeType === 'both') {
            if ($currentOfficeType === 'secretariat') {
            } else {
                if ($currentDepth >= 2) {
                    return null;
                }
            }
        } else {
            if ($maxDepth > 0 && $currentDepth > $maxDepth) {
                return null;
            }
        }

        $officeHead = User::whereHas('currentPosting', function ($query) use ($office) {
            $query->where('office_id', $office->id)
                ->where('is_current', true);
        })
            ->with(['currentDesignation', 'currentOffice'])
            ->get();

        $sortedUsers = $officeHead->sortByDesc(function ($user) {
            return $user->currentDesignation && $user->currentDesignation->bps
                ? (int) $user->currentDesignation->bps
                : 0;
        });

        $officeHead = $sortedUsers->first();

        $usersCount = User::whereHas('currentPosting', function ($query) use ($office) {
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

        $childOfficesQuery = Office::where('parent_id', $office->id)
            ->where('status', 'Active');

        if ($officeType == 'secretariat') {
            $childOfficesQuery->where('type', 'Secretariat');
        } elseif ($officeType == 'field') {
            $childOfficesQuery->where(function ($query) {
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
}
