<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">

<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>

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
                               id="commentsSwitch" 
                               role="switch"
                               {{ $DevelopmentProject->comments_allowed ? 'checked' : '' }}
                               data-url="{{ route('admin.development_projects.comments', $DevelopmentProject->id) }}">
                    </div>
                </td>
            </tr>
            
            <!-- File Name -->
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $DevelopmentProject->name }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="text" id="input-name" value="{{ $DevelopmentProject->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Commnsecement Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-commencement_date">{{ $DevelopmentProject->commencement_date }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="date" id="input-commencement_date" value="{{ $DevelopmentProject->commencement_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('commencement_date', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-commencement_date" class="btn btn-sm btn-light d-none" onclick="updateField('commencement_date', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-commencement_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('commencement_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Introduction</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-introduction">{!! $DevelopmentProject->introduction !!}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <div class="mb-3 w-100">
                        <textarea name="introduction" id="input-introduction" class="form-control d-none" style="height:150px">{!! old('introduction', $DevelopmentProject->introduction) !!}</textarea>
                    </div>
                    <button id="save-btn-introduction" class="btn btn-sm btn-light d-none" onclick="updateField('introduction', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-introduction" class="no-print btn btn-sm edit-button" onclick="enableEditing('introduction')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
            <tr>
                <th class="table-cell">Total Cost</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-total_cost">{{ $DevelopmentProject->total_cost }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="text" id="input-total_cost" value="{{ $DevelopmentProject->total_cost }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('total_cost', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-total_cost" class="btn btn-sm btn-light d-none" onclick="updateField('total_cost', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-total_cost" class="no-print btn btn-sm edit-button" onclick="enableEditing('total_cost')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-district_id">{{ $DevelopmentProject->district->name }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <select id="input-district_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('district_id', {{ $DevelopmentProject->id }})">
                        @foreach ($cat['districts'] as $district)
                        <option value="{{ $district->id }}" {{ $DevelopmentProject->district_id == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-district_id" class="btn btn-sm btn-light d-none" onclick="updateField('district_id', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-district_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('district_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Chief Engineer</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-ce_id">{{ $DevelopmentProject->chiefEngineer?->name }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <select id="input-ce_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('ce_id', {{ $DevelopmentProject->id }})">
                        @foreach ($cat['chiefEngineers'] as $chief)
                        <option value="{{ $chief->id }}" {{ $DevelopmentProject->ce_id == $chief->id ? 'selected' : '' }}>
                            {{ $chief->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-ce_id" class="btn btn-sm btn-light d-none" onclick="updateField('ce_id', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-ce_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('ce_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Progress Percentage</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-progress_percentage">{{ $DevelopmentProject->progress_percentage }}</span>
                    @if ($DevelopmentProject->status !== ['Completed'])
                    <input type="range" id="input-progress_percentage" value="{{ $DevelopmentProject->progress_percentage }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('progress_percentage', {{ $DevelopmentProject->id }})" />
                    <button id="save-btn-progress_percentage" class="btn btn-sm btn-light d-none" onclick="updateField('progress_percentage', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-progress_percentage" class="no-print btn btn-sm edit-button" onclick="enableEditing('progress_percentage')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-status">{{ $DevelopmentProject->status }}</span>
                    @if (!in_array($DevelopmentProject->status, ['Completed']))
                        <select id="input-status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('status', {{ $DevelopmentProject->id }})">
                            @foreach($cat['status'] as $status)
                            <option value="{{ $status }}" {{ $DevelopmentProject->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                            @endforeach
                        </select>
                        <button id="save-btn-status" class="btn btn-sm btn-light d-none" onclick="updateField('status', {{ $DevelopmentProject->id }})"><i class="bi-send-fill"></i></button>
                        <button class="no-print btn btn-sm edit-button" onclick="enableEditing('status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

        </table>

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
                        <input type="hidden" name="commentable_type" value="{{ get_class($DevelopmentProject) }}">
                        <input type="hidden" name="commentable_id" value="{{ $DevelopmentProject->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </div>
            </div>
        </form>

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

        if (field === 'introduction') {
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
        const newValue = (field === 'introduction') ? $('#input-' + field).summernote('code') : $('#input-' + field).val();
        const url = "{{ route('admin.development_projects.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'introduction') {
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
