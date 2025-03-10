@props(['user'])

@if($user->currentPosting)
    <div class="d-flex flex-column">
        <span class="badge bg-primary mb-1">
            {{ $user->currentPosting->designation->name ?? 'Unknown Designation' }}
        </span>
        <span class="badge bg-secondary">
            {{ $user->currentPosting->office->name ?? 'Unknown Office' }}
        </span>
    </div>
@else
    <span class="badge bg-warning">No Active Posting</span>
@endif