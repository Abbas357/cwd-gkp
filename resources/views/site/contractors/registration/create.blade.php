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
    @include('site.contractors.partials.header')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Edit your information</h2>
        </div>

        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
            <form class="needs-validation" action="{{ route('contractors.store') }}" method="post" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="pec_number">PEC No. <abbr title="Required">*</abbr></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="pec_number" value="{{ old('pec_number') }}" placeholder="eg. 3423425" name="pec_number" required>
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
                    <div class="col-md-6">
                        <label for="category_applied">Applying Category <abbr title="Required">*</abbr></label>
                        <select class="form-select" id="category_applied" name="category_applied" required>
                            <option value="">Choose...</option>
                            @foreach ($cat['contractor_category'] as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_applied')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pec_category">PEC Category <abbr title="Required">*</abbr></label>
                        <select class="form-select" id="pec_category" name="pec_category" required>
                            <option value="">Choose...</option>
                            @foreach ($cat['contractor_category'] as $pec)
                            <option value="{{ $pec->name }}">{{ $pec->name }}</option>
                            @endforeach
                        </select>
                        @error('pec_category')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="fbr_ntn">FBR Registration No <abbr title="Required">*</abbr></label>
                        <input type="text" class="form-control" id="fbr_ntn" value="{{ old('fbr_ntn') }}" placeholder="eg. 23523645" name="fbr_ntn" required>
                        @error('fbr_ntn')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="kpra_reg_no">KIPPRA Registration No <abbr title="Required">*</abbr></label>
                        <input type="text" class="form-control" id="kpra_reg_no" value="{{ old('kpra_reg_no') }}" placeholder="eg. K753465974-7" name="kpra_reg_no" required>
                        @error('kpra_reg_no')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pre_enlistment">In Case of already enlisted in following</label>
                        <select class="form-select" data-placeholder="Choose" id="pre_enlistment" multiple name="pre_enlistment[]">
                            @foreach ($cat['provincial_entities'] as $entities)
                            <option value="{{ $entities->name }}">{{ $entities->name }}</option>
                            @endforeach
                        </select>
                        @error('pre_enlistment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="is_limited">Is Limitted <abbr title="Required">*</abbr></label>
                        <select class="form-select" id="is_limited" name="is_limited" required>
                            <option value="">Choose...</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        @error('is_limited')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="fbr_attachment">FBR Registration</label>
                        <input type="file" class="form-control" id="fbr_attachment" name="fbr_attachment">
                        @error('fbr_attachment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <img id="previewFbrRegistration" src="#" alt="FBR Registration Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                    </div>

                    <div class="col-md-6">
                        <label for="kpra_attachment">KIPPRA Certificate</label>
                        <input type="file" class="form-control" id="kpra_attachment" name="kpra_attachment">
                        @error('kpra_attachment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <img id="previewKippraCertificate" src="#" alt="KIPPRA Certificate Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                    </div>

                    <div class="col-md-6">
                        <label for="pec_attachment">PEC - 2020</label>
                        <input type="file" class="form-control" id="pec_attachment" name="pec_attachment">
                        @error('pec_attachment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <img id="previewPecCert" src="#" alt="PEC Certificate Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                    </div>

                    <div class="col-md-6">
                        <label for="form_h_attachment">Form - H (In case of Company)</label>
                        <input type="file" class="form-control" id="form_h_attachment" name="form_h_attachment">
                        @error('form_h_attachment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <img id="previewFormH" src="#" alt="Form H Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                    </div>

                    <div class="col-md-6">
                        <label for="pre_enlistment_attachment">Previous Enlistment (Not for fresh contractors)</label>
                        <input type="file" class="form-control" id="pre_enlistment_attachment" name="pre_enlistment_attachment">
                        @error('pre_enlistment_attachment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <img id="previewPreviousEnlistment" src="#" alt="Previous Enlistment Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-primary btn-block" type="submit" id="submitBtn">Apply</button>
                    </div>
                </div>
            </form>

            
    </div>
    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            const formInputs = document.querySelector('main').querySelectorAll(`
                input:not([type="hidden"]):not([type="submit"]),
                select,
                textarea
            `);

            imageCropper({
                fileInput: "#fbr_attachment"
                , inputLabelPreview: "#previewFbrRegistration"
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#previewFbrRegistration").show();
                }
            });

            imageCropper({
                fileInput: "#kpra_attachment"
                , inputLabelPreview: "#previewKippraCertificate"
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#previewKippraCertificate").show();
                }
            });

            imageCropper({
                fileInput: "#pec_attachment"
                , inputLabelPreview: "#previewPecCert"
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#previewPecCert").show();
                }
            });

            imageCropper({
                fileInput: "#form_h_attachment"
                , inputLabelPreview: "#previewFormH"
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#previewFormH").show();
                }
            });

            imageCropper({
                fileInput: "#pre_enlistment_attachment"
                , inputLabelPreview: "#previewPreviousEnlistment"
                , aspectRatio: 1 / 1.6471
                , onComplete() {
                    $("#previewPreviousEnlistment").show();
                }
            });

            $('#pre_enlistment').select2({
                theme: "bootstrap-5"
                , width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style'
                , placeholder: $(this).data('placeholder')
                , closeOnSelect: false
                , dropdownParent: $('#pre_enlistment').parent()
            , });

            $('#district').select2({
                theme: "bootstrap-5"
                , placeholder: $(this).data('placeholder')
                , dropdownParent: $('#district').parent()
            , });

            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });

            formInputs.forEach(input => {
                const isEmpty = checkIfEmpty(input);
                if (isEmpty) {
                    addWarningLabel(input);
                    updateFieldStatus();
                }
            });

            function checkIfEmpty(input) {
                if (input.type === 'file') {

                    const existingFile = input.closest('.mb-3').querySelector('img, a');
                    return !existingFile;
                } else if (input.tagName === 'SELECT' && input.multiple) {
                    return !input.selectedOptions.length;
                } else {
                    return !input.value.trim();
                }
            }

            function addWarningLabel(input) {

                const existingLabel = input.parentElement.querySelector('.warning-label');
                if (existingLabel) {
                    existingLabel.remove();
                }

                const label = document.createElement('div');
                label.className = 'warning-label';
                label.textContent = 'Required field';
                label.style.cssText = `
                    color: #fff;
                    font-size: 0.8rem;
                    position: absolute;
                    right: 0;
                    top: 5px;
                    padding: 1px 2px;
                    border-radius: 3px;
                    background: orange;
                `;

                input.parentElement.style.position = 'relative';
                input.classList.add('border-danger');
                input.parentElement.appendChild(label);
            }

            function removeWarningLabel(input) {
                const warningLabel = input.parentElement.querySelector('.warning-label');
                if (warningLabel) {
                    warningLabel.remove();
                    input.classList.remove('border-danger');
                }
            }

            function updateFieldStatus() {
                const emptyFieldCount = Array.from(formInputs).filter(input => checkIfEmpty(input)).length;
                const statusDiv = document.querySelector('.alert.alert-warning');

                if (emptyFieldCount > 0) {
                    if (!statusDiv) {
                        const newStatusDiv = document.createElement('div');
                        newStatusDiv.className = 'alert alert-warning mb-4';
                        newStatusDiv.innerHTML = `<strong>Profile Incomplete:</strong> ${emptyFieldCount} out of ${formInputs.length} fields need to be filled.`;
                        const form = document.querySelector('main form');
                        form.parentNode.insertBefore(newStatusDiv, form);
                    } else {
                        statusDiv.innerHTML = `<strong>Profile Incomplete:</strong> ${emptyFieldCount} out of ${formInputs.length} fields need to be filled.`;
                    }
                } else if (statusDiv) {
                    statusDiv.remove();
                }
            }

            formInputs.forEach(input => {
                ['change', 'input'].forEach(eventType => {
                    input.addEventListener(eventType, function() {
                        if (!checkIfEmpty(input)) {
                            removeWarningLabel(input);
                        } else {
                            addWarningLabel(input);
                        }
                        updateFieldStatus();
                    });
                });
            });


            $('#pec_number').on('input', function() {
                let pecNumber = $(this).val();
                let feedbackElement = $('#pec_number_feedback');
                let loaderElement = $('#checking_loader');
                let submitButton = $('#submitBtn');

                if (pecNumber) {
                    loaderElement.show();
                    feedbackElement.text('');
                    feedbackElement.removeClass('text-danger text-success');

                    fetch("{{ route('contractors.checkPEC') }}", {
                            method: 'POST'
                            , headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                            , body: JSON.stringify({
                                pec_number: pecNumber
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            loaderElement.hide();
                            if (data.unique) {
                                feedbackElement.text('PEC Number is available for registration');
                                feedbackElement.addClass('text-success');
                                submitButton.prop('disabled', false);
                            } else {
                                feedbackElement.text('You have already applied.');
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
            });

            

        });

    </script>
    @endpush
</x-main-layout>