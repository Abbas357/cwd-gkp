@php
    $status = $row->status;
@endphp

<div class="action-btns">
    @can('view', $row)
        <i class="view-btn bi-eye bg-light text-primary" title="View" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
    @endcan

    @if($status === 'new')
        @can('reliefGrant', $row)
            <i class="relief-grant-btn bg-light text-success bi-hand-thumbs-up" title="Grant Relief" data-bs-toggle="tooltip"data-id="{{ $row->id }}"></i>
        @endcan

        @can('reliefNotGrant', $row)
            <i class="relief-not-grant-btn bg-light text-warning bi-hand-thumbs-down" title="Relief cannot be granted" data-bs-toggle="tooltip"data-id="{{ $row->id }}"></i>
        @endcan

        @can('drop', $row)
            <i class="dropped-btn bg-light text-danger bi-archive" title="Dropped" data-bs-toggle="tooltip"data-id="{{ $row->id }}"></i>
        @endcan
    @endif
</div>
