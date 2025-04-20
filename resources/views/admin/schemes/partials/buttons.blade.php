<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>
