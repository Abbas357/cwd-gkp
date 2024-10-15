<x-guest-layout>
    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4 mx-auto">
                <div class="card overflow-hidden login-box border border-secondary" style="box-shadow: -20px -20px 20px 0px #fff, 20px 20px 20px 0px #aaa">
                    <div class="card-body p-4 position-relative">
                        <div class="bg-secondary position-absolute top-0 start-0 w-100 p-3">
                            <img src="{{ asset('images/logo.png') }}" class="d-block mx-auto" width="225" alt="">
                        </div>
                        <hr /><br /><br />
                        <h4 class="fw-bold">Login</h4>
                        <p class="mb-0">Enter your credentials to login your account</p>
                        @if (session('status'))
                        {{ $status }}
                        @endif
                        <hr />
                        <div class="form-body my-4">
                            <form class="row g-3" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required autofocus autocomplete="email">
                                    @foreach($errors->get('email') as $error)
                                    <span class="text-danger"> {{ $error }}</span>
                                    @endforeach
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" class="form-control border-end-0" id="password" placeholder="Enter Password" name="password" required autocomplete="current-password">
                                        <a href="javascript:;" class="input-group-text bg-transparent"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor">
                                                <path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z" /></svg></a>
                                        @foreach($errors->get('password') as $error)
                                        <span class="text-danger"> {{ $error }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                        <label class="form-check-label" for="remember_me">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary">Login</button>
                                    </div>
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
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bi-eye-slash-fill");
                    $('#show_hide_password i').removeClass("bi-eye-fill");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bi-eye-slash-fill");
                    $('#show_hide_password i').addClass("bi-eye-fill");
                }
            });
        });

    </script>
    @endpush
</x-guest-layout>
