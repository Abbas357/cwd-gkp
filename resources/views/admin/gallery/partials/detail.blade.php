<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }

</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row downloads-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell"> Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $gallery->title }}</span>
                    @if (!in_array($gallery->status, ['published', 'archived']))
                    <input type="text" id="input-title" value="{{ $gallery->title }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('title', {{ $gallery->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $gallery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Type -->
            <tr>
                <th class="table-cell">Gallery Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $gallery->type }}</span>
                    @if (!in_array($gallery->status, ['published', 'archived']))
                    <select id="input-type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('type', {{ $gallery->id }})">
                        @foreach ($cat['gallery_type'] as $type)
                        <option value="{{ $type->name }}" {{ $gallery->type == $type->name ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $gallery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Category -->
            <tr>
                <th class="table-cell">Description</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-description">{{ $gallery->description }}</span>
                    @if (!in_array($gallery->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="description" id="input-description" class="form-control d-none" style="height:150px">{{ old('description', $gallery->description) }}</textarea>
                    </div>
                    <button id="save-btn-description" class="btn btn-sm btn-light d-none" onclick="updateField('description', {{ $gallery->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-description" class="no-print btn btn-sm edit-button" onclick="enableEditing('description')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">File</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <!-- If the file is uploaded, show View link -->
                    @if($gallery->hasMedia('gallery'))
                    <a href="{{ $gallery->getFirstMediaUrl('gallery') }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if (!in_array($gallery->status, ['published', 'archived']))
                    <div class="no-print">
                        <label for="file" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $gallery->hasMedia('gallery') ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $gallery->hasMedia('gallery') ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="file" name="file" class="d-none file-input">
                    </div>
                    @endif
                </td>
            </tr>


        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 4 / 3
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('file', file);
                formData.append('id', "{{ $gallery->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.gallery.uploadFile') }}"
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

    });

    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();
        const url = "{{ route('admin.gallery.updateField') }}";
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