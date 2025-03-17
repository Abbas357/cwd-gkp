<x-hr-layout title="Employee Directory">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/printThis/printThis.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #f8f9fa;
            --border-radius: 0.5rem;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }
        
        .directory-card {
            transition: var(--transition);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            height: 100%;
        }
        
        .directory-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .card-header-img {
            height: 120px;
            background: linear-gradient(135deg, #4361ee, #3a56d4);
            position: relative;
        }
        
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            position: absolute;
            bottom: -50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #fff;
            object-fit: cover;
        }
        
        .card-user-details {
            padding-top: 60px;
            text-align: center;
        }
        
        .user-name {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .user-designation {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .user-office {
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 50px;
            display: inline-block;
            font-size: 0.8rem;
            margin-bottom: 15px;
        }
        
        .user-contact-info {
            padding: 15px;
            border-top: 1px solid #eee;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .contact-icon {
            width: 30px;
            height: 30px;
            background: #f0f4f8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
        }
        
        .filter-section {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid #e9ecef;
        }
        
        .btn-view-profile {
            background: #f0f4f8;
            color: #4361ee;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-view-profile:hover {
            background: #4361ee;
            color: white;
        }
        
        .cw-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            transition: var(--transition);
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.2);
        }
        
        .cw-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(67, 97, 238, 0.3);
            color: white;
        }
        
        /* List View Styles */
        .user-list-item {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border-left: 3px solid #4361ee;
        }
        
        .user-list-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .list-user-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-list-details {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .list-user-name {
            font-weight: 600;
            margin-bottom: 0;
        }
        
        .list-user-designation {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .view-toggle-btn {
            border-radius: 50px;
            padding: 8px 16px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        .view-toggle-btn.active {
            background: #4361ee;
            color: white;
            border-color: #4361ee;
        }
        
        /* BPS Badge Styles */
        .bps-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 5px;
        }
        
        .bps-1-5 {
            background-color: #e9f5e9;
            color: #28a745;
        }
        
        .bps-6-10 {
            background-color: #e8eaff;
            color: #4361ee;
        }
        
        .bps-11-16 {
            background-color: #fff8e8;
            color: #ffc107;
        }
        
        .bps-17-19 {
            background-color: #ffe8e8;
            color: #dc3545;
        }
        
        .bps-20-22 {
            background-color: #e8e8e8;
            color: #343a40;
        }
        
        /* Print Styling */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
            }
            
            .directory-card, .user-list-item {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
                break-inside: avoid;
            }
            
            .card-header-img {
                height: 80px;
            }
            
            .profile-img {
                width: 70px;
                height: 70px;
                bottom: -35px;
            }
            
            .card-user-details {
                padding-top: 40px;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.index') }}">HR</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.reports.employees') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Employee Directory</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Employee Directory</h3>
                    <div class="d-flex gap-2">
                        <div class="btn-group no-print">
                            <button type="button" class="view-toggle-btn active" id="grid-view-btn">
                                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Grid
                            </button>
                            <button type="button" class="view-toggle-btn" id="list-view-btn">
                                <i class="bi bi-list-ul me-1"></i> List
                            </button>
                        </div>
                        <button type="button" id="print-directory" class="no-print btn btn-primary btn-sm">
                            <span class="d-flex align-items-center">
                                <i class="bi-printer me-2"></i>
                                Print Directory
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="col-12 p-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-muted mb-0 fs-5">Filter Options</h4>
                        <button type="button" id="toggleFilters" class="btn btn-sm btn-outline-secondary">
                            <i class="bi-chevron-up" id="filterIcon"></i>
                            <span id="filterText">Hide Filters</span>
                        </button>
                    </div>
                    <hr class="mt-2">
                </div>

                <form method="GET" class="filter-section">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label" for="office_id">
                                Office
                            </label>
                            <select name="office_id" id="office_id" class="form-select select2" data-placeholder="Select Office">
                                <option value="">All Offices</option>
                                @foreach($allOffices as $office)
                                    <option value="{{ $office->id }}" @selected($filters['office_id'] == $office->id)>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="designation_id">
                                Designation
                            </label>
                            <select name="designation_id" id="designation_id" class="form-select select2" data-placeholder="Select Designation">
                                <option value="">All Designations</option>
                                @foreach($designations as $designation)
                                    <option value="{{ $designation->id }}" @selected($filters['designation_id'] == $designation->id)>
                                        {{ $designation->name }} ({{ $designation->bps }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="bps">
                                BPS
                            </label>
                            <select name="bps" id="bps" class="form-select select2" data-placeholder="Select BPS">
                                <option value="">All BPS</option>
                                @foreach($bpsValues as $bps)
                                    <option value="{{ $bps }}" @selected($filters['bps'] == $bps)>
                                        {{ $bps }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="district_id">
                                District
                            </label>
                            <select name="district_id" id="district_id" class="form-select select2" data-placeholder="Select District">
                                <option value="">All Districts</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}" @selected($filters['district_id'] == $district->id)>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="posting_type">
                                Posting Type
                            </label>
                            <select name="posting_type" id="posting_type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($postingTypes as $type)
                                    <option value="{{ $type }}" @selected($filters['posting_type'] == $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="status">
                                Status
                            </label>
                            <select name="status" id="status" class="form-select">
                                <option value="Active" @selected($filters['status'] == 'Active')>Active</option>
                                <option value="Inactive" @selected($filters['status'] == 'Inactive')>Inactive</option>
                                <option value="Archived" @selected($filters['status'] == 'Archived')>Archived</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="search">
                                Search
                            </label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   placeholder="Name, Email, CNIC, Mobile" value="{{ $filters['search'] }}">
                        </div>
                        
                        <div class="col-md-12 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="include_subordinates" 
                                       name="include_subordinates" value="1" 
                                       @checked($filters['include_subordinates'])>
                                <label class="form-check-label" for="include_subordinates">
                                    Include subordinate offices (when office is selected)
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-3">
                            <hr>
                            <div class="d-flex gap-2">
                                <button type="submit" class="cw-btn">
                                    <i class="bi-filter me-2"></i> APPLY FILTERS
                                </button>
                                <a href="{{ route('admin.apps.hr.reports.employees') }}" class="btn btn-outline-secondary">
                                    <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                    <div>
                        <h5 class="m-0">
                            Found <span class="text-primary fw-bold">{{ $users->total() }}</span> employees
                            @if($filters['search'])
                                matching "<span class="text-primary">{{ $filters['search'] }}</span>"
                            @endif
                        </h5>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-2">Display:</span>
                        <select id="per-page-selector" class="form-select form-select-sm" style="width: auto;">
                            <option value="10" @selected($perPage == 10)>10 per page</option>
                            <option value="20" @selected($perPage == 20)>20 per page</option>
                            <option value="50" @selected($perPage == 50)>50 per page</option>
                            <option value="100" @selected($perPage == 100)>100 per page</option>
                        </select>
                    </div>
                </div>

                <!-- Grid View -->
                <div id="grid-view" class="row g-3">
                    @forelse($users as $user)
                        @php
                            // Get BPS class based on the BPS grade
                            $bpsClass = '';
                            $bpsNumber = 0;
                            $bps = $user->currentPosting->designation->bps ?? '';
                            
                            if (preg_match('/(\d+)/', $bps, $matches)) {
                                $bpsNumber = (int)$matches[1];
                                
                                if ($bpsNumber >= 1 && $bpsNumber <= 5) {
                                    $bpsClass = 'bps-1-5';
                                } elseif ($bpsNumber >= 6 && $bpsNumber <= 10) {
                                    $bpsClass = 'bps-6-10';
                                } elseif ($bpsNumber >= 11 && $bpsNumber <= 16) {
                                    $bpsClass = 'bps-11-16';
                                } elseif ($bpsNumber >= 17 && $bpsNumber <= 19) {
                                    $bpsClass = 'bps-17-19';
                                } else {
                                    $bpsClass = 'bps-20-22';
                                }
                            }
                        @endphp
                        
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="directory-card">
                                <div class="card-header-img">
                                    <img src="{{ $user->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.jpg') }}" 
                                         alt="{{ $user->name }}" class="profile-img">
                                </div>
                                <div class="card-user-details p-3">
                                    <h3 class="user-name">{{ $user->name }}</h3>
                                    <p class="user-designation mb-1">
                                        {{ $user->currentPosting->designation->name ?? 'N/A' }}
                                        @if($bps)
                                            <span class="bps-badge {{ $bpsClass }}">{{ $bps }}</span>
                                        @endif
                                    </p>
                                    <div class="user-office">
                                        <i class="bi bi-building me-1"></i>
                                        {{ $user->currentPosting->office->name ?? 'N/A' }}
                                    </div>
                                    
                                    <a href="{{ route('admin.apps.hr.users.employee', $user->uuid) }}" 
                                       class="btn-view-profile">
                                        <i class="bi bi-eye"></i> View Profile
                                    </a>
                                </div>
                                <div class="user-contact-info">
                                    @if($user->profile && $user->profile->mobile_number)
                                        <div class="contact-item">
                                            <div class="contact-icon">
                                                <i class="bi bi-phone"></i>
                                            </div>
                                            <div>{{ $user->profile->mobile_number }}</div>
                                        </div>
                                    @endif
                                    
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <i class="bi bi-envelope"></i>
                                        </div>
                                        <div class="text-truncate">{{ $user->email }}</div>
                                    </div>
                                    
                                    @if($user->profile && $user->profile->cnic)
                                        <div class="contact-item">
                                            <div class="contact-icon">
                                                <i class="bi bi-person-badge"></i>
                                            </div>
                                            <div>{{ $user->profile->cnic }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-person-x" style="font-size: 3rem; color: #ddd;"></i>
                            <h4 class="mt-3">No employees found</h4>
                            <p class="text-muted">Try adjusting your search or filter criteria</p>
                            <a href="{{ route('admin.apps.hr.reports.employees') }}" class="btn btn-outline-primary mt-2">
                                Reset Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- List View (Hidden by Default) -->
                <div id="list-view" class="d-none">
                    @forelse($users as $user)
                        @php
                            // Get BPS class based on the BPS grade
                            $bpsClass = '';
                            $bpsNumber = 0;
                            $bps = $user->currentPosting->designation->bps ?? '';
                            
                            if (preg_match('/(\d+)/', $bps, $matches)) {
                                $bpsNumber = (int)$matches[1];
                                
                                if ($bpsNumber >= 1 && $bpsNumber <= 5) {
                                    $bpsClass = 'bps-1-5';
                                } elseif ($bpsNumber >= 6 && $bpsNumber <= 10) {
                                    $bpsClass = 'bps-6-10';
                                } elseif ($bpsNumber >= 11 && $bpsNumber <= 16) {
                                    $bpsClass = 'bps-11-16';
                                } elseif ($bpsNumber >= 17 && $bpsNumber <= 19) {
                                    $bpsClass = 'bps-17-19';
                                } else {
                                    $bpsClass = 'bps-20-22';
                                }
                            }
                        @endphp
                        
                        <div class="user-list-item bg-white p-3">
                            <div class="row align-items-center">
                                <div class="col-md-1">
                                    <img src="{{ $user->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.jpg') }}" 
                                         alt="{{ $user->name }}" class="list-user-img">
                                </div>
                                <div class="col-md-3">
                                    <div class="user-list-details">
                                        <h5 class="list-user-name">{{ $user->name }}</h5>
                                        <p class="list-user-designation mb-0">
                                            {{ $user->currentPosting->designation->name ?? 'N/A' }}
                                            @if($bps)
                                                <span class="bps-badge {{ $bpsClass }}">{{ $bps }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building me-2"></i>
                                        <span>{{ $user->currentPosting->office->name ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-envelope me-2"></i>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                    @if($user->profile && $user->profile->mobile_number)
                                        <div class="d-flex align-items-center mt-1">
                                            <i class="bi bi-phone me-2"></i>
                                            <span>{{ $user->profile->mobile_number }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-2 text-end">
                                    <a href="{{ route('admin.apps.hr.users.employee', $user->uuid) }}" 
                                       class="btn-view-profile">
                                        <i class="bi bi-eye"></i> View Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-person-x" style="font-size: 3rem; color: #ddd;"></i>
                            <h4 class="mt-3">No employees found</h4>
                            <p class="text-muted">Try adjusting your search or filter criteria</p>
                            <a href="{{ route('admin.apps.hr.reports.employees') }}" class="btn btn-outline-primary mt-2">
                                Reset Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} 
                        of {{ $users->total() }} employees
                    </div>
                    
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: "bootstrap-5",
                dropdownParent: $(this).parent(),
                width: '100%'
            });
            
            // Toggle filters
            $('#toggleFilters').on('click', function() {
                $('.filter-section').slideToggle(300);
                
                if ($('#filterIcon').hasClass('bi-chevron-up')) {
                    $('#filterIcon').removeClass('bi-chevron-up').addClass('bi-chevron-down');
                    $('#filterText').text('Show Filters');
                } else {
                    $('#filterIcon').removeClass('bi-chevron-down').addClass('bi-chevron-up');
                    $('#filterText').text('Hide Filters');
                }
            });
            
            // Grid and List view toggle
            $('#grid-view-btn').on('click', function() {
                $('#grid-view').removeClass('d-none');
                $('#list-view').addClass('d-none');
                $(this).addClass('active');
                $('#list-view-btn').removeClass('active');
                localStorage.setItem('directory-view', 'grid');
            });
            
            $('#list-view-btn').on('click', function() {
                $('#list-view').removeClass('d-none');
                $('#grid-view').addClass('d-none');
                $(this).addClass('active');
                $('#grid-view-btn').removeClass('active');
                localStorage.setItem('directory-view', 'list');
            });
            
            // Check if user has a preferred view saved
            const savedView = localStorage.getItem('directory-view');
            if (savedView === 'list') {
                $('#list-view-btn').click();
            }
            
            // Per page selector
            $('#per-page-selector').on('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', $(this).val());
                window.location.href = url.toString();
            });
            
            // Print directory
            $('#print-directory').on('click', function() {
                const printTitle = "Employee Directory";
                const currentView = $('#grid-view').hasClass('d-none') ? 'list' : 'grid';
                
                if (currentView === 'grid') {
                    $("#grid-view").printThis({
                        importCSS: true,
                        importStyle: true,
                        loadCSS: "{{ asset('admin/css/print.css') }}",
                        header: `<h1 class='text-center mb-4'>${printTitle}</h1>
                                <p class='text-center text-muted mb-4'>Generated on ${new Date().toLocaleDateString()}</p>`,
                        footer: `<p class='text-center mt-4'>&copy; ${new Date().getFullYear()} Communication & Works Department</p>`,
                    });
                } else {
                    $("#list-view").printThis({
                        importCSS: true,
                        importStyle: true,
                        loadCSS: "{{ asset('admin/css/print.css') }}",
                        header: `<h1 class='text-center mb-4'>${printTitle}</h1>
                                <p class='text-center text-muted mb-4'>Generated on ${new Date().toLocaleDateString()}</p>`,
                        footer: `<p class='text-center mt-4'>&copy; ${new Date().getFullYear()} Communication & Works Department</p>`,
                    });
                }
            });
        });
    </script>
    @endpush
</x-hr-layout>