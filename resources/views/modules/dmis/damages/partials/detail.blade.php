<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $damage);
    $canUpload = auth()->user()->can('uploadFile', $damage);
@endphp
<div class="row damage-details">
    <div class="col-md-12">
        <table class="table table-bordered mt-3">
            <!-- Basic Information -->
            <tr>
                <th class="table-cell">Report Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-report_date">{{ $damage->report_date->format('Y-m-d') }}</span>
                    @if($canUpdate)
                    <input type="date" id="input-report_date" value="{{ $damage->report_date->format('Y-m-d') }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('report_date', {{ $damage->id }})" />
                    <button id="save-btn-report_date" class="btn btn-sm btn-light d-none" onclick="updateField('report_date', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-report_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('report_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $damage->type }}</span>
                    @if($canUpdate)
                    <select id="input-type" class="d-none form-control" onchange="updateField('type', {{ $damage->id }})">
                        <option value="">Select Type</option>
                        @foreach(setting('infrastructure_type', 'dmis') as $type)
                        <option value="{{ $type }}" {{ $damage->type == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Infrastructure</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-infrastructure_id">{{ $damage->infrastructure->name ?? 'N/A' }}</span>
                    @if($canUpdate)
                    <select id="input-infrastructure_id" class="d-none form-control select2" onchange="updateField('infrastructure_id', {{ $damage->id }})">
                        <option value="{{ $damage->infrastructure_id }}" selected>{{ $damage->infrastructure->name ?? 'N/A' }}</option>
                    </select>
                    <button id="save-btn-infrastructure_id" class="btn btn-sm btn-light d-none" onclick="updateField('infrastructure_id', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-infrastructure_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('infrastructure_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            <!-- Damage Information -->
            <tr>
                <th class="table-cell">Damaged Length</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-damaged_length">{{ $damage->damaged_length }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-damaged_length" value="{{ $damage->damaged_length }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('damaged_length', {{ $damage->id }})" />
                    <button id="save-btn-damaged_length" class="btn btn-sm btn-light d-none" onclick="updateField('damaged_length', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-damaged_length" class="no-print btn btn-sm edit-button" onclick="enableEditing('damaged_length')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Damage Nature</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @if($canUpdate)
                    <span id="text-damage_nature">{{ implode(', ', json_decode($damage->damage_nature) ?? []) }}</span>
                    <select id="input-damage_nature" class="d-none form-control select2-multiple" multiple onchange="updateField('damage_nature', {{ $damage->id }})">
                        @foreach(setting('damage_nature', 'dmis') as $nature)
                        <option value="{{ $nature }}" {{ in_array($nature, json_decode($damage->damage_nature) ?? []) ? 'selected' : '' }}>
                            {{ $nature }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-damage_nature" class="btn btn-sm btn-light d-none" onclick="updateField('damage_nature', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-damage_nature" class="no-print btn btn-sm edit-button" onclick="enableEditing('damage_nature')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Damage Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-damage_status">{{ $damage->damage_status }}</span>
                    @if($canUpdate)
                    <select id="input-damage_status" class="d-none form-control" onchange="updateField('damage_status', {{ $damage->id }})">
                        <option value="">Select Damage Status</option>
                        @foreach(setting('damage_status', 'dmis') as $damage_status)
                        <option value="{{ $damage_status }}" {{ $damage->damage_status == $damage_status ? 'selected' : '' }}>
                            {{ $damage_status }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-damage_status" class="btn btn-sm btn-light d-none" onclick="updateField('damage_status', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-damage_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('damage_status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Road Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-road_status">{{ $damage->road_status }}</span>
                    @if($canUpdate)
                    <select id="input-road_status" class="d-none form-control" onchange="updateField('road_status', {{ $damage->id }})">
                        <option value="">Select Road Status</option>
                        @foreach(setting('road_status', 'dmis') as $road_status)
                        <option value="{{ $road_status }}" {{ $damage->road_status == $road_status ? 'selected' : '' }}>
                            {{ $road_status }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-road_status" class="btn btn-sm btn-light d-none" onclick="updateField('road_status', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-road_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('road_status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            <!-- Damage Coordinates -->
            <tr>
                <th class="table-cell">Damage Start (Easting)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-damage_east_start">{{ $damage->damage_east_start }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-damage_east_start" value="{{ $damage->damage_east_start }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('damage_east_start', {{ $damage->id }})" />
                    <button id="save-btn-damage_east_start" class="btn btn-sm btn-light d-none" onclick="updateField('damage_east_start', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-damage_east_start" class="no-print btn btn-sm edit-button" onclick="enableEditing('damage_east_start')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Damage Start (Northing)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-damage_north_start">{{ $damage->damage_north_start }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-damage_north_start" value="{{ $damage->damage_north_start }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('damage_north_start', {{ $damage->id }})" />
                    <button id="save-btn-damage_north_start" class="btn btn-sm btn-light d-none" onclick="updateField('damage_north_start', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-damage_north_start" class="no-print btn btn-sm edit-button" onclick="enableEditing('damage_north_start')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Damage End (Easting)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-damage_east_end">{{ $damage->damage_east_end }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-damage_east_end" value="{{ $damage->damage_east_end }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('damage_east_end', {{ $damage->id }})" />
                    <button id="save-btn-damage_east_end" class="btn btn-sm btn-light d-none" onclick="updateField('damage_east_end', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-damage_east_end" class="no-print btn btn-sm edit-button" onclick="enableEditing('damage_east_end')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Damage End (Northing)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-damage_north_end">{{ $damage->damage_north_end }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-damage_north_end" value="{{ $damage->damage_north_end }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('damage_north_end', {{ $damage->id }})" />
                    <button id="save-btn-damage_north_end" class="btn btn-sm btn-light d-none" onclick="updateField('damage_north_end', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-damage_north_end" class="no-print btn btn-sm edit-button" onclick="enableEditing('damage_north_end')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            <!-- Cost Information -->
            <tr>
                <th class="table-cell">Restoration Cost (Millions)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-approximate_restoration_cost">{{ $damage->approximate_restoration_cost }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-approximate_restoration_cost" value="{{ $damage->approximate_restoration_cost }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('approximate_restoration_cost', {{ $damage->id }})" />
                    <button id="save-btn-approximate_restoration_cost" class="btn btn-sm btn-light d-none" onclick="updateField('approximate_restoration_cost', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-approximate_restoration_cost" class="no-print btn btn-sm edit-button" onclick="enableEditing('approximate_restoration_cost')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Rehabilitation Cost (Millions)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-approximate_rehabilitation_cost">{{ $damage->approximate_rehabilitation_cost }}</span>
                    @if($canUpdate)
                    <input type="text" id="input-approximate_rehabilitation_cost" value="{{ $damage->approximate_rehabilitation_cost }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('approximate_rehabilitation_cost', {{ $damage->id }})" />
                    <button id="save-btn-approximate_rehabilitation_cost" class="btn btn-sm btn-light d-none" onclick="updateField('approximate_rehabilitation_cost', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-approximate_rehabilitation_cost" class="no-print btn btn-sm edit-button" onclick="enableEditing('approximate_rehabilitation_cost')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Remarks</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-remarks">{{ $damage->remarks }}</span>
                    @if($canUpdate)
                    <textarea id="input-remarks" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('remarks', {{ $damage->id }})">{{ $damage->remarks }}</textarea>
                    <button id="save-btn-remarks" class="btn btn-sm btn-light d-none" onclick="updateField('remarks', {{ $damage->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-remarks" class="no-print btn btn-sm edit-button" onclick="enableEditing('remarks')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
        </table>
        
    </div>
</div>

<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>

<script>
    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');

        if (field === 'remarks') {
            var textarea = $('#input-' + field);
            if (!textarea.data('summernote-initialized')) {
                textarea.summernote({
                    height: 300
                });
                textarea.data('summernote-initialized', true);
            }
        }
        
        if (field === 'infrastructure_id') {
            select2Ajax(
                '#input-infrastructure_id',
                '{{ route("admin.apps.dmis.infrastructures.api") }}',
                {
                    placeholder: "Select Infrastructure",
                    params: {
                        type: $('#input-type').val() || $('#text-type').text()
                    }
                }
            );
        }
        
        if (field === 'damage_nature') {
            $('#input-damage_nature').select2({
                theme: "bootstrap-5",
                width: '100%',
                placeholder: 'Select Damage Nature',
                closeOnSelect: false
            });
        }
    }

    async function updateField(field, id) {
        let newValue;
        
        if (field === 'remarks') {
            newValue = $('#input-' + field).summernote('code');
        } else if (field === 'damage_nature') {
            newValue = JSON.stringify($('#input-' + field).val());
        } else {
            newValue = $('#input-' + field).val();
        }

        const url = "{{ route('admin.apps.dmis.damages.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field,
            value: newValue
        };
        
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'remarks') {
                $('#text-' + field).html(newValue);
                $('#input-' + field).summernote('destroy');
                $('#input-' + field).data('summernote-initialized', false);
            } else if (field === 'damage_nature') {
                const selectedOptions = $('#input-' + field + ' option:selected').map(function() {
                    return $(this).text();
                }).get();
                $('#text-' + field).text(selectedOptions.join(', '));
            } else if (field === 'infrastructure_id') {
                $('#text-' + field).text($('#input-' + field + ' option:selected').text());
            } else {
                $('#text-' + field).text(newValue);
            }
            
            $('#input-' + field).addClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#edit-btn-' + field).removeClass('d-none');
            $('#text-' + field).removeClass('d-none');
            
            if (field === 'type') {
                $('#text-infrastructure_id').text(''); 
                $('#input-infrastructure_id').empty();
            }
        }
    }
</script>