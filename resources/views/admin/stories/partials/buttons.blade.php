<div class="action-btns">
    @if(!$row->published_at && auth()->user()->can('publish', $row))
        <i class="publish-btn bg-light text-success bi-check-circle" title="Publish" data-bs-toggle="tooltip" data-type="publish" data-id="{{ $row->id }}"></i>
    @else
        <i class="publish-btn bg-light text-warning bi-archive" title="Unpublish" data-bs-toggle="tooltip" data-type="unpublish" data-id="{{ $row->id }}"></i>   
    @endif
    @can('delete', $row)
        <i class="delete-btn bi-dash-circle bg-light text-danger" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>