<x-hr-layout title="Office Strength Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/chartjs/css/chart.min.css') }}" rel="stylesheet">
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
        
        .office-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            height: 100%;
            transition: var(--transition);
            border-top: 4px solid #4361ee;
        }
        
        .office-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .card-header-bg {
            height: 80px;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            position: relative;
            overflow: hidden;
        }
        
        .card-header-bg::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('admin/images/pattern.svg') }}') repeat;
            opacity: 0.1;
        }
        
        .office-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #212529;
            margin-bottom: 10px;
        }
        
        .office-info {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 15px;
        }
        
        .office-level {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            background-color: #e9ecef;
            color: #495057;
            margin-bottom: 15px;
        }
        
        .office-district {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            background-color: #e8eaff;
            color: #4361ee;
            margin-left: 5px;
        }
        
        .staff-count {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
            margin-top: 15px;
        }
        
        .count-item {
            text-align: center;
            padding: 0 10px;
            border-right: 1px dashed #e9ecef;
            flex: 1;
        }
        
        .count-item:last-child {
            border-right: none;
        }
        
        .count-value {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
            color: #212529;
        }
        
        .count-label {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .count-sanctioned .count-value {
            color: #4361ee;
        }
        
        .count-filled .count-value {
            color: #2ecc71;
        }
        
        .count-vacant .count-value {
            color: #e74c3c;
        }
        
        .progress-bar-container {
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
            margin-top: 15px;
            overflow: hidden;
        }
        
        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(to right, #2ecc71, #4361ee);
            border-radius: 3px;
            transition: width 0.5s ease;
        }
        
        .staff-list {
            margin-top: 15px;
            border-top: 1px solid #e9ecef;
            padding-top: 15px;
        }
        
        .staff-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #e9ecef;
        }
        
        .staff-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .staff-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .staff-details {
            flex: 1;
        }
        
        .staff-name {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 2px;
            color: #212529;
        }
        
        .staff-designation {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .filter-section {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid #e9ecef;
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
        
        .summary-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .summary-card .icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .summary-card.primary .icon {
            background: linear-gradient(135deg, #4361ee, #3a56d4);
        }

        .summary-card.success .icon {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }

        .summary-card.warning .icon {
            background: linear-gradient(135deg, #f39c12, #e67e22);
        }

        .summary-card.danger .icon {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .summary-card .card-title {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .summary-card .card-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        /* Responsive tables for mobile */
        @media (max-width: 767.98px) {
            .table-responsive-custom {
                display: block;
                width: 100%;
                overflow-x: auto;
            }
            
            .table-responsive-custom thead {
                display: none;
            }
            
            .table-responsive-custom tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 10px;
            }
            
            .table-responsive-custom tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                border-bottom: 1px dashed #e9ecef;
            }
            
            .table-responsive-custom tbody td:last-child {
                border-bottom: none;
            }
            
            .table-responsive-custom tbody td:before {
                content: attr(data-label);
                font-weight: 600;
                margin-right: 10px;
            }
        }
        
        /* Print Styling */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
            }
            
            .office-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
                page-break-inside: avoid;
            }
            
            .filter-section, .summary-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
        }
    </style>
@endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.index') }}">HR</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.reports.office-strength') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Office Strength Report</li>
    </x-slot>

    <div class="wrapper">
        <!-- Dashboard Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card summary-card primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon me-3">
                            <i class="bi bi-building"></i>
                        </div>
                        <div>
                            <div class="card-title">TOTAL OFFICES</div>
                            <div class="card-value">{{ number_format($totalOffices) }}</div>
                            <div class="text-muted">Active offices</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card summary-card success h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon me-3">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <div>
                            <div class="card-title">FILLED POSITIONS</div>
                            <div class="card-value">{{ number_format($totalFilled) }}</div>
                            <div class="text-muted">{{ $totalSanctioned > 0 ? round(($totalFilled / $totalSanctioned) * 100, 1) : 0 }}% of total</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card summary-card danger h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon me-3">
                            <i class="bi bi-person-dash"></i>
                        </div>
                        <div>
                            <div class="card-title">VACANT POSITIONS</div>
                            <div class="card-value">{{ number_format($totalVacant) }}</div>
                            <div class="text-muted">{{ $totalSanctioned > 0 ? round(($totalVacant / $totalSanctioned) * 100, 1) : 0 }}% of total</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card summary-card warning h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon me-3">
                            <i class="bi bi-diagram-3"></i>
                        </div>
                        <div>
                            <div class="card-title">SANCTIONED POSTS</div>
                            <div class="card-value">{{ number_format($totalSanctioned) }}</div>
                            <div class="text-muted">Department-wide</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Office Strength Report</h3>
                    <div class="d-flex gap-2">
                        <div class="btn-group no-print">
                            <button type="button" class="view-toggle-btn active" id="card-view-btn">
                                <i class="bi bi-grid-3x3-gap-fill me-1"></i> Card View
                            </button>
                            <button type="button" class="view-toggle-btn" id="table-view-btn">
                                <i class="bi bi-table me-1"></i> Table View
                            </button>
                        </div>
                        <button type="button" id="print-report" class="no-print btn btn-primary btn-sm">
                            <span class="d-flex align-items-center">
                                <i class="bi-printer me-2"></i>
                                Print Report
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
                            <label class="form-label" for="level">
                                Office Level
                            </label>
                            <select name="level" id="level" class="form-select">
                                <option value="">All Levels</option>
                                @foreach($officeLevels as $level)
                                    <option value="{{ $level }}" @selected($filters['level'] == $level)>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
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

                        <div class="col-md-6">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="show_details" 
                                       name="show_details" value="1" 
                                       @checked($filters['show_details'])>
                                <label class="form-check-label" for="show_details">
                                    Show staff details for each office
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-md-6 text-end">
                            <label class="form-label" for="per_page">Records per page</label>
                            <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                <option value="15" @selected($perPage == 15)>15</option>
                                <option value="30" @selected($perPage == 30)>30</option>
                                <option value="50" @selected($perPage == 50)>50</option>
                                <option value="100" @selected($perPage == 100)>100</option>
                                <option value="all" @selected($perPage == 'all')>All</option>
                            </select>
                        </div>
                        
                        <div class="col-12 mt-3">
                            <hr>
                            <div class="d-flex gap-2">
                                <button type="submit" class="cw-btn">
                                    <i class="bi-filter me-2"></i> APPLY FILTERS
                                </button>
                                <a href="{{ route('admin.apps.hr.reports.office-strength') }}" class="btn btn-outline-secondary">
                                    <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Card View -->
                <div id="card-view" class="row g-3 mt-3">
                    @forelse($offices as $office)
                        @php
                            $fillPercentage = $office->sanctioned_positions > 0 ? 
                                ($office->filled_positions / $office->sanctioned_positions) * 100 : 0;
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="office-card bg-white p-3">
                                <div class="card-header-bg mb-3"></div>
                                <h3 class="office-title">{{ $office->name }}</h3>
                                <div class="office-info">
                                    <span class="office-level">{{ $office->level ?? 'N/A' }}</span>
                                    @if($office->district)
                                        <span class="office-district">{{ $office->district->name }}</span>
                                    @endif
                                </div>
                                
                                <div class="staff-count">
                                    <div class="count-item count-sanctioned">
                                        <span class="count-value">{{ $office->sanctioned_positions }}</span>
                                        <span class="count-label">Sanctioned</span>
                                    </div>
                                    <div class="count-item count-filled">
                                        <span class="count-value">{{ $office->filled_positions }}</span>
                                        <span class="count-label">Filled</span>
                                    </div>
                                    <div class="count-item count-vacant">
                                        <span class="count-value">{{ $office->vacant_positions }}</span>
                                        <span class="count-label">Vacant</span>
                                    </div>
                                </div>
                                
                                <div class="progress-bar-container">
                                    <div class="progress-bar-fill" style="width: {{ $fillPercentage }}%;"></div>
                                </div>
                                <div class="text-center mt-2">
                                    <small class="text-muted">{{ round($fillPercentage, 1) }}% filled</small>
                                </div>
                                
                                @if($filters['show_details'] && isset($office->staff) && $office->staff->count() > 0)
                                    <div class="staff-list">
                                        <h6 class="mb-3">Staff Members ({{ $office->staff->count() }})</h6>
                                        @foreach($office->staff->take(5) as $staff)
                                            <div class="staff-item">
                                                <img src="{{ $staff->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.jpg') }}" 
                                                     alt="{{ $staff->name }}" class="staff-avatar">
                                                <div class="staff-details">
                                                    <div class="staff-name">{{ $staff->name }}</div>
                                                    <div class="staff-designation">
                                                        {{ $staff->currentPosting->designation->name ?? 'N/A' }}
                                                        @if($staff->currentPosting && $staff->currentPosting->designation)
                                                            <small>({{ $staff->currentPosting->designation->bps ?? 'N/A' }})</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        @if($office->staff->count() > 5)
                                            <div class="text-center mt-2">
                                                <a href="#" class="btn btn-sm btn-outline-primary view-all-staff" 
                                                   data-office-id="{{ $office->id }}" data-office-name="{{ $office->name }}">
                                                    View all {{ $office->staff->count() }} staff members
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <i class="bi bi-building-x" style="font-size: 3rem; color: #ddd;"></i>
                            <h4 class="mt-3">No offices found</h4>
                            <p class="text-muted">Try adjusting your filter criteria</p>
                            <a href="{{ route('admin.apps.hr.reports.office-strength') }}" class="btn btn-outline-primary mt-2">
                                Reset Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Table View -->
                <div id="table-view" class="d-none">
                    <div class="table-responsive-custom">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Office Name</th>
                                    <th>Level</th>
                                    <th>District</th>
                                    <th class="text-center">Sanctioned Posts</th>
                                    <th class="text-center">Filled Posts</th>
                                    <th class="text-center">Vacant Posts</th>
                                    <th class="text-center">Fill Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($offices as $office)
                                    @php
                                        $fillPercentage = $office->sanctioned_positions > 0 ? 
                                            ($office->filled_positions / $office->sanctioned_positions) * 100 : 0;
                                        
                                        if ($fillPercentage >= 90) {
                                            $badgeClass = 'bg-success';
                                        } elseif ($fillPercentage >= 70) {
                                            $badgeClass = 'bg-info';
                                        } elseif ($fillPercentage >= 50) {
                                            $badgeClass = 'bg-warning';
                                        } else {
                                            $badgeClass = 'bg-danger';
                                        }
                                    @endphp
                                    <tr>
                                        <td data-label="Office Name">
                                            <strong>{{ $office->name }}</strong>
                                            @if($filters['show_details'] && isset($office->staff) && $office->staff->count() > 0)
                                                <br>
                                                <a href="#" class="btn btn-sm btn-outline-primary mt-2 view-all-staff" 
                                                   data-office-id="{{ $office->id }}" data-office-name="{{ $office->name }}">
                                                    View {{ $office->staff->count() }} staff
                                                </a>
                                            @endif
                                        </td>
                                        <td data-label="Level">{{ $office->level ?? 'N/A' }}</td>
                                        <td data-label="District">{{ $office->district->name ?? 'N/A' }}</td>
                                        <td data-label="Sanctioned Posts" class="text-center">{{ $office->sanctioned_positions }}</td>
                                        <td data-label="Filled Posts" class="text-center">{{ $office->filled_positions }}</td>
                                        <td data-label="Vacant Posts" class="text-center">{{ $office->vacant_positions }}</td>
                                        <td data-label="Fill Rate" class="text-center">
                                            <div class="d-flex align-items-center">
                                                <span class="badge {{ $badgeClass }} me-2">{{ round($fillPercentage, 1) }}%</span>
                                                <div class="progress flex-grow-1" style="height: 6px;">
                                                    <div class="progress-bar {{ $badgeClass }}" role="progressbar" 
                                                         style="width: {{ $fillPercentage }}%;" 
                                                         aria-valuenow="{{ $fillPercentage }}" 
                                                         aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="bi bi-building-x text-muted d-block mb-2" style="font-size: 2rem;"></i>
                                            <p class="text-muted">No offices found matching the criteria</p>
                                            <a href="{{ route('admin.apps.hr.reports.office-strength') }}" class="btn btn-sm btn-outline-primary mt-2">
                                                Reset Filters
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($offices instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="text-muted">
                            Showing {{ $offices->firstItem() ?? 0 }} to {{ $offices->lastItem() ?? 0 }} 
                            of {{ $offices->total() }} offices
                        </div>
                        
                        <div>
                            {{ $offices->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Staff List Modal -->
    <div class="modal fade" id="staffListModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staffListModalTitle">Staff Members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="staff-list-container">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-3">Loading staff members...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script src="{{ asset('admin/plugins/chartjs/js/chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: "bootstrap-5",
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
            
            // Grid and Table view toggle
            $('#card-view-btn').on('click', function() {
                $('#card-view').removeClass('d-none');
                $('#table-view').addClass('d-none');
                $(this).addClass('active');
                $('#table-view-btn').removeClass('active');
                localStorage.setItem('office-strength-view', 'card');
            });
            
            $('#table-view-btn').on('click', function() {
                $('#table-view').removeClass('d-none');
                $('#card-view').addClass('d-none');
                $(this).addClass('active');
                $('#card-view-btn').removeClass('active');
                localStorage.setItem('office-strength-view', 'table');
            });
            
            // Check if user has a preferred view saved
            const savedView = localStorage.getItem('office-strength-view');
            if (savedView === 'table') {
                $('#table-view-btn').click();
            }
            
            // Load staff details modal
            $('.view-all-staff').on('click', function(e) {
                e.preventDefault();
                const officeId = $(this).data('office-id');
                const officeName = $(this).data('office-name');
                
                // Update modal title
                $('#staffListModalTitle').text('Staff Members - ' + officeName);
                
                // Show the modal
                const staffModal = new bootstrap.Modal(document.getElementById('staffListModal'));
                staffModal.show();
                
                // Fetch staff data via AJAX
                $.ajax({
                    url: '{{ route('admin.apps.hr.reports.office-staff') }}',
                    type: 'GET',
                    data: {
                        office_id: officeId
                    },
                    success: function(response) {
                        $('.staff-list-container').html(response);
                    },
                    error: function() {
                        $('.staff-list-container').html(`
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                Error loading staff data. Please try again.
                            </div>
                        `);
                    }
                });
            });
            
            // Print report functionality
            $('#print-report').on('click', function() {
                const printTitle = "Office Strength Report";
                const currentView = $('#card-view').hasClass('d-none') ? 'table' : 'card';
                
                if (currentView === 'card') {
                    $("#card-view").printThis({
                        importCSS: true,
                        importStyle: true,
                        loadCSS: "{{ asset('admin/css/print.css') }}",
                        header: `<h1 class='text-center mb-4'>${printTitle}</h1>
                                <p class='text-center text-muted mb-4'>Generated on ${new Date().toLocaleDateString()}</p>`,
                        footer: `<p class='text-center mt-4'>&copy; ${new Date().getFullYear()} Communication & Works Department</p>`,
                    });
                } else {
                    $("#table-view").printThis({
                        importCSS: true,
                        importStyle: true,
                        loadCSS: "{{ asset('admin/css/print.css') }}",
                        header: `<h1 class='text-center mb-4'>${printTitle}</h1>
                                <p class='text-center text-muted mb-4'>Generated on ${new Date().toLocaleDateString()}</p>`,
                        footer: `<p class='text-center mt-4'>&copy; ${new Date().getFullYear()} Communication & Works Department</p>`,
                    });
                }
            });
            
            // Initialize any charts if needed
            if ($('#officeStrengthChart').length) {
                const officeStrengthChart = new Chart(
                    document.getElementById('officeStrengthChart').getContext('2d'),
                    {
                        type: 'bar',
                        data: {
                            labels: JSON.parse('{{ json_encode(array_keys($officeStrengthData ?? [])) }}'),
                            datasets: [
                                {
                                    label: 'Sanctioned Posts',
                                    data: JSON.parse('{{ json_encode(array_column($officeStrengthData ?? [], "sanctioned")) }}'),
                                    backgroundColor: '#4361ee',
                                    borderWidth: 0
                                },
                                {
                                    label: 'Filled Posts',
                                    data: JSON.parse('{{ json_encode(array_column($officeStrengthData ?? [], "filled")) }}'),
                                    backgroundColor: '#2ecc71',
                                    borderWidth: 0
                                },
                                {
                                    label: 'Vacant Posts',
                                    data: JSON.parse('{{ json_encode(array_column($officeStrengthData ?? [], "vacant")) }}'),
                                    backgroundColor: '#e74c3c',
                                    borderWidth: 0
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        precision: 0
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Office Strength Distribution'
                                }
                            }
                        }
                    }
                );
            }
        });
    </script>
    @endpush
</x-hr-layout>