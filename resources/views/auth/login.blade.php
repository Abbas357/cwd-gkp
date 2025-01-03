<x-guest-layout>
    @push('style')
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc, #cfdef3);
            font-family: Arial, sans-serif;
        }
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
            border-radius: 10px;
            background: #ffffff99; 
            box-shadow:  20px 20px 60px #bebebe,-20px -20px 60px #ffffff;
            border: 1px solid #ddd;
        }
    </style>
    @endpush
    
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
                <div class="card p-3 overflow-hidden login-box">
                    <div class="card-body p-4 position-relative">
                        <div class="bg-light text-center py-4 rounded-top">
                            <h4 class="fw-bold mb-0">Welcome Back!</h4>
                            <p class="small mb-0">Please login to continue</p>
                        </div>
            
                        @if (session('status'))
                            <div class="alert alert-info my-3 text-center">
                                {{ session('status') }}
                            </div>
                        @endif
            
                        <div class="form-body mt-3">
                            <form class="row g-3" method="POST" action="{{ route('login') }}">
                                @csrf
            
                                <div class="col-12">
                                    <label for="email" class="form-label text-secondary">Email</label>
                                    <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required autofocus autocomplete="email">
                                    @foreach($errors->get('email') as $error)
                                        <span class="text-danger small"> {{ $error }}</span>
                                    @endforeach
                                </div>
            
                                <div class="col-12">
                                    <label for="password" class="form-label text-secondary">Password</label>
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
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                        <label class="form-check-label text-secondary" for="remember_me">Remember Me</label>
                                    </div>
                                </div>
            
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary btn-block shadow-lg w-100 py-2 fw-bold" style="border-radius: 10px;">Login</button>
                                </div>
                            </form>
                        </div>
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
</x-guest-layout>
