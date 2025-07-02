<x-dmis-layout title="District Damage Details - {{ $district->name }}">
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <style>
        .damage-card {
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .damage-card-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .damage-card-body {
            padding: 1.5rem;
        }

        .infrastructure-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .damage-info {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 0.25rem;
            text-transform: capitalize;
        }

        .status-fully-restored {
            background-color: #d4edda;
            color: #155724;
        }

        .status-partially-restored {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-not-restored {
            background-color: #f8d7da;
            color: #721c24;
        }

        .image-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .image-section {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .image-section-header {
            background-color: #f8f9fa;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .before-header {
            background-color: #fff3cd;
            color: #856404;
        }

        .after-header {
            background-color: #d4edda;
            color: #155724;
        }

        .image-container {
            position: relative;
            padding: 1rem;
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
        }

        .damage-image {
            width: 250px;
            height: 200px;
            object-fit: cover;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .damage-image:hover {
            transform: scale(1.05);
        }

        .no-images {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            color: #6c757d;
            font-style: italic;
            background-color: #f8f9fa;
            border-radius: 0.25rem;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border: 1px solid #dee2e6;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .summary-number {
            font-size: 2rem;
            font-weight: 700;
            color: #007bff;
        }

        .summary-label {
            font-size: 0.9rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .officer-info {
            background-color: #e3f2fd;
            padding: 0.75rem;
            border-radius: 0.375rem;
            margin-top: 0.5rem;
        }

        .modal-image {
            max-width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }

        @media print {
            .no-print {
                display: none;
            }

            .damage-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }

        .damage-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .meta-item {
            background-color: #ffffff;
            padding: 0.75rem;
            border: 1px solid #e9ecef;
            border-radius: 0.25rem;
        }

        .meta-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .meta-value {
            font-weight: 600;
            color: #2c3e50;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-group-custom {
            display: flex;
            gap: 0.25rem;
        }

        .btn-group-custom .btn {
            border-radius: 0.375rem !important;
        }

        @media print {

            .no-print {
                display: none !important;
                visibility: hidden !important;
            }

            body {
                font-size: 12px;
                line-height: 1.4;
                color: #000 !important;
                background: white !important;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 10px !important;
            }

            .page-header {
                border-bottom: 2px solid #000;
                margin-bottom: 15px;
                padding-bottom: 10px;
            }

            .summary-cards {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 8px !important;
                margin-bottom: 20px !important;
            }

            .summary-card {
                border: 1px solid #000;
                background: white !important;
                box-shadow: none;
                page-break-inside: avoid;
                flex: 1 1 calc(25% - 6px) !important;

                min-width: 120px !important;
                padding: 8px !important;
                margin: 0 !important;
                text-align: center;
            }

            .summary-number {
                font-size: 16px !important;
                font-weight: bold;
                margin-bottom: 4px;
            }

            .summary-label {
                font-size: 10px !important;
                line-height: 1.2;
            }

            .damage-card {
                border: 1px solid #000;
                background: white !important;
                box-shadow: none;
                margin-bottom: 15px !important;
                page-break-inside: avoid;
                width: 100% !important;
            }

            .damage-card-header {
                background: white !important;
                border-bottom: 1px solid #000;
                color: #000 !important;
                padding: 8px !important;
            }

            .damage-card-body {
                background: white !important;
                padding: 10px !important;
            }

            .damage-info {
                border: 1px solid #000;
                background: white !important;
                margin-bottom: 12px !important;
                padding: 8px !important;
                page-break-inside: avoid;
                width: 100% !important;
            }

            .damage-meta {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 8px !important;
                margin-bottom: 10px !important;
            }

            .meta-item {
                border: 1px solid #000;
                background: white !important;
                flex: 1 1 calc(50% - 4px) !important;

                min-width: 150px !important;
                padding: 6px !important;
                margin: 0 !important;
            }

            .meta-label {
                font-size: 9px !important;
                margin-bottom: 2px !important;
            }

            .meta-value {
                font-size: 11px !important;
                font-weight: bold;
            }

            .officer-info {
                border: 1px solid #000;
                background: white !important;
                color: #000 !important;
                margin-bottom: 8px !important;
                padding: 8px !important;
                width: 100% !important;
            }

            .card {
                border: 1px solid #000;
                background: white !important;
                box-shadow: none;
                margin-bottom: 15px !important;
                page-break-inside: avoid;
                width: 100% !important;
            }

            .card-header {
                background: white !important;
                border-bottom: 1px solid #000;
                color: #000 !important;
                padding: 8px !important;
            }

            .card-body {
                background: white !important;
                padding: 10px !important;
            }

            .image-gallery {
                display: flex !important;
                gap: 10px !important;
                margin-top: 10px !important;
                flex-wrap: wrap !important;
            }

            .image-section {
                border: 1px solid #000;
                background: white !important;
                flex: 1 1 calc(50% - 5px) !important;

                min-width: 200px !important;
                margin: 0 !important;
                page-break-inside: avoid;
            }

            .image-section-header {
                background: white !important;
                border-bottom: 1px solid #000;
                color: #000 !important;
                padding: 6px !important;
                font-size: 10px !important;
            }

            .image-container {
                background: white !important;
                padding: 8px !important;
                min-height: 100px !important;
            }

            .damage-image {
                border: 1px solid #000;
                max-width: 100% !important;
                height: auto !important;
                max-height: 120px !important;
            }

            .no-images {
                background: white !important;
                border: 1px solid #000;
                color: #000 !important;
                padding: 20px !important;
                text-align: center;
                font-size: 10px !important;
            }

            .status-badge,
            .badge {
                background: white !important;
                color: #000 !important;
                border: 1px solid #000;
                display: inline-block !important;
                padding: 2px 6px !important;
                font-size: 9px !important;
                margin-right: 5px !important;
                margin-bottom: 3px !important;
            }

            .infrastructure-title {
                border-bottom: 1px solid #000;
                padding-bottom: 5px !important;
                margin-bottom: 8px !important;
                color: #000 !important;
                font-size: 14px !important;
                font-weight: bold;
            }

            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                color: #000 !important;
                margin-bottom: 10px !important;
                margin-top: 5px !important;
                page-break-after: avoid;
            }

            h4 {
                font-size: 16px !important;
                border-bottom: 1px solid #000;
                padding-bottom: 5px !important;
            }

            h5 {
                font-size: 14px !important;
                border-bottom: 1px solid #000;
                padding-bottom: 3px !important;
            }

            .table th {
                background: white !important;
                color: #000 !important;
                border: 1px solid #000;
                padding: 4px !important;
                font-size: 10px !important;
            }

            .table td {
                border: 1px solid #000;
                color: #000 !important;
                padding: 4px !important;
                font-size: 10px !important;
            }

            .text-muted,
            .text-primary,
            .text-secondary {
                color: #000 !important;
            }

            p {
                margin-bottom: 6px !important;
            }

            p,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6 {
                orphans: 3;
                widows: 3;
            }

            * {
                box-shadow: none !important;
                text-shadow: none !important;
                background-image: none !important;
            }

            .row {
                display: flex !important;
                flex-wrap: wrap !important;
                gap: 10px !important;
            }

            .col-md-6,
            .col-lg-4 {
                flex: 1 1 calc(33.333% - 7px) !important;

                min-width: 150px !important;
            }

            .damage-card:last-child {
                margin-bottom: 0 !important;
            }
        }

    </style>
    @endpush

    <x-slot name="header">
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.dashboard') }}">DMIS</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.apps.dmis.reports.index') }}">Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $district->name }} Details</li>
    </x-slot>

    <div id="district-report" class="container py-2 px-1 rounded">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">{{ $district->name }} District - Damage Details</h4>
                <div class="text-muted">
                    <span class="badge bg-primary">Report Date: {{ now()->format('F d, Y') }}</span>
                    <span class="badge bg-secondary">Infrastructure Type: {{ $type }}</span>
                    <span class="badge bg-info">Total Damages: {{ $stats['total_damages'] }}</span>
                </div>
            </div>
            <div class="no-print action-buttons">
                <div class="btn-group-custom">
                    <button type="button" id="print-report" class="cw-btn">
                        <i class="bi-printer me-1"></i> Print Report
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
                <div class="summary-label">Damaged Length {{ request()->query("type") == "Road" || !request()->has("type") ? "(KM)" : "(Meter)" }}</div>
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
                <div class="summary-number">{{ $stats['total_cost'] }} Millions</div>
                <div class="summary-label">Total Cost (PKR)</div>
            </div>
        </div>

        <!-- Reporting Officers Section -->
        @if($reportingOfficers->count() > 0)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi-people me-2"></i>Reporting Officers</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($reportingOfficers as $officer)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="officer-info">
                            <div class="fw-bold">{{ $officer['user']->name }}</div>
                            <div class="text-muted small">{{ $officer['designation']->name ?? 'N/A' }}</div>
                            <div class="text-muted small">{{ $officer['office']->name ?? 'N/A' }}</div>
                            <div class="text-primary small">{{ $officer['damage_count'] }} damage(s) reported</div>
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

            @if($damages->count() > 0)
            @foreach($damagesByInfrastructure as $infrastructureId => $infrastructureDamages)
            @php
            $infrastructure = $infrastructureDamages->first()->infrastructure;
            @endphp

            <div class="damage-card border border-secondary shadow">
                <div class="damage-card-header">
                    <div class="infrastructure-title">
                        <i class="bi-geo-alt me-2"></i>{{ $infrastructure->name }}
                    </div>
                    <div class="text-muted small">
                        Type: {{ $infrastructure->type }} |
                        Length: {{ $infrastructure->length ?? 'N/A' }} {{ request()->query("type") == "Road" || !request()->has("type") ? "(KM)" : "(Meter)" }} |
                        Damages: {{ $infrastructureDamages->count() }}
                    </div>
                </div>

                <div class="damage-card-body">
                    @foreach($infrastructureDamages as $damage)
                    <div class="damage-info">
                        <!-- Damage Metadata -->
                        <div class="damage-meta">
                            <div class="meta-item">
                                <div class="meta-label">Damage ID</div>
                                <div class="meta-value">#{{ $damage->id }}</div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Status</div>
                                <div class="meta-value">
                                    <span class="status-badge status-{{ str_replace(' ', '-', strtolower($damage->road_status)) }}">
                                        {{ $damage->road_status }}
                                    </span>
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Damaged Length</div>
                                <div class="meta-value">{{ $damage->damaged_length ?? 'N/A' }} {{ request()->query("type") == "Road" || !request()->has("type") ? "(KM)" : "(Meter)" }}</div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Reported Date</div>
                                <div class="meta-value">{{ $damage->created_at->format('M d, Y') }}</div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Restoration Cost</div>
                                <div class="meta-value">{{ $damage->approximate_restoration_cost }} Millions</div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-label">Rehabilitation Cost</div>
                                <div class="meta-value">{{ $damage->approximate_rehabilitation_cost }} Millions</div>
                            </div>
                        </div>

                        <!-- Damage Description -->
                        @if($damage->description)
                        <div class="mb-3">
                            <strong>Description:</strong>
                            <p class="mb-0 mt-1">{{ $damage->description }}</p>
                        </div>
                        @endif

                        <!-- Reporting Officer Info -->
                        @if($damage->posting && $damage->posting->user)
                        <div class="mb-3">
                            <strong>Reported by:</strong>
                            <div class="officer-info">
                                <div class="fw-bold">{{ $damage->posting->user->name }}</div>
                                <div class="text-muted small">
                                    {{ $damage->posting->user->currentDesignation->name ?? 'N/A' }} |
                                    {{ $damage->posting->office->name ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Before and After Images -->
                        <div class="image-gallery">
                            <!-- Before Work Pictures -->
                            <div class="image-section">
                                <div class="image-section-header before-header">
                                    <i class="bi-camera me-1"></i>Images before Work
                                </div>
                                <div class="image-container">
                                    @php
                                    $beforeImages = $damage->getMedia('damage_before_images');
                                    @endphp

                                    @if($beforeImages->count() > 0)
                                    @foreach($beforeImages as $image)
                                    <img src="{{ $image->getUrl() }}" alt="Before work - {{ $infrastructure->name }}" class="damage-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="{{ $image->getUrl() }}" data-image-title="Before Work - {{ $infrastructure->name }}">
                                    @endforeach
                                    @else
                                    <div class="no-images">
                                        <i class="bi-image me-2"></i>No before pictures available
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- After Work Pictures -->
                            <div class="image-section">
                                <div class="image-section-header after-header">
                                    <i class="bi-camera me-1"></i>Images After Work
                                </div>
                                <div class="image-container">
                                    @php
                                    $afterImages = $damage->getMedia('damage_after_images');
                                    @endphp

                                    @if($afterImages->count() > 0)
                                    @foreach($afterImages as $image)
                                    <img src="{{ $image->getUrl() }}" alt="After work - {{ $infrastructure->name }}" class="damage-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image-src="{{ $image->getUrl() }}" data-image-title="After Work - {{ $infrastructure->name }}">
                                    @endforeach
                                    @else
                                    <div class="no-images">
                                        <i class="bi-image me-2"></i>No after pictures available
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!$loop->last)
                    <hr class="my-3">
                    @endif
                    @endforeach
                </div>
            </div>
            @endforeach
            @else
            <div class="text-center py-5">
                <i class="bi-exclamation-circle display-1 text-muted"></i>
                <h5 class="mt-3">No Damages Found</h5>
                <p class="text-muted">No damage records found for {{ $district->name }} district with the selected infrastructure type.</p>
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

    <script>
        $(document).ready(function() {
            // Existing print functionality
            $('#print-report').on('click', () => {
                $("#district-report").printThis({
                    header: "<h4 class='text-center mb-3'>District Damages Report</h4>"
                    , beforePrint() {
                        document.querySelector('.page-loader').classList.remove('hidden');
                    }
                    , afterPrint() {
                        document.querySelector('.page-loader').classList.add('hidden');
                    }
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

        });

    </script>
    @endpush
</x-dmis-layout>
