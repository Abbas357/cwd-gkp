<x-dmis-layout title="District Damage Details - {{ $district->name }}">
    @push('style')
        <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
        <style>
            .damage-card {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                margin-bottom: 2rem;
                overflow: hidden;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                background: #ffffff;
            }

            .damage-card-header {
                background: #f8f9fa;
                padding: 1.5rem;
                border-bottom: 1px solid #dee2e6;
            }

            .damage-card-body {
                padding: 1.5rem;
            }

            .infrastructure-title {
                font-weight: 600;
                font-size: 1.2rem;
                color: #495057;
                margin-bottom: 0.5rem;
            }

            .damage-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 1rem;
                background: #ffffff;
                border-radius: 6px;
                overflow: hidden;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .damage-table th,
            .damage-table td {
                border: 1px solid #dee2e6;
                padding: 0.75rem;
                text-align: left;
                vertical-align: top;
            }

            .damage-table th {
                background: #495057;
                color: #ffffff;
                font-weight: 600;
                font-size: 0.9rem;
            }

            .damage-table tbody tr {
                background-color: #ffffff;
                transition: background-color 0.2s;
            }

            .damage-table tbody tr:nth-child(even) {
                background-color: #f8f9fa;
            }

            .damage-table tbody tr:hover {
                background-color: #e9ecef;
            }

            .damage-row {
                border-bottom: 2px solid #495057 !important;
                background: #f8f9fa !important;
            }

            .damage-row td {
                font-weight: 600;
                color: #495057;
                border-bottom: 2px solid #495057 !important;
            }

            .damage-separator {
                height: 2px;
                background: #dee2e6;
                margin: 1rem 0;
            }

            .images-row {
                background: #f8f9fa !important;
                border-bottom: 1px solid #dee2e6 !important;
            }

            .images-row td {
                padding: 1.5rem !important;
            }

            .status-badge {
                padding: 0.4em 0.8em;
                font-size: 0.75em;
                font-weight: 600;
                border-radius: 4px;
                text-transform: uppercase;
            }

            .status-fully-restored {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .status-partially-restored {
                background: #fff3cd;
                color: #856404;
                border: 1px solid #ffeaa7;
            }

            .status-not-restored {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .image-gallery {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 1rem;
                margin-top: 1rem;
            }

            .image-section {
                border: 1px solid #dee2e6;
                border-radius: 6px;
                overflow: hidden;
                background: #ffffff;
            }

            .image-section-header {
                padding: 0.75rem;
                font-weight: 600;
                font-size: 0.9rem;
                text-align: center;
                background: #f8f9fa;
                border-bottom: 1px solid #dee2e6;
            }

            .before-header {
                color: #856404;
            }

            .after-header {
                color: #155724;
            }

            .image-container {
                padding: 1rem;
                display: flex;
                gap: 0.75rem;
                overflow-x: auto;
            }

            .damage-image {
                width: 200px;
                height: 150px;
                object-fit: cover;
                border-radius: 4px;
                cursor: pointer;
                transition: transform 0.2s ease;
                border: 1px solid #dee2e6;
            }

            .damage-image:hover {
                transform: scale(1.02);
            }

            .no-images {
                display: flex;
                align-items: center;
                justify-content: center;
                height: 120px;
                color: #6c757d;
                font-style: italic;
                background: #f8f9fa;
                border: 1px dashed #dee2e6;
                border-radius: 4px;
            }

            .summary-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 1rem;
                margin-bottom: 2rem;
            }

            .summary-card {
                background: #ffffff;
                border: 1px solid #dee2e6;
                border-radius: 6px;
                padding: 1.5rem;
                text-align: center;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                transition: transform 0.2s;
            }

            .summary-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            }

            .summary-number {
                font-size: 2rem;
                font-weight: 700;
                color: #495057;
                margin-bottom: 0.5rem;
            }

            .summary-label {
                font-size: 0.9rem;
                color: #6c757d;
                font-weight: 500;
            }

            .officer-info {
                background: #f8f9fa;
                padding: 1rem;
                border-radius: 4px;
                margin-top: 0.5rem;
                border: 1px solid #dee2e6;
            }

            .modal-image {
                max-width: 100%;
                max-height: 80vh;
                object-fit: contain;
                border-radius: 4px;
            }

            .action-buttons {
                display: flex;
                gap: 0.5rem;
                align-items: center;
            }

            .btn-group-custom {
                display: flex;
                gap: 0.5rem;
            }

            .infrastructure-separator {
                margin: 2rem 0;
                text-align: center;
                position: relative;
            }

            .infrastructure-separator::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 1px;
                background: #dee2e6;
            }

            .infrastructure-separator span {
                background: #ffffff;
                padding: 0.5rem 1rem;
                color: #6c757d;
                font-weight: 500;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                position: relative;
                z-index: 1;
            }

            /* Print Styles */
            @media print {
                .no-print {
                    display: none !important;
                    visibility: hidden !important;
                }

                body {
                    font-size: 11px;
                    line-height: 1.3;
                    color: #000 !important;
                    background: white !important;
                    margin: 0;
                    padding: 0;
                }

                .container {
                    width: 100% !important;
                    max-width: none !important;
                    margin: 0 !important;
                    padding: 8px !important;
                }

                .page-header {
                    border-bottom: 2px solid #000;
                    margin-bottom: 15px;
                    padding-bottom: 10px;
                }

                .summary-cards {
                    display: flex !important;
                    flex-wrap: wrap !important;
                    gap: 6px !important;
                    margin-bottom: 20px !important;
                }

                .summary-card {
                    border: 1px solid #000 !important;
                    background: white !important;
                    box-shadow: none !important;
                    page-break-inside: avoid;
                    flex: 1 1 calc(25% - 5px) !important;
                    min-width: 110px !important;
                    padding: 6px !important;
                    margin: 0 !important;
                    text-align: center;
                }

                .summary-number {
                    font-size: 14px !important;
                    font-weight: bold !important;
                    margin-bottom: 3px !important;
                }

                .summary-label {
                    font-size: 9px !important;
                    line-height: 1.2 !important;
                }

                .damage-card {
                    border: 2px solid #000 !important;
                    background: white !important;
                    box-shadow: none !important;
                    margin-bottom: 20px !important;
                    page-break-inside: avoid;
                }

                .damage-card-header {
                    background: #f5f5f5 !important;
                    border-bottom: 1px solid #000 !important;
                    color: #000 !important;
                    padding: 10px !important;
                }

                .damage-card-body {
                    background: white !important;
                    padding: 12px !important;
                }

                .damage-table {
                    width: 100% !important;
                    border-collapse: collapse !important;
                    margin-bottom: 15px !important;
                }

                .damage-table th,
                .damage-table td {
                    border: 1px solid #000 !important;
                    padding: 6px !important;
                    color: #000 !important;
                    background: white !important;
                    font-size: 9px !important;
                }

                .damage-table th {
                    background: #f0f0f0 !important;
                    font-weight: bold !important;
                    text-align: center !important;
                }

                .damage-row td {
                    border-bottom: 2px solid #000 !important;
                    font-weight: bold !important;
                    background: #f5f5f5 !important;
                }

                .damage-separator {
                    height: 1px !important;
                    background: #000 !important;
                    margin: 8px 0 !important;
                }

                .images-row td {
                    background: white !important;
                    padding: 8px !important;
                    border-bottom: 1px solid #000 !important;
                }

                .officer-info {
                    border: 1px solid #000 !important;
                    background: white !important;
                    color: #000 !important;
                    margin-bottom: 8px !important;
                    padding: 6px !important;
                }

                .image-section {
                    border: 1px solid #000 !important;
                    background: white !important;
                    margin-bottom: 10px !important;
                    page-break-inside: avoid;
                }

                .image-section-header {
                    background: #f0f0f0 !important;
                    border-bottom: 1px solid #000 !important;
                    color: #000 !important;
                    padding: 6px !important;
                    font-size: 10px !important;
                    font-weight: bold !important;
                    text-align: center !important;
                }

                .image-container {
                    background: white !important;
                    padding: 6px !important;
                    display: flex !important;
                    flex-wrap: wrap !important;
                    gap: 6px !important;
                }

                .damage-image {
                    border: 1px solid #000 !important;
                    width: 130px !important;
                    height: 100px !important;
                    object-fit: cover !important;
                    margin: 0 !important;
                }

                .no-images {
                    background: white !important;
                    border: 1px dashed #000 !important;
                    color: #000 !important;
                    padding: 15px !important;
                    text-align: center !important;
                    font-size: 9px !important;
                }

                .status-badge {
                    background: white !important;
                    color: #000 !important;
                    border: 1px solid #000 !important;
                    padding: 2px 4px !important;
                    font-size: 8px !important;
                    border-radius: 2px !important;
                }

                .infrastructure-title {
                    color: #000 !important;
                    font-size: 12px !important;
                    font-weight: bold !important;
                    border-bottom: 1px solid #000 !important;
                    padding-bottom: 4px !important;
                }

                .infrastructure-separator {
                    margin: 15px 0 !important;
                }

                .infrastructure-separator::before {
                    background: #000 !important;
                    height: 1px !important;
                }

                .infrastructure-separator span {
                    background: white !important;
                    color: #000 !important;
                    border: 1px solid #000 !important;
                    font-size: 10px !important;
                    padding: 3px 8px !important;
                }

                h1,
                h2,
                h3,
                h4,
                h5,
                h6 {
                    color: #000 !important;
                    margin-bottom: 8px !important;
                    margin-top: 4px !important;
                }

                .text-muted,
                .text-primary,
                .text-secondary {
                    color: #000 !important;
                }

                .print-image-placeholder {
                    width: 130px !important;
                    height: 100px !important;
                    border: 1px dashed #000 !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    background: #f8f9fa !important;
                    color: #666 !important;
                    font-size: 9px !important;
                    text-align: center !important;
                    margin: 3px !important;
                }
            }
        </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.dashboard') }}">DMIS</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $district->name }} Details</li>
    </x-slot>

    <div id="district-report" class="container py-2 px-1">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">{{ $district->name }} District - Damage Details</h4>
                <div class="text-muted">
                    <span class="badge bg-primary fs-6 px-2 py-1">Report Date: <strong> {{ now()->format('F d, Y') }}
                        </strong></span>
                    <span class="badge bg-secondary fs-6 px-2 py-1">Infrastructure Type: <strong>{{ $type }}
                        </strong></span>
                    <span class="badge bg-info fs-6 px-2 py-1">Total Damages:
                        <strong>{{ $stats['total_damages'] }}</strong></span>
                </div>
            </div>
            <div class="no-print action-buttons">
                <div class="btn-group-custom">
                    <button type="button" id="print-report" class="btn btn-outline-primary">
                        <i class="bi-printer me-1"></i> Print Report
                    </button>
                    <button type="button" id="export-pdf" class="btn btn-outline-success">
                        <i class="bi-file-pdf me-1"></i> Export PDF
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card">
                <div class="summary-number">{{ $stats['total_damages'] }}</div>
                <div class="summary-label">Total Damages</div>
            </div>
            <div class="summary-card">
                <div class="summary-number">{{ $stats['unique_infrastructures'] }}</div>
                <div class="summary-label">Affected Infrastructures</div>
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
            <div class="summary-card">
                <div class="summary-number">{{ $stats['total_restoration_cost'] }} M</div>
                <div class="summary-label">Restoration Cost (PKR)</div>
            </div>
            <div class="summary-card">
                <div class="summary-number">{{ $stats['total_rehabilitation_cost'] }} M</div>
                <div class="summary-label">Rehabilitation Cost (PKR)</div>
            </div>
            <div class="summary-card">
                <div class="summary-number">{{ $stats['total_cost'] }} M</div>
                <div class="summary-label">Total Cost (PKR)</div>
            </div>
        </div>

        <!-- Reporting Officers Section -->
        @if ($reportingOfficers->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi-people me-2"></i>Reporting Officers</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($reportingOfficers as $officer)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="officer-info">
                                    <div class="fw-bold">{{ $officer['user']->name }}</div>
                                    <div class="text-muted small">{{ $officer['designation']->name ?? 'N/A' }}</div>
                                    <div class="text-muted small">{{ $officer['office']->name ?? 'N/A' }}</div>
                                    <div class="text-primary small">{{ $officer['damage_count'] }} damage(s) reported
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Damages by Infrastructure -->
        <div class="mb-4">
            <h5 class="fw-bold mb-3"><i class="bi-list-ul me-2"></i>Damages by Infrastructure</h5>

            @if ($damages->count() > 0)
                @foreach ($damagesByInfrastructure as $infrastructureId => $infrastructureDamages)
                    @php
                        $infrastructure = $infrastructureDamages->first()->infrastructure;
                    @endphp

                    @if (!$loop->first)
                        <div class="infrastructure-separator">
                            <span><i class="bi-arrow-down-circle me-2"></i>Next
                                {{ request()->query('type') ?? 'Road' }}</span>
                        </div>
                    @endif

                    <div class="damage-card">
                        <div class="damage-card-header">
                            <div class="infrastructure-title">
                                <i class="bi-geo-alt me-2"></i>{{ $infrastructure->name }}
                            </div>
                            <div class="text-muted">
                                Type: <strong>{{ $infrastructure->type }} </strong> |
                                Length: <strong>{{ $infrastructure->length ?? 'N/A' }}
                                    {{ request()->query('type') == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}
                                </strong>|
                                Damages: <strong>{{ $infrastructureDamages->count() }}</strong>
                            </div>
                        </div>

                        <div class="damage-card-body">
                            <table class="damage-table">
                                <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Status</th>
                                        <th>Damaged Length</th>
                                        <th>Reported Date</th>
                                        <th>Restoration Cost</th>
                                        <th>Rehabilitation Cost</th>
                                        <th>Reported By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($infrastructureDamages as $damage)
                                        @if (!$loop->first)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="damage-separator"></div>
                                                </td>
                                            </tr>
                                        @endif

                                        <!-- Damage Information Row -->
                                        <tr class="damage-row">
                                            <td><strong>#{{ $loop->iteration }}</strong></td>
                                            <td>
                                                <span
                                                    class="status-badge status-{{ str_replace(' ', '-', strtolower($damage->road_status)) }}">
                                                    {{ $damage->road_status }}
                                                </span>
                                            </td>
                                            <td>{{ $damage->damaged_length ?? 'N/A' }}
                                                {{ request()->query('type') == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}
                                            </td>
                                            <td>{{ $damage->created_at->format('M d, Y') }}</td>
                                            <td>{{ $damage->approximate_restoration_cost }} M</td>
                                            <td>{{ $damage->approximate_rehabilitation_cost }} M</td>
                                            <td>
                                                @if ($damage->posting && $damage->posting->user)
                                                    <strong>{{ $damage->posting->user->name }}</strong><br>
                                                    <small
                                                        class="text-muted">{{ $damage->posting->user->currentDesignation->name ?? 'N/A' }}</small><br>
                                                    <small
                                                        class="text-muted">{{ $damage->posting->office->name ?? 'N/A' }}</small>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>

                                        <!-- Description Row (if exists) -->
                                        @if ($damage->description)
                                            <tr>
                                                <td colspan="7">
                                                    <div class="p-3 bg-light rounded">
                                                        <strong><i class="bi-card-text me-2"></i>Description:</strong>
                                                        {{ $damage->description }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif

                                        <!-- Images Row -->
                                        <tr class="images-row">
                                            <td colspan="7">
                                                <div class="image-gallery">
                                                    <!-- Before Work Pictures -->
                                                    <div class="image-section">
                                                        <div class="image-section-header before-header">
                                                            <i class="bi-camera me-2"></i>Images Before Work
                                                        </div>
                                                        <div class="image-container">
                                                            @php
                                                                $beforeImages = $damage->getMedia(
                                                                    'damage_before_images',
                                                                );
                                                            @endphp

                                                            @if ($beforeImages->count() > 0)
                                                                @foreach ($beforeImages as $image)
                                                                    <img src="{{ $image->getUrl() }}"
                                                                        alt="Before work - {{ $infrastructure->name }}"
                                                                        class="damage-image" data-bs-toggle="modal"
                                                                        data-bs-target="#imageModal"
                                                                        data-image-src="{{ $image->getUrl() }}"
                                                                        data-image-title="Before Work - {{ $infrastructure->name }}">
                                                                @endforeach
                                                            @else
                                                                <div class="no-images">
                                                                    <i class="bi-image me-2"></i>No before pictures
                                                                    available
                                                                </div>
                                                                <!-- Print placeholder -->
                                                                <div class="print-image-placeholder d-none">
                                                                    No Before<br>Image
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- After Work Pictures -->
                                                    <div class="image-section">
                                                        <div class="image-section-header after-header">
                                                            <i class="bi-camera me-2"></i>Images After Work
                                                        </div>
                                                        <div class="image-container">
                                                            @php
                                                                $afterImages = $damage->getMedia('damage_after_images');
                                                            @endphp

                                                            @if ($afterImages->count() > 0)
                                                                @foreach ($afterImages as $image)
                                                                    <img src="{{ $image->getUrl() }}"
                                                                        alt="After work - {{ $infrastructure->name }}"
                                                                        class="damage-image" data-bs-toggle="modal"
                                                                        data-bs-target="#imageModal"
                                                                        data-image-src="{{ $image->getUrl() }}"
                                                                        data-image-title="After Work - {{ $infrastructure->name }}">
                                                                @endforeach
                                                            @else
                                                                <div class="no-images">
                                                                    <i class="bi-image me-2"></i>No after pictures
                                                                    available
                                                                </div>
                                                                <!-- Print placeholder -->
                                                                <div class="print-image-placeholder d-none">
                                                                    No After<br>Image
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-5">
                    <i class="bi-exclamation-circle display-1 text-muted"></i>
                    <h5 class="mt-3">No Damages Found</h5>
                    <p class="text-muted">No damage records found for {{ $district->name }} district with the selected
                        infrastructure type.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="" class="modal-image">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="downloadImage" href="" download class="btn btn-primary">
                        <i class="bi-download me-1"></i>Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script src="{{ asset('admin/plugins/jspdf/jspdf.min.js') }}"></script>
        <script src="{{ asset('admin/plugins/html2canvas/html2canvas.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#print-report').on('click', function() {
                    $('.no-images').each(function() {
                        $(this).siblings('.print-image-placeholder').removeClass('d-none');
                    });

                    $("#district-report").printThis({
                        header: "<h3 class='text-center mb-4'>{{ $district->name }} District - Damage Details Report</h3>",
                        beforePrint: function() {
                            if (document.querySelector('.page-loader')) {
                                document.querySelector('.page-loader').classList.remove('hidden');
                            }
                        },
                        afterPrint: function() {
                            if (document.querySelector('.page-loader')) {
                                document.querySelector('.page-loader').classList.add('hidden');
                            }
                            $('.print-image-placeholder').addClass('d-none');
                        }
                    });
                });

                $('#export-pdf').on('click', function() {
                    const button = $(this);
                    const originalText = button.html();

                    button.html('<i class="spinner-border spinner-border-sm me-1"></i> Generating PDF...');
                    button.prop('disabled', true);

                    $('.action-buttons').hide();

                    $('.no-images').each(function() {
                        $(this).siblings('.print-image-placeholder').removeClass('d-none');
                    });

                    // Generate PDF
                    html2canvas(document.getElementById('district-report'), {
                        scale: 2,
                        useCORS: true,
                        allowTaint: true,
                        backgroundColor: '#ffffff',
                        width: document.getElementById('district-report').scrollWidth,
                        height: document.getElementById('district-report').scrollHeight
                    }).then(function(canvas) {
                        const {
                            jsPDF
                        } = window.jspdf;
                        const pdf = new jsPDF('p', 'mm', 'a4');

                        const imgData = canvas.toDataURL('image/png');
                        const imgWidth = 210;
                        const pageHeight = 295;
                        const imgHeight = (canvas.height * imgWidth) / canvas.width;
                        let heightLeft = imgHeight;
                        let position = 0;

                        pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                        heightLeft -= pageHeight;

                        while (heightLeft >= 0) {
                            position = heightLeft - imgHeight;
                            pdf.addPage();
                            pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                            heightLeft -= pageHeight;
                        }

                        const fileName =
                            `{{ $district->name }}_Damage_Report_${new Date().toISOString().split('T')[0]}.pdf`;
                        pdf.save(fileName);

                        button.html(originalText);
                        button.prop('disabled', false);

                        $('.action-buttons').show();

                        // Hide print placeholders
                        $('.print-image-placeholder').addClass('d-none');

                    }).catch(function(error) {
                        console.error('Error generating PDF:', error);
                        alert('Error generating PDF. Please try again.');

                        // Reset button state
                        button.html(originalText);
                        button.prop('disabled', false);

                        // Show action buttons again
                        $('.action-buttons').show();

                        // Hide print placeholders
                        $('.print-image-placeholder').addClass('d-none');
                    });
                });

                // Image modal functionality
                const imageModal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                const modalLabel = document.getElementById('imageModalLabel');
                const downloadLink = document.getElementById('downloadImage');

                imageModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const imageSrc = button.getAttribute('data-image-src');
                    const imageTitle = button.getAttribute('data-image-title');

                    modalImage.src = imageSrc;
                    modalImage.alt = imageTitle;
                    modalLabel.textContent = imageTitle;
                    downloadLink.href = imageSrc;
                });

                // Clear modal when hidden
                imageModal.addEventListener('hidden.bs.modal', function() {
                    modalImage.src = '';
                    modalLabel.textContent = 'Image Preview';
                    downloadLink.href = '';
                });

                // Add smooth scrolling for better user experience
                $('a[href^="#"]').on('click', function(event) {
                    var target = $(this.getAttribute('href'));
                    if (target.length) {
                        event.preventDefault();
                        $('html, body').stop().animate({
                            scrollTop: target.offset().top - 100
                        }, 1000);
                    }
                });

                $('.damage-card').each(function(index) {
                    $(this).css('opacity', '0').delay(index * 100).animate({
                        opacity: 1
                    }, 500);
                });

                $('.summary-card').hover(
                    function() {
                        $(this).find('.summary-number').css('color', '#28a745');
                    },
                    function() {
                        $(this).find('.summary-number').css('color', '#007bff');
                    }
                );
            });
        </script>
    @endpush
</x-dmis-layout>
