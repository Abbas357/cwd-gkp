<div class="action-btns">
    @can('view', $row)
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewHistory', $row)
    <i class="history-btn bi-clock-history bg-light text-secondary" title="History" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('create', App\Models\MachineryAllocation::class)
    <i class="allocate-btn bg-light text-info bi-link" title="Allocate" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('delete', $row)
    <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>
