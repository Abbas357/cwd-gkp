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
</head>

<body>
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
    
</body>

</html>
