<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle
    }

</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
@php
    $canUpdate = auth()->user()->can('updateField', $consultant);
    $canUpload = auth()->user()->can('uploadFile', $consultant);
@endphp
<div class="row consultants-details">
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
                        {{ $consultant->status == 'draft' ? 'bg-warning' : '' }}
                        {{ $consultant->status == 'rejected' ? 'bg-danger' : '' }}
                        {{ $consultant->status == 'approved' ? 'bg-success' : '' }}">
                        {{ $consultant->status }}
                    </span>
                    @if($canUpdate)
                    <select id="input-status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('status', {{ $consultant->id }})">
                        @foreach($cat['status'] as $status)
                        <option value="{{ $status }}" {{ $consultant->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-status" class="btn btn-sm btn-light d-none" onclick="updateField('status', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-name">{{ $consultant->name }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-name" value="{{ $consultant->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $consultant->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-email">{{ $consultant->email }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-email" value="{{ $consultant->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $consultant->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Contact Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-contact_number">{{ $consultant->contact_number }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-contact_number" value="{{ $consultant->contact_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('contact_number', {{ $consultant->id }})" />
                    <button id="save-btn-contact_number" class="btn btn-sm btn-light d-none" onclick="updateField('contact_number', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('contact_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-address">{{ $consultant->address }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-address" value="{{ $consultant->address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('address', {{ $consultant->id }})" />
                    <button id="save-btn-address" class="btn btn-sm btn-light d-none" onclick="updateField('address', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Sector</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-sector">{{ $consultant->sector }}</span>
                    @if($canUpdate)
                    <select id="input-sector" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('sector', {{ $consultant->id }})">
                        @foreach($cat['sectors'] as $sector)
                        <option value="{{ $sector }}" {{ $consultant->sector == $sector ? 'selected' : '' }}>{{ $sector }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-sector" class="btn btn-sm btn-light d-none" onclick="updateField('sector', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('sector')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-district_id">{{ $consultant?->district?->name }}</span>
                    @if($canUpdate)
                    <select id="input-district_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('district_id', {{ $consultant->id }})">
                        @foreach($cat['districts'] as $district)
                        <option value="{{ $district->id }}" {{ $consultant->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-district_id" class="btn btn-sm btn-light d-none" onclick="updateField('district_id', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('district_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">PEC Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-pec_number">{{ $consultant->pec_number }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-pec_number" value="{{ $consultant->pec_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('pec_number', {{ $consultant->id }})" />
                    <button id="save-btn-pec_number" class="btn btn-sm btn-light d-none" onclick="updateField('pec_number', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('pec_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Password</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-password">*********</span>
                    @if($canUpdate)
                    <input type="text" id="input-password" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('password', {{ $consultant->id }})" />
                    <button id="save-btn-password" class="btn btn-sm btn-light d-none" onclick="updateField('password', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('password')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Remarks</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-remarks">{{ $consultant->remarks }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-remarks" value="{{ $consultant->remarks }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('remarks', {{ $consultant->id }})" />
                    <button id="save-btn-remarks" class="btn btn-sm btn-light d-none" onclick="updateField('remarks', {{ $consultant->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('remarks')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#input-contact_number').mask('0000-0000000', {
            placeholder: "____-_______"
        });

    })

    $('#print-registration').on('click', () => {
        $(".consultants-details").printThis({
            pageTitle: "Details of {{ $consultant->name }}"
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
        const url = "{{ route('admin.apps.consultants.updateField', ':id') }}".replace(':id', id);
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
