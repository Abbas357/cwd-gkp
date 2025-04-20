<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $download);
    $canUpload = auth()->user()->can('uploadFile', $download);
@endphp
<div class="row downloads-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell">File Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-file_name">{{ $download->file_name }}</span>
                    @if ($canUpdate && !in_array($download->status, ['published', 'archived']))
                    <input type="text" id="input-file_name" value="{{ $download->file_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('file_name', {{ $download->id }})" />
                    <button id="save-btn-file_name" class="btn btn-sm btn-light d-none" onclick="updateField('file_name', {{ $download->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-file_name" class="no-print btn btn-sm edit-button" onclick="enableEditing('file_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Type -->
            <tr>
                <th class="table-cell">File Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-file_type">{{ $download->file_type }}</span>
                    @if ($canUpdate && !in_array($download->status, ['published', 'archived']))
                    <select id="input-file_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('file_type', {{ $download->id }})">
                        @foreach ($cat['file_type'] as $file_type)
                        <option value="{{ $file_type->name }}" {{ $download->file_type == $file_type->name ? 'selected' : '' }}>
                            {{ $file_type->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-file_type" class="btn btn-sm btn-light d-none" onclick="updateField('file_type', {{ $download->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-file_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('file_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Category -->
            <tr>
                <th class="table-cell">Category</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-category">{{ $download->category }}</span>
                    @if ($canUpdate && !in_array($download->status, ['published', 'archived']))
                    <select id="input-category" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('category', {{ $download->id }})">
                        @foreach ($cat['download_category'] as $category)
                        <option value="{{ $category->name }}" {{ $download->category == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-category" class="btn btn-sm btn-light d-none" onclick="updateField('category', {{ $download->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-category" class="no-print btn btn-sm edit-button" onclick="enableEditing('category')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File -->
            <tr>
                <th class="table-cell">File</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @if($download->hasMedia('downloads'))
                    <a href="{{ $download->getFirstMediaUrl('downloads') }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @if ($canUpload && !in_array($download->status, ['published', 'archived']))
                    <div class="no-print">
                        <label for="file" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">{!! $download->hasMedia('downloads') ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                        </label>
                        <input type="file" id="file" name="file" class="d-none file-input" onchange="uploadFile({{ $download->id }})">
                    </div>
                    @endif
                    @else
                    <span>Not Uploaded</span>
                    @endif
                </td>
            </tr>
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
        const url = "{{ route('admin.downloads.updateField', ':id') }}".replace(':id', id);
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

        const url = "{{ route('admin.downloads.uploadFile', ':id') }}".replace(':id', id);
        fetchRequest(url, 'POST', formData);
    }
</script>
