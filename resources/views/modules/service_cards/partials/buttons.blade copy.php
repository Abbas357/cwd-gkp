@php
    $approvalStatus = $row->approval_status;
    $cardStatus = $row->card_status;
    $isExpired = $row->isExpired();
    $canBeRenewed = $row->canBeRenewed();
@endphp

{{-- <div class="action-btns">
    {{-- View button available for all statuses --}}
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View Details" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    
    {{-- Draft status actions --}}
    @if ($approvalStatus === 'draft')
        @can('verify', $row)
            <i class="verify-btn bg-light text-success bi-check-circle" title="Verify" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
        @can('reject', $row)
            <i class="reject-btn bg-light text-danger bi-x-circle" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
    @endif
    
    {{-- Verified status actions --}}
    @if ($approvalStatus === 'verified')
        @can('viewCard', $row)
            <i class="card-btn bi-credit-card bg-light text-info" title="View Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
        
        {{-- Active card actions --}}
        @if ($cardStatus === 'active' && !$isExpired)
            @can('revoke', $row)
                <i class="revoke-btn bi-slash-circle bg-light text-warning" title="Revoke Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
            @endcan
            @can('markLost', $row)
                <i class="mark-lost-btn bi-exclamation-triangle bg-light text-danger" title="Mark as Lost" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
            @endcan
        @endif
        
        {{-- Renewal action --}}
        @if ($canBeRenewed)
            @can('renew', $row)
                <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
            @endcan
        @endif
        
        {{-- Lost card action --}}
        @if ($cardStatus === 'lost')
            @can('reprint', $row)
                <i class="reprint-btn bi-printer bg-light text-info" title="Reprint Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
            @endcan
        @endif
    @endif
    
    {{-- Rejected status actions --}}
    @if ($approvalStatus === 'rejected')
        @can('restore', $row)
            <i class="restore-btn bi-arrow-counterclockwise bg-light text-success" title="Restore to Draft" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan    
    @endif
    
    {{-- Print button for verified cards that have been printed --}}
    @if ($approvalStatus === 'verified' && $row->printed_at)
        @can('viewCard', $row)
            <i class="print-btn bi-printer-fill bg-light text-secondary" title="Print Again" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
    @endif
</div> --}}