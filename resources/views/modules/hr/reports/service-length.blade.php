<x-hr-layout title="Service Length Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/apexcharts/dist/apexcharts.css') }}" rel="stylesheet">
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
        
        .service-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
            border-left: 4px solid #4361ee;
            margin-bottom: 20px;
            background-color: white;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .service-header {
            padding: 15px;
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .service-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .service-designation {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .service-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            background-color: #e9ecef;
            color: #495057;
        }
        
        .service-body {
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }
        
        .service-info {
            flex: 1;
        }
        
        .service-info-item {
            margin-bottom: 10px;
        }
        
        .service-info-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 2px;
        }
        
        .service-info-value {
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .service-meter {
            width: 40%;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .service-progress {
            height: 10px;
            border-radius: 5px;
            background-color: #e9ecef;
            margin-bottom: 10px;
            overflow: hidden;
        }
        
        .service-progress-bar {
            height: 100%;
            background: linear-gradient(to right, #4361ee, #3a56d4);
            border-radius: 5px;
        }
        
        .service-progress-text {
            font-size: 0.8rem;
            text-align: right;
            color: #6c757d;
        }
        
        .service-footer {
            padding: 15px;
            border-top: 1px solid #e9ecef;
        }
        
        .service-employee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }
        
        .stats-box {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: var(--transition);
        }
        
        .stats-box:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        }
        
        .stats-title {
            font-size: 0.85rem;
            font-weight: 500;
            color: #6c757d;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        
        .stats-value {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .stats-icon {
            font-size: 2rem;
            color: #eaeaea;
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
        
        /* Print Styling */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
            }
            
            .service-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
                page-break-inside: avoid;
            }
            
            .filter-section {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
            
            .service-card:hover {
                transform: none;
            }
            
            .stats-box {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
            
            .stats-box:hover {
                box-shadow: none;
            }
            
            .chart-container {
                page-break-inside: avoid;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.index') }}">HR</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.reports.service-length') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Service Length Report</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Service Length Report</h3>
                    <button type="button" id="print-report" class="no-print btn btn-primary btn-sm">
                        <span class="d-flex align-items-center">
                            <i class="bi-printer me-2"></i>
                            Print Report
                        </span>
                    </button>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row mb-4">
                    <!-- Statistics Overview -->
                    <div class="col-md-3">
                        <div class="stats-box">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="stats-title">Avg. Service Length</div>
                                    <div class="stats-value">{{ number_format($avgServiceYears, 1) }} yrs</div>
                                </div>
                                <i class="bi bi-clock-history stats-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-box">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="stats-title">Longest Service</div>
                                    <div class="stats-value">{{ number_format($maxServiceYears, 1) }} yrs</div>
                                </div>
                                <i class="bi bi-award stats-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-box">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="stats-title">Shortest Service</div>
                                    <div class="stats-value">{{ number_format($minServiceYears, 1) }} yrs</div>
                                </div>
                                <i class="bi bi-hourglass-top stats-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-box">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="stats-title">Total Employees</div>
                                    <div class="stats-value">{{ count($users) }}</div>
                                </div>
                                <i class="bi bi-people stats-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <!-- Service Length Distribution Chart -->
                    <div class="col-md-12">
                        <div class="stats-box chart-container">
                            <h5 class="mb-3">Service Length Distribution</h5>
                            <div id="serviceLengthChart" style="height: 300px;"></div>
                        </div>
                    </div>
                </div>

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

                        <div class="col-md-4">
                            <label class="form-label" for="bps">
                                BPS Grade
                            </label>
                            <select name="bps" id="bps" class="form-select select2" data-placeholder="Select BPS">
                                <option value="">All BPS Grades</option>
                                @foreach($bpsValues as $bps)
                                    <option value="{{ $bps }}" @selected($filters['bps'] == $bps)>
                                        {{ $bps }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" for="min_years">
                                        Min. Years of Service
                                    </label>
                                    <input type="number" class="form-control" id="min_years" name="min_years" 
                                           min="0" max="60" step="1" value="{{ $filters['min_years'] }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="max_years">
                                        Max. Years of Service
                                    </label>
                                    <input type="number" class="form-control" id="max_years" name="max_years" 
                                           min="0" max="60" step="1" value="{{ $filters['max_years'] }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="d-flex flex-column h-100 justify-content-end">
                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="cw-btn">
                                        <i class="bi-filter me-2"></i> APPLY FILTERS
                                    </button>
                                    <a href="{{ route('admin.apps.hr.reports.service-length') }}" class="btn btn-outline-secondary">
                                        <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 text-end mt-3">
                            <label class="form-label" for="per_page">Records per page</label>
                            <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                <option value="15" @selected($perPage == 15)>15</option>
                                <option value="30" @selected($perPage == 30)>30</option>
                                <option value="50" @selected($perPage == 50)>50</option>
                                <option value="100" @selected($perPage == 100)>100</option>
                                <option value="all" @selected($perPage == 'all')>All</option>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                    <div>
                        <h5 class="m-0">
                            Found <span class="text-primary fw-bold">{{ count($users) }}</span> employees
                        </h5>
                    </div>
                </div>

                <!-- Employee Listing with Service Length -->
                <div id="employee-list">
                    @forelse($users as $user)
                        <div class="service-card">
                            <div class="service-header">
                                <div>
                                    <h3 class="service-title">{{ $user->name }}</h3>
                                    <p class="service-designation">
                                        {{ $user->currentPosting->designation->name ?? 'No Designation' }} 
                                        ({{ $user->currentPosting->designation->bps ?? 'N/A' }})
                                    </p>
                                </div>
                                <div class="service-badge">
                                    {{ $user->service_years }} year{{ $user->service_years != 1 ? 's' : '' }}
                                    @if($user->service_months > 0)
                                        , {{ $user->service_months }} month{{ $user->service_months != 1 ? 's' : '' }}
                                    @endif
                                </div>
                            </div>
                            <div class="service-body">
                                <div class="service-info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="service-info-item">
                                                <div class="service-info-label">Office</div>
                                                <div class="service-info-value">{{ $user->currentPosting->office->name ?? 'No Office' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="service-info-item">
                                                <div class="service-info-label">Service Start Date</div>
                                                <div class="service-info-value">{{ $user->service_start_date ? $user->service_start_date->format('d M, Y') : 'N/A' }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="service-info-item">
                                                <div class="service-info-label">Email</div>
                                                <div class="service-info-value">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="service-info-item">
                                                <div class="service-info-label">Contact Number</div>
                                                <div class="service-info-value">{{ $user->profile->mobile_number ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="service-meter">
                                    @php
                                        // Calculate progress percentage (capped at 100%)
                                        $progressPercent = min(($user->service_years / 30) * 100, 100);
                                    @endphp
                                    <div class="service-info-label mb-2">Service Progress (30 years standard)</div>
                                    <div class="service-progress">
                                        <div class="service-progress-bar" style="width: {{ $progressPercent }}%"></div>
                                    </div>
                                    <div class="service-progress-text">{{ number_format($progressPercent, 1) }}% completed</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x" style="font-size: 3rem; color: #ddd;"></i>
                            <h4 class="mt-3">No employees found</h4>
                            <p class="text-muted">Try adjusting your filter criteria</p>
                            <a href="{{ route('admin.apps.hr.reports.service-length') }}" class="btn btn-outline-primary mt-2">
                                Reset Filters
                            </a>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($perPage != 'all')
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->appends(request()->except('page'))->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
            
            // Toggle Filters
            $('#toggleFilters').on('click', function() {
                $('.filter-section').slideToggle();
                $('#filterIcon').toggleClass('bi-chevron-up bi-chevron-down');
                $('#filterText').text($('#filterIcon').hasClass('bi-chevron-up') ? 'Hide Filters' : 'Show Filters');
            });
            
            // Submit form when per_page changes
            $('#per_page').on('change', function() {
                $(this).closest('form').submit();
            });
            
            // Print Report
            $('#print-report').on('click', function() {
                $('#employee-list').printThis({
                    importCSS: true,
                    importStyle: true,
                    loadCSS: "",
                    pageTitle: "Service Length Report",
                    header: `
                        <div class="text-center mb-4">
                            <h2>Service Length Report</h2>
                            <p>Generated on ${new Date().toLocaleDateString()}</p>
                        </div>
                    `,
                    removeInline: false
                });
            });
            
            // Service Length Distribution Chart
            const serviceLengthData = @json($serviceLengthRanges);
            
            const chartOptions = {
                series: [{
                    name: 'Employees',
                    data: Object.values(serviceLengthData)
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 5,
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val;
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: Object.keys(serviceLengthData),
                    position: 'bottom',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    title: {
                        text: 'Years of Service'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Number of Employees'
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 0.85,
                        opacityTo: 0.85,
                        stops: [50, 0, 100]
                    }
                },
                colors: ['#4361ee']
            };
            
            const chart = new ApexCharts(document.querySelector('#serviceLengthChart'), chartOptions);
            chart.render();
        });
    </script>
    @endpush
</x-hr-layout>