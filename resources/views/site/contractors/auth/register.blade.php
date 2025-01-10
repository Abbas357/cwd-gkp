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

        .register-box > div {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1),
                0 1px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 1rem;
        }

        .bg-dark {
            background: linear-gradient(135deg, #1a1a1a, #2d2d2d) !important;
            margin: -25px -25px 25px -25px;
            padding: 25px !important;
            border-radius: 15px 15px 0 0 !important;
        }

    </style>
    @endpush

    <div class="container-fluid">
        @if (session('status'))
        <div class="alert alert-info my-3 text-center">
            {{ session('status') }}
        </div>
        @endif

        <div class="register-box " >
            <div class="auth-form" id="loginForm">
                <div class="bg-dark text-white text-center py-4 rounded-top mb-4">
                    <h4 class="fw-bold mb-0">Contractor Registration</h4>
                    <span>(If you alreadu have an account please <a class="switch-form-btn" href="{{ route('contractors.login')}}">Login</a> here)</span>
                </div>

                <form class="needs-validation" action="{{ route('contractors.store') }}" method="post" novalidate>
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name">Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="name" value="{{ old('name') }}" placeholder="eg. Aslam Khan" name="name" required>
                            @error('name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col">
                            <label for="firm_name">Firm / Company Name <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="firm_name" value="{{ old('firm_name') }}" placeholder="eg. Aslam Builders" name="firm_name" required>
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

                        <div class="col-md-12">
                            <label for="address">Address <abbr title="Required">*</abbr></label>
                            <input type="text" class="form-control" id="address" value="{{ old('address') }}" placeholder="Address (As per PEC)" name="address" required>
                            @error('address')
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

                        <div class="col-12 mt-3">
                            <x-button type="submit" text="Register" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script>
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

        const pecInput = document.getElementById('pec_number');
        if (pecInput) {
            pecInput.addEventListener('input', function() {
                let pecNumber = this.value;
                let feedbackElement = document.getElementById('pec_number_feedback');
                let loaderElement = document.getElementById('checking_loader');
                let submitButton = document.getElementById('submitBtn');

                if (pecNumber) {
                    loaderElement.style.display = 'block';
                    feedbackElement.textContent = '';
                    feedbackElement.classList.remove('text-danger', 'text-success');

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
                            loaderElement.style.display = 'none';
                            if (data.unique) {
                                feedbackElement.textContent = 'PEC Number is available for registration';
                                feedbackElement.classList.add('text-success');
                                if (submitButton) submitButton.disabled = false;
                            } else {
                                feedbackElement.textContent = 'You have already applied.';
                                feedbackElement.classList.add('text-danger');
                                if (submitButton) submitButton.disabled = true;
                            }
                        })
                        .catch(error => {
                            loaderElement.style.display = 'none';
                            console.error('Error:', error);
                        });
                } else {
                    feedbackElement.textContent = '';
                    loaderElement.style.display = 'none';
                    if (submitButton) submitButton.disabled = false;
                }
            });
        }
    </script>
    @endpush
</x-main-layout>