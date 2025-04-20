@php
    $status = $row->status;
@endphp

<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary"  title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewAny', App\Models\Product::class)
        <i class="product-btn bi-cart bg-light text-secondary"  title="Product" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @if ($status === 'draft')
        @can('approve', $row)
            <i class="approve-btn bg-light text-success bi-check" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
        @can('reject', $row)
            <i class="reject-btn bg-light text-warning bi-ban" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
    @endif
    @if ($status === 'approved')
        @can('viewCard', $row)
            <i class="card-btn bi-credit-card bg-light text-info" title="Generate Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan
        @can('renew', $row)
            <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>    
        @endcan
    @endif
</div>