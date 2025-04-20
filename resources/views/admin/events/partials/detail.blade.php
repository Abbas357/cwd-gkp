<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $event);
@endphp
<div class="row events-details">
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
                               {{ $event->comments_allowed ? 'checked' : '' }}
                               data-url="{{ route('admin.events.comments', $event->id) }}">
                    </div>
                </td>
            </tr>

            <!-- File Name -->
            <tr>
                <th class="table-cell">Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $event->title }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <input type="text" id="input-title" value="{{ $event->title }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('title', {{ $event->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Location</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-location">{{ $event->location }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <input type="text" id="input-location" value="{{ $event->location }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('location', {{ $event->id }})" />
                    <button id="save-btn-location" class="btn btn-sm btn-light d-none" onclick="updateField('location', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-location" class="no-print btn btn-sm edit-button" onclick="enableEditing('location')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Description</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-description">{!! $event->description !!}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="description" id="input-description" class="form-control d-none" style="height:150px">{!! old('description', $event->description) !!}</textarea>
                    </div>
                    <button id="save-btn-description" class="btn btn-sm btn-light d-none" onclick="updateField('description', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-description" class="no-print btn btn-sm edit-button" onclick="enableEditing('description')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Start Date & Time</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-start_datetime">{{ $event->start_datetime }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <input type="date" id="input-start_datetime" value="{{ $event->start_datetime }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('start_datetime', {{ $event->id }})" />
                    <button id="save-btn-start_datetime" class="btn btn-sm btn-light d-none" onclick="updateField('start_datetime', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-start_datetime" class="no-print btn btn-sm edit-button" onclick="enableEditing('start_datetime')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">End Date & Time</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="date-end_datetime">{{ $event->end_datetime }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <input type="text" id="input-end_datetime" value="{{ $event->end_datetime }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('end_datetime', {{ $event->id }})" />
                    <button id="save-btn-end_datetime" class="btn btn-sm btn-light d-none" onclick="updateField('end_datetime', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-end_datetime" class="no-print btn btn-sm edit-button" onclick="enableEditing('end_datetime')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Category -->
            <tr>
                <th class="table-cell">Participant Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-participants_type">{{ $event->participants_type }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <select id="input-participants_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('participants_type', {{ $event->id }})">
                        @foreach ($cat['participants_type'] as $participants_type)
                        <option value="{{ $participants_type }}" {{ $event->participants_type == $participants_type ? 'selected' : '' }}>
                            {{ $participants_type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-participants_type" class="btn btn-sm btn-light d-none" onclick="updateField('participants_type', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-participants_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('participants_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Event Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-event_type">{{ $event->event_type }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <select id="input-event_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('event_type', {{ $event->id }})">
                        @foreach ($cat['event_type'] as $event_type)
                        <option value="{{ $event_type }}" {{ $event->event_type == $event_type ? 'selected' : '' }}>
                            {{ $event_type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-event_type" class="btn btn-sm btn-light d-none" onclick="updateField('event_type', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-event_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('event_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Organizer</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-organizer">{{ $event->organizer }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <input type="text" id="input-organizer" value="{{ $event->organizer }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('organizer', {{ $event->id }})" />
                    <button id="save-btn-organizer" class="btn btn-sm btn-light d-none" onclick="updateField('organizer', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-organizer" class="no-print btn btn-sm edit-button" onclick="enableEditing('organizer')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Chairperson</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-chairperson">{{ $event->chairperson }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <input type="text" id="input-chairperson" value="{{ $event->chairperson }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('chairperson', {{ $event->id }})" />
                    <button id="save-btn-chairperson" class="btn btn-sm btn-light d-none" onclick="updateField('chairperson', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-chairperson" class="no-print btn btn-sm edit-button" onclick="enableEditing('chairperson')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">No. of Participants</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-no_of_participants">{{ $event->no_of_participants }}</span>
                    @if ($canUpdate && !in_array($event->status, ['published', 'archived']))
                    <input type="text" id="input-no_of_participants" value="{{ $event->no_of_participants }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('no_of_participants', {{ $event->id }})" />
                    <button id="save-btn-no_of_participants" class="btn btn-sm btn-light d-none" onclick="updateField('no_of_participants', {{ $event->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-no_of_participants" class="no-print btn btn-sm edit-button" onclick="enableEditing('no_of_participants')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
        </table>

        @can('comment', \App\Models\Event::class)
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
                        <input type="hidden" name="commentable_type" value="{{ get_class($event) }}">
                        <input type="hidden" name="commentable_id" value="{{ $event->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </div>
        </form>
        @endcan
        
    </div>
</div>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
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
        const newValue = (field === 'description') ? $('#input-' + field).summernote('code') : $('#input-' + field).val();

        const url = "{{ route('admin.events.updateField', ':id') }}".replace(':id', id);
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
