@php
    $status = $row->status;
@endphp

<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewAny', App\Models\ConsultantHumanResource::class)
        <i class="hr-btn bi-people bg-light text-primary" title="Human Resource" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewAny', App\Models\ConsultantProject::class)
        <i class="projects-btn bi-kanban bg-light text-primary" title="Project" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>