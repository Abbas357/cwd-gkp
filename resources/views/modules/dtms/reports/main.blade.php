<x-dtms-layout title="Damages Report">
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

    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Damages Reports</li>
    </x-slot>

    <div class="container py-2 px-1 rounded">
        <div class="report-header">
            <div class="report-title">
                <h4 class="fw-bold border-bottom pb-2">
                    DAMAGE ASSESSMENT REPORT
                </h4>
            </div>
        </div>

        <div class="row mb-4 no-print">
            <div class="col-md-12">
                <form method="get" class="row">
                    <div class="col-md-6">
                        <label class="form-label" for="type">Infrastructure Type</label>
                        <select name="type" id="type" class="form-control" placeholder="Select Type">
                            @foreach(setting('infrastructure_type', 'dtms', ['Road', 'Bridge', 'Culvert']) as $infrastructure_type)
                            <option value="{{ $infrastructure_type }}" {{ request()->query('type') == $infrastructure_type ? 'selected' : '' }}>
                                {{ $infrastructure_type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
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
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <button type="submit" class="cw-btn success">
                                <i class="bi-filter me-2"></i> GENERATE REPORT
                            </button>
                            <a href="{{ route('admin.apps.dtms.reports.index') }}" class="cw-btn light ms-3">
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
            <table id="assessment-report" class="table table-bordered">
                <caption class="report-metadata">
                    <div><strong>Report Date:</strong> {{ now()->format('F d, Y') }}</div>
                    <div><strong>Officer:</strong> {{ $selectedUser->name }} ({{ $selectedUser->currentDesignation->name ?? 'No Designation' }})</div>
                    <div><strong>Office:</strong> {{ $selectedUser->currentOffice->name ?? 'No Office Assigned' }}</div>
                </caption>
                <thead>
                    <tr class="bg-success text-white text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle" rowspan="2">S#</th>
                        <th scope="col" class="text-center align-middle" rowspan="2">Officer</th>
                        <th scope="col" class="text-center align-middle" rowspan="2">District</th>
                        <th scope="colgroup" class="text-center align-middle bg-light" colspan="3">
                            Damaged {{ request()->query("type") ?? "Road" }}s {{ request()->query("type") == "Road" || !request()->has("type") ? "(KM)" : "(Meter)" }}
                        </th>
                        <th scope="colgroup" class="text-center align-middle bg-light" colspan="3">
                            {{ request()->query("type") ?? "Road" }} Status
                        </th>
                        <th scope="colgroup" class="text-center align-middle bg-light" colspan="2">
                            Approximate Cost (Millions)
                        </th>
                    </tr>
                    <tr class="bg-success bg-opacity-75 text-white text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle">
                            Effected {{ request()->query("type") ?? "Road" }}s
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
                        <td class="text-center fw-medium">{{ $district->damaged_infrastructure_count }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->damaged_infrastructure_total_count, 2) }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->damaged_infrastructure_sum, 2) }}</td>
                        <td class="text-center fw-medium">{{ $district->fully_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->partially_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->not_restored }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->restoration, 2) }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->rehabilitation, 2) }}</td>
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
                    </tr>
                    @endif
                </tbody>
            </table>

            @if(count($subordinatesWithDistricts) == 0)
            <div class="alert alert-info text-center">
                <i class="bi-info-circle me-2"></i>
                No damages found for the selected criteria. Try changing your filters or select a different officer.
            </div>
            @endif
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            select2Ajax(
                '#load-users'
                , '{{ route("admin.apps.hr.users.api") }}', {
                    placeholder: "Select Officer"
                    , dropdownParent: $('#load-users').closest('body')
                }
            );

            $('#print-report').on('click', () => {
                $("#assessment-report").printThis({
                    header: "<h4 class='text-center mb-3'>Infrastructure Damages Report</h4>"
                    , beforePrint() {
                        document.querySelector('.page-loader').classList.remove('hidden');
                    }
                    , afterPrint() {
                        document.querySelector('.page-loader').classList.add('hidden');
                    }
                });
            });
        });

    </script>
    @endpush
</x-dtms-layout>
