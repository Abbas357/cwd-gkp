@php
    $deferStatus = $row->defer_status;
    $approvalStatus = $row->approval_status;
@endphp

<div class="action-btns">
    <a href="{{ route('registrations.show', $row->id) }}">
        <span class="text-secondary border border-secondary icon icon-eye" title="View" data-bs-toggle="tooltip">
            visibility
        </span>
    </a>
    @if ($deferStatus < 3 && $approvalStatus !== 1)
        <span class="defer-btn border border-danger icon icon-thumb-down" title="Defer" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
        </span>
        <span class="approve-btn border border-success icon icon-thumb-up" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
        </span>
    @endif
</div>