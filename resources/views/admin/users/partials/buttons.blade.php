@php
    $isAdmin = request()->user()->isAdmin();
@endphp

<div class="action-btns">
    @if($row->status == 'Inactive')
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="activate-btn bg-light text-success bi-person-check" title="Activate" data-bs-toggle="tooltip" data-type="Activate" data-id="{{ $row->id }}"></i>
        <i class="archive-btn bi-archive bg-light text-secondary" title="Archive" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @elseif($row->status == 'Active')
        <i class="activate-btn bg-light text-warning bi-person-x" title="De-Activate" data-bs-toggle="tooltip" data-type="Deactivate" data-id="{{ $row->id }}"></i>
        <i class="archive-btn bi-archive bg-light text-secondary" title="Archive" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    @if($isAdmin)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete (Admin)" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif

    <i class="edit-btn bg-light text-primary bi-pencil-square" title="Edit" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
</div>
