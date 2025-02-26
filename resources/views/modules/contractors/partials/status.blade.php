@php
    $status = $row->status;
    $statusUpdatedAt = $row->status_updated_at;
    
    $badgeClass = match ($status) {
        'active' => 'text-bg-success',
        'blacklisted' => 'text-bg-danger',
        'suspended' => 'text-bg-warning',
        'dormant' => 'text-bg-secondary',
        default => 'text-bg-success',
    };
@endphp

<span class="badge {{ $badgeClass }}">{{ $status }}</span>
@if (!is_null($statusUpdatedAt))
    <span class="badge text-bg-info">{{ $statusUpdatedAt->format('j, F Y') }}</span>
@else
<span class="badge text-bg-danger">New</span>
@endif