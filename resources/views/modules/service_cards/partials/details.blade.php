<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align: middle;
    }
    .change-image {
        cursor: pointer;
        width: 150px;
        height: 180px;
        object-fit: cover;
    }
</style>
@php
    $canUpdate = auth_user()->can('updateField', $ServiceCard);
    $canUpload = auth_user()->can('uploadFile', $ServiceCard);
    $user = $ServiceCard->user;
    $profile = $user->profile;
@endphp
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row service_card-details">
    <div class="col-md-12">
        <button type="button" id="print-service_card-details" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
            <span class="d-flex align-items-center">
                <i class="bi-print"></i>
                Print
            </span>
        </button>
    </div>
    <div class="col-md-12">
        <div class="d-flex justify-content-center align-items-center">
            <label class="label" data-toggle="tooltip" title="Change Profile Picture">
                <img id="image-label-preview" src="{{ $user->getFirstMediaUrl('profile_pictures') }}" alt="avatar" class="change-image" style="width:150px; height:150px; border-radius: 50%">
                @if ($canUpload)
                    <input type="file" id="image" name="image" class="visually-hidden" accept="image/*">
                @endif
            </label>
        </div>
        <h3 class="display-3 fs-3 text-center">{{ $user->name }}</h3>
        <h3 class="fs-6 text-center">
            {{ $user->currentDesignation ? $user->currentDesignation->name : 'N/A' }}
            @if($user->currentDesignation && $user->currentDesignation->bps)
                (BPS-{{ $user->currentDesignation->bps }})
            @endif
        </h3>
        <hr>

        <table class="table table-bordered mt-3">
            <tr>
                <th class="table-cell">Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-name">{{ $user->name }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-name" value="{{ $user->name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('name', {{ $ServiceCard->id }})" />
                    <button id="save-btn-name" class="btn btn-sm btn-light d-none" onclick="updateField('name', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-name" class="no-print btn btn-sm edit-button" onclick="enableEditing('name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-email">{{ $user->email }}</span>
                    @if ($canUpdate)
                    <input type="email" id="input-email" value="{{ $user->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $ServiceCard->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-email" class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Father Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-father_name">{{ $profile->father_name ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-father_name" value="{{ $profile->father_name ?? '' }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('father_name', {{ $ServiceCard->id }})" />
                    <button id="save-btn-father_name" class="btn btn-sm btn-light d-none" onclick="updateField('father_name', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-father_name" class="no-print btn btn-sm edit-button" onclick="enableEditing('father_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Date of Birth</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-date_of_birth">{{ $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : 'N/A' }}</span>
                    @if ($canUpdate)
                    <input type="date" id="input-date_of_birth" value="{{ $profile->date_of_birth ? $profile->date_of_birth->format('Y-m-d') : '' }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('date_of_birth', {{ $ServiceCard->id }})" />
                    <button id="save-btn-date_of_birth" class="btn btn-sm btn-light d-none" onclick="updateField('date_of_birth', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-date_of_birth" class="no-print btn btn-sm edit-button" onclick="enableEditing('date_of_birth')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">CNIC</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-cnic">{{ $profile->cnic ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-cnic" value="{{ $profile->cnic ?? '' }}" class="d-none form-control cnic-mask" onkeypress="if (event.key === 'Enter') updateField('cnic', {{ $ServiceCard->id }})" />
                    <button id="save-btn-cnic" class="btn btn-sm btn-light d-none" onclick="updateField('cnic', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-cnic" class="no-print btn btn-sm edit-button" onclick="enableEditing('cnic')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Personnel Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-personnel_number">{{ $profile->personnel_number ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-personnel_number" value="{{ $profile->personnel_number ?? '' }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('personnel_number', {{ $ServiceCard->id }})" />
                    <button id="save-btn-personnel_number" class="btn btn-sm btn-light d-none" onclick="updateField('personnel_number', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-personnel_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('personnel_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Mobile Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-mobile_number">{{ $profile->mobile_number ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-mobile_number" value="{{ $profile->mobile_number ?? '' }}" class="d-none form-control mobile-mask" onkeypress="if (event.key === 'Enter') updateField('mobile_number', {{ $ServiceCard->id }})" />
                    <button id="save-btn-mobile_number" class="btn btn-sm btn-light d-none" onclick="updateField('mobile_number', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-mobile_number" class="no-print btn btn-sm edit-button" onclick="enableEditing('mobile_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Mark of Identification</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-mark_of_identification">{{ $profile->mark_of_identification ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-mark_of_identification" value="{{ $profile->mark_of_identification ?? '' }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mark_of_identification', {{ $ServiceCard->id }})" />
                    <button id="save-btn-mark_of_identification" class="btn btn-sm btn-light d-none" onclick="updateField('mark_of_identification', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-mark_of_identification" class="no-print btn btn-sm edit-button" onclick="enableEditing('mark_of_identification')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Blood Group</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-blood_group">{{ $profile->blood_group ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <select id="input-blood_group" class="d-none form-control" onchange="updateField('blood_group', {{ $ServiceCard->id }})">
                        <option value="">Select Blood Group</option>
                        @foreach ($cat['blood_groups'] as $blood_group)
                        <option value="{{ $blood_group }}" {{ ($profile->blood_group == $blood_group) ? 'selected' : '' }}>
                            {{ $blood_group }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-blood_group" class="btn btn-sm btn-light d-none" onclick="updateField('blood_group', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-blood_group" class="no-print btn btn-sm edit-button" onclick="enableEditing('blood_group')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Emergency Contact</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-emergency_contact">{{ $profile->emergency_contact ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <input type="text" id="input-emergency_contact" value="{{ $profile->emergency_contact ?? '' }}" class="d-none form-control mobile-mask" onkeypress="if (event.key === 'Enter') updateField('emergency_contact', {{ $ServiceCard->id }})" />
                    <button id="save-btn-emergency_contact" class="btn btn-sm btn-light d-none" onclick="updateField('emergency_contact', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-emergency_contact" class="no-print btn btn-sm edit-button" onclick="enableEditing('emergency_contact')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Permanent Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-permanent_address">{{ $profile->permanent_address ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <textarea id="input-permanent_address" class="d-none form-control" rows="2">{{ $profile->permanent_address ?? '' }}</textarea>
                    <button id="save-btn-permanent_address" class="btn btn-sm btn-light d-none" onclick="updateField('permanent_address', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-permanent_address" class="no-print btn btn-sm edit-button" onclick="enableEditing('permanent_address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Present Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    <span id="text-present_address">{{ $profile->present_address ?? 'N/A' }}</span>
                    @if ($canUpdate)
                    <textarea id="input-present_address" class="d-none form-control" rows="2">{{ $profile->present_address ?? '' }}</textarea>
                    <button id="save-btn-present_address" class="btn btn-sm btn-light d-none" onclick="updateField('present_address', {{ $ServiceCard->id }})"><i class="bi-send-fill"></i></button>
                    <button id="edit-btn-present_address" class="no-print btn btn-sm edit-button" onclick="enableEditing('present_address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">CNIC Front</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @php
                    $hasAttachments = $user->hasMedia('users_cnic_front');
                    $fileUrl = $hasAttachments ? $user->getFirstMediaUrl('users_cnic_front') : null;
                    @endphp

                    @if($hasAttachments)
                    <a href="{{ $fileUrl }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if ($canUpload)
                    <div class="no-print">
                        <label for="cnic-front" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $hasAttachments ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $hasAttachments ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="cnic-front" name="cnic-front" class="d-none file-input">
                    </div>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">CNIC Back</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @php
                    $hasAttachments = $user->hasMedia('users_cnic_back');
                    $fileUrl = $hasAttachments ? $user->getFirstMediaUrl('users_cnic_back') : null;
                    @endphp

                    @if($hasAttachments)
                    <a href="{{ $fileUrl }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if ($canUpload)
                    <div class="no-print">
                        <label for="cnic-back" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $hasAttachments ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $hasAttachments ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="cnic-back" name="cnic-back " class="d-none file-input">
                    </div>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Covering Letter</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @php
                    $hasAttachments = $ServiceCard->hasMedia('covering_letters');
                    $fileUrl = $hasAttachments ? $ServiceCard->getFirstMediaUrl('covering_letters') : null;
                    @endphp

                    @if($hasAttachments)
                    <a href="{{ $fileUrl }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if ($canUpload)
                    <div class="no-print">
                        <label for="covering-letter" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $hasAttachments ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $hasAttachments ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="covering-letter" name="covering-letter " class="d-none file-input">
                    </div>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Pay Slip (Preferably last month)</th>
                <td class="d-flex justify-content-between align-items-center gap-2">
                    @php
                    $hasAttachments = $ServiceCard->hasMedia('payslips');
                    $fileUrl = $hasAttachments ? $ServiceCard->getFirstMediaUrl('payslips') : null;
                    @endphp

                    @if($hasAttachments)
                    <a href="{{ $fileUrl }}" target="_blank" title="File" class="d-flex align-items-center gap-2">
                        View
                    </a>
                    @else
                    <span>Not Uploaded</span>
                    @endif

                    @if ($canUpload)
                    <div class="no-print">
                        <label for="payslip" class="btn btn-sm btn-light">
                            <span class="d-flex align-items-center">
                                <i class="bi-{{ $hasAttachments ? 'pencil-square' : 'plus-circle' }}"></i>&nbsp;
                                {{ $hasAttachments ? 'Update' : 'Add' }}
                            </span>
                        </label>
                        <input type="file" id="payslip" name="payslip" class="d-none file-input">
                    </div>
                    @endif
                </td>
            </tr>

            <tr>
                <th class="table-cell">Status</th>
                <td>
                    <span class="badge bg-{{ $ServiceCard->status == 'active' ? 'success' : ($ServiceCard->status == 'rejected' ? 'danger' : 'secondary') }}">
                        {{ ucfirst($ServiceCard->status) }}
                    </span>
                </td>
            </tr>

            @if($ServiceCard->issued_at)
            <tr>
                <th class="table-cell">Issue Date</th>
                <td>{{ $ServiceCard->issued_at->format('d M, Y') }}</td>
            </tr>
            @endif

            @if($ServiceCard->expired_at)
            <tr>
                <th class="table-cell">Expiry Date</th>
                <td>{{ $ServiceCard->expired_at->format('d M, Y') }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>

<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Initialize masks
        $('.cnic-mask').mask('00000-0000000-0', {
            placeholder: "_____-_______-_"
        });
        
        $('.mobile-mask').mask('0000-0000000', {
            placeholder: "____-_______"
        });

        imageCropper({
            fileInput: '#image',
            inputLabelPreview: '#image-label-preview',
            aspectRatio: 5 / 6,
            onComplete: async function(file, input) {
                var formData = new FormData();
                const realFile = file[0] instanceof File ? file[0] : file;
                formData.append('attachment', realFile);
                formData.append('collection_name', 'profile_pictures');
                formData.append('_method', "POST");

                const url = "{{ route('admin.apps.service_cards.users.uploadFile', ':id') }}".replace(':id', '{{ $ServiceCard->id }}');
                try {
                    const result = await fetchRequest(url, 'POST', formData);
                    if (result) {
                        $(input).closest('.modal').modal('toggle');
                        showNotification('Image uploaded successfully', 'success');
                    }
                } catch (error) {
                    console.error('Error during form submission:', error);
                    showNotification('Error uploading image', 'error');
                }
            }
        });

        const fileUploaders = [
            { selector: '#cnic-front', collection: 'users_cnic_front', ratio: 1.59 / 1 },
            { selector: '#cnic-back', collection: 'users_cnic_back', ratio: 1.59 / 1 },
            { selector: '#covering-letter', collection: 'covering_letters', ratio: 1 / 1.41 },
            { selector: '#payslip', collection: 'payslips', ratio: 1 / 1.41 }
        ];

        fileUploaders.forEach(function(uploader) {
            imageCropper({
                fileInput: uploader.selector,
                aspectRatio: uploader.ratio,
                onComplete: async function(files, input) {
                    var formData = new FormData();
                    const realFile = files[0] instanceof File ? files[0] : files;
                    formData.append('attachment', realFile);
                    formData.append('collection_name', uploader.collection);
                    formData.append('_method', "POST");

                    const url = "{{ route('admin.apps.service_cards.users.uploadFile', ':id') }}".replace(':id', '{{ $ServiceCard->id }}');
                    try {
                        const result = await fetchRequest(url, 'POST', formData);
                        if (result) {
                            showNotification('Image uploaded successfully', 'success');
                            location.reload();
                        }
                    } catch (error) {
                        console.error('Error during form submission:', error);
                        showNotification('Error uploading image', 'error');
                    }
                }
            });
        });
        
    });

    $('#print-service_card-details').on('click', () => {
        $(".service_card-details").printThis({
            pageTitle: "Service Card Details - {{ $user->name }}",
            beforePrint() {
                document.querySelector('.page-loader')?.classList.remove('hidden');
            },
            afterPrint() {
                document.querySelector('.page-loader')?.classList.add('hidden');
            }
        });
    });

    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
        $('#edit-btn-' + field).addClass('d-none');
        
        // Apply masks when enabling editing
        if (field === 'cnic') {
            $('#input-cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });
        } else if (field === 'mobile_number' || field === 'emergency_contact') {
            $('#input-' + field).mask('0000-0000000', {
                placeholder: "____-_______"
            });
        }
        
        // Focus on the input
        $('#input-' + field).focus();
    }

    async function updateField(field, id) {
        const inputElement = $('#input-' + field);
        const newValue = inputElement.val();
        
        if (!newValue && ['name', 'email', 'cnic', 'personnel_number'].includes(field)) {
            showNotification('This field is required', 'error');
            return;
        }
        
        const url = "{{ route('admin.apps.service_cards.users.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field,
            value: newValue
        };
        
        try {
            const success = await fetchRequest(url, 'PATCH', data);
            if (success) {
                // Update display text
                if (field === 'designation_id') {
                    const selectedText = $('#input-designation_id option:selected').text();
                    $('#text-designation').text(selectedText.trim() || 'N/A');
                } else if (field === 'office_id') {
                    const selectedText = $('#input-office_id option:selected').text();
                    $('#text-office').text(selectedText.trim() || 'N/A');
                } else {
                    $('#text-' + field).text(newValue || 'N/A');
                }
                
                // Hide input and show text
                $('#input-' + field).addClass('d-none');
                $('#save-btn-' + field).addClass('d-none');
                $('#edit-btn-' + field).removeClass('d-none');
                $('#text-' + field).removeClass('d-none');
                
                showNotification('Field updated successfully', 'success');
            }
        } catch (error) {
            console.error('Error updating field:', error);
            showNotification('Error updating field', 'error');
        }
    }
</script>