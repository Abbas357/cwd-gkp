<x-hr-layout title="Posting History Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
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
        
        .posting-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
            border-left: 4px solid #4361ee;
            margin-bottom: 20px;
            background-color: white;
        }
        
        .posting-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .posting-header {
            padding: 15px;
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            border-bottom: 1px solid #e9ecef;
        }
        
        .posting-type {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            margin-bottom: 5px;
        }
        
        .posting-type-appointment {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .posting-type-transfer {
            background-color: #e8eaff;
            color: #3f51b5;
        }
        
        .posting-type-promotion {
            background-color: #e1f5fe;
            color: #0288d1;
        }
        
        .posting-type-deputation {
            background-color: #ede7f6;
            color: #673ab7;
        }
        
        .posting-type-additional-charge {
            background-color: #fce4ec;
            color: #c2185b;
        }
        
        .posting-type-retirement {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        
        .posting-type-termination {
            background-color: #ffebee;
            color: #d32f2f;
        }
        
        .posting-body {
            padding: 15px;
        }
        
        .posting-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .posting-office {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 10px;
        }
        
        .posting-dates {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .posting-date {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .date-label {
            font-size: 0.75rem;
            color: #6c757d;
        }
        
        .date-value {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .date-separator {
            width: 50px;
            height: 2px;
            background-color: #e9ecef;
            margin: 0 15px;
        }
        
        .duration-badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e9ecef;
            color: #495057;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .posting-footer {
            padding: 15px;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .posting-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .posting-current {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .posting-past {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .employee-info {
            display: flex;
            align-items: center;
        }
        
        .employee-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }
        
        .employee-name {
            font-size: 0.9rem;
            font-weight: 500;
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
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 15px;
            height: 100%;
            width: 2px;
            background-color: #e9ecef;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }
        
        .timeline-item:last-child {
            margin-bottom: 0;
        }
        
        .timeline-dot {
            position: absolute;
            left: -30px;
            top: 0;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #4361ee;
            border: 2px solid white;
            z-index: 1;
        }
        
        .timeline-dot.current {
            background-color: #2ecc71;
        }
        
        /* Print Styling */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
            }
            
            .posting-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
                page-break-inside: avoid;
            }
            
            .filter-section {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
            
            .posting-card:hover {
                transform: none;
            }
            
            .timeline::before {
                display: none;
            }
            
            .timeline-dot {
                display: none;
            }
            
            .timeline {
                padding-left: 0;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.index') }}">HR</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.reports.posting-history') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Posting History Report</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Posting History Report</h3>
                    <div class="d-flex gap-2">
                        <div class="btn-group no-print">
                            <button type="button" class="view-toggle-btn active" id="card-view-btn">
                                <i class="bi bi-card-text me-1"></i> Card View
                            </button>
                            <button type="button" class="view-toggle-btn" id="timeline-view-btn">
                                <i class="bi bi-clock-history me-1"></i> Timeline
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
                            <label class="form-label" for="user_id">
                                Employee
                            </label>
                            <select name="user_id" id="user_id" class="form-select select2" data-placeholder="Select Employee">
                                <option value="">All Employees</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @selected($filters['user_id'] == $user->id)>
                                        {{ $user->name }} ({{ $user->position ?? $user->designation ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label" for="office_id">
                                Office
                            </label>
                            <select name="office_id" id="office_id" class="form-select select2" data-placeholder="Select Office">
                                <option value="">All Offices</option>
                                @foreach($offices as $office)
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
                            <label class="form-label" for="date_from">
                                Date From
                            </label>
                            <input type="text" class="form-control datepicker" id="date_from" name="date_from" 
                                   placeholder="YYYY-MM-DD" value="{{ $filters['date_from'] }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="date_to">
                                Date To
                            </label>
                            <input type="text" class="form-control datepicker" id="date_to" name="date_to" 
                                   placeholder="YYYY-MM-DD" value="{{ $filters['date_to'] }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="is_current">
                                Status
                            </label>
                            <select name="is_current" id="is_current" class="form-select">
                                <option value="">All Postings</option>
                                <option value="1" @selected($filters['is_current'] === '1')>Current Only</option>
                                <option value="0" @selected($filters['is_current'] === '0')>Previous Only</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex flex-column h-100 justify-content-end">
                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="cw-btn">
                                        <i class="bi-filter me-2"></i> APPLY FILTERS
                                    </button>
                                    <a href="{{ route('admin.apps.hr.reports.posting-history') }}" class="btn btn-outline-secondary">
                                        <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 text-end">
                            <label class="form-label" for="per_page">Records per page</label>
                            <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                <option value="15" @selected($perPage == 15)>15</option>
                                <option value="30" @selected($perPage == 30)>30</option>
                                <option value="50" @selected($perPage == 50)>50</option>
                                <option value="100" @selected($perPage == 100)>100</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                    <div>
                        <h5 class="m-0">
                            Found <span class="text-primary fw-bold">{{ $postings->total() }}</span> posting records
                        </h5>
                    </div>
                </div>

                <!-- Card View -->
                <div id="card-view">
                    @forelse($postings as $posting)
                        @php
                            $typeLowercase = strtolower($posting->type ?? 'Appointment');
                            $typeClass = "posting-type-" . str_replace(' ', '-', $typeLowercase);
                            
                            $isCurrent = $posting->is_current;
                            $statusClass = $isCurrent ? 'posting-current' : 'posting-past';
                            $statusText = $isCurrent ? 'Current Posting' : 'Previous Posting';
                        @endphp
                        
                        <div class="posting-card">
                            <div class="posting-header">
                                <span class="posting-type {{ $typeClass }}">{{ $posting->type ?? 'Appointment' }}</span>
                                <h3 class="posting-title">{{ $posting->designation->name ?? 'Unknown Designation' }}</h3>
                                <p class="posting-office">{{ $posting->office->name ?? 'Unknown Office' }}</p>
                            </div>
                            <div class="posting-body">
                                <div class="posting-dates">
                                    <div class="posting-date">
                                        <span class="date-label">Start Date</span>
                                        <span class="date-value">{{ $posting->start_date->format('d M, Y') }}</span>
                                    </div>
                                    <div class="date-separator"></div>
                                    <div class="posting-date">
                                        <span class="date-label">End Date</span>
                                        <span class="date-value">{{ $posting->end_date ? $posting->end_date->format('d M, Y') : 'Current' }}</span>
                                    </div>
                                </div>
                                
                                <div class="duration-badge">
                                    @if($posting->duration_years > 0)
                                        {{ $posting->duration_years }} year{{ $posting->duration_years != 1 ? 's' : '' }} 
                                    @endif
                                    
                                    @if($posting->duration_months > 0)
                                        {{ $posting->duration_months }} month{{ $posting->duration_months != 1 ? 's' : '' }} 
                                    @endif
                                    
                                    @if($posting->duration_days > 0 || ($posting->duration_years == 0 && $posting->duration_months == 0))
                                        {{ $posting->duration_days }} day{{ $posting->duration_days != 1 ? 's' : '' }}
                                    @endif
                                </div>
                                
                                @if($posting->order_number)
                                    <div class="mt-3">
                                        <small class="text-muted">Order No: {{ $posting->order_number }}</small>
                                    </div>
                                @endif
                                
                                @if($posting->remarks)
                                    <div class="mt-2">
                                        <small class="text-muted">Remarks: {{ $posting->remarks }}</small>
                                    </div>
                                @endif
                            </div>
                            <div class="posting-footer">
                                <div class="employee-info">
                                    <img src="{{ $posting->user->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.jpg') }}" 
                                         alt="{{ $posting->user->name }}" class="employee-avatar">
                                    <span class="employee-name">{{ $posting->user->name }}</span>
                                </div>
                                <span class="posting-status {{ $statusClass }}">{{ $statusText }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x" style="font-size: 3rem; color: #ddd;"></i>
                            <h4 class="mt-3">No posting records found</h4>
                            <p class="text-muted">Try adjusting your filter criteria</p>
                            <a href="{{ route('admin.apps.hr.reports.posting-history') }}" class="btn btn-outline-primary mt-2">
                                Reset Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Timeline View -->
                <div id="timeline-view" class="d-none">
                    @if($postings->count() > 0)
                        @php
                            // Group postings by user
                            $postingsByUser = $postings->groupBy('user_id');
                        @endphp
                        
                        @foreach($postingsByUser as $userId => $userPostings)
                            @php
                                $user = $userPostings->first()->user;
                                $sortedPostings = $userPostings->sortByDesc('start_date');
                            @endphp
                            
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->getFirstMediaUrl('profile_pictures') ?: asset('admin/images/default-avatar.jpg') }}" 
                                             alt="{{ $user->name }}" 
                                             style="width: 40px; height: 40px; border-radius: 50%; margin-right: 15px;">
                                        <div>
                                            <h5 class="mb-0">{{ $user->name }}</h5>
                                            <small class="text-muted">{{ $user->position ?? $user->designation ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="timeline">
                                        @foreach($sortedPostings as $posting)
                                            @php
                                                $typeLowercase = strtolower($posting->type ?? 'Appointment');
                                                $typeClass = "posting-type-" . str_replace(' ', '-', $typeLowercase);
                                                
                                                $isCurrent = $posting->is_current;
                                                $dotClass = $isCurrent ? 'current' : '';
                                            @endphp
                                            
                                            <div class="timeline-item">
                                                <div class="timeline-dot {{ $dotClass }}"></div>
                                                <div class="posting-card" style="margin-left: 0;">
                                                    <div class="posting-header">
                                                        <span class="posting-type {{ $typeClass }}">{{ $posting->type ?? 'Appointment' }}</span>
                                                        <h3 class="posting-title">{{ $posting->designation->name ?? 'Unknown Designation' }}</h3>
                                                        <p class="posting-office">{{ $posting->office->name ?? 'Unknown Office' }}</p>
                                                    </div>
                                                    <div class="posting-body">
                                                        <div class="posting-dates">
                                                            <div class="posting-date">
                                                                <span class="date-label">Start Date</span>
                                                                <span class="date-value">{{ $posting->start_date->format('d M, Y') }}</span>
                                                            </div>
                                                            <div class="date-separator"></div>
                                                            <div class="posting-date">
                                                                <span class="date-label">End Date</span>
                                                                <span class="date-value">{{ $posting->end_date ? $posting->end_date->format('d M, Y') : 'Current' }}</span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="duration-badge">
                                                            @if($posting->duration_years > 0)
                                                                {{ $posting->duration_years }} year{{ $posting->duration_years != 1 ? 's' : '' }} 
                                                            @endif
                                                            
                                                            @if($posting->duration_months > 0)
                                                                {{ $posting->duration_months }} month{{ $posting->duration_months != 1 ? 's' : '' }} 
                                                            @endif
                                                            
                                                            @if($posting->duration_days > 0 || ($posting->duration_years == 0 && $posting->duration_months == 0))
                                                                {{ $posting->duration_days }} day{{ $posting->duration_days != 1 ? 's' : '' }}
                                                            @endif
                                                        </div>
                                                        
                                                        @if($posting->order_number)
                                                            <div class="mt-3">
                                                                <small class="text-muted">Order No: {{ $posting->order_number }}</small>
                                                            </div>
                                                        @endif
                                                        
                                                        @if($posting->remarks)
                                                            <div class="mt-2">
                                                                <small class="text-muted">Remarks: {{ $posting->remarks }}</small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x" style="font-size: 3rem; color: #ddd;"></i>
                            <h4 class="mt-3">No posting records found</h4>
                            <p class="text-muted">Try adjusting your filter criteria</p>
                            <a href="{{ route('admin.apps.hr.reports.posting-history') }}" class="btn btn-outline-primary mt-2">
                                Reset Filters
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $postings->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
            
            // Initialize Datepicker
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                clearBtn: true
            });
            
            // Toggle Filters
            $('#toggleFilters').on('click', function() {
                $('.filter-section').slideToggle();
                $('#filterIcon').toggleClass('bi-chevron-up bi-chevron-down');
                $('#filterText').text($('#filterIcon').hasClass('bi-chevron-up') ? 'Hide Filters' : 'Show Filters');
            });
            
            // View Toggle
            $('#card-view-btn').on('click', function() {
                $(this).addClass('active');
                $('#timeline-view-btn').removeClass('active');
                $('#card-view').removeClass('d-none');
                $('#timeline-view').addClass('d-none');
            });
            
            $('#timeline-view-btn').on('click', function() {
                $(this).addClass('active');
                $('#card-view-btn').removeClass('active');
                $('#timeline-view').removeClass('d-none');
                $('#card-view').addClass('d-none');
            });
            
            // Print Report
            $('#print-report').on('click', function() {
                // Determine which view is active
                const activeView = $('#card-view').hasClass('d-none') ? '#timeline-view' : '#card-view';
                
                $(activeView).printThis({
                    importCSS: true,
                    importStyle: true,
                    loadCSS: "",
                    pageTitle: "Posting History Report",
                    header: `
                        <div class="text-center mb-4">
                            <h2>Posting History Report</h2>
                            <p>Generated on ${new Date().toLocaleDateString()}</p>
                        </div>
                    `,
                    removeInline: false
                });
            });
            
            // Submit form when per_page changes
            $('#per_page').on('change', function() {
                $(this).closest('form').submit();
            });
        });
    </script>
    @endpush
</x-hr-layout>