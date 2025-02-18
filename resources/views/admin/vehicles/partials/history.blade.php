<style>
    /* Timeline Styles */
    .timeline {
        position: relative;
        max-width: 1200px;
        margin: 0 auto;
        padding: 15px 0;
    }

    .timeline::after {
        content: '';
        position: absolute;
        width: 2px;
        background-color: #e5e7eb;
        top: 0;
        bottom: 0;
        left: 20px;
        z-index: 0;
    }

    .timeline-item {
        padding: 0 0 0 50px;
        position: relative;
        margin-bottom: 16px;
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        width: 16px;
        height: 16px;
        left: 13px;
        background-color: white;
        border: 3px solid #3b82f6;
        top: 50%;
        transform: translateY(-50%);
        border-radius: 50%;
        z-index: 2;
        transition: all 0.3s ease;
    }

    .timeline-item.active::after {
        background-color: #22c55e;
        border-color: #22c55e;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
    }

    .timeline-content {
        padding: 16px 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
        position: relative;
    }

    .timeline-content:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .timeline-main {
        flex: 1;
    }

    .timeline-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 6px;
    }

    .timeline-type {
        font-weight: 700;
        color: #3b82f6;
        font-size: 0.95em;
        letter-spacing: -0.2px;
        background: rgba(59, 130, 246, 0.1);
        padding: 4px 10px;
        border-radius: 20px;
    }

    .timeline-date {
        color: #94a3b8;
        font-size: 0.85em;
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
    }

    .timeline-user {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 180px;
    }

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
        transition: background 0.3s ease;
    }

    .timeline-status {
        display: inline-flex;
        align-items: center;
        padding: 4px 12px;
        border-radius: 16px;
        font-size: 0.75em;
        font-weight: 600;
        margin-left: auto;
        gap: 6px;
    }

    .status-active {
        background-color: #dcfce7;
        color: #166534;
    }

    .status-completed {
        background-color: #f3f4f6;
        color: #374151;
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

    .fas.fa-calendar-alt {
        font-size: 0.9em;
        opacity: 0.8;
    }

    /* Vehicle Information & Header Styles */
    .vehicle-history-header {
        margin-bottom: 20px;
    }

    .vehicle-info-card {
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .vehicle-info-card h3 {
        margin: 0 0 10px;
        color: #1e293b;
    }

    .vehicle-info-card p {
        margin: 4px 0;
        color: #64748b;
    }

    .timeline-history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 16px;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        font-weight: 600;
        color: #1e293b;
    }

    .timeline-history-col {
        flex: 1;
        text-align: center;
    }

    .table td, .table th {
        padding: .6rem !important;
    }

</style>

<main id="vehicle-history">
    <div class=" d-flex justify-content-between align-items-center">
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
                <table class="table table-striped table-bordered align-middle">
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
                @forelse($vehicle->getMedia('vehicle_pictures') as $index => $image)
                    <img src="{{ $image->getUrl() }}" class="g-2 mx-1 slide {{ $index === 0 ? 'active' : '' }}" alt="Vehicle Image {{ $index + 1 }}" style="height:150px; display: inline-block;">
                @empty
                    <div class="d-flex align-items-center justify-content-center w-100">
                        <p class="text-muted">No images available</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Timeline Columns Header -->
        <div class="timeline-history-header">
            <div class="timeline-history-col">Name</div>
            <div class="timeline-history-col">Allotment Type</div>
            <div class="timeline-history-col">Dates</div>
            <div class="timeline-history-col">Duration</div>
            <div class="timeline-history-col">Status</div>
        </div>
    </div>
    
    <!-- Timeline Items -->
    <div class="timeline">
        @foreach($allotments as $allotment)
        <div class="timeline-item {{ is_null($allotment->end_date) ? 'active' : '' }}">
            <div class="timeline-content">
                <!-- User Info -->
                @if($allotment->type !== 'Pool')
                    <div class="timeline-user">
                        <div class="timeline-user-icon">
                            <img src="{{ getProfilePic($allotment->user) }}" alt="{{ $allotment->user->name }}" style="width:45px; border-radius: 50px">
                        </div>
                        <div class="user-details">
                            <span class="user-name">{{ $allotment->user->name }}</span>
                            <span class="user-designation">{{ $allotment->user->position ?? 'N/A' }}</span>
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
                <!-- Allotment Type & Date -->
                <div class="timeline-main" style="min-width: 20rem">
                    <div class="timeline-header">
                        <span class="badge {{ match($allotment->type) {
                            'Pool' => 'bg-danger',
                            'Temporary' => 'bg-warning text-dark',
                            'Permanent' => 'bg-success',
                            default => 'bg-secondary'
                        } }}">{{ $allotment->type }}</span>
                        <span class="timeline-date">
                            <i class="fas fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($allotment->start_date)->format('M d, Y') }}
                            @if($allotment->end_date)
                            - {{ \Carbon\Carbon::parse($allotment->end_date)->format('M d, Y') }}
                            @endif
                        </span>
                    </div>
                </div>
    
                <!-- Duration -->
                <div class="timeline-main">
                    <div class="timeline-header">
                        <span class="timeline-type">{{ $allotment->duration }}</span>
                    </div>
                </div>
    
                <!-- Status -->
                <span class="timeline-status {{ is_null($allotment->end_date) ? 'status-active' : 'status-completed' }}">
                    @if(is_null($allotment->end_date))
                    <i class="fas fa-spinner fa-pulse"></i>
                    @else
                    <i class="fas fa-check-circle"></i>
                    @endif
                    {{ is_null($allotment->end_date) ? 'Active' : 'Completed' }}
                </span>
            </div>
        </div>
        @endforeach
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
