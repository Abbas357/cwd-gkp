@php
    $status = $row->status;
    $user = auth()->user();
@endphp

<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @if($status !== 'archived')
        @can('response', $row)
            <i class="add-comment-btn bi-chat-left bg-light text-success" title="Response" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endcan

        @if($user->can('publish', $row) && $status === 'draft')
            <i class="publish-btn bg-light text-success bi-check-circle" title="Publish" data-bs-toggle="tooltip" data-type="publish" data-id="{{ $row->id }}"></i>
        @elseif($user->can('publish', $row) && $status === 'published')
            <i class="publish-btn bg-light text-warning bi-x-circle" title="Unpublish" data-bs-toggle="tooltip" data-type="unpublish" data-id="{{ $row->id }}"></i>
        @endif

        @if($user->can('delete', $row) && $status === 'draft' && is_null($row->published_at))
            <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif

        @if($user->can('archive', $row) && ($status === 'published' || ($status === 'draft' && !is_null($row->published_at))))
            <i class="archive-btn bi-archive bg-light text-secondary" title="Archive" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
    @endif
</div>