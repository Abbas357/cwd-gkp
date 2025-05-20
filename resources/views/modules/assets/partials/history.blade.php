<style>
    .vehicle-info td, .vehicle-info th {
        padding: .5rem !important;
    }

    .vehicle-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 20px;
    }

    .vehicle-table th,
    .vehicle-table td {
        padding: 16px !important;
        border: 1px solid #e5e7eb;
    }

    .vehicle-table th {
        background-color: #f9fafb;
        color: #1e293b;
        font-weight: 600;
        text-align: left;
    }

    .vehicle-table td {
        background-color: white;
    }

    .timeline-user {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .timeline-user-icon {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50px;
        color: #64748b;
        font-size: 0.9em;
        overflow: hidden;
    }

    .timeline-user-icon img {
        width: 100%;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        font-size: 0.95em;
        color: #1e293b;
    }

    .user-designation {
        font-size: 0.8em;
        color: #64748b;
        letter-spacing: -0.2px;
    }

    .user-office {
        font-size: 0.8em;
        color: #64748b;
        letter-spacing: -0.2px;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-completed {
        background-color: #f3f4f6;
        color: #374151;
    }

    .timeline-status {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 0.75em;
        font-weight: 600;
        gap: 6px;
    }

    .badge-allotment {
        font-size: 0.85em;
        padding: 5px 10px;
        border-radius: 4px;
        display: inline-block;
        font-weight: 600;
    }

    .badge-assignment {
        font-size: 0.75em;
        padding: 3px 8px;
        border-radius: 4px;
        display: inline-block;
        margin-top: 4px;
        background-color: #f3f4f6;
        color: #4b5563;
    }
</style>

<main id="vehicle-history">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">{{ $asset->brand ?? 'Unknown Brand' }} ({{ $asset->model ?? 'Unknown Model' }})</h3>
        <button type="button" id="print-vehicle-history" class="no-print btn btn-light me-2 m-2">
            <span class="">
                <i class="bi-print"></i>
                Print
            </span>
        </button>
    </div>

    <div class="vehicle-history-header">
        <div class="vehicle-info-card d-flex align-items-start g-2">
            <div class="table-responsive flex-grow-1" style="flex-basis: 50%;">
                <table class="table vehicle-info table-striped table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th>Reg. No:</th>
                            <td>{{ $asset->registration_number ?? 'Pending Registration' }}</td>
                            <th>Chassis No:</th>
                            <td>{{ $asset->chassis_number ?? 'Not Available' }}</td>
                        </tr>
                        <tr>
                            <th>Type:</th>
                            <td>{{ $asset->type ?? 'Unspecified' }}</td>
                            <th>Year:</th>
                            <td>{{ $asset->model_year ?? 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <th>Color:</th>
                            <td>{{ $asset->color ?? 'Unspecified' }}</td>
                            <th>Fuel Type:</th>
                            <td>{{ $asset->fuel_type ?? 'Unspecified' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>{{ $asset->functional_status ?? 'Under Assessment' }}</td>
                            <th>Remarks:</th>
                            <td>{{ $asset->remarks ?? 'No remarks' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="no-print d-flex align-items-center overflow-auto" style="flex-basis: 50%; max-width: 50%; white-space: nowrap;">
                @php
                    $hasAnyImages = false;
                    $views = [
                        ['collection' => 'vehicle_front_pictures', 'label' => 'Front View'],
                        ['collection' => 'vehicle_side_pictures', 'label' => 'Side View'],
                        ['collection' => 'vehicle_rear_pictures', 'label' => 'Rear View'],
                        ['collection' => 'vehicle_interior_pictures', 'label' => 'Interior View'],
                    ];
                @endphp

                @foreach($views as $view)
                    @if($asset->hasMedia($view['collection']))
                        @php $hasAnyImages = true; @endphp
                        <div class="slide" style="height:150px; display: inline-block; position: relative; margin-right:10px;">
                            <img src="{{ $asset->getFirstMediaUrl($view['collection']) }}" alt="{{ $view['label'] }}" style="height:100%;">
                            <span style="position: absolute; top:10px; left:10px; background-color: rgba(0,0,0,0.5); color: white; padding:5px;">{{ $view['label'] }}</span>
                        </div>
                    @endif
                @endforeach

                @if(!$hasAnyImages)
                    <div class="text-center p-4 mt-2 w-100 border">
                        <i class="bi-camera text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted">No images available</p>
                    </div>
                @endif
            </div>
        </div>

        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Assignment</th>
                    <th>Allotment Type</th>
                    <th>Dates</th>
                    <th>Duration</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allotments as $allotment)
                <tr>
                    <td>
                        @if($allotment->type === 'Pool')
                            @if($allotment->office_id)
                                <div class="timeline-user">
                                    <div class="timeline-user-icon">
                                        <i class="bi-building fs-5"></i>
                                    </div>
                                    <div class="user-details">
                                        <span class="user-name">Office Pool</span>
                                        <span class="user-designation">{{ $allotment->office->name ?? 'Unknown Office' }}</span>
                                    </div>
                                </div>
                            @elseif($allotment->user_id)
                                <div class="timeline-user">
                                    <div class="timeline-user-icon">
                                        <img src="{{ getProfilePic($allotment->user) }}" alt="{{ $allotment->user?->name ?? 'User' }}">
                                    </div>
                                    <div class="user-details">
                                        <span class="user-name">Office Pool</span>
                                        <span class="user-designation">{{ $allotment->user->currentPosting?->office?->name ?? 'Unknown Office' }}</span>
                                        <small class="text-muted">(Manager: {{ $allotment->user->name ?? 'Unknown' }})</small>
                                    </div>
                                </div>
                            @else
                                <div class="timeline-user">
                                    <div class="timeline-user-icon">
                                        <img src="{{ asset('site/images/logo-square.png') }}" alt="C&W Department">
                                    </div>
                                    <div class="user-details">
                                        <span class="user-name">Department Pool</span>
                                        <span class="user-designation">C&W Department, Govt. of KP</span>
                                    </div>
                                </div>
                            @endif
                        @elseif($allotment->user_id)
                            <div class="timeline-user">
                                <div class="timeline-user-icon">
                                    <img src="{{ getProfilePic($allotment->user) }}" style="width:50px; height: 70px" alt="{{ $allotment->user?->name ?? 'User' }}">
                                </div>
                                <div class="user-details">
                                    <span class="user-name">{{ $allotment->user->name ?? 'Unknown User' }}</span>
                                    <span class="user-office">{{ $allotment->user->currentPosting?->office?->name ?? 'No Office' }}</span>
                                </div>
                            </div>
                        @elseif($allotment->office_id)
                            <div class="timeline-user">
                                <div class="timeline-user-icon">
                                    <i class="bi-building fs-5"></i>
                                </div>
                                <div class="user-details">
                                    <span class="user-name">Office Assignment</span>
                                    <span class="user-designation">{{ $allotment->office->name ?? 'Unknown Office' }}</span>
                                </div>
                            </div>
                        @else
                            <div class="timeline-user">
                                <div class="timeline-user-icon">
                                    <i class="bi-question-circle fs-5"></i>
                                </div>
                                <div class="user-details">
                                    <span class="user-name">Unspecified</span>
                                    <span class="user-designation">No assignment details</span>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div>
                            <span class="badge {{ match($allotment->type ?? 'Other') {
                                'Pool' => 'bg-primary',
                                'Temporary' => 'bg-warning text-dark',
                                'Permanent' => 'bg-success',
                                default => 'bg-secondary'
                            } }}">{{ $allotment->type ?? 'Other' }}</span>
                        </div>
                        
                        @if($allotment->type !== 'Pool')
                            <div>
                                @if($allotment->user_id)
                                    <span class="badge-assignment">Personal</span>
                                @elseif($allotment->office_id)
                                    <span class="badge-assignment">Office</span>
                                @endif
                            </div>
                        @elseif($allotment->type === 'Pool')
                            <div>
                                @if($allotment->office_id)
                                    <span class="badge-assignment">Office Pool</span>
                                @elseif($allotment->user_id)
                                    <span class="badge-assignment">Office Pool</span>
                                @else
                                    <span class="badge-assignment">Department Pool</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="timeline-date">
                            {{ \Carbon\Carbon::parse($allotment->start_date ?? now())->format('M d, Y') }}
                            @if(!empty($allotment->end_date))
                            - {{ \Carbon\Carbon::parse($allotment->end_date)->format('M d, Y') }}
                            @else
                            - Present
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="timeline-type">{{ formatDuration($allotment->start_date, $allotment->end_date ?? now()) }}</span>
                    </td>
                    <td>
                        <span class="timeline-status border {{ ($allotment->is_current ?? 0) === 1 ? 'status-active' : 'status-completed' }}">
                            @if(($allotment->is_current ?? 0) === 1)
                            <i class="bi-check-circle"></i> 
                            @else
                            <i class="fs-6 bi-arrow-left-square"></i>
                            @endif
                            {{ ($allotment->is_current ?? 0) === 1 ? 'Current' : 'Previous' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <i class="bi-clock-history text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No allotment history available for this vehicle</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script>
    $('#print-vehicle-history').on('click', () => {
        $("#vehicle-history").printThis({
            pageTitle: "Asset History",
            beforePrint() {
                document.querySelector('.page-loader').classList.remove('hidden');
            },
            afterPrint() {
                document.querySelector('.page-loader').classList.add('hidden');
            }
        });
    });
</script>