@php
    $status = $row->card_status;
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary"  title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @if ($status === 'new')
        <i class="verify-btn bg-light text-success bi-check" title="Verify" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="reject-btn bg-light text-warning bi-x" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    @if ($status === 'verified')
        <i class="card-btn bi-credit-card bg-light text-info" title="Generate Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    @if ($status === 'rejected')
        <i class="restore-btn bi-arrow-repeat bg-light text-danger" title="Restore User" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>