<x-hr-layout title="Vacancy Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/chartjs/css/chart.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #f8f9fa;
            --border-radius: 0.5rem;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
        }
        
        .table > :not(caption) > * > * {
            vertical-align: middle;
            padding: 1rem;
        }
        
        .table th {
            background-color: #f0f4f8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.6px;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }
        
        .vacancy-details {
            line-height: 1.7;
        }
        
        .vacancy-details strong {
            font-size: 1.05rem;
            color: #212529;
        }
        
        .vacancy-details small {
            color: #6c757d;
            display: block;
            margin-top: 0.1rem;
            font-size: 0.8rem;
        }
        
        .status-badge {
            padding: 0.4em 0.8em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 50rem;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .table-container {
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }
        
        .table-container:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .filter-section {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid #e9ecef;
        }
        
        /* Card and Button Enhancements */
        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        
        .card-header {
            background: linear-gradient(to right, #e9ecef, #f8f9fa);
            border-bottom: 1px solid #e9ecef;
            padding: 1.25rem 1.5rem;
        }
        
        .card-title {
            font-weight: 700;
            color: #212529;
            margin: 0;
            font-size: 1.4rem;
        }
        
        .card-body {
            background: linear-gradient(to bottom, #ffffff, #fafbfc);
            padding: 2rem;
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

        .progress-thin {
            height: 6px;
            border-radius: 3px;
        }

        .vacancy-row-filled {
            background-color: rgba(46, 204, 113, 0.05);
            border-left: 3px solid #2ecc71;
        }

        .vacancy-row-vacant {
            background-color: rgba(231, 76, 60, 0.05);
            border-left: 3px solid #e74c3c;
        }

        .vacancy-row-partial {
            background-color: rgba(243, 156, 18, 0.05);
            border-left: 3px solid #f39c12;
        }

        /* Print Styling */
        @media print {
            .no-print {
                display: none !important;
            }
            
            body {
                font-size: 12pt;
            }
            
            table {
                page-break-inside: avoid;
            }
            
            .card, .table-container {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
            
            .card-header {
                background: #f8f9fa !important;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.index') }}">HR</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.hr.reports.vacancy') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Vacancy Report</li>
    </x-slot>

    <div class="wrapper">
        <!-- Dashboard Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card summary-card primary h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon me-3">
                            <i class="bi bi-people"></i>
                        </div>
                        <div>
                            <div class="card-title">TOTAL SANCTIONED</div>
                            <div class="card-value">{{ number_format($totalSanctioned) }}</div>
                            <div class="text-muted">Approved positions</div>
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
                            <div class="text-muted">{{ round(($totalFilled / $totalSanctioned) * 100, 1) }}% of total</div>
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
                            <div class="text-muted">{{ round(($totalVacant / $totalSanctioned) * 100, 1) }}% of total</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card summary-card warning h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon me-3">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <div class="card-title">VACANCY RATE</div>
                            <div class="card-value">{{ number_format($vacancyRate, 1) }}%</div>
                            <div class="text-muted">Department-wide</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Vacancy Report</h3>
                    <button type="button" id="print-report" class="no-print btn btn-primary btn-sm">
                        <span class="d-flex align-items-center">
                            <i class="bi-printer me-2"></i>
                            Print Report
                        </span>
                    </button>
                </div>
            </div>
            <div class="card-body p-1">
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
                            <label class="form-label" for="vacancy_status">
                                Vacancy Status
                            </label>
                            <select name="vacancy_status" id="vacancy_status" class="form-select">
                                <option value="all" @selected($filters['vacancy_status'] == 'all')>All Positions</option>
                                <option value="vacant" @selected($filters['vacancy_status'] == 'vacant')>Only Vacant</option>
                                <option value="filled" @selected($filters['vacancy_status'] == 'filled')>Only Filled</option>
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

                        <div class="col-md-3">
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
                            <label class="form-label" for="status">
                                Status
                            </label>
                            <select name="status" id="status" class="form-select">
                                <option value="Active" @selected($filters['status'] == 'Active')>Active</option>
                                <option value="Inactive" @selected($filters['status'] == 'Inactive')>Inactive</option>
                            </select>
                        </div>
                        
                        <div class="col-12 mt-3">
                            <hr>
                            <div class="d-flex gap-2">
                                <button type="submit" class="cw-btn">
                                    <i class="bi-filter me-2"></i> GENERATE REPORT
                                </button>
                                <a href="{{ route('admin.apps.hr.reports.vacancy') }}" class="btn btn-outline-secondary">
                                    <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-container p-3">
                    <div class="d-flex justify-content-between align-items-center p-2 bg-light border-bottom">
                        <h5 class="m-0 fw-bold">Sanctioned Posts & Vacancies</h5>
                        <div class="d-flex align-items-center">
                            <span class="me-2">Display:</span>
                            <select id="per-page-selector" class="form-select form-select-sm" style="width: auto;">
                                <option value="10" @selected($perPage == 10)>10 per page</option>
                                <option value="25" @selected($perPage == 25)>25 per page</option>
                                <option value="50" @selected($perPage == 50)>50 per page</option>
                                <option value="100" @selected($perPage == 100)>100 per page</option>
                                <option value="all" @selected($perPage == 'all')>All records</option>
                            </select>
                        </div>
                    </div>

                    <table class="table table-hover mb-0" id="vacancy-report">
                        <thead>
                            <tr>
                                <th>Office</th>
                                <th>Designation</th>
                                <th>BPS</th>
                                <th>District</th>
                                <th class="text-center">Total Posts</th>
                                <th class="text-center">Filled</th>
                                <th class="text-center">Vacant</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sanctionedPosts as $post)
                                @php
                                    $vacancyPercent = ($post->vacant_positions / $post->total_positions) * 100;
                                    
                                    if ($post->vacant_positions == 0) {
                                        $rowClass = 'vacancy-row-filled';
                                        $statusBadgeClass = 'bg-success';
                                        $statusText = 'Filled';
                                    } elseif ($post->vacant_positions == $post->total_positions) {
                                        $rowClass = 'vacancy-row-vacant';
                                        $statusBadgeClass = 'bg-danger';
                                        $statusText = 'All Vacant';
                                    } else {
                                        $rowClass = 'vacancy-row-partial';
                                        $statusBadgeClass = 'bg-warning';
                                        $statusText = 'Partially Filled';
                                    }
                                @endphp
                                <tr class="{{ $rowClass }}">
                                    <td>
                                        <div class="vacancy-details">
                                            <strong>{{ $post->office->name }}</strong>
                                            <small>Level: {{ $post->office->level ?? 'N/A' }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $post->designation->name }}</td>
                                    <td>{{ $post->designation->bps }}</td>
                                    <td>{{ $post->office->district->name ?? 'N/A' }}</td>
                                    <td class="text-center font-weight-bold">{{ $post->total_positions }}</td>
                                    <td class="text-center">{{ $post->filled_positions }}</td>
                                    <td class="text-center font-weight-bold">{{ $post->vacant_positions }}</td>
                                    <td>
                                        <span class="status-badge {{ $statusBadgeClass }} text-white">
                                            {{ $statusText }}
                                        </span>
                                        <div class="progress progress-thin mt-2">
                                            <div class="progress-bar bg-primary" role="progressbar" 
                                                 style="width: {{ 100 - $vacancyPercent }}%" 
                                                 aria-valuenow="{{ 100 - $vacancyPercent }}" aria-valuemin="0" 
                                                 aria-valuemax="100"></div>
                                        </div>
                                        <small class="d-block text-center mt-1">
                                            {{ round(100 - $vacancyPercent, 1) }}% filled
                                        </small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox text-muted d-block mb-2" style="font-size: 2rem;"></i>
                                        <p class="text-muted">No sanctioned posts found matching the criteria</p>
                                        <a href="{{ route('admin.apps.hr.reports.vacancy') }}" class="btn btn-sm btn-outline-primary mt-2">
                                            Reset Filters
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center p-3 border-top">
                        <div class="text-muted">
                            @if($sanctionedPosts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                Showing {{ $sanctionedPosts->firstItem() ?? 0 }} to {{ $sanctionedPosts->lastItem() ?? 0 }} 
                                of {{ $sanctionedPosts->total() }} entries
                            @else
                                Showing all {{ count($sanctionedPosts) }} entries
                            @endif
                        </div>
                        
                        <div>
                            @if($sanctionedPosts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                                {{ $sanctionedPosts->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/chartjs/js/chart.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
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
            
            // Per page selector
            $('#per-page-selector').on('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', $(this).val());
                window.location.href = url.toString();
            });
            
            // Print report
            $('#print-report').on('click', function() {
                $("#vacancy-report").printThis({
                    importCSS: true,
                    importStyle: true,
                    loadCSS: "{{ asset('admin/css/print.css') }}",
                    header: `<h1 class='text-center mb-4'>Vacancy Report</h1>
                             <p class='text-center text-muted mb-4'>Generated on ${new Date().toLocaleDateString()}</p>`,
                    footer: `<p class='text-center mt-4'>&copy; ${new Date().getFullYear()} Communication & Works Department</p>`,
                });
            });
        });
    </script>
    @endpush
</x-hr-layout>