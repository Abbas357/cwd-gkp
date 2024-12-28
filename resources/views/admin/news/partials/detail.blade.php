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
                    <span id="text-title">{{ $news->title }}</span>
                    @if (!in_array($news->status, ['published', 'archived']))
                    <input type="text" id="input-title" value="{{ $news->title }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('title', {{ $news->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $news->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Type -->
            <tr>
                <th class="table-cell">Category</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-category">{{ $news->category }}</span>
                    @if (!in_array($news->status, ['published', 'archived']))
                    <select id="input-category" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('category', {{ $news->id }})">
                        @foreach ($cat['news_category'] as $category)
                        <option value="{{ $category->name }}" {{ $news->category == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-category" class="btn btn-sm btn-light d-none" onclick="updateField('category', {{ $news->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-category" class="no-print btn btn-sm edit-button" onclick="enableEditing('category')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Short Description</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-summary">{!! $news->summary !!}</span>
                    @if (!in_array($news->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="summary" id="input-summary" class="form-control d-none" style="height:150px">{!! old('summary', $news->summary) !!}</textarea>
                    </div>
                    <button id="save-btn-summary" class="btn btn-sm btn-light d-none" onclick="updateField('summary', {{ $news->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-summary" class="no-print btn btn-sm edit-button" onclick="enableEditing('summary')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            <tr>
                <th class="table-cell">Content</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-content">{!! $news->content !!}</span>
                    @if (!in_array($news->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="content" id="input-content" class="form-control d-none" style="height:150px">{!! old('content', $news->content) !!}</textarea>
                    </div>
                    <button id="save-btn-content" class="btn btn-sm btn-light d-none" onclick="updateField('content', {{ $news->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-content" class="no-print btn btn-sm edit-button" onclick="enableEditing('content')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">File</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @php
                    $hasAttachments = $news->hasMedia('news_attachments');
                    $attachmentUrl = $hasAttachments ? $news->getFirstMediaUrl('news_attachments') : null;
                    @endphp

                    @if($hasAttachments)
                    <a href="{{ $attachmentUrl }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if (!in_array($news->status, ['published', 'archived']))
                    <div class="no-print">
                        <label for="attachment" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $hasAttachments ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $hasAttachments ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="attachment" name="attachment" class="d-none file-input">
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
                formData.append('attachment', file);
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.news.uploadFile', ':id') }}".replace(':id', '{{ $news->id }}');
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

        if (field === 'content') {
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
        const url = "{{ route('admin.news.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'content') {
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
