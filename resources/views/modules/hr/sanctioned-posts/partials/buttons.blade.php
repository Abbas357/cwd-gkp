<div class="action-btns">
    @can('update', $row)
    <i class="edit-btn bg-light text-primary bi-pencil-square" title="Edit" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('delete', $row)
    <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>