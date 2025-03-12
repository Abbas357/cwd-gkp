@php
    $isAdmin = request()->user()->isAdmin();
@endphp
<div class="action-btns">
    <i class="end-posting-btn bg-light text-warning bi-stop-circle" title="End Posting" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @if($isAdmin)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>