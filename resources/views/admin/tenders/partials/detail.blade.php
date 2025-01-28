<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">

<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>

<div class="row tenders-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell">Title</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-title">{{ $tender->title }}</span>
                    @if (!in_array($tender->status, ['published', 'archived']))
                    <input type="text" id="input-title" value="{{ $tender->title }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('title', {{ $tender->id }})" />
                    <button id="save-btn-title" class="btn btn-sm btn-light d-none" onclick="updateField('title', {{ $tender->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-title" class="no-print btn btn-sm edit-button" onclick="enableEditing('title')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Procurement Entity</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-procurement_entity">{{ $tender->procurement_entity }}</span>
                    @if (!in_array($tender->status, ['published', 'archived']))
                    <input type="text" id="input-procurement_entity" value="{{ $tender->procurement_entity }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('procurement_entity', {{ $tender->id }})" />
                    <button id="save-btn-procurement_entity" class="btn btn-sm btn-light d-none" onclick="updateField('procurement_entity', {{ $tender->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-procurement_entity" class="no-print btn btn-sm edit-button" onclick="enableEditing('procurement_entity')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Description</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-description">{!! $tender->description !!}</span>
                    @if (!in_array($tender->status, ['published', 'archived']))
                    <div class="mb-3 w-100">
                        <textarea name="description" id="input-description" class="form-control d-none" style="height:150px">{!! old('description', $tender->description) !!}</textarea>
                    </div>
                    <button id="save-btn-description" class="btn btn-sm btn-light d-none" onclick="updateField('description', {{ $tender->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-description" class="no-print btn btn-sm edit-button" onclick="enableEditing('description')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Date of Advertisement</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-date_of_advertisement">{{ $tender->date_of_advertisement }}</span>
                    @if (!in_array($tender->status, ['published', 'archived']))
                    <input type="date" id="input-date_of_advertisement" value="{{ $tender->date_of_advertisement }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('date_of_advertisement', {{ $tender->id }})" />
                    <button id="save-btn-date_of_advertisement" class="btn btn-sm btn-light d-none" onclick="updateField('date_of_advertisement', {{ $tender->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-date_of_advertisement" class="no-print btn btn-sm edit-button" onclick="enableEditing('date_of_advertisement')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Closing Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="date-closing_date">{{ $tender->closing_date }}</span>
                    @if (!in_array($tender->status, ['published', 'archived']))
                    <input type="text" id="input-closing_date" value="{{ $tender->closing_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('closing_date', {{ $tender->id }})" />
                    <button id="save-btn-closing_date" class="btn btn-sm btn-light d-none" onclick="updateField('closing_date', {{ $tender->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-closing_date" class="no-print btn btn-sm edit-button" onclick="enableEditing('closing_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <!-- File Category -->
            <tr>
                <th class="table-cell">Tender Domain</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-domain">{{ $tender->domain }}</span>
                    @if (!in_array($tender->status, ['published', 'archived']))
                    <select id="input-domain" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('domain', {{ $tender->id }})">
                        @foreach ($cat['tender_domain'] as $domain)
                        <option value="{{ $domain->name }}" {{ $tender->domain == $domain->name ? 'selected' : '' }}>
                            {{ $domain->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-domain" class="btn btn-sm btn-light d-none" onclick="updateField('domain', {{ $tender->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-domain" class="no-print btn btn-sm edit-button" onclick="enableEditing('domain')"><i class="bi-pencil fs-6"></i></button>
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
                        <input type="hidden" name="commentable_type" value="{{ get_class($tender) }}">
                        <input type="hidden" name="commentable_id" value="{{ $tender->id }}">
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
        const url = "{{ route('admin.tenders.updateField', ':id') }}".replace(':id', id);
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
