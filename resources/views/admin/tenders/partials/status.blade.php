@php
    $status = $row->status;
    $publishedAt = $row->published_at;
    
    $badgeClass = match ($status) {
        'draft' => 'text-bg-primary',
        'archived' => 'text-bg-warning',
        'published' => 'text-bg-success',
        default => 'text-bg-secondary',
    };
@endphp

<span class="badge {{ $badgeClass }}">{{ $status }}</span>
@if (!is_null($publishedAt))
    <span class="badge text-bg-info">{{ $publishedAt->format('j, F Y') }}</span>
@else
<span class="badge text-bg-danger">New</span>
@endif  