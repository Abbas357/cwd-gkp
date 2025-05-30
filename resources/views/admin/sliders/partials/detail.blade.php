<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
@php
    $canUpdate = auth()->user()->can('updateField', $slider);
    $canUpload = auth()->user()->can('uploadFile', $slider);
@endphp
<div class="row downloads-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">
                    <label class="form-check-label" for="commentsSwitch">
                        Allow Comments
                    </label>
                </th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <div class="form-check form-switch">
                        <input type="checkbox" 
                               class="form-check-input" 
                               {{ !$canUpdate && 'disabled' }}
                               id="commentsSwitch" 
                               role="switch"
                               {{ $slider->comments_allowed ? 'checked' : '' }}
                               data-url="{{ route('admin.sliders.comments', $slider->id) }}">
                    </div>
                </td>
            </tr>

            <!-- File Name -->
            <tr>
                <th class="table-cell"> Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $slider->title }}</span>
                    @if ($canUpdate && !in_array($slider->status, ['published', 'archived']))
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
                    @if ($canUpdate && !in_array($slider->status, ['published', 'archived']))
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
                    @if ($canUpdate && !in_array($slider->status, ['published', 'archived']))
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
                    @if ($canUpdate && !in_array($slider->status, ['published', 'archived']))
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

                    @if ($canUpload && !in_array($slider->status, ['published', 'archived']))
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

        @can('comment', \App\Models\Slider::class)
        <form class="needs-validation" action="{{ route('admin.comments.postResponse') }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Add Comment
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <label for="body">Body</label>
                            <textarea name="body" id="body" class="form-control" style="height:100px">{{ old('body') }}</textarea>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control" id="attachment" name="attachment">
                            <img id="previewAttachment" src="#" alt="Attachment Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>
                        <input type="hidden" name="commentable_type" value="{{ get_class($slider) }}">
                        <input type="hidden" name="commentable_id" value="{{ $slider->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </div>
        </form>
        @endcan
    </div>
</div>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    
    document.getElementById('commentsSwitch').addEventListener('change', async function() {
        const url = this.dataset.url;
        const newValue = this.checked ? 1 : 0;
        
        const success = await fetchRequest(
            url,
            'PATCH',
            { comments_allowed: newValue },
            'Comments visibility updated',
            'Failed to update'
        );

        if (!success) {
            this.checked = !this.checked;
        }
    });
    
    $(document).ready(function() {
        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 4 / 3
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('image', file);
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.sliders.uploadFile', ':id') }}".replace(':id', '{{ $slider->id }}');
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
        const url = "{{ route('admin.sliders.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
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
