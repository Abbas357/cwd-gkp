<style>
    .asset-details-container {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .asset-gallery {
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
    
    .asset-status {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
    }
    
    .asset-status.functional {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .asset-status.non-functional {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    
    .asset-status.under-maintenance {
        background-color: #fff7cd;
        color: #854d0e;
    }
    
    .allotment-history {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    
    .allotment-history th,
    .allotment-history td {
        padding: 12px 16px;
        border: 1px solid #e5e7eb;
    }
    
    .allotment-history th {
        background-color: #f9fafb;
        font-weight: 600;
        text-align: left;
    }
    
    .allotment-type {
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .allotment-permanent {
        background-color: #dcfce7;
        color: #166534;
    }
    
    .allotment-temporary {
        background-color: #fff7cd;
        color: #854d0e;
    }
    
    .allotment-pool {
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
        .asset-gallery {
            display: none !important;
        }
    }
</style>
<!-- Print Button -->
<div class="d-flex justify-content-end">
    <button type="button" id="print-asset-details" class="btn btn-light btn-sm me-2 no-print">
        <i class="bi-printer me-1"></i> Print Details
    </button>
</div>
<div class="asset-details-container">
    <!-- Asset Gallery -->
    <div class="asset-gallery no-print">
        @php
            $galleryItems = [
                ['collection' => 'asset_front_pictures', 'label' => 'Front View'],
                ['collection' => 'asset_side_pictures', 'label' => 'Side View'],
                ['collection' => 'asset_rear_pictures', 'label' => 'Rear View'],
                ['collection' => 'asset_interior_pictures', 'label' => 'Interior View'],
            ];
            $hasImages = false;
        @endphp
    
        @foreach($galleryItems as $item)
            @if($asset?->hasMedia($item['collection']))
                @php $hasImages = true; @endphp
                <div class="gallery-item">
                    <img src="{{ $asset?->getFirstMediaUrl($item['collection']) }}" alt="{{ $item['label'] }}">
                    <div class="gallery-label">{{ $item['label'] }}</div>
                </div>
            @endif
        @endforeach
    
        @if(!$hasImages)
            <div class="d-flex align-items-center justify-content-center w-100 border rounded py-4">
                <div class="text-center">
                    <i class="bi-camera text-muted mb-2" style="font-size: 2rem;"></i>
                    <p class="text-muted mb-0">No images available for this asset</p>
                </div>
            </div>
        @endif
    </div>

<!-- Asset Information -->
<div class="info-section">
    <div class="info-header">
        <i class="bi-car-front fs-5"></i>
        <h5>Asset Information</h5>
    </div>
    <div class="info-content">
        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Brand & Model</span>
                <span class="info-value highlight">{{ $asset?->brand ?? 'Unknown' }} {{ $asset?->model ?? '' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Registration Number</span>
                <span class="info-value">{{ $asset?->registration_number ?? 'Not Registered' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Type</span>
                <span class="info-value">{{ $asset?->type ?? 'Not Specified' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Model Year</span>
                <span class="info-value">{{ $asset?->model_year ?? 'Unknown' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Color</span>
                <span class="info-value">{{ $asset?->color ?? 'Not Specified' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Fuel Type</span>
                <span class="info-value">{{ $asset?->fuel_type ?? 'Not Specified' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Chassis Number</span>
                <span class="info-value">{{ $asset?->chassis_number ?? 'Not Available' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Engine Number</span>
                <span class="info-value">{{ $asset?->engine_number ?? 'Not Available' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Status</span>
                <span class="asset-status {{ strtolower($asset?->functional_status ?? 'unknown') === 'functional' ? 'functional' : (strtolower($asset?->functional_status ?? '') === 'non-functional' ? 'non-functional' : 'under-maintenance') }}">
                    {{ $asset?->functional_status ?? 'Unknown' }}
                </span>
            </div>
            <div class="info-item">
                <span class="info-label">Registration Status</span>
                <span class="info-value">{{ $asset?->registration_status ?? 'Not Available' }}</span>
            </div>
        </div>
    </div>
</div>

@if($currentAllotment)
<div class="info-section">
    <div class="info-header">
        <i class="bi-person-check fs-5"></i>
        <h5>Current Allotment</h5>
    </div>
    <div class="info-content">
        <div class="info-grid">
            @if($currentAllotment?->type === 'Pool')
                <div class="info-item">
                    <span class="info-label">Allotment Type</span>
                    <span class="allotment-type allotment-pool">
                        {{ $currentAllotment?->type }} Asset
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Assigned To</span>
                    <div class="timeline-user mt-1">
                        <div class="user-avatar">
                            <i class="bi-building fs-5"></i>
                        </div>
                        <div class="user-info">
                            @if($currentAllotment?->office_id)
                                <span class="user-name">Office Pool</span>
                                <span class="user-position">{{ $currentAllotment?->office?->name ?? 'Office' }}</span>
                            @elseif($currentAllotment?->user_id)
                                <span class="user-name">Office Pool</span>
                                <span class="user-position">{{ $currentAllotment?->user?->currentPosting?->office?->name ?? 'Office' }}</span>
                                <small class="text-muted">(Managed by: {{ $currentAllotment?->user?->name ?? 'Unknown' }})</small>
                            @else
                                <span class="user-name">Department Pool</span>
                                <span class="user-position">General</span>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($currentAllotment?->user_id)
                <div class="info-item">
                    <span class="info-label">Allotment Type</span>
                    <span class="allotment-type {{ $currentAllotment?->type === 'Permanent' ? 'allotment-permanent' : 'allotment-temporary' }}">
                        {{ $currentAllotment?->type }} (Personal)
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Allotted To</span>
                    <div class="timeline-user mt-1">
                        <div class="user-avatar">
                            <img src="{{ getProfilePic($currentAllotment?->user) }}" alt="{{ $currentAllotment?->user?->name ?? 'User' }}">
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ $currentAllotment?->user?->name ?? 'Unknown' }}</span>
                            <span class="user-position">{{ $currentAllotment?->user?->currentPosting?->designation?->name ?? 'No Designation' }}</span>
                        </div>
                    </div>
                </div>
                <div class="info-item">
                    <span class="info-label">Office</span>
                    <span class="info-value">{{ $currentAllotment?->user?->currentPosting?->office?->name ?? 'No Office' }}</span>
                </div>
            @elseif($currentAllotment?->office_id)
                <div class="info-item">
                    <span class="info-label">Allotment Type</span>
                    <span class="allotment-type {{ $currentAllotment?->type === 'Permanent' ? 'allotment-permanent' : 'allotment-temporary' }}">
                        {{ $currentAllotment?->type }} (Office)
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Assigned To</span>
                    <div class="timeline-user mt-1">
                        <div class="user-avatar">
                            <i class="bi-building fs-5"></i>
                        </div>
                        <div class="user-info">
                            <span class="user-name">Office Assignment</span>
                            <span class="user-position">{{ $currentAllotment?->office?->name ?? 'Unknown Office' }}</span>
                        </div>
                    </div>
                </div>
            @endif
            
            <div class="info-item">
                <span class="info-label">Allotment Date</span>
                <span class="info-value">{{ $currentAllotment?->start_date ? $currentAllotment?->start_date->format('j F, Y') : 'Not Available' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Duration</span>
                <span class="info-value"> {{ formatDuration($currentAllotment?->start_date, now()) }}</span>
            </div>
            @if($currentAllotment?->hasMedia('asset_allotment_orders'))
            <div class="info-item">
                <span class="info-label">Allotment Order</span>
                <a href="{{ $currentAllotment?->getFirstMediaUrl('asset_allotment_orders') }}" target="_blank" class="btn btn-sm btn-outline-primary mt-1">
                    <i class="bi-file-earmark-text me-1"></i> View Order
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

<!-- Allotment History -->
<div class="info-section">
    <div class="info-header">
        <i class="bi-clock-history fs-5"></i>
        <h5>Allotment History</h5>
    </div>
    <div class="info-content">
        <div class="table-responsive">
            <table class="allotment-history">
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
                    @forelse($allotments as $allotment)
                    <tr>
                        <td>
                            @if($allotment?->type === 'Pool')
                                <div class="timeline-user">
                                    <div class="user-avatar">
                                        <i class="bi-building fs-5"></i>
                                    </div>
                                    <div class="user-info">
                                        @if($allotment?->office_id)
                                            <span class="user-name">Office Pool</span>
                                            <span class="user-position">{{ $allotment?->office?->name ?? 'Office' }}</span>
                                        @elseif($allotment?->user_id)
                                            <span class="user-name">Office Pool</span>
                                            <span class="user-position">{{ $allotment?->user?->currentPosting?->office?->name ?? 'Office' }}</span>
                                            <small class="text-muted">({{ $allotment?->user?->name ?? 'Unknown' }})</small>
                                        @else
                                            <span class="user-name">Department Pool</span>
                                            <span class="user-position">General</span>
                                        @endif
                                    </div>
                                </div>
                            @elseif($allotment?->user_id)
                                <div class="timeline-user">
                                    <div class="user-avatar">
                                        <img src="{{ getProfilePic($allotment?->user) }}" alt="{{ $allotment?->user?->name ?? 'User' }}">
                                    </div>
                                    <div class="user-info">
                                        <span class="user-name">{{ $allotment?->user?->name ?? 'Unknown' }}</span>
                                        <span class="user-position">{{ $allotment?->user?->currentPosting?->office?->name ?? 'No Office' }}</span>
                                    </div>
                                </div>
                            @elseif($allotment?->office_id)
                                <div class="timeline-user">
                                    <div class="user-avatar">
                                        <i class="bi-building fs-5"></i>
                                    </div>
                                    <div class="user-info">
                                        <span class="user-name">Office Assignment</span>
                                        <span class="user-position">{{ $allotment?->office?->name ?? 'Unknown Office' }}</span>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">No assignment details</span>
                            @endif
                        </td>
                        <td>
                            <span class="allotment-type {{ $allotment?->type === 'Permanent' ? 'allotment-permanent' : ($allotment?->type === 'Temporary' ? 'allotment-temporary' : 'allotment-pool') }}">
                                {{ $allotment?->type }}
                                @if($allotment?->type !== 'Pool')
                                    @if($allotment?->user_id)
                                        (Person)
                                    @elseif($allotment?->office_id)
                                        (Office)
                                    @endif
                                @endif
                            </span>
                        </td>
                        <td>{{ $allotment?->start_date ? $allotment?->start_date->format('j M, Y') : 'N/A' }}</td>
                        <td>{{ $allotment?->end_date ? $allotment?->end_date->format('j M, Y') : 'Current' }}</td>
                        <td>{{ formatDuration($allotment?->start_date, $allotment?->end_date ?? now()) }}</td>
                        <td>
                            <span class="asset-status {{ $allotment?->is_current ? 'functional' : 'non-functional' }}">
                                {{ $allotment?->is_current ? 'Current' : 'Previous' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="bi-clock-history text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">No allotment history available</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(!empty($asset?->remarks))
<div class="info-section">
    <div class="info-header">
        <i class="bi-pencil-square fs-5"></i>
        <h5>Remarks</h5>
    </div>
    <div class="info-content">
        <p>{{ $asset?->remarks }}</p>
    </div>
</div>
@endif
</div>
<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>

<script>
    $(document).ready(function() {
        $(document).on('click', '#print-asset-details', function() {
            $(".asset-details-container").printThis({
                pageTitle: "Asset details",
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