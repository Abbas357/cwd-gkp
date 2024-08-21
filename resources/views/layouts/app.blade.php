<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Communication and Works Department KP') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/png" />

    <link href="{{ asset('plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/metismenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/metismenu/mm-vertical.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/semi-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bordered-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet">

    @stack('style')
</head>

<body>
    @include("layouts.partials.header")
    @include("layouts.partials.aside")

    <main class="main-wrapper">
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('danger'))
        <div class="alert alert-danger">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Uh Oh!</strong> {{ session('danger') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        <div class="main-content">
            @if (isset($header))
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-2"><a href="{{ route('dashboard') }}"><svg class="mb-1" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="currentColor">
                            <path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" /></svg></a></div> <span class="fs-5">\</span>
                <div class="ps-2">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            {{ $header }}
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end"> <a class="dropdown-item" href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{ $slot }}
        </div>>
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

    @stack('script')
</body>

</html>
