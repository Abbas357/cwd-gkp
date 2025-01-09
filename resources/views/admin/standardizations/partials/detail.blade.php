<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align:middle
    }
</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row standardization-details">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-4">Standardization Details</h3>
            <button type="button" id="print-standardization" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                <span class="d-flex align-items-center">
                    <i class="bi-print"></i>
                    Print
                </span>
            </button>
        </div>

        <table class="table table-bordered">
            <tr>
                <th class="table-cell">Product Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-product_name">{{ $standardization->product_name }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-product_name" value="{{ $standardization->product_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('product_name', {{ $standardization->id }})" />
                    <button id="save-btn-product_name" class="btn btn-sm btn-light d-none" onclick="updateField('product_name', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('product_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Specification Details</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-specification_details">{{ $standardization->specification_details }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-specification_details" value="{{ $standardization->specification_details }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('specification_details', {{ $standardization->id }})" />
                    <button id="save-btn-specification_details" class="btn btn-sm btn-light d-none" onclick="updateField('specification_details', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('specification_details')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Firm Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-firm_name">{{ $standardization->firm_name }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-firm_name" value="{{ $standardization->firm_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('firm_name', {{ $standardization->id }})" />
                    <button id="save-btn-firm_name" class="btn btn-sm btn-light d-none" onclick="updateField('firm_name', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('firm_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-address">{{ $standardization->address }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-address" value="{{ $standardization->address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('address', {{ $standardization->id }})" />
                    <button id="save-btn-address" class="btn btn-sm btn-light d-none" onclick="updateField('address', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Mobile Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-mobile_number">{{ $standardization->mobile_number }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-mobile_number" value="{{ $standardization->mobile_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mobile_number', {{ $standardization->id }})" />
                    <button id="save-btn-mobile_number" class="btn btn-sm btn-light d-none" onclick="updateField('mobile_number', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('mobile_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Phone Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-phone_number">{{ $standardization->phone_number }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-phone_number" value="{{ $standardization->phone_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('phone_number', {{ $standardization->id }})" />
                    <button id="save-btn-phone_number" class="btn btn-sm btn-light d-none" onclick="updateField('phone_number', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('phone_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-email">{{ $standardization->email }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-email" value="{{ $standardization->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $standardization->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">NTN Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-ntn_number">{{ $standardization->ntn_number }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-ntn_number" value="{{ $standardization->ntn_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('ntn_number', {{ $standardization->id }})" />
                    <button id="save-btn-ntn_number" class="btn btn-sm btn-light d-none" onclick="updateField('ntn_number', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('ntn_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Locality</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-locality">{{ $standardization->locality }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <select id="input-locality" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('locality', {{ $standardization->id }})">
                        <option value="Local" {{ $standardization->locality == 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Foreign" {{ $standardization->locality == 'Foreign' ? 'selected' : '' }}>Foreign</option>
                    </select>
                    <button id="save-btn-locality" class="btn btn-sm btn-light d-none" onclick="updateField('locality', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('locality')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Location Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-location_type">{{ $standardization->location_type }}</span>
                    @if (!in_array($standardization->status, ['approved', 'rejected']))
                    <select id="input-location_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('location_type', {{ $standardization->id }})">
                        <option value="Factory" {{ $standardization->location_type == 'Factory' ? 'selected' : '' }}>Factory</option>
                        <option value="Warehouse" {{ $standardization->location_type == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                    </select>
                    <button id="save-btn-location_type" class="btn btn-sm btn-light d-none" onclick="updateField('location_type', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('location_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Expiry Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-expiry_date">{{ $standardization->expiry_date }}</span>
                    @if ($standardization->status === 'approved')
                    <input type="date" id="input-expiry_date" value="{{ $standardization->expiry_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('expiry_date', {{ $standardization->id }})" />
                    <button id="save-btn-expiry_date" class="btn btn-sm btn-light d-none" onclick="updateField('expiry_date', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('expiry_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Issue Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-issue_date">{{ $standardization->issue_date }}</span>
                    @if ($standardization->status === 'approved')
                    <input type="date" id="input-issue_date" value="{{ $standardization->issue_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('issue_date', {{ $standardization->id }})" />
                    <button id="save-btn-issue_date" class="btn btn-sm btn-light d-none" onclick="updateField('issue_date', {{ $standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('issue_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
        </table>

        <div class="row mt-3 mx-1">
            @php
            $uploads = [
                'secp_certificates',
                'iso_certificates',
                'commerse_memberships',
                'pec_certificates',
                'annual_tax_returns',
                'audited_financials',
                'organization_registrations',
                'performance_certificate',
            ];
            @endphp
            <h3 class="mt-3">Attachments</h3>
            <table class="table table-bordered" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                        @if (!in_array($standardization->status, ['approved', 'rejected']))
                        <th class="no-print text-center">Add / Update Attachment</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="max-width: 200px">Firm Picture</td>
                        <td>
                            @if($standardization->hasMedia('firm_pictures'))
                            <a href="{{ $standardization->getFirstMediaUrl('firm_pictures') }}" target="_blank" title="Firm Picture" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        @if ($standardization->status === 'approved')
                        <td class="no-print text-center">
                            <label for="firm_pictures" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $standardization->hasMedia('firm_pictures') ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                            </label>
                            <input type="file" id="firm_pictures" name="firm_pictures" class="d-none file-input" data-collection="firm_pictures">
                        </td>
                        @endif
                    </tr>
                    @foreach($uploads as $upload)
                    <tr>
                        <td style="max-width: 200px">{{ str_replace('_', ' ', ucwords($upload)) }}</td>
                        <td>
                            @if($standardization->hasMedia($upload))
                            <a href="{{ $standardization->getFirstMediaUrl($upload) }}" target="_blank" title="{{ str_replace('_', ' ', ucwords($upload)) }}" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        @if (!in_array($standardization->status, ['approved', 'rejected']))
                        <td class="no-print text-center">
                            <label for="{{ $upload }}" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $standardization->hasMedia($upload) ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                            </label>
                            <input type="file" id="{{ $upload }}" name="{{ $upload }}" class="d-none file-input" data-collection="{{ $upload }}">
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</div>

<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        
        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 1 / 1.6471
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('file', file);
                formData.append('collection', input.dataset.collection);
                formData.append('id', "{{ $standardization->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.standardizations.uploadFile', ':id') }}".replace(':id', '{{ $standardization->id }}');
                try {
                    const result = await fetchRequest(url, 'POST', formData);
                    if (result) {
                        $(input).closest('.modal').modal('toggle');
                    }
                } catch (error) {
                    console.error('Error during form submission:', error);
                }
            }
        });
        
    })

    $('#print-standardization').on('click', () => {
        $(".standardization-details").printThis({
            pageTitle: "Standardization details of {{ $standardization->product_name }}"
        });
    });

    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#input-' + field + '~ .edit-button').addClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();
        const url = "{{ route('admin.standardizations.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data, 'Field updated successfully', 'Error updating field');
        if (success) {
            $('#text-' + field).text(newValue);
            $('#input-' + field).addClass('d-none');
            $('#input-' + field + '~ .edit-button').removeClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }

</script>
