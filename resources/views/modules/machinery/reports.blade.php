<x-machinery-layout title="Machinery Reports">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        :root {
            --primary-color: #28a745;
            --primary-hover: #1e7e34;
            --secondary-color: #f8f9fa;
            --border-radius: 0.5rem;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            --transition: all 0.3s ease;
            --machinery-accent: #fd7e14;
        }

        .table> :not(caption)>*>* {
            vertical-align: middle;
            padding: 1rem;
        }

        .table th {
            background-color: #e8f5e8;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.6px;
            color: #495057;
            border-bottom: 2px solid #d4edda;
        }

        .machinery-details {
            line-height: 1.7;
        }

        .machinery-details strong {
            font-size: 1.05rem;
            color: #212529;
        }

        .machinery-details small {
            color: #6c757d;
            display: block;
            margin-top: 0.1rem;
            font-size: 0.8rem;
        }

        .status-badge {
            padding: 0.4em 0.8em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 50rem;
            text-transform: capitalize;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: none;
            transition: var(--transition);
        }

        .table-container:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .filter-section {
            background: linear-gradient(145deg, #f8f9fa, #ffffff);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: 1px solid #e9ecef;
        }

        .card {
            border: none;
            box-shadow: var(--card-shadow);
            border-radius: var(--border-radius);
            overflow: hidden;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            background: linear-gradient(to right, #d4edda, #f8f9fa);
            border-bottom: 1px solid #d4edda;
        }

        .card-title {
            font-weight: 700;
            color: #212529;
            margin: 0;
            font-size: 1.4rem;
        }

        .card-body {
            background: linear-gradient(to bottom, #ffffff, #fafbfc);
            padding: 2rem;
        }

        .form-check-input {
            width: 1.2em;
            height: 1.2em;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-switch .form-check-input {
            width: 2.5em;
        }

        .table-hover tbody tr {
            transition: var(--transition);
        }

        .table-hover tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.05);
            transform: scale(1.005);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        tbody tr {
            border-bottom: 1px solid #e9ecef;
        }

        .empty-state {
            padding: 3rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #dee2e6;
            margin-bottom: 1rem;
        }

        .empty-state p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .select2-container--bootstrap-5 .select2-selection {
            border-radius: var(--border-radius);
            padding: 0.3rem 0.5rem;
            border: 1px solid #dee2e6;
            min-height: 42px;
        }

        .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.15);
        }

        .machinery-icon {
            color: var(--machinery-accent);
            font-size: 1.2em;
        }

        .allocation-type-badge {
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 12pt;
            }

            table {
                page-break-inside: avoid;
            }

            .card,
            .table-container {
                box-shadow: none !important;
                border: 1px solid #dee2e6;
            }
        }

    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item active" aria-current="page">Machinery Reports</li>
    </x-slot>

    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-muted mb-0 fs-5">
                            <i class="bi-gear machinery-icon me-2"></i>
                            Filter Options
                        </h4>
                        <button type="button" id="toggleFilters" class="btn btn-sm btn-outline-secondary">
                            <i class="bi-chevron-up" id="filterIcon"></i>
                            <span id="filterText">Hide Filters</span>
                        </button>
                    </div>
                    <hr />
                </div>
            </div>
            <div class="card-body p-1">

                <form method="GET" class="filter-section">
                    <div class="row g-2">

                        <div class="d-flex align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="includeSubordinates" name="include_subordinates" value="1" @checked(request('include_subordinates', false))>
                                <label class="form-check-label" for="includeSubordinates">
                                    Include Subordinate Offices
                                </label>
                            </div>
                            <div class="form-check form-switch ms-3">
                                <input class="form-check-input" type="checkbox" role="switch" id="showHistory" name="show_history" value="1" @checked(request('show_history', false))>
                                <label class="form-check-label" for="showHistory">
                                    Include Past Allocations
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="load-offices">Office</label>
                            <select name="office_id" id="load-offices" class="form-select" data-placeholder="Select Office">
                                @foreach(App\Models\Office::all() as $office)
                                    <option value="{{ $office->id }}" @selected(($filters['office_id'] ?? null) == $office->id)>
                                        {{ $office->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="allocation_status">
                                Allocation Status
                            </label>
                            <select name="allocation_status" id="allocation_status" class="form-select">
                                <option value="">All Allocation Types</option>
                                @foreach($cat['allocation_status'] ?? [] as $allocation_status)
                                <option value="{{ $allocation_status }}" @selected(request('allocation_status')==$allocation_status)>
                                    {{ $allocation_status }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="machinery_type">
                                Machinery Type
                            </label>
                            <select name="type" id="machinery_type" class="form-select">
                                <option value="">All Types</option>
                                @foreach($cat['machinery_types'] ?? [] as $type)
                                <option value="{{ $type }}" @selected(request('type')==$type)>
                                    {{ $type }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="functional_status">
                                Functional Status
                            </label>
                            <select name="functional_status" id="functional_status" class="form-select">
                                <option value="">All Status</option>
                                @foreach($cat['statuses'] ?? [] as $status)
                                <option value="{{ $status }}" @selected(request('functional_status')==$status)>
                                    {{ ucfirst($status) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="brand">
                                Brand
                            </label>
                            <select name="brand" id="brand" class="form-select">
                                <option value="">All Brands</option>
                                @foreach($cat['machinery_brands'] ?? [] as $brand)
                                <option value="{{ $brand }}" @selected(request('brand')==$brand)>
                                    {{ $brand }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="model">
                                Model
                            </label>
                            <select name="model" id="model" class="form-select">
                                <option value="">All Models</option>
                                @foreach($cat['machinery_models'] ?? [] as $model)
                                <option value="{{ $model }}" @selected(request('model')==$model)>
                                    {{ $model }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="machinery_id">
                                Specific Machinery
                            </label>
                            <select name="machinery_id" id="machinery_id" class="form-select" data-placeholder="Select Machinery">
                                <option value=""></option>
                                @php
                                $machineries = [];
                                try {
                                $machineries = App\Models\Machinery::all();
                                } catch (\Exception $e) {

                                }
                                @endphp
                                @foreach($machineries as $machinery)
                                <option value="{{ $machinery->id ?? '' }}" @selected(($filters['machinery_id'] ?? null)==($machinery->id ?? ''))>
                                    {{ $machinery->type ?? 'Unknown Type' }} - {{ $machinery->model ?? 'Unknown Model' }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="registration_number">
                                Registration Number
                            </label>
                            <input type="text" id="registration_number" name="registration_number" class="form-control" placeholder="Enter registration number" value="{{ request('registration_number') ?? '' }}">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label" for="engine_number">
                                Engine Number
                            </label>
                            <input type="text" id="engine_number" name="engine_number" class="form-control" placeholder="Enter engine number" value="{{ request('engine_number') ?? '' }}">
                        </div>

                        <div class="col-12">
                            <hr class="">
                            <div class="action-buttons">
                                <button type="submit" class="cw-btn">
                                    <i class="bi-filter me-2"></i> GENERATE REPORT
                                </button>
                                <a href="{{ route('admin.apps.machineries.reports') }}" class="btn btn-sm px-3 border fs-6 py-1 btn-light">
                                    <i class="bi-arrow-counterclockwise me-2"></i> RESET FILTERS
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="table-container p-3">
                    <div class="d-flex justify-content-between align-items-center p-2 bg-light border-bottom">
                        <h5 class="m-0 fw-bold">
                            <i class="bi-gear machinery-icon me-2"></i>
                            Machinery Allocation Results
                        </h5>
                        <button type="button" id="print-machinery-details" class="no-print btn btn-primary btn-sm">
                            <span class="d-flex align-items-center">
                                <i class="bi-printer me-2"></i>
                                Print Report
                            </span>
                        </button>
                    </div>

                    <div class="d-flex p-4 justify-content-between align-items-center">
                        <div class="pagination-info">
                            @if(isset($totalCount))
                            <span class="badge bg-success rounded-pill fs-6">
                                {{ $totalCount }} {{ Str::plural('result', $totalCount) }} found
                            </span>
                            @endif
                        </div>

                        <div class="d-flex align-items-center">
                            <span class="me-2">Display:</span>
                            <select id="per-page-selector" class="form-select form-select-sm" style="width: auto;">
                                @foreach($paginationOptions ?? [10 => '10 per page', 25 => '25 per page', 50 => '50 per page', 'all' => 'Show All'] as $value => $label)
                                <option value="{{ $value }}" @selected(($perPage ?? 10)==$value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <table class="table table-hover mb-0" id="machinery-report">
                        <thead>
                            <tr>
                                <th class="bg-light">Machinery Details</th>
                                <th class="bg-light">Identification</th>
                                <th class="bg-light">Allocated To</th>
                                <th class="bg-light">Status</th>
                                <th class="bg-light">Allocation Date</th>
                                @if(request('show_history', false))
                                <th class="bg-light">End Date</th>
                                @endif
                                <th class="bg-light">Duration</th>
                                <th class="bg-light no-print">Documents</th>
                                <th class="bg-light no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allocations ?? [] as $allocation)
                            <tr>
                                <td>
                                    <div class="machinery-details">
                                        <strong>{{ $allocation?->machinery?->brand ?? 'Unknown Brand' }} {{ $allocation?->machinery?->model ?? 'Unknown Model' }}</strong>
                                        <small>Type: {{ $allocation?->machinery?->type ?? 'Unspecified' }}</small>
                                        <small>Brand: {{ $allocation?->machinery?->brand ?? 'Unspecified' }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="machinery-details">
                                        <strong>Registration No: {{ $allocation?->machinery?->registration_number ?? 'Unregistered' }}</strong>
                                        <small>EngineNumber: {{ $allocation?->machinery?->engine_number ?? 'Not Available' }}</small>
                                    </div>
                                </td>
                                <td>

                                    <div class="machinery-details">
                                        <div class="d-flex align-items-center mb-1">
                                            <span class="allocation-type-badge badge bg-warning text-dark">Office Pool</span>
                                        </div>
                                        <strong>{{ $allocation->office->name ?? 'Unknown Office' }}</strong>
                                        <small>Pool Machinery Assignment</small>
                                    </div>
                                </td>
                                <td>
                                    @php
                                    $status = $allocation?->machinery?->functional_status ?? 'Unknown';
                                    $statusClass = match($status) {
                                    'functional' => 'success',
                                    'condemned' => 'danger',
                                    'repairable' => 'warning',
                                    default => 'secondary'
                                    };
                                    @endphp
                                    <span class="status-badge bg-{{ $statusClass }} text-white">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        @php
                                        $startDate = null;
                                        try {
                                        $startDate = $allocation?->start_date?->format('j F, Y');
                                        } catch (\Exception $e) {
                                        $startDate = 'Not Specified';
                                        }
                                        @endphp
                                        {{ $startDate }}
                                    </span>
                                </td>
                                @if(request('show_history', false))
                                <td>
                                    <span class="text-muted">
                                        @php
                                        $endDate = 'Current';
                                        try {
                                        if(!empty($allocation->end_date)) {
                                        $endDate = $allocation?->end_date?->format('j F, Y');
                                        }
                                        } catch (\Exception $e) {

                                        }
                                        @endphp
                                        {{ $endDate }}
                                    </span>
                                </td>
                                @endif
                                <td>
                                    <span class="text-muted">
                                        @php
                                        try {
                                        $duration = formatDuration($allocation->start_date, $allocation->end_date ?? null);
                                        } catch (\Exception $e) {
                                        $duration = 'Not Available';
                                        }
                                        @endphp
                                        {{ $duration }}
                                    </span>
                                </td>
                                <td class="no-print">
                                    @if(method_exists($allocation, 'hasMedia') && $allocation->hasMedia('machinery_allocation_orders'))
                                    <a href="{{ $allocation->getFirstMediaUrl('machinery_allocation_orders') }}" class="btn btn-sm btn-outline-success" target="_blank">
                                        <i class="bi-file-earmark-text me-1"></i> View Order
                                    </a>
                                    @else
                                    <span class="badge bg-light text-secondary">Not Available</span>
                                    @endif
                                </td>
                                <td class="no-print text-center">
                                    <button type="button" class="btn btn-sm btn-light details-btn" data-id="{{ $allocation->machinery_id }}">
                                        <i class="bi-eye me-1"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ request('show_history', false) ? 9 : 8 }}" class="empty-state">
                                    <i class="bi-gear"></i>
                                    <p>No machinery found matching the criteria</p>
                                    <a href="{{ route('admin.apps.machineries.reports') }}" class="btn btn-sm btn-outline-success mt-2">
                                        RESET FILTERS
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="pagination-wrapper p-3 border-top d-flex justify-content-between align-items-center">
                        <div class="pagination-info">
                            @if(isset($allocations) && !($perPage === 'all') && $allocations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            <span class="text-muted">
                                Showing {{ $allocations->firstItem() ?? 0 }} to {{ $allocations->lastItem() ?? 0 }} of {{ $allocations->total() ?? 0 }} entries
                            </span>
                            @endif
                        </div>

                        <div class="pagination-links">
                            @if(isset($allocations) && !($perPage === 'all') && $allocations instanceof \Illuminate\Pagination\LengthAwarePaginator)
                            {{ $allocations->links('pagination::bootstrap-4') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script>
    <script>
        pushStateModal({
            fetchUrl: "{{ route('admin.apps.machineries.details', ':id') }}"
            , btnSelector: '.details-btn'
            , title: 'Machinery Details'
            , modalSize: 'xl'
            , hash: false
        , });

        $(document).ready(function() {
            initFilterToggle();
            initPagination();
            initFormControls();
            initExportButtons();
            initAnimations();
        });

        function initFilterToggle() {
            const urlParams = new URLSearchParams(window.location.search);
            const hasRelevantParams = Array.from(urlParams.keys()).some(key =>
                key !== 'page' && key !== 'per_page'
            );

            if (hasRelevantParams) {
                $('.filter-section').hide();
                $('#filterIcon').removeClass('bi-chevron-up').addClass('bi-chevron-down');
                $('#filterText').text('Show Filters');
            }

            $('#toggleFilters').on('click', function() {
                $('.filter-section').slideToggle(300);

                if ($('#filterIcon').hasClass('bi-chevron-up')) {
                    $('#filterIcon').removeClass('bi-chevron-up').addClass('bi-chevron-down');
                    $('#filterText').text('Show Filters');
                } else {
                    $('#filterIcon').removeClass('bi-chevron-down').addClass('bi-chevron-up');
                    $('#filterText').text('Hide Filters');
                }
            });
        }

        function initPagination() {
            $('#per-page-selector').on('change', function() {
                const url = new URL(window.location.href);
                url.searchParams.set('per_page', $(this).val());
                window.location.href = url.toString();
            });

            $('.pagination .page-link').hover(
                function() {
                    $(this).addClass('bg-light');
                }
                , function() {
                    $(this).removeClass('bg-light');
                }
            );
        }

        function initFormControls() {
            $('.form-control, .form-select').on('focus', function() {
                $(this).parent().find('.form-label').addClass('text-primary');
            }).on('blur', function() {
                $(this).parent().find('.form-label').removeClass('text-primary');
            });
        }

        select2Ajax(
            '#load-offices'
            , '{{ route("admin.apps.hr.offices.api") }}', {
                placeholder: "Select Office"
                , dropdownParent: $('#load-offices').closest('body')
            }
        );

        select2Ajax(
            '#load-machineries'
            , '{{ route("admin.apps.machineries.search") }}', {
                placeholder: "Select Selec Mahinery"
                , dropdownParent: $('#load-machineries').closest('body')
            }
        );

        function initExportButtons() {
            $('#print-machinery-details').on('click', handlePrintReport);
            addExcelExportButton();
        }

        function handlePrintReport() {
            Swal.fire({
                title: 'Preparing Print View'
                , text: 'Please wait...'
                , allowOutsideClick: false
                , didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                $("#machinery-report").printThis({
                    pageTitle: "Machinery Report - " + new Date().toLocaleDateString()
                    , importCSS: true
                    , importStyle: true
                    , header: "<h1 class='text-center mb-4'>Machinery Allocation Report</h1>" +
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
        }

        function addExcelExportButton() {
            const printButton = document.getElementById('print-machinery-details');
            if (printButton) {
                const exportButton = document.createElement('button');
                exportButton.type = 'button';
                exportButton.id = 'export-excel';
                exportButton.className = 'no-print btn btn-success btn-sm ms-2';
                exportButton.innerHTML = '<span class="d-flex align-items-center"><i class="bi-file-excel me-2"></i>Export to Excel</span>';
                printButton.parentNode.appendChild(exportButton);
                document.getElementById('export-excel').addEventListener('click', handleExcelExport);
            }
        }

        function handleExcelExport() {
            Swal.fire({
                title: 'Preparing Excel Export'
                , text: 'Please wait...'
                , allowOutsideClick: false
                , didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                try {
                    const wsData = extractTableData();
                    generateSecureExcelFile(wsData);

                    Swal.fire({
                        icon: 'success'
                        , title: 'Export Successful'
                        , text: 'Your Excel file has been downloaded'
                        , timer: 2000
                        , showConfirmButton: false
                    });
                } catch (error) {
                    console.error('Export error:', error);
                    Swal.fire({
                        icon: 'error'
                        , title: 'Export Failed'
                        , text: 'There was an error exporting to Excel. Please try again.'
                    });
                }
            }, 500);
        }

        function extractTableData() {
            const table = document.getElementById('machinery-report');
            const wsData = [];

            const headerRow = table.querySelector('thead tr');
            const headers = [];
            headerRow.querySelectorAll('th').forEach(th => {
                if (!th.classList.contains('no-print')) {
                    headers.push(th.textContent.trim());
                }
            });
            wsData.push(headers);

            table.querySelectorAll('tbody tr').forEach(tr => {
                const rowData = [];
                tr.querySelectorAll('td').forEach(td => {
                    if (!td.classList.contains('no-print')) {
                        let content = td.textContent.replace(/\s+/g, ' ').trim();
                        rowData.push(content);
                    }
                });

                if (rowData.length > 0 && !tr.querySelector('.empty-state')) {
                    wsData.push(rowData);
                }
            });

            return wsData;
        }

        function generateSecureExcelFile(wsData) {
            const wb = XLSX.utils.book_new();
            const ws = XLSX.utils.aoa_to_sheet(wsData);

            const colWidths = [{
                    wch: 30
                }, // Machinery Details
                {
                    wch: 25
                }, // Identification
                {
                    wch: 35
                }, // Allocated To
                {
                    wch: 15
                }, // Status
                {
                    wch: 15
                }, // Allocation Date
                {
                    wch: 15
                }, // End Date (if shown)
                {
                    wch: 15
                } // Duration
            ];

            ws['!cols'] = colWidths;

            const headerRange = XLSX.utils.decode_range(ws['!ref']);
            for (let C = headerRange.s.c; C <= headerRange.e.c; ++C) {
                const cellRef = XLSX.utils.encode_cell({
                    r: 0
                    , c: C
                });
                if (!ws[cellRef]) continue;

                ws[cellRef].s = {
                    font: {
                        bold: true
                        , sz: 14
                    }
                    , fill: {
                        fgColor: {
                            rgb: "E9ECEF"
                        }
                    }
                    , alignment: {
                        horizontal: "center"
                        , vertical: "center"
                    }
                };
            }

            ws['!rows'] = [];
            ws['!rows'][0] = {
                hpt: 30
            };

            XLSX.utils.book_append_sheet(wb, ws, 'Machinery Report');

            const date = new Date();
            const dateStr = date.toISOString().split('T')[0];
            const fileName = `Machinery_Report_${dateStr}.xlsx`;

            if (typeof saveAs === 'function') {
                const wopts = {
                    bookType: 'xlsx'
                    , bookSST: false
                    , type: 'array'
                };
                const wbout = XLSX.write(wb, wopts);

                const blob = new Blob([wbout], {
                    type: 'application/octet-stream'
                });
                saveAs(blob, fileName);
            } else {
                XLSX.writeFile(wb, fileName, {
                    type: 'base64'
                    , bookType: 'xlsx'
                    , Props: {
                        Title: "Machinery Report"
                        , Subject: "Machinery Allocation Report"
                        , Author: "Machinery Management System"
                    }
                });
            }
        }

        function initAnimations() {
            $('.card').addClass('animate__animated animate__fadeIn');
            $('.filter-section').addClass('animate__animated animate__fadeIn');
            $('.table-container').addClass('animate__animated animate__fadeIn');
        }

        // Additional machinery-specific functions
        function initMachinerySpecificFeatures() {
            // Handle machinery type filtering
            $('#machinery_type').on('change', function() {
                const selectedType = $(this).val();
                filterMachineryByType(selectedType);
            });

            // Handle functional status color coding
            $('.status-badge').each(function() {
                const status = $(this).text().toLowerCase().trim();
                $(this).addClass(getStatusClass(status));
            });

            // Initialize machinery tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        }

        function filterMachineryByType(type) {
            if (!type) return;

            // Update brand and model options based on selected type
            $.ajax({
                url: '{{ route("admin.apps.machineries.filter-options") ?? "#" }}'
                , method: 'GET'
                , data: {
                    type: type
                }
                , success: function(response) {
                    updateSelectOptions('#brand', response.brands || []);
                    updateSelectOptions('#model', response.models || []);
                }
                , error: function() {
                    console.log('Error fetching filter options');
                }
            });
        }

        function updateSelectOptions(selector, options) {
            const select = $(selector);
            const currentValue = select.val();

            select.empty();
            select.append('<option value="">All ' + selector.replace('#', '').charAt(0).toUpperCase() + selector.replace('#', '').slice(1) + 's</option>');

            options.forEach(function(option) {
                select.append('<option value="' + option + '">' + option + '</option>');
            });

            if (options.includes(currentValue)) {
                select.val(currentValue);
            }

            select.trigger('change');
        }

        function getStatusClass(status) {
            const statusClasses = {
                'functional': 'bg-success'
                , 'condemned': 'bg-danger'
                , 'repairable': 'bg-warning'
                , 'under_maintenance': 'bg-info'
                , 'unknown': 'bg-secondary'
            };

            return statusClasses[status] || 'bg-secondary';
        }

        // Initialize machinery-specific features when document is ready
        $(document).ready(function() {
            initMachinerySpecificFeatures();
        });

    </script>
    @endpush
</x-machinery-layout>
