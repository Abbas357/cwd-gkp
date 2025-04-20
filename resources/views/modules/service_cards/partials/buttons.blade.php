@php
    $status = $row->status;
@endphp

<div class="action-btns">
    @can('view', $row)
    <i class="view-btn bi-eye bg-light text-primary"  title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @if ($status === 'draft')
        @can('verify', $row)
            <i class="verify-btn bg-light text-success bi-check" title="Verify" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
        @can('reject', $row)
            <i class="reject-btn bg-light text-warning bi-x" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
    @endif
    @if ($status === 'verified')
        @can('viewCard', $row)
        <i class="card-btn bi-credit-card bg-light text-info" title="Generate Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
        @can('renew', $row)
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
    @endif
    @if ($status === 'rejected')
        @can('restore', $row)
            <i class="restore-btn bi-arrow-repeat bg-light text-danger" title="Restore User" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan    
    @endif
</div>