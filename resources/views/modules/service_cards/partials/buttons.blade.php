@php
    $status = $row->status;
    $isExpired = $row->isExpired();
    $canBeRenewed = $row->canBeRenewed();
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary" title="View Details" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    
    @if ($status === 'draft')
        <i class="pending-btn bg-light text-info bi-hourglass" title="Pending" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'pending')
        <i class="verify-btn bg-light text-success bi-check-circle" title="Verify" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="reject-btn bg-light text-danger bi-x-circle" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'active')
        @if ($row->printed_at === null)
            <i class="print-btn bi-printer bg-light text-info" title="Print Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif

        @if ($row->printed_at !== null)
            <i class="card-btn bi-credit-card bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        
        @if (!$isExpired)
            <i class="mark-lost-btn bi-exclamation-triangle bg-light text-danger" title="Mark as Lost" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        
        @if ($canBeRenewed)
            <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif
    
    @if ($status === 'expired')
        @if ($canBeRenewed)
            <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif
    
    @if ($status === 'lost')
        <i class="duplicate-btn bi-stack bg-light text-info" title="Duplicate Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        
        @if ($canBeRenewed)
            <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif

    @if ($status === 'duplicate')
        @if ($row->printed_at === null)
            <i class="print-btn bi-printer bg-light text-info" title="Print Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif

        @if ($row->printed_at !== null)
            <i class="card-btn bi-credit-card bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif
    
    @if ($status === 'rejected')
        <i class="restore-btn bi-arrow-counterclockwise bg-light text-success" title="Restore to Draft" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @can('delete', $row)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>