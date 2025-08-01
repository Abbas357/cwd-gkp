@can('update', $row)
    @if ($row->is_current)
        <div class="form-check form-switch" title="{{ $row->is_head ? 'Remove as Head' : 'Make Head' }}"
            data-bs-toggle="tooltip">
            <input class="form-check-input is-head-switch" type="checkbox" data-id="{{ $row->id }}"
                {{ $row->is_head ? 'checked' : '' }}>
        </div>
    @endif
@endcan
