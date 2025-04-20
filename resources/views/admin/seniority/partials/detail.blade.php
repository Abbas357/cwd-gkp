<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
@php
    $canUpdate = auth()->user()->can('updateField', $seniority);
    $canUpload = auth()->user()->can('uploadFile', $seniority);
@endphp
<div class="row seniority-details">
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
                               {{ $seniority->comments_allowed ? 'checked' : '' }}
                               data-url="{{ route('admin.seniority.comments', $seniority->id) }}">
                    </div>
                </td>
            </tr>

            <tr>
                <th class="table-cell">Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $seniority->title }}</span>
                    @if ($canUpdate && !in_array($seniority->status, ['published', 'archived']))
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
                    @if ($canUpdate && !in_array($seniority->status, ['published', 'archived']))
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
                    @if ($canUpdate && !in_array($seniority->status, ['published', 'archived']))
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
                    @if ($canUpload && !in_array($seniority->status, ['published', 'archived']))
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
        @can('comment', \App\Models\Seniority::class)
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
                        <input type="hidden" name="commentable_type" value="{{ get_class($seniority) }}">
                        <input type="hidden" name="commentable_id" value="{{ $seniority->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </div>
        </form>
        @endcan
    </div>
</div>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    
    document.getElementById('commentsSwitch').addEventListener('change', async function() {
        const url = this.dataset.url;
        const newValue = this.checked ? 1 : 0;
        
        const success = await fetchRequest(url, 'PATCH', { comments_allowed: newValue }, 'Comments visibility updated', 'Failed to update');

        if (!success) {
            this.checked = !this.checked;
        }
    });
    
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
