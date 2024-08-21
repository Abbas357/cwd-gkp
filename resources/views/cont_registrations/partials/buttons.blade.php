@php
    $deferStatus = $row->defer_status;
    $approvalStatus = $row->approval_status;
@endphp

<div class="action-btns">
    <a class="badge bg-secondary" href="{{ route('registrations.show', $row->id) }}">
        VIEW
    </a>
    @if ($deferStatus < 3 && $approvalStatus !== 1)
        <span class="defer-btn badge bg-danger" data-id="{{ $row->id }}">
            DEFER ({{ $deferStatus }})
        </span>
        <span class="approve-btn badge bg-success" data-id="{{ $row->id }}">
            APPROVE
        </span>
    @endif
</div>