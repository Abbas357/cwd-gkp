<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align:middle
    }
</style>
<link href="{{ asset('plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
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
                    <span id="text-product_name">{{ $EStandardization->product_name }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-product_name" value="{{ $EStandardization->product_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('product_name', {{ $EStandardization->id }})" />
                    <button id="save-btn-product_name" class="btn btn-sm btn-light d-none" onclick="updateField('product_name', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('product_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Specification Details</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-specification_details">{{ $EStandardization->specification_details }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-specification_details" value="{{ $EStandardization->specification_details }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('specification_details', {{ $EStandardization->id }})" />
                    <button id="save-btn-specification_details" class="btn btn-sm btn-light d-none" onclick="updateField('specification_details', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('specification_details')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Firm Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-firm_name">{{ $EStandardization->firm_name }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-firm_name" value="{{ $EStandardization->firm_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('firm_name', {{ $EStandardization->id }})" />
                    <button id="save-btn-firm_name" class="btn btn-sm btn-light d-none" onclick="updateField('firm_name', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('firm_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-address">{{ $EStandardization->address }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-address" value="{{ $EStandardization->address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('address', {{ $EStandardization->id }})" />
                    <button id="save-btn-address" class="btn btn-sm btn-light d-none" onclick="updateField('address', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Mobile Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-mobile_number">{{ $EStandardization->mobile_number }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-mobile_number" value="{{ $EStandardization->mobile_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mobile_number', {{ $EStandardization->id }})" />
                    <button id="save-btn-mobile_number" class="btn btn-sm btn-light d-none" onclick="updateField('mobile_number', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('mobile_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Phone Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-phone_number">{{ $EStandardization->phone_number }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-phone_number" value="{{ $EStandardization->phone_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('phone_number', {{ $EStandardization->id }})" />
                    <button id="save-btn-phone_number" class="btn btn-sm btn-light d-none" onclick="updateField('phone_number', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('phone_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-email">{{ $EStandardization->email }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-email" value="{{ $EStandardization->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $EStandardization->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">NTN Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-ntn_number">{{ $EStandardization->ntn_number }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <input type="text" id="input-ntn_number" value="{{ $EStandardization->ntn_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('ntn_number', {{ $EStandardization->id }})" />
                    <button id="save-btn-ntn_number" class="btn btn-sm btn-light d-none" onclick="updateField('ntn_number', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('ntn_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Locality</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-locality">{{ $EStandardization->locality }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <select id="input-locality" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('locality', {{ $EStandardization->id }})">
                        <option value="Local" {{ $EStandardization->locality == 'Local' ? 'selected' : '' }}>Local</option>
                        <option value="Foreign" {{ $EStandardization->locality == 'Foreign' ? 'selected' : '' }}>Foreign</option>
                    </select>
                    <button id="save-btn-locality" class="btn btn-sm btn-light d-none" onclick="updateField('locality', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('locality')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Location Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-location_type">{{ $EStandardization->location_type }}</span>
                    @if (!in_array($EStandardization->status, [1,2]))
                    <select id="input-location_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('location_type', {{ $EStandardization->id }})">
                        <option value="Factory" {{ $EStandardization->location_type == 'Factory' ? 'selected' : '' }}>Factory</option>
                        <option value="Warehouse" {{ $EStandardization->location_type == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                    </select>
                    <button id="save-btn-location_type" class="btn btn-sm btn-light d-none" onclick="updateField('location_type', {{ $EStandardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('location_type')"><i class="bi-pencil fs-6"></i></button>
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
                        @if (!in_array($EStandardization->status, [1,2]))
                        <th class="no-print text-center">Add / Update Attachment</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploads as $upload)
                    <tr>
                        <td style="max-width: 200px">{{ str_replace('_', ' ', ucwords($upload)) }}</td>
                        <td>
                            @if($EStandardization->hasMedia($upload))
                            <a href="{{ $EStandardization->getFirstMediaUrl($upload) }}" target="_blank" title="{{ str_replace('_', ' ', ucwords($upload)) }}" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        @if (!in_array($EStandardization->status, [1,2]))
                        <td class="no-print text-center">
                            <label for="{{ $upload }}" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $EStandardization->hasMedia($upload) ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
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

<script src="{{ asset('plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        
        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 1 / 1.6471
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('file', file);
                formData.append('collection', input.dataset.collection);
                formData.append('id', "{{ $EStandardization->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('standardizations.uploadFile') }}"
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
            pageTitle: "Standardization details of {{ $EStandardization->product_name }}"
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
        const url = "{{ route('standardizations.updateField') }}";
        const data = {
            id: id
            , field: field
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
