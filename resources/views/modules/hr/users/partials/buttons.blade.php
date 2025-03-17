@php
    $isAdmin = request()->user()->isAdmin();
@endphp

<div class="action-btns">
    <i class="edit-btn bg-light text-primary bi-pencil-square" title="Edit" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    <a class="view-btn" href="{{ route('admin.apps.hr.users.employee', $row->uuid) }}" title="Employee Profile" data-bs-toggle="tooltip"><i class="bg-light text-info bi-eye"></i></a>
    @if($isAdmin)
        <i class="delete-btn bg-light text-danger bi-trash" title="Delete (Admin)" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endif
</div>
