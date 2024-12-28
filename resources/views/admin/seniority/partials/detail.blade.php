<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }

</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row seniority-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $seniority->title }}</span>
                    @if (!in_array($seniority->status, ['published', 'archived']))
                    <input type="text" id="input-title" value="{{ $seniority->title }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('title', {{ $seniority->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $seniority->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Type -->
            <tr>
                <th class="table-cell">BPS</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-bps">{{ $seniority->bps }}</span>
                    @if (!in_array($seniority->status, ['published', 'archived']))
                    <select id="input-bps" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('bps', {{ $seniority->id }})">
                        @foreach ($cat['bps'] as $bps)
                        <option value="{{ $bps }}" {{ $seniority->bps == $bps ? 'selected' : '' }}>
                            {{ $bps }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-bps" class="btn btn-sm btn-light d-none" onclick="updateField('bps', {{ $seniority->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-bps" class="no-print btn btn-sm edit-button" onclick="enableEditing('bps')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Category -->
            <tr>
                <th class="table-cell">Designation</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-designation">{{ $seniority->designation }}</span>
                    @if (!in_array($seniority->status, ['published', 'archived']))
                    <select id="input-designation" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('designation', {{ $seniority->id }})">
                        @foreach ($cat['designations'] as $designation)
                        <option value="{{ $designation->name }}" {{ $seniority->designation == $designation->name ? 'selected' : '' }}>
                            {{ $designation->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-designation" class="btn btn-sm btn-light d-none" onclick="updateField('designation', {{ $seniority->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-designation" class="no-print btn btn-sm edit-button" onclick="enableEditing('designation')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File -->
            <tr>
                <th class="table-cell">Attachment</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @if($seniority->hasMedia('seniorities'))
                    <a href="{{ $seniority->getFirstMediaUrl('seniorities') }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @if (!in_array($seniority->status, ['published', 'archived']))
                    <div class="no-print">
                        <label for="attachment" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">{!! $seniority->hasMedia('seniorities') ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                        </label>
                        <input type="file" id="attachment" name="attachment" class="d-none file-input" onchange="uploadFile({{ $seniority->id }})">
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
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    imageCropper({
        fileInput: '.file-input'
        , aspectRatio: 2 / 3
        , onComplete: async function(file, input) {
            var formData = new FormData();
            formData.append('attachment', file);
            formData.append('_method', "PATCH");

            const url = "{{ route('admin.seniority.uploadFile', ':id') }}".replace(':id', '{{ $seniority->id }}');
            try {
                const result = await fetchRequest(url, 'POST', formData);
                if (result) {
                    $(input).closest('.modal').modal('toggle');
                }
            } catch (error) {
                console.error('Error during form submission:', error);
            }
        }
    });

    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();
        const url = "{{ route('admin.seniority.updateField', ':id') }}".replace(':id', id);
        const data = {
            id: id
            , field: field
            , value: newValue
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

</script>
