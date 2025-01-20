@php
    $status = $row->status;
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary"  title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    <i class="product-btn bi-cart bg-light text-secondary"  title="Product" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @if ($status === 'new')
        <i class="approve-btn bg-light text-success bi-check" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="reject-btn bg-light text-warning bi-ban" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
    @if ($status === 'approved')
        <i class="card-btn bi-credit-card bg-light text-info" title="Generate Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>    
    @endif
</div>