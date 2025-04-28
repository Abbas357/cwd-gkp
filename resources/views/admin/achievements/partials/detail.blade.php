<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $achievement);
@endphp

<div class="row achievements-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell">Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $achievement->title }}</span>
                    @if ($canUpdate && !in_array($achievement->status, ['published', 'archived']))
                    <input type="text" id="input-title" value="{{ $achievement->title }}" class="d-none form-control" onkeypress="if (achievement.key === 'Enter') updateField('title', {{ $achievement->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $achievement->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Start Date & Time</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-start_datetime">{{ $achievement->start_datetime }}</span>
                    @if ($canUpdate && !in_array($achievement->status, ['published', 'archived']))
                    <input type="date" id="input-start_datetime" value="{{ $achievement->start_datetime }}" class="d-none form-control" onkeypress="if (achievement.key === 'Enter') updateField('start_datetime', {{ $achievement->id }})" />
                    <button id="save-btn-start_datetime" class="btn btn-sm btn-light d-none" onclick="updateField('start_datetime', {{ $achievement->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-start_datetime" class="no-print btn btn-sm edit-button" onclick="enableEditing('start_datetime')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">End Date & Time</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="date-end_datetime">{{ $achievement->end_datetime }}</span>
                    @if ($canUpdate && !in_array($achievement->status, ['published', 'archived']))
                    <input type="text" id="input-end_datetime" value="{{ $achievement->end_datetime }}" class="d-none form-control" onkeypress="if (achievement.key === 'Enter') updateField('end_datetime', {{ $achievement->id }})" />
                    <button id="save-btn-end_datetime" class="btn btn-sm btn-light d-none" onclick="updateField('end_datetime', {{ $achievement->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-end_datetime" class="no-print btn btn-sm edit-button" onclick="enableEditing('end_datetime')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Location</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-location">{{ $achievement->location }}</span>
                    @if ($canUpdate && !in_array($achievement->status, ['published', 'archived']))
                    <input type="text" id="input-location" value="{{ $achievement->location }}" class="d-none form-control" onkeypress="if (achievement.key === 'Enter') updateField('location', {{ $achievement->id }})" />
                    <button id="save-btn-location" class="btn btn-sm btn-light d-none" onclick="updateField('location', {{ $achievement->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-location" class="no-print btn btn-sm edit-button" onclick="enableEditing('location')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Content</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-content">{!! $achievement->content !!}</span>
                    @if ($canUpdate && !in_array($achievement->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="content" id="input-content" class="form-control d-none" style="height:150px">{!! old('content', $achievement->content) !!}</textarea>
                    </div>
                    <button id="save-btn-content" class="btn btn-sm btn-light d-none" onclick="updateField('content', {{ $achievement->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-content" class="no-print btn btn-sm edit-button" onclick="enableEditing('content')"><i class="bi-pencil fs-6"></i></button>
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

        const url = "{{ route('admin.achievements.updateField', ':id') }}".replace(':id', id);
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
