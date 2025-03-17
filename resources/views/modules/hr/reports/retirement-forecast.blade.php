<x-hr-layout title="Retirement Forecast Report">
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
        
        .retirement-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0,0,0,0.05);
            transition: var(--transition);
            border-left: 4px solid #ff6b6b;
            margin-bottom: 20px;
            background-color: white;
        }
        
        .retirement-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .retirement-header {
            padding: 15px;
            background: linear-gradient(to right, #fff5f5, #ffffff);
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .retirement-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .retirement-designation {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .retirement-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .retirement-urgent {
            background-color: #ffebee;
            color: #d32f2f;
        }
        
        .retirement-upcoming {
            background-color: #fff8e1;
            color: #ff8f00;
        }
        
        .retirement-distant {
            background-color: #e8f5e9;
            color: #2e7d32;
        }
        
        .retirement-body {
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }
        
        .retirement-info {
            flex: 1;
        }
        
        .retirement-info-item {
            margin-bottom: 10px;
        }
        
        .retirement-info-label {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 2px;
        }
        
        .retirement-info-value {
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .retirement-countdown {
            width: 40%;
            padding-left: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .countdown-timer {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .countdown-unit {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 8px 12px;
            width: 23%;
        }
        
        .countdown-value {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 2px;
        }
        
        .countdown-label {
            font-size: 0.7rem;
            color: #6c757d;
            text-transform: uppercase;
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
        
        .years-selector .btn {
            border-radius: 20px;
            margin-right: 5px;
            font-size: 0.85rem;
            padding: 0.3rem 0.8rem;
        }
        
        .years-selector .btn.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }
        
        /* Print Styling */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
            }
            
            .retirement-card {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
                page-break-inside: avoid;
            }
            
            .filter-section {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
            
            .retirement-card:hover {
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

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-clock me-2"></i>
                        Retirement Forecast Report
                    </h4>
                    <div class="d-flex">
                        <button type="button" class="btn btn-outline-secondary me-2 no-print" id="printReport">
                            <i class="fas fa-print me-1"></i> Print Report
                        </button>
                        <a href="{{ route('admin.apps.hr.reports.retirement-forecast', ['format' => 'excel']) }}" class="btn btn-outline-success no-print">
                            <i class="fas fa-file-excel me-1"></i> Export to Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="filter-section no-print">
                    <form action="{{ route('admin.apps.hr.reports.retirement-forecast') }}" method="GET" id="filterForm">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="office_id" class="form-label">Office</label>
                                <select class="form-select select2" id="office_id" name="office_id">
                                    <option value="">All Offices</option>
                                    @foreach($offices as $office)
                                        <option value="{{ $office->id }}" {{ $filters['office_id'] == $office->id ? 'selected' : '' }}>
                                            {{ $office->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="designation_id" class="form-label">Designation</label>
                                <select class="form-select select2" id="designation_id" name="designation_id">
                                    <option value="">All Designations</option>
                                    @foreach($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ $filters['designation_id'] == $designation->id ? 'selected' : '' }}>
                                            {{ $designation->name }} ({{ $designation->bps }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="bps" class="form-label">BPS Grade</label>
                                <select class="form-select" id="bps" name="bps">
                                    <option value="">All Grades</option>
                                    @foreach($bpsValues as $bps)
                                        <option value="{{ $bps }}" {{ $filters['bps'] == $bps ? 'selected' : '' }}>
                                            {{ $bps }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="per_page" class="form-label">Entries Per Page</label>
                                <select class="form-select" id="per_page" name="per_page">
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10 entries</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 entries</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 entries</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 entries</option>
                                    <option value="all" {{ $perPage == 'all' ? 'selected' : '' }}>All entries</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row align-items-end">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Forecast Period</label>
                                <div class="years-selector">
                                    <div class="btn-group" role="group">
                                        @foreach([1, 3, 5, 10] as $year)
                                            <button type="button" class="btn btn-outline-secondary year-btn {{ $filters['years_range'] == $year ? 'active' : '' }}" 
                                                data-years="{{ $year }}">
                                                {{ $year }} {{ $year == 1 ? 'Year' : 'Years' }}
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="years_range" id="years_range" value="{{ $filters['years_range'] }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 text-md-end">
                                <button type="submit" class="cw-btn">
                                    <i class="fas fa-filter me-1"></i> Apply Filters
                                </button>
                                <a href="{{ route('admin.apps.hr.reports.retirement-forecast') }}" class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stats-title">Total Retirements</div>
                            <div class="stats-value">{{ count($users) }}</div>
                            <div class="stats-subtitle">Within Next {{ $filters['years_range'] }} Years</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div>
                            <div class="stats-title">Urgent Retirements</div>
                            <div class="stats-value">
                                {{ $users->where('years_to_retirement', '<=', 1)->count() }}
                            </div>
                            <div class="stats-subtitle">Within 1 Year</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div>
                            <div class="stats-title">Critical Positions</div>
                            <div class="stats-value">
                                {{ $users->filter(function($user) {
                                    return $user->years_to_retirement <= 2 && 
                                           $user->currentPosting && 
                                           $user->currentPosting->designation && 
                                           strpos($user->currentPosting->designation->bps ?? '', 'BPS-1') === 0;
                                })->count() }}
                            </div>
                            <div class="stats-subtitle">Senior Positions (BPS 17+)</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="stats-box">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <div class="stats-title">Peak Retirement Year</div>
                            <div class="stats-value">
                                @if(count($retirementsByYear) > 0)
                                    {{ array_search(max($retirementsByYear), $retirementsByYear) }}
                                @else
                                    N/A
                                @endif
                            </div>
                            <div class="stats-subtitle">Highest Number of Retirements</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Retirements by Year</h5>
                    </div>
                    <div class="card-body">
                        <div id="retirementsByYearChart" class="chart-container" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Retirements by Designation</h5>
                    </div>
                    <div class="card-body">
                        <div id="retirementsByDesignationChart" class="chart-container" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Retirement Cards -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Employees Retiring in the Next {{ $filters['years_range'] }} Years
                            <span class="badge bg-primary ms-2">{{ count($users) }}</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(count($users) > 0)
                            <div id="retirement-list">
                                @foreach($users as $user)
                                    <div class="retirement-card">
                                        <div class="retirement-header">
                                            <div>
                                                <div class="retirement-title">{{ $user->name }}</div>
                                                <div class="retirement-designation">
                                                    {{ $user->currentPosting->designation->name ?? 'No Designation' }} 
                                                    ({{ $user->currentPosting->designation->bps ?? 'N/A' }})
                                                </div>
                                            </div>
                                            <div>
                                                @if($user->years_to_retirement <= 1)
                                                    <span class="retirement-badge retirement-urgent">Retiring Soon (< 1 Year)</span>
                                                @elseif($user->years_to_retirement <= 3)
                                                    <span class="retirement-badge retirement-upcoming">Upcoming (< 3 Years)</span>
                                                @else
                                                    <span class="retirement-badge retirement-distant">Planned (> 3 Years)</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="retirement-body">
                                            <div class="retirement-info">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="retirement-info-item">
                                                            <div class="retirement-info-label">Current Office</div>
                                                            <div class="retirement-info-value">
                                                                {{ $user->currentPosting->office->name ?? 'N/A' }}
                                                            </div>
                                                        </div>
                                                        <div class="retirement-info-item">
                                                            <div class="retirement-info-label">Date of Birth</div>
                                                            <div class="retirement-info-value">
                                                                {{ $user->profile->date_of_birth ? date('d M Y', strtotime($user->profile->date_of_birth)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="retirement-info-item">
                                                            <div class="retirement-info-label">Contact Number</div>
                                                            <div class="retirement-info-value">
                                                                {{ $user->profile->mobile_number ?? 'N/A' }}
                                                            </div>
                                                        </div>
                                                        <div class="retirement-info-item">
                                                            <div class="retirement-info-label">Retirement Date</div>
                                                            <div class="retirement-info-value">
                                                                {{ $user->retirement_date ? date('d M Y', strtotime($user->retirement_date)) : 'N/A' }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="retirement-countdown">
                                                <div class="countdown-timer">
                                                    <div class="countdown-unit">
                                                        <div class="countdown-value">{{ $user->years_to_retirement }}</div>
                                                        <div class="countdown-label">Years</div>
                                                    </div>
                                                    <div class="countdown-unit">
                                                        <div class="countdown-value">{{ $user->months_to_retirement }}</div>
                                                        <div class="countdown-label">Months</div>
                                                    </div>
                                                    <div class="countdown-unit">
                                                        <div class="countdown-value">{{ $user->retirement_date ? now()->diffInDays($user->retirement_date) % 30 : 0 }}</div>
                                                        <div class="countdown-label">Days</div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('hr.users.show', $user->id) }}" class="btn btn-sm btn-outline-primary w-100 no-print">
                                                    <i class="fas fa-user me-1"></i> View Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            @if(!($perPage == 'all'))
                                <div class="d-flex justify-content-center mt-4 no-print">
                                    {{ $users->appends(request()->except('page'))->links() }}
                                </div>
                            @endif
                            
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No employees are due to retire within the selected time period based on the applied filters.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
            
            // Year selector buttons
            $('.year-btn').click(function() {
                $('.year-btn').removeClass('active');
                $(this).addClass('active');
                $('#years_range').val($(this).data('years'));
            });
            
            // Print report
            $('#printReport').click(function() {
                $('#retirement-list').printThis({
                    importCSS: true,
                    importStyle: true,
                    header: "<h3 class='text-center mb-4'>Retirement Forecast Report</h3>",
                    footer: "<div class='text-center mt-4'><small>Generated on: " + new Date().toLocaleDateString() + "</small></div>",
                    pageTitle: "Retirement Forecast Report",
                    removeInline: false,
                });
            });
            
            // Retirements by Year Chart
            var retirementsByYearOptions = {
                series: [{
                    name: 'Retirements',
                    data: [
                        @foreach($retirementsByYear as $year => $count)
                            {{ $count }},
                        @endforeach
                    ]
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
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '60%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [
                        @foreach($retirementsByYear as $year => $count)
                            '{{ $year }}',
                        @endforeach
                    ]
                },
                yaxis: {
                    title: {
                        text: 'Number of Retirements'
                    }
                },
                fill: {
                    opacity: 1,
                    colors: ['#4361ee']
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val + " employees"
                        }
                    }
                }
            };
            
            var retirementsByYearChart = new ApexCharts(document.querySelector("#retirementsByYearChart"), retirementsByYearOptions);
            retirementsByYearChart.render();
            
            // Retirements by Designation Chart
            var retirementsByDesignationOptions = {
                series: [
                    @foreach($retirementsByDesignation as $designation => $count)
                        {{ $count }},
                    @endforeach
                ],
                chart: {
                    type: 'pie',
                    height: 300,
                    toolbar: {
                        show: false
                    }
                },
                labels: [
                    @foreach($retirementsByDesignation as $designation => $count)
                        '{{ $designation }}',
                    @endforeach
                ],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                legend: {
                    position: 'bottom'
                },
                colors: ['#4361ee', '#ff6b6b', '#25c2e3', '#ffc107', '#82c91e', '#be4bdb', '#fab005', '#15aabf', '#fd7e14', '#748ffc']
            };
            
            var retirementsByDesignationChart = new ApexCharts(document.querySelector("#retirementsByDesignationChart"), retirementsByDesignationOptions);
            retirementsByDesignationChart.render();
        });
    </script>
    @endpush
</x-hr-layout>