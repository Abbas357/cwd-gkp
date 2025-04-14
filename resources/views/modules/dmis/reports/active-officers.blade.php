<x-dmis-layout title="Active Officers Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        .table> :not(caption)>*>* {
            vertical-align: middle;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .receipt-details {
            line-height: 1.6;
        }

        .receipt-details small {
            color: #6c757d;
            display: block;
        }

        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 0.25rem;
            text-transform: capitalize;
        }

        .table-container {
            border-radius: 0.5rem;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .filter-section {
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #e9ecef;
        }

        .card-body {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }

        .cw-btn,
        .btn {
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cw-btn:hover,
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                font-size: 12pt;
            }

            table {
                page-break-inside: avoid;
            }
        }

        .amount-cell {
            text-align: right;
            font-family: monospace;
            font-weight: 500;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .officer-cell {
            background-color: #f8f9fa;
        }

        .officer-name {
            font-weight: 600;
        }

        .officer-designation {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .officer-office {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .report-title {
            display: flex;
            flex-direction: column;
        }

        .report-metadata {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .table {
            border: 1px solid #999999AA
        }

        .no-activity {
            color: #6c757d;
            font-style: italic;
        }
        
        .district-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            max-width: 300px;
        }
        
        .district-badge {
            font-size: 0.75rem;
            background-color: #f0f0f0;
            border-radius: 12px;
            padding: 2px 8px;
            white-space: nowrap;
        }
        
        .activity-indicator {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        
        .activity-high {
            background-color: #28a745;
        }
        
        .activity-medium {
            background-color: #ffc107;
        }
        
        .activity-low {
            background-color: #dc3545;
        }
        
        .activity-none {
            background-color: #6c757d;
        }
        
        .time-ago {
            font-size: 0.8rem;
            color: #6c757d;
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.dashboard') }}">dmis</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Active Officers</li>
    </x-slot>

    <div class="container py-2 px-1 rounded">
        <div class="report-header">
            <div class="report-title">
                <h4 class="fw-bold border-bottom pb-2">
                    ACTIVE OFFICERS REPORT
                </h4>
                <div class="report-metadata">
                    <span class="badge bg-primary">Report Date: {{ now()->format('F d, Y') }}</span>
                    <span class="badge bg-secondary">Infrastructure Type: {{ $type ?? 'All' }}</span>
                    <span class="badge bg-info">Period: Last {{ $period }} days</span>
                </div>
            </div>
        </div>

        <div class="row mb-4 no-print">
            <div class="col-md-12">
                <form method="get" class="row">
                    <div class="col-md-4">
                        <label class="form-label" for="type">Infrastructure Type</label>
                        <select name="type" id="type" class="form-control" placeholder="Select Type">
                            <option value="All" {{ request()->query('type') == 'All' ? 'selected' : '' }}>All Types</option>
                            @foreach(setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']) as $infrastructure_type)
                            <option value="{{ $infrastructure_type }}" {{ request()->query('type') == $infrastructure_type ? 'selected' : '' }}>
                                {{ $infrastructure_type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="period">Time Period (Days)</label>
                        <select name="period" id="period" class="form-control">
                            <option value="7" {{ request()->query('period') == '7' ? 'selected' : '' }}>Last 7 Days</option>
                            <option value="30" {{ request()->query('period') == '30' || !request()->has('period') ? 'selected' : '' }}>Last 30 Days</option>
                            <option value="90" {{ request()->query('period') == '90' ? 'selected' : '' }}>Last 90 Days</option>
                            <option value="180" {{ request()->query('period') == '180' ? 'selected' : '' }}>Last 180 Days</option>
                            <option value="365" {{ request()->query('period') == '365' ? 'selected' : '' }}>Last 365 Days</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <button type="submit" class="cw-btn success">
                                <i class="bi-filter me-2"></i> GENERATE REPORT
                            </button>
                            <a href="{{ route('admin.apps.dmis.reports.active-officers') }}" class="cw-btn light ms-3">
                                <i class="bi-arrow-counterclockwise me-1"></i> RESET
                            </a>
                        </div>
                        <div>
                            <button type="button" id="print-report" class="cw-btn dark ms-3">
                                <i class="bi-printer me-1"></i> PRINT REPORT
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table id="active-officers-report" class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-success text-white text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle">Rank</th>
                        <th scope="col" class="text-center align-middle">Officer</th>
                        <th scope="col" class="text-center align-middle">Office & Designation</th>
                        <th scope="col" class="text-center align-middle">Assigned Districts</th>
                        <th scope="col" class="text-center align-middle">Activity Status</th>
                        <th scope="col" class="text-center align-middle">Recent Reports</th>
                        <th scope="col" class="text-center align-middle">Total Reports</th>
                        <th scope="col" class="text-center align-middle">Last Activity</th>
                        <th scope="col" class="text-center align-middle">Recent Costs (M)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($officerStats as $index => $stats)
                    @php
                        $activityStatus = 'none';
                        if ($stats['recent_damage_count'] > 10) {
                            $activityStatus = 'high';
                        } elseif ($stats['recent_damage_count'] > 5) {
                            $activityStatus = 'medium';
                        } elseif ($stats['recent_damage_count'] > 0) {
                            $activityStatus = 'low';
                        }
                        
                        $lastActivity = $stats['last_activity'] ? \Carbon\Carbon::parse($stats['last_activity']) : null;
                    @endphp
                    <tr class="align-middle">
                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                        <td class="officer-cell">
                            <div class="officer-name">{{ $stats['officer']->name }}</div>
                        </td>
                        <td>
                            <div class="officer-office">{{ $stats['officer']->currentOffice?->name ?? 'No Office Assigned' }}</div>
                            <div class="officer-designation">{{ $stats['officer']->currentDesignation?->name ?? 'No Designation' }}</div>
                        </td>
                        <td>
                            <div class="district-badges">
                                @if($stats['assigned_districts']->isEmpty())
                                    <span class="no-activity">No districts assigned</span>
                                @else
                                    @foreach($stats['assigned_districts'] as $district)
                                        <span class="district-badge">{{ $district->name }}</span>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="activity-indicator activity-{{ $activityStatus }}"></span>
                            @if($activityStatus == 'high')
                                Very Active
                            @elseif($activityStatus == 'medium')
                                Active
                            @elseif($activityStatus == 'low')
                                Low Activity
                            @else
                                No Activity
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="fw-bold">{{ $stats['recent_damage_count'] }}</div>
                            <small class="text-muted">Last {{ $period }} days</small>
                        </td>
                        <td class="text-center">{{ $stats['all_damage_count'] }}</td>
                        <td class="text-center">
                            @if($lastActivity)
                                <div>{{ $lastActivity->format('M d, Y') }}</div>
                                <div class="time-ago">{{ $lastActivity->diffForHumans() }}</div>
                            @else
                                <span class="no-activity">No activity</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div>{{ number_format($stats['recent_total_cost'], 2) }}</div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">R: {{ number_format($stats['recent_restoration_cost'], 2) }}</small>
                                <small class="text-muted">RH: {{ number_format($stats['recent_rehabilitation_cost'], 2) }}</small>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    <tr class="fw-bold total-row">
                        <td colspan="5" class="text-end">Total:</td>
                        <td class="text-center">{{ $total['total_recent_damage_count'] }}</td>
                        <td class="text-center">{{ $total['total_all_damage_count'] }}</td>
                        <td></td>
                        <td class="text-center">{{ number_format($total['total_recent_cost'], 2) }}</td>
                    </tr>
                </tbody>
            </table>

            @if($officerStats->isEmpty())
            <div class="alert alert-info text-center">
                <i class="bi-info-circle me-2"></i>
                No data available for the selected criteria.
            </div>
            @endif
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#print-report').on('click', () => {
                $("#active-officers-report").printThis({
                    header: "<h4 class='text-center mb-3'>Active Officers Report</h4>",
                    beforePrint() {
                        document.querySelector('.page-loader').classList.remove('hidden');
                    },
                    afterPrint() {
                        document.querySelector('.page-loader').classList.add('hidden');
                    }
                });
            });
        });
    </script>
    @endpush
</x-dmis-layout>