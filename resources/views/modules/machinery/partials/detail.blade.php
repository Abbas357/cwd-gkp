<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }

</style>
@php
$canUpdate = auth()->user()->can('updateField', $machinery);
@endphp
<div class="row machinery-details">
    <div class="col-md-12">
        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $machinery->type }}</span>
                    @if ($canUpdate)
                    <select id="input-type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('type', {{ $machinery->id }})">
                        @foreach (category('type', 'machinery') as $type)
                        <option value="{{ $type }}" {{ $machinery->type == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Functional Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-functional_status">{{ $machinery->functional_status }}</span>
                    @if ($canUpdate)
                    <select id="input-functional_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('functional_status', {{ $machinery->id }})">
                        @foreach ($statuses as $functional_status)
                        <option value="{{ $functional_status }}" {{ $machinery->functional_status == $functional_status ? 'selected' : '' }}>
                            {{ $functional_status }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-functional_status" class="btn btn-sm btn-light d-none" onclick="updateField('functional_status', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-functional_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('functional_status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Brand</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-brand">{{ $machinery->brand }}</span>
                    @if ($canUpdate)
                    <select id="input-brand" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('brand', {{ $machinery->id }})">
                        @foreach (category('brand', 'machinery') as $brand)
                        <option value="{{ $brand }}" {{ $machinery->brand == $brand ? 'selected' : '' }}>
                            {{ $brand }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-brand" class="btn btn-sm btn-light d-none" onclick="updateField('brand', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-brand" class="no-print btn btn-sm edit-button" onclick="enableEditing('brand')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Model</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-model">{{ $machinery->model }}</span>
                    @if ($canUpdate)
                    <select id="input-model" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('model', {{ $machinery->id }})">
                        @foreach (category('model', 'machinery') as $model)
                        <option value="{{ $model }}" {{ $machinery->model == $model ? 'selected' : '' }}>
                            {{ $model }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-model" class="btn btn-sm btn-light d-none" onclick="updateField('model', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-model" class="no-print btn btn-sm edit-button" onclick="enableEditing('model')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Model Year</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-model_year">{{ $machinery->model_year }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-model_year" value="{{ $machinery->model_year }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('model_year', {{ $machinery->id }})" />
                    <button id="save-btn-model_year" class="btn btn-sm btn-light d-none" onclick="updateField('model_year', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-model_year" class="no-print btn btn-sm edit-button" onclick="enableEditing('model_year')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Registration Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-registration_number">{{ $machinery->registration_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-registration_number" value="{{ $machinery->registration_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('registration_number', {{ $machinery->id }})" />
                    <button id="save-btn-registration_number" class="btn btn-sm btn-light d-none" onclick="updateField('registration_number', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-registration_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('registration_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Fuel Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-fuel_type">{{ $machinery->fuel_type }}</span>
                    @if ($canUpdate)
                    <select id="input-fuel_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('fuel_type', {{ $machinery->id }})">
                        @foreach ($fuel_types as $fuel_type)
                        <option value="{{ $fuel_type }}" {{ $machinery->fuel_type == $fuel_type ? 'selected' : '' }}>
                            {{ $fuel_type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-fuel_type" class="btn btn-sm btn-light d-none" onclick="updateField('fuel_type', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-fuel_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('fuel_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Engine Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-engine_number">{{ $machinery->engine_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-engine_number" value="{{ $machinery->engine_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('engine_number', {{ $machinery->id }})" />
                    <button id="save-btn-engine_number" class="btn btn-sm btn-light d-none" onclick="updateField('engine_number', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-engine_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('engine_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Chassis Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-chassis_number">{{ $machinery->chassis_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-chassis_number" value="{{ $machinery->chassis_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('chassis_number', {{ $machinery->id }})" />
                    <button id="save-btn-chassis_number" class="btn btn-sm btn-light d-none" onclick="updateField('chassis_number', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-chassis_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('chassis_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Remarks</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-remarks">{{ $machinery->remarks }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-remarks" value="{{ $machinery->remarks }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('remarks', {{ $machinery->id }})" />
                    <button id="save-btn-remarks" class="btn btn-sm btn-light d-none" onclick="updateField('remarks', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-remarks" class="no-print btn btn-sm edit-button" onclick="enableEditing('remarks')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');

        if (field === 'specifications' || field === 'remarks') {
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
        const newValue = (field === 'specifications' || field === 'remarks') ?
            $('#input-' + field).summernote('code') :
            $('#input-' + field).val();

        const url = "{{ route('admin.apps.machineries.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'specifications' || field === 'remarks') {
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
