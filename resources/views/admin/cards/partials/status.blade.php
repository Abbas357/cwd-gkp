@php
    $status = $row->status;   
    $badgeClass = match ($status) {
        'active' => 'text-bg-success',
        'expired' => 'text-bg-danger',
        default => 'text-bg-secondary',
    };
@endphp

<span class="badge {{ $badgeClass }}">{{ $status }}</span>
