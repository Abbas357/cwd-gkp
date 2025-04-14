<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
<div class="row infrastructure-details">
    <div class="col-md-12">
        <table class="table table-bordered mt-3">

            <tr>
                <th class="table-cell">Infrastructure Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $infrastructure->type }}</span>
                    <select id="input-type" class="d-none form-control" onchange="updateField('type', {{ $infrastructure->id }})">
                        <option value="">Select Type</option>
                        @foreach(setting('infrastructure_type', 'dmis') as $infrastructure_type)
                        <option value="{{ $infrastructure_type }}" {{ $infrastructure->type == $infrastructure_type ? 'selected' : '' }}>
                            {{ $infrastructure_type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-district_id">{{ $infrastructure->district->name ?? 'N/A' }}</span>
                    <select id="input-district_id" class="d-none form-control" onchange="updateField('district_id', {{ $infrastructure->id }})">
                        <option value="">Select District</option>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ $infrastructure->district_id == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-district_id" class="btn btn-sm btn-light d-none" onclick="updateField('district_id', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-district_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('district_id')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $infrastructure->name }}</span>
                    <input type="text" id="input-name" value="{{ $infrastructure->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $infrastructure->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">Length</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-length">{{ $infrastructure->length }}</span>
                    <input type="number" id="input-length" value="{{ $infrastructure->length }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('length', {{ $infrastructure->id }})" />
                    <button id="save-btn-length" class="btn btn-sm btn-light d-none" onclick="updateField('length', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-length" class="no-print btn btn-sm edit-button" onclick="enableEditing('length')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            
            <tr>
                <th class="table-cell">Start Coordinate (Easting)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-east_start_coordinate">{{ $infrastructure->east_start_coordinate }}</span>
                    <input type="text" id="input-east_start_coordinate" value="{{ $infrastructure->east_start_coordinate }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('east_start_coordinate', {{ $infrastructure->id }})" />
                    <button id="save-btn-east_start_coordinate" class="btn btn-sm btn-light d-none" onclick="updateField('east_start_coordinate', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-east_start_coordinate" class="no-print btn btn-sm edit-button" onclick="enableEditing('east_start_coordinate')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">Start Coordinate (Northing)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-north_start_coordinate">{{ $infrastructure->north_start_coordinate }}</span>
                    <input type="text" id="input-north_start_coordinate" value="{{ $infrastructure->north_start_coordinate }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('north_start_coordinate', {{ $infrastructure->id }})" />
                    <button id="save-btn-north_start_coordinate" class="btn btn-sm btn-light d-none" onclick="updateField('north_start_coordinate', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-north_start_coordinate" class="no-print btn btn-sm edit-button" onclick="enableEditing('north_start_coordinate')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">End Coordinate (Easting)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-east_end_coordinate">{{ $infrastructure->east_end_coordinate }}</span>
                    <input type="text" id="input-east_end_coordinate" value="{{ $infrastructure->east_end_coordinate }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('east_end_coordinate', {{ $infrastructure->id }})" />
                    <button id="save-btn-east_end_coordinate" class="btn btn-sm btn-light d-none" onclick="updateField('east_end_coordinate', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-east_end_coordinate" class="no-print btn btn-sm edit-button" onclick="enableEditing('east_end_coordinate')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>

            <tr>
                <th class="table-cell">End Coordinate (Northing)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-north_end_coordinate">{{ $infrastructure->north_end_coordinate }}</span>
                    <input type="text" id="input-north_end_coordinate" value="{{ $infrastructure->north_end_coordinate }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('north_end_coordinate', {{ $infrastructure->id }})" />
                    <button id="save-btn-north_end_coordinate" class="btn btn-sm btn-light d-none" onclick="updateField('north_end_coordinate', {{ $infrastructure->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-north_end_coordinate" class="no-print btn btn-sm edit-button" onclick="enableEditing('north_end_coordinate')"><i class="bi-pencil fs-6"></i></button>
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
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();

        const url = "{{ route('admin.apps.dmis.infrastructures.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field,
            value: newValue
        };
        
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'district_id') {
                $('#text-' + field).text($('#input-' + field + ' option:selected').text());
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