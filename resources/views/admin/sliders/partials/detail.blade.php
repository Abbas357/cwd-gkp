<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }

</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<div class="row downloads-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell"> Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $slider->title }}</span>
                    @if (!in_array($slider->status, ['published', 'archived']))
                    <input type="text" id="input-title" value="{{ $slider->title }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('title', {{ $slider->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $slider->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Type -->
            <tr>
                <th class="table-cell">Order</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-order">{{ $slider->order }}</span>
                    @if (!in_array($slider->status, ['published', 'archived']))
                    <select id="input-order" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('order', {{ $slider->id }})">
                        <option value="1" {{ $slider->order == 1 ? 'selected' : '' }}>1</option>
                        <option value="2" {{ $slider->order == 2 ? 'selected' : '' }}>2</option>
                        <option value="3" {{ $slider->order == 3 ? 'selected' : '' }}>3</option>
                        <option value="4" {{ $slider->order == 4 ? 'selected' : '' }}>4</option>
                        <option value="5" {{ $slider->order == 5 ? 'selected' : '' }}>5</option>
                    </select>
                    <button id="save-btn-order" class="btn btn-sm btn-light d-none" onclick="updateField('order', {{ $slider->id }})">
                        <i class="bi-send-fill"></i>
                    </button>
                    <button id="edit-btn-order" class="no-print btn btn-sm edit-button" onclick="enableEditing('order')">
                        <i class="bi-pencil fs-6"></i>
                    </button>
                    @endif
                </td>
            </tr>
            
            <tr>
                <th class="table-cell">Short Description</th>
                <td class="d-flex justify-summary-between align-items-center gap-2">
                    <span id="text-summary">{!! $slider->summary !!}</span>
                    @if (!in_array($slider->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="summary" id="input-summary" class="form-control d-none" style="height:150px">{!! old('summary', $slider->summary) !!}</textarea>
                    </div>
                    <button id="save-btn-summary" class="btn btn-sm btn-light d-none" onclick="updateField('summary', {{ $slider->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-summary" class="no-print btn btn-sm edit-button" onclick="enableEditing('summary')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Content</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-description">{!! $slider->description !!}</span>
                    @if (!in_array($slider->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="description" id="input-description" class="form-control d-none" style="height:150px">{!! old('description', $slider->description) !!}</textarea>
                    </div>
                    <button id="save-btn-description" class="btn btn-sm btn-light d-none" onclick="updateField('description', {{ $slider->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-description" class="no-print btn btn-sm edit-button" onclick="enableEditing('description')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">File</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @php
                    $hasAttachments = $slider->hasMedia('sliders');
                    $imageUrl = $hasAttachments ? $slider->getFirstMediaUrl('sliders') : null;
                    @endphp

                    @if($hasAttachments)
                    <a href="{{ $imageUrl }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if (!in_array($slider->status, ['published', 'archived']))
                    <div class="no-print">
                        <label for="image" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $hasAttachments ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $hasAttachments ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="image" name="image" class="d-none file-input">
                    </div>
                    @endif
                </td>
            </tr>

        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 4 / 3
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('image', file);
                formData.append('id', "{{ $slider->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.sliders.uploadFile') }}"
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

        if (field === 'description') {
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
        const newValue = (field === 'content') ? $('#input-' + field).summernote('code') : $('#input-' + field).val();
        const url = "{{ route('admin.sliders.updateField') }}";
        const data = {
            id: id
            , field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'description') {
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
