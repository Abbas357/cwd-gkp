<x-dtms-layout title="District Damages Report">
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

        .district-cell {
            background-color: #f8f9fa;
        }

        .district-name {
            font-weight: 600;
        }

        .officer-name {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .officer-office {
            font-weight: 600;
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

        .officers-list {
            max-height: 80px;
            overflow-y: auto;
            font-size: 0.85rem;
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dtms.dashboard') }}">DTMS</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dtms.reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">District Damages</li>
    </x-slot>

    <div class="container py-2 px-1 rounded">
        <div class="report-header">
            <div class="report-title">
                <h4 class="fw-bold border-bottom pb-2">
                    DISTRICT DAMAGE ASSESSMENT REPORT
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
                            @foreach(setting('infrastructure_type', 'dtms', ['Road', 'Bridge', 'Culvert']) as $infrastructure_type)
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
                            <a href="{{ route('admin.apps.dtms.reports.district-wise') }}" class="cw-btn light ms-3">
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
            <table id="district-damages-report" class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-success text-white text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle">Rank</th>
                        <th scope="col" class="text-center align-middle">District</th>
                        <th scope="col" class="text-center align-middle">Total Infrastructures</th>
                        <th scope="col" class="text-center align-middle">Damaged Infrastructures</th>
                        <th scope="col" class="text-center align-middle">Damage Reports</th>
                        <th scope="col" class="text-center align-middle">Damaged Length</th>
                        <th scope="col" class="text-center align-middle">Fully Restored</th>
                        <th scope="col" class="text-center align-middle">Partially Restored</th>
                        <th scope="col" class="text-center align-middle">Not Restored</th>
                        <th scope="col" class="text-center align-middle">Restoration Cost (M)</th>
                        <th scope="col" class="text-center align-middle">Rehabilitation Cost (M)</th>
                        <th scope="col" class="text-center align-middle">Total Cost (M)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($districtStats as $index => $stats)
                    <tr class="align-middle">
                        <td class="text-center fw-bold">{{ $index + 1 }}</td>
                        <td class="district-cell">
                            <div class="district-name">{{ $stats['district']->name }}</div>
                        </td>
                        <td class="text-center">{{ $stats['infrastructure_count'] }}</td>
                        <td class="text-center">
                            @if($stats['damaged_infrastructure_count'] > 0)
                                {{ $stats['damaged_infrastructure_count'] }}
                            @else
                                <span class="no-damage">None</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($stats['damage_count'] > 0)
                                {{ $stats['damage_count'] }}
                            @else
                                <span class="no-damage">None</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($stats['damaged_length'] > 0)
                                {{ number_format($stats['damaged_length'], 2) }}
                            @else
                                <span class="no-damage">0.00</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $stats['fully_restored'] }}</td>
                        <td class="text-center">{{ $stats['partially_restored'] }}</td>
                        <td class="text-center">{{ $stats['not_restored'] }}</td>
                        <td class="text-center">{{ number_format($stats['restoration_cost'], 2) }}</td>
                        <td class="text-center">{{ number_format($stats['rehabilitation_cost'], 2) }}</td>
                        <td class="text-center fw-bold">{{ number_format($stats['total_cost'], 2) }}</td>
                    </tr>
                    @endforeach
                    
                    <tr class="fw-bold total-row">
                        <td colspan="3" class="text-end">Total:</td>
                        <td class="text-center">{{ $total['total_infrastructure_count'] }}</td>
                        <td class="text-center">{{ $total['total_damaged_infrastructure_count'] }}</td>
                        <td class="text-center">{{ $total['total_damage_count'] }}</td>
                        <td class="text-center">{{ number_format($total['total_damaged_length'], 2) }}</td>
                        <td class="text-center">{{ $total['total_fully_restored'] }}</td>
                        <td class="text-center">{{ $total['total_partially_restored'] }}</td>
                        <td class="text-center">{{ $total['total_not_restored'] }}</td>
                        <td class="text-center">{{ number_format($total['total_restoration_cost'], 2) }}</td>
                        <td class="text-center">{{ number_format($total['total_rehabilitation_cost'], 2) }}</td>
                        <td class="text-center">{{ number_format($total['total_cost'], 2) }}</td>
                    </tr>
                </tbody>
            </table>

            @if($districtStats->isEmpty())
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
                $("#district-damages-report").printThis({
                    header: "<h4 class='text-center mb-3'>District Damages Report</h4>",
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
</x-dtms-layout>