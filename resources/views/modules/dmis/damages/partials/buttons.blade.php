<div class="action-btns">
    @can('view', $row)
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('delete', $row)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewAny', $row)
        <i class="view-logs bg-light text-info bi-clock-history" title="Damage Logs" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>
