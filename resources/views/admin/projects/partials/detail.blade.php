<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
@php
    $canUpdate = auth()->user()->can('updateField', $project);
@endphp
<div class="row downloads-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $project->name }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-name" value="{{ $project->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $project->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $project->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                    @endcan
                </td>
            </tr>

            <tr>
                <th class="table-cell">Introduction</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-introduction">{!! $project->introduction !!}</span>
                    @if ($canUpdate)
                    <div class="mb-3 w-100">
                        <textarea name="introduction" id="input-introduction" class="form-control d-none" style="height:150px">{!! old('introduction', $project->introduction) !!}</textarea>
                    </div>
                    <button id="save-btn-introduction" class="btn btn-sm btn-light d-none" onclick="updateField('introduction', {{ $project->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-introduction" class="no-print btn btn-sm edit-button" onclick="enableEditing('introduction')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Location</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-location">{{ $project->location }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-location" value="{{ $project->location }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('location', {{ $project->id }})" />
                    <button id="save-btn-location" class="btn btn-sm btn-light d-none" onclick="updateField('location', {{ $project->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-location" class="no-print btn btn-sm edit-button" onclick="enableEditing('location')"><i class="bi-pencil fs-6"></i></button>
                    @endcan
                </td>
            </tr>

            <tr>
                <th class="table-cell">Budget</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-budget">{{ $project->budget }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-budget" value="{{ $project->budget }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('budget', {{ $project->id }})" />
                    <button id="save-btn-budget" class="btn btn-sm btn-light d-none" onclick="updateField('budget', {{ $project->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-budget" class="no-print btn btn-sm edit-button" onclick="enableEditing('budget')"><i class="bi-pencil fs-6"></i></button>
                    @endcan
                </td>
            </tr>

            <tr>
                <th class="table-cell">Funding Source</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-funding_source">{{ $project->funding_source }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-funding_source" value="{{ $project->funding_source }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('funding_source', {{ $project->id }})" />
                    <button id="save-btn-funding_source" class="btn btn-sm btn-light d-none" onclick="updateField('funding_source', {{ $project->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-funding_source" class="no-print btn btn-sm edit-button" onclick="enableEditing('funding_source')"><i class="bi-pencil fs-6"></i></button>
                    @endcan
                </td>
            </tr>

            <tr>
                <th class="table-cell">Start Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-start_date">{{ $project->start_date }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-start_date" value="{{ $project->start_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('start_date', {{ $project->id }})" />
                    <button id="save-btn-start_date" class="btn btn-sm btn-light d-none" onclick="updateField('start_date', {{ $project->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-start_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('start_date')"><i class="bi-pencil fs-6"></i></button>
                    @endcan
                </td>
            </tr>

            <tr>
                <th class="table-cell">End Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-end_date">{{ $project->end_date }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-end_date" value="{{ $project->end_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('end_date', {{ $project->id }})" />
                    <button id="save-btn-end_date" class="btn btn-sm btn-light d-none" onclick="updateField('end_date', {{ $project->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-end_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('end_date')"><i class="bi-pencil fs-6"></i></button>
                    @endcan
                </td>
            </tr>
            
        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
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
        const url = "{{ route('admin.projects.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
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
