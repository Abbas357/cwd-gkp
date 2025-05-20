<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewHistory', $row)
        <i class="history-btn bi-clock-history bg-light text-secondary" title="History" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('create', App\Models\AssetAllotment::class)
        <i class="allot-btn bg-light text-info bi-link" title="Allot" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('delete', $row)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete (Admin)" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>
