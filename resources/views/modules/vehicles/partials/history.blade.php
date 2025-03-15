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

    /* Keeping your existing styles */
    .timeline-user-icon {
        background-color: #f1f5f9;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #64748b;
        font-size: 0.9em;
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
</style>

<main id="vehicle-history">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">{{ $vehicle->brand }} ({{ $vehicle->model }})</h3>
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
                            <td>{{ $vehicle->registration_number }}</td>
                            <th>Chassis No:</th>
                            <td>{{ $vehicle->chassis_number }}</td>
                        </tr>
                        <tr>
                            <th>Type:</th>
                            <td>{{ $vehicle->type }}</td>
                            <th>Year:</th>
                            <td>{{ $vehicle->model_year }}</td>
                        </tr>
                        <tr>
                            <th>Color:</th>
                            <td>{{ $vehicle->color }}</td>
                            <th>Fuel Type:</th>
                            <td>{{ $vehicle->fuel_type }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>{{ $vehicle->functional_status }}</td>
                            <th>Remarks:</th>
                            <td>{{ $vehicle->remarks }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="no-print d-flex align-items-center overflow-auto" style="flex-basis: 50%; max-width: 50%; white-space: nowrap;">
                @foreach([
                    ['collection' => 'vehicle_front_pictures', 'label' => 'Front View'],
                    ['collection' => 'vehicle_side_pictures', 'label' => 'Side View'],
                    ['collection' => 'vehicle_rear_pictures', 'label' => 'Rear View'],
                    ['collection' => 'vehicle_interior_pictures', 'label' => 'Interior View'],
                ] as $view)
                    @if($vehicle->hasMedia($view['collection']))
                        <div class="slide" style="height:150px; display: inline-block; position: relative; margin-right:10px;">
                            <img src="{{ $vehicle->getFirstMediaUrl($view['collection']) }}" alt="{{ $view['label'] }}" style="height:100%;">
                            <span style="position: absolute; top:10px; left:10px; background-color: rgba(0,0,0,0.5); color: white; padding:5px;">{{ $view['label'] }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <table class="vehicle-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Allotment Type</th>
                    <th>Dates</th>
                    <th>Duration</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allotments as $allotment)
                <tr>
                    <td>
                        @if($allotment->type !== 'Pool')
                            <div class="timeline-user">
                                <div class="timeline-user-icon">
                                    <img src="{{ getProfilePic($allotment->user) }}" alt="{{ $allotment->user->name }}" style="width:45px; border-radius: 50px">
                                </div>
                                <div class="user-details">
                                    <span class="user-name">{{ $allotment->user->name }}</span>
                                    <span class="user-designation">{{ $allotment->user->currentPosting->designation->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        @elseif($allotment->type === 'Pool' && !empty($allotment->user_id))
                            <div class="timeline-user">
                                <div class="timeline-user-icon">
                                    <img src="{{ getProfilePic($allotment->user) }}" alt="{{ $allotment->user->name }}" style="width:45px; border-radius: 50px">
                                </div>
                                <div class="user-details">
                                    <span class="user-name">Office Pool</span>
                                    <span class="user-designation">{{ $allotment->user->currentPosting->designation->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                        @else
                            <div class="timeline-user">
                                <div class="timeline-user-icon">
                                    <img src="{{ asset('site/images/logo-square.png') }}" alt="C&W Department" style="width:45px; border-radius: 50px">
                                </div>
                                <div class="user-details">
                                    <span class="user-name">C&W Department</span>
                                    <span class="user-designation">Govt. of Khyber Pakhtunkhwa</span>
                                </div>
                            </div>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ match($allotment->type) {
                            'Pool' => 'bg-danger',
                            'Temporary' => 'bg-warning text-dark',
                            'Permanent' => 'bg-success',
                            default => 'bg-secondary'
                        } }}">{{ $allotment->type }}</span>
                    </td>
                    <td>
                        <span class="timeline-date">
                            {{ \Carbon\Carbon::parse($allotment->start_date)->format('M d, Y') }}
                            @if($allotment->end_date)
                            - {{ \Carbon\Carbon::parse($allotment->end_date)->format('M d, Y') }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="timeline-type">{{ $allotment->duration }}</span>
                    </td>
                    <td>
                        <span class="timeline-status border {{ $allotment->is_current === 1 ? 'status-active' : 'status-completed' }}">
                            @if($allotment->is_current === 1)
                            <i class="bi-check-circle"></i> 
                            @else
                            <i class="fs-6 bi-arrow-left-square"></i>
                            @endif
                            {{ $allotment->is_current === 1 ? 'Current' : 'Returned' }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script>
    $('#print-vehicle-history').on('click', () => {
        $("#vehicle-history").printThis({
            pageTitle: "Vehicle History",
            beforePrint() {
                document.querySelector('.page-loader').classList.remove('hidden');
            },
            afterPrint() {
                document.querySelector('.page-loader').classList.add('hidden');
            }
        });
    });
</script>