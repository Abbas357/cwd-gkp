<x-main-layout>
    @push('style')
    <style>
        .login-box {
            background-color: #ffffff;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background: #5f8cec;
            border: none;
            transition: background 0.3s ease;
        }

        .btn-primary:hover {
            background: #3b5998;
        }

        .input-group-text {
            cursor: pointer;
        }

        .shadow-lg {
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
        }

        .login-box {
            width: 450px;
            margin: auto;
            border-radius: 10px;
            background: #ffffff99;
            box-shadow: 0 0 30px #999;
            border: 1px solid #ddd;
        }

        body {
            background-image: url("../site/images/engineering-bg-image.jpg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.85);
            z-index: -1;
        }

    </style>
    @endpush

    <div class="container-fluid my-5">
        <div class="row">
            <div class="card p-1 overflow-hidden login-box">
                <div class="card-body px-3 position-relative">
                    <div class="bg-dark text-white text-center py-4 rounded-top">
                        <h4 class="fw-bold mb-0">Contractor Login</h4>
                        <p class="small mb-0">(Login with email and Password)</p>
                    </div>

                    @if (session('status'))
                    <div class="alert alert-info my-3 text-center">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="form-body mt-3">
                        <form class="row g-3" method="POST" action="{{ route('contractors.login') }}">
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
                </div>
            </div>
        </div>
    </div>
    @push('script')
    <script>
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

    </script>
    @endpush
</x-main-layout>
