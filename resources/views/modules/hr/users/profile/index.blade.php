<x-hr-layout>
    @push('style')
    <style>
        .profile-header {
            background: linear-gradient(135deg, #4c84ff, #876afe, #ff6bb7);
            padding: 20px 0;
            border-radius: 10px;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            object-fit: cover;
        }
        
        .profile-name {
            font-size: 24px;
            font-weight: 600;
            margin-top: 10px;
        }
        
        .profile-address {
            font-size: 14px;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .info-card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f1f1;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-pills .nav-link.active {
            background-color: #4c84ff;
            color: white;
        }
        
        .nav-pills .nav-link {
            border-radius: 30px;
            padding: 8px 18px;
            margin-right: 5px;
            color: #555;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-pills .nav-link:hover:not(.active) {
            background-color: #f1f5ff;
        }
        
        .info-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f1f1;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #666;
            font-weight: 500;
        }
        
        .info-value {
            font-weight: 500;
            color: #333;
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 10px;
            width: 2px;
            background-color: #e0e0e0;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 25px;
        }
        
        .timeline-item:last-child {
            padding-bottom: 0;
        }
        
        .timeline-point {
            position: absolute;
            left: -30px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #4c84ff;
            border: 4px solid white;
            box-shadow: 0 0 0 2px #4c84ff;
        }
        
        .timeline-date {
            position: absolute;
            right: 0;
            top: 0;
            color: #888;
            font-size: 0.85rem;
        }
        
        .timeline-content {
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
        }
        
        .badge-bps {
            background-color: #ff6bb7;
            color: white;
            font-weight: 500;
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }
        
        .add-button {
            border-radius: 30px;
            padding: 5px 15px;
            font-size: 0.85rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Employee Profile</li>
    </x-slot>

    <div class="row">
        <!-- Profile Header -->
        <div class="col-12 mb-4">
            <div class="profile-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-2 text-center">
                            <img src="{{ getProfilePic($data['user']) }}" alt="Profile Image" class="profile-img">
                        </div>
                        <div class="col-md-8">
                            <h1 class="profile-name">{{ $data['user']->name }}</h1>
                            <p class="profile-address">
                                <i class="bi bi-geo-alt"></i> 
                                {{ $data['user']->profile->address ?? 'No address available' }}
                            </p>
                            <div class="d-flex align-items-center mt-2">
                                @if($data['user']->currentPosting)
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="bi bi-person-badge"></i> 
                                        {{ $data['user']->currentPosting->designation->name ?? 'N/A' }}
                                    </span>
                                    <span class="badge bg-light text-dark me-2">
                                        <i class="bi bi-building"></i> 
                                        {{ $data['user']->currentPosting->office->name ?? 'N/A' }}
                                    </span>
                                    <span class="badge badge-bps">
                                        {{ $data['user']->currentPosting->designation->bps ?? 'N/A' }}
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark">No current posting</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <button type="button" class="btn btn-light edit-btn" data-id="{{ $data['user']->id }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="col-12 mb-4">
            <ul class="nav nav-pills" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-info-tab" data-bs-toggle="tab" data-bs-target="#basic-info" type="button" role="tab" aria-selected="true">
                        <i class="bi bi-person me-1"></i> Basic Info
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-info-tab" data-bs-toggle="tab" data-bs-target="#profile-info" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-card-text me-1"></i> Profile
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="service-history-tab" data-bs-toggle="tab" data-bs-target="#service-history" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-briefcase me-1"></i> Service History
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="roles-permissions-tab" data-bs-toggle="tab" data-bs-target="#roles-permissions" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-shield me-1"></i> Roles & Permissions
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reporting-tab" data-bs-toggle="tab" data-bs-target="#reporting" type="button" role="tab" aria-selected="false">
                        <i class="bi bi-diagram-3 me-1"></i> Reporting
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="col-12">
            <div class="tab-content" id="profileTabContent">
                <!-- Basic Info Tab -->
                <div class="tab-pane fade show active" id="basic-info" role="tabpanel" aria-labelledby="basic-info-tab">
                    <div class="card info-card">
                        <div class="card-header">
                            <span>Basic Information</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Full Name</div>
                                        <div class="info-value">{{ $data['user']->name }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Username</div>
                                        <div class="info-value">{{ $data['user']->username }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value">{{ $data['user']->email }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">Status</div>
                                        <div class="info-value">
                                            <span class="badge bg-{{ $data['user']->status === 'Active' ? 'success' : ($data['user']->status === 'Inactive' ? 'warning' : 'secondary') }}">
                                                {{ $data['user']->status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Account Created</div>
                                        <div class="info-value">{{ $data['user']->created_at->format('j F, Y') }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Last Updated</div>
                                        <div class="info-value">{{ $data['user']->updated_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Tab -->
                <div class="tab-pane fade" id="profile-info" role="tabpanel" aria-labelledby="profile-info-tab">
                    <div class="card info-card">
                        <div class="card-header">
                            <span>Profile Information</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">CNIC</div>
                                        <div class="info-value">{{ $data['user']->profile->cnic ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Mobile Number</div>
                                        <div class="info-value">{{ $data['user']->profile->mobile_number ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Landline Number</div>
                                        <div class="info-value">{{ $data['user']->profile->landline_number ?? 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <div class="info-label">WhatsApp</div>
                                        <div class="info-value">{{ $data['user']->profile->whatsapp ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Facebook</div>
                                        <div class="info-value">{{ $data['user']->profile->facebook ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Twitter</div>
                                        <div class="info-value">{{ $data['user']->profile->twitter ?? 'Not provided' }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-item">
                                        <div class="info-label">Message</div>
                                        <div class="info-value">{{ $data['user']->profile->message ?? 'No message available' }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="info-item">
                                        <div class="info-label">Featured On</div>
                                        <div class="info-value">
                                            @php
                                                $featuredOn = $data['user']->profile?->featured_on
                                                ? json_decode($data['user']->profile->featured_on, true)
                                                : [];
                                            @endphp
                                            
                                            @if(count($featuredOn) > 0)
                                                @foreach($featuredOn as $page)
                                                    <span class="badge bg-info me-1">{{ $page }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">Not featured on any page</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Service History Tab -->
                <div class="tab-pane fade" id="service-history" role="tabpanel" aria-labelledby="service-history-tab">
                    <div class="card info-card">
                        <div class="card-header">
                            <span>Service History</span>
                            <button type="button" class="btn btn-primary btn-sm add-button add-posting-btn" data-id="{{ $data['user']->id }}">
                                <i class="bi bi-plus"></i> Add Posting
                            </button>
                        </div>
                        <div class="card-body">
                            @if($data['user']->postings->count() > 0)
                                <div class="timeline">
                                    @foreach($data['user']->postings->sortByDesc('start_date') as $posting)
                                        <div class="timeline-item">
                                            <div class="timeline-point"></div>
                                            <div class="timeline-date">
                                                {{ $posting->start_date->format('d M, Y') }} - 
                                                {{ $posting->end_date ? $posting->end_date->format('d M, Y') : 'Current' }}
                                            </div>
                                            <div class="timeline-content">
                                                <h5 class="mb-1">{{ $posting->type }}</h5>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span><strong>Designation:</strong> {{ optional($posting->designation)->name }}</span>
                                                    @if($posting->designation && $posting->designation->bps)
                                                        <span class="badge badge-bps">{{ $posting->designation->bps }}</span>
                                                    @endif
                                                </div>
                                                <p class="mb-0"><strong>Office:</strong> {{ optional($posting->office)->name }}</p>
                                                @if($posting->remarks)
                                                    <p class="text-muted mt-2 mb-0 small"><i class="bi bi-info-circle"></i> {{ $posting->remarks }}</p>
                                                @endif
                                                <div class="mt-2 text-end">
                                                    <button class="btn btn-sm btn-outline-primary edit-posting-btn" data-id="{{ $posting->id }}">
                                                        <i class="bi bi-pencil"></i> Edit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-briefcase-x" style="font-size: 3rem; color: #ccc;"></i>
                                    <p class="mt-3">No posting history available</p>
                                    <button type="button" class="btn btn-outline-primary btn-sm add-posting-btn" data-id="{{ $data['user']->id }}">
                                        <i class="bi bi-plus"></i> Add First Posting
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Roles & Permissions Tab -->
                <div class="tab-pane fade" id="roles-permissions" role="tabpanel" aria-labelledby="roles-permissions-tab">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card info-card">
                                <div class="card-header">
                                    <span>Roles</span>
                                </div>
                                <div class="card-body">
                                    @if($data['roles']->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($data['roles'] as $role)
                                                <span class="badge bg-primary">{{ $role->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No roles assigned</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card info-card">
                                <div class="card-header">
                                    <span>Direct Permissions</span>
                                </div>
                                <div class="card-body">
                                    @if($data['permissions']->count() > 0)
                                        <div class="d-flex flex-wrap gap-2">
                                            @foreach($data['permissions'] as $permission)
                                                <span class="badge bg-info">{{ $permission->name }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted">No direct permissions assigned</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reporting Tab -->
                <div class="tab-pane fade" id="reporting" role="tabpanel" aria-labelledby="reporting-tab">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card info-card">
                                <div class="card-header">
                                    <span>Current Position</span>
                                </div>
                                <div class="card-body">
                                    @if($data['user']->currentPosting)
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-1"><strong>Designation:</strong>
                                                    {{ optional($data['user']->currentDesignation)->name ?? 'Not Assigned' }}
                                                </p>
                                                <p class="mb-1"><strong>Office:</strong>
                                                    {{ optional($data['user']->currentOffice)->name ?? 'Not Assigned' }}
                                                </p>
                                                <p class="mb-0"><strong>Since:</strong>
                                                    {{ $data['user']->currentPosting->start_date->format('d M, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    @else
                                        <p class="mb-0 text-muted">No active posting assigned.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card info-card">
                                <div class="card-header">
                                    <span>District Information</span>
                                </div>
                                <div class="card-body" id="district-info-container">
                                    @if($data['user']->currentOffice)
                                        @php
                                            $directDistrict = $data['user']->currentOffice->district ?? null;
                                            $managedDistricts = $data['user']->currentOffice->getAllManagedDistricts() ?? collect([]);
                                        @endphp
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="mb-2">Direct District Assignment</h6>
                                                @if($directDistrict)
                                                    <span class="badge bg-primary">{{ $directDistrict->name }}</span>
                                                @else
                                                    <span class="text-muted">No direct district assignment</span>
                                                @endif
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h6 class="mb-2">Managed Districts</h6>
                                                @if($managedDistricts->count() > 0)
                                                    @foreach($managedDistricts as $district)
                                                        <span class="badge bg-secondary mb-1">{{ $district->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No managed districts</span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="form-text mt-3">
                                            <small class="text-muted">
                                                <i class="bi bi-info-circle me-1"></i>
                                                District assignments are based on the office hierarchy. Higher-level office users manage districts of their subordinate offices.
                                            </small>
                                        </div>
                                    @else
                                        <div class="text-center text-muted">
                                            <i class="bi bi-building-x mb-2" style="font-size: 2rem;"></i>
                                            <p>No office assignment. District information will be available once an office is assigned.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Reports To</h6>
                                </div>
                                <div class="card-body" id="supervisor-container">
                                    <div class="text-center py-3">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2 mb-0">Loading supervisor information...</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Subordinates</h6>
                                </div>
                                <div class="card-body" id="subordinates-container">
                                    <div class="text-center py-3">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2 mb-0">Loading subordinate information...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Edit user modal
            pushStateModal({
                fetchUrl: "{{ route('admin.apps.hr.users.edit', ':id') }}",
                btnSelector: '.edit-btn',
                title: 'Edit User',
                actionButtonName: 'Update User',
                modalSize: 'lg',
                includeForm: true,
                formAction: "{{ route('admin.apps.hr.users.update', ':id') }}",
                formType: 'edit'
            });

            // Add posting modal
            pushStateModal({
                fetchUrl: "{{ route('admin.apps.hr.postings.create', ['user_id' => ':id']) }}",
                btnSelector: '.add-posting-btn',
                title: 'Add New Posting',
                actionButtonName: 'Create Posting',
                modalSize: 'md',
                includeForm: true,
                formAction: "{{ route('admin.apps.hr.postings.store') }}",
                formType: 'create'
            });

            // Edit posting modal
            pushStateModal({
                fetchUrl: "{{ route('admin.apps.hr.postings.edit', ':id') }}",
                btnSelector: '.edit-posting-btn',
                title: 'Edit Posting',
                actionButtonName: 'Update Posting',
                modalSize: 'md',
                includeForm: true,
                formAction: "{{ route('admin.apps.hr.postings.update', ':id') }}",
                formType: 'edit'
            });

            // Load reporting relationships when the reporting tab is shown
            $('button[data-bs-target="#reporting"]').on('shown.bs.tab', function(e) {
                loadReportingRelationships();
            });

            function loadReportingRelationships() {
                $.ajax({
                    url: "{{ route('admin.apps.hr.user-relationships') }}",
                    type: "GET",
                    data: {
                        user_id: "{{ $data['user']->id }}"
                    },
                    success: function(response) {
                        let supervisorHtml = '';
                        if (response.directSupervisor) {
                            supervisorHtml = `
                            <div class="d-flex align-items-center">
                                <img src="${getUserAvatar(response.directSupervisor)}" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                <div>
                                    <h6 class="mb-1">${response.directSupervisor.name}</h6>
                                    <p class="mb-1 small">${response.directSupervisor.current_designation ? response.directSupervisor.current_designation.name : 'No Designation'}</p>
                                    <p class="mb-0 small text-muted">${response.directSupervisor.current_office ? response.directSupervisor.current_office.name : 'No Office'}</p>
                                </div>
                            </div>
                        `;
                        } else if (response.supervisors && response.supervisors.length > 0) {
                            supervisorHtml = '<div class="list-group">';
                            $.each(response.supervisors, function(index, supervisor) {
                                supervisorHtml += `
                                <div class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <img src="${getUserAvatar(supervisor)}" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                        <div>
                                            <h6 class="mb-1">${supervisor.name}</h6>
                                            <p class="mb-1 small">${supervisor.current_designation ? supervisor.current_designation.name : 'No Designation'}</p>
                                            <p class="mb-0 small text-muted">${supervisor.current_office ? supervisor.current_office.name : 'No Office'}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            });
                            supervisorHtml += '</div>';
                        } else {
                            supervisorHtml = '<div class="alert alert-info">No direct supervisor found. This may be a top-level position.</div>';
                        }
                        $('#supervisor-container').html(supervisorHtml);

                        let subordinatesHtml = '';
                        if (response.subordinates && response.subordinates.length > 0) {
                            subordinatesHtml = '<div class="list-group">';
                            $.each(response.subordinates, function(index, subordinate) {
                                subordinatesHtml += `
                                <div class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        <img src="${getUserAvatar(subordinate)}" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                        <div>
                                            <h6 class="mb-1">${subordinate.name}</h6>
                                            <p class="mb-1 small">${subordinate.current_designation ? subordinate.current_designation.name : 'No Designation'}</p>
                                            <p class="mb-0 small text-muted">${subordinate.current_office ? subordinate.current_office.name : 'No Office'}</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            });
                            subordinatesHtml += '</div>';
                        } else {
                            subordinatesHtml = '<div class="alert alert-info">No subordinates found for this user.</div>';
                        }
                        $('#subordinates-container').html(subordinatesHtml);
                    },
                    error: function() {
                        $('#supervisor-container').html('<div class="alert alert-danger">Error loading supervisor information.</div>');
                        $('#subordinates-container').html('<div class="alert alert-danger">Error loading subordinate information.</div>');
                    }
                });
            }

            function getUserAvatar(user) {
                return "{{ asset('admin/images/no-profile.png') }}";
            }
            
            // Functions for posting management
            function createSanctionedPost() {
                const officeId = $('#office_id').val();
                const designationId = $('#designation_id').val();
                const designationName = $('#designation_id option:selected').text().trim();
                const officeName = $('#office_id option:selected').text().trim();
                
                $('#vacancy-info').html(`
                    <div class="card mt-2">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">Create New Sanctioned Post</h6>
                        </div>
                        <div class="card-body">
                            <p>Creating sanctioned post for:</p>
                            <ul>
                                <li><strong>Office:</strong> ${officeName}</li>
                                <li><strong>Designation:</strong> ${designationName}</li>
                            </ul>
                            <div class="mb-3">
                                <label for="total_positions">Total Positions:</label>
                                <input type="number" class="form-control" id="total_positions" value="1" min="1">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="checkVacancies()">Cancel</button>
                                <button type="button" class="btn btn-primary" onclick="saveSanctionedPost()">Create</button>
                            </div>
                        </div>
                    </div>
                `);
            }

            function saveSanctionedPost() {
                const officeId = $('#office_id').val();
                const designationId = $('#designation_id').val();
                const totalPositions = $('#total_positions').val();
                
                $.ajax({
                    url: "{{ route('admin.apps.hr.sanctioned-posts.quick-create') }}",
                    type: "POST",
                    data: {
                        office_id: officeId,
                        designation_id: designationId,
                        total_positions: totalPositions,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#vacancy-info').html(`
                                <div class="alert alert-success">
                                    Sanctioned post created successfully.
                                </div>
                            `);
                            // Re-check vacancies after creation
                            setTimeout(checkVacancies, 1000);
                        } else {
                            $('#vacancy-info').html(`
                                <div class="alert alert-danger">
                                    ${response.error || 'Failed to create sanctioned post.'}
                                </div>
                            `);
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to create sanctioned post.';
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            errorMessage = xhr.responseJSON.error;
                        }
                        $('#vacancy-info').html(`
                            <div class="alert alert-danger">
                                ${errorMessage}
                            </div>
                        `);
                    }
                });
            }

            // Function to check if mutual transfer is possible
            function checkMutualTransferEligibility(userId, targetOfficeId, targetDesignationId) {
                $.ajax({
                    url: "{{ route('admin.apps.hr.users.current-posting') }}",
                    type: "GET",
                    data: { user_id: userId },
                    dataType: 'json',
                    success: function(response) {
                        if (!response.current_posting) {
                            $('#vacancy-info').html(`
                                <span class="text-danger">Cannot perform mutual transfer. The selected officer does not have an active posting.</span>
                            `);
                            return;
                        }
                        
                        // Check if there's someone in the target position
                        $.ajax({
                            url: "{{ route('admin.apps.hr.postings.check-occupancy') }}",
                            type: "GET",
                            data: { 
                                office_id: targetOfficeId,
                                designation_id: targetDesignationId
                            },
                            dataType: 'json',
                            success: function(occupancyData) {
                                if (occupancyData.is_occupied) {
                                    const otherUser = occupancyData.user;
                                    $('#vacancy-info').html(`
                                        <span class="text-success">Mutual transfer possible with ${otherUser.name}</span>
                                        <input type="hidden" name="mutual_transfer_user_id" value="${otherUser.id}">
                                        <div class="alert alert-info mt-2">
                                            <small>This will transfer ${otherUser.name} to ${response.current_posting.office.name} 
                                            as ${response.current_posting.designation.name}</small>
                                        </div>
                                    `);
                                } else {
                                    $('#vacancy-info').html(`
                                        <span class="text-warning">No officer found in the target position for mutual transfer.</span>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                onclick="switchToRegularTransfer()">
                                                Switch to Regular Transfer
                                            </button>
                                        </div>
                                    `);
                                }
                            }
                        });
                    }
                });
            }

            // Function to show override options when no vacancy exists
            function showOverrideOptions(postingType) {
                const options = [
                    { value: 'create-excess', text: 'Create in excess of sanctioned positions' },
                    { value: 'convert-to-mutual', text: 'Convert to Mutual Transfer' },
                    { value: 'vacate-existing', text: 'Vacate existing officer' }
                ];
                
                let optionsHtml = `
                    <div class="mt-3 card">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">Override Options</h6>
                        </div>
                        <div class="card-body">
                            <select class="form-select form-select-sm" id="override-option">
                                <option value="">Select an option...</option>
                `;
                
                options.forEach(option => {
                    optionsHtml += `<option value="${option.value}">${option.text}</option>`;
                });
                
                optionsHtml += `
                            </select>
                            <div id="override-details" class="mt-2"></div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-sm btn-primary" onclick="applyOverride()">Apply</button>
                                <button type="button" class="btn btn-sm btn-secondary" onclick="checkVacancies()">Cancel</button>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#vacancy-info').append(optionsHtml);
                
                $('#override-option').change(function() {
                    const option = $(this).val();
                    
                    if (option === 'vacate-existing') {
                        const officeId = $('#office_id').val();
                        const designationId = $('#designation_id').val();
                        
                        $.ajax({
                            url: "{{ route('admin.apps.hr.postings.current-officers') }}",
                            type: "GET",
                            data: { 
                                office_id: officeId,
                                designation_id: designationId
                            },
                            success: function(response) {
                                if (response.officers && response.officers.length > 0) {
                                    let html = `
                                        <div class="form-group">
                                            <label>Select officer to vacate:</label>
                                            <select class="form-select form-select-sm" id="officer-to-vacate">
                                    `;
                                    
                                    response.officers.forEach(officer => {
                                        html += `<option value="${officer.id}">${officer.name}</option>`;
                                    });
                                    
                                    html += `
                                            </select>
                                            <div class="mt-2">
                                                <label>Reason for vacating:</label>
                                                <select class="form-select form-select-sm" id="vacate-reason">
                                                    <option value="Transfer">Transfer</option>
                                                    <option value="Retirement">Retirement</option>
                                                    <option value="Suspension">Suspension</option>
                                                    <option value="OSD">OSD</option>
                                                </select>
                                            </div>
                                        </div>
                                    `;
                                    
                                    $('#override-details').html(html);
                                } else {
                                    $('#override-details').html('<div class="alert alert-danger">No officers found in this position.</div>');
                                }
                            }
                        });
                    } else if (option === 'convert-to-mutual') {
                        $('#posting_type').val('Mutual').trigger('change');
                        checkVacancies();
                    } else if (option === 'create-excess') {
                        $('#override-details').html(`
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                This will create a position in excess of the sanctioned strength. 
                                Add a justification below:
                            </div>
                            <textarea class="form-control form-control-sm" id="excess-justification" 
                                placeholder="Provide justification for exceeding sanctioned strength"></textarea>
                            <input type="hidden" name="override_sanctioned_post" value="true">
                        `);
                    } else {
                        $('#override-details').html('');
                    }
                });
            }

            function applyOverride() {
                const option = $('#override-option').val();
                
                if (option === 'vacate-existing') {
                    const officerId = $('#officer-to-vacate').val();
                    const reason = $('#vacate-reason').val();
                    
                    if (officerId && reason) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'vacate_officer_id',
                            value: officerId
                        }).appendTo('form');
                        
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'vacate_reason',
                            value: reason
                        }).appendTo('form');
                        
                        $('#vacancy-info').html(`
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>
                                Current officer will be vacated with reason: ${reason}
                            </div>
                        `);
                    }
                } else if (option === 'create-excess') {
                    const justification = $('#excess-justification').val();
                    
                    if (justification) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'excess_justification',
                            value: justification
                        }).appendTo('form');
                        
                        $('#vacancy-info').html(`
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>
                                Position will be created in excess of sanctioned strength
                            </div>
                        `);
                    } else {
                        alert('Please provide justification for exceeding sanctioned strength');
                    }
                }
            }

            function switchToRegularTransfer() {
                $('#posting_type').val('Transfer').trigger('change');
                checkVacancies();
            }

            function fetchDistrictInformation() {
                const officeId = $('#office_id').val();
                const userId = '{{ $data['user']->id }}';
                $.ajax({
                    url: "{{ route('admin.apps.hr.offices.district') }}",
                    type: "GET",
                    data: { office_id: officeId },
                    success: function(response) {
                        if (response.success) {
                            let html = '<div class="row">';
                            
                            // Direct district
                            html += '<div class="col-md-6">';
                            html += '<h6 class="mb-2">Direct District Assignment</h6>';
                            if (response.district) {
                                html += '<span class="badge bg-primary">' + response.district.name + '</span>';
                            } else {
                                html += '<span class="text-muted">No direct district assignment</span>';
                            }
                            html += '</div>';
                            
                            // Managed districts
                            html += '<div class="col-md-6">';
                            html += '<h6 class="mb-2">Managed Districts</h6>';
                            if (response.managed_districts && response.managed_districts.length > 0) {
                                response.managed_districts.forEach(function(district) {
                                    html += '<span class="badge bg-secondary mb-1 me-1">' + district.name + '</span>';
                                });
                            } else {
                                html += '<span class="text-muted">No managed districts</span>';
                            }
                            html += '</div>';
                            
                            html += '</div>';
                            
                            // Add info text
                            html += '<div class="form-text mt-3">' +
                                    '<small class="text-muted">' +
                                    '<i class="bi bi-info-circle me-1"></i>' +
                                    'District assignments are based on the office hierarchy. Higher-level office users manage districts of their subordinate offices.' +
                                    '</small>' +
                                    '</div>';
                            
                            $('#district-info-container').html(html);
                        }
                    },
                    error: function() {
                        $('#district-info-container').html(
                            '<div class="alert alert-danger">Error loading district information</div>'
                        );
                    }
                });
            }

            // Function to check sanctioned post vacancies
            function checkVacancies() {
                const officeId = $('#office_id').val();
                const designationId = $('#designation_id').val();
                const postingType = $('#posting_type').val();
                const userId = '{{ $data['user']->id }}';
                
                // Clear any previous messages
                $('#vacancy-info').html('');
                
                // Return early if not enough data
                if (!officeId || !designationId || !postingType) {
                    return;
                }
                
                $('#vacancy-info').html('<span class="text-info">Checking vacancy...</span>');
                
                // Special handling for different posting types
                if (postingType === 'Mutual') {
                    checkMutualTransferEligibility(userId, officeId, designationId);
                    return;
                }
                
                if (['Retirement', 'Suspension', 'OSD'].includes(postingType)) {
                    // For these types, we're just changing the officer's status
                    $('#vacancy-info').html(`<span class="text-info">User will be marked as ${postingType.toLowerCase()}. Current position will be vacated.</span>`);
                    return;
                }
                
                // For regular postings (Appointment, Transfer, Promotion)
                $.ajax({
                    url: "{{ route('admin.apps.hr.sanctioned-posts.available-positions') }}",
                    type: "GET",
                    data: {
                        office_id: officeId,
                        user_id: userId
                    },
                    dataType: 'json',
                    success: function(response) {
                        // If the response is empty, check if a sanctioned post exists at all
                        if (!response || response.length === 0) {
                            // Check if the sanctioned post exists without filtering
                            $.ajax({
                                url: "{{ route('admin.apps.hr.sanctioned-posts.check-exists') }}",
                                type: "GET",
                                data: {
                                    office_id: officeId,
                                    designation_id: designationId
                                },
                                dataType: 'json',
                                success: function(checkResponse) {
                                    if (checkResponse.exists) {
                                        // The post exists but is full
                                        $('#vacancy-info').html(`
                                            <span class="text-danger">No vacancy available. (${checkResponse.filled}/${checkResponse.total} positions filled)</span>
                                            <button type="button" class="btn btn-sm btn-outline-warning mt-2" 
                                                onclick="showOverrideOptions('${postingType}')">
                                                Override Options
                                            </button>
                                        `);
                                    } else {
                                        // The sanctioned post doesn't exist at all
                                        $('#vacancy-info').html(`
                                            <span class="text-danger">This position is not sanctioned for the selected office.</span>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" 
                                                onclick="createSanctionedPost()">
                                                Create Sanctioned Post
                                            </button>
                                        `);
                                    }
                                },
                                error: function() {
                                    $('#vacancy-info').html('<span class="text-danger">Error checking sanctioned post.</span>');
                                }
                            });
                            return;
                        }
                        
                        // Try to find the position by ID (convert both to strings for comparison)
                        let position = response.find(p => String(p.id) === String(designationId));
                        
                        if (position) {
                            if (position.is_full && !position.current_user) {
                                $('#vacancy-info').html(`
                                    <span class="text-danger">No vacancy available. (${position.filled}/${position.total} positions filled)</span>
                                    <button type="button" class="btn btn-sm btn-outline-warning mt-2" 
                                        onclick="showOverrideOptions('${postingType}')">
                                        Override Options
                                    </button>
                                `);
                            } else {
                                $('#vacancy-info').html(`<span class="text-success">Vacancy available. (${position.filled}/${position.total} positions filled)</span>`);
                            }
                        } else {
                            // Position wasn't found in the response
                            $('#vacancy-info').html(`
                                <span class="text-danger">This position is not sanctioned for the selected office.</span>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" 
                                    onclick="createSanctionedPost()">
                                    Create Sanctioned Post
                                </button>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#vacancy-info').html('<span class="text-danger">Error checking vacancy.</span>');
                    }
                });
            }

            // Attach event handlers when creating or editing postings
            $(document).on('shown.bs.modal', function (e) {
                const modal = $(e.target);
                
                // Check if this is a posting-related modal
                if (modal.find('#posting_type, #office_id, #designation_id').length > 0) {
                    // Check vacancies when office or designation changes
                    modal.find('#office_id, #designation_id, #posting_type').change(function() {
                        checkVacancies();
                        fetchDistrictInformation();
                    });

                    // Initial check if values are already set
                    if (modal.find('#office_id').val() && modal.find('#designation_id').val()) {
                        checkVacancies();
                        fetchDistrictInformation();
                    }
                }
            });
        });
    </script>
    @endpush
</x-hr-layout>