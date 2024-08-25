@php
    $deferStatus = $row->defer_status;
    $approvalStatus = $row->approval_status;
@endphp

<div class="action-btns">
    <a href="{{ route('registrations.show', $row->id) }}">
        <span class="text-primary material-symbols-outlined" title="View" data-bs-toggle="tooltip">
            visibility
        </span>
    </a>
    @if ($deferStatus < 3 && $approvalStatus !== 1)
        <span class="defer-btn text-danger material-symbols-outlined" title="Defer" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
            thumb_down
        </span>
        <span class="approve-btn text-success material-symbols-outlined" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
            task_alt
        </span>
    @endif
</div>