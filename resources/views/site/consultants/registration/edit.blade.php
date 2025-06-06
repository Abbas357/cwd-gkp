<x-main-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <style>
        .warning-label {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .border-danger {
            border-color: #dc3545 !important;
        }

        .border-danger:focus {
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }
    </style>
    @endpush

    @include('site.consultants.partials.header')

    <div class="container">
        <form class="needs-validation" action="{{ route('consultants.registration.update', $registration->uuid) }}" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PATCH')
            
            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Edit Consultant Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <label for="pec_number">PEC No. <abbr title="Required">*</abbr></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="pec_number" value="{{ old('pec_number', $registration->pec_number) }}" placeholder="eg. 3423425" name="pec_number" required>
                                <span class="input-group-append">
                                    <div id="checking_loader" class="spinner-border spinner-border-lg text-info" style="display: none;" role="status">
                                        <span class="visually-hidden">Checking...</span>
                                    </div>
                                </span>
                            </div>
                            <div id="pec_number_feedback" class="mt-1"></div>
                            @error('pec_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="category_applied">Applying Category <abbr title="Required">*</abbr></label>
                            <select class="form-select" id="category_applied" name="category_applied" required>
                                <option value="">Choose...</option>
                                @foreach ($cat['consultant_category'] as $category)
                                <option value="{{ $category->name }}" {{ old('category_applied', $registration->category_applied) == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_applied')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="pec_category">PEC Category <abbr title="Required">*</abbr></label>
                            <select class="form-select" id="pec_category" name="pec_category" required>
                                <option value="">Choose...</option>
                                @foreach ($cat['consultant_category'] as $pec)
                                <option value="{{ $pec->name }}" {{ old('pec_category', $registration->pec_category) == $pec->name ? 'selected' : '' }}>
                                    {{ $pec->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('pec_category')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="fbr_ntn">FBR Registration No <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="fbr_ntn" value="{{ old('fbr_ntn', $registration->fbr_ntn) }}" placeholder="eg. 23523645" name="fbr_ntn" required>
                            @error('fbr_ntn')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="kpra_reg_no">KIPPRA Registration No <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="kpra_reg_no" value="{{ old('kpra_reg_no', $registration->kpra_reg_no) }}" placeholder="eg. K753465974-7" name="kpra_reg_no" required>
                            @error('kpra_reg_no')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="pre_enlistment">In Case of already enlisted in following</label>
                            <select class="form-select" data-placeholder="Choose" id="pre_enlistment" multiple name="pre_enlistment[]">
                                @foreach ($cat['provincial_entities'] as $entities)
                                <option value="{{ $entities->name }}" 
                                    {{ in_array($entities->name, json_decode($registration->pre_enlistment ?? '[]')) ? 'selected' : '' }}>
                                    {{ $entities->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('pre_enlistment')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="is_limited">Is Limited <abbr title="Required">*</abbr></label>
                            <select class="form-select" id="is_limited" name="is_limited" required>
                                <option value="">Choose...</option>
                                <option value="Yes" {{ old('is_limited', $registration->is_limited) == 'Yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ old('is_limited', $registration->is_limited) == 'No' ? 'selected' : '' }}>No</option>
                            </select>
                            @error('is_limited')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase">
                    Update Attachments
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            @if($registration->hasMedia('fbr_attachments'))
                            <div class="mb-2">
                                <a target="_blank" href="{{ $registration->getFirstMediaUrl('fbr_attachments') }}">View Current FBR Registration</a>
                            </div>
                            @endif
                            <label for="fbr_attachment">FBR Registration</label>
                            <input type="file" class="form-control" id="fbr_attachment" name="fbr_attachment">
                            <img id="previewFbrRegistration" src="#" alt="FBR Registration Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>
                        
                        <div class="col-md-4 mb-2">
                            @if($registration->hasMedia('kpra_attachments'))
                            <div class="mb-2">
                                <a target="_blank" href="{{ $registration->getFirstMediaUrl('kpra_attachments') }}">View Current KIPPRA Certificate</a>
                            </div>
                            @endif
                            <label for="kpra_attachment">KIPPRA Certificate</label>
                            <input type="file" class="form-control" id="kpra_attachment" name="kpra_attachment">
                            <img id="previewKippraCertificate" src="#" alt="KIPPRA Certificate Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-2">
                            @if($registration->hasMedia('pec_attachments'))
                            <div class="mb-2">
                                <a target="_blank" href="{{ $registration->getFirstMediaUrl('pec_attachments') }}">View Current PEC Certificate</a>
                            </div>
                            @endif
                            <label for="pec_attachment">PEC - 2020</label>
                            <input type="file" class="form-control" id="pec_attachment" name="pec_attachment">
                            <img id="previewPecCert" src="#" alt="PEC Certificate Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-2">
                            @if($registration->hasMedia('form_h_attachments'))
                            <div class="mb-2">
                                <a target="_blank" href="{{ $registration->getFirstMediaUrl('form_h_attachments') }}">View Current Form H</a>
                            </div>
                            @endif
                            <label for="form_h_attachment">Form - H (In case of Company)</label>
                            <input type="file" class="form-control" id="form_h_attachment" name="form_h_attachment">
                            <img id="previewFormH" src="#" alt="Form H Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-2">
                            @if($registration->hasMedia('pre_enlistment_attachments'))
                            <div class="mb-2">
                                <a target="_blank" href="{{ $registration->getFirstMediaUrl('pre_enlistment_attachments') }}">View Current Enlistment</a>
                            </div>
                            @endif
                            <label for="pre_enlistment_attachment">Previous Enlistment (Not for fresh consultants)</label>
                            <input type="file" class="form-control" id="pre_enlistment_attachment" name="pre_enlistment_attachment">
                            <img id="previewPreviousEnlistment" src="#" alt="Previous Enlistment Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions mt-4">
                <x-button class="cw-btn" type="submit" text="Edit Registration" id="submitBtn" />
            </div>
        </form>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pre_enlistment').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                closeOnSelect: false,
                dropdownParent: $('#pre_enlistment').parent()
            });

            imageCropper({
                fileInput: "#fbr_attachment",
                inputLabelPreview: "#previewFbrRegistration",
                aspectRatio: 1 / 1.6471,
                onComplete() {
                    $("#previewFbrRegistration").show();
                }
            });

            imageCropper({
                fileInput: "#kpra_attachment",
                inputLabelPreview: "#previewKippraCertificate",
                aspectRatio: 1 / 1.6471,
                onComplete() {
                    $("#previewKippraCertificate").show();
                }
            });

            imageCropper({
                fileInput: "#pec_attachment",
                inputLabelPreview: "#previewPecCert",
                aspectRatio: 1 / 1.6471,
                onComplete() {
                    $("#previewPecCert").show();
                }
            });

            imageCropper({
                fileInput: "#form_h_attachment",
                inputLabelPreview: "#previewFormH",
                aspectRatio: 1 / 1.6471,
                onComplete() {
                    $("#previewFormH").show();
                }
            });

            imageCropper({
                fileInput: "#pre_enlistment_attachment",
                inputLabelPreview: "#previewPreviousEnlistment",
                aspectRatio: 1 / 1.6471,
                onComplete() {
                    $("#previewPreviousEnlistment").show();
                }
            });

            function checkPECEligibility() {
                let pecNumber = $('#pec_number').val();
                let categoryApplied = $('#category_applied').val();
                let pecCategory = $('#pec_category').val();
                let feedbackElement = $('#pec_number_feedback');
                let loaderElement = $('#checking_loader');
                let submitButton = $('#submitBtn');
                let registrationId = '{{ $registration->id }}';

                if (pecNumber) {
                    loaderElement.show();
                    feedbackElement.text('');
                    feedbackElement.removeClass('text-danger text-success');

                    fetch("{{ route('consultants.registration.checkPEC') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            pec_number: pecNumber,
                            category_applied: categoryApplied,
                            pec_category: pecCategory,
                            registration_id: registrationId 
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        loaderElement.hide();
                        if (data.unique) {
                            feedbackElement.text(data.message);
                            feedbackElement.addClass('text-success');
                            submitButton.prop('disabled', false);
                        } else {
                            feedbackElement.text(data.message);
                            feedbackElement.addClass('text-danger');
                            submitButton.prop('disabled', true);
                        }
                    })
                    .catch(error => {
                        loaderElement.hide();
                        console.error('Error:', error);
                    });
                } else {
                    feedbackElement.text('');
                    loaderElement.hide();
                    submitButton.prop('disabled', false);
                }
            }

            $('#pec_number').on('input', checkPECEligibility);

            // Check eligibility when categories change
            $('#category_applied, #pec_category').on('change', function() {
                if ($('#pec_number').val()) {
                    checkPECEligibility();
                }
            });

        });
    </script>
    @endpush
</x-main-layout>