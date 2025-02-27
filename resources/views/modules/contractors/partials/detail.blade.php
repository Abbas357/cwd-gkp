<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle
    }

</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row contractors-details">
    <div class="col-md-12">

        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4"></h2>
            <button type="button" id="print-registration" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                <span class="d-flex align-items-center">
                    <i class="bi-print"></i>
                    Print
                </span>
            </button>
        </div>

        <table class="table table-bordered">
            <tr>
                <th class="table-cell">Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-status" class="badge 
                        {{ $Contractor->status == 'active' ? 'bg-success' : '' }}
                        {{ $Contractor->status == 'blacklisted' ? 'bg-danger' : '' }}
                        {{ $Contractor->status == 'suspended' ? 'bg-warning' : '' }}
                        {{ $Contractor->status == 'dormant' ? 'bg-secondary' : '' }}">
                        {{ $Contractor->status }}
                    </span>
                    <select id="input-status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('status', {{ $Contractor->id }})">
                        @foreach($cat['status'] as $status)
                        <option value="{{ $status }}" {{ $Contractor->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-status" class="btn btn-sm btn-light d-none" onclick="updateField('status', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('status')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-name">{{ $Contractor->name }}</span>
                    <input type="text" id="input-name" value="{{ $Contractor->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $Contractor->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">CNIC Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-cnic">{{ $Contractor->cnic }}</span>
                    <input type="text" id="input-cnic" value="{{ $Contractor->cnic }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('cnic', {{ $Contractor->id }})" />
                    <button id="save-btn-cnic" class="btn btn-sm btn-light d-none" onclick="updateField('cnic', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('cnic')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-email">{{ $Contractor->email }}</span>
                    <input type="text" id="input-email" value="{{ $Contractor->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $Contractor->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Mobile Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-mobile_number">{{ $Contractor->mobile_number }}</span>
                    <input type="text" id="input-mobile_number" value="{{ $Contractor->mobile_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mobile_number', {{ $Contractor->id }})" />
                    <button id="save-btn-mobile_number" class="btn btn-sm btn-light d-none" onclick="updateField('mobile_number', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('mobile_number')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-address">{{ $Contractor->address }}</span>
                    <input type="text" id="input-address" value="{{ $Contractor->address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('address', {{ $Contractor->id }})" />
                    <button id="save-btn-address" class="btn btn-sm btn-light d-none" onclick="updateField('address', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('address')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-district">{{ $Contractor->district }}</span>
                    <select id="input-district" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('district', {{ $Contractor->id }})">
                        @foreach($cat['districts'] as $district)
                        <option value="{{ $district->name }}" {{ $Contractor->district == $district->name ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-district" class="btn btn-sm btn-light d-none" onclick="updateField('district', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('district')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Firm Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-firm_name">{{ $Contractor->firm_name }}</span>
                    <input type="text" id="input-firm_name" value="{{ $Contractor->firm_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('firm_name', {{ $Contractor->id }})" />
                    <button id="save-btn-firm_name" class="btn btn-sm btn-light d-none" onclick="updateField('firm_name', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('firm_name')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Password</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-password">*********</span>
                    <input type="text" id="input-password" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('password', {{ $Contractor->id }})" />
                    <button id="save-btn-password" class="btn btn-sm btn-light d-none" onclick="updateField('password', {{ $Contractor->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('password')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
        </table>

        <div class="row mt-3 mx-1">
            @php
            $uploads = [
                'contractor_pictures',
                'contractor_cnic_front',
                'contractor_cnic_back',
            ];
            @endphp
            <h3 class="mt-3">Attachments</h3>
            <table class="table table-bordered" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                        <th class="no-print text-center">Add / Update Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploads as $upload)
                    <tr>
                        <td style="max-width: 200px">{{ str_replace('_', ' ', ucwords($upload)) }}</td>
                        <td>
                            @if($Contractor->hasMedia($upload))
                            <a href="{{ $Contractor->getFirstMediaUrl($upload) }}" target="_blank" title="{{ str_replace('_', ' ', ucwords($upload)) }}" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        @if (!in_array($Contractor->status, ['deferred_three', 'approved']))
                        <td class="no-print text-center">
                            <label for="{{ $upload }}" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $Contractor->hasMedia($upload) ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
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
<script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
<script>
    $(document).ready(function() {

        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 3 / 4
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('file', file);
                formData.append('collection', input.dataset.collection);
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.apps.contractors.uploadFile', ':id') }}".replace(':id', '{{ $Contractor->id }}');
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

        $('#input-mobile_number').mask('0000-0000000', {
            placeholder: "____-_______"
        });

        $('#input-cnic').mask('00000-0000000-0', {
            placeholder: "_____-_______-_"
        });
    })

    $('#print-registration').on('click', () => {
        $(".contractors-details").printThis({
            pageTitle: "Details of {{ $Contractor->firm_name }}"
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
        const url = "{{ route('admin.apps.contractors.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data, 'Field updated successfully', 'Error updating field');
        if (success) {
            if(field !== 'password') {
                $('#text-' + field).text(newValue);
            }
            $('#input-' + field).addClass('d-none');
            $('#input-' + field + '~ .edit-button').removeClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }

</script>
