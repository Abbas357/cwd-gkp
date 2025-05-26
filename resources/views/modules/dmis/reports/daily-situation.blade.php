<x-dmis-layout title="Daily Situation Report">
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

        .table th {
            height: 50px;
        }

        .table th[rowspan="2"] {
            background: #eee;
        }

        [data-bs-theme=dark] .table th[rowspan="2"] {
            background: #333;
        }

        .table caption {
            caption-side: top;
            text-align: center;
            padding: 10px;
        }

        .daily-badge {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 1rem;
            display: inline-block;
            box-shadow: 0 2px 10px rgba(255, 107, 107, 0.3);
        }

        .new-damage-indicator {
            background-color: #ff6b6b;
            color: white;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            margin-left: 0.5rem;
        }

        .updated-damage-indicator {
            background-color: #ffa726;
            color: white;
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            margin-left: 0.5rem;
        }
    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Daily Situation Report</li>
    </x-slot>

    <div class="container py-2 px-1 rounded">
        <div class="report-header">
            <div class="report-title">
                <h4 class="fw-bold border-bottom pb-2">
                    DAILY SITUATION REPORT
                    <span class="daily-badge">{{ \Carbon\Carbon::parse($reportDate)->format('M d, Y') }}</span>
                </h4>
            </div>
        </div>

        <div class="row mb-4 no-print">
            <div class="col-md-12">
                <form method="get" class="row">
                    <div class="col-md-4">
                        <label class="form-label" for="type">Infrastructure Type</label>
                        <select name="type" id="type" class="form-control" placeholder="Select Type">
                            @foreach(setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']) as $infrastructure_type)
                            <option value="{{ $infrastructure_type }}" {{ request()->query('type') == $infrastructure_type ? 'selected' : '' }}>
                                {{ $infrastructure_type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="load-users">Reporting Officer</label>
                        <select name="user_id" id="load-users" class="form-select" data-placeholder="Select Officer">
                            <option value="">Select Officer</option>
                            @foreach(App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" @selected((request()->query('user_id')?? null) == $user->id)>
                                {{ $user->name }} ({{ $user->currentDesignation?->name ?? 'No Designation' }} - {{ $user->currentOffice?->name ?? 'Office Not Assigned' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="date">Report Date</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ request()->query('date') ?? now()->format('Y-m-d') }}">
                    </div>
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <button type="submit" class="cw-btn success">
                                <i class="bi-calendar-check me-2"></i> GENERATE DAILY REPORT
                            </button>
                            <a href="{{ route('admin.apps.dmis.reports.daily-situation') }}" class="cw-btn light ms-3">
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
            <table id="daily-situation-report" class="table table-bordered">
                <caption class="report-metadata">
                    <div><strong>Daily Report for:</strong> {{ \Carbon\Carbon::parse($reportDate)->format('F d, Y (l)') }}</div>
                    <div><strong>Officer:</strong> {{ $selectedUser->name }} ({{ $selectedUser->currentDesignation->name ?? 'No Designation' }})</div>
                    <div><strong>Office:</strong> {{ $selectedUser->currentOffice->name ?? 'No Office Assigned' }}</div>
                    <div class="mt-2 text-muted"><small>This report shows damage assessments recorded on the selected date only</small></div>
                </caption>
                <thead>
                    <tr class="bg-danger text-white text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle" rowspan="2">S#</th>
                        <th scope="col" class="text-center align-middle" rowspan="2">Officer</th>
                        <th scope="col" class="text-center align-middle" rowspan="2">District</th>
                        <th scope="colgroup" class="text-center align-middle bg-light" colspan="3">
                            Daily Damages - {{ request()->query("type") ?? "Road" }}s {{ request()->query("type") == "Road" || !request()->has("type") ? "(KM)" : "(Meter)" }}
                        </th>
                        <th scope="colgroup" class="text-center align-middle bg-light" colspan="3">
                            {{ request()->query("type") ?? "Road" }} Status (Today)
                        </th>
                        <th scope="colgroup" class="text-center align-middle bg-light" colspan="2">
                            Approximate Cost (Millions)
                        </th>
                        <th scope="colgroup" class="text-center align-middle bg-warning text-dark" colspan="2">
                            Daily Activity
                        </th>
                    </tr>
                    <tr class="bg-danger bg-opacity-75 text-white text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle">
                            Affected {{ request()->query("type") ?? "Road" }}s
                        </th>
                        <th scope="col" class="text-center align-middle">
                            Total Length
                        </th>
                        <th scope="col" class="text-center align-middle">
                            Damage Length
                        </th>
                        <th scope="col" class="text-center align-middle">
                            Fully Restored
                        </th>
                        <th scope="col" class="text-center align-middle">
                            Partially Restored
                        </th>
                        <th scope="col" class="text-center align-middle">
                            Not Restored
                        </th>
                        <th scope="col" class="text-center align-middle">
                            Restoration
                        </th>
                        <th scope="col" class="text-center align-middle">
                            Rehabilitation
                        </th>
                        <th scope="col" class="text-center align-middle bg-warning text-dark">
                            New Today
                        </th>
                        <th scope="col" class="text-center align-middle bg-warning text-dark">
                            Updated Today
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $serial = 1; @endphp
                    @foreach($subordinatesWithDistricts as $index => $item)
                    @php
                    $subordinate = $item['subordinate'];
                    $districts = $item['districts'];
                    $districtCount = $item['district_count'];
                    @endphp

                    @foreach($districts as $districtIndex => $district)
                    <tr class="align-middle {{ $districtIndex % 2 == 0 ? 'bg-light' : '' }}">
                        @if($districtIndex === 0)
                        <td class="text-center fw-medium" rowspan="{{ $districtCount }}">{{ $serial++ }}</td>
                        @if(isset($subordinateDesignation))
                        <td class="text-center fw-medium officer-cell" rowspan="{{ $districtCount }}">
                            <div class="officer-office">{{ $subordinate?->currentOffice?->name ?? 'No Office' }}</div>
                            <div class="officer-name">({{ $subordinate->name }})</div>
                        </td>
                        @endif
                        @endif
                        <td class="text-center fw-medium">{{ $district->name }}</td>
                        <td class="text-center fw-medium">
                            {{ $district->damaged_infrastructure_count }}
                            @if($district->new_damages_today > 0)
                                <span class="new-damage-indicator">{{ $district->new_damages_today }} new</span>
                            @endif
                        </td>
                        <td class="text-center fw-medium">{{ number_format($district->damaged_infrastructure_total_count, 2) }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->damaged_infrastructure_sum, 2) }}</td>
                        <td class="text-center fw-medium">{{ $district->fully_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->partially_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->not_restored }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->restoration, 2) }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->rehabilitation, 2) }}</td>
                        <td class="text-center fw-medium">
                            <span class="badge bg-danger">{{ $district->new_damages_today ?? 0 }}</span>
                        </td>
                        <td class="text-center fw-medium">
                            <span class="badge bg-warning text-dark">{{ $district->updated_damages_today ?? 0 }}</span>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach

                    @if(count($subordinatesWithDistricts) > 0)
                    <tr class="fw-bold">
                        <th class="bg-light text-center">Total</th>
                        @if(isset($subordinateDesignation))
                        <th class="bg-light text-center"></th>
                        @endif
                        <th class="bg-light text-center"></th>
                        <th class="bg-light text-center">{{ $total["totalDamagedInfrastructureCount"] }}</th>
                        <th class="bg-light text-center">{{ number_format($total["totalDamagedInfrastructureTotalCount"], 2) }}</th>
                        <th class="bg-light text-center">{{ number_format($total["totalDamagedInfrastructureSum"], 2) }}</th>
                        <th class="bg-light text-center">{{ $total["totalFullyRestored"] }}</th>
                        <th class="bg-light text-center">{{ $total["totalPartiallyRestored"] }}</th>
                        <th class="bg-light text-center">{{ $total["totalNotRestored"] }}</th>
                        <th class="bg-light text-center">{{ number_format($total["totalRestorationCost"], 2) }}</th>
                        <th class="bg-light text-center">{{ number_format($total["totalRehabilitationCost"], 2) }}</th>
                        <th class="bg-light text-center">
                            <span class="badge bg-danger">
                                {{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('new_damages_today') }}
                            </span>
                        </th>
                        <th class="bg-light text-center">
                            <span class="badge bg-warning text-dark">
                                {{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('updated_damages_today') }}
                            </span>
                        </th>
                    </tr>
                    @endif
                </tbody>
            </table>

            @if(count($subordinatesWithDistricts) == 0)
            <div class="alert alert-warning text-center">
                <i class="bi-calendar-x me-2"></i>
                No damage reports found for {{ \Carbon\Carbon::parse($reportDate)->format('F d, Y') }}. 
                Try selecting a different date or officer.
            </div>
            @endif
        </div>

        @if(count($subordinatesWithDistricts) > 0)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi-info-circle me-2"></i>Daily Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="card border-danger">
                                    <div class="card-body">
                                        <h6 class="text-danger">New Damages Today</h6>
                                        <h3 class="text-danger">{{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('new_damages_today') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <h6 class="text-warning">Updates Today</h6>
                                        <h3 class="text-warning">{{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('updated_damages_today') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-success">
                                    <div class="card-body">
                                        <h6 class="text-success">Total Restored</h6>
                                        <h3 class="text-success">{{ $total["totalFullyRestored"] }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h6 class="text-primary">Cost (Millions)</h6>
                                        <h3 class="text-primary">{{ number_format($total["totalRestorationCost"] + $total["totalRehabilitationCost"], 2) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            select2Ajax(
                '#load-users', 
                '{{ route("admin.apps.hr.users.api") }}', {
                    placeholder: "Select Officer",
                    dropdownParent: $('#load-users').closest('body')
                }
            );

            $('#print-report').on('click', () => {
                $("#daily-situation-report").printThis({
                    header: "<h4 class='text-center mb-3'>Daily Infrastructure Damage Situation Report - {{ \Carbon\Carbon::parse($reportDate)->format('F d, Y') }}</h4>",
                    beforePrint() {
                        document.querySelector('.page-loader').classList.remove('hidden');
                    },
                    afterPrint() {
                        document.querySelector('.page-loader').classList.add('hidden');
                    }
                });
            });

            // Auto-refresh functionality (optional)
            @if(request()->query('date') == now()->format('Y-m-d'))
            setInterval(() => {
                const now = new Date();
                const lastRefresh = localStorage.getItem('lastDailyReportRefresh');
                const fiveMinutesAgo = now.getTime() - (5 * 60 * 1000);
                
                if (!lastRefresh || parseInt(lastRefresh) < fiveMinutesAgo) {
                    localStorage.setItem('lastDailyReportRefresh', now.getTime());
                    // Uncomment below line if you want auto-refresh
                    // location.reload();
                }
            }, 300000); // Check every 5 minutes
            @endif
        });
    </script>
    @endpush
</x-dmis-layout>