<style>
    .table-cell {
        padding: 0.1rem 0.5rem;
        vertical-align:middle
    }
</style>
<link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
@php
    $canUpdate = auth()->user()->can('updateField', $Standardization);
    $canUpload = auth()->user()->can('uploadFile', $Standardization);
@endphp
<div class="row standardization-details">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="mb-4">Standardization Details</h3>
            <button type="button" id="print-standardization" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                <span class="d-flex align-items-center">
                    <i class="bi-print"></i>
                    Print
                </span>
            </button>
        </div>

        <table class="table table-bordered">
            <tr>
                <th class="table-cell">Firm Name</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-firm_name">{{ $Standardization->firm_name }}</span>
                    @if ($canUpdate && !in_array($Standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-firm_name" value="{{ $Standardization->firm_name }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('firm_name', {{ $Standardization->id }})" />
                    <button id="save-btn-firm_name" class="btn btn-sm btn-light d-none" onclick="updateField('firm_name', {{ $Standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('firm_name')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Address</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-address">{{ $Standardization->address }}</span>
                    @if ($canUpdate && !in_array($Standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-address" value="{{ $Standardization->address }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('address', {{ $Standardization->id }})" />
                    <button id="save-btn-address" class="btn btn-sm btn-light d-none" onclick="updateField('address', {{ $Standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('address')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Mobile Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-mobile_number">{{ $Standardization->mobile_number }}</span>
                    @if ($canUpdate && !in_array($Standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-mobile_number" value="{{ $Standardization->mobile_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('mobile_number', {{ $Standardization->id }})" />
                    <button id="save-btn-mobile_number" class="btn btn-sm btn-light d-none" onclick="updateField('mobile_number', {{ $Standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('mobile_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Phone Number</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-phone_number">{{ $Standardization->phone_number }}</span>
                    @if ($canUpdate && !in_array($Standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-phone_number" value="{{ $Standardization->phone_number }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('phone_number', {{ $Standardization->id }})" />
                    <button id="save-btn-phone_number" class="btn btn-sm btn-light d-none" onclick="updateField('phone_number', {{ $Standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('phone_number')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Email</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-email">{{ $Standardization->email }}</span>
                    @if ($canUpdate && !in_array($Standardization->status, ['approved', 'rejected']))
                    <input type="text" id="input-email" value="{{ $Standardization->email }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('email', {{ $Standardization->id }})" />
                    <button id="save-btn-email" class="btn btn-sm btn-light d-none" onclick="updateField('email', {{ $Standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('email')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Expiry Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-expiry_date">{{ $Standardization->expiry_date }}</span>
                    @if ($canUpdate && $Standardization->status === 'approved')
                    <input type="date" id="input-expiry_date" value="{{ $Standardization->expiry_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('expiry_date', {{ $Standardization->id }})" />
                    <button id="save-btn-expiry_date" class="btn btn-sm btn-light d-none" onclick="updateField('expiry_date', {{ $Standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('expiry_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="table-cell">Issue Date</th>
                <td class="d-flex justify-content-between align-items-center gap-2" class="table-cell">
                    <span id="text-issue_date">{{ $Standardization->issue_date }}</span>
                    @if ($canUpdate && $Standardization->status === 'approved')
                    <input type="date" id="input-issue_date" value="{{ $Standardization->issue_date }}" class="d-none form-control" onkeypress="if (event.key === 'Enter') updateField('issue_date', {{ $Standardization->id }})" />
                    <button id="save-btn-issue_date" class="btn btn-sm btn-light d-none" onclick="updateField('issue_date', {{ $Standardization->id }})"><i class="bi-send-fill"></i></button>
                    <button class="no-print btn btn-sm edit-button" onclick="enableEditing('issue_date')"><i class="bi-pencil fs-6"></i></button>
                    @endif
                </td>
            </tr>
        </table>

        <div class="row mt-3 mx-1">
            @php
            $uploads = [
                'secp_certificates',
                'iso_certificates',
                'commerse_memberships',
                'pec_certificates',
                'annual_tax_returns',
                'audited_financials',
                'organization_registrations',
                'performance_certificate',
            ];
            @endphp
            <h3 class="mt-3">Attachments</h3>
            <table class="table table-bordered" style="vertical-align: middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                        @if ($canUpdate && !in_array($Standardization->status, ['approved', 'rejected']))
                        <th class="no-print text-center">Add / Update Attachment</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="max-width: 200px">Firm Picture</td>
                        <td>
                            @if($Standardization->hasMedia('standardization_firms_pictures'))
                            <a href="{{ $Standardization->getFirstMediaUrl('standardization_firms_pictures') }}" target="_blank" title="Firm Picture" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        @if ($canUpdate && $Standardization->status === 'approved')
                        <td class="no-print text-center">
                            <label for="firm_pictures" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $Standardization->hasMedia('standardization_firms_pictures') ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
                            </label>
                            <input type="file" id="firm_pictures" name="firm_pictures" class="d-none file-input" data-collection="firm_pictures">
                        </td>
                        @endif
                    </tr>
                    @foreach($uploads as $upload)
                    <tr>
                        <td style="max-width: 200px">{{ str_replace('_', ' ', ucwords($upload)) }}</td>
                        <td>
                            @if($Standardization->hasMedia($upload))
                            <a href="{{ $Standardization->getFirstMediaUrl($upload) }}" target="_blank" title="{{ str_replace('_', ' ', ucwords($upload)) }}" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        @if ($canUpdate && !in_array($Standardization->status, ['approved', 'rejected']))
                        <td class="no-print text-center">
                            <label for="{{ $upload }}" class="btn btn-sm btn-light">
                                <span class="d-flex align-items-center">{!! $Standardization->hasMedia($upload) ? '<i class="bi-pencil-square"></i>&nbsp; Update' : '<i class="bi-plus-circle"></i>&nbsp; Add' !!}</span>
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

<script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    $(document).ready(function() {
        
        imageCropper({
            fileInput: '.file-input'
            , aspectRatio: 1 / 1.6471
            , onComplete: async function(file, input) {
                var formData = new FormData();
                formData.append('file', file);
                formData.append('collection', input.dataset.collection);
                formData.append('id', "{{ $Standardization->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('admin.apps.standardizations.uploadFile', ':id') }}".replace(':id', '{{ $Standardization->id }}');
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
        
    })

    $('#print-standardization').on('click', () => {
        $(".standardization-details").printThis({
            pageTitle: "Standardization details of {{ $Standardization->product_name }}"
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
        const url = "{{ route('admin.apps.standardizations.updateField', ':id') }}".replace(':id', id);
        const data = {
            field: field
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
