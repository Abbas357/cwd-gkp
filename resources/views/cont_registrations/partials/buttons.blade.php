@php
    $deferStatus = $row->defer_status;
    $approvalStatus = $row->approval_status;
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @if ($deferStatus < 3 && $approvalStatus !== 1)
        <i class="approve-btn bg-light text-success bi-check2-circle" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
        </i>
        <i class="defer-btn bg-light text-danger bi-ban" title="Defer" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
        </i>
    @endif
</div>