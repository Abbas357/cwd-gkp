@php
    $status = $row->status;
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @if (!in_array($status, ['deffered_thrice', 'approved']))
        <i class="approve-btn bg-light text-success bi-check2-circle" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
        </i>
        <i class="defer-btn bg-light text-danger bi-ban" title="Defer" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
        </i>
    @endif
    @if ($status === 'approved')
        <i class="card-btn bi-credit-card bg-light text-info" title="Generate Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="renew-btn bi-arrow-clockwise bg-light text-primary" title="Renew Card" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>