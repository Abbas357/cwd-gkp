<x-consultant-layout title="Consultant Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">

    <style>
        .page-header {
            border-bottom: 3px solid #3498db;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        /* Report Cards */
        .report-card {
            border: 1px solid #e8ecef;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            background: white;
            overflow: hidden;
        }

        .report-card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .report-card-header i {
            font-size: 1.2rem;
            color: #6c757d;
        }

        .report-card-body {
            padding: 1.5rem;
        }

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgb(241, 247, 250);
            border: 2px solid #e6ecf2;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(52, 152, 219, 0.6);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2980b9);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.95rem;
            color: #7f8c8d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Badges */
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-success {
            background-color: #d1eddd;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        /* Tables */
        .table-container {
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .table th {
            background-color: #f8f9fa;
            border-color: #dee2e6;
            font-weight: 600;
            font-size: 0.85rem;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
            border-bottom: 2px solid #dee2e6;
            vertical-align: middle
        }

        .table td {
            padding: .5rem !important;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .highlight-row {
            background-color: #fff3cd !important;
            border-left: 4px solid #ffc107;
        }

        .highlight-row:hover {
            background-color: #ffeaa7 !important;
        }

        /* Selection Area */
        .selection-area {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .selection-area label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            display: block;
        }

        /* Buttons */
        .btn-print {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.3);
            color: white;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .info-item {
            margin-bottom: 1rem;
        }

        .info-item strong {
            color: #2c3e50;
            font-weight: 600;
            display: inline-block;
            min-width: 120px;
        }

        /* Summary Grid */
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .summary-section h6 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        .summary-list {
            list-style: none;
            padding: 0;
        }

        .summary-list li {
            margin-bottom: 0.75rem;
            padding: 0.5rem 0;
            border-bottom: 1px dotted #e9ecef;
        }

        .summary-list li:last-child {
            border-bottom: none;
        }

        /* Alert */
        .custom-alert {
            background: #e3f2fd;
            border: 1px solid #bbdefb;
            border-left: 4px solid #2196f3;
            border-radius: 6px;
            padding: 1.5rem;
            color: #0d47a1;
        }

        .badge-warning,
            .badge-success,
            .badge-info {
                margin-bottom: .5rem;
                display: inline-block;
            }

        /* Print Styles */
        @media print {
            body {
                font-size: 12px;
                line-height: 1.4;
                color: #000 !important;
            }

            .page-header {
                border-bottom: 2px solid #000;
                margin-bottom: 20px;
            }

            .stat-card {
                border: 1px solid #000;
                background: white !important;
                box-shadow: none;
                margin-bottom: 15px;
                page-break-inside: avoid;
                height: 150px
            }

            .stat-card::before {
                display: none;
            }

            .report-card {
                border: 1px solid #000;
                background: white !important;
                box-shadow: none;
                margin-bottom: 20px;
                page-break-inside: avoid;
            }

            .report-card-header {
                background: white !important;
                border-bottom: 1px solid #000;
                color: #000 !important;
            }

            .table th {
                background: white !important;
                color: #000 !important;
                border: 1px solid #000;
            }

            .table td {
                border: 1px solid #000;
                color: #000 !important;
            }

            .highlight-row {
                background: #f5f5f5 !important;
                border-left: 2px solid #000;
            }

            .badge-warning,
            .badge-success,
            .badge-info {
                background: white !important;
                color: #000 !important;
                border: 1px solid #000;
                margin-bottom: .5rem;
                display: inline-block;
            }

            .stats-grid {
                display: block;
                text-align: center;
            }

            .stat-card {
                display: inline-block;
                width: 20%;
                margin-right: 2%;
                vertical-align: top;
            }

            .info-grid,
            .summary-grid {
                display: block;
            }

            .custom-alert {
                background: white !important;
                border: 1px solid #000;
                color: #000 !important;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .info-grid,
            .summary-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .selection-area {
                padding: 1rem;
            }

            .table-container {
                font-size: 0.8rem;
            }
        }
    </style>
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="h2 mb-0">Consultant Report</h1>
            <p class="mb-0">Comprehensive analysis of consultant HR assignments and project details</p>
        </div>

        <!-- Consultant Selection -->
        <div class="selection-area no-print">
            <div class="d-flex justify-content-between align-items-end">
                <div style="flex: 1; max-width: 800px;">
                    <form method="GET" action="{{ route('admin.apps.consultants.report') }}">
                        <label for="load-consultants">Select Consultant</label>
                        <select class="form-select" id="load-consultants" name="consultant_id" onchange="this.form.submit()">
                        </select>
                    </form>
                </div>
                <div class="ms-2">
                    <button type="button" id="print-consultant-details" class="cw-btn btn-print">
                        <i class="bi-printer me-2"></i>
                        Print Report
                    </button>
                </div>
            </div>
        </div>

        <div id="consultant-report" class="report-container">
            @if($reportData)
            <!-- Statistics Overview -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $reportData['total_projects'] }}</div>
                    <div class="stat-label">Active Projects</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $reportData['total_hr'] }}</div>
                    <div class="stat-label">Total HR</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $reportData['assigned_hr_count'] }}</div>
                    <div class="stat-label">Assigned HR</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $reportData['multiple_assignment_count'] }}</div>
                    <div class="stat-label">Multi-Project HR</div>
                </div>
            </div>

            <!-- Consultant Information -->
            <div class="report-card">
                <div class="report-card-header">
                    <i class="bi-building"></i>
                    Consultant Information
                </div>
                <div class="report-card-body">
                    <div class="info-grid">
                        <div>
                            <div class="info-item">
                                <strong>Name:</strong> {{ $reportData['consultant']->name }}
                            </div>
                            <div class="info-item">
                                <strong>Email:</strong> {{ $reportData['consultant']->email }}
                            </div>
                            <div class="info-item">
                                <strong>Contact:</strong> {{ $reportData['consultant']->contact_number }}
                            </div>
                        </div>
                        <div>
                            <div class="info-item">
                                <strong>Sector:</strong> {{ $reportData['consultant']->sector }}
                            </div>
                            <div class="info-item">
                                <strong>PEC Number:</strong> {{ $reportData['consultant']->pec_number }}
                            </div>
                            <div class="info-item">
                                <strong>District:</strong> {{ $reportData['consultant']->district->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Section -->
            <div class="report-card">
                <div class="report-card-header">
                    <i class="bi-bar-chart"></i>
                    Overview
                </div>
                <div class="report-card-body">
                    <div class="summary-grid">
                        <div class="summary-section">
                            <h6>Resource Utilization</h6>
                            <ul class="summary-list">
                                <li><strong>Total HR:</strong> {{ $reportData['total_hr'] }}</li>
                                <li><strong>Assigned HR:</strong> {{ $reportData['assigned_hr_count'] }}</li>
                                <li><strong>Available HR:</strong> {{ $reportData['unassigned_hr_count'] }}</li>
                                <li><strong>Utilization Rate:</strong>
                                    {{ $reportData['total_hr'] > 0 ? round(($reportData['assigned_hr_count'] / $reportData['total_hr']) * 100, 2) : 0 }}%
                                </li>
                            </ul>
                        </div>
                        <div class="summary-section">
                            <h6>Project Status</h6>
                            <ul class="summary-list">
                                <li><strong>Active Projects:</strong> {{ $reportData['total_projects'] }}</li>
                                <li><strong>Multi-Assignment Issues:</strong> {{ $reportData['multiple_assignment_count'] }}</li>
                                @if($reportData['multiple_assignment_count'] > 0)
                                <li class="text-warning">
                                    <i class="bi-exclamation-circle"></i>
                                    Some HR are assigned to multiple projects simultaneously
                                </li>
                                @else
                                <li class="text-success">
                                    <i class="bi-check-circle"></i>
                                    No HR assignment conflicts detected
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combined HR Details Table -->
            <div class="report-card">
                <div class="report-card-header">
                    <i class="bi-people"></i>
                    Human Resources Details
                </div>
                <div class="report-card-body">
                    <div class="table-container">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Contact Details</th>
                                    <th>Salary</th>
                                    <th>Project Assignments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportData['all_hr'] as $hr)
                                <tr class="{{ isset($reportData['hr_assignments'][$hr->id]) && count($reportData['hr_assignments'][$hr->id]) > 1 ? 'highlight-row' : '' }}">
                                    <td class="fw-bold">{{ $hr->name }}</td>
                                    <td>{{ $hr->designation }}</td>
                                    <td>
                                        <div><small class="text-muted">Email: {{ $hr->email }}</small></div>
                                        <div><small class="text-muted">CNIC: {{ $hr->cnic_number }}</small></div>
                                        <div><small class="text-muted">Contact: {{ $hr->contact_number }}</small></div>
                                    </td>
                                    <td>{{ number_format($hr->salary, 2) }}</td>
                                    <td>
                                        @if(isset($reportData['hr_assignments'][$hr->id]))
                                            @php
                                                $assignments = $reportData['hr_assignments'][$hr->id];
                                                $assignmentCount = count($assignments);
                                            @endphp
                                            
                                            @if($assignmentCount > 1)
                                                <span class="badge-warning">{{ $assignmentCount }} Projects</span>
                                            @else
                                                <span class="badge-success">1 Project</span>
                                            @endif
                                            
                                            @foreach($assignments as $assignment)
                                                <div class="mb-2 border-bottom pb-1">
                                                    <div class="fw-bold">
                                                        @if(count($assignments) > 1)
                                                            {{ $loop->iteration }}. 
                                                        @endif
                                                        {{ $assignment['project_name'] }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $assignment['start_date'] }} to {{ $assignment['end_date'] }}
                                                    </small>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="badge-info">No Assignments</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div class="report-card">
                <div class="report-card-header">
                    <i class="bi-diagram-3"></i>
                    Project Details
                </div>
                <div class="report-card-body">
                    <div class="table-container">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name & ADP No</th>
                                    <th>Scheme Code</th>
                                    <th>Duration</th>
                                    <th style="max-width: 100px">Estimated Cost (In Millions)</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportData['projects'] as $project)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $project['name'] }} - ({{ $project['adp_number'] }})</div>
                                    </td>
                                    <td>{{ $project['scheme_code'] }}</td>
                                    <td>
                                        <small class="text-center">
                                            <div>{{ $project['start_date'] ?? 'N/A' }} </div>
                                            <div>to</div>
                                            <div> {{ $project['end_date'] ?? 'N/A' }}</div>
                                            
                                            
                                           
                                        </small>
                                    </td>
                                    <td>{{ number_format($project['estimated_cost'] ?? 0) }}</td>
                                    <td>
                                        <span class="badge-info">{{ $project['hr_count'] }} HR</span>
                                        @foreach($project['assigned_hr'] as $hr)
                                        <div class="mb-1">
                                            <span class="fw-bold">{{ $hr->name }}</span> - {{ $hr->designation }}
                                            @if(isset($reportData['hr_assignments'][$hr->id]) && count($reportData['hr_assignments'][$hr->id]) > 1)
                                            <span class="badge-warning">Multi</span>
                                            @endif
                                        </div>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="custom-alert">
                <i class="bi-info-circle me-2"></i>
                Please select a consultant from the dropdown above to generate and view the comprehensive report.
            </div>
            @endif
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const multiProjectHR = @json($reportData ? array_column($reportData['multiple_assignment_hr'], 'hr') : []);

            select2Ajax(
                '#load-consultants',
                '{{ route("admin.apps.consultants.api") }}', {
                    placeholder: "Select Consultant",
                    dropdownParent: $('#load-consultants').closest('body')
                }
            );

            $('#print-consultant-details').on('click', function() {
                Swal.fire({
                    title: 'Preparing Print View',
                    text: 'Please wait while we prepare your report...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    $("#consultant-report").printThis({
                        pageTitle: "Consultant Report - " + new Date().toLocaleDateString(),
                        importCSS: true,
                        importStyle: true,
                        header: "<div style='text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px;'>" +
                               "<h1 style='margin: 0; color: #000; font-size: 24px;'>Consultant Report</h1>" +
                               "<p style='margin: 10px 0 0 0; color: #666; font-size: 14px;'>Generated on " + new Date().toLocaleDateString() + "</p>" +
                               "</div>",
                        footer: "<div style='text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #000; font-size: 12px; color: #666;'>" +
                               "<p>Note: This is a computer-generated report. Every effort has been made to ensure the accuracy of the information provided. Please contact IT Cell if you notice any discrepancies or omissions.</p>" +
                               "</div>",
                        beforePrint() {
                            $('.no-print').hide();
                        },
                        afterPrint() {
                            $('.no-print').show();
                            Swal.close();
                        }
                    });
                }, 500);
            });
        });
    </script>
    @endpush
</x-consultant-layout>