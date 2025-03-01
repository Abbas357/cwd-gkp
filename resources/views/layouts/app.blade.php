<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <link rel="icon" href="{{ asset('admin/images/favicon.ico') }}" type="image/png" />

    <link href="{{ asset('admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/metismenu/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/metismenu/mm-vertical.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">

    <link href="{{ asset('admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/open-props.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/main.min.css') }}?cw=19" rel="stylesheet">
    <link href="{{ asset('admin/css/semi-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/bordered-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/responsive.css') }}" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('admin/css/custom.min.css') }}?cw=19" rel="stylesheet">
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
            0% {
                background-position: -150% 0, -150% 0;
            }

            66% {
                background-position: 250% 0, -150% 0;
            }

            100% {
                background-position: 250% 0, 250% 0;
            }
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

    <x-header :show-aside="$showAside">
        <x-slot name="breadcrumb">
            {{ $header ?? '' }}
        </x-slot>
    </x-header>
    
    @if ($showAside)
    <x-sidebar app-name="WEBSITE">
        @canany(['view any user', 'view any seniority'])
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-people-fill text-warning"></i></div>
                <div class="menu-title">User Management</div>
            </a>
            <ul class="p-2 menu-items">
                @can('view any user')
                <li><a href="{{ route('admin.users.index') }}"><i class="bi-person-circle fs-6"></i>&nbsp; Users</a></li>
                @endcan
                @can('view any seniority')
                <li><a href="{{ route('admin.seniority.index') }}"><i class="bi-graph-up-arrow fs-6"></i>&nbsp; Seniority</a></li>
                @endcan
                @can('view hierarchy')
                <li><a href="{{ route('admin.users.hierarchy') }}"><i class="bi-person-circle fs-6"></i>&nbsp; Hierarchy</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['view any news', 'view any event', 'view any tender'])
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-megaphone text-primary"></i></div>
                <div class="menu-title">Updates</div>
            </a>
            <ul class="p-2 menu-items">
                @can('view any news')
                <li><a href="{{ route('admin.news.index') }}"><i class="bi-newspaper fs-6"></i>&nbsp; News</a></li>
                @endcan
                @can('view any event')
                <li><a href="{{ route('admin.events.index') }}"><i class="bi-calendar2-event fs-6"></i>&nbsp; Events</a></li>
                @endcan
                @can('view any tender')
                <li><a href="{{ route('admin.tenders.index') }}"><i class="bi-briefcase fs-6"></i>&nbsp; Tenders</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['view any slider', 'view any story', 'view any gallery'])
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-collection-play-fill text-success"></i></div>
                <div class="menu-title">Media</div>
            </a>
            <ul class="p-2 menu-items">
                @can('view any slider')
                <li><a href="{{ route('admin.sliders.index') }}"><i class="bi-images fs-6"></i>&nbsp; Sliders</a></li>
                @endcan
                @can('view any story')
                <li><a href="{{ route('admin.stories.index') }}"><i class="bi-circle fs-6"></i>&nbsp; Stories</a></li>
                @endcan
                @can('view any gallery')
                <li><a href="{{ route('admin.gallery.index') }}"><i class="bi-card-image fs-6"></i>&nbsp; Gallery</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['view any project', 'view project file', 'create development project'])
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-kanban text-primary"></i></div>
                <div class="menu-title">Projects</div>
            </a>
            <ul class="p-2 menu-items">
                @can('view any project')
                <li><a href="{{ route('admin.projects.index') }}"><i class="bi-kanban fs-6"></i>&nbsp; Projects</a></li>
                @endcan
                @can('view project file')
                <li><a href="{{ route('admin.project_files.index') }}"><i class="bi-folder fs-6"></i>&nbsp; Project Files</a></li>
                @endcan
                @can('create development project')
                <li><a href="{{ route('admin.development_projects.index') }}"><i class="bi-buildings fs-6"></i>&nbsp; Dev. Projects</a></li>
                @endcan
                @can('view any project')
                <li><a href="{{ route('admin.schemes.index') }}"><i class="bi-building fs-6"></i>&nbsp; Schemes</a></li>
                @endcan
                @can('view any achievement')
                <li><a href="{{ route('admin.achievements.index') }}"><i class="bi-building fs-6"></i>&nbsp; Achievements</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['view any page', 'create download'])
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-database text-success"></i></div>
                <div class="menu-title">Site Content</div>
            </a>
            <ul class="p-2 menu-items">
                @can('view any page')
                <li><a href="{{ route('admin.pages.index') }}"><i class="bi-file-earmark-plus fs-6"></i>&nbsp; Pages</a></li>
                @endcan
                @can('create download')
                <li><a href="{{ route('admin.downloads.index') }}"><i class="bi-cloud-arrow-down fs-6"></i>&nbsp; Downloads</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @canany(['update comment', 'view any newsletter', 'view any public contact'])
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi-person-walking text-danger"></i></div>
                <div class="menu-title">Public Dealings</div>
            </a>
            <ul class="p-2 menu-items">
                @can('update comment')
                <li><a href="{{ route('admin.comments.index') }}"><i class="bi-chat fs-6"></i>&nbsp; Comments</a></li>
                @endcan
                @can('view any newsletter')
                <li><a href="{{ route('admin.newsletter.create_mass_email') }}"><i class="bi-send fs-6"></i>&nbsp; Send Email</a></li>
                <li><a href="{{ route('admin.newsletter.index') }}"><i class="bi-envelope fs-6"></i>&nbsp; All Emails</a></li>
                @endcan
                @can('view any public contact')
                <li><a href="{{ route('admin.public_contact.index') }}"><i class="bi-exclamation-triangle fs-6"></i>&nbsp; Queries</a></li>
                @endcan
            </ul>
        </li>
        @endcanany
    </x-sidebar>
    @endif

    <main class="main-wrapper" style="{{ !$showAside ? 'margin-left: 0;' : '' }}">
        <div class="main-content">
            @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showMessage("{{ session('success') }}");
                });

            </script>
            @endif

            @if (session('danger'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showMessage("{{ session('danger') }}", 'error');
                });

            </script>
            @endif

            {{ $slot }}
            <br /><br />
        </div>
    </main>

    <div class="overlay btn-toggle"></div>

    <x-footer :show-aside="$showAside" :site-name="$settings->site_name" />
    
    <x-theme-switcher current-theme="LightTheme" />

    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>

    <script src="{{ asset('admin/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/plugins/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/sweetalert2@11.js') }}"></script>

    <script src="{{ asset('admin/js/helpers.min.js') }}?cw=19"></script>
    <script src="{{ asset('admin/js/custom.min.js') }}?cw=19"></script>
    @stack('script')
    <script>
        window.onload = function() {
            document.querySelector('.page-loader').classList.add('hidden');
            document.body.classList.remove('loading');
        }

    </script>
</body>

</html>
