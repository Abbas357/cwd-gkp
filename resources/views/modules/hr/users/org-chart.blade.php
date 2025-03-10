<x-hr-layout>
    @push('style')
    <style>
        .org-chart {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .office-node {
            border: 2px solid #3498db;
            border-radius: 5px;
            padding: 10px;
            margin: 5px;
            background-color: #f8f9fa;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .office-node:hover {
            background-color: #e2e6ea;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .office-children {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 20px;
            width: 100%;
        }
        
        .office-branch {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 10px;
            position: relative;
        }
        
        .branch-line {
            border-left: 2px solid #95a5a6;
            height: 20px;
            margin-bottom: 5px;
        }
        
        .user-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 5px;
            width: 220px;
            background-color: white;
            transition: all 0.3s;
        }
        
        .user-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .user-card .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .hierarchy-view {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Organization Chart</li>
    </x-slot>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Offices</h5>
                </div>
                <div class="card-body">
                    <div id="office-tree">
                        @foreach($topOffices as $office)
                            <div class="office-item mb-2">
                                <a href="#" class="load-office" data-id="{{ $office->id }}">
                                    <i class="bi bi-building"></i> {{ $office->name }}
                                </a>
                                <div class="children-container ms-4" id="children-{{ $office->id }}">
                                    <!-- Child offices will be loaded here -->
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">User Search</h5>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="text" id="user-search" class="form-control" placeholder="Search for a user...">
                        <button class="btn btn-primary" id="search-btn" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div id="search-results" class="mt-3">
                        <!-- Search results will appear here -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0" id="office-heading">Organization Hierarchy</h5>
                </div>
                <div class="card-body">
                    <div id="org-chart-container">
                        <div class="text-center p-5">
                            <i class="bi bi-building fs-1 text-muted"></i>
                            <p class="mt-3">Select an office from the left to view its hierarchy.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">User Reporting Relationship</h5>
                </div>
                <div class="card-body">
                    <div id="user-relationship-container">
                        <div class="text-center p-5">
                            <i class="bi bi-people fs-1 text-muted"></i>
                            <p class="mt-3">Select a user to view their reporting relationships.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script>
        $(document).ready(function() {
            // Load child offices
            function loadChildOffices(officeId, containerSelector) {
                $.ajax({
                    url: "{{ route('admin.apps.hr.office-hierarchy') }}",
                    type: "GET",
                    data: { office_id: officeId },
                    success: function(response) {
                        let html = '';
                        
                        if (response.childOffices.length > 0) {
                            $.each(response.childOffices, function(index, office) {
                                html += `<div class="office-item mb-2">
                                    <a href="#" class="load-office" data-id="${office.id}">
                                        <i class="bi bi-building"></i> ${office.name}
                                    </a>
                                    <div class="children-container ms-4" id="children-${office.id}">
                                        <!-- Child offices will be loaded here -->
                                    </div>
                                </div>`;
                            });
                        }
                        
                        $(containerSelector).html(html);
                        
                        // Attach click event to newly created elements
                        $(containerSelector).find('.load-office').on('click', function(e) {
                            e.preventDefault();
                            const childOfficeId = $(this).data('id');
                            loadOfficeHierarchy(childOfficeId);
                            loadChildOffices(childOfficeId, `#children-${childOfficeId}`);
                        });
                    }
                });
            }
            
            // Load office hierarchy
            function loadOfficeHierarchy(officeId) {
                $.ajax({
                    url: "{{ route('admin.apps.hr.office-hierarchy') }}",
                    type: "GET",
                    data: { office_id: officeId },
                    success: function(response) {
                        const office = response.office;
                        const users = response.users;
                        const childOffices = response.childOffices;
                        
                        $('#office-heading').text(`${office.name} Organization`);
                        
                        let html = `<div class="hierarchy-view">
                            <div class="office-node" data-id="${office.id}">
                                <h5>${office.name}</h5>
                                <p class="mb-0 text-muted small">${office.type || 'Office'}</p>
                            </div>
                            
                            <div class="users-container mt-3">
                                <h6 class="mb-3">Users in this office:</h6>
                                <div class="row">`;
                        
                        if (users.length > 0) {
                            $.each(users, function(index, user) {
                                const designation = user.current_designation ? user.current_designation.name : 'No Designation';
                                const bps = user.current_designation && user.current_designation.bps ? `(BPS-${user.current_designation.bps})` : '';
                                
                                html += `<div class="col-md-6 mb-3">
                                    <div class="user-card">
                                        <div class="d-flex align-items-center">
                                            <img src="${getUserAvatar(user)}" class="avatar me-3">
                                            <div>
                                                <h6 class="mb-0">${user.name}</h6>
                                                <p class="mb-0 text-muted small">${designation} ${bps}</p>
                                                <a href="#" class="view-relationships small" data-id="${user.id}">View Relationships</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            });
                        } else {
                            html += `<div class="col-12">
                                <div class="alert alert-info">No users are currently assigned to this office.</div>
                            </div>`;
                        }
                        
                        html += `</div>
                            </div>`;
                            
                        if (childOffices.length > 0) {
                            html += `<div class="child-offices mt-4">
                                <h6 class="mb-3">Sub-offices:</h6>
                                <div class="row">`;
                                
                            $.each(childOffices, function(index, childOffice) {
                                html += `<div class="col-md-4 mb-3">
                                    <div class="office-node" data-id="${childOffice.id}" onclick="loadOfficeHierarchy(${childOffice.id})">
                                        <h6>${childOffice.name}</h6>
                                        <p class="mb-0 text-muted small">${childOffice.type || 'Office'}</p>
                                    </div>
                                </div>`;
                            });
                            
                            html += `</div>
                            </div>`;
                        }
                        
                        html += `</div>`;
                        
                        $('#org-chart-container').html(html);
                        
                        // Attach click events
                        $('.view-relationships').on('click', function(e) {
                            e.preventDefault();
                            const userId = $(this).data('id');
                            loadUserRelationships(userId);
                        });
                        
                        $('.office-node').on('click', function() {
                            const clickedOfficeId = $(this).data('id');
                            loadOfficeHierarchy(clickedOfficeId);
                        });
                    }
                });
            }
            
            // Load user relationships
            function loadUserRelationships(userId) {
                $.ajax({
                    url: "{{ route('admin.apps.hr.user-relationships') }}",
                    type: "GET",
                    data: { user_id: userId },
                    success: function(response) {
                        const user = response.user;
                        const supervisors = response.supervisors;
                        const directSupervisor = response.directSupervisor;
                        const subordinates = response.subordinates;
                        
                        let html = `<div class="user-relationship">
                            <div class="text-center mb-4">
                                <img src="${getUserAvatar(user)}" class="avatar mb-2" style="width: 80px; height: 80px;">
                                <h5>${user.name}</h5>
                                <p class="mb-0">${user.current_designation ? user.current_designation.name : 'No Designation'}</p>
                                <p class="text-muted small">${user.current_office ? user.current_office.name : 'No Office'}</p>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Reports To</h6>
                                        </div>
                                        <div class="card-body">`;
                        
                        if (directSupervisor) {
                            html += `<div class="user-card mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="${getUserAvatar(directSupervisor)}" class="avatar me-3">
                                    <div>
                                        <h6 class="mb-0">${directSupervisor.name}</h6>
                                        <p class="mb-0 text-muted small">${directSupervisor.current_designation ? directSupervisor.current_designation.name : 'No Designation'}</p>
                                        <p class="mb-0 text-muted small">${directSupervisor.current_office ? directSupervisor.current_office.name : 'No Office'}</p>
                                    </div>
                                </div>
                            </div>`;
                        } else if (supervisors.length > 0) {
                            $.each(supervisors, function(index, supervisor) {
                                html += `<div class="user-card mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="${getUserAvatar(supervisor)}" class="avatar me-3">
                                        <div>
                                            <h6 class="mb-0">${supervisor.name}</h6>
                                            <p class="mb-0 text-muted small">${supervisor.current_designation ? supervisor.current_designation.name : 'No Designation'}</p>
                                            <p class="mb-0 text-muted small">${supervisor.current_office ? supervisor.current_office.name : 'No Office'}</p>
                                        </div>
                                    </div>
                                </div>`;
                            });
                        } else {
                            html += `<div class="alert alert-info">No supervisors found for this user.</div>`;
                        }
                        
                        html += `</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Subordinates</h6>
                                        </div>
                                        <div class="card-body">`;
                        
                        if (subordinates.length > 0) {
                            $.each(subordinates, function(index, subordinate) {
                                html += `<div class="user-card mb-3">
                                    <div class="d-flex align-items-center">
                                        <img src="${getUserAvatar(subordinate)}" class="avatar me-3">
                                        <div>
                                            <h6 class="mb-0">${subordinate.name}</h6>
                                            <p class="mb-0 text-muted small">${subordinate.current_designation ? subordinate.current_designation.name : 'No Designation'}</p>
                                            <p class="mb-0 text-muted small">${subordinate.current_office ? subordinate.current_office.name : 'No Office'}</p>
                                        </div>
                                    </div>
                                </div>`;
                            });
                        } else {
                            html += `<div class="alert alert-info">No subordinates found for this user.</div>`;
                        }
                        
                        html += `</div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        
                        $('#user-relationship-container').html(html);
                    }
                });
            }
            
            // Helper to get user avatar
            function getUserAvatar(user) {
                // This should be replaced with your actual method of getting user avatars
                return "{{ asset('admin/images/no-profile.png') }}";
            }
            
            // Initial event binding
            $('.load-office').on('click', function(e) {
                e.preventDefault();
                const officeId = $(this).data('id');
                loadOfficeHierarchy(officeId);
                loadChildOffices(officeId, `#children-${officeId}`);
            });
            
            // Search users
            $('#search-btn').on('click', function() {
                const query = $('#user-search').val();
                if (query.trim().length < 2) {
                    alert('Please enter at least 2 characters');
                    return;
                }
                
                $.ajax({
                    url: "{{ route('admin.apps.hr.users.api') }}",
                    type: "GET",
                    data: { q: query },
                    success: function(response) {
                        let html = '';
                        
                        if (response.results.length > 0) {
                            $.each(response.results, function(index, result) {
                                html += `<div class="user-item mb-2">
                                    <a href="#" class="view-relationships" data-id="${result.id}">
                                        <i class="bi bi-person"></i> ${result.text}
                                    </a>
                                </div>`;
                            });
                        } else {
                            html = '<div class="alert alert-info">No users found</div>';
                        }
                        
                        $('#search-results').html(html);
                        
                        // Attach click event to search results
                        $('#search-results').find('.view-relationships').on('click', function(e) {
                            e.preventDefault();
                            const userId = $(this).data('id');
                            loadUserRelationships(userId);
                        });
                    }
                });
            });
            
            // Allow search on enter press
            $('#user-search').on('keypress', function(e) {
                if (e.which === 13) {
                    $('#search-btn').click();
                }
            });
        });
    </script>
    @endpush
</x-hr-layout>