<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Encoding and Viewport -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token and Title -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Meta Description and Keywords -->
    <meta name="description" content="{{ $settings->meta_description ?? 'Official Website of Communication and Works Department Government of Khyber Pakhtunkhwa' }}">
    <meta name="keywords" content="KP, KPK, Communication and Works Department, C&W Department, KP Government, infrastructure KP, road development, public works, construction KP, C&W projects, Pakistan, Khyber Pakhtunkhwa government, C&W initiatives, civil engineering KP">
    <meta name="author" content="Communication and Works Department, KPK Government">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $settings->meta_description ?? 'Official Website of Communication and Works Department Government of Khyber Pakhtunkhwa' }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:site_name" content="{{ $title }}">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:logo" content="{{ asset('site/images/logo-square.png') }}">
    <link rel="canonical" href="{{ request()->url() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('site/images/favicon.ico') }}" type="image/x-icon">

    <!-- Preconnect for Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('site/lib/pace/loading-bar.css') }}">
    <link rel="stylesheet" href="{{ asset('site/css/bootstrap-icons.min.css') }}">
    <link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/css/style.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('site/css/custom.css') }}" rel="stylesheet">
</head>


<body>
    @include("layouts.site.partials.header")

    @if(isset($breadcrumbTitle) || isset($breadcrumbItems))
    <div class="container-fluid bg-breadcrumb mb-1">
        <div class="container d-flex justify-content-between align-items-center">
            @isset($breadcrumbTitle)
                <h3 class="fs-4" style="text-shadow: 3px 3px 3px #00000055">
                    {{ $breadcrumbTitle }}
                </h3>
            @endisset
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('site') }}" class="text-decoration-none sunken-text">Home</a>
                </li>  
                {{ $breadcrumbItems ?? '' }}
            </ol>
        </div>
    </div>
    
    @endif

    <main class="cw-main-content">
        {{ $slot }}
    </main>

    @include("layouts.site.partials.footer")

    <script src="{{ asset('site/js/jquery.min.js') }}"></script>
    <script src="{{ asset('site/lib/pace/pace.min.js') }}"></script>
    <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/js/menu.js') }}"></script>
    <script src="{{ asset('site/js/core.min.js') }}"></script>

    @stack('script')
    <script src="{{ asset('site/js/custom.js') }}"></script>
</body>
</html>
