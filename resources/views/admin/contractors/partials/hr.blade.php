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
            </tr>
        </thead>
        <tbody>
            @forelse($hr as $resource)
                <tr data-id="{{ $resource->id }}">
                    <td>
                        <span 
                            class="editable" 
                            data-field="name"
                            data-value="{{ $resource->name }}"
                        >{{ $resource->name }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable" 
                            data-field="father_name"
                            data-value="{{ $resource->father_name }}"
                        >{{ $resource->father_name }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable" 
                            data-field="email"
                            data-value="{{ $resource->email }}"
                        >{{ $resource->email }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable" 
                            data-field="mobile_number"
                            data-value="{{ $resource->mobile_number }}"
                        >{{ $resource->mobile_number }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable" 
                            data-field="cnic_number"
                            data-value="{{ $resource->cnic_number }}"
                        >{{ $resource->cnic_number }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable" 
                            data-field="pec_number"
                            data-value="{{ $resource->pec_number }}"
                        >{{ $resource->pec_number }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable" 
                            data-field="designation"
                            data-value="{{ $resource->designation }}"
                        >{{ $resource->designation }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable" 
                            data-field="salary"
                            data-value="{{ $resource->salary }}"
                        >{{ number_format($resource->salary, 2) }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable date" 
                            data-field="start_date"
                            data-value="{{ $resource->start_date }}"
                        >{{ $resource->start_date }}</span>
                    </td>
                    <td>
                        <span 
                            class="editable date" 
                            data-field="end_date"
                            data-value="{{ $resource->end_date }}"
                        >{{ $resource->end_date }}</span>
                    </td>
                    <td>
                        <select class="form-control status-select" data-field="status">
                            <option value="draft" {{ $resource->status === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="rejected" {{ $resource->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="approved" {{ $resource->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </td>
                    <td class="d-flex justify-content-center">
                        <input type="file" 
                               class="file-input p-0" 
                               data-id="{{ $resource->id }}"
                               style="display: none;">
                        <button class="btn upload-btn"><i class="bi-pencil-square"></i></button>
                        
                        @if($resource->getFirstMedia('contractor_hr_resumes'))
                            <div class="mt-2">
                                <a href="{{ $resource->getFirstMedia('contractor_hr_resumes')->getUrl() }}" target="_blank" class="p-0">
                                    <i class="bi-eye"></i>
                                </a>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">No records found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<style>
.editable {
    padding: 5px;
    border-radius: 3px;
    cursor: pointer;
    min-height: 20px;
    display: block;
}
.table-hr th, .table-hr td {
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

<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Inline editing functionality
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
            
            // Make AJAX call to update
            $.ajax({
                url: `{{ route('admin.contractors.hr.update', ':resourceId') }}`.replace(':resourceId', resourceId),
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
    
    // Status change handling
    $('.status-select').on('change', function() {
        const select = $(this);
        const resourceId = select.closest('tr').data('id');
        const newStatus = select.val();
        
        $.ajax({
            url: `{{ route('admin.contractors.hr.update', ':resourceId') }}`.replace(':resourceId', resourceId),
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
    
    // Initialize cropper for each file input
    $('.file-input').each(function() {
        imageCropper({
            fileInput: this,
            aspectRatio: 3 / 4,
            onComplete: async function(file, input) {
                const resourceId = $(input).data('id');
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_method', 'PATCH');
                
                const url = '{{ route("admin.contractors.hr.upload", ":id") }}'.replace(':id', resourceId);
                
                try {
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
                            <div class="mt-2">
                                <a href="${result.fileUrl}" target="_blank">
                                    <i class="bi-eye"></i>
                                </a>
                            </div>
                        `;
                        
                        const buttonContainer = $(input).closest('td').find('.mt-2');
                        if (buttonContainer.length) {
                            buttonContainer.replaceWith(viewButton);
                        } else {
                            $(input).closest('td').append(viewButton);
                        }
                        
                        console.success('File uploaded successfully');
                    } else {
                        console.error('Failed to upload file');
                    }
                } catch (error) {
                    console.error('Error during file upload:', error);
                    console.error('Failed to upload file');
                }
            }
        });
    });

});
</script>