<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
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
                        @foreach ($cat['machinery_type'] as $type)
                        <option value="{{ $type->name }}" {{ $machinery->type == $type->name ? 'selected' : '' }}>
                            {{ $type->name }}
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
                        @foreach ($cat['machinery_operational_status'] as $operational_status)
                        <option value="{{ $operational_status->name }}" {{ $machinery->operational_status == $operational_status->name ? 'selected' : '' }}>
                            {{ $operational_status->name }}
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
                        @foreach ($cat['machinery_manufacturer'] as $manufacturer)
                        <option value="{{ $manufacturer->name }}" {{ $machinery->manufacturer == $manufacturer->name ? 'selected' : '' }}>
                            {{ $manufacturer->name }}
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
                        @foreach ($cat['machinery_power_source'] as $power_source)
                        <option value="{{ $power_source->name }}" {{ $machinery->power_source == $power_source->name ? 'selected' : '' }}>
                            {{ $power_source->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-power_source" class="btn btn-sm btn-light d-none" onclick="updateField('power_source', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-power_source" class="no-print btn btn-sm edit-button" onclick="enableEditing('power_source')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Power Rating</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-power_rating">{{ $machinery->power_rating }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-power_rating" value="{{ $machinery->power_rating }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('power_rating', {{ $machinery->id }})" />
                    <button id="save-btn-power_rating" class="btn btn-sm btn-light d-none" onclick="updateField('power_rating', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-power_rating" class="no-print btn btn-sm edit-button" onclick="enableEditing('power_rating')"><i class="bi-pencil fs-6"></i></button>
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
                <th class="table-cell">Operating Hours</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-operating_hours">{{ $machinery->operating_hours }}</span>
                    @if ($canUpdate)
                    <input type="number" id="input-operating_hours" value="{{ $machinery->operating_hours }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('operating_hours', {{ $machinery->id }})" />
                    <button id="save-btn-operating_hours" class="btn btn-sm btn-light d-none" onclick="updateField('operating_hours', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-operating_hours" class="no-print btn btn-sm edit-button" onclick="enableEditing('operating_hours')"><i class="bi-pencil fs-6"></i></button>
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
                <th class="table-cell">Next Maintenance Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-next_maintenance_date">{{ $machinery->next_maintenance_date }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-next_maintenance_date" value="{{ $machinery->next_maintenance_date }}" class="d-none form-control datepicker" onkeypress="if (event.key === 'Enter') updateField('next_maintenance_date', {{ $machinery->id }})" />
                    <button id="save-btn-next_maintenance_date" class="btn btn-sm btn-light d-none" onclick="updateField('next_maintenance_date', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-next_maintenance_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('next_maintenance_date')"><i class="bi-pencil fs-6"></i></button>
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
                <th class="table-cell">Hourly Cost</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-hourly_cost">{{ $machinery->hourly_cost }}</span>
                    @if ($canUpdate)
                    <input type="number" step="0.01" id="input-hourly_cost" value="{{ $machinery->hourly_cost }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('hourly_cost', {{ $machinery->id }})" />
                    <button id="save-btn-hourly_cost" class="btn btn-sm btn-light d-none" onclick="updateField('hourly_cost', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-hourly_cost" class="no-print btn btn-sm edit-button" onclick="enableEditing('hourly_cost')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Asset Tag</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-asset_tag">{{ $machinery->asset_tag }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-asset_tag" value="{{ $machinery->asset_tag }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('asset_tag', {{ $machinery->id }})" />
                    <button id="save-btn-asset_tag" class="btn btn-sm btn-light d-none" onclick="updateField('asset_tag', {{ $machinery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-asset_tag" class="no-print btn btn-sm edit-button" onclick="enableEditing('asset_tag')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Certification Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-certification_status">{{ $machinery->certification_status }}</span>
                    @if ($canUpdate)
                    <select id="input-certification_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('certification_status', {{ $machinery->id }})">
                        @foreach ($cat['machinery_certification_status'] as $certification_status)
                        <option value="{{ $certification_status->name }}" {{ $machinery->certification_status == $certification_status->name ? 'selected' : '' }}>
                            {{ $certification_status->name }}
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
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".datepicker").flatpickr({
            dateFormat: "Y-m-d"
        });
    });
    
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
        
        if (field === 'last_maintenance_date' || field === 'next_maintenance_date') {
            $('#input-' + field).flatpickr({
                dateFormat: "Y-m-d"
            });
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