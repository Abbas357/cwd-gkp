<div class="table-responsive">
    <table class="table table-products table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Specification Details</th>
                <th>Locality</th>
                <th>NTN Number</th>
                <th>Sale Tax Number</th>
                <th>Location Type</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Product Images</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr data-id="{{ $product->id }}">
                <td>
                    <span class="editable" data-field="name" data-value="{{ $product->name }}">{{ $product->name }}</span>
                </td>
                <td>
                    <span class="editable" data-field="specification_details" data-value="{{ $product->specification_details }}">
                        {{ $product->specification_details }}
                    </span>
                </td>
                <td>
                    <select class="form-control locality-select" data-field="locality">
                        <option value="Local" {{ $product->locality === 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Foreign" {{ $product->locality === 'Foreign' ? 'selected' : '' }}>Foreign</option>
                    </select>
                </td>
                <td>
                    <span class="editable" data-field="ntn_number" data-value="{{ $product->ntn_number }}">
                        {{ $product->ntn_number }}
                    </span>
                </td>
                <td>
                    <span class="editable" data-field="sale_tax_number" data-value="{{ $product->sale_tax_number }}">
                        {{ $product->sale_tax_number }}
                    </span>
                </td>
                <td>
                    <select class="form-control location-select" data-field="location_type">
                        <option value="Factory" {{ $product->location_type === 'Factory' ? 'selected' : '' }}>Factory</option>
                        <option value="Warehouse" {{ $product->location_type === 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                        <option value="Store" {{ $product->location_type === 'Store' ? 'selected' : '' }}>Store</option>
                        <option value="Distribution Center" {{ $product->location_type === 'Distribution Center' ? 'selected' : '' }}>Distribution Center</option>
                    </select>
                </td>
                <td>
                    <select class="form-control status-select" data-field="status">
                        <option value="new" {{ $product->status === 'new' ? 'selected' : '' }}>New</option>
                        <option value="approved" {{ $product->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $product->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </td>
                <td>
                    <span class="editable" data-field="remarks" data-value="{{ $product->remarks }}">
                        {{ $product->remarks }}
                    </span>
                </td>
                <td>
                    <div class="d-flex justify-content-center">
                        <input type="file" class="file-input p-0" data-id="{{ $product->id }}" style="display: none;">
                        <button class="btn upload-btn"><i class="bi-pencil-square"></i></button>
                
                        @if($product->getMedia('product_images'))
                            @foreach($product->getMedia('product_images') as $index => $doc)
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
                    <form class="delete-product-form" data-product-id="{{ $product->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="bg-light border-0 delete-product-btn" style="cursor: pointer;">
                            <i class="bi-trash fs-5" title="Delete Product"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center">No records found</td>
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

    .table-products th,
    .table-products td {
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
        if (field.includes('date')) {
            input = $('<input>', {
                type: 'datetime-local',
                value: value,
                class: 'form-control'
            });
        } else if (field === 'specification_details' || field === 'remarks') {
            input = $('<textarea>', {
                class: 'form-control',
                text: value
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
            const productId = span.closest('tr').data('id');
            const url = '{{ route("admin.apps.standardizations.product.update", ":id") }}'.replace(':id', productId);

            $.ajax({
                url: url,
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

    $('.status-select, .locality-select, .location-select').on('change', function() {
        const select = $(this);
        const productId = select.closest('tr').data('id');
        const field = select.data('field');
        const newValue = select.val();
        const url = '{{ route("admin.apps.standardizations.product.update", ":id") }}'.replace(':id', productId);

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                field: field,
                value: newValue
            },
            success: function(response) {
                if (!response.success) {
                    alert(`${field} update failed`);
                    select.val(select.data('original-value'));
                }
            },
            error: function() {
                alert(`${field} update failed`);
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
                const productId = $(input).data('id');
                const formData = new FormData();
                formData.append('file', file);
                formData.append('_method', 'PATCH');

                const url = '{{ route("admin.apps.standardizations.product.upload", ":id") }}'.replace(':id', productId);

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

    $(".table-products").on('click', '.delete-product-btn', async function() {
        const form = $(this).closest('.delete-product-form');
        const productId = form.data('product-id');
        const row = form.closest('tr');
        const url = '{{ route("admin.apps.standardizations.product.destroy", ":id") }}'.replace(':id', productId);
        
        const result = await confirmAction('Do you want to delete this product?');
        if (result && result.isConfirmed) {
            const success = await fetchRequest(url, 'DELETE');
            if (success) {
                row.fadeOut(300, function() {
                    $(this).remove();
                    
                    if ($('.table-products tbody tr').length === 0) {
                        $('.table-products tbody').append(`
                            <tr>
                                <td colspan="10" class="text-center">No records found</td>
                            </tr>
                        `);
                    }
                });
            }
        }
    });
});
</script>