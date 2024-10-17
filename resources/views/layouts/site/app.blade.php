<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="Official Website of Communication and Works Department Government of Khyber Pakhtunkhwa" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap-icons.min.css') }}">

    <link href="{{ asset('site/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/lib/lightbox/css/lightbox.min.css') }}" rel="stylesheet">
    
    <link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('site/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('site/css/menu.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('site/css/custom.css') }}" rel="stylesheet">
</head>

<body>
    @include("layouts.site.partials.header")

    <main class="cw-main-content">
        {{ $slot }}
    </main>

    @include("layouts.site.partials.footer")

    <script src="{{ asset('site/js/jquery.min.js') }}"></script>
    <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('site/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('site/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('site/lib/lightbox/js/lightbox.min.js') }}"></script>
    
    <script src="{{ asset('site/js/menu.js') }}"></script>
    <script src="{{ asset('site/js/core.min.js') }}"></script>
    <script src="{{ asset('site/js/custom.js') }}"></script>
    @stack('script')
</body>
</html>
