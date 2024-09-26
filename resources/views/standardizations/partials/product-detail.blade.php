<link href="{{ asset('plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
<style>
    .card {
        position: relative;
    }

    .card-img-top {
        display: block;
        width: 100%;
        height: auto;
    }

    .card .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .card:hover .overlay {
        opacity: 1;
    }

</style>
<div class="row standardization-details">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4">Standardization Details</h2>
            <button type="button" id="print-standardization" class="btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
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
                    <button class="btn btn-sm" onclick="enableEditing('{{ $field }}')">
                        edit
                    </button>
                </td>
            </tr>
            @endforeach
        </table>

        <h3 class="mt-5">Uploaded Documents</h3>

        <div class="row mt-3">
            @php
            $imageFields = [
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

            @foreach($imageFields as $imageField => $label)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <label for="{{ $imageField }}">
                        <img src="{{ $EStandardization->hasMedia($imageField) ? $EStandardization->getFirstMediaUrl($imageField) : 'https://via.placeholder.com/150x247' }}" id="{{ $imageField }}-prev" class="card-img-top" alt="{{ $label }}">
                        <div class="overlay">
                            <span>{{ $EStandardization->hasMedia($imageField) ? 'Change Image' : 'Add Image' }}</span>
                        </div>
                    </label>
                    <input type="file" id="{{ $imageField }}" name="{{ $imageField }}" class="d-none image-input">
                    <div class="card-body">
                        <p class="card-text">{{ $label }}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

<script src="{{ asset('plugins/printThis/printThis.js') }}"></script>
<script src="{{ asset('plugins/cropper/js/cropper.min.js') }}"></script>
<script>
    const certificates = [{
            fileInput: '#secp_certificates'
            , inputLabelPreview: '#secp_certificates-prev'
        }
        , {
            fileInput: '#iso_certificates'
            , inputLabelPreview: '#iso_certificates-prev'
        }
        , {
            fileInput: '#commerse_memberships'
            , inputLabelPreview: '#commerse_memberships-prev'
        }
        , {
            fileInput: '#pec_certificates'
            , inputLabelPreview: '#pec_certificates-prev'
        }
        , {
            fileInput: '#annual_tax_returns'
            , inputLabelPreview: '#annual_tax_returns-prev'
        }
        , {
            fileInput: '#audited_financials'
            , inputLabelPreview: '#audited_financials-prev'
        }
        , {
            fileInput: '#organization_registrations'
            , inputLabelPreview: '#organization_registrations-prev'
        }
        , {
            fileInput: '#performance_certificate'
            , inputLabelPreview: '#performance_certificate-prev'
        }
    ];

    certificates.forEach(cert => {
        const fileInput = document.querySelector(cert.fileInput);

        imageCropper({
            fileInput: cert.fileInput
            , inputLabelPreview: cert.inputLabelPreview
            , aspectRatio: 1 / 1.6471
            , onCrop: async function(croppedFile) {
                var formData = new FormData();
                formData.append('image', croppedFile);
                formData.append('collection', cert.fileInput.replace('#', ''));
                formData.append('id', "{{ $EStandardization->id }}");
                formData.append('_method', "PATCH");

                const url = "{{ route('standardizations.upsertImage') }}"
                try {
                    const result = await fetchRequest(url, 'POST', formData);
                    if (result) {
                    }
                } catch (error) {
                    console.error('Error during form submission:', error);
                }
            }
        });
    });



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
