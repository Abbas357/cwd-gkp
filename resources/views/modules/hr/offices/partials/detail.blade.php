<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $office);
@endphp
<div class="row offices-details">
    <div class="col-md-12">
        <table class="table table-bordered mt-3">            
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $office->name }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-name" value="{{ $office->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $office->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $office->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $office->type }}</span>
                    @if ($canUpdate)
                    <select id="input-type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('type', {{ $office->id }})">
                        @foreach ($cat['officeTypes'] as $type)
                        <option value="{{ $type }}" {{ $office->type == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $office->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Contact Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-contact_number">{{ $office->contact_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-contact_number" value="{{ $office->contact_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('contact_number', {{ $office->id }})" />
                    <button id="save-btn-contact_number" class="btn btn-sm btn-light d-none" onclick="updateField('contact_number', {{ $office->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-contact_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('contact_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Parent Office</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-parent_id">{{ $office->parent?->name }}</span>
                    @if ($canUpdate)
                    <select id="input-parent_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('parent_id', {{ $office->id }})">
                        @foreach ($cat['offices'] as $parent)
                        <option value="{{ $parent->id }}" {{ $office->parent_id == $parent->id ? 'selected' : '' }}>
                            {{ $parent?->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-parent_id" class="btn btn-sm btn-light d-none" onclick="updateField('parent_id', {{ $office->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-parent_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('parent_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-district_id">
                        @if ($office->district)
                            <div class="col-md-6">
                                <p><strong>Direct District:</strong></p>
                                <span class="badge bg-primary">{{ $office->district->name }}</span>
                            </div>
                        @else
                            <div class="col-md-6">
                                <p><strong>Direct District:</strong></p>
                                <span class="text-muted">No direct district assigned</span>
                            </div>
                        @endif

                        <div class="col-md-6">
                            <p><strong>Managed Districts:</strong></p>
                            @php
                                $managedDistricts = $office->getAllManagedDistricts();
                            @endphp
                            
                            @if($managedDistricts->count() > 0)
                                @foreach($managedDistricts as $district)
                                    <span class="badge bg-secondary mb-1 me-1">{{ $district->name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">No managed districts</span>
                            @endif
                        </div>
                    </span>
                    @if ($canUpdate)
                    <select id="input-district_id" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('district_id', {{ $office->id }})">
                        @foreach ($cat['districts'] as $district)
                        <option value="{{ $district->id }}" {{ $office->district_id == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-district_id" class="btn btn-sm btn-light d-none" onclick="updateField('district_id', {{ $office->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-district_id" class="no-print btn btn-sm edit-button" onclick="enableEditing('district_id')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Job Description</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-job_description">{!! $office->job_description !!}</span>
                    @if ($canUpdate)
                    <div class="mb-3 w-100">
                        <textarea name="job_description" id="input-job_description" class="form-control d-none" style="height:150px">{{ old('job_description', $office->job_description) }}</textarea>
                    </div>
                    <button id="save-btn-job_description" class="btn btn-sm btn-light d-none" onclick="updateField('job_description', {{ $office->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-job_description" class="no-print btn btn-sm edit-button" onclick="enableEditing('job_description')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script>
    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');

        if (field === 'job_description') {
            var textarea = $('#input-' + field);
            if (textarea.data('summernote-initialized')) {
                textarea.summernote('destroy'); 
            }
            textarea.summernote({
                height: 300
            });
            textarea.data('summernote-initialized', true);
        }
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();
        const url = "{{ route('admin.apps.hr.offices.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data);
        if (success) {
            if (field === 'job_description') {
                $('#text-' + field).html(newValue);
                $('#input-' + field).summernote('destroy');
                $('#input-' + field).data('summernote-initialized', false);
            } else {
                $('#text-' + field).text(newValue);
            }
            $('#text-' + field).text(newValue);
            $('#input-' + field).addClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#edit-btn-' + field).removeClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }
</script>
