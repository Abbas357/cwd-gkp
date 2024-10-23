@php
    $status = $row->unsubscribe_token;
@endphp

@if (is_null($status))
    <span class="badge text-bg-warning">Unsubscribed {{ $row->unsubscribed_at->diffForHumans() }}</span>
@else
    <span class="badge text-bg-success">Subscribed {{ $row->subscribed_at->diffForHumans() }}</span>
@endif