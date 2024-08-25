@php
    $deferStatus = $row->defer_status;
    $approvalStatus = $row->approval_status;
@endphp

<div class="action-btns">
    <a href="{{ route('registrations.show', $row->id) }}">
        <span class="text-secondary bg-light border border-secondary material-symbols-outlined" title="View" data-bs-toggle="tooltip">
            visibility
        </span>
    </a>
    @if ($deferStatus < 3 && $approvalStatus !== 1)
        <span class="defer-btn text-danger border border-danger bg-light material-symbols-outlined" title="Defer" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
            thumb_down
        </span>
        <span class="approve-btn text-success border border-success bg-light material-symbols-outlined" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
            thumb_up
        </span>
    @endif
</div>