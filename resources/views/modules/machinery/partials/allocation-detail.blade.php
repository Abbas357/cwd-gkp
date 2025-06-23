<style>
    .machinery-details-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .machinery-gallery {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding: 10px 0;
        margin-bottom: 15px;
        scrollbar-width: thin;
    }
    
    .gallery-item {
        position: relative;
        min-width: 250px;
        height: 180px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .gallery-item:hover img {
        transform: scale(1.05);
    }
    
    .gallery-label {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0, 0, 0, 0.6);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .info-section {
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .info-header {
        background-color: #f8f9fa;
        padding: 12px 15px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .info-header h5 {
        margin: 0;
        font-weight: 600;
        color: #111827;
    }
    
    .info-content {
        padding: 15px;
        background-color: white;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }
    
    .info-item {
        display: flex;
        flex-direction: column;
    }
    
    .info-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 5px;
    }
    
    .info-value {
        font-size: 1rem;
        color: #111827;
        font-weight: 500;
    }
    
    .info-value.highlight {
        color: #2563eb;
    }
    
    .machinery-status {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .machinery-status.functional {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .machinery-status.non-functional {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .machinery-status.under-maintenance {
        background-color: #fff7cd;
        color: #854d0e;
    }
    
    .allocation-history {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    
    .allocation-history th,
    .allocation-history td {
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
    }
    
    .allocation-history th {
        background-color: #f9fafb;
        font-weight: 600;
        text-align: left;
    }
    
    .allocation-type {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .allocation-permanent {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .allocation-temporary {
        background-color: #fff7cd;
        color: #854d0e;
    }
    
    .allocation-pool {
        background-color: #e0f2fe;
        color: #075985;
    }
    
    .timeline-user {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #4b5563;
        overflow: hidden;
    }
    
    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .user-info {
        display: flex;
        flex-direction: column;
    }
    
    .user-name {
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .user-position {
        font-size: 0.8rem;
        color: #6b7280;
    }

    .no-scroll {
        overflow: hidden !important;
    }

    @media print {
        .machinery-gallery {
            display: none !important;
        }
    }
</style>
<!-- Print Button -->
<div class="d-flex justify-content-end">
    <button type="button" id="print-machinery-details" class="btn btn-light btn-sm me-2 no-print">
        <i class="bi-printer me-1"></i> Print Details
    </button>
</div>
<div class="machinery-details-container">
    <!-- Machinery Gallery -->
    <div class="machinery-gallery no-print">
        @php
            $galleryItems = [
                ['collection' => 'machinery_front_pictures', 'label' => 'Front View'],
                ['collection' => 'machinery_side_pictures', 'label' => 'Side View'],
            ];
            $hasImages = false;
        @endphp
    
        @foreach($galleryItems as $item)
            @if($machinery?->hasMedia($item['collection']))
                @php $hasImages = true; @endphp
                <div class="gallery-item">
                    <img src="{{ $machinery?->getFirstMediaUrl($item['collection']) }}" alt="{{ $item['label'] }}">
                    <div class="gallery-label">{{ $item['label'] }}</div>
                </div>
            @endif
        @endforeach
    
        @if(!$hasImages)
            <div class="d-flex align-items-center justify-content-center w-100 border rounded py-4">
                <div class="text-center">
                    <i class="bi-camera text-muted mb-2" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0">No images available for this machinery</p>
                </div>
            </div>
        @endif
    </div>

<!-- Machinery Information -->
<div class="info-section">
    <div class="info-header">
        <i class="bi-car-front fs-5"></i>
        <h5>Machinery Information</h5>
    </div>
    <div class="info-content">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Brand & Model</span>
                <span class="info-value highlight">{{ $machinery?->brand ?? 'Unknown' }} {{ $machinery?->model ?? '' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Registration Number</span>
                <span class="info-value">{{ $machinery?->registration_number ?? 'Not Registered' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Type</span>
                <span class="info-value">{{ $machinery?->type ?? 'Not Specified' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Model Year</span>
                <span class="info-value">{{ $machinery?->model_year ?? 'Unknown' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Color</span>
                <span class="info-value">{{ $machinery?->color ?? 'Not Specified' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fuel Type</span>
                <span class="info-value">{{ $machinery?->fuel_type ?? 'Not Specified' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Chassis Number</span>
                <span class="info-value">{{ $machinery?->chassis_number ?? 'Not Available' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Engine Number</span>
                <span class="info-value">{{ $machinery?->engine_number ?? 'Not Available' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="machinery-status {{ strtolower($machinery?->functional_status ?? 'unknown') === 'functional' ? 'functional' : (strtolower($machinery?->functional_status ?? '') === 'condemned' ? 'condemned' : 'repairable') }}">
                    {{ $machinery?->functional_status ?? 'Unknown' }}
                </span>
            </div>
        </div>
    </div>
</div>

@if($currentAllocation)
<div class="info-section">
    <div class="info-header">
        <i class="bi-person-check fs-5"></i>
        <h5>Current Allocation</h5>
    </div>
    <div class="info-content">
        <div class="info-grid">

            <div class="info-item">
                <span class="info-label">Allocation Type</span>
                <span class="allocation-type allocation-pool">
                    {{ $currentAllocation?->type }} Machinery
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Assigned To</span>
                <div class="timeline-user mt-1">
                    <div class="user-avatar">
                        <i class="bi-building fs-5"></i>
                    </div>
                    <div class="user-info">
                        @if($currentAllocation?->office_id)
                            <span class="user-name">Office</span>
                            <span class="user-position">{{ $currentAllocation?->office?->name ?? 'Office' }}</span>
                        @else
                            <span class="user-name">Department</span>
                            <span class="user-position">General</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="info-item">
                <span class="info-label">Allocation Date</span>
                <span class="info-value">{{ $currentAllocation?->start_date ? $currentAllocation?->start_date->format('j F, Y') : 'Not Available' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Duration</span>
                <span class="info-value"> {{ formatDuration($currentAllocation?->start_date, now()) }}</span>
            </div>
            @if($currentAllocation?->hasMedia('machinery_allocation_orders'))
            <div class="info-item">
                <span class="info-label">Allocation Order</span>
                <a href="{{ $currentAllocation?->getFirstMediaUrl('machinery_allocation_orders') }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                    <i class="bi-file-earmark-text me-1"></i> View Order
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Allocation History -->
<div class="info-section">
    <div class="info-header">
        <i class="bi-clock-history fs-5"></i>
        <h5>Allocation History</h5>
    </div>
    <div class="info-content">
        <div class="table-responsive">
            <table class="allocation-history">
                <thead>
                    <tr>
                        <th>Assignment</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allocations as $allocation)
                    <tr>
                        <td>
                            @if($allocation?->office_id)
                                <div class="timeline-user">
                                    <div class="user-avatar">
                                        <i class="bi-building fs-5"></i>
                                    </div>
                                    <div class="user-info">
                                        <span class="user-name">Office Assignment</span>
                                        <span class="user-position">{{ $allocation?->office?->name ?? 'Unknown Office' }}</span>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">No assignment details</span>
                            @endif
                        </td>
                        <td>
                            <span class="allocation-type {{ $allocation?->type === 'Permanent' ? 'Permanent Allocation' : ($allocation?->type === 'Temporary' ? 'Temporary Allocation' : 'Pool') }}">
                                {{ $allocation?->type }} Office
                            </span>
                        </td>
                        <td>{{ $allocation?->start_date ? $allocation?->start_date->format('j M, Y') : 'N/A' }}</td>
                        <td>{{ $allocation?->end_date ? $allocation?->end_date->format('j M, Y') : 'Current' }}</td>
                        <td>{{ formatDuration($allocation?->start_date, $allocation?->end_date ?? now()) }}</td>
                        <td>
                            <span class="machinery-status {{ $allocation?->is_current ? 'functional' : 'condemned' }}">
                                {{ $allocation?->is_current ? 'Current' : 'Previous' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi-clock-history text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No allocation history available</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(!empty($machinery?->remarks))
<div class="info-section">
    <div class="info-header">
        <i class="bi-pencil-square fs-5"></i>
        <h5>Remarks</h5>
    </div>
    <div class="info-content">
        <p>{{ $machinery?->remarks }}</p>
    </div>
</div>
@endif
</div>
<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#print-machinery-details', function() {
            $(".machinery-details-container").printThis({
                pageTitle: "Machinery details",
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