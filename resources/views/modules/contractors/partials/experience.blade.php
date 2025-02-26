<div class="table-responsive">
    <table class="table table-experience table-bordered">
        <thead>
            <tr>
                <th>ADP Number</th>
                <th>Project Name</th>
                <th>Project Cost</th>
                <th>Commencement Date</th>
                <th>Completion Date</th>
                <th>Project Status</th>
                <th>Status</th>
                <th>Documents</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($experiences as $experience)
            <tr data-id="{{ $experience->id }}">
                <td>
                    <span class="editable" data-field="adp_number" data-value="{{ $experience->adp_number }}">{{ $experience->adp_number }}</span>
                </td>
                <td>
                    <span class="editable" data-field="project_name" data-value="{{ $experience->project_name }}">{{ $experience->project_name }}</span>
                </td>
                <td>
                    <span class="editable number" data-field="project_cost" data-value="{{ $experience->project_cost }}">{{ number_format($experience->project_cost, 2) }}</span>
                </td>
                <td>
                    <span class="editable date" data-field="commencement_date" data-value="{{ $experience->commencement_date }}">{{ $experience->commencement_date }}</span>
                </td>
                <td>
                    <span class="editable date" data-field="completion_date" data-value="{{ $experience->completion_date }}">{{ $experience->completion_date }}</span>
                </td>
                <td>
                    <select class="form-control project-status-select" data-field="project_status">
                        <option value="completed" {{ $experience->project_status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="ongoing" {{ $experience->project_status === 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    </select>
                </td>
                <td>
                    <select class="form-control status-select" data-field="status">
                        <option value="draft" {{ $experience->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="rejected" {{ $experience->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="approved" {{ $experience->status === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </td>
                <td class="d-flex justify-content-center">
                    <input type="file" class="file-input p-0" data-id="{{ $experience->id }}" style="display: none;">
                    <button class="btn upload-btn"><i class="bi-pencil-square"></i></button>

                    @if($experience->getFirstMedia('contractor_work_orders'))
                    <div class="mt-2 files">
                        <a href="{{ $experience->getFirstMedia('contractor_work_orders')->getUrl() }}" target="_blank" class="badge bg-primary">
                            File
                        </a>
                    </div>
                    @endif
                </td>
                <td>
                    <form class="delete-experience-form" data-experience-id="{{ $experience->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-light border-0 delete-experience-btn" style="cursor: pointer;">
                            <i class="bi-trash fs-5" title="Delete Experience"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    .editable {
        padding: 5px;
        border-radius: 3px;
        cursor: pointer;
        min-height: 20px;
        display: block;
    }

    .table-work-experience th,
    .table-work-experience td {
        vertical-align: middle;
        white-space: nowrap;
        min-width: 10rem;
    }

    .editable:hover {
        background-color: #f8f9fa;
    }

    .editing {
        background-color: #fff;
        border: 1px solid #ced4da;
        padding: 0px;
    }
</style>

<script>
$(document).ready(function() {
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
        } else if (span.hasClass('number')) {
            input = $('<input>', {
                type: 'number',
                value: value,
                class: 'form-control',
                step: '0.01'
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
            const experienceId = span.closest('tr').data('id');

            $.ajax({
                url: `{{ route('module.contractors.experience.update', ':experienceId') }}`.replace(':experienceId', experienceId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    field: field,
                    value: newValue
                },
                success: function(response) {
                    if (response.success) {
                        if (span.hasClass('number')) {
                            span.html(Number(newValue).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                        } else {
                            span.html(newValue);
                        }
                        span.data('value', newValue);
                    } else {
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

    $('.status-select, .project-status-select').on('change', function() {
        const select = $(this);
        const experienceId = select.closest('tr').data('id');
        const field = select.data('field');
        const newValue = select.val();

        $.ajax({
            url: `{{ route('module.contractors.experience.update', ':experienceId') }}`.replace(':experienceId', experienceId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                field: field,
                value: newValue
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

    $('.upload-btn').on('click', function() {
        $(this).siblings('.file-input').click();
    });
    $('.file-input').each(function() {
        imageCropper({
            fileInput: this,
            aspectRatio: 3 / 4,
            onComplete: async function(file, input) {
                const experienceId = $(input).data('id');
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_method', 'PATCH');

                const url = '{{ route("admin.contractors.experience.upload", ":id") }}'.replace(':id', experienceId);

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
                    showMessage('File Updated')

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

    $(".table-experience").on('click', '.delete-experience-btn', async function() {
        const form = $(this).closest('.delete-experience-form');
        const experienceId = form.data('experience-id');
        const row = form.closest('tr');
        const url = `{{ route('module.contractors.experience.destroy', ':experienceId') }}`.replace(':experienceId', experienceId);
        
        const result = await confirmAction(`Do you want to delete this experience?`);
        
        if (result && result.isConfirmed) {
            const success = await fetchRequest(url, 'DELETE');
            if (success) {
                row.fadeOut(300, function() {
                    $(this).remove();
                    
                    if ($('.table-experience tbody tr').length === 0) {
                        $('.table-experience tbody').append(`
                            <tr>
                                <td colspan="9" class="text-center">No records found</td>
                            </tr>
                        `);
                    }
                });
            }
        }
    });

});
</script>