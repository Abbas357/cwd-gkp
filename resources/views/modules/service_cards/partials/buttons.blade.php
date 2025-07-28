@php
    $approvalStatus = $row->approval_status;
    $cardStatus = $row->card_status;
    $isExpired = $row->isExpired();
    $canBeRenewed = $row->canBeRenewed();
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary" title="View Details" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    
    @if ($approvalStatus === 'draft')
        <i class="verify-btn bg-light text-success bi-check-circle" title="Verify" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="reject-btn bg-light text-danger bi-x-circle" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if ($approvalStatus === 'verified')
        
        {{-- Print button: only for verified status and when printed_at is null --}}
        @if ($row->printed_at === null && $cardStatus !== 'lost' && !$isExpired)
            <i class="print-btn bi-printer bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif

        {{-- Card button: only when printed_at is not null, card_status is active, and approval_status is verified --}}
        @if ($row->printed_at !== null && $cardStatus === 'active' || !$cardStatus === 'duplicate')
            <i class="card-btn bi-credit-card bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        
        @if ($cardStatus === 'active' && !$isExpired)
            <i class="mark-lost-btn bi-exclamation-triangle bg-light text-danger" title="Mark as Lost" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        
        @if ($canBeRenewed)
            <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        
        @if ($cardStatus === 'lost')
            <i class="reprint-btn bi-stack bg-light text-info" title="Reprint Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif
    
    @if ($approvalStatus === 'rejected')
        <i class="restore-btn bi-arrow-counterclockwise bg-light text-success" title="Restore to Draft" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>