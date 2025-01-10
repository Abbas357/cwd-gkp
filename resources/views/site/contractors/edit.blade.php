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

        <form action="{{ route('contractors.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="card mb-4">
                <div class="card-header bg-light fw-bold text-uppercase text-center">
                    Personal Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name', $contractor->name) }}" placeholder="eg. Aslam Khan" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="email">Email Address <abbr title="Required">*</abbr></label>
                            <input type="email" class="form-control" id="email" value="{{ old('email', $contractor->email) }}" placeholder="eg. aslam@gmail.com" name="email" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="firm_name">Firm / Company Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="firm_name" value="{{ old('firm_name', $contractor->firm_name) }}" placeholder="eg. Aslam Builders" name="firm_name" required>
                            @error('firm_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="mobile_number">Mobile No. <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number', $contractor->mobile_number) }}" placeholder="eg. 0333-3333333" name="mobile_number" required>
                            @error('mobile_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="cnic">CNIC No <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="cnic" value="{{ old('cnic', $contractor->cnic) }}" placeholder="National Identity Card Number" name="cnic" required>
                            @error('cnic')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="district">District <abbr title="Required">*</abbr></label>
                            <select class="form-select" id="district" name="district" required>
                                <option value="">Choose...</option>
                                @foreach ($cat['districts'] as $district)
                                <option value="{{ $district->name }}" {{ $contractor->district == $district->name ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                            @error('district')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="address">Address (as per PEC) <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="address" value="{{ old('address', $contractor->address) }}" placeholder="eg. Dir Upper" name="address" required>
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="contractor_picture">Contractor Picture (Picture on Card)</label>
                            <input type="file" class="form-control" id="contractor_picture" name="contractor_picture">
                            @error('contractor_picture')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="previewContractorPicture" src="#" alt="Contractor Picture Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="cnic_front">CNIC (Front Side)</label>
                            <input type="file" class="form-control" id="cnic_front" name="cnic_front">
                            @error('cnic_front')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="previewCnicFront" src="#" alt="CNIC Front Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="cnic_back">CNIC (Back Side)</label>
                            <input type="file" class="form-control" id="cnic_back" name="cnic_back">
                            @error('cnic_back')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="previewCnicBack" src="#" alt="CNIC Back Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('contractors.dashboard') }}" class="btn btn-light me-2">Cancel</a>
                <x-button type="submit" text="Update Contractor" />
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
                fileInput: "#contractor_picture"
                , inputLabelPreview: "#previewContractorPicture"
                , aspectRatio: 5 / 6
                , onComplete() {
                    $("#previewContractorPicture").show();
                }
            });

            imageCropper({
                fileInput: "#cnic_front"
                , inputLabelPreview: "#previewCnicFront"
                , aspectRatio: 1.58 / 1
                , onComplete() {
                    $("#previewCnicFront").show();
                }
            });

            imageCropper({
                fileInput: "#cnic_back"
                , inputLabelPreview: "#previewCnicBack"
                , aspectRatio: 1.58 / 1
                , onComplete() {
                    $("#previewCnicBack").show();
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
        });

    </script>
    @endpush
</x-main-layout>
