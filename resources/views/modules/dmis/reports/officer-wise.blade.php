<x-dmis-layout title="Damage Report by Officer">
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

        .no-damage {
            color: #6c757d;
            font-style: italic;
        }
        
        .progress-bar-container {
            width: 100%;
            background-color: #e9ecef;
            border-radius: 4px;
            margin-top: 4px;
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
        }
        
        .restoration-bar {
            background-color: #007bff;
        }
        
        .rehabilitation-bar {
            background-color: #28a745;
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
        <li class="breadcrumb-item active" aria-current="page">Report by Officer</li>
    </x-slot>

    <div class="container py-2 px-1 rounded">
        <div class="report-header">
            <div class="report-title">
                <h4 class="fw-bold border-bottom pb-2">
                    DAMAGE REPORT BY OFFICER
                </h4>
                <div class="report-metadata">
                    <span class="badge bg-primary">Report Date: {{ now()->format('F d, Y') }}</span>
                    <span class="badge bg-secondary">Infrastructure Type: {{ $type ?? 'All' }}</span>
                </div>
            </div>
        </div>

        <div class="row mb-4 no-print">
            <div class="col-md-12">
                <form method="get" class="row">
                    <div class="col-md-6">
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
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <button type="submit" class="cw-btn success">
                                <i class="bi-filter me-2"></i> GENERATE REPORT
                            </button>
                            <a href="{{ route('admin.apps.dmis.reports.officer-wise') }}" class="cw-btn light ms-3">
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
            <table id="officer-report" class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-success text-white text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle">Rank</th>
                        <th scope="col" class="text-center align-middle">Officer</th>
                        <th scope="col" class="text-center align-middle">Office & Designation</th>
                        <th scope="col" class="text-center align-middle">Damages Reported</th>
                        <th scope="col" class="text-center align-middle">Infrastructures</th>
                        <th scope="col" class="text-center align-middle">Status Breakdown</th>
                        <th scope="col" class="text-center align-middle">Costs (Millions)</th>
                        <th scope="col" class="text-center align-middle">Last Report</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($officerStats as $index => $stats)
                    @php
                        $lastReported = $stats['last_reported'] ? \Carbon\Carbon::parse($stats['last_reported']) : null;
                        
                        // Calculate percentages for status
                        $totalReports = $stats['fully_restored'] + $stats['partially_restored'] + $stats['not_restored'];
                        $fullyPercent = $totalReports > 0 ? ($stats['fully_restored'] / $totalReports) * 100 : 0;
                        $partiallyPercent = $totalReports > 0 ? ($stats['partially_restored'] / $totalReports) * 100 : 0;
                        $notPercent = $totalReports > 0 ? ($stats['not_restored'] / $totalReports) * 100 : 0;
                        
                        // Calculate cost percentages
                        $totalCost = $stats['restoration_cost'] + $stats['rehabilitation_cost'];
                        $restorePercent = $totalCost > 0 ? ($stats['restoration_cost'] / $totalCost) * 100 : 0;
                        $rehabPercent = $totalCost > 0 ? ($stats['rehabilitation_cost'] / $totalCost) * 100 : 0;
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
                        <td class="text-center">
                            <div class="fw-bold">{{ $stats['damage_count'] }}</div>
                        </td>
                        <td class="text-center">{{ $stats['distinct_infrastructure_count'] }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <small>Fully: {{ $stats['fully_restored'] }}</small>
                                <small>Partially: {{ $stats['partially_restored'] }}</small>
                                <small>Not: {{ $stats['not_restored'] }}</small>
                            </div>
                            <div class="progress-bar-container">
                                <div class="d-flex">
                                    <div class="progress-bar bg-success" style="width: {{ $fullyPercent }}%"></div>
                                    <div class="progress-bar bg-warning" style="width: {{ $partiallyPercent }}%"></div>
                                    <div class="progress-bar bg-danger" style="width: {{ $notPercent }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <div>Total: <span class="fw-bold">{{ number_format($stats['total_cost'], 2) }}</span></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>Restoration: {{ number_format($stats['restoration_cost'], 2) }}</small>
                                <small>Rehab: {{ number_format($stats['rehabilitation_cost'], 2) }}</small>
                            </div>
                            <div class="progress-bar-container">
                                <div class="d-flex">
                                    <div class="progress-bar restoration-bar" style="width: {{ $restorePercent }}%"></div>
                                    <div class="progress-bar rehabilitation-bar" style="width: {{ $rehabPercent }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($lastReported)
                                <div>{{ $lastReported->format('M d, Y') }}</div>
                                <div class="time-ago">{{ $lastReported->diffForHumans() }}</div>
                            @else
                                <span class="no-damage">No reports</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    
                    <tr class="fw-bold total-row">
                        <td colspan="3" class="text-end">Total:</td>
                        <td class="text-center">{{ $total['total_damage_count'] }}</td>
                        <td class="text-center">{{ $total['total_infrastructure_count'] }}</td>
                        <td>
                            <div class="d-flex justify-content-between">
                                <small>Fully: {{ $total['total_fully_restored'] }}</small>
                                <small>Partially: {{ $total['total_partially_restored'] }}</small>
                                <small>Not: {{ $total['total_not_restored'] }}</small>
                            </div>
                        </td>
                        <td>
                            <div>Total: {{ number_format($total['total_cost'], 2) }}</div>
                            <div class="d-flex justify-content-between">
                                <small>R: {{ number_format($total['total_restoration_cost'], 2) }}</small>
                                <small>RH: {{ number_format($total['total_rehabilitation_cost'], 2) }}</small>
                            </div>
                        </td>
                        <td></td>
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
                $("#officer-report").printThis({
                    header: "<h4 class='text-center mb-3'>Damage Report by Officer</h4>",
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