<x-dmis-layout title="Damages Report">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        .table > :not(caption) > * > * {
            vertical-align: middle;
        }

        .table {
            border: 1px solid #999999AA;
        }

        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
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

        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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

        .officer-cell,
        .district-cell {
            background-color: #f8f9fa;
        }

        .officer-name {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .officer-office,
        .district-name {
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

        .no-damage {
            color: #6c757d;
            font-style: italic;
        }

        .officers-list {
            max-height: 80px;
            overflow-y: auto;
            font-size: 0.85rem;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .btn-detail {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            border-radius: 0.25rem;
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
                <form method="get" class="row" id="report-form">
                    <div class="col-md-3">
                        <label class="form-label" for="type">Report Type</label>
                        <select name="report_type" id="report_type" class="form-control" placeholder="Select report_type">
                            @can('viewMainReport', App\Models\Damage::class)
                            <option value="Summary" {{ request()->query('report_type') == 'Summary' ? 'selected' : '' }}>Summary</option>
                            @endcan
                            @can('viewSituationReport', App\Models\Damage::class)
                            <option value="Daily Situation" {{ request()->query('report_type') == 'Daily Situation' ? 'selected' : '' }}>Daily Situation</option>
                            @endcan
                            @can('viewDistrictWiseReport', App\Models\Damage::class)
                            <option value="District Wise" {{ request()->query('report_type') == 'District Wise' ? 'selected' : '' }}>District Wise</option>
                            @endcan
                        </select>
                    </div>
                    <div class="col-md-3 report-date-field">
                        <label class="form-label" for="report_date">Report Date</label>
                        <input type="date" name="report_date" id="report_date" class="form-control" value="{{ request()->query('report_date') ?? now()->format('Y-m-d') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="type">Infrastructure Type</label>
                        <select name="type" id="type" class="form-control" placeholder="Select Type">
                            @foreach(setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']) as $infrastructure_type)
                            <option value="{{ $infrastructure_type }}" {{ request()->query('type') == $infrastructure_type ? 'selected' : '' }}>
                                {{ $infrastructure_type }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 load-users-field">
                        <label class="form-label" for="load-users">Officer</label>
                        <select name="user_id" id="load-users" class="form-select" data-placeholder="Select Officer">
                            <option value="">Select Officer</option>
                            @foreach(App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" @selected((request()->query('user_id') ?? null) == $user->id)>
                                {{ $user->name }} ({{ $user->currentDesignation?->name ?? 'No Designation' }} - {{ $user->currentOffice?->name ?? 'Office Not Assigned' }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-between p-3">
                        <div>
                            <button type="button" id="generate-report" class="cw-btn success">
                                <i class="bi-filter me-2"></i> GENERATE REPORT
                            </button>
                            <a href="{{ route('admin.apps.dmis.reports.index') }}" class="cw-btn light ms-3">
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

        <div class="table-responsive" id="main-report">
            <div class="alert alert-info" role="alert">
                <i class="bi-info-circle me-2"></i>
                Please select your criteria and click "Generate Report" to view the damage assessment data.
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
    <script>
        const $reportType   = $('#report_type');
        const $dateField    = $('.report-date-field');
        const $usersField   = $('.load-users-field');
        const $infraField   = $('#type').closest('.col-md-3');

        function toggleFields() {
        const val = $reportType.val();

        // always show infra
        $infraField.show();

        if (val === 'Summary') {
            $dateField.hide();
            $usersField.show();
        }
        else if (val === 'Daily Situation') {
            $dateField.show();
            $usersField.show();
        }
        else if (val === 'District Wise') {
            $dateField.hide();
            $usersField.hide();
        }
        }

        // initialize on load
        toggleFields();

        // re‑toggle on select change
        $reportType.on('change', toggleFields);

        $(document).ready(function() {
            loadMainReport();

            $('#generate-report').on('click', function(e) {
                e.preventDefault();
                loadMainReport();
            });

            async function loadMainReport() {
                try {
                    $('#main-report').html(`
                        <x-table-skeleton 
                            :rows="6" 
                            :columns="7" 
                            loading-text="Generating report, please wait..."
                        />
                    `);

                    const reportType = $('#report_type').val() || "Summary";
                    const type = $('#type').val() || "Road";
                    const userId = $('#load-users').val() || 4;
                    const reportDate = $('#report_date').val();

                    const url = "{{ route('admin.apps.dmis.reports.loadReport') }}";

                    const response = await fetch(url, {
                        method: 'POST'
                        , headers: {
                            'Content-Type': 'application/json'
                            , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            , 'Accept': 'application/json'
                        }
                        , body: JSON.stringify({
                            'report_type': reportType,
                            'type': type,
                            'user_id': userId,
                            'report_date': reportDate
                        })
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    if (data.success && data.data && data.data.result) {
                        $('#main-report').html(data.data.result);
                    } else {
                        $('#main-report').html(
                            '<div class="alert alert-warning" role="alert">' +
                            '<i class="bi-exclamation-triangle me-2"></i>' +
                            'No data available for the selected criteria.' +
                            '</div>'
                        );
                    }
                } catch (error) {
                    console.error('Error loading report:', error);
                    $('#main-report').html(
                        '<div class="alert alert-danger" role="alert">' +
                        '<i class="bi-exclamation-circle me-2"></i>' +
                        'Error loading report: ' + error.message +
                        '</div>'
                    );
                }
            }

            select2Ajax(
                '#load-users'
                , '{{ route("admin.apps.hr.users.api") }}', {
                    placeholder: "Select Officer"
                    , dropdownParent: $('#load-users').closest('body')
                }
            );

            $('#print-report').on('click', () => {
                $("#generated-report").printThis({
                    beforePrint() {
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
</x-dmis-layout>
