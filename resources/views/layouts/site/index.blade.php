<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <meta name="description" content="{{ setting('meta_description', 'main', 'Official Website of Communication and Works Department Government of Khyber Pakhtunkhwa') }}">
    <meta name="keywords" content="KP, KPK, Communication and Works Department, C&W Department, KP Government, infrastructure KP, road development, public works, construction KP, C&W projects, Pakistan, Khyber Pakhtunkhwa government, C&W initiatives, civil engineering KP">
    <meta name="author" content="Communication and Works Department, KPK Government">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ setting('meta_description', 'main', 'Official Website of Communication and Works Department Government of Khyber Pakhtunkhwa') }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:site_name" content="{{ $title }}">
    <meta name="theme-color" content="#0b7240">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:logo" content="{{ asset('site/images/logo-square.png') }}?cw=78">
    <link rel="canonical" href="{{ request()->url() }}">

    <link rel="icon" href="{{ asset('site/images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('site/lib/pace/loading-bar.css') }}">
    <script src="{{ asset('site/lib/pace/pace.min.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('site/css/bootstrap-icons.min.css') }}">
    <link href="{{ asset('site/css/bootstrap.min.css') }}?cw=78" rel="stylesheet">
    <link href="{{ asset('site/css/bootstrap-extended.css') }}?cw=78" rel="stylesheet">
    <link href="{{ asset('site/css/style.min.css') }}?cw=78" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('site/css/custom.min.css') }}?cw=78" rel="stylesheet">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('selectedTheme');
            if (savedTheme && savedTheme !== 'default') {
                document.write(`<link id="theme-stylesheet" rel="stylesheet" href="{{ asset('site/css/themes/${savedTheme}.css') }}?cw=78">`);
            }
            
            const updateThemeColor = () => {
                const color = getComputedStyle(document.documentElement).getPropertyValue('--cw-primary').trim();
                document.querySelector("meta[name=theme-color]").setAttribute("content", color);
            };
            updateThemeColor();

        })();
        </script>
</head>

<body>
    @include("layouts.site.partials.header")

    <div id="notification-container"></div>
    <div id="announcement-container"></div>

    @if(isset($breadcrumbTitle) || isset($breadcrumbItems))
    <div class="container-fluid bg-breadcrumb mb-1" style="box-shadow: 0 0 7px var(--cw-primary-light)">
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

    @if (session('success'))
        <div class="container d-flex justify-content-center pt-2 bg-light">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {!! session('success') !!}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container d-flex justify-content-center pt-2 bg-light">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <main class="cw-main-content">
        {{ $slot }}
    </main>

    @include("layouts.site.partials.footer")

    <script src="{{ asset('site/js/jquery.min.js') }}"></script>
    <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/js/menu.min.js') }}?cw=78"></script>
    <script src="{{ asset('site/js/core.min.js') }}?cw=78"></script>
    <script src="{{ asset('site/js/utils.min.js') }}?cw=78"></script>

    @stack('script')
    <script src="{{ asset('site/js/custom.min.js') }}?v=47"></script>
</body>
</html>
