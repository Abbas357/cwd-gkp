@php
    $status = $row->status;
    $publishedAt = $row->published_at;
    $isAdmin = request()->user()->isAdmin();
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>

    @if($status !== 'archived')
        @if($status === 'draft')
            <i class="publish-btn bg-light text-success bi-check-circle" title="Publish" data-bs-toggle="tooltip" data-type="publish" data-id="{{ $row->id }}"></i>
            <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif

        @if($status === 'published' && !is_null($publishedAt))
            <i class="publish-btn bg-light text-warning bi-x-circle" title="Unpublish" data-bs-toggle="tooltip" data-type="unpublish" data-id="{{ $row->id }}"></i>
            <i class="archive-btn bi-archive bg-light text-secondary" title="Archive" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif
</div>
