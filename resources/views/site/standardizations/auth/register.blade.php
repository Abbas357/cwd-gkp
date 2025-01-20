<x-main-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url("../site/images/products-bg-image.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.95),
                    rgba(255, 255, 255, 0.85));
            z-index: -1;
        }

        .register-box {
            width: 800px;
            max-width: 95%;
            margin: 2rem auto;
        }

        .register-box>div {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1),
                0 1px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 1rem;
        }

        .bg-dark {
            background: linear-gradient(135deg, #14006e, #1d03ad) !important;
            margin: -25px -25px 25px -25px;
            padding: 25px !important;
            border-radius: 15px 15px 0 0 !important;
        }

    </style>
    @endpush

    <div class="container-fluid">
        <div class="register-box ">
            <div class="auth-form" id="loginForm">
                <div class="bg-dark text-white text-center py-4 rounded-top mb-4">
                    <h4 class="fw-bold mb-0">Firm Standardization Registration</h4>
                    <span>(If you already have an account please <a class="switch-form-btn" href="{{ route('standardizations.login.post')}}">Login</a> here)</span>
                </div>

                <form class="needs-validation" action="{{ route('standardizations.store') }}" method="post" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="owner_name">Owner Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="owner_name" value="{{ old('owner_name') }}" placeholder="eg. Aslam Khan" name="owner_name" required>
                            @error('owner_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="firm_name">Firm / Company Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="firm_name" value="{{ old('firm_name') }}" placeholder="Firm or Company name" name="firm_name" required>
                            @error('firm_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email">Email <abbr title="Required">*</abbr></label>
                            <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="eg. aslamkhan@gmail.com" name="email" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cnic">CNIC Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="cnic" name="cnic" value="{{ old('cnic') }}" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" placeholder="eg. 11111-1111111-1" required>
                            @error('cnic')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
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

                        <div class="col-md-4">
                            <label for="mobile_number">Mobile Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" pattern="[0-9]{4}-[0-9]{7}" placeholder="eg. 0333-3333333" name="mobile_number" required>
                            @error('mobile_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="password" class="form-label text-secondary">Password</label></span>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control shadow-sm" id="password" placeholder="Enter Password" name="password" required autocomplete="current-password">
                                <button type="button" class="input-group-text bg-white" style="border: 1px solid #999" onclick="togglePasswordVisibility()">
                                    <i class="bi bi-eye-fill" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            @foreach($errors->get('password') as $error)
                            <span class="text-danger small"> {{ $error }}</span>
                            @endforeach
                        </div>

                        <div class="col-md-12">
                            <label for="address">Address <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="address" value="{{ old('address') }}" placeholder="Address (As per CNIC)" name="address" required>
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="firm_picture">Firm Picture (Picture on Card)</label>
                            <input type="file" class="form-control" id="firm_picture" name="firm_picture">
                            @error('firm_picture')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <img id="previewFirmPicture" src="#" alt="Firm Picture Preview" style="display:none; margin-top: 10px; max-height: 100px;">
                        </div>

                        <div class="col-12 mt-3">
                            <x-button type="submit" id="submitBtn" text="Register" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            $('#mobile_number').mask('0000-0000000', {
                placeholder: "____-_______"
            });

            $('#cnic').mask('00000-0000000-0', {
                placeholder: "_____-_______-_"
            });

            imageCropper({
                fileInput: "#firm_picture"
                , inputLabelPreview: "#previewFirmPicture"
                , aspectRatio: 5 / 6
                , onComplete() {
                    $("#previewFirmPicture").show();
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

            window.togglePasswordVisibility = function() {
                const passwordField = document.getElementById("password");
                const toggleIcon = document.getElementById("togglePasswordIcon");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    toggleIcon.classList.replace("bi-eye-fill", "bi-eye-slash-fill");
                } else {
                    passwordField.type = "password";
                    toggleIcon.classList.replace("bi-eye-slash-fill", "bi-eye-fill");
                }
            };
            
            function validateField(field, value) {
                const feedbackId = `${field}_feedback`;
                const inputElement = $(`#${field}`);
                let submitButton = $('#submitBtn');
                
                if (!$(`#${feedbackId}`).length) {
                    inputElement.after(`<div id="${feedbackId}" class="mt-1"></div>`);
                }
                
                const feedbackElement = $(`#${feedbackId}`);
                
                feedbackElement.html('<div class="spinner-border spinner-border-sm text-info" role="status"></div>');
                
                $.ajax({
                    url: '{{ route("standardizations.check") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        field: field,
                        value: value
                    },
                    success: function(response) {
                        if (response.valid) {
                            inputElement.removeClass('border-danger');
                            feedbackElement.removeClass('text-danger').addClass('text-success');
                            feedbackElement.html('<i class="fas fa-check"></i> Available');
                            submitButton.prop('disabled', false);
                        } else {
                            inputElement.addClass('border-danger');
                            feedbackElement.removeClass('text-success').addClass('text-danger');
                            feedbackElement.html(`<i class="fas fa-times"></i> ${response.message}`);
                            submitButton.prop('disabled', true);
                        }
                    },
                    error: function() {
                        feedbackElement.html('<span class="text-danger">Error checking availability</span>');
                    }
                });
            }

            // Debounce function to limit API calls
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }

            // Add event listeners for each field
            const debouncedValidate = debounce(validateField, 500);

            $('#email').on('input', function() {
                const value = $(this).val();
                if (value.length > 3) {
                    debouncedValidate('email', value);
                }
            });

            $('#cnic').on('input', function() {
                const value = $(this).val();
                if (value.length > 5) {
                    debouncedValidate('cnic', value);
                }
            });

            $('#mobile_number').on('input', function() {
                const value = $(this).val();
                if (value.length > 5) {
                    debouncedValidate('mobile_number', value);
                }
            });

            // Form submission validation
            $('form').on('submit', function(e) {
                const invalidFields = $('.border-danger').length;
                if (invalidFields > 0) {
                    e.preventDefault();
                    alert('Please fix the highlighted errors before submitting');
                }
            });

        });
            

    </script>
    @endpush
</x-main-layout>
