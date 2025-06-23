<style>
    .machinery-info td, .machinery-info th {
        padding: .5rem !important;
    }

    .machinery-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 20px;
    }

    .machinery-table th,
    .machinery-table td {
        padding: 16px !important;
        border: 1px solid #e5e7eb;
    }

    .machinery-table th {
        background-color: #f9fafb;
        color: #1e293b;
        font-weight: 600;
        text-align: left;
    }

    .machinery-table td {
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

<main id="machinery-history">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="m-0">{{ $machinery->type }} ({{ $machinery->brand }})</h3>
        <button type="button" id="print-machinery-history" class="no-print btn btn-light me-2 m-2">
            <span class="">
                <i class="bi-print"></i>
                Print
            </span>
        </button>
    </div>

    <div class="machinery-history-header">
        <div class="machinery-info-card d-flex align-items-start g-2">
            <div class="table-responsive flex-grow-1" style="flex-basis: 50%;">
                <table class="table machinery-info table-striped table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th>Engine No:</th>
                            <td>{{ $machinery->engine_number }}</td>
                            <th>Model Year:</th>
                            <td>{{ $machinery->model }}</td>
                        </tr>
                        <tr>
                            <th>Type:</th>
                            <td>{{ $machinery->type }}</td>
                            <th>Model Year:</th>
                            <td>{{ $machinery->model_year }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>{{ $machinery->functional_status }}</td>
                            <th>Remarks:</th>
                            <td>{{ $machinery->remarks }}</td>
                        </tr>
                        @if($machinery->allocation)
                            <tr>
                                <th>Allocated for</th>
                                <td colspan="3">
                                    <table class="table mb-0">
                                        <tbody>
                                            <tr>
                                                <th>Allocation Type</th>
                                                <td>{{ $machinery->allocation->type }}</td>
                                            </tr>
                                            <tr>
                                                <th>Office</th>
                                                <td>{{ $machinery?->allocation?->office?->name ?? "No Office" }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
            <div class="no-print d-flex align-items-center overflow-auto" style="flex-basis: 50%; max-width: 50%; white-space: nowrap;">
                @foreach([
                    ['collection' => 'machinery_front_pictures', 'label' => 'Front View'],
                    ['collection' => 'machinery_side_pictures', 'label' => 'Side View'],
                ] as $view)
                    @if($machinery->hasMedia($view['collection']))
                        <div class="slide" style="height:150px; display: inline-block; position: relative; margin-right:10px;">
                            <img src="{{ $machinery->getFirstMediaUrl($view['collection']) }}" alt="{{ $view['label'] }}" style="height:100%;">
                            <span style="position: absolute; top:10px; left:10px; background-color: rgba(0,0,0,0.5); color: white; padding:5px;">{{ $view['label'] }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <table class="machinery-table">
            <thead>
                <tr>
                    <th>Office</th>
                    <th>Allocation Type</th>
                    <th>Dates</th>
                    <th>Duration</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allocations as $allocation)
                <tr>
                    <td>
                        <div class="timeline-user">
                            <div class="user-details">
                                <span class="user-name">{{ $allocation?->office?->name ?? "C&W DEPARTMENT" }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ match($allocation->type) {
                            'Temporary' => 'bg-danger',
                            'Permanent' => 'bg-success',
                            default => 'bg-secondary'
                        } }}">{{ $allocation->type }}</span>
                    </td>
                    <td>
                        <span class="timeline-date">
                            {{ \Carbon\Carbon::parse($allocation->start_date)->format('M d, Y') }}
                            @if($allocation->end_date)
                            - {{ \Carbon\Carbon::parse($allocation->end_date)->format('M d, Y') }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <span class="timeline-type">
                            @php
                                $startDate = \Carbon\Carbon::parse($allocation->start_date);
                                $endDate = $allocation->end_date ? \Carbon\Carbon::parse($allocation->end_date) : now();
                                $duration = $startDate->diffForHumans($endDate, ['parts' => 2, 'short' => false, 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]);
                            @endphp
                            {{ $duration }}
                        </span>
                    </td>
                    <td>
                        <span class="timeline-status border {{ $allocation->is_current === 1 ? 'status-active' : 'status-completed' }}">
                            @if($allocation->is_current === 1)
                            <i class="bi-check-circle"></i>
                            @else
                            <i class="fs-6 bi-arrow-left-square"></i>
                            @endif
                            {{ $allocation->is_current === 1 ? 'Current' : 'Returned' }}
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
    $('#print-machinery-history').on('click', () => {
        $("#machinery-history").printThis({
            pageTitle: "Machinery History",
            beforePrint() {
                document.querySelector('.page-loader').classList.remove('hidden');
            },
            afterPrint() {
                document.querySelector('.page-loader').classList.add('hidden');
            }
        });
    });
</script>