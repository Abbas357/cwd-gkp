<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/png">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-image">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-0">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="{{ asset('images/logo.png') }}" alt="Official Logo" style="width: 180px"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    Official Website of Communication & Works Department, KP
                </span>
            </div>
        </div>
    </nav>
    <div class="wrapper mt-3">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('danger'))
        <div class="alert alert-danger">
            {{ session('danger') }}
        </div>
        @endif
        {{ $slot }}
    </div>
    <footer class="bg-dark py-2 mt-4 border-top text-white">
        <div class="container d-flex flex-wrap justify-content-between align-items-center">
            <p class="col-md-4 mb-0">© 2024 Communication & Works Department, KP</p>
    
            <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ asset('images/logo-square.png') }}" style="width: 30px" alt="">
            </a>
    
            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-white" href="#"><i class="bi-facebook"></i></a></li>
                <li class="ms-3"><a class="text-white" href="#"><i class="bi-instagram"></i></a></li>
                <li class="ms-3"><a class="text-white" href="#"><i class="bi-twitter"></i></a></li>
            </ul>
        </div>
    </footer>
    
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('script')
</body>
</html>
