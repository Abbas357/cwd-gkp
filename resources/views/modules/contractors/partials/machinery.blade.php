<div class="table-responsive">
    <table class="table table-machinery table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Number</th>
                <th>Model</th>
                <th>Registration</th>
                <th>Status</th>
                <th>Machinery Documents</th>
                <th>Machinery Pictures</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($machinery as $machine)
            <tr data-id="{{ $machine->id }}">
                <td>
                    <span class="editable" data-field="name" data-value="{{ $machine->name }}">{{ $machine->name }}</span>
                </td>
                <td>
                    <span class="editable" data-field="number" data-value="{{ $machine->number }}">{{ $machine->number }}</span>
                </td>
                <td>
                    <span class="editable" data-field="model" data-value="{{ $machine->model }}">{{ $machine->model }}</span>
                </td>
                <td>
                    <span class="editable" data-field="registration" data-value="{{ $machine->registration }}">{{ $machine->registration }}</span>
                </td>
                <td>
                    <select class="form-control status-select" data-field="status">
                        <option value="draft" {{ $machine->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="rejected" {{ $machine->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="approved" {{ $machine->status === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <input type="file" class="file-input p-0" data-collection="contractor_machinery_docs" data-id="{{ $machine->id }}" style="display: none;">
                        <button class="btn upload-btn"><i class="bi-pencil-square"></i></button>
                
                        @if($machine->getMedia('contractor_machinery_docs'))
                            @foreach($machine->getMedia('contractor_machinery_docs') as $index => $doc)
                            <div class="mt-2 files">
                                <a href="{{ $doc->getUrl() }}" target="_blank" class="m-1 badge bg-primary">
                                    {{ $index + 1 }}
                                </a>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <input type="file" class="file-input p-0" data-collection="contractor_machinery_pics" data-id="{{ $machine->id }}" style="display: none;">
                        <button class="btn upload-btn"><i class="bi-pencil-square"></i></button>
                        
                        @if($machine->getMedia('contractor_machinery_pics'))
                            @foreach($machine->getMedia('contractor_machinery_pics') as $index => $pic)
                            <div class="mt-2 files">
                                <a href="{{ $pic->getUrl() }}" target="_blank" class="m-1 badge bg-primary">
                                    {{ $index + 1 }}
                                </a>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </td>
                <td>
                    <form class="delete-machine-form" data-machine-id="{{ $machine->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-light border-0 delete-machine-btn" style="cursor: pointer;">
                            <i class="bi-trash fs-5" title="Delete Machinery"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No records found</td>
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

    .table-machinery th,
    .table-machinery td {
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
            const machineId = span.closest('tr').data('id');

            $.ajax({
                url: `{{ route('admin.app.contractors.machinery.update', ':machineId') }}`.replace(':machineId', machineId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    field: field,
                    value: newValue
                },
                success: function(response) {
                    if (response.success) {
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
        const machineId = select.closest('tr').data('id');
        const newStatus = select.val();

        $.ajax({
            url: `{{ route('admin.app.contractors.machinery.update', ':machineId') }}`.replace(':machineId', machineId),
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

    $('.upload-btn').on('click', function() {
        $(this).siblings('.file-input').click();
    });

    $('.file-input').each(function(key, value) {
        const collection = $(value).data('collection');
        imageCropper({
            fileInput: this,
            aspectRatio: 3 / 4,
            onComplete: async function(file, input) {
                const machineId = $(input).data('id');
                const formData = new FormData();
                formData.append('file', file);
                formData.append('collection', collection);
                formData.append('_method', 'PATCH');

                const url = '{{ route("admin.app.contractors.machinery.upload", ":id") }}'.replace(':id', machineId);

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
                    showMessage('Files Updated');

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

    $(".table-machinery").on('click', '.delete-machine-btn', async function() {
            const form = $(this).closest('.delete-machine-form');
            const machineId = form.data('machine-id');
            const row = form.closest('tr');
            const url = `{{ route('admin.app.contractors.machinery.destroy', ':machineId') }}`.replace(':machineId', machineId);
            const result = await confirmAction(`Do you want to delete this machinery?`);
            if (result && result.isConfirmed) {
                const success = await fetchRequest(url, 'DELETE');
                if (success) {
                    row.fadeOut(300, function() {
                        $(this).remove();
                        
                        if ($('.table-machinery tbody tr').length === 0) {
                            $('.table-machinery tbody').append(`
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