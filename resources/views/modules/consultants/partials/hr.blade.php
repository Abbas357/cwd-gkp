<div class="table-responsive">
    <table class="table table-hr table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>CNIC Number</th>
                <th>PEC No.</th>
                <th>Designation</th>
                <th>Salary</th>
                <th>Start Date</th>
                <th>End Date</th>
                @can('delete', App\Models\ConsultantHumanResource::class)
                <th>Action</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($employees as $employee)
            <tr data-id="{{ $employee->id }}">
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable" data-field="name" data-value="{{ $employee->name }}">{{ $employee->name }}</span>
                    @else
                        {{ $employee->name }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable" data-field="email" data-value="{{ $employee->email }}">{{ $employee->email }}</span>
                    @else
                        {{ $employee->email }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable" data-field="contact_number" data-value="{{ $employee->contact_number }}">{{ $employee->contact_number }}</span>
                    @else
                        {{ $employee->contact_number }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable" data-field="cnic_number" data-value="{{ $employee->cnic_number }}">{{ $employee->cnic_number }}</span>
                    @else
                        {{ $employee->cnic_number }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable" data-field="pec_number" data-value="{{ $employee->pec_number }}">{{ $employee->pec_number }}</span>
                    @else
                        {{ $employee->pec_number }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable" data-field="designation" data-value="{{ $employee->designation }}">{{ $employee->designation }}</span>
                    @else
                        {{ $employee->designation }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable" data-field="salary" data-value="{{ $employee->salary }}">{{ number_format($employee->salary, 2) }}</span>
                    @else
                        {{ number_format($employee->salary, 2) }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable date" data-field="start_date" data-value="{{ $employee->start_date }}">{{ $employee->start_date }}</span>
                    @else
                        {{ $employee->start_date }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <span class="editable date" data-field="end_date" data-value="{{ $employee->end_date }}">{{ $employee->end_date }}</span>
                    @else
                        {{ $employee->end_date }}
                    @endcan
                </td>
                <td>
                    @can('update', App\Models\ConsultantHumanResource::class)
                        <select class="form-control status-select" data-field="status">
                            <option value="draft" {{ $employee->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="rejected" {{ $employee->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="approved" {{ $employee->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    @else
                        {{ ucfirst($employee->status) }}
                    @endcan
                </td>
                @can('delete', App\Models\ConsultantHumanResource::class)
                <td>
                    <form class="delete-hr-form" data-hr-id="{{ $employee->id }}" style="display:inline;">
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
                <td colspan="{{ Auth::user()->can('delete', App\Models\ConsultantHumanResource::class) ? '13' : '12' }}" class="text-center">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<style>
    @can('update', App\Models\ConsultantHumanResource::class)
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
        @can('update', App\Models\ConsultantHumanResource::class)
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
                const employeeId = span.closest('tr').data('id');

                $.ajax({
                    url: `{{ route('admin.apps.consultants.hr.update', ':employeeId') }}`.replace(':employeeId', employeeId),
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
            const employeeId = select.closest('tr').data('id');
            const newStatus = select.val();

            $.ajax({
                url: `{{ route('admin.apps.consultants.hr.update', ':employeeId') }}`.replace(':employeeId', employeeId),
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

        @can('upload', App\Models\ConsultantHumanResource::class)
        $('.upload-btn').on('click', function() {
            $(this).siblings('.file-input').click();
        });

        $('.file-input').each(function() {
            imageCropper({
                fileInput: this,
                aspectRatio: 3 / 4,
                onComplete: async function(file, input) {
                    const employeeId = $(input).data('id');
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('_method', 'PATCH');

                    const url = '{{ route("admin.apps.consultants.hr.upload", ":id") }}'.replace(':id', employeeId);

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

        @can('delete', App\Models\ConsultantHumanResource::class)
        $("table").on('click', '.delete-hr-btn', async function() {
            const form = $(this).closest('.delete-hr-form');
            const hrId = form.data('hr-id');
            const row = form.closest('tr');
            const url = `{{ route('admin.apps.consultants.hr.destroy', ':hrId') }}`.replace(':hrId', hrId);
            const result = await confirmAction(`Do you want to delete this user?`);
            if (result && result.isConfirmed) {
                const success = await fetchRequest(url, 'DELETE');
                if (success) {
                    row.fadeOut(300, function() {
                        $(this).remove();
                        
                        if ($('.table-hr tbody tr').length === 0) {
                            $('.table-hr tbody').append(`
                                <tr>
                                    <td colspan="{{ Auth::user()->can('delete', App\Models\ConsultantHumanResource::class) ? '13' : '12' }}" class="text-center">No records found</td>
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