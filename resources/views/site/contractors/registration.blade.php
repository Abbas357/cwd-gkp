<x-main-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    @endpush
    <x-slot name="breadcrumbTitle">
        Online Contractor Registrations
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Contractor</li>
    </x-slot>
    <div class="wrapper mt-2">
        <div class="page container">
            <div class="page-inner">
                <div class="page-section shadow-lg rounded bg-light" style="border:1px solid #dedede">
                    <form class="needs-validation" action="{{ route('contractors.store') }}" method="post" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card p-2 shadow border border-light rounded border-2">
                                    <div class="card-body">
                                        <h3 class="card-title">Fill all the fields</h3>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="owner_name">Name of Owner <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="owner_name" value="{{ old('owner_name') }}" placeholder="eg. Aslam Khan" name="owner_name" required>
                                                @error('owner_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="district">District <abbr title="Required">*</abbr></label>
                                                <select class="form-select" id="district" name="district" required>
                                                    <option value="">Choose...</option>
                                                    @foreach ($cat['districts'] as $district)
                                                    <option value="{{ $district->name }}">{{ $district->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('district')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
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
                                        </div>

                                        <div class="row mb-3">
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
                                            <div class="col">
                                                <label for="contractor_name">Name of Contractor / Firm / Company <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="contractor_name" value="{{ old('contractor_name') }}" placeholder="eg. Aslam Builders" name="contractor_name" required>
                                                @error('contractor_name')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col">
                                                <label for="address">Address (as per PEC) <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="address" value="{{ old('address') }}" placeholder="eg. Dir Upper" name="address" required>
                                                @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
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
                                                <label for="cnic">CNIC No <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="cnic" value="{{ old('cnic') }}" placeholder="National Identity Card Number" name="cnic" required>
                                                @error('cnic')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
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
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="email">Email Address <abbr title="Required">*</abbr></label>
                                                <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="eg. aslam@gmail.com" name="email" required>
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mobile_number">Mobile No. <abbr title="Required">*</abbr></label>
                                                <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" placeholder="eg. 0333-3333333" name="mobile_number" required>
                                                @error('mobile_number')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
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
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card p-2 shadow border border-light rounded border-2">
                                    <div class="card-body">
                                        <h3 class="card-title">Upload relevant documents</h3>
                                        <div class="mb-3">
                                            <label for="contractor_picture">Contractor Picture (Picture on Card)</label>
                                            <input type="file" class="form-control" id="contractor_picture" name="contractor_picture">
                                            @error('contractor_picture')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="previewContractorPicture" src="#" alt="Contractor Picture Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="cnic_front_attachment">CNIC (Front Side)</label>
                                            <input type="file" class="form-control" id="cnic_front_attachment" name="cnic_front_attachment">
                                            @error('cnic_front_attachment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="previewCnicFront" src="#" alt="CNIC Front Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="cnic_back_attachment">CNIC (Back Side)</label>
                                            <input type="file" class="form-control" id="cnic_back_attachment" name="cnic_back_attachment">
                                            @error('cnic_back_attachment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="previewCnicBack" src="#" alt="CNIC Back Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="fbr_attachment">FBR Registration</label>
                                            <input type="file" class="form-control" id="fbr_attachment" name="fbr_attachment">
                                            @error('fbr_attachment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="previewFbrRegistration" src="#" alt="FBR Registration Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="kpra_attachment">KIPPRA Certificate</label>
                                            <input type="file" class="form-control" id="kpra_attachment" name="kpra_attachment">
                                            @error('kpra_attachment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="previewKippraCertificate" src="#" alt="KIPPRA Certificate Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="pec_attachment">PEC - 2020</label>
                                            <input type="file" class="form-control" id="pec_attachment" name="pec_attachment">
                                            @error('pec_attachment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="previewPecCert" src="#" alt="PEC Certificate Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
                                            <label for="form_h_attachment">Form - H (In case of Company)</label>
                                            <input type="file" class="form-control" id="form_h_attachment" name="form_h_attachment">
                                            @error('form_h_attachment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            <img id="previewFormH" src="#" alt="Form H Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                                        </div>

                                        <div class="mb-3">
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
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push("script")
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            imageCropper({
                fileInput: "#contractor_picture"
                , inputLabelPreview: "#previewContractorPicture"
                , aspectRatio: 5 / 6
                , onComplete() {
                    $("#previewContractorPicture").show();
                }
            });

            imageCropper({
                fileInput: "#cnic_front_attachment"
                , inputLabelPreview: "#previewCnicFront"
                , aspectRatio: 1.58 / 1
                , onComplete() {
                    $("#previewCnicFront").show();
                }
            });

            imageCropper({
                fileInput: "#cnic_back_attachment"
                , inputLabelPreview: "#previewCnicBack"
                , aspectRatio: 1.58 / 1
                , onComplete() {
                    $("#previewCnicBack").show();
                }
            });

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
            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })

            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
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
