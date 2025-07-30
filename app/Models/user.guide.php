<?php 

public function getSubordinatesWithOptions(array $options = [])
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        // Start building the query
        $query = User::query()
            ->select('users.*', 'designations.bps', 'designations.name as designation_name', 'offices.name as office_name', 'offices.type as office_type', 'postings.office_id')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->join('offices', 'postings.office_id', '=', 'offices.id')
            ->where('postings.is_current', true)
            ->where('users.id', '!=', $this->id);

        // Handle same office only option
        if (!empty($options['same_office_only']) && $options['same_office_only']) {
            $query->where('postings.office_id', $this->currentOffice->id);
            
            // If same office only, filter by BPS less than current user
            if ($this->currentDesignation) {
                $query->where('designations.bps', '<', $this->currentDesignation->bps);
            }
        } else {
            // Get office IDs based on direct_only option
            if (!empty($options['direct_only']) && $options['direct_only']) {
                $officeIds = $this->getDirectSubordinateOfficeIds();
            } else {
                $officeIds = $this->getAllSubordinateOfficeIds();
            }

            // Apply office IDs filter
            if (!empty($officeIds)) {
                $query->whereIn('postings.office_id', $officeIds);
            } else if (empty($options['same_office_only'])) {
                // No subordinate offices and not same office, return empty
                return collect();
            }
        }

        // Filter by office type
        if (!empty($options['office_type'])) {
            $officeTypes = is_array($options['office_type']) ? $options['office_type'] : [$options['office_type']];
            $query->whereIn('offices.type', $officeTypes);
        }

        // Exclude office types
        if (!empty($options['exclude_office_types'])) {
            $query->whereNotIn('offices.type', $options['exclude_office_types']);
        }

        // Filter by specific office IDs
        if (!empty($options['office_ids'])) {
            $query->whereIn('postings.office_id', $options['office_ids']);
        }

        // Filter by BPS value(s)
        if (!empty($options['bps'])) {
            $bpsValues = is_array($options['bps']) ? $options['bps'] : [$options['bps']];
            $query->whereIn('designations.bps', $bpsValues);
        }

        // Filter by BPS range
        if (!empty($options['bps_range'])) {
            if (isset($options['bps_range']['min'])) {
                $query->where('designations.bps', '>=', $options['bps_range']['min']);
            }
            if (isset($options['bps_range']['max'])) {
                $query->where('designations.bps', '<=', $options['bps_range']['max']);
            }
        }

        // Filter by designation IDs
        if (!empty($options['designation_ids'])) {
            $query->whereIn('postings.designation_id', $options['designation_ids']);
        }

        // Filter by designation names (partial match)
        if (!empty($options['designation_names'])) {
            $query->where(function($q) use ($options) {
                foreach ($options['designation_names'] as $name) {
                    $q->orWhere('designations.name', 'LIKE', '%' . $name . '%');
                }
            });
        }

        // Filter by district IDs
        if (!empty($options['district_ids'])) {
            $query->whereIn('offices.district_id', $options['district_ids']);
        }

        // Exclude specific users
        if (!empty($options['exclude_users'])) {
            $query->whereNotIn('users.id', $options['exclude_users']);
        }

        // Filter by gender
        if (!empty($options['gender'])) {
            $query->where('users.gender', $options['gender']);
        }

        // Filter by status (if not using global scope)
        if (!empty($options['status'])) {
            $query->where('users.status', $options['status']);
        }

        // Handle highest ranking only per office
        if (!empty($options['highest_ranking_only']) && $options['highest_ranking_only']) {
            // Subquery to get max BPS per office
            $query->join(DB::raw('(
                SELECT p.office_id, MAX(d.bps) as max_bps
                FROM postings p
                JOIN designations d ON p.designation_id = d.id
                WHERE p.is_current = 1
                GROUP BY p.office_id
            ) as max_bps_per_office'), function($join) {
                $join->on('postings.office_id', '=', 'max_bps_per_office.office_id')
                    ->on('designations.bps', '=', 'max_bps_per_office.max_bps');
            });
        }

        // Handle ordering
        $orderBy = $options['order_by'] ?? 'bps';
        $orderDirection = $options['order_direction'] ?? ($orderBy === 'bps' ? 'desc' : 'asc');

        switch ($orderBy) {
            case 'bps':
                $query->orderBy('designations.bps', $orderDirection);
                break;
            case 'name':
                $query->orderBy('users.name', $orderDirection);
                break;
            case 'designation':
                $query->orderBy('designations.name', $orderDirection);
                break;
            case 'office':
                $query->orderBy('offices.name', $orderDirection);
                break;
            default:
                $query->orderBy('designations.bps', 'desc');
        }

        // Apply limit if specified
        if (!empty($options['limit'])) {
            $query->limit($options['limit']);
        }

        // Get the results
        $subordinates = $query->get();

        // Load additional relations if specified
        if (!empty($options['with_relations'])) {
            $subordinates->load($options['with_relations']);
        }

        return $subordinates;
    }

    private function getDirectSubordinateOfficeIds()
    {
        $directOfficeIds = [];
        $childOffices = $this->currentOffice->children;

        foreach ($childOffices as $childOffice) {
            // Check if office has users
            $hasUsers = Posting::where('office_id', $childOffice->id)
                ->where('is_current', true)
                ->exists();

            if ($hasUsers) {
                $directOfficeIds[] = $childOffice->id;
            } else {
                // If no users, go deeper
                $deeperOfficeIds = $this->getDeepestOfficeIdsWithUsers($childOffice);
                $directOfficeIds = array_merge($directOfficeIds, $deeperOfficeIds);
            }
        }

        return array_unique($directOfficeIds);
    }

    private function getAllSubordinateOfficeIds()
    {
        $allDescendants = $this->currentOffice->getAllDescendants();
        return $allDescendants->pluck('id')->toArray();
    }

    private function getDeepestOfficeIdsWithUsers($office)
    {
        $officeIds = [];

        $hasUsers = Posting::where('office_id', $office->id)
            ->where('is_current', true)
            ->exists();

        if ($hasUsers) {
            return [$office->id];
        }

        $childOffices = $office->children;

        foreach ($childOffices as $childOffice) {
            $deeperOfficeIds = $this->getDeepestOfficeIdsWithUsers($childOffice);
            $officeIds = array_merge($officeIds, $deeperOfficeIds);
        }

        return $officeIds;
    }

    public function getDistrictSubordinatesInBPSRange($minBps = 17, $maxBps = 19)
    {
        return $this->getSubordinatesWithOptions([
            'office_type' => 'District',
            'bps_range' => ['min' => $minBps, 'max' => $maxBps],
            'order_by' => 'bps',
            'order_direction' => 'desc'
        ]);
    }

    public function getHighestRankingSubordinatesByOfficeType($officeTypes)
    {
        return $this->getSubordinatesWithOptions([
            'office_type' => $officeTypes,
            'highest_ranking_only' => true,
            'with_relations' => ['currentOffice', 'currentDesignation']
        ]);
    }

    public function getDirectSubordinatesByDesignation($designationNames)
    {
        return $this->getSubordinatesWithOptions([
            'direct_only' => true,
            'designation_names' => $designationNames,
            'order_by' => 'office'
        ]);
    }

    public function getSameOfficeSubordinatesWithBPS($bps)
    {
        return $this->getSubordinatesWithOptions([
            'same_office_only' => true,
            'bps' => $bps
        ]);
    }

    public function getSubordinatesHighestRanking()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;
        $childOffices = $office->getAllDescendants();

        if ($childOffices->isEmpty()) {
            // If no child offices, get subordinates from same office with lower BPS
            $currentDesignation = $this->currentDesignation;
            
            if (!$currentDesignation) {
                return collect();
            }

            return User::select('users.*')
                ->join('postings', 'users.id', '=', 'postings.user_id')
                ->join('designations', 'postings.designation_id', '=', 'designations.id')
                ->where('postings.office_id', $office->id)
                ->where('postings.is_current', true)
                ->where('designations.bps', '<', $currentDesignation->bps)
                ->where('users.id', '!=', $this->id)
                ->orderBy('designations.bps', 'desc')
                ->get()
                ->unique('id');
        }

        $childOfficeIds = $childOffices->pluck('id')->toArray();

        // Get highest ranking user per office
        $subordinates = User::select('users.*')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->whereIn('postings.office_id', $childOfficeIds)
            ->where('postings.is_current', true)
            ->whereIn('designations.bps', function($query) use ($childOfficeIds) {
                $query->select(DB::raw('MAX(designations.bps)'))
                    ->from('postings')
                    ->join('designations', 'postings.designation_id', '=', 'designations.id')
                    ->whereColumn('postings.office_id', 'users_postings.office_id')
                    ->where('postings.is_current', true);
            })
            ->from('postings as users_postings')
            ->get();

        return $subordinates;
    }

    public function getDirectSubordinatesHighestRanking()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $office = $this->currentOffice;
        $directSubordinates = collect();
        $childOffices = $office->children;

        foreach ($childOffices as $childOffice) {
            // Get highest ranking user in this child office
            $highestRankingUser = User::select('users.*')
                ->join('postings', 'users.id', '=', 'postings.user_id')
                ->join('designations', 'postings.designation_id', '=', 'designations.id')
                ->where('postings.office_id', $childOffice->id)
                ->where('postings.is_current', true)
                ->orderBy('designations.bps', 'desc')
                ->first();

            if ($highestRankingUser) {
                $directSubordinates->push($highestRankingUser);
            } else {
                // If no users in child office, go deeper to find highest ranking
                $deeperSubordinates = $this->getDeepestDirectSubordinatesHighestRanking($childOffice);
                $directSubordinates = $directSubordinates->merge($deeperSubordinates);
            }
        }

        return $directSubordinates->unique('id');
    }

    protected function getDeepestDirectSubordinatesHighestRanking($office)
    {
        $subordinates = collect();

        // Get highest ranking user in this office
        $highestRankingUser = User::select('users.*')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->where('postings.office_id', $office->id)
            ->where('postings.is_current', true)
            ->orderBy('designations.bps', 'desc')
            ->first();

        if ($highestRankingUser) {
            return collect([$highestRankingUser]);
        }

        $childOffices = $office->children;

        if ($childOffices->isEmpty()) {
            return collect();
        }

        foreach ($childOffices as $childOffice) {
            $deeperSubordinates = $this->getDeepestDirectSubordinatesHighestRanking($childOffice);
            $subordinates = $subordinates->merge($deeperSubordinates);
        }

        return $subordinates;
    }

    public function getAllAccessibleUsers(array $options = [])
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        // Get all subordinate office IDs
        $subordinateOfficeIds = $this->getAllSubordinateOfficeIds();
        
        // Add current office ID to include colleagues
        $allOfficeIds = array_merge($subordinateOfficeIds, [$this->currentOffice->id]);
        $allOfficeIds = array_unique($allOfficeIds);

        // Start building the query
        $query = User::query()
            ->select('users.*', 'designations.bps', 'designations.name as designation_name', 'offices.name as office_name', 'offices.type as office_type')
            ->join('postings', 'users.id', '=', 'postings.user_id')
            ->join('designations', 'postings.designation_id', '=', 'designations.id')
            ->join('offices', 'postings.office_id', '=', 'offices.id')
            ->where('postings.is_current', true)
            ->where('users.id', '!=', $this->id) // Exclude self
            ->whereIn('postings.office_id', $allOfficeIds);

        // Apply additional filters from options
        $this->applyFiltersToQuery($query, $options);

        // Get the results
        $users = $query->get();

        // Load additional relations if specified
        if (!empty($options['with_relations'])) {
            $users->load($options['with_relations']);
        }

        return $users;
    }

    public function getAllAccessibleUsersWithContext(array $options = [])
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return collect();
        }

        $users = $this->getAllAccessibleUsers($options);
        
        // Add relationship context to each user
        $currentOfficeId = $this->currentOffice->id;
        $currentBps = $this->currentDesignation ? $this->currentDesignation->bps : 0;
        
        return $users->map(function ($user) use ($currentOfficeId, $currentBps) {
            // Get the office_id from the query result
            $userOfficeId = $user->office_id;
            
            // Determine relationship type
            if ($userOfficeId == $currentOfficeId) {
                // Same office
                if ($user->bps > $currentBps) {
                    $user->relationship_type = 'senior_colleague';
                    $user->relationship_description = 'Senior colleague in same office';
                } elseif ($user->bps < $currentBps) {
                    $user->relationship_type = 'junior_colleague';
                    $user->relationship_description = 'Junior colleague in same office';
                } else {
                    $user->relationship_type = 'peer_colleague';
                    $user->relationship_description = 'Peer colleague in same office';
                }
            } else {
                // Subordinate office
                $user->relationship_type = 'subordinate';
                $user->relationship_description = 'User from subordinate office';
            }
            
            return $user;
        });
    }

    public function getAllAccessibleUsersStats()
    {
        if (!$this->currentPosting || !$this->currentOffice) {
            return [
                'total_users' => 0,
                'colleagues' => 0,
                'subordinates' => 0,
                'by_office_type' => [],
                'by_bps' => [],
                'by_designation' => []
            ];
        }

        $allUsers = $this->getAllAccessibleUsers();
        $colleagues = $allUsers->where('office_id', $this->currentOffice->id);
        $subordinates = $allUsers->where('office_id', '!=', $this->currentOffice->id);

        return [
            'total_users' => $allUsers->count(),
            'colleagues' => $colleagues->count(),
            'subordinates' => $subordinates->count(),
            'by_office_type' => $allUsers->groupBy('office_type')->map->count(),
            'by_bps' => $allUsers->groupBy('bps')->map->count()->sortKeysDesc(),
            'by_designation' => $allUsers->groupBy('designation_name')->map->count()
        ];
    }

    public function getAllAccessibleUsersGroupedByOffice(array $options = [])
    {
        $users = $this->getAllAccessibleUsers($options);
        
        return $users->groupBy('office_name')->map(function ($officeUsers, $officeName) {
            return [
                'office_name' => $officeName,
                'office_id' => $officeUsers->first()->postings->first()->office_id,
                'office_type' => $officeUsers->first()->office_type,
                'user_count' => $officeUsers->count(),
                'users' => $officeUsers->sortByDesc('bps')
            ];
        })->sortBy('office_name');
    }

    public function hasAccessToUser($user)
    {
        $userId = $user instanceof User ? $user->id : $user;
        
        $accessibleUserIds = $this->getAllAccessibleUsers()->pluck('id')->toArray();
        
        return in_array($userId, $accessibleUserIds);
    }

    public function getAllSeniorUsers()
    {
        if (!$this->currentDesignation) {
            return collect();
        }
        
        return $this->getAllAccessibleUsers([
            'bps_range' => ['min' => $this->currentDesignation->bps + 1]
        ]);
    }

    public function getAllJuniorUsers()
    {
        if (!$this->currentDesignation) {
            return collect();
        }
        
        return $this->getAllAccessibleUsers([
            'bps_range' => ['max' => $this->currentDesignation->bps - 1]
        ]);
    }

    public function getAllPeerUsers()
    {
        if (!$this->currentDesignation) {
            return collect();
        }
        
        return $this->getAllAccessibleUsers([
            'bps' => $this->currentDesignation->bps
        ]);
    }

    private function applyFiltersToQuery($query, array $options)
    {
        // Filter by office type
        if (!empty($options['office_type'])) {
            $officeTypes = is_array($options['office_type']) ? $options['office_type'] : [$options['office_type']];
            $query->whereIn('offices.type', $officeTypes);
        }

        // Exclude office types
        if (!empty($options['exclude_office_types'])) {
            $query->whereNotIn('offices.type', $options['exclude_office_types']);
        }

        // Filter by BPS value(s)
        if (!empty($options['bps'])) {
            $bpsValues = is_array($options['bps']) ? $options['bps'] : [$options['bps']];
            $query->whereIn('designations.bps', $bpsValues);
        }

        // Filter by BPS range
        if (!empty($options['bps_range'])) {
            if (isset($options['bps_range']['min'])) {
                $query->where('designations.bps', '>=', $options['bps_range']['min']);
            }
            if (isset($options['bps_range']['max'])) {
                $query->where('designations.bps', '<=', $options['bps_range']['max']);
            }
        }

        // Filter by designation IDs
        if (!empty($options['designation_ids'])) {
            $query->whereIn('postings.designation_id', $options['designation_ids']);
        }

        // Filter by designation names (partial match)
        if (!empty($options['designation_names'])) {
            $designationNames = is_array($options['designation_names']) ? $options['designation_names'] : [$options['designation_names']];
            $query->where(function($q) use ($designationNames) {
                foreach ($designationNames as $name) {
                    $q->orWhere('designations.name', 'LIKE', '%' . $name . '%');
                }
            });
        }

        // Filter by district IDs
        if (!empty($options['district_ids'])) {
            $query->whereIn('offices.district_id', $options['district_ids']);
        }

        // Exclude specific users
        if (!empty($options['exclude_users'])) {
            $query->whereNotIn('users.id', $options['exclude_users']);
        }

        // Filter by gender
        if (!empty($options['gender'])) {
            $query->where('users.gender', $options['gender']);
        }

        // Filter by status
        if (!empty($options['status'])) {
            $query->where('users.status', $options['status']);
        }

        // Handle highest ranking only per office
        if (!empty($options['highest_ranking_only']) && $options['highest_ranking_only']) {
            $query->join(DB::raw('(
                SELECT p.office_id, MAX(d.bps) as max_bps
                FROM postings p
                JOIN designations d ON p.designation_id = d.id
                WHERE p.is_current = 1
                GROUP BY p.office_id
            ) as max_bps_per_office'), function($join) {
                $join->on('postings.office_id', '=', 'max_bps_per_office.office_id')
                    ->on('designations.bps', '=', 'max_bps_per_office.max_bps');
            });
        }

        // Handle ordering
        $orderBy = $options['order_by'] ?? 'bps';
        $orderDirection = $options['order_direction'] ?? ($orderBy === 'bps' ? 'desc' : 'asc');

        switch ($orderBy) {
            case 'bps':
                $query->orderBy('designations.bps', $orderDirection);
                break;
            case 'name':
                $query->orderBy('users.name', $orderDirection);
                break;
            case 'designation':
                $query->orderBy('designations.name', $orderDirection);
                break;
            case 'office':
                $query->orderBy('offices.name', $orderDirection);
                break;
            default:
                $query->orderBy('designations.bps', 'desc');
        }

        // Apply limit if specified
        if (!empty($options['limit'])) {
            $query->limit($options['limit']);
        }
    }
    
$subordinates = $user->getSubordinatesHighestRanking();

// Get colleagues from same office
$colleagues = $user->getUsersFromSameOffice();

// Get subordinates from same office only
$sameOfficeSubordinates = $user->getSubordinatesFromSameOffice();

// From an office perspective
$office = //Office::find(1);
$highestRankingUser = $office->getHighestRankingUser();
$subordinateOffices = $office->getSubordinateOfficesWithHighestRankingUsers();

$subordinates = $user->getSubordinatesWithOptions([
    'office_type' => 'District',
    'bps_range' => ['min' => 17, 'max' => 19]
]);

// Get highest ranking person from each Tehsil office
$subordinates = $user->getSubordinatesWithOptions([
    'office_type' => 'Tehsil',
    'highest_ranking_only' => true
]);

// Get subordinates from same office with BPS 17
$subordinates = $user->getSubordinatesWithOptions([
    'same_office_only' => true,
    'bps' => 17
]);

// Get direct subordinates only, excluding certain office types
$subordinates = $user->getSubordinatesWithOptions([
    'direct_only' => true,
    'exclude_office_types' => ['Project', 'Authority']
]);

// Complex query: Get female subordinates with BPS 17-19 from District offices
$subordinates = $user->getSubordinatesWithOptions([
    'office_type' => 'District',
    'bps_range' => ['min' => 17, 'max' => 19],
    'gender' => 'Female',
    'order_by' => 'name',
    'with_relations' => ['profile', 'currentOffice']
]);

// Get subordinates with specific designations
$subordinates = $user->getSubordinatesWithOptions([
    'designation_names' => ['Engineer', 'Assistant'],
    'order_by' => 'bps',
    'order_direction' => 'desc'
]);

// Get top 5 highest ranking subordinates
$subordinates = $user->getSubordinatesWithOptions([
    'order_by' => 'bps',
    'order_direction' => 'desc',
    'limit' => 5
]);

// Get all accessible users (subordinates + colleagues)
$allUsers = $user->getAllAccessibleUsers();

// Get all accessible users with filters
$filteredUsers = $user->getAllAccessibleUsers([
    'office_type' => ['District', 'Tehsil'],
    'bps_range' => ['min' => 16, 'max' => 18],
    'gender' => 'Female'
]);

// Get users with relationship context
$usersWithContext = $user->getAllAccessibleUsersWithContext();
foreach ($usersWithContext as $accessibleUser) {
    echo $accessibleUser->name . ' - ' . $accessibleUser->relationship_description;
}

// Get statistics
$stats = $user->getAllAccessibleUsersStats();
echo "Total accessible users: " . $stats['total_users'];
echo "Colleagues: " . $stats['colleagues'];
echo "Subordinates: " . $stats['subordinates'];

// Get users grouped by office
$groupedUsers = $user->getAllAccessibleUsersGroupedByOffice();
foreach ($groupedUsers as $office) {
    echo $office['office_name'] . ': ' . $office['user_count'] . ' users';
}

// Check if you have access to a specific user
if ($user->hasAccessToUser($targetUser)) {
    // You can view/manage this user
}

// Get all senior users in your sphere
$seniors = $user->getAllSeniorUsers();

// Get highest ranking from each office
$highestRanking = $user->getAllAccessibleUsers([
    'highest_ranking_only' => true
]);