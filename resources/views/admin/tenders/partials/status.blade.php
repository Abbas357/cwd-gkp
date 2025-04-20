@php
    $status = $row->status;
    
    $badgeClass = match ($status) {
        'draft' => 'text-bg-primary',
        'archived' => 'text-bg-warning',
        'published' => 'text-bg-success',
        default => 'text-bg-secondary',
    };
@endphp

<span class="badge {{ $badgeClass }}">{{ $status }}</span>
@if (!is_null($row->published_at))
    <span class="badge text-bg-info">{{ $row->published_at->format('j, F Y') }}</span>
@else
<span class="badge text-bg-danger">New</span>
@endif  