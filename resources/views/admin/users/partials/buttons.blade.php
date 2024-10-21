<div class="action-btns">
    @if(!$row->is_active)
    <i class="activate-btn bg-light text-success bi-person-check" title="Activate" data-bs-toggle="tooltip" data-type="Activate" data-id="{{ $row->id }}"></i>
    @else
    <i class="activate-btn bg-light text-warning bi-person-x" title="De-Activate" data-bs-toggle="tooltip" data-type="Deactivate" data-id="{{ $row->id }}"></i>
    @endif
    <i class="edit-btn bg-light text-primary bi-pencil-square" title="Edit" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
    </i>
    <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}">
    </i>
</div>
