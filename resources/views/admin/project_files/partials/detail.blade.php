<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $project_file);
    $canUpload = auth()->user()->can('uploadFile', $project_file);
@endphp
<div class="row downloads-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">File Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-file_name">{{ $project_file->file_name }}</span>
                    @if ($canUpdate && !in_array($project_file->status, ['published', 'archived']))
                    <input type="text" id="input-file_name" value="{{ $project_file->file_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('file_name', {{ $project_file->id }})" />
                    <button id="save-btn-file_name" class="btn btn-sm btn-light d-none" onclick="updateField('file_name', {{ $project_file->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-file_name" class="no-print btn btn-sm edit-button" onclick="enableEditing('file_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">File Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-file_type">{{ $project_file->file_type }}</span>
                    @if ($canUpdate && !in_array($project_file->status, ['published', 'archived']))
                    <select id="input-file_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('file_type', {{ $project_file->id }})">
                        @foreach ($cat['file_type'] as $file_type)
                        <option value="{{ $file_type }}" {{ $project_file->file_type == $file_type ? 'selected' : '' }}>
                            {{ $file_type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-file_type" class="btn btn-sm btn-light d-none" onclick="updateField('file_type', {{ $project_file->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-file_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('file_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Project</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-project_id">{{ $project_file->project->name }}</span>
                    @if ($canUpdate && !in_array($project_file->status, ['published', 'archived']))
                    <select id="input-project_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('projects', {{ $project_file->id }})">
                        @foreach ($cat['projects'] as $project)
                        <option value="{{ $project->id }}" {{ $project_file->project->name == $project->name ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-project_id" class="btn btn-sm btn-light d-none" onclick="updateField('project_id', {{ $project_file->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-project_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('project_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            @if ($project_file->hasMedia('project_files'))
            <tr>
                <th class="table-cell">File</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @if($project_file->hasMedia('project_files'))
                    <a href="{{ $project_file->getFirstMediaUrl('project_files') }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @if ($canUpload && !in_array($project_file->status, ['published', 'archived']))
                    <div class="no-print">
                        <label for="file" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">{!! $project_file->hasMedia('project_files') ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                        </label>
                        <input type="file" id="file" name="file" class="d-none file-input" onchange="uploadFile({{ $project_file->id }})">
                    </div>
                    @endif
                    @else
                    <span>Not Uploaded</span>
                    @endif
                </td>
            </tr>
            @else 
            <tr>
                <th class="table-cell">File Link</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-file_link">{{ $project_file->file_link }}</span>
                    @if ($canUpdate && !in_array($project_file->status, ['published', 'archived']))
                    <input type="text" id="input-file_link" value="{{ $project_file->file_link }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('file_link', {{ $project_file->id }})" />
                    <button id="save-btn-file_link" class="btn btn-sm btn-light d-none" onclick="updateField('file_link', {{ $project_file->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-file_link" class="no-print btn btn-sm edit-button" onclick="enableEditing('file_link')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            @endif
        </table>
    </div>
</div>

<script>
    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();
        const url = "{{ route('admin.project_files.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field,
            value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            $('#text-' + field).text(newValue);
            $('#input-' + field).addClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#edit-btn-' + field).removeClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }

    function uploadFile(id) {
        const file = $('#file')[0].files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('_method', 'PATCH');

        const url = "{{ route('admin.project_files.uploadFile', ':id') }}".replace(':id', id);
        fetchRequest(url, 'POST', formData);
    }
</script>
