<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}" type="image/png">
    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/open-props.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/main.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/responsive.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('admin/css/custom.min.css') }}" rel="stylesheet">
    <style>
      .bg-image::before {
          content: "";
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-image: url("{{ asset('admin/images/bg-image.jpg') }}?cw=59");
          background-size: cover;
          background-position: center;
          filter: blur(5px);
          z-index: -1;
      }
    </style>
</head>
<body class="bg-image" id="particles">
    <header style="background: #ffffff55; backdrop-filter: blur(10px);">
        <div class="px-3 py-2">
          <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
              <a href="/" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                <img src="{{ asset('site/images/logo-mobile.png') }}" style="width: 200px" alt="">
              </a>
    
              <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                <li>
                  <a href="{{ route('site') }}" class="nav-link text-secondary">
                    Home
                  </a>
                </li>
                
              </ul>
            </div>
          </div>
        </div>
      </header>
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
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.min.js') }}"></script>
    @stack('script')
</body>
</html>
