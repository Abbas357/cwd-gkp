<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">

<link href="{{ asset('admin/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>

<div class="row achievements-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $user->name }}</span>
                    <input type="text" id="input-name" value="{{ $user->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $user->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Desingation</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-designation">{{ $user->designation }}</span>
                    @if (!in_array($user->status, ['published', 'archived']))
                    <select id="input-designation" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('designation', {{ $user->id }})">
                        @foreach ($cat['designations'] as $designation)
                        <option value="{{ $designation->name }}" {{ $user->designation == $designation->name ? 'selected' : '' }}>
                            {{ $designation->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-designation" class="btn btn-sm btn-light d-none" onclick="updateField('designation', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-designation" class="no-print btn btn-sm edit-button" onclick="enableEditing('designation')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Office</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-office">{{ $user->office }}</span>
                    @if (!in_array($user->status, ['published', 'archived']))
                    <select id="input-office" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('office', {{ $user->id }})">
                        @foreach ($cat['offices'] as $office)
                        <option value="{{ $office->name }}" {{ $user->office == $office->name ? 'selected' : '' }}>
                            {{ $office->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-office" class="btn btn-sm btn-light d-none" onclick="updateField('office', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-office" class="no-print btn btn-sm edit-button" onclick="enableEditing('office')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Office Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-office_type">{{ $user->office_type }}</span>
                    @if (!in_array($user->status, ['published', 'archived']))
                    <select id="input-office_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('office_type', {{ $user->id }})">
                        <option value="division" {{ $user->office_type == 'division' ? 'selected' : '' }}>Division</option>
                        <option value="circle" {{ $user->office_type == 'circle' ? 'selected' : '' }}>Circle</option>
                    </select>
                    <button id="save-btn-office_type" class="btn btn-sm btn-light d-none" onclick="updateField('office_type', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-office_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('office_type')"><i class="bi-pencil fs-6"></i></button>
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

        const url = "{{ route('admin.vehicle-users.updateField', ':id') }}".replace(':id', id);
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
