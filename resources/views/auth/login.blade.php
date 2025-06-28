<x-guest-layout>
    
@push('style')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    .info-text {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border: none !important;
        border-radius: 16px !important;
        padding: 2rem !important;
        position: relative;
        overflow: hidden;
    }
    
    .info-text::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        background-size: 200% 100%;
        animation: gradientShift 1s ease-in-out infinite;
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .info-text h2 {
        background: linear-gradient(135deg, #667eea, #764ba2);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-weight: 700 !important;
        font-size: 2rem;
        letter-spacing: -0.5px;
        text-shadow: none !important;
        margin-bottom: 0.5rem !important;
    }
    
    .info-text p {
        color: #64748b;
        font-weight: 500;
        font-size: 0.875rem;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .form-control {
        padding: 0.55rem 1rem;
    }
    /* Focus ring for accessibility */
    .form-control:focus-visible,
    .cw-btn:focus-visible,
    .form-check-input:focus-visible {
        outline: 2px solid #667eea;
    }

    /* Responsive enhancements */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
        
        .info-text {
            padding: 1.5rem !important;
        }
        
        .info-text h4 {
            font-size: 1.5rem;
        }
    }

</style>
@endpush
    
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
                <div class="card p-3 overflow-hidden login-box">
                    <div class="card-body p-2 py-3 position-relative">
                        <div class="info-text border text-center py-4 rounded-top" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.15)">
                            <h2 class="fw-bold mb-2" style="text-shadow: 3px 3px 7px rgba(0, 0, 0, 0.5)">WELCOME BACK</h2>
                            <p class="small mb-0">PLEASE LOGIN TO CONTINUE</p>
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
                                    <label for="email" class="form-label text-secondary">Email / Username</label>
                                    <input type="text" class="form-control shadow-sm" id="email" name="email" placeholder="Email / Username" value="{{ old('email') }}" required autofocus autocomplete="email">
                                    @foreach($errors->get('email') as $error)
                                        <span class="text-danger small"> {{ $error }}</span>
                                    @endforeach
                                </div>
            
                                <div class="col-12">
                                    <label for="password" class="form-label text-secondary">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" class="form-control shadow-sm" id="password" placeholder="Password" name="password" required autocomplete="current-password">
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
                                    <button type="submit" class="submit-btn cw-btn block">Login</button>
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

    document.querySelector('form').addEventListener('submit', function() {
        document.querySelector('button[type="submit"]').textContent = 'Please wait ...';
    });

    </script>
    @endpush
</x-guest-layout>
