<style>
    .table>:not(caption)>*>* {
        padding: .1rem .5rem !important;
    }
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align:middle
    }
</style>
<link href="{{ asset('plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row registrations-details">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Registration Details</h2>
            <button type="button" id="print-registration" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                <span class="d-flex align-items-center">
                    <i class="bi-print"></i>
                    Print
                </span>
            </button>
        </div>

        <table class="table table-bordered">
            <tr>
                <th class="table-cell">Owner Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-owner_name">{{ $ContractorRegistration->owner_name }}</span>
                    <input type="text" id="input-owner_name" value="{{ $ContractorRegistration->owner_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('owner_name', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-owner_name" class="btn btn-sm btn-light d-none" onclick="updateField('owner_name', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('owner_name')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">District</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-district">{{ $ContractorRegistration->district }}</span>
                    <select id="input-district" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('district', {{ $ContractorRegistration->id }})">
                        @foreach($cat['districts'] as $district)
                        <option value="{{ $district->name }}" {{ $ContractorRegistration->district == $district->name ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-district" class="btn btn-sm btn-light d-none" onclick="updateField('district', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('district')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">PEC Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-pec_number">{{ $ContractorRegistration->pec_number }}</span>
                    <input type="text" id="input-pec_number" value="{{ $ContractorRegistration->pec_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('pec_number', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-pec_number" class="btn btn-sm btn-light d-none" onclick="updateField('pec_number', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('pec_number')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Category Applied</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-category_applied">{{ $ContractorRegistration->category_applied }}</span>
                    <select id="input-category_applied" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('category_applied', {{ $ContractorRegistration->id }})">
                        @foreach($cat['contractor_category'] as $category)
                        <option value="{{ $category->name }}" {{ $ContractorRegistration->category_applied == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-category_applied" class="btn btn-sm btn-light d-none" onclick="updateField('category_applied', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('category_applied')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Contractor Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-contractor_name">{{ $ContractorRegistration->contractor_name }}</span>
                    <input type="text" id="input-contractor_name" value="{{ $ContractorRegistration->contractor_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('contractor_name', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-contractor_name" class="btn btn-sm btn-light d-none" onclick="updateField('contractor_name', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('contractor_name')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-address">{{ $ContractorRegistration->address }}</span>
                    <input type="text" id="input-address" value="{{ $ContractorRegistration->address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('address', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-address" class="btn btn-sm btn-light d-none" onclick="updateField('address', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('address')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">PEC Category</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-pec_category">{{ $ContractorRegistration->pec_category }}</span>
                    <select id="input-pec_category" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('pec_category', {{ $ContractorRegistration->id }})">
                        @foreach($cat['contractor_category'] as $category)
                        <option value="{{ $category->name }}" {{ $ContractorRegistration->pec_category == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button id="save-btn-pec_category" class="btn btn-sm btn-light d-none" onclick="updateField('pec_category', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('pec_category')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">CNIC Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-cnic">{{ $ContractorRegistration->cnic }}</span>
                    <input type="text" id="input-cnic" value="{{ $ContractorRegistration->cnic }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('cnic', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-cnic" class="btn btn-sm btn-light d-none" onclick="updateField('cnic', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('cnic')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">NTN Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-fbr_ntn">{{ $ContractorRegistration->fbr_ntn }}</span>
                    <input type="text" id="input-fbr_ntn" value="{{ $ContractorRegistration->fbr_ntn }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('fbr_ntn', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-fbr_ntn" class="btn btn-sm btn-light d-none" onclick="updateField('fbr_ntn', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('fbr_ntn')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">KPPRA Registration Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-kpra_reg_no">{{ $ContractorRegistration->kpra_reg_no }}</span>
                    <input type="text" id="input-kpra_reg_no" value="{{ $ContractorRegistration->kpra_reg_no }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('kpra_reg_no', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-kpra_reg_no" class="btn btn-sm btn-light d-none" onclick="updateField('kpra_reg_no', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('kpra_reg_no')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-email">{{ $ContractorRegistration->email }}</span>
                    <input type="text" id="input-email" value="{{ $ContractorRegistration->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Mobile Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-mobile_number">{{ $ContractorRegistration->mobile_number }}</span>
                    <input type="text" id="input-mobile_number" value="{{ $ContractorRegistration->mobile_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mobile_number', {{ $ContractorRegistration->id }})" />
                    <button id="save-btn-mobile_number" class="btn btn-sm btn-light d-none" onclick="updateField('mobile_number', {{ $ContractorRegistration->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('mobile_number')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Already enlistments</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-pre_enlistment">
                        {{ is_array(json_decode($ContractorRegistration->pre_enlistment)) ? implode(', ', json_decode($ContractorRegistration->pre_enlistment)) : $ContractorRegistration->pre_enlistment }}
                    </span>
                    <select id="input-pre_enlistment" class="d-none form-control" multiple onkeypress="if (event.key === 'Enter') updateField('pre_enlistment', {{ $ContractorRegistration->id }})">
                        @foreach($cat['provincial_entities'] as $category)
                        <option value="{{ $category->name }}" {{ is_array(json_decode($ContractorRegistration->pre_enlistment)) && in_array($category->name, json_decode($ContractorRegistration->pre_enlistment)) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <button id="save-btn-pre_enlistment" class="btn btn-sm btn-light d-none" onclick="updateField('pre_enlistment', {{ $ContractorRegistration->id }})">
                        <i class="bi-send-fill"></i>
                    </button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('pre_enlistment')"><i class="bi-pencil fs-6"></i></button>
                </td>
            </tr>
            <tr>
                <th class="table-cell">Is Limited</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    {{ $ContractorRegistration->is_limited === 0 ? 'No' : 'Yes' }}
                </td>
            </tr>
            <tr>
                <th class="table-cell">Is Agreed</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    {{ $ContractorRegistration->is_agreed === 0 ? 'No' : 'Yes' }}
                </td>
            </tr>
        </table>

        <div class="row mt-3 mx-1">
            @php
            $uploads = [
            'cnic_front_attachments',
            'cnic_back_attachments',
            'fbr_attachments',
            'kpra_attachments',
            'pec_attachments',
            'form_h_attachments',
            'pre_enlistment_attachments',
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
                            @if($ContractorRegistration->hasMedia($upload))
                            <a href="{{ $ContractorRegistration->getFirstMediaUrl($upload) }}" target="_blank" title="{{ str_replace('_', ' ', ucwords($upload)) }}" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        <td class="no-print text-center">
                            <label for="{{ $upload }}" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $ContractorRegistration->hasMedia($upload) ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                            </label>
                            <input type="file" id="{{ $upload }}" name="{{ $upload }}" class="d-none file-input" data-collection="{{ $upload }}">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
</div>

<script src="{{ asset('plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('plugins/cropper/js/cropper.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mask/jquery.mask.min.js') }}"></script>
<script>
    $(document).ready(function() {

        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 1 / 1.6471
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('file', file);
                formData.append('collection', input.dataset.collection);
                formData.append('id', "{{ $ContractorRegistration->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('registrations.uploadFile') }}"
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

        $('#input-mobile_number').mask('0000-0000000', {
            placeholder: "____-_______"
        });

        $('#input-cnic').mask('00000-0000000-0', {
            placeholder: "_____-_______-_"
        });
    })

    $('#print-registration').on('click', () => {
        $(".registrations-details").printThis({
            pageTitle: "Details of {{ $ContractorRegistration->contractor_name }}"
        });
    });

    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#input-' + field + '~ .edit-button').addClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();
        const url = "{{ route('registrations.updateField') }}";
        const data = {
            id: id
            , field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data, 'Field updated successfully', 'Error updating field');
        if (success) {
            $('#text-' + field).text(newValue);
            $('#input-' + field).addClass('d-none');
            $('#input-' + field + '~ .edit-button').removeClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }

</script>
