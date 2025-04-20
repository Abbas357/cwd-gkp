@php
    $status = $row->status;
@endphp

<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewAny', App\Models\ContractorHumanResource::class)
        <i class="hr-btn bi-people bg-light text-primary" title="Human Resource" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewAny', App\Models\ContractorMachinery::class)
        <i class="machinery-btn bi-tools bg-light text-primary" title="Machinery" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
    @can('viewAny', App\Models\ContractorWorkExperience::class)
        <i class="experience-btn bi-trophy bg-light text-primary" title="Experience" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan
</div>