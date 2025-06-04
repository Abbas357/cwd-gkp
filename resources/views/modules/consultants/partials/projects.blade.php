<div class="table-responsive">
    <table class="table table-projects table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>ADP Number</th>
                <th>Scheme Code</th>
                <th>District</th>
                <th>Estimated Cost</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Assigned HR</th>
                <th>Status</th>
                @can('delete', App\Models\ConsultantProject::class)
                <th>Action</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $project)
            <tr data-id="{{ $project->id }}">
                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <span class="editable" data-field="name" data-value="{{ $project->name }}">{{ $project->name }}</span>
                    @else
                        {{ $project->name }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <span class="editable" data-field="adp_number" data-value="{{ $project->adp_number }}">{{ $project->adp_number }}</span>
                    @else
                        {{ $project->adp_number }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <span class="editable" data-field="scheme_code" data-value="{{ $project->scheme_code }}">{{ $project->scheme_code }}</span>
                    @else
                        {{ $project->scheme_code }}
                    @endcan
                </td>

                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <select class="form-control status-select" data-field="district_id">
                            @foreach($cat['districts'] as $district)
                                <option value="{{ $district->id }}" {{ $project->district->id === $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                    @else
                        {{ $project->district ? $project->district->name : 'N/A' }}
                    @endcan
                </td>

                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <span class="editable" data-field="estimated_cost" data-value="{{ $project->estimated_cost }}">{{ $project->estimated_cost }}</span>
                    @else
                        {{ $project->estimated_cost }}
                    @endcan
                </td>

                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <span class="editable" data-field="start_date" data-value="{{ $project->start_date }}">{{ $project->start_date }}</span>
                    @else
                        {{ $project->start_date }}
                    @endcan
                </td>

                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <span class="editable" data-field="end_date" data-value="{{ $project->end_date }}">{{ $project->end_date }}</span>
                    @else
                        {{ $project->end_date }}
                    @endcan
                </td>

                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <div class="hr-assignment-container">
                            <div class="assigned-hr-display" data-project-id="{{ $project->id }}">
                                @php
                                    $assignedHrIds = $project->getHrIds() ?? [];
                                    $assignedHrDesignations = [];
                                    if (!empty($assignedHrIds)) {
                                        $assignedHrDesignations = App\Models\ConsultantHumanResource::whereIn('id', $assignedHrIds)->pluck('designation')->toArray();
                                    }
                                @endphp
                                
                                @if(!empty($assignedHrDesignations))
                                    @foreach($assignedHrDesignations as $name)
                                        <span class="badge bg-primary me-1 mb-1">{{ $name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">No HR assigned</span>
                                @endif
                            </div>
                            
                            <select class="form-control hr-multiselect mt-1" multiple data-project-id="{{ $project->id }}" style="height: auto; min-height: 80px;">
                                @php
                                    $availableHr = App\Models\ConsultantHumanResource::where('consultant_id', $project->consultant_id)
                                        ->where('status', 'approved')
                                        ->get();
                                    $currentHrIds = $project->getHrIds() ?? [];
                                @endphp
                                @foreach($availableHr as $hr)
                                    <option value="{{ $hr->id }}" {{ in_array($hr->id, $currentHrIds) ? 'selected' : '' }}>
                                        {{ $hr->name }}{{ $hr->designation ? ' - ' . $hr->designation : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        @php
                            $assignedHrIds = $project->getHrIds() ?? [];
                            $assignedHrDesignations = [];
                            if (!empty($assignedHrIds)) {
                                $assignedHrDesignations = App\Models\ConsultantHumanResource::whereIn('id', $assignedHrIds)->pluck('designation')->toArray();
                            }
                        @endphp
                        
                        @if(!empty($assignedHrDesignations))
                            @foreach($assignedHrDesignations as $name)
                                <span class="badge bg-primary me-1 mb-1">{{ $name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">No HR assigned</span>
                        @endif
                    @endcan
                </td>
                
                <td>
                    @can('update', App\Models\ConsultantProject::class)
                        <select class="form-control status-select" data-field="status">
                            @foreach($cat['statuses'] as $status)
                                <option value="{{ $status }}" {{ $project->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    @else
                        {{ ucfirst($project->status) }}
                    @endcan
                </td>
                @can('delete', App\Models\ConsultantProject::class)
                <td>
                    <form class="delete-project-form" data-project-id="{{ $project->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-light border-0 delete-project-btn" style="cursor: pointer;">
                            <i class="bi-trash fs-5" title="Delete Project"></i>
                        </button>
                    </form>
                </td>
                @endcan
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->can('delete', App\Models\ConsultantProject::class) ? '10' : '9' }}" class="text-center">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    @can('update', App\Models\ConsultantProject::class)
    .editable {
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
        min-height: 20px;
        display: block;
    }

    .editable:hover {
        background-color: #f8f9fa;
    }

    .editing {
        background-color: #fff;
        border: 1px solid #ced4da;
        padding: 0px;
    }
    @endcan

    .table-projects th,
    .table-projects td {
        vertical-align: middle;
        white-space: nowrap;
        min-width: 10rem;
    }

    .hr-assignment-container {
        min-width: 200px;
    }

    .assigned-hr-display {
        margin-bottom: 5px;
        min-height: 25px;
    }

    .hr-multiselect {
        font-size: 0.875rem;
    }

    .hr-multiselect option {
        padding: 5px;
        margin: 2px 0;
    }

    .hr-multiselect option:checked {
        background: #007bff;
        color: white;
    }
</style>

<script>
$(document).ready(function() {
    @can('update', App\Models\ConsultantProject::class)
    $('.editable').on('click', function() {
        const span = $(this);
        const field = span.data('field');
        const value = span.data('value');
        const width = span.width();

        if (span.hasClass('editing')) {
            return;
        }

        const input = $('<input>', {
            type: 'text',
            value: value,
            class: 'form-control'
        });

        input.css('width', width + 'px');
        span.html(input);
        input.focus();
        span.addClass('editing');

        input.on('blur', function() {
            const newValue = $(this).val();
            const projectId = span.closest('tr').data('id');

            $.ajax({
                url: `{{ route('admin.apps.consultants.projects.update', ':projectId') }}`.replace(':projectId', projectId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    field: field,
                    value: newValue
                },
                success: function(response) {
                    if (response.success) {
                        showNotification(response.success);
                        span.html(newValue);
                        span.data('value', newValue);
                    } else {
                        alert('Update failed');
                        span.html(value);
                    }
                },
                error: function() {
                    alert('Update failed');
                    span.html(value);
                }
            });

            span.removeClass('editing');
        });

        // Handle Enter key
        input.on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                $(this).blur();
            }
        });

        // Handle Escape key
        input.on('keyup', function(e) {
            if (e.which === 27) { // Escape key
                span.html(value);
                span.removeClass('editing');
            }
        });
    });

    $('.status-select').on('change', function() {
        const select = $(this);
        const projectId = select.closest('tr').data('id');
        const newValue = select.val();
        const field = select.data('field');

        $.ajax({
            url: `{{ route('admin.apps.consultants.projects.update', ':projectId') }}`.replace(':projectId', projectId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                field: field,
                value: newValue
            },
            success: function(response) {
                if (response.success) {
                    showNotification(response.success);
                } else {
                    alert('Update failed');
                    select.val(select.data('original-value'));
                }
            },
            error: function() {
                alert('Update failed');
                select.val(select.data('original-value'));
            }
        });
    });

    // Store original values for selects
    $('.status-select').each(function() {
        $(this).data('original-value', $(this).val());
    });

    // HR Multi-Select Change Handler
    $('.hr-multiselect').on('change', function() {
        const select = $(this);
        const projectId = select.data('project-id');
        const selectedHrIds = select.val() || [];
        
        $.ajax({
            url: `{{ route('admin.apps.consultants.projects.update-hr-assignments', ':projectId') }}`.replace(':projectId', projectId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                hr_ids: selectedHrIds
            },
            success: function(response) {
                if (response.success) {
                    // Update the badge display
                    const displayContainer = select.siblings('.assigned-hr-display');
                    
                    if (response.hr_names && response.hr_names.length > 0) {
                        let badgesHtml = '';
                        response.hr_names.forEach(function(name) {
                            badgesHtml += `<span class="badge bg-primary me-1 mb-1">${name}</span>`;
                        });
                        displayContainer.html(badgesHtml);
                    } else {
                        displayContainer.html('<span class="text-muted">No HR assigned</span>');
                    }
                    
                    showNotification('HR assignments updated successfully');
                } else {
                    alert(response.message || 'Failed to update HR assignments');
                    // Revert selection on failure
                    select.val(select.data('original-value'));
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert(response.message || 'Failed to update HR assignments');
                // Revert selection on failure
                select.val(select.data('original-value'));
            }
        });
    });

    // Store original values for HR selects
    $('.hr-multiselect').each(function() {
        $(this).data('original-value', $(this).val());
    });
    @endcan

    @can('upload', App\Models\ConsultantProject::class)
    $('.upload-btn').on('click', function() {
        $(this).siblings('.file-input').click();
    });

    $('.file-input').each(function(key, value) {
        const collection = $(value).data('collection');
        imageCropper({
            fileInput: this,
            aspectRatio: 3 / 4,
            onComplete: async function(file, input) {
                const projectId = $(input).data('id');
                const formData = new FormData();
                formData.append('file', file);
                formData.append('collection', collection);
                formData.append('_method', 'PATCH');

                const url = '{{ route("admin.apps.consultants.projects.upload", ":id") }}'.replace(':id', projectId);

                const response = await fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    const viewButton = `
                        <div class="mt-2 files">
                            <a href="${result.fileUrl}" target="_blank" class="badge bg-primary">
                                Done
                            </a>
                        </div>
                    `;
                    showNotification('Files Updated');

                    const buttonContainer = $(input).closest('td').find('.mt-2');
                    if (buttonContainer.length) {
                        buttonContainer.replaceWith(viewButton);
                    } else {
                        $(input).closest('td').append(viewButton);
                    }
                } else {
                    console.error('Failed to upload file');
                }
            }
        });
    });
    @endcan

    @can('delete', App\Models\ConsultantProject::class)
    $(".table-projects").on('click', '.delete-project-btn', async function() {
        const form = $(this).closest('.delete-project-form');
        const projectId = form.data('project-id');
        const row = form.closest('tr');
        const url = `{{ route('admin.apps.consultants.projects.destroy', ':projectId') }}`.replace(':projectId', projectId);
        const result = await confirmAction(`Do you want to delete this project?`);
        if (result && result.isConfirmed) {
            const success = await fetchRequest(url, 'DELETE');
            if (success) {
                row.fadeOut(300, function() {
                    $(this).remove();
                    
                    if ($('.table-projects tbody tr').length === 0) {
                        $('.table-projects tbody').append(`
                            <tr>
                                <td colspan="{{ Auth::user()->can('delete', App\Models\ConsultantProject::class) ? '10' : '9' }}" class="text-center">No records found</td>
                            </tr>
                        `);
                    }
                });
            }
        }
    });
    @endcan
});
</script>