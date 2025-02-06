@php
    $isAdmin = request()->user()->isAdmin();
@endphp

<div class="action-btns">
    <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @if($isAdmin)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete (Admin)" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>
