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
    
        /* Loading Bar Styles */
        .loading-bar-container {
            position: absolute;
            top: -1px;
            left: 0;
            right: 0;
            height: 5px;
            background: rgba(255, 255, 255, 0.1);
            overflow: hidden;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }
    
        .loading-bar-container.active {
            opacity: 1;
        }
    
        .loading-bar {
            height: 100%;
            background: #667eea;
            background-size: 300% 100%;
            animation: loadingAnimation 1.3s ease-in-out infinite;
        }
    
        @keyframes loadingAnimation {
            0% {
                transform: translateX(-100%);
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                transform: translateX(100%);
                background-position: 0% 50%;
            }
        }
    
        /* Loading Overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999;
            border-radius: inherit;
        }
    
        .loading-overlay.active {
            display: flex;
        }
    
        /* Spinner */
        .loading-spinner {
            width: 50px;
            height: 50px;
            position: relative;
        }
    
        .loading-spinner::before,
        .loading-spinner::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }
    
        .loading-spinner::before {
            background: #667eea;
            animation: pulse 1.5s ease-in-out infinite;
        }
    
        .loading-spinner::after {
            background: #764ba2;
            animation: pulse 1.5s ease-in-out infinite 0.2s;
        }
    
        @keyframes pulse {
            0%, 100% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 1;
            }
            50% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }
    
        /* Loading Text */
        .loading-text {
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.875rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            white-space: nowrap;
        }
    
        /* Form disabled state */
        .form-disabled {
            pointer-events: none;
            user-select: none;
        }
    
        .form-disabled .form-control,
        .form-disabled .form-check-input,
        .form-disabled .cw-btn {
            opacity: 0.5;
            cursor: not-allowed;
        }
    
        /* Card with overflow visible for loading bar */
        .login-box {
            overflow: visible !important;
        }
    
        .card-body {
            position: relative;
            transition: opacity 0.3s ease;
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
                    <div class="card p-3 overflow-hidden login-box" style="overflow: hidden;">
                        <!-- Loading Bar -->
                        <div class="loading-bar-container" id="loadingBar">
                            <div class="loading-bar"></div>
                        </div>
                        
                        <div class="card-body p-2 py-3 position-relative">
                            <!-- Loading Overlay -->
                            <div class="loading-overlay" id="loadingOverlay">
                                <div class="loading-spinner">
                                    <div class="loading-text">Signing you in...</div>
                                </div>
                            </div>
                            
                            <div class="info-text border text-center py-4 rounded-top" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.15)">
                                <h2 class="fw-bold mb-2" style="text-shadow: 3px 3px 7px rgba(0, 0, 0, 0.5)">WELCOME BACK</h2>
                                <p class="small mb-0">PLEASE LOGIN TO CONTINUE</p>
                            </div>
                
                            @if (session('status'))
                                <div class="alert alert-info my-3 text-center">
                                    {{ session('status') }}
                                </div>
                            @endif
                
                            <div class="form-body mt-3" id="loginForm">
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
    
        document.querySelector('form').addEventListener('submit', function(e) {
            // Show loading bar at the top
            document.getElementById('loadingBar').classList.add('active');
            
            // Show loading overlay
            document.getElementById('loadingOverlay').classList.add('active');
            
            // Disable form
            document.getElementById('loginForm').classList.add('form-disabled');
            
            // Change button text
            const submitBtn = document.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Please wait...';
            submitBtn.disabled = true;
            
            // Optional: Add loading messages that change
            const loadingText = document.querySelector('.loading-text');
            const messages = ['Signing you in...', 'Verifying credentials...', 'Almost there...'];
            let messageIndex = 0;
            
            const messageInterval = setInterval(() => {
                messageIndex = (messageIndex + 1) % messages.length;
                loadingText.textContent = messages[messageIndex];
            }, 1500);
            
            // If you want to test the loading state without actually submitting, uncomment below:
            // e.preventDefault();
            // setTimeout(() => {
            //     document.getElementById('loadingBar').classList.remove('active');
            //     document.getElementById('loadingOverlay').classList.remove('active');
            //     document.getElementById('loginForm').classList.remove('form-disabled');
            //     submitBtn.innerHTML = 'Login';
            //     submitBtn.disabled = false;
            //     clearInterval(messageInterval);
            // }, 3000);
        });
    
        </script>
        @endpush
    </x-guest-layout>