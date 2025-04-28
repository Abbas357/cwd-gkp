<x-machinery-layout title="Machinery Reports">
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
        .machinery-details {
            line-height: 1.6;
        }
        .machinery-details small {
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
            .no-print, .table-container {
                display: none;
            }
            body {
                font-size: 12pt;
            }
            table {
                page-break-inside: avoid;
            }
        }
    </style>
    @endpush
    
    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Machinery Reports</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header bg-light">
                <h3 class="card-title mb-0">Machinery Reports</h3>
            </div>
            <div class="card-body">
                <form method="GET" class="filter-section">
                    <div class="row g-3">

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="includeSubordinates" name="include_subordinates" value="1" @checked(request('include_subordinates'))>
                            <label class="form-check-label fw-bold" for="includeSubordinates">
                                Include Subordinates
                            </label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" 
                                    id="showHistory" name="show_history" value="1" 
                                    @checked(request('show_history'))>
                            <label class="form-check-label fw-bold" for="showHistory">
                                Include Past Allocations
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="load-offices">Office</label>
                            <select name="office_id" id="load-offices" class="form-select" data-placeholder="Select Office">
                                <option value=""></option>
                                @foreach(App\Models\Office::all() as $office)
                                    <option value="{{ $office->id }}" @selected($filters['office_id'] == $office->id)>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Machinery Type</label>
                            <select name="type" class="form-select">
                                <option value="">All Types</option>
                                @foreach(category('machinery_type', 'machinery') as $type)
                                    <option value="{{ $type }}" @selected(request('type') == $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold">Operational Status</label>
                            <select name="operational_status" class="form-select">
                                <option value="">All Status</option>
                                @foreach(category('machinery_operational_status', 'machinery') as $status)
                                    <option value="{{ $status }}" @selected(request('operational_status') == $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Specific Machinery</label>
                            <select name="machinery_id" class="form-select" data-placeholder="Select Machinery">
                                <option value=""></option>
                                @foreach(App\Models\Machinery::all() as $machinery)
                                    <option value="{{ $machinery->id }}" @selected($filters['machinery_id'] == $machinery->id)>
                                        {{ $machinery->type }} - {{ $machinery->model }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <!-- Additional Filters -->
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Power Source</label>
                            <select name="power_source" class="form-select">
                                <option value="">All Power Sources</option>
                                @foreach(category('machinery_power_source', 'machinery') as $source)
                                    <option value="{{ $source }}" @selected($filters['power_source'] == $source)>
                                        {{ $source }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Location</label>
                            <select name="location" class="form-select">
                                <option value="">All Locations</option>
                                @foreach(category('machinery_location', 'machinery') as $location)
                                    <option value="{{ $location }}" @selected($filters['location'] == $location)>
                                        {{ $location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Manufacturer</label>
                            <select name="manufacturer" class="form-select">
                                <option value="">All Manufacturers</option>
                                @foreach(category('machinery_manufacturer', 'machinery') as $manufacturer)
                                    <option value="{{ $manufacturer }}" @selected($filters['manufacturer'] == $manufacturer)>
                                        {{ $manufacturer }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Certification Status</label>
                            <select name="certification_status" class="form-select">
                                <option value="">All Certification Status</option>
                                @foreach(category('machinery_certification_status', 'machinery') as $certification)
                                    <option value="{{ $certification }}" @selected($filters['certification_status'] == $certification)>
                                        {{ $certification }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="cw-btn">
                                <i class="bi-filter me-1"></i> Generate Report
                            </button>
                            <a href="{{ route('admin.apps.machineries.reports') }}" class="btn btn-light">
                                <i class="bi-undo me-1"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-container">
                    <button type="button" id="print-machinery-details" class="no-print btn btn-light float-end me-2 m-2">
                        <span class="d-flex align-items-center">
                            <i class="bi-print"></i>
                            Print
                        </span>
                    </button>
                    <table class="table table-hover mb-0" id="machinery-report">
                        <thead>
                            <tr>
                                <th class="bg-light">Machinery Details</th>
                                <th class="bg-light">Serial Number</th>
                                <th class="bg-light">Allocated To</th>
                                <th class="bg-light">Status</th>
                                <th class="bg-light">Allocation Date</th>
                                @if(request('show_history'))
                                <th class="bg-light">End Date</th>
                                @endif
                                <th class="bg-light no-print">Allocation Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allocations as $allocation)
                                <tr>
                                    <td>
                                        <div class="machinery-details">
                                            <strong>{{ $allocation->machinery->manufacturer }} {{ $allocation->machinery->model }}</strong>
                                            <small>Type: {{ $allocation->machinery->type }}</small>
                                            <small>Power: {{ $allocation->machinery->power_source }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="machinery-details">
                                            <strong>{{ $allocation->machinery->serial_number }}</strong>
                                            <small>Location: {{ $allocation->machinery->location }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $allocation->office->name ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge bg-{{ $allocation->machinery->operational_status === 'Operational' ? 'success' : 'danger' }} text-white">
                                            {{ $allocation->machinery->operational_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ $allocation->start_date ? $allocation->start_date->format('j F, Y') : 'N/A' }}
                                        </span>
                                    </td>
                                    @if(request('show_history'))
                                    <td>
                                        <span class="text-muted">
                                            {{ $allocation->end_date ? $allocation->end_date->format('j F, Y') : 'Current' }}
                                        </span>
                                    </td>
                                    @endif
                                    @if($allocation->hasMedia('machinery_allocation_orders'))
                                    <td class="no-print">
                                        <a href="{{ $allocation->getFirstMediaUrl('machinery_allocation_orders') }}" target="_blank">
                                            <i class="bi-file-earmark-text"></i> View Order
                                        </a>
                                    </td>
                                    @else
                                    <td class="no-print">
                                        <span class="text-muted">Not Available</span>
                                    </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p class="mb-0">No machinery found matching the criteria</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        select2Ajax(
            '#load-offices',
            '{{ route("admin.apps.hr.offices.api") }}',
            {
                placeholder: "Select Office",
                dropdownParent: $('#load-offices').closest('body')
            }
        );            

        $('#print-machinery-details').on('click', () => {
            $("#machinery-report").printThis({
                pageTitle: "Report",
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
</x-machinery-layout>