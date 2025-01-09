<x-main-layout>
    @push('style')
    <style>
        body {
            background-image: url("../site/images/engineering-bg-image.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            perspective: 1500px;
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

        .container-fluid {
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
            padding-bottom: 2rem;
            z-index: 999;
        }

        .cube-container {
            width: 500px;
            max-width: 95%;
            position: relative;
            margin: 2rem auto;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cube-face {
            position: relative;
            
            width: 100%;
            backface-visibility: hidden;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1),
                0 1px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .login-face {
            transform: rotateY(0deg);
            z-index: 2;
        }

        .register-face {
            transform: rotateY(180deg);
            position: absolute;
            
            top: 0;
            left: 0;
        }

        .bg-dark {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d) !important;
            margin: -25px -25px 25px -25px;
            padding: 25px !important;
            border-radius: 15px 15px 0 0 !important;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            padding: 12px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(95, 140, 236, 0.15);
            border-color: #5f8cec;
            background: #ffffff;
        }

        .rotate-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s;
            transform: translateZ(0);
            color: #5f8cec;
            font-weight: bold
        }

        .rotate-btn:hover {
            transform: translateY(-2px) scale(1.01);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .rotate-btn::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 500%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent,
                    rgba(255, 255, 255, 0.3),
                    transparent);
            transform: rotate(45deg);
            animation: shine 2s infinite;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(45deg);
            }

            100% {
                transform: translateX(100%) rotate(45deg);
            }
        }

        .input-group-text {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .input-group-text:hover {
            background-color: #f8f9fa !important;
        }

        
        @media (max-width: 576px) {
            .cube-container {
                width: 100%;
                margin: 1rem auto;
            }

            .cube-face {
                padding: 20px;
            }

            .bg-dark {
                margin: -20px -20px 20px -20px;
                padding: 20px !important;
            }
        }

    </style>
    @endpush

    <div class="container-fluid">

        @if (session('status'))
        <div class="alert alert-info my-3 text-center">
            {{ session('status') }}
        </div>
        @endif

        <div class="cube-container" id="authCube">
            <!-- Login Face -->
            <div class="cube-face login-face">
                <div class="bg-dark text-white text-center py-4 rounded-top mb-4">
                    <h4 class="fw-bold mb-0">Contractor Login</h4>
                    <span>(If you don't have account please <a href="#" class="rotate-btn" onclick="rotateCube()">Register</a> here)</span>
                </div>

                <form class="row g-3 needs-validation" method="POST" action="{{ route('contractors.login') }}" novalidate>
                    @csrf
                    <div class="col-12">
                        <label for="email" class="form-label text-secondary">Email</label>
                        <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required autofocus autocomplete="email">
                        @foreach($errors->get('email') as $error)
                        <span class="text-danger small"> {{ $error }}</span>
                        @endforeach
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label text-secondary">Password</label><span style="font-size:12px; color: #0000ff"> (If don't have password contact C&W IT Cell)</span>
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

                    <div class="col-12 mt-3">
                        <x-button type="submit" text="Login" />
                    </div>
                </form>
            </div>

            <!-- Register Face -->
            <div class="cube-face register-face">
                <div class="bg-dark text-white text-center py-4 rounded-top mb-4">
                    <h4 class="fw-bold mb-0">Contractor Registration</h4>
                    <span>(If you already applied please <a href="#" class="rotate-btn" onclick="rotateCube()">Login</a> here)</span>
                </div>

                <form class="needs-validation" action="{{ route('contractors.store') }}" method="post" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="email">Email Address <abbr title="Required">*</abbr></label>
                            <input type="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="eg. aslam@gmail.com" name="email" required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
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

                        <div class="col-md-6">
                            <label for="owner_name">Owner Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="owner_name" value="{{ old('owner_name') }}" placeholder="eg. Aslam Khan" name="owner_name" required>
                            @error('owner_name')
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

                        

                        <div class="col-md-6">
                            <label for="mobile_number">Mobile No. <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="mobile_number" value="{{ old('mobile_number') }}" pattern="[0-9]{4}-[0-9]{7}" placeholder="eg. 0333-3333333" name="mobile_number" required>
                            @error('mobile_number')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="cnic">CNIC No <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="cnic" name="cnic" value="{{ old('cnic') }}" pattern="[0-9]{5}-[0-9]{7}-[0-9]{1}" placeholder="National Identity Card Number" required>
                            @error('cnic')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 mt-3">
                            <x-button type="submit" text="Register" />
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
        let isLoginVisible = localStorage.getItem('isLoginVisible') !== null ?
            localStorage.getItem('isLoginVisible') === 'true' :
            true;

        document.addEventListener('DOMContentLoaded', function() {
            const cube = document.getElementById('authCube');
            if (!isLoginVisible) {
                cube.style.transform = 'rotateY(180deg)';
            }
        });

        function rotateCube() {
            const cube = document.getElementById('authCube');
            isLoginVisible = !isLoginVisible;
            localStorage.setItem('isLoginVisible', isLoginVisible);
            cube.style.transform = isLoginVisible ? 'rotateY(0deg)' : 'rotateY(180deg)';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })
        
        function togglePasswordVisibility() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.getElementById("togglePasswordIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.replace("bi-eye-fill", "bi-eye-slash-fill");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.replace("bi-eye-slash-fill", "bi-eye-fill");
            }
        }

        $('#pre_enlistment').select2({
            theme: "bootstrap-5"
            , width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style'
            , placeholder: $(this).data('placeholder')
            , closeOnSelect: false
            , dropdownParent: $('#pre_enlistment').parent()
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

    </script>
    @endpush
</x-main-layout>
