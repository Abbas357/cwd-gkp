@php
    $status = $row->status;
    $action_at = $row->action_at;
    
    $badgeClass = match ($status) {
        'new' => 'text-bg-primary',
        'relief-granted' => 'text-bg-success',
        'relief-not-granted' => 'text-bg-warning',
        'dropped' => 'text-bg-danger',
        default => 'text-bg-secondary',
    };
@endphp

<span class="badge {{ $badgeClass }}">{{ $status }}</span>
@if (!is_null($action_at))
    <span class="badge text-bg-info">{{ $action_at->format('j, F Y') }}</span>
@endif