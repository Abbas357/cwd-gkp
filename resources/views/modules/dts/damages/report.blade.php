<x-dts-layout title="Damages Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        .table > :not(caption) > * > * {
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
        .cw-btn, .btn {
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .cw-btn:hover, .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Damages Reports</li>
    </x-slot>
    
    <div class="container py-2 px-1 rounded">
        <h3 class="fw-bold border-bottom pb-2">ABSTRACT OF {{ strtoupper(request()->query("type") ?? "Road") }} DAMAGES</h3>
    
        <div class="table-responsive">
            
            <form method="get">
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label" id="type">Select Type</label>
                        <select name="type" id="type" class="form-control" placeholder="Select Type">
                            @foreach(setting('infrastructure_type', 'dts') as $infrastructure_type)
                                <option value="{{ $infrastructure_type }}" {{ request()->query('type') == $infrastructure_type ? 'selected' : '' }}>
                                    {{ $infrastructure_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="load-users">User / Office</label>
                        <select name="user_id" id="load-users" class="form-select" data-placeholder="Select User / Office">
                            <option value="">Select Officer</option>
                            @foreach(App\Models\User::all() as $user)
                                <option value="{{ $user->id }}" @selected((request()->query('user_id')?? null) == $user->id)>
                                    {{ $user?->currentOffice?->name ?? 'Office Not Assigned' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <hr class="">
                        <div class="action-buttons">
                            <button type="submit" class="cw-btn">
                                <i class="bi-filter me-2"></i> GENERATE REPORT
                            </button>
                            <a href="{{ route('admin.apps.dts.damages.report') }}" class="btn btn-sm px-3 border fs-6 py-1 btn-light">
                                <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-end mb-3">
                <button type="button" id="print-report" class="btn btn-outline-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer me-2" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
                    </svg>
                    Print Report
                </button>
            </div>
    
            <table id="assessment-report" class="table table-bordered">
                <thead>
                    <tr class="bg-success text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle" rowspan="2">S#</th>
                        @if(empty(request()->query("CE")) && auth()->user()->designation !== "CE")
                        <th scope="col" class="text-center align-middle" rowspan="2">Chief Engineer</th>
                        @endif
                        <th scope="col" class="text-center align-middle" rowspan="2">District</th>
                        <th scope="colgroup" class="text-center align-middle" colspan="3">
                            Damaged {{ request()->query("type") ?? "Road" }}s {{ request()->query("type") == "Road" || !request()->has("type") ? "(KM)" : "(Meter)" }}
                        </th>
                        <th scope="colgroup" class="text-center align-middle" colspan="3">
                            {{ request()->query("type") ?? "Road" }} Status
                        </th>
                        <th scope="colgroup" class="text-center align-middle" colspan="2">
                            Approximate Cost (Millions)
                        </th>
                    </tr>
                    <tr class="bg-success bg-opacity-10 text-uppercase fw-bold">
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
                    @foreach($districts as $district)
                    <tr class="align-middle">
                        <td class="text-center fw-medium">{{ $serial++ }}</td>
                        @if(empty(request()->query("CE")) && auth()->user()->designation !== "CE")
                        <td class="text-center fw-medium">{{ $district->chiefEngineer->name ?? 'N/A' }}</td>
                        @endif
                        <td class="text-center fw-medium">{{ $district->name }}</td>
                        <td class="text-center fw-medium">{{ $district->damaged_infrastructure_count }}</td>
                        <td class="text-center fw-medium">{{ $district->damaged_infrastructure_total_count }}</td>
                        <td class="text-center fw-medium">{{ $district->damaged_infrastructure_sum }}</td>
                        <td class="text-center fw-medium">{{ $district->fully_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->partially_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->not_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->restoration }}</td>
                        <td class="text-center fw-medium">{{ $district->rehabilitation }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg-light fw-bold">
                        <th class="text-center" rowspan="2">Total</th>
                        @if(empty(request()->query("CE")) && auth()->user()->designation !== "CE")
                        <th class="text-center"></th>
                        @endif
                        <th class="text-center"></th>
                        <th class="text-center">{{ $total["totalDamagedInfrastructureCount"] }}</th>
                        <th class="text-center">{{ $total["totalDamagedInfrastructureTotalCount"] }}</th>
                        <th class="text-center">{{ $total["totalDamagedInfrastructureSum"] }}</th>
                        <th class="text-center">{{ $total["totalFullyRestored"] }}</th>
                        <th class="text-center">{{ $total["totalPartiallyRestored"] }}</th>
                        <th class="text-center">{{ $total["totalNotRestored"] }}</th>
                        <th class="text-center">{{ $total["totalRestorationCost"] }}</th>
                        <th class="text-center">{{ $total["totalRehabilitationCost"] }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        $(document).ready(function() {
            
        select2Ajax(
            '#load-users',
            '{{ route("admin.apps.hr.users.api") }}',
            {
                placeholder: "Select User / Office",
                dropdownParent: $('#load-users').closest('body')
            }
        );

        $('#print-report').on('click', () => {
            $("#assessment-report").printThis({
                pageTitle: "Infrastructure Damages Report",
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
</x-dts-layout>