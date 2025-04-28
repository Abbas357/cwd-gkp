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
                        @foreach (category('machinery_type', 'machinery') as $type)
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
                <th class="table-cell">Operational Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-operational_status">{{ $machinery->operational_status }}</span>
                    @if ($canUpdate)
                    <select id="input-operational_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('operational_status', {{ $machinery->id }})">
                        @foreach (category('machinery_operational_status', 'machinery') as $operational_status)
                        <option value="{{ $operational_status }}" {{ $machinery->operational_status == $operational_status ? 'selected' : '' }}>
                            {{ $operational_status }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-operational_status" class="btn btn-sm btn-light d-none" onclick="updateField('operational_status', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-operational_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('operational_status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Manufacturer</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-manufacturer">{{ $machinery->manufacturer }}</span>
                    @if ($canUpdate)
                    <select id="input-manufacturer" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('manufacturer', {{ $machinery->id }})">
                        @foreach (category('machinery_manufacturer', 'machinery') as $manufacturer)
                        <option value="{{ $manufacturer }}" {{ $machinery->manufacturer == $manufacturer ? 'selected' : '' }}>
                            {{ $manufacturer }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-manufacturer" class="btn btn-sm btn-light d-none" onclick="updateField('manufacturer', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-manufacturer" class="no-print btn btn-sm edit-button" onclick="enableEditing('manufacturer')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Model</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-model">{{ $machinery->model }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-model" value="{{ $machinery->model }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('model', {{ $machinery->id }})" />
                    <button id="save-btn-model" class="btn btn-sm btn-light d-none" onclick="updateField('model', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-model" class="no-print btn btn-sm edit-button" onclick="enableEditing('model')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Serial Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-serial_number">{{ $machinery->serial_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-serial_number" value="{{ $machinery->serial_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('serial_number', {{ $machinery->id }})" />
                    <button id="save-btn-serial_number" class="btn btn-sm btn-light d-none" onclick="updateField('serial_number', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-serial_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('serial_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Power Source</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-power_source">{{ $machinery->power_source }}</span>
                    @if ($canUpdate)
                    <select id="input-power_source" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('power_source', {{ $machinery->id }})">
                        @foreach (category('machinery_power_source', 'machinery') as $power_source)
                        <option value="{{ $power_source }}" {{ $machinery->power_source == $power_source ? 'selected' : '' }}>
                            {{ $power_source }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-power_source" class="btn btn-sm btn-light d-none" onclick="updateField('power_source', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-power_source" class="no-print btn btn-sm edit-button" onclick="enableEditing('power_source')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Manufacturing Year</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-manufacturing_year">{{ $machinery->manufacturing_year }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-manufacturing_year" value="{{ $machinery->manufacturing_year }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('manufacturing_year', {{ $machinery->id }})" />
                    <button id="save-btn-manufacturing_year" class="btn btn-sm btn-light d-none" onclick="updateField('manufacturing_year', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-manufacturing_year" class="no-print btn btn-sm edit-button" onclick="enableEditing('manufacturing_year')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Last Maintenance Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-last_maintenance_date">{{ $machinery->last_maintenance_date }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-last_maintenance_date" value="{{ $machinery->last_maintenance_date }}" class="d-none form-control datepicker" onkeypress="if (event.key === 'Enter') updateField('last_maintenance_date', {{ $machinery->id }})" />
                    <button id="save-btn-last_maintenance_date" class="btn btn-sm btn-light d-none" onclick="updateField('last_maintenance_date', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-last_maintenance_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('last_maintenance_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Location</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-location">{{ $machinery->location }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-location" value="{{ $machinery->location }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('location', {{ $machinery->id }})" />
                    <button id="save-btn-location" class="btn btn-sm btn-light d-none" onclick="updateField('location', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-location" class="no-print btn btn-sm edit-button" onclick="enableEditing('location')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Certification Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-certification_status">{{ $machinery->certification_status }}</span>
                    @if ($canUpdate)
                    <select id="input-certification_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('certification_status', {{ $machinery->id }})">
                        @foreach (category('machinery_certification_status', 'machinery') as $certification_status)
                        <option value="{{ $certification_status }}" {{ $machinery->certification_status == $certification_status ? 'selected' : '' }}>
                            {{ $certification_status }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-certification_status" class="btn btn-sm btn-light d-none" onclick="updateField('certification_status', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-certification_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('certification_status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Specifications</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-specifications">{{ $machinery->specifications }}</span>
                    @if ($canUpdate)
                    <div class="mb-3 w-100">
                        <textarea name="specifications" id="input-specifications" class="form-control d-none" style="height:150px">{!! old('specifications', $machinery->specifications) !!}</textarea>
                    </div>
                    <button id="save-btn-specifications" class="btn btn-sm btn-light d-none" onclick="updateField('specifications', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-specifications" class="no-print btn btn-sm edit-button" onclick="enableEditing('specifications')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Remarks</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-remarks">{{ $machinery->remarks }}</span>
                    @if ($canUpdate)
                    <div class="mb-3 w-100">
                        <textarea name="remarks" id="input-remarks" class="form-control d-none" style="height:150px">{!! old('remarks', $machinery->remarks) !!}</textarea>
                    </div>
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
            field: field,
            value: newValue
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