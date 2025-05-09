<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    
    @if(!$row->is_active && auth()->user()->can('activate', $row))
        <i class="activate-btn bg-light text-success bi-check" title="Activate" data-bs-toggle="tooltip" data-type="activate" data-id="{{ $row->id }}"></i>
    @else
        <i class="activate-btn bg-light text-warning bi-x" title="De-Activate" data-bs-toggle="tooltip" data-type="deactivate" data-id="{{ $row->id }}"></i>
    @endif
    
    @can('delete', $row)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>
