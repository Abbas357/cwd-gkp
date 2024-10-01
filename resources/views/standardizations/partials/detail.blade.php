<link href="{{ asset('plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<div class="row standardization-details">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Standardization Details</h2>
            <button type="button" id="print-standardization" class="no-print btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                <span class="d-flex align-items-center">
                    <i class="bi-print"></i>
                    Print
                </span>
            </button>
        </div>

        <table class="table table-bordered">
            @foreach(['product_name', 'specification_details', 'firm_name', 'address', 'mobile_number', 'phone_number', 'email', 'ntn_number', 'locality', 'location_type'] as $field)
            <tr>
                <th style="padding: 0.1rem 0.5rem; vertical-align:middle">{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                <td class="d-flex justify-content-between align-items-center gap-3" style="padding: 0.1rem 0.5rem; vertical-align:middle">
                    <span id="text-{{ $field }}">{{ $EStandardization->$field }}</span>
                    <input type="text" id="input-{{ $field }}" value="{{ $EStandardization->$field }}" class="d-none form-control" />
                    <button id="save-btn-{{ $field }}" class="btn btn-sm btn-primary d-none" onclick="updateField('{{ $field }}', {{ $EStandardization->id }})">Update</button>
                    <button class="no-print btn btn-sm" onclick="enableEditing('{{ $field }}')">
                        edit
                    </button>
                </td>
            </tr>
            @endforeach
        </table>

        <div class="row mt-3 mx-1">
            @php
            $uploads = [
            'secp_certificates' => 'SECP Certificate',
            'iso_certificates' => 'ISO Certificate',
            'commerse_memberships' => 'Commerce Membership',
            'pec_certificates' => 'PEC Certificate',
            'annual_tax_returns' => 'Annual Tax Returns',
            'audited_financials' => 'Audited Financials',
            'organization_registrations' => 'Department/Organization Registrations',
            'performance_certificate' => 'Performance Certificate',
            ];
            @endphp
            <h3 class="mt-3">Documents</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                        <th class="no-print">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uploads as $upload => $label)
                    <tr>
                        <td>{{ $label }}</td>
                        <td>
                            @if($EStandardization->hasMedia($upload))
                            <a href="{{ $EStandardization->getFirstMediaUrl($upload) }}" target="_blank" title="{{ $label }}" class="d-flex align-items-center gap-2">
                                View
                            </a>
                            @else
                            <span>Not Uploaded</span>
                            @endif
                        </td>
                        <td class="no-print">
                            <label for="{{ $upload }}" class="d-flex align-items-center btn btn-sm btn-light">
                                <span>{{ $EStandardization->hasMedia($upload) ? 'Change File' : 'Add File' }}</span>
                            </label>
                            <input type="file" id="{{ $upload }}" name="{{ $upload }}" class="file-input" data-upload="{{ $upload }}">
                            <img src="" class=".preview-image" alt="">
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
<script>
    $(document).ready(function() {
        
        imageCropper({
            fileInput: '.file-input'
            , inputLabelPreview: '.preview-image'
            , aspectRatio: 1 / 1.6471
            , onCrop: async function(croppedFile) {
                var formData = new FormData();
                console.log(croppedFile)
                formData.append('file', croppedFile);
                formData.append('collection', '');
                formData.append('id', "{{ $EStandardization->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('standardizations.uploadFile') }}"
                try {
                    const result = await fetchRequest(url, 'POST', formData);
                    if (result) {}
                } catch (error) {
                    console.error('Error during form submission:', error);
                }
            }
        });
    })

    $('#print-standardization').on('click', () => {
        $(".standardization-details").printThis({
            pageTitle: "Standardization details of {{ $EStandardization->product_name }}"
        });
    });

    function enableEditing(field) {
        $('#text-' + field).addClass('d-none');
        $('#input-' + field).removeClass('d-none');
        $('#save-btn-' + field).removeClass('d-none');
    }

    async function updateField(field, id) {
        const newValue = $('#input-' + field).val();
        const url = "{{ route('standardizations.updateField') }}";
        const data = {
            id: id
            , field: field
            , value: newValue
        };
        const success = await fetchRequest(url, 'PATCH', data, 'Field updated successfully', 'Error updating field');
        if (success) {
            $('#text-' + field).text(newValue);
            $('#input-' + field).addClass('d-none');
            $('#save-btn-' + field).addClass('d-none');
            $('#text-' + field).removeClass('d-none');
        }
    }

</script>
