<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">

<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>

<div class="row events-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $DevelopmentProject->name }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="text" id="input-name" value="{{ $DevelopmentProject->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Commnsecement Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-commencement_date">{{ $DevelopmentProject->commencement_date }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="date" id="input-commencement_date" value="{{ $DevelopmentProject->commencement_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('commencement_date', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-commencement_date" class="btn btn-sm btn-light d-none" onclick="updateField('commencement_date', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-commencement_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('commencement_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Introduction</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-introduction">{!! $DevelopmentProject->introduction !!}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <div class="mb-3 w-100">
                        <textarea name="introduction" id="input-introduction" class="form-control d-none" style="height:150px">{!! old('introduction', $DevelopmentProject->introduction) !!}</textarea>
                    </div>
                    <button id="save-btn-introduction" class="btn btn-sm btn-light d-none" onclick="updateField('introduction', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-introduction" class="no-print btn btn-sm edit-button" onclick="enableEditing('introduction')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            <tr>
                <th class="table-cell">Total Cost</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-total_cost">{{ $DevelopmentProject->total_cost }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="text" id="input-total_cost" value="{{ $DevelopmentProject->total_cost }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('total_cost', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-total_cost" class="btn btn-sm btn-light d-none" onclick="updateField('total_cost', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-total_cost" class="no-print btn btn-sm edit-button" onclick="enableEditing('total_cost')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-district_id">{{ $DevelopmentProject->district->name }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <select id="input-district_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('district_id', {{ $DevelopmentProject->id }})">
                        @foreach ($cat['districts'] as $district)
                        <option value="{{ $district->id }}" {{ $DevelopmentProject->district_id == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-district_id" class="btn btn-sm btn-light d-none" onclick="updateField('district_id', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-district_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('district_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Chief Engineer</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-ce_id">{{ $DevelopmentProject->chiefEngineer?->name }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <select id="input-ce_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('ce_id', {{ $DevelopmentProject->id }})">
                        @foreach ($cat['chiefEngineers'] as $chief)
                        <option value="{{ $chief->id }}" {{ $DevelopmentProject->ce_id == $chief->id ? 'selected' : '' }}>
                            {{ $chief->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-ce_id" class="btn btn-sm btn-light d-none" onclick="updateField('ce_id', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-ce_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('ce_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Progress Percentage</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-progress_percentage">{{ $DevelopmentProject->progress_percentage }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="range" id="input-progress_percentage" value="{{ $DevelopmentProject->progress_percentage }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('progress_percentage', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-progress_percentage" class="btn btn-sm btn-light d-none" onclick="updateField('progress_percentage', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-progress_percentage" class="no-print btn btn-sm edit-button" onclick="enableEditing('progress_percentage')"><i class="bi-pencil fs-6"></i></button>
                    @endif
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

        if (field === 'introduction') {
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
        const newValue = (field === 'introduction') ? $('#input-' + field).summernote('code') : $('#input-' + field).val();
        const url = "{{ route('admin.development_projects.updateField') }}";
        const data = {
            id: id
            , field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'introduction') {
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
