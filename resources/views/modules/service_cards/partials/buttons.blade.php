@php
    $status = $row->status;
    $isExpired = $row->isExpired();
    $canBeRenewed = $row->canBeRenewed();
    $user = auth()->user();
@endphp

<div class="action-btns">
    @if ($user->can('view', $row))
        <i class="view-btn bi-eye bg-light text-primary" title="View Details" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    
    @if ($status === 'draft' && $user->can('pending', $row))
        <i class="pending-btn bg-light text-info bi-hourglass" title="Pending" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'pending' && $user->can('verify', $row))
        <i class="verify-btn bg-light text-success bi-check-circle" title="Verify" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'pending' && $user->can('reject', $row))
        <i class="reject-btn bg-light text-danger bi-x-circle" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'active' && $row->printed_at === null && $user->can('markPrinted', $row))
        <i class="print-btn bi-printer bg-light text-info" title="Print Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'active' && $row->printed_at !== null && $user->can('viewCard', $row))
        <i class="card-btn bi-credit-card bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
        
    @if ($status === 'active' && !$isExpired && $user->can('markLost', $row))
        <i class="mark-lost-btn bi-exclamation-triangle bg-light text-danger" title="Mark as Lost" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
        
    @if ($status === 'active' && $canBeRenewed && $user->can('renew', $row))
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    
    @if ($status === 'expired' && $canBeRenewed && $user->can('renew', $row))
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    
    @if ($status === 'lost' && $user->can('duplicate', $row))
        <i class="duplicate-btn bi-stack bg-light text-info" title="Duplicate Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
        
    @if ($status === 'lost' && $canBeRenewed && $user->can('renew', $row))
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'duplicate' && $row->printed_at === null && $user->can('markPrinted', $row))
        <i class="print-btn bi-printer bg-light text-info" title="Print Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($status === 'duplicate' && $row->printed_at !== null && $user->can('viewCard', $row))
        <i class="card-btn bi-credit-card bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    
    @if ($status === 'rejected' && $user->can('restore', $row))
        <i class="restore-btn bi-arrow-counterclockwise bg-light text-success" title="Restore to Draft" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($user->can('delete', $row))
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>