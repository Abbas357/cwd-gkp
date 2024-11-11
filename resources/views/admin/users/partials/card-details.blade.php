<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }

</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row user-details">
    <div class="col-md-12">
        <button type="button" id="print-user-details" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
            <span class="d-flex align-items-center">
                <i class="bi-print"></i>
                Print
            </span>
        </button>
    </div>
    <div class="col-md-12">
        <div class="d-flex justify-content-center align-items-center">
            <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                <img id="image-label-preview" src="{{ getProfilePic($user) }}" alt="avatar" class="change-image img-fluid rounded-circle">
                @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="file" id="image" name="image" class="sr-only" id="input" name="image" accept="image/*">
                @endif
            </label>
        </div>
        <h3 class="display-3 fs-3 text-center"> {{ $user->name }}</h3>
        <h3 class="fs-6  text-center"> {{ $user->designation }} ({{ $user->bps }})</h3>
        <hr>

        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell"> Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $user->name }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-name" value="{{ $user->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $user->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Father Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-father_name">{{ $user->father_name }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-father_name" value="{{ $user->father_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('father_name', {{ $user->id }})" />
                    <button id="save-btn-father_name" class="btn btn-sm btn-light d-none" onclick="updateField('father_name', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-father_name" class="no-print btn btn-sm edit-button" onclick="enableEditing('father_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Date of Birth</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-date_of_birth">{{ $user->date_of_birth }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="date" id="input-date_of_birth" value="{{ $user->date_of_birth }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('date_of_birth', {{ $user->id }})" />
                    <button id="save-btn-date_of_birth" class="btn btn-sm btn-light d-none" onclick="updateField('date_of_birth', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-date_of_birth" class="no-print btn btn-sm edit-button" onclick="enableEditing('date_of_birth')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> CNIC</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-cnic">{{ $user->cnic }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-cnic" value="{{ $user->cnic }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('cnic', {{ $user->id }})" />
                    <button id="save-btn-cnic" class="btn btn-sm btn-light d-none" onclick="updateField('cnic', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-cnic" class="no-print btn btn-sm edit-button" onclick="enableEditing('cnic')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-email">{{ $user->email }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-email" value="{{ $user->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $user->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-email" class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Personnel Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-personnel_number">{{ $user->personnel_number }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-personnel_number" value="{{ $user->personnel_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('personnel_number', {{ $user->id }})" />
                    <button id="save-btn-personnel_number" class="btn btn-sm btn-light d-none" onclick="updateField('personnel_number', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-personnel_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('personnel_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Mobile Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-mobile_number">{{ $user->mobile_number }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-mobile_number" value="{{ $user->mobile_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mobile_number', {{ $user->id }})" />
                    <button id="save-btn-mobile_number" class="btn btn-sm btn-light d-none" onclick="updateField('mobile_number', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-mobile_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('mobile_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Landline Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-landline_number">{{ $user->landline_number }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-landline_number" value="{{ $user->landline_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('landline_number', {{ $user->id }})" />
                    <button id="save-btn-landline_number" class="btn btn-sm btn-light d-none" onclick="updateField('landline_number', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-landline_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('landline_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Designation</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-designation">{{ $user->designation }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
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
                <th class="table-cell">BPS</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-bps">{{ $user->bps }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <select id="input-bps" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('bps', {{ $user->id }})">
                        @foreach ($cat['bps'] as $bps)
                        <option value="{{ $bps->name }}" {{ $user->bps == $bps->name ? 'selected' : '' }}>
                            {{ $bps->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-bps" class="btn btn-sm btn-light d-none" onclick="updateField('bps', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-bps" class="no-print btn btn-sm edit-button" onclick="enableEditing('bps')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Office</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-office">{{ $user->office }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
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
                <th class="table-cell"> Mark of Identification</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-mark_of_identification">{{ $user->mark_of_identification }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-mark_of_identification" value="{{ $user->mark_of_identification }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mark_of_identification', {{ $user->id }})" />
                    <button id="save-btn-mark_of_identification" class="btn btn-sm btn-light d-none" onclick="updateField('mark_of_identification', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-mark_of_identification" class="no-print btn btn-sm edit-button" onclick="enableEditing('mark_of_identification')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Blood Group</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-blood_group">{{ $user->blood_group }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <select id="input-blood_group" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('blood_group', {{ $user->id }})">
                        @foreach ($cat['blood_groups'] as $blood_group)
                        <option value="{{ $blood_group }}" {{ $user->blood_group == $blood_group ? 'selected' : '' }}>
                            {{ $blood_group }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-blood_group" class="btn btn-sm btn-light d-none" onclick="updateField('blood_group', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-blood_group" class="no-print btn btn-sm edit-button" onclick="enableEditing('blood_group')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Emergency Contact</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-emergency_contact">{{ $user->emergency_contact }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-emergency_contact" value="{{ $user->emergency_contact }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('emergency_contact', {{ $user->id }})" />
                    <button id="save-btn-emergency_contact" class="btn btn-sm btn-light d-none" onclick="updateField('emergency_contact', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-emergency_contact" class="no-print btn btn-sm edit-button" onclick="enableEditing('emergency_contact')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Parmanent Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-parmanent_address">{{ $user->parmanent_address }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-parmanent_address" value="{{ $user->parmanent_address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('parmanent_address', {{ $user->id }})" />
                    <button id="save-btn-parmanent_address" class="btn btn-sm btn-light d-none" onclick="updateField('parmanent_address', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-parmanent_address" class="no-print btn btn-sm edit-button" onclick="enableEditing('parmanent_address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell"> Present Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-present_address">{{ $user->present_address }}</span>
                    @if (!in_array($user->card_status, ['verified', 'rejected']))
                    <input type="text" id="input-present_address" value="{{ $user->present_address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('present_address', {{ $user->id }})" />
                    <button id="save-btn-present_address" class="btn btn-sm btn-light d-none" onclick="updateField('present_address', {{ $user->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-present_address" class="no-print btn btn-sm edit-button" onclick="enableEditing('present_address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        imageCropper({
            fileInput: '#image'
            , inputLabelPreview: '#image-label-preview'
            , aspectRatio: 5 / 6
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('image', file);
                formData.append('id', "{{ $user->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.users.uploadFile') }}"
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

    $('#print-user-details').on('click', () => {
        $(".user-details").printThis({
            pageTitle: "Details of {{ $user->name }}",
            beforePrint() {
                document.querySelector('.page-loader').classList.remove('hidden');
            },
            afterPrint() {
                document.querySelector('.page-loader').classList.add('hidden');
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
        const url = "{{ route('admin.users.updateField') }}";
        const data = {
            id: id
            , field: field
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
