<div class="action-btns">
    @can('view', $row)
    <button class="view-logs-btn btn btn-sm btn-danger text-white border border-warning d-flex align-items-center g-3" title="View Logs" data-bs-toggle="tooltip" data-id="{{ $row->id }}"> <span class="text-xs bi-exclamation-circle"></span> &nbsp; Logs</button>
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('delete', $row)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>
