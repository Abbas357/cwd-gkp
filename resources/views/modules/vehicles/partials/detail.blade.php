<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">

<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>

<div class="row vehicles-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">

            <tr>
                <th class="table-cell">Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $vehicle->type }}</span>
                    @if (!in_array($vehicle->status, ['published', 'archived']))
                    <select id="input-type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('type', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_type'] as $type)
                        <option value="{{ $type->name }}" {{ $vehicle->type == $type->name ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Functional Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-functional_status">{{ $vehicle->functional_status }}</span>
                    @if (!in_array($vehicle->status, ['published', 'archived']))
                    <select id="input-functional_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('functional_status', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_functional_status'] as $functional_status)
                        <option value="{{ $functional_status->name }}" {{ $vehicle->functional_status == $functional_status->name ? 'selected' : '' }}>
                            {{ $functional_status->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-functional_status" class="btn btn-sm btn-light d-none" onclick="updateField('functional_status', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-functional_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('functional_status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Color</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-color">{{ $vehicle->color }}</span>
                    @if (!in_array($vehicle->status, ['published', 'archived']))
                    <select id="input-color" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('color', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_color'] as $color)
                        <option value="{{ $color->name }}" {{ $vehicle->color == $color->name ? 'selected' : '' }}>
                            {{ $color->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-color" class="btn btn-sm btn-light d-none" onclick="updateField('color', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-color" class="no-print btn btn-sm edit-button" onclick="enableEditing('color')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Registration Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-registration_number">{{ $vehicle->registration_number }}</span>
                    <input type="text" id="input-registration_number" value="{{ $vehicle->registration_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('registration_number', {{ $vehicle->id }})" />
                    <button id="save-btn-registration_number" class="btn btn-sm btn-light d-none" onclick="updateField('registration_number', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-registration_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('registration_number')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">Fuel Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-fuel_type">{{ $vehicle->fuel_type }}</span>
                    @if (!in_array($vehicle->status, ['published', 'archived']))
                    <select id="input-fuel_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('fuel_type', {{ $vehicle->id }})">
                        @foreach ($cat['fuel_type'] as $fuel_type)
                        <option value="{{ $fuel_type->name }}" {{ $vehicle->fuel_type == $fuel_type->name ? 'selected' : '' }}>
                            {{ $fuel_type->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-fuel_type" class="btn btn-sm btn-light d-none" onclick="updateField('fuel_type', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-fuel_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('fuel_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Brand</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-brand">{{ $vehicle->brand }}</span>
                    @if (!in_array($vehicle->status, ['published', 'archived']))
                    <select id="input-brand" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('brand', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_brand'] as $brand)
                        <option value="{{ $brand->name }}" {{ $vehicle->brand == $brand->name ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-brand" class="btn btn-sm btn-light d-none" onclick="updateField('brand', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-brand" class="no-print btn btn-sm edit-button" onclick="enableEditing('brand')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Registration Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                <span id="text-registration_status">{{ $vehicle->registration_status }}</span>
                <select id="input-registration_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('registration_status', {{ $vehicle->id }})">
                    @foreach ($cat['vehicle_registration_status'] as $registration_status)
                    <option value="{{ $registration_status->name }}" {{ $vehicle->registration_status == $registration_status->name ? 'selected' : '' }}>
                        {{ $registration_status->name }}
                    </option>
                    @endforeach
                </select>
                <button id="save-btn-registration_status" class="btn btn-sm btn-light d-none" onclick="updateField('registration_status', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                <button id="edit-btn-registration_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('registration_status')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">Remarks</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-remarks">{{ $vehicle->remarks }}</span>
                    <div class="mb-3 w-100">
                        <textarea name="remarks" id="input-remarks" class="form-control d-none" style="height:150px">{!! old('remarks', $vehicle->remarks) !!}</textarea>
                    </div>
                    <button id="save-btn-remarks" class="btn btn-sm btn-light d-none" onclick="updateField('remarks', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-remarks" class="no-print btn btn-sm edit-button" onclick="enableEditing('remarks')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            
        </table>
        
    </div>
</div>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script>
    
    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');

        if (field === 'content') {
            var textarea = $('#input-' + field);
            if (!textarea.data('summernote-initialized')) {
                textarea.summernote({
                    height: 300
                });
                textarea.data('summernote-initialized', true);
            }
        }
    }

    async function updateField(field, id) {
        const newValue = (field === 'content') ? $('#input-' + field).summernote('code') : $('#input-' + field).val();

        const url = "{{ route('admin.app.vehicles.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'content') {
                $('#text-' + field).html(newValue);
                $('#input-' + field).summernote('destroy');
                $('#input-' + field).data('summernote-initialized', false);
            } else {
                $('#text-' + field).text(newValue);
            }
            $('#input-' + field).addClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#edit-btn-' + field).removeClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }
</script>
