<div class="action-btns">
    @if(!$row->published_at)
        <i class="publish-btn bg-light text-success bi-check-circle" title="publish" data-bs-toggle="tooltip" data-type="publish" data-id="{{ $row->id }}"></i>
    @else
        <i class="publish-btn bg-light text-warning bi-archive" title="Unpublish" data-bs-toggle="tooltip" data-type="unpublish" data-id="{{ $row->id }}"></i>
    @endif
    <i class="delete-btn bi-dash-circle bg-light text-danger" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
</div>