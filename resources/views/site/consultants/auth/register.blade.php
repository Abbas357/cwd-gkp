<x-main-layout>
    @push('style')
    <link href="{{ asset('admin/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/select2/css/select2-bootstrap-5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/cropper/css/cropper.min.css') }}" rel="stylesheet">
    <style>
        body {
            background-image: url("../site/images/engineering-bg-image.jpg");
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
            width: 700px;
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

        .header-bg {
            background: linear-gradient(135deg, #ffffff, #6f82ff) !important;
            margin: -25px -25px 25px -25px;
            padding: 25px !important;
            border-radius: 15px 15px 0 0 !important;
        }

    </style>
    @endpush

    <div class="container-fluid">
        <div class="register-box ">
            <div class="auth-form" id="loginForm">
                <div class="header-bg {text-white text-center py-4 rounded-top mb-4">
                    <h4 class="fw-bold mb-0">Consultant Registration</h4>
                    <span>(If you already have an account please <a class="switch-form-btn" href="{{ route('consultants.login.post')}}">Login</a> here)</span>
                </div>

                <form class="needs-validation" action="{{ route('consultants.store') }}" method="post" novalidate>
                    @csrf
                    <div class="row g-3">
                        
                        <div class="col-md-4">
                            <label for="firm_name">Firm Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="firm_name" value="{{ old('firm_name') }}" placeholder="Firm / Company Name" name="firm_name" required>
                            @error('firm_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="email">Email <abbr title="Required">*</abbr></label>
                            <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="Email" name="email" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="pec_number">PEC Number <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="pec_number" value="{{ old('pec_number') }}" placeholder="Active PEC Number" name="pec_number">
                            @error('pec_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" value="{{ old('contact_number') }}" placeholder="Valid Contact Number" name="contact_number">
                            @error('contact_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="district">District</label>
                            <select class="form-select" id="district" name="district">
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
                            <label for="sector">Sector</label>
                            <select class="form-select" id="sector" name="sector">
                                <option value="">Choose...</option>
                                @foreach ($cat['sectors'] as $sector)
                                <option value="{{ $sector }}">{{ $sector }}</option>
                                @endforeach
                            </select>
                            @error('sector')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" value="{{ old('address') }}" placeholder="Address (As per PEC)" name="address">
                            @error('address')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <x-button type="submit" id="submitBtn" text="Save & Next" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/cropper/js/cropper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            
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
                    url: '{{ route("consultants.check") }}',
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

            $('#contact_number').on('input', function() {
                const value = $(this).val();
                if (value.length > 5) {
                    debouncedValidate('contact_number', value);
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
