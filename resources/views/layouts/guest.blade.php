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
    <link href="{{ asset('admin/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/responsive.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('admin/css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-image">
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
    <script src="{{ asset('admin/js/custom.js') }}"></script>
    @stack('script')
</body>
</html>
