@php
    $status = $row->status;
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>

    @if($status === 'new')
    <i class="relief-grant-btn bg-light text-success bi-hand-thumbs-up" title="Grant Relief" data-bs-toggle="tooltip"data-id="{{ $row->id }}"></i>
    <i class="relief-not-grant-btn bg-light text-warning bi-hand-thumbs-down" title="Relief cannot be granted" data-bs-toggle="tooltip"data-id="{{ $row->id }}"></i>
    <i class="dropped-btn bg-light text-danger bi-archive" title="Dropped" data-bs-toggle="tooltip"data-id="{{ $row->id }}"></i>
    @endif
</div>
