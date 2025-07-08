<x-main-layout title="District Wise Damages {{ setting('activity', 'dmis') }} {{ setting('session', 'dmis') }}">

    <x-slot name="breadcrumbTitle">District Wise Damages {{ setting('activity', 'dmis') }}
        ({{ setting('session', 'dmis') }})</x-slot>
    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Damages</li>
    </x-slot>

    @push('style')
        <style>
            .district-wise {
                font-family: Tahoma, Courier, monospace;
            }
            
            .table> :not(caption)>*>* {
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

            .table caption {
                caption-side: top;
                display: none;
                text-align: center;
                padding: 15px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                font-weight: bold;
                font-size: 1.1rem;
                border-radius: 8px 8px 0 0;
                margin-bottom: 0;
            }

            .table-hover tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05);
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .table-container {
                border-radius: 0.5rem;
                overflow: hidden;
                margin-bottom: 2rem;
            }

            .filter-section {
                background: #F5F5F5;
                padding: 1rem;
                border-radius: 0.3rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border: 1px solid #ccc
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

                .filter-section {
                    display: none !important;
                }

                .table-container {
                    box-shadow: none;
                }

                .table caption {
                    color: #000 !important;
                    background: #f8f9fa !important;
                    border: 1px solid #000;
                }
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

            .no-damage {
                color: #6c757d;
                font-style: italic;
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

            .date-fields {
                display: none;
            }

            .date-fields.show {
                display: block;
            }

            .form-control {
                border: 1px solid #ced4da;
                border-radius: 0.375rem;
                padding: 0.5rem 0.75rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .form-control:focus {
                border-color: #86b7fe;
                box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            }

            .form-label {
                margin-bottom: 0.5rem;
                font-weight: 500;
            }
        </style>
    @endpush

    <div class="container district-wise mt-4">
        <div class="col-md-12">
            <div class="filter-section mb-3">
                @php
                    $activity = setting('activity', 'dmis');
                @endphp
                <form method="GET" action="{{ route($activity . '.index') }}" class="row g-3 p-2" id="filterForm">
                    <div class="col-md-3">
                        <label class="form-label" for="type">Infrastructure Type</label>
                        <select name="type" id="type" class="form-control">
                            @foreach (setting('infrastructure_type', 'dmis', ['Road', 'Bridge', 'Culvert']) as $infrastructure_type)
                                <option value="{{ $infrastructure_type }}"
                                    {{ request()->query('type') == $infrastructure_type ? 'selected' : '' }}>
                                    {{ $infrastructure_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="duration">Report Duration</label>
                        <select name="duration" id="duration" class="form-control">
                            <option value="">Select Duration</option>
                            <option value="90" {{ request()->query('duration') == '90' ? 'selected' : '' }}>Last 90
                                days</option>
                            <option value="45" {{ request()->query('duration') == '45' ? 'selected' : '' }}>Last 45
                                days</option>
                            <option value="30"
                                {{ request()->query('duration') == '30' ? 'selected' : '' }}>
                                Last 30 days</option>
                            <option value="15" {{ request()->query('duration') == '15' ? 'selected' : '' }}>Last 15
                                days</option>
                            <option value="Custom" {{ request()->query('duration') == 'Custom' ? 'selected' : '' }}>
                                Custom</option>
                        </select>
                    </div>

                    <div class="col-md-3 date-fields" id="start-date-field">
                        <label class="form-label" for="start_date">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control"
                            value="{{ request()->query('start_date') }}">
                    </div>

                    <div class="col-md-3 date-fields" id="end-date-field">
                        <label class="form-label" for="end_date">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="form-control"
                            value="{{ request()->query('end_date') }}">
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="cw-btn success">
                                    <i class="bi-filter me-2"></i> FILTER
                                </button>
                                <a href="{{ route($activity . '.index') }}" class="cw-btn bg-secondary ms-3">
                                    <i class="bi-arrow-counterclockwise me-1"></i>
                                </a>
                            </div>
                            <div>
                                <button type="button" id="print-report" class="cw-btn bg-dark">
                                    <i class="bi-printer me-1"></i> PRINT
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <div class="table-container" id="generated-report">
                <div class="text-center mb-2">
                    <h5 class="mb-0">
                        District Wise <span
                            class="px-2 py-1 bg-light shadow-sm rounded border text-dark">{{ $type ?? 'Road' }}s</span>
                        Damage Report
                    </h5>
                    @if (isset($parsedStartDate) && isset($parsedEndDate))
                        @if ($parsedStartDate->format('Y-m-d') === $parsedEndDate->format('Y-m-d'))
                            <div class="text-dark mt-1">Date: {{ $parsedStartDate->format('F d, Y (l)') }}</div>
                        @else
                            <div class="text-dark mt-1">From {{ $parsedStartDate->format('F d, Y') }} to
                                {{ $parsedEndDate->format('F d, Y') }}</div>
                        @endif
                    @else
                        <div class="text-dark mt-1">Dated: {{ now()->format('F d, Y (l)') }}</div>
                    @endif
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="bg-success text-white text-uppercase fw-bold">
                            <th scope="col" class="text-center align-middle">Rank</th>
                            <th scope="col" class="text-center align-middle">District</th>
                            <th scope="col" class="text-center align-middle">Damaged {{ $type ?? 'Road' }}s</th>
                            <th scope="col" class="text-center align-middle">Damage Reports</th>
                            <th scope="col" class="text-center align-middle">Damaged Length
                                {{ $type === 'Road' ? '(KM)' : '(Meter)' }}</th>
                            <th scope="col" class="text-center align-middle">Fully Restored</th>
                            <th scope="col" class="text-center align-middle">Partially Restored</th>
                            <th scope="col" class="text-center align-middle">Not Restored</th>
                            <th scope="col" class="text-center align-middle">Restoration Cost(M)</th>
                            <th scope="col" class="text-center align-middle">Rehabilitation Cost(M)</th>
                            <th scope="col" class="text-center align-middle">Total Cost(M)</th>
                            <th scope="col" class="text-center align-middle no-print px-3">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($districtStats as $index => $stats)
                            <tr class="align-middle">
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td class="district-cell">
                                    <div class="district-name">{{ $stats['district']->name }}</div>
                                </td>
                                <td class="text-center">
                                    @if ($stats['damaged_infrastructure_count'] > 0)
                                        {{ $stats['damaged_infrastructure_count'] }}
                                    @else
                                        <span class="no-damage">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($stats['damage_count'] > 0)
                                        {{ $stats['damage_count'] }}
                                    @else
                                        <span class="no-damage">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($stats['damaged_length'] > 0)
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
                                <td class="text-center no-print">
                                    <div class="action-buttons d-flex justify-content-center align-items-center">
                                        @php
                                            $detailUrl = route($activity . '.detail.district', ['district' => $stats['district']->name]);
                                            $queryParams = [];
                                            if (request()->query('type')) $queryParams['type'] = request()->query('type');
                                            if (request()->query('duration')) $queryParams['duration'] = request()->query('duration');
                                            if (request()->query('start_date')) $queryParams['start_date'] = request()->query('start_date');
                                            if (request()->query('end_date')) $queryParams['end_date'] = request()->query('end_date');
                                            $detailUrl .= '?' . http_build_query($queryParams);
                                        @endphp
                                        <a href="{{ $detailUrl }}" class="btn btn-white border-secondary btn-detail" title="View Details">
                                            <i class="bi-eye-fill fs-5"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        <tr class="fw-bold total-row">
                            <td colspan="2" class="text-end">Total:</td>
                            <td class="text-center">{{ $total['total_damaged_infrastructure_count'] }}</td>
                            <td class="text-center">{{ $total['total_damage_count'] }}</td>
                            <td class="text-center">{{ number_format($total['total_damaged_length'], 2) }}</td>
                            <td class="text-center">{{ $total['total_fully_restored'] }}</td>
                            <td class="text-center">{{ $total['total_partially_restored'] }}</td>
                            <td class="text-center">{{ $total['total_not_restored'] }}</td>
                            <td class="text-center">{{ number_format($total['total_restoration_cost'], 2) }}</td>
                            <td class="text-center">{{ number_format($total['total_rehabilitation_cost'], 2) }}</td>
                            <td class="text-center">{{ number_format($total['total_cost'], 2) }}</td>
                            <td class="text-center no-print">-</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="13" class="text-center">
                                <small class="text-muted" style="font-size: .7rem;">
                                    This is a system-generated report from Damage Management Information System (DMIS),
                                    C&W Department. All efforts have been made to ensure accuracy; however, errors and
                                    omissions are excepted.
                                </small>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if ($districtStats->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="bi-info-circle me-2"></i>
                    @if (request()->query('duration'))
                        No data available for the selected criteria and time period.
                    @else
                        No damage data available in the system.
                    @endif
                </div>
            @endif
        </div>
    </div>

    @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script>
            function toggleDateFields() {
                const duration = document.getElementById('duration').value;
                const dateFields = document.querySelectorAll('.date-fields');

                if (duration === 'Custom') {
                    dateFields.forEach(field => {
                        field.style.display = 'block';
                    });
                } else {
                    dateFields.forEach(field => {
                        field.style.display = 'none';
                    });
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                toggleDateFields();

                $('#print-report').on('click', () => {
                    if (window.Pace && Pace.restart) {
                        Pace.restart();
                    }

                    $("#generated-report").printThis({
                        afterPrint() {
                            if (window.Pace && Pace.stop) {
                                Pace.stop();
                            }
                        },
                    });
                });
            });

            document.getElementById('duration').addEventListener('change', toggleDateFields);
        </script>
    @endpush

</x-main-layout>