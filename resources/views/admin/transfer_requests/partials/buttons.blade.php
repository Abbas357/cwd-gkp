@php
    $status = $row->status;
    $user = auth()->user();
@endphp

<div class="action-btns">
    @if($status == 'Pending')
        @if($user->can('delete', $row))
            <i class="delete-btn bg-light text-danger bi-trash" title="Delete" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        @endif
        <i class="review-btn text-warning bi-hourglass-split" title="Mark as Under Review" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="approve-btn text-success bi-check-circle" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="reject-btn text-danger bi-x-circle" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        
    @elseif($status == 'Under Review')
        <i class="approve-btn text-success bi-check-circle" title="Approve" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        <i class="reject-btn text-danger bi-x-circle" title="Reject" data-bs-toggle="tooltip" data-id="{{ $row->id }}"></i>
        
    @elseif($status == 'Approved' || $status == 'Rejected')
        -
    @endif
</div>