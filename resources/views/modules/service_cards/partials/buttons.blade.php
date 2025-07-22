@php
    $approvalStatus = $row->approval_status;
    $cardStatus = $row->card_status;
    $isExpired = $row->isExpired();
    $canBeRenewed = $row->canBeRenewed();
@endphp

<div class="action-btns">
    {{-- View button available for all statuses --}}
        <i class="view-btn bi-eye bg-light text-primary" title="View Details" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    
    {{-- Draft status actions --}}
    @if ($approvalStatus === 'draft')
            <i class="verify-btn bg-light text-success bi-check-circle" title="Verify" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
            <i class="reject-btn bg-light text-danger bi-x-circle" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    
    {{-- Verified status actions --}}
    @if ($approvalStatus === 'verified')
            <i class="card-btn bi-credit-card bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        {{-- Active card actions --}}
        @if ($cardStatus === 'active' && !$isExpired)
                <i class="revoke-btn bi-slash-circle bg-light text-warning" title="Revoke Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
                <i class="mark-lost-btn bi-exclamation-triangle bg-light text-danger" title="Mark as Lost" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        
        {{-- Renewal action --}}
        @if ($canBeRenewed)
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        {{-- Lost card action --}}
        @if ($cardStatus === 'lost')
                <i class="reprint-btn bi-printer bg-light text-info" title="Reprint Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif
    
    {{-- Rejected status actions --}}
    @if ($approvalStatus === 'rejected')
        <i class="restore-btn bi-arrow-counterclockwise bg-light text-success" title="Restore to Draft" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    
    {{-- Print button for verified cards that have been printed --}}
    @if ($approvalStatus === 'verified' && $row->printed_at)
        <i class="print-btn bi-printer-fill bg-light text-secondary" title="Print Again" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>