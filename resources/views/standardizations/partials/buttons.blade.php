@php
    $approvalStatus = $row->approval_status;
@endphp

<div class="action-btns">
    <i class="bi-eye bg-light text-primary" onclick="window.location.href = '{{ route('standardizations.show', $row->id) }}'" title="View" data-bs-toggle="tooltip"></i>
    @if ($approvalStatus !== 1)
        <i class="approve-btn bg-light text-success bi-check2-circle" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
        </i>
    @endif
</div>