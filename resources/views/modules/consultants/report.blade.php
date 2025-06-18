<x-consultant-layout title="Consultant Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">

    <style>
        .report-card {
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
            margin-bottom: 1.5rem;
        }

        .report-card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem;
            font-weight: 600;
        }

        .report-card-body {
            padding: 1rem;
        }

        .stat-card {
            background: #00916d;
            color: white;
            border-radius: 0.35rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .warning-badge {
            background-color: #ffeaa7;
            color: #2d3436;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .success-badge {
            background-color: #00b894;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .info-badge {
            background-color: #74b9ff;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .table-responsive {
            border-radius: 0.35rem;
            overflow: hidden;
        }

        .table th {
            background-color: #f8f9fc;
            border-color: #e3e6f0;
            font-weight: 600;
            font-size: 0.85rem;
            color: #5a5c69;
        }

        .highlight-row {
            background-color: #fff3cd;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }

    </style>
    @endpush

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="h3 mb-0 text-gray-800">Consultant Report</h1>
                <p class="text-muted">Analyze consultant HR assignments and project details</p>
            </div>
        </div>

        <!-- Consultant Selection -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="w-50">
                <form method="GET" action="{{ route('admin.apps.consultants.report') }}">
                    <label for="load-consultants">Consultants</label>
                    <select class="form-select form-select-md" id="load-consultants" name="consultant_id" onchange="this.form.submit()">
                    </select>
                </form>
            </div>
            <div>
                <button type="button" id="print-consultant-details" class="no-print btn btn-primary btn-sm mt-4">
                    <span class="d-flex align-items-center">
                        <i class="bi-printer me-2"></i>
                        Print Report
                    </span>
                </button>
            </div>
        </div>
        <div id="consultant-report" class="report-container">
            @if($reportData)
            <!-- Statistics Overview -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $reportData['total_projects'] }}</div>
                        <div class="stat-label">Active Projects</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $reportData['total_hr'] }}</div>
                        <div class="stat-label">Total HR</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $reportData['assigned_hr_count'] }}</div>
                        <div class="stat-label">Assigned HR</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-number">{{ $reportData['multiple_assignment_count'] }}</div>
                        <div class="stat-label">Multi-Project HR</div>
                    </div>
                </div>
            </div>

            <!-- Consultant Information -->
            <div class="report-card">
                <div class="report-card-header">
                    <i class="bi-building"></i> Consultant Information
                </div>
                <div class="report-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $reportData['consultant']->name }}</p>
                            <p><strong>Email:</strong> {{ $reportData['consultant']->email }}</p>
                            <p><strong>Contact:</strong> {{ $reportData['consultant']->contact_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Sector:</strong> {{ $reportData['consultant']->sector }}</p>
                            <p><strong>PEC Number:</strong> {{ $reportData['consultant']->pec_number }}</p>
                            <p><strong>District:</strong> {{ $reportData['consultant']->district->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- HR with Multiple Project Assignments -->
            @if(count($reportData['multiple_assignment_hr']) > 0)
            <div class="report-card">
                <div class="report-card-header text-warning">
                    <i class="bi-exclamation-circle"></i> HR with Multiple Project Assignments
                </div>
                <div class="report-card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>HR Name</th>
                                    <th>Designation</th>
                                    <th>Salary</th>
                                    <th>Projects Count</th>
                                    <th>Assigned Projects</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportData['multiple_assignment_hr'] as $item)
                                <tr class="highlight-row">
                                    <td>
                                        <strong>{{ $item['hr']->name }}</strong>
                                        <br><small class="text-muted">{{ $item['hr']->email }}</small>
                                    </td>
                                    <td>{{ $item['hr']->designation }}</td>
                                    <td>{{ number_format($item['hr']->salary, 2) }}</td>
                                    <td>
                                        <span class="warning-badge">{{ $item['project_count'] }} Projects</span>
                                    </td>
                                    <td>
                                        @foreach($item['assignments'] as $assignment)
                                        <div class="mb-1">
                                            <strong>{{ $assignment['project_name'] }}</strong>
                                            <br><small class="text-muted">
                                                {{ $assignment['start_date'] }} to {{ $assignment['end_date'] }}
                                            </small>
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
            @endif

            <!-- Project Details -->
            <div class="report-card">
                <div class="report-card-header">
                    <i class="bi-diagram-3"></i> Project Details
                </div>
                <div class="report-card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>ADP Number</th>
                                    <th>Scheme Code</th>
                                    <th>Duration</th>
                                    <th>Estimated Cost</th>
                                    <th>HR Assigned</th>
                                    <th>HR Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportData['projects'] as $project)
                                <tr>
                                    <td>
                                        <strong>{{ $project['name'] }}</strong>
                                    </td>
                                    <td>{{ $project['adp_number'] }}</td>
                                    <td>{{ $project['scheme_code'] }}</td>
                                    <td>
                                        <small>
                                            {{ $project['start_date'] ?? 'N/A' }} to
                                            {{ $project['end_date'] ?? 'N/A' }}
                                        </small>
                                    </td>
                                    <td>{{ number_format($project['estimated_cost'] ?? 0) }}</td>
                                    <td>
                                        <span class="info-badge">{{ $project['hr_count'] }} HR</span>
                                    </td>
                                    <td>
                                        @foreach($project['assigned_hr'] as $hr)
                                        <div class="mb-1">
                                            <strong>{{ $hr->name }}</strong> - {{ $hr->designation }}
                                            @if(isset($reportData['hr_assignments'][$hr->id]) && count($reportData['hr_assignments'][$hr->id]) > 1)
                                            <span class="warning-badge">Multi-Project</span>
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

            <!-- Unassigned HR -->
            @if(count($reportData['unassigned_hr']) > 0)
            <div class="report-card">
                <div class="report-card-header text-info">
                    <i class="bi-person-circle"></i> Unassigned Human Resources
                </div>
                <div class="report-card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Salary</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reportData['unassigned_hr'] as $hr)
                                <tr>
                                    <td><strong>{{ $hr->name }}</strong></td>
                                    <td>{{ $hr->designation }}</td>
                                    <td>{{ $hr->email }}</td>
                                    <td>{{ $hr->contact_number }}</td>
                                    <td>{{ number_format($hr->salary, 2) }}</td>
                                    <td>
                                        <span class="success-badge">Available</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Summary Section -->
            <div class="report-card">
                <div class="report-card-header">
                    <i class="bi-bar-chart"></i> Summary
                </div>
                <div class="report-card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Resource Utilization</h6>
                            <ul class="list-unstyled">
                                <li><strong>Total HR:</strong> {{ $reportData['total_hr'] }}</li>
                                <li><strong>Assigned HR:</strong> {{ $reportData['assigned_hr_count'] }}</li>
                                <li><strong>Available HR:</strong> {{ $reportData['unassigned_hr_count'] }}</li>
                                <li><strong>Utilization Rate:</strong>
                                    {{ $reportData['total_hr'] > 0 ? round(($reportData['assigned_hr_count'] / $reportData['total_hr']) * 100, 2) : 0 }}%
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Project Status</h6>
                            <ul class="list-unstyled">
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
            @else
            <div class="alert alert-info">
                <i class="bi-info-circle"></i> Please select a consultant to view the report.
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
                '#load-consultants'
                , '{{ route("admin.apps.consultants.api") }}', {
                    placeholder: "Select Consultant"
                    , dropdownParent: $('#load-consultants').closest('body')
                }
            );

            $('#print-consultant-details').on('click', function() {
                Swal.fire({
                    title: 'Preparing Print View'
                    , text: 'Please wait...'
                    , allowOutsideClick: false
                    , didOpen: () => {
                        Swal.showLoading();
                    }
                });

                setTimeout(() => {
                    $("#consultant-report").printThis({
                        pageTitle: "consultant Report - " + new Date().toLocaleDateString()
                        , importCSS: true
                        , importStyle: true
                        , header: "<h1 class='text-center mb-4'>Consultant Report</h1>" +
                            "<p class='text-center text-muted mb-4'>Generated on " + new Date().toLocaleDateString() + "</p>"
                        , footer: "<p class='text-center mt-4'>&copy; " + new Date().getFullYear() + " - All Rights Reserved</p>"
                        , beforePrint() {
                            $('.no-print').hide();
                        }
                        , afterPrint() {
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
