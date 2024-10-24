@if ($row->is_active)
    <span class="badge text-bg-info">Active</span>
@else
<span class="badge text-bg-danger">Inactive</span>
@endif