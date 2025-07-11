<x-main-layout title="District Damage Details - {{ $district->name }}">
    <x-slot name="breadcrumbTitle">{{ $district->name }} Detail {{ setting('activity', 'dmis') }}
        ({{ setting('session', 'dmis') }})</x-slot>
    <x-slot name="breadcrumbItems"></x-slot>
    @push('style')
        <style>
            #district-report {
                font-family: Tahoma, Courier, monospace;
            }

            .damage-table {
                width: 100%;
                border-collapse: collapse;
                background: #ffffff;
                border: 1px solid #ddd;
            }

            .damage-table th,
            .damage-table td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
                vertical-align: top;
            }

            .damage-table th {
                background: #F5F5F5;
                font-weight: 600;
            }

            .damage-table tbody tr:nth-child(even) {
                background-color: #fff;
            }

            .infrastructure-row {
                background: #fff !important;
            }

            .status-badge {
                padding: 4px 8px;
                font-size: 12px;
                border-radius: 3px;
                border: 1px solid #ccc;
                background: #f8f8f8;
                white-space: nowrap;
            }

            .summary-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .summary-card {
                background: #ffffff;
                border: 1px solid #ddd;
                padding: 1.5rem;
                text-align: center;
            }

            .summary-number {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .summary-label {
                font-size: 0.9rem;
                color: #666;
            }

            .officer-info {
                background: #f8f8f8;
                padding: 1rem;
                border: 1px solid #ddd;
                margin: 0.5rem;
                display: inline-block;
            }

            /* Print Styles */
            @media print {

                .damage-table th,
                .damage-table td {
                    border: 1px solid #000 !important;
                    padding: 6px !important;
                    font-size: 10px !important;
                }

                .damage-table th {
                    background: #f0f0f0 !important;
                    color: #000 !important;
                }

                .infrastructure-row td {
                    background: #fff !important;
                    color: #000 !important;
                    font-weight: bold !important;
                }

                .damage-sub-row td {
                    background: #fff !important;
                    color: #000 !important;
                }

                .status-badge {
                    background: white !important;
                    color: #000 !important;
                    border: 1px solid #000 !important;
                }

                .summary-card {
                    border: 1px solid #000 !important;
                    background: white !important;
                }
            }
        </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.dashboard') }}">DMIS</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $district->name }} Details</li>
    </x-slot>

    <div class="container">
        <div id="district-report" class="py-2 px-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <div class="text-muted">
                        <span class="badge border border-primary text-primary bg-transparent fs-6 px-2 py-1">Report Date:
                            <strong>{{ now()->format('F d, Y') }}</strong></span>
                        <span class="badge border border-success text-success bg-transparent  fs-6 px-2 py-1">Infrastructure Type:
                            <strong>{{ $type }}</strong></span>
                        <span class="badge border border-danger text-danger bg-transparent  fs-6 px-2 py-1">Total Damages:
                            <strong>{{ $stats['total_damages'] }}</strong></span>
                    </div>
                </div>
                <div class="no-print">
                    <button type="button" id="print-report" class="cw-btn bg-dark">
                        <i class="bi-printer me-1"></i> Print
                    </button>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-number">{{ $stats['unique_infrastructures'] }}</div>
                    <div class="summary-label">Affected Infrastructures</div>
                </div>
                <div class="summary-card">
                    <div class="summary-number">{{ $stats['total_damages'] }}</div>
                    <div class="summary-label">Total Damages</div>
                </div>
                <div class="summary-card">
                    <div class="summary-number">{{ $stats['total_damaged_length'] }}</div>
                    <div class="summary-label">Damaged Length
                        {{ request()->query('type') == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}</div>
                </div>
                <div class="summary-card">
                    <div class="summary-number">{{ $stats['fully_restored'] }}</div>
                    <div class="summary-label">Fully Restored</div>
                </div>
                <div class="summary-card">
                    <div class="summary-number">{{ $stats['partially_restored'] }}</div>
                    <div class="summary-label">Partially Restored</div>
                </div>
                <div class="summary-card">
                    <div class="summary-number">{{ $stats['not_restored'] }}</div>
                    <div class="summary-label">Not Restored</div>
                </div>
                {{-- <div class="summary-card">
                    <div class="summary-number">{{ $stats['total_cost'] }} M</div>
                    <div class="summary-label">Total Cost (PKR)</div>
                </div> --}}
            </div>

            <!-- Reporting Officers -->
            @if ($reportingOfficers->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi-people me-2"></i>Reporting Officers</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($reportingOfficers as $officer)
                            <div class="officer-info">
                                <div class="text-muted small">{{ $officer['designation']->name ?? 'N/A' }}</div>
                                <div class="text-muted small">{{ $officer['office']->name ?? 'N/A' }}</div>
                                <div class="text-primary small">{{ $officer['damage_count'] }} damage(s) reported</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Main Damage Table -->
            <div class="mb-4">
                <h5 class="fw-bold mb-3"><i class="bi-list-ul me-2"></i>Infrastructure Damages</h5>

                @if ($damages->count() > 0)
                    <table class="damage-table">
                        <thead>
                            <tr>
                                <th width="5%">S#</th>
                                <th width="25%">{{ $type }} Name</th>
                                <th width="10%">Type</th>
                                <th width="10%">Total Length</th>
                                <th width="10%">Status</th>
                                <th width="10%">Damaged Length</th>
                                {{-- <th width="10%">Restoration Cost</th>
                                <th width="10%">Rehabilitation Cost</th> --}}
                                <th width="10%">Dated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach ($damagesByInfrastructure as $infrastructureId => $infrastructureDamages)
                                @php
                                    $infrastructure = $infrastructureDamages->first()->infrastructure;
                                    $totalDamages = $infrastructureDamages->count();
                                @endphp

                                <!-- Infrastructure Header Row -->
                                <tr class="infrastructure-row">
                                    <td
                                        rowspan="{{ $totalDamages + ($infrastructureDamages->where('remarks', '!=', '')->count() > 0 ? $infrastructureDamages->where('remarks', '!=', '')->count() : 0) }}">
                                        {{ $counter++ }}
                                    </td>
                                    <td
                                        rowspan="{{ $totalDamages + ($infrastructureDamages->where('remarks', '!=', '')->count() > 0 ? $infrastructureDamages->where('remarks', '!=', '')->count() : 0) }}">
                                        {{ $infrastructure->name }} <span style="font-size:10px">
                                            {{ $infrastructureDamages->count() > 1 ? "({$infrastructureDamages->count()} Damages)" : '' }}</span>
                                    </td>
                                    <td
                                        rowspan="{{ $totalDamages + ($infrastructureDamages->where('remarks', '!=', '')->count() > 0 ? $infrastructureDamages->where('remarks', '!=', '')->count() : 0) }}">
                                        {{ $infrastructure->type }}
                                    </td>
                                    <td
                                        rowspan="{{ $totalDamages + ($infrastructureDamages->where('remarks', '!=', '')->count() > 0 ? $infrastructureDamages->where('remarks', '!=', '')->count() : 0) }}">
                                        {{ $infrastructure->length ?? 'N/A' }}
                                        {{ request()->query('type') == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}
                                    </td>

                                    @php $firstDamage = $infrastructureDamages->first(); @endphp
                                    <td>
                                        <span class="status-badge">
                                            {{ $firstDamage->road_status }}
                                        </span>
                                    </td>
                                    <td>{{ $firstDamage->damaged_length ?? 'N/A' }}
                                        {{ request()->query('type') == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}
                                    </td>
                                    {{-- <td>{{ $firstDamage->approximate_restoration_cost }} M</td>
                                    <td>{{ $firstDamage->approximate_rehabilitation_cost }} M</td> --}}
                                    <td>{{ $firstDamage->created_at->format('M d, Y') }}</td>
                                </tr>

                                <!-- remarks for first damage if exists -->
                                @if ($firstDamage->remarks)
                                    <tr class="remarks-row">
                                        <td colspan="5" style="color:#888">
                                            <div><strong>Remarks:</strong> {!! $firstDamage->remarks !!} </div>
                                            <div><strong>Reported by:</strong>
                                                {{ $firstDamage->posting->office->name ?? 'N/A' }}</div>
                                        </td>
                                    </tr>
                                @endif

                                <!-- Additional Damage Rows -->
                                @foreach ($infrastructureDamages->skip(1) as $damage)
                                    <tr class="">
                                        <td>
                                            <span class="status-badge">
                                                {{ $damage->road_status }}
                                            </span>
                                        </td>
                                        <td>{{ $damage->damaged_length ?? 'N/A' }}
                                            {{ request()->query('type') == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}
                                        </td>
                                        {{-- <td>{{ $damage->approximate_restoration_cost }} M</td>
                                        <td>{{ $damage->approximate_rehabilitation_cost }} M</td> --}}
                                        <td>{{ $damage->created_at->format('M d, Y') }}</td>
                                    </tr>

                                    <!-- remarks for additional damages -->
                                    @if ($damage->remarks)
                                        <tr class="remarks-row">
                                            <td colspan="5" style="color:#888">
                                                <div><strong>Remarks:</strong> {{ $damage->remarks }}</div>
                                                <div><strong>Reported by:</strong>
                                                    {{ $firstDamage->posting->office->name ?? 'N/A' }}</div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center py-5">
                        <i class="bi-exclamation-circle display-1 text-muted"></i>
                        <h5 class="mt-3">No Damages Found</h5>
                        <p class="text-muted">No damage records found for {{ $district->name }} district.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#print-report').on('click', function() {
                    $("#district-report").printThis({
                        header: "<h3 class='text-center mb-4'>{{ $district->name }} District - Damage Details Report</h3>",
                        printContainer: true,
                        loadCSS: true,
                        pageTitle: "{{ $district->name }} Damage Report"
                    });
                });
            });
        </script>
    @endpush
</x-main-layout>
