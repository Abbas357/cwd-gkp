<link href="{{ asset('admin/plugins/summernote/summernote-bs5.min.css') }}" rel="stylesheet">
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
</style>
@php
    $canUpdate = auth()->user()->can('updateField', $vehicle);
    $canUpload = auth()->user()->can('uploadFile', $vehicle);
@endphp
<div class="row vehicles-details">
    <div class="col-md-12">

        <table class="table table-bordered mt-3">

            <tr>
                <th class="table-cell">Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-type">{{ $vehicle->type }}</span>
                    @if ($canUpdate)
                    <select id="input-type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('type', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_type'] as $type)
                        <option value="{{ $type }}" {{ $vehicle->type == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-type" class="btn btn-sm btn-light d-none" onclick="updateField('type', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-type" class="no-print btn btn-sm edit-button" onclick="enableEditing('type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Functional Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-functional_status">{{ $vehicle->functional_status }}</span>
                    @if ($canUpdate)
                    <select id="input-functional_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('functional_status', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_functional_status'] as $functional_status)
                        <option value="{{ $functional_status }}" {{ $vehicle->functional_status == $functional_status ? 'selected' : '' }}>
                            {{ $functional_status }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-functional_status" class="btn btn-sm btn-light d-none" onclick="updateField('functional_status', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-functional_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('functional_status')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Color</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-color">{{ $vehicle->color }}</span>
                    @if ($canUpdate)
                    <select id="input-color" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('color', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_color'] as $color)
                        <option value="{{ $color }}" {{ $vehicle->color == $color ? 'selected' : '' }}>
                            {{ $color }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-color" class="btn btn-sm btn-light d-none" onclick="updateField('color', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-color" class="no-print btn btn-sm edit-button" onclick="enableEditing('color')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Fuel Type</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-fuel_type">{{ $vehicle->fuel_type }}</span>
                    @if ($canUpdate)
                    <select id="input-fuel_type" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('fuel_type', {{ $vehicle->id }})">
                        @foreach ($cat['fuel_type'] as $fuel_type)
                        <option value="{{ $fuel_type }}" {{ $vehicle->fuel_type == $fuel_type ? 'selected' : '' }}>
                            {{ $fuel_type }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-fuel_type" class="btn btn-sm btn-light d-none" onclick="updateField('fuel_type', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-fuel_type" class="no-print btn btn-sm edit-button" onclick="enableEditing('fuel_type')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Brand</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-brand">{{ $vehicle->brand }}</span>
                    @if ($canUpdate)
                    <select id="input-brand" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('brand', {{ $vehicle->id }})">
                        @foreach ($cat['vehicle_brand'] as $brand)
                        <option value="{{ $brand }}" {{ $vehicle->brand == $brand ? 'selected' : '' }}>
                            {{ $brand }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-brand" class="btn btn-sm btn-light d-none" onclick="updateField('brand', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-brand" class="no-print btn btn-sm edit-button" onclick="enableEditing('brand')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Registration Status</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                <span id="text-registration_status">{{ $vehicle->registration_status }}</span>
                @if ($canUpdate)
                <select id="input-registration_status" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('registration_status', {{ $vehicle->id }})">
                    @foreach ($cat['vehicle_registration_status'] as $registration_status)
                    <option value="{{ $registration_status }}" {{ $vehicle->registration_status == $registration_status ? 'selected' : '' }}>
                        {{ $registration_status }}
                    </option>
                    @endforeach
                </select>
                <button id="save-btn-registration_status" class="btn btn-sm btn-light d-none" onclick="updateField('registration_status', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                <button id="edit-btn-registration_status" class="no-print btn btn-sm edit-button" onclick="enableEditing('registration_status')"><i class="bi-pencil fs-6"></i></button>
                @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Model</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-model">{{ $vehicle->model }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-model" value="{{ $vehicle->model }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('model', {{ $vehicle->id }})" />
                    <button id="save-btn-model" class="btn btn-sm btn-light d-none" onclick="updateField('model', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-model" class="no-print btn btn-sm edit-button" onclick="enableEditing('model')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Registration Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-registration_number">{{ $vehicle->registration_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-registration_number" value="{{ $vehicle->registration_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('registration_number', {{ $vehicle->id }})" />
                    <button id="save-btn-registration_number" class="btn btn-sm btn-light d-none" onclick="updateField('registration_number', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-registration_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('registration_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Model Year</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-model_year">{{ $vehicle->model_year }}</span>
                    @if ($canUpdate)
                    <input type="date" id="input-model_year" value="{{ $vehicle->model_year }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('model_year', {{ $vehicle->id }})" />
                    <button id="save-btn-model_year" class="btn btn-sm btn-light d-none" onclick="updateField('model_year', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-model_year" class="no-print btn btn-sm edit-button" onclick="enableEditing('model_year')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Chassis Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-chassis_number">{{ $vehicle->chassis_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-chassis_number" value="{{ $vehicle->chassis_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('chassis_number', {{ $vehicle->id }})" />
                    <button id="save-btn-chassis_number" class="btn btn-sm btn-light d-none" onclick="updateField('chassis_number', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-chassis_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('chassis_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Engine Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-engine_number">{{ $vehicle->engine_number }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-engine_number" value="{{ $vehicle->engine_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('engine_number', {{ $vehicle->id }})" />
                    <button id="save-btn-engine_number" class="btn btn-sm btn-light d-none" onclick="updateField('engine_number', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-engine_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('engine_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Remarks</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-remarks">{{ $vehicle->remarks }}</span>
                    @if ($canUpdate)
                    <div class="mb-3 w-100">
                        <textarea name="remarks" id="input-remarks" class="form-control d-none" style="height:150px">{!! old('remarks', $vehicle->remarks) !!}</textarea>
                    </div>
                    <button id="save-btn-remarks" class="btn btn-sm btn-light d-none" onclick="updateField('remarks', {{ $vehicle->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-remarks" class="no-print btn btn-sm edit-button" onclick="enableEditing('remarks')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            
        </table>

        <div class="row mt-3 mx-1">
            @php
            $uploads = [
                'vehicle_front_pictures',
                'vehicle_side_pictures',
                'vehicle_rear_pictures',
                'vehicle_interior_pictures',
            ];
            @endphp
            <h3 class="mt-3">Attachments</h3>
            <table class="table table-bordered" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                        <th class="no-print text-center">Add / Update Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploads as $upload)
                    <tr>
                        <td style="max-width: 200px">{{ str_replace('_', ' ', ucwords($upload)) }}</td>
                        <td>
                            @if($vehicle->hasMedia($upload))
                            <a href="{{ $vehicle->getFirstMediaUrl($upload) }}" target="_blank" title="{{ str_replace('_', ' ', ucwords($upload)) }}" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        @if ($canUpload)
                        <td class="no-print text-center">
                            <label for="{{ $upload }}" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $vehicle->hasMedia($upload) ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                            </label>
                            <input type="file" id="{{ $upload }}" name="{{ $upload }}" class="d-none file-input" data-collection="{{ $upload }}">
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
        
    </div>
</div>
<script src="{{ asset('admin/plugins/summernote/summernote-bs5.min.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>

    imageCropper({
        fileInput: '.file-input'
        , aspectRatio: 3 / 4
        , onComplete: async function(file, input) {
            var formData = new FormData();
            formData.append('file', file);
            formData.append('collection', input.dataset.collection);
            formData.append('_method', "PATCH");

            const url = "{{ route('admin.apps.vehicles.uploadFile', ':id') }}".replace(':id', '{{ $vehicle->id }}');
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

        const url = "{{ route('admin.apps.vehicles.updateField', ':id') }}".replace(':id', id);
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
