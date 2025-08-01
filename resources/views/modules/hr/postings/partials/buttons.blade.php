<div class="action-btns">    
    @can('end', $row)
        @if($row->is_current)
            <i class="end-posting-btn bg-light text-warning bi-stop-circle" 
               title="End Posting" 
               data-bs-toggle="tooltip" 
               data-id="{{ $row->id }}"></i>
        @endif
    @endcan
    
    @can('delete', $row)
        <i class="delete-btn bg-light text-danger bi-trash" 
           title="Delete" 
           data-bs-toggle="tooltip" 
           data-id="{{ $row->id }}"></i>
    @endcan
</div>