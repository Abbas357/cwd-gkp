<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/png" />

    <link href="{{ asset('plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/metismenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/metismenu/mm-vertical.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/semi-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bordered-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <style>
        .page-loader {
            height: 5px;
            width: 250px;
            --color: no-repeat linear-gradient(rgba(28, 37, 46) 0 0);
            background: var(--color), var(--color), #eee;
            background-size: 60% 100%;
            animation: page-loader 3s infinite;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            border-radius: 50px;
            outline: 1px solid #575757;
        }

        [data-bs-theme=dark] .page-loader {
            outline: 1px solid #bbb;
        }

        @keyframes page-loader {
            0%   {background-position: -150% 0, -150% 0;}
            66%  {background-position: 250% 0, -150% 0;}
            100% {background-position: 250% 0, 250% 0;}
        }

        body.loading::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(51, 50, 50, 0.3);
            z-index: 9998;
        }

        .page-loader.hidden {
            display: none;
        }

        body.loading {
            overflow: hidden;
        }
        
    </style>
</head>

<body class="loading">
    <div class="page-loader"></div>
    
    @include("layouts.partials.header")
    @include("layouts.partials.aside")

    <main class="main-wrapper">
        <div class="main-content">
            @if (session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showMessage("{{ session('success') }}");
                    });
                </script>
            @endif
    
            @if (session('danger'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showMessage("{{ session('danger') }}", 'error');
                    });
                </script>
            @endif
    
            {{ $slot }}
            <br /><br />
        </div>
    </main>
    
    <div class="overlay btn-toggle"></div>

    @include("layouts.partials.footer")
    @include("layouts.partials.theme-switcher")

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <script src="{{ asset('plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script> 
    @stack('script')
    <script>
        window.onload = function() {
            document.querySelector('.page-loader').classList.add('hidden');
            document.body.classList.remove('loading');
        }
    </script>
</body>

</html>
