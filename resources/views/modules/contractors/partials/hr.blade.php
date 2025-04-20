<div class="table-responsive">
    <table class="table table-hr table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Father Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>CNIC</th>
                <th>PEC No.</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Documents</th>
                @can('delete', App\Models\ContractorHumanResource::class)
                <th>Action</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($hr as $resource)
            <tr data-id="{{ $resource->id }}">
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="name" data-value="{{ $resource->name }}">{{ $resource->name }}</span>
                    @else
                        {{ $resource->name }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="father_name" data-value="{{ $resource->father_name }}">{{ $resource->father_name }}</span>
                    @else
                        {{ $resource->father_name }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="email" data-value="{{ $resource->email }}">{{ $resource->email }}</span>
                    @else
                        {{ $resource->email }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="mobile_number" data-value="{{ $resource->mobile_number }}">{{ $resource->mobile_number }}</span>
                    @else
                        {{ $resource->mobile_number }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="cnic_number" data-value="{{ $resource->cnic_number }}">{{ $resource->cnic_number }}</span>
                    @else
                        {{ $resource->cnic_number }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="pec_number" data-value="{{ $resource->pec_number }}">{{ $resource->pec_number }}</span>
                    @else
                        {{ $resource->pec_number }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="designation" data-value="{{ $resource->designation }}">{{ $resource->designation }}</span>
                    @else
                        {{ $resource->designation }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable" data-field="salary" data-value="{{ $resource->salary }}">{{ number_format($resource->salary, 2) }}</span>
                    @else
                        {{ number_format($resource->salary, 2) }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable date" data-field="start_date" data-value="{{ $resource->start_date }}">{{ $resource->start_date }}</span>
                    @else
                        {{ $resource->start_date }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <span class="editable date" data-field="end_date" data-value="{{ $resource->end_date }}">{{ $resource->end_date }}</span>
                    @else
                        {{ $resource->end_date }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ContractorHumanResource::class)
                        <select class="form-control status-select" data-field="status">
                            <option value="draft" {{ $resource->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="rejected" {{ $resource->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="approved" {{ $resource->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    @else
                        {{ ucfirst($resource->status) }}
                    @endcan
                </td>
                <td class="d-flex justify-content-center">
                    @can('upload', App\Models\ContractorHumanResource::class)
                        <input type="file" class="file-input p-0" data-id="{{ $resource->id }}" style="display: none;">
                        <button class="btn upload-btn"><i class="bi-pencil-square"></i></button>
                    @endcan

                    @if($resource->getFirstMedia('contractor_hr_resumes'))
                    <div class="mt-2 files">
                        <a href="{{ $resource->getFirstMedia('contractor_hr_resumes')->getUrl() }}" target="_blank" class="p-0">
                            File
                        </a>
                    </div>
                    @endif
                </td>
                @can('delete', App\Models\ContractorHumanResource::class)
                <td>
                    <form class="delete-hr-form" data-hr-id="{{ $resource->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-light border-0 delete-hr-btn" style="cursor: pointer;">
                            <i class="bi-trash fs-5" title="Delete HR User"></i>
                        </button>
                    </form>
                </td>
                @endcan
            </tr>
            @empty
            <tr>
                <td colspan="{{ Auth::user()->can('delete', App\Models\ContractorHumanResource::class) ? '13' : '12' }}" class="text-center">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<style>
    @can('update', App\Models\ContractorHumanResource::class)
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

    .table-hr th,
    .table-hr td {
        vertical-align: middle;
        white-space: nowrap;
        min-width: 10rem;
    }
</style>

<script>
    $(document).ready(function() {
        @can('update', App\Models\ContractorHumanResource::class)
        $('.editable').on('click', function() {
            const span = $(this);
            const field = span.data('field');
            const value = span.data('value');
            const width = span.width();

            if (span.hasClass('editing')) {
                return;
            }

            let input;
            if (span.hasClass('date')) {
                input = $('<input>', {
                    type: 'date',
                    value: value,
                    class: 'form-control'
                });
            } else {
                input = $('<input>', {
                    type: 'text',
                    value: value,
                    class: 'form-control'
                });
            }

            input.css('width', width + 'px');
            span.html(input);
            input.focus();
            span.addClass('editing');

            input.on('blur', function() {
                const newValue = $(this).val();
                const resourceId = span.closest('tr').data('id');

                $.ajax({
                    url: `{{ route('admin.apps.contractors.hr.update', ':resourceId') }}`.replace(':resourceId', resourceId),
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
        });

        $('.status-select').on('change', function() {
            const select = $(this);
            const resourceId = select.closest('tr').data('id');
            const newStatus = select.val();

            $.ajax({
                url: `{{ route('admin.apps.contractors.hr.update', ':resourceId') }}`.replace(':resourceId', resourceId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    field: 'status',
                    value: newStatus
                },
                success: function(response) {
                    if (!response.success) {
                        alert('Status update failed');
                        select.val(select.data('original-value'));
                    }
                },
                error: function() {
                    alert('Status update failed');
                    select.val(select.data('original-value'));
                }
            });
        });
        @endcan

        @can('upload', App\Models\ContractorHumanResource::class)
        $('.upload-btn').on('click', function() {
            $(this).siblings('.file-input').click();
        });

        $('.file-input').each(function() {
            imageCropper({
                fileInput: this,
                aspectRatio: 3 / 4,
                onComplete: async function(file, input) {
                    const resourceId = $(input).data('id');
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('_method', 'PATCH');

                    const url = '{{ route("admin.apps.contractors.hr.upload", ":id") }}'.replace(':id', resourceId);

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
                    showNotification('File Updated')

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

        @can('delete', App\Models\ContractorHumanResource::class)
        $("table").on('click', '.delete-hr-btn', async function() {
            const form = $(this).closest('.delete-hr-form');
            const hrId = form.data('hr-id');
            const row = form.closest('tr');
            const url = `{{ route('admin.apps.contractors.hr.destroy', ':hrId') }}`.replace(':hrId', hrId);
            const result = await confirmAction(`Do you want to delete this user?`);
            if (result && result.isConfirmed) {
                const success = await fetchRequest(url, 'DELETE');
                if (success) {
                    row.fadeOut(300, function() {
                        $(this).remove();
                        
                        if ($('.table-hr tbody tr').length === 0) {
                            $('.table-hr tbody').append(`
                                <tr>
                                    <td colspan="{{ Auth::user()->can('delete', App\Models\ContractorHumanResource::class) ? '13' : '12' }}" class="text-center">No records found</td>
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