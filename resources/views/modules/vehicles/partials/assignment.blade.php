@php
    $hasAllotment = $row->allotment !== null;
    $isPersonal = $hasAllotment && $row->allotment->user_id !== null;
    $isOfficePool = $hasAllotment && $row->allotment->office_id !== null && $row->allotment->user_id === null;
    $assignmentType = $hasAllotment ? $row->allotment->type : null;
@endphp

@if(!$hasAllotment)
    <span class="badge bg-secondary">Unassigned</span>
@elseif($isPersonal)
    <div>
        <div class="text-primary">{{ $row->allotment?->user?->name }}</div>
        <div class="text-muted small">{{ $row->allotment?->user?->currentPosting?->office?->name ?? 'No Office' }}</div>
        <span class="badge bg-primary">Personal</span>
    </div>
@elseif($isOfficePool)
    <div>
        <div class="text-success">{{ $row->allotment?->office?->name ?? 'Unknown Office' }}</div>
        <span class="badge bg-warning badge-sm text-dark">Office Pool</span>
    </div>
@else
    <span class="badge bg-secondary">Not Assignment</span>
@endif

@if($assignmentType && !$isPersonal && !$isOfficePool)
    <span class="badge bg-dark">{{ $assignmentType }}</span>
@endif