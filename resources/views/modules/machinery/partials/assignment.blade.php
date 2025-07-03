@php
    $hasAllocation = $row->allocation !== null;
@endphp

@if(!$hasAllocation)
    <span class="badge bg-secondary">Unassigned</span>
@else
    <div>
        <div class="text-success">{{ $row->allocation?->office?->name ?? 'Unknown Office' }}</div>
        <span class="badge bg-warning badge-sm text-dark">Office Pool</span>
    </div>
@endif