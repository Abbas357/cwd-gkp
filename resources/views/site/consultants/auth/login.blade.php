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

        .login-box {
            width: 450px;
            max-width: 95%;
            margin: 2rem auto;
        }

        .login-box>div {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1),
                0 1px 8px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 1rem;
        }

        .header-bg {
            background: linear-gradient(135deg, #6f82ff, #ffffff) !important;
            margin: -25px -25px 25px -25px;
            padding: 25px !important;
            border-radius: 15px 15px 0 0 !important;
        }

    </style>
    @endpush

    <div class="container-fluid">
        <div class="login-box">
            <!-- Login Form -->
            <div class="auth-form" id="loginForm">
                <div class="header-bg text-white text-center py-4 rounded-top mb-4">
                    <h4 class="fw-bold mb-0">Consultant Login</h4>
                    <span>(If you don't have account please <a class="switch-form-btn" href="{{ route('consultants.register')}}">Register</a> here)</span>
                </div>

                <form class="row g-3" method="POST" action="{{ route('consultants.login.post') }}">
                    @csrf
                    <div class="col-12">
                        <label for="email" class="form-label text-secondary">Email</label>
                        <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required autofocus autocomplete="email">
                        @foreach($errors->get('email') as $error)
                        <span class="text-danger small"> {{ $error }}</span>
                        @endforeach
                    </div>

                    <div class="col-12 mb-2">
                        <label for="password" class="form-label text-secondary">Password</label><span style="font-size:12px; color: #0000ff"> (If you forgot your password, please contact C&W IT Cell)</span>
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

                    <div class="col-12 mt-4">
                        <x-button type="submit" text="Login" />
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script>

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

    </script>
    @endpush
</x-main-layout>
