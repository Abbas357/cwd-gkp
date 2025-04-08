<x-porms-layout title="Provincial Own Receipts Reports">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        /* General Table and Layout Styles */
        .table > :not(caption) > * > * {
            vertical-align: middle;
        }
        .table th {
            background-color: #f8f9fa;
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
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .filter-section {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        /* Enhanced Styles */
        .card-header {
            background-color: #e9ecef; /* Lighter grey */
        }
        .card-body {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa); /* Very subtle gradient */
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
        /* Print Styling */
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
        <li class="breadcrumb-item active" aria-current="page">Provincial Own Receipts Reports</li>
    </x-slot>

    <div class="container p-4 p-lg-5 bg-white shadow rounded">
        <h1 class="display-6 mb-3 fw-bold border-bottom pb-2">ABSTRACT OF {{ '{{ strtoupper(request()->query("type") ?? "Road") }}' }} DAMAGES</h1>
    
        <div class="table-responsive">
            <div class="text-center mb-4">
                <a href="{{ '{{ request()->fullUrlWithQuery(["type" => "Road"]) }}' }}" class="btn btn-outline-secondary me-2 mb-2 position-relative {{ '{{ request()->query("type") == "Road" || !request()->has("type") == "Road" ? "border-2 bg-light" : "" }}' }}">
                    Road
                    @if ('{{ request()->query("type") == "Road" || !request()->has("type") == "Road" }}')
                    <span class="position-absolute bottom-0 start-50 translate-middle-x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </span>
                    @endif
                </a>
                <a href="{{ '{{ request()->fullUrlWithQuery(["type" => "Bridge"]) }}' }}" class="btn btn-outline-primary me-2 mb-2 position-relative {{ '{{ request()->query("type") == "Bridge" ? "border-2" : "" }}' }}">
                    Bridge
                    @if ('{{ request()->query("type") == "Bridge" }}')
                    <span class="position-absolute bottom-0 start-50 translate-middle-x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </span>
                    @endif
                </a>
                <a href="{{ '{{ request()->fullUrlWithQuery(["type" => "Culvert"]) }}' }}" class="btn btn-outline-success me-2 mb-2 position-relative {{ '{{ request()->query("type") == "Culvert" ? "border-2" : "" }}' }}">
                    Culvert
                    @if ('{{ request()->query("type") == "Culvert" }}')
                    <span class="position-absolute bottom-0 start-50 translate-middle-x">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </span>
                    @endif
                </a>
            </div>
            
            <form method="get" onchange="this.submit()">
                <div class="row mt-4 mb-4 g-3">
                    @can('view', App\Models\User::class)
                    <div class="col-md-4">
                        <label for="CE" class="form-label">Select Chief Engineer</label>
                        <select class="form-select" name="CE" id="CE">
                            @foreach('{{ $users["chiefEngineers"] }}' as $chiefEngineer)
                            <option value="{{ '{{ $chiefEngineer->id }}' }}">{{ '{{ $chiefEngineer->title }}' }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endcan
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
    
            <table id="assessment-report" class="table table-bordered table-hover">
                <caption class="fs-4 fw-semibold bg-light">{{ '{{ !empty(request()->query("CE")) ? \App\Models\User::findOrFail(request()->query("CE"))->title : "" }}' }}</caption>
                <caption class="fs-4 fw-semibold bg-light">{{ '{{ !empty(request()->query("SE")) ? \App\Models\User::findOrFail(request()->query("SE"))->title : "" }}' }}</caption>
                <caption class="fs-4 fw-semibold bg-light">{{ '{{ !empty(request()->query("XEN")) ? \App\Models\User::findOrFail(request()->query("XEN"))->title : "" }}' }}</caption>
                <thead>
                    <tr class="bg-success bg-opacity-25 text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle" rowspan="2">S#</th>
                        @if('{{ empty(request()->query("CE")) && auth()->user()->designation !== "CE" }}')
                        <th scope="col" class="text-center align-middle" rowspan="2">Chief Engineer</th>
                        @endif
                        <th scope="col" class="text-center align-middle" rowspan="2">District</th>
                        <th scope="colgroup" class="text-center align-middle" colspan="3">
                            Damaged {{ '{{ request()->query("type") ?? "Road" }}' }}s {{ '{{ request()->query("type") == "Road" || !request()->has("type") ? "(KM)" : "(Meter)" }}' }}
                        </th>
                        <th scope="colgroup" class="text-center align-middle" colspan="3">
                            {{ '{{ request()->query("type") ?? "Road" }}' }} Status
                        </th>
                        <th scope="colgroup" class="text-center align-middle" colspan="2">
                            Approximate Cost (Millions)
                        </th>
                    </tr>
                    <tr class="bg-success bg-opacity-10 text-uppercase fw-bold">
                        <th scope="col" class="text-center align-middle">
                            Effected {{ '{{ request()->query("type") ?? "Road" }}' }}s
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
                    @foreach ('{{ $districts }}' as $district)
                    <tr class="align-middle">
                        <td class="text-center fw-medium">{{ '{{ $serial++ }}' }}</td>
                        @if('{{ empty(request()->query("CE")) && auth()->user()->designation !== "CE" }}')
                        <td class="text-center fw-medium">{{ '{{ $district->chiefEngineer }}' }}</td>
                        @endif
                        <td class="text-center fw-medium">{{ '{{ $district->name }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->damaged_infrastructure_count }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->damaged_infrastructure_total_count }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->damaged_infrastructure_sum }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->fully_restored }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->partially_restored }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->not_restored }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->restoration }}' }}</td>
                        <td class="text-center fw-medium">{{ '{{ $district->rehabilitation }}' }}</td>
                    </tr>
                    @endforeach
                    <tr class="bg-light fw-bold">
                        <th class="text-center" rowspan="2">Total</th>
                        @if('{{ empty(request()->query("CE")) && auth()->user()->designation !== "CE" }}')
                        <th class="text-center"></th>
                        @endif
                        <th class="text-center"></th>
                        <th class="text-center">{{ '{{ $total["totalDamagedInfrastructureCount"] }}' }}</th>
                        <th class="text-center">{{ '{{ $total["totalDamagedInfrastructureTotalCount"] }}' }}</th>
                        <th class="text-center">{{ '{{ $total["totalDamagedInfrastructureSum"] }}' }}</th>
                        <th class="text-center">{{ '{{ $total["totalFullyRestored"] }}' }}</th>
                        <th class="text-center">{{ '{{ $total["totalPartiallyRestored"] }}' }}</th>
                        <th class="text-center">{{ '{{ $total["totalNotRestored"] }}' }}</th>
                        <th class="text-center">{{ '{{ $total["totalRestorationCost"] }}' }}</th>
                        <th class="text-center">{{ '{{ $total["totalRehabilitationCost"] }}' }}</th>
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
            const userSelect = $('#load-users');
            
            userSelect.select2({
                theme: "bootstrap-5",
                dropdownParent: $('#load-users').parent(),
                placeholder: "Select User",
                allowClear: true,
                ajax: {
                    url: '{{ route("admin.apps.hr.users.api") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function(data, params) {
                        params.page = params.page || 1;
                        
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    },
                    cache: true
                },
                templateResult: function(user) {
                    if (user.loading) {
                        return 'Loading...';
                    }
                    return user.text;
                },
                templateSelection: function(user) {
                    return user.text || 'Select User';
                }
            });
        });

        $('#print-receipts').on('click', () => {
            $("#receipts-report").printThis({
                pageTitle: "Provincial Own Receipts Report",
                beforePrint() {
                    document.querySelector('.page-loader').classList.remove('hidden');
                },
                afterPrint() {
                    document.querySelector('.page-loader').classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-porms-layout>9