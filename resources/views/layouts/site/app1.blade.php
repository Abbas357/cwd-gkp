<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <meta name="description" content="{{ $settings->meta_description ?? 'Official Website of Communication and Works Department Government of Khyber Pakhtunkhwa' }}">
    <meta name="keywords" content="KP, KPK, Communication and Works Department, C&W Department, KP Government, infrastructure KP, road development, public works, construction KP, C&W projects, Pakistan, Khyber Pakhtunkhwa government, C&W initiatives, civil engineering KP">
    <meta name="author" content="Communication and Works Department, KPK Government">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_US">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $settings->meta_description ?? 'Official Website of Communication and Works Department Government of Khyber Pakhtunkhwa' }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:site_name" content="{{ $title }}">
    <meta name="theme-color" content="#2c9f45">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:logo" content="{{ asset('site/images/logo-square.png') }}">
    <link rel="canonical" href="{{ request()->url() }}">

    <link rel="icon" href="{{ asset('site/images/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('site/lib/pace/loading-bar.css') }}">
    <script src="{{ asset('site/lib/pace/pace.min.js') }}"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600&family=Roboto&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('site/css/bootstrap-icons.min.css') }}">
    <link href="{{ asset('site/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('site/css/style.min.css') }}?v=4" rel="stylesheet">
    @stack('style')
    <link href="{{ asset('site/css/custom.min.css') }}?v=4" rel="stylesheet">
    <script>
        const themes = {
            default: {
                '--cw-primary': '#0b7240'
                , '--cw-primary-light': '#32b877'
                , '--cw-menu-text-color': '#fff'
                , '--cw-primary-deep': '#0b6137'
                , '--cw-dense': '#232323'
                , '--cw-simple': '#FCFCFC'
                , '--cw-simple-alpha': '#F8F8F8'
                , '--cw-simple-beta': '#E0E0E0'
                , '--cw-simple-gray': '#D5D6D7'
                , '--cw-gray': '#C5C5C5'
                , '--cw-dense-gray': '#575757'
                , '--bg-breadcrumb': 'linear-gradient(rgba(255, 255, 255, .7), rgba(255, 255, 255, .7)), url(../images/section-bg1.png) repeat;'
                , '--footer-bg' : 'linear-gradient(to top, #184115, #29654b, #202412)'
            }
            , brown: {
                '--cw-primary': '#855723'
                , '--cw-primary-light': '#ba7b33'
                , '--cw-menu-text-color': '#fff'
                , '--cw-primary-deep': '#5c3c18'
                , '--cw-dense': '#2b1810'
                , '--cw-simple': '#FCFAF7'
                , '--cw-simple-alpha': '#F8F4F0'
                , '--cw-simple-beta': '#E6DCD1'
                , '--cw-simple-gray': '#D5CDC4'
                , '--cw-gray': '#C5B8AC'
                , '--cw-dense-gray': '#767066'
                , '--bg-breadcrumb': 'linear-gradient(rgba(255, 255, 255, .7), rgba(255, 255, 255, .7)), url(../images/section-bg2.png) repeat;'
                , '--footer-bg' : 'linear-gradient(to top, #413215, #654829, #242412)'
            }
            , blue: {
                '--cw-primary': '#1e4d8c'
                , '--cw-primary-light': '#2d6fc7'
                , '--cw-menu-text-color': '#fff'
                , '--cw-primary-deep': '#163761'
                , '--cw-dense': '#1a2634'
                , '--cw-simple': '#F7FAFC'
                , '--cw-simple-alpha': '#F0F4F8'
                , '--cw-simple-beta': '#D1DEE6'
                , '--cw-simple-gray': '#C4D0D9'
                , '--cw-gray': '#ACB8C5'
                , '--cw-dense-gray': '#666D76'
                , '--bg-breadcrumb': 'linear-gradient(rgba(255, 255, 255, .7), rgba(255, 255, 255, .7)), url(../images/breadcrumb-bg3.png) repeat;'
                , '--footer-bg' : 'linear-gradient(to top, #152641, #293d65, #121624)'
            }
        };

        (function() {
            const savedTheme = localStorage.getItem('selectedTheme');
            if (savedTheme && themes[savedTheme]) {
                const theme = themes[savedTheme];
                const styles = Object.entries(theme)
                    .map(([property, value]) => `${property}: ${value}`)
                    .join(';');
                document.write(`<style>body { ${styles} }</style>`);
            }
        })();

    </script>
</head>

<body>
    @include("layouts.site.partials.header")

    <div id="modal-container"></div>

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
    <script src="{{ asset('site/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('site/js/menu.min.js') }}?v=4"></script>
    <script src="{{ asset('site/js/core.min.js') }}?v=4"></script>

    @stack('script')
    <script src="{{ asset('site/js/custom.min.js') }}?v=4"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.createElement('button');
            themeToggle.id = 'theme-toggle';
            themeToggle.className = 'position-fixed';
            themeToggle.style.cssText = 'right: 0; top: 33vh; z-index: 1040; color: white; border: none; padding: .5rem .7rem; border-radius: 5px; cursor: pointer;';

            const icon = document.createElement('i');
            icon.className = 'bi bi-palette';
            icon.style.fontSize = '1.5rem';
            themeToggle.appendChild(icon);

            const offcanvas = document.createElement('div');
            offcanvas.className = 'offcanvas offcanvas-end';
            offcanvas.id = 'themeCanvas';
            offcanvas.setAttribute('tabindex', '-1');
            offcanvas.setAttribute('aria-labelledby', 'themeCanvasLabel');

            const themeOptions = [{
                    name: 'default'
                    , color: '#0b7240'
                    , title: 'Default Theme'
                    , description: 'Original green color scheme'
                }
                , {
                    name: 'brown'
                    , color: '#855723'
                    , title: 'Brown Theme'
                    , description: 'Warm brown color palette'
                }
                , {
                    name: 'blue'
                    , color: '#1e4d8c'
                    , title: 'Blue Theme'
                    , description: 'Professional blue scheme'
                }
            ];

            offcanvas.innerHTML = `
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="themeCanvasLabel">Choose Theme</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <div class="d-flex flex-column gap-3">
                        ${themeOptions.map(theme => `
                            <div class="theme-option p-3 rounded" onclick="applyTheme('${theme.name}')" 
                                style="cursor: pointer; border: 1px solid #ddd;">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div style="width: 25px; height: 25px; background-color: ${theme.color}; border-radius: 50%;"></div>
                                    <h6 class="mb-0">${theme.title}</h6>
                                </div>
                                <small class="text-muted">${theme.description}</small>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;

            document.body.appendChild(themeToggle);
            document.body.appendChild(offcanvas);

            window.applyTheme = function(themeName) {
                const theme = themes[themeName];
                const themedElement = document.querySelector('body');

                Object.entries(theme).forEach(([property, value]) => {
                    themedElement.style.setProperty(property, value);
                });

                localStorage.setItem('selectedTheme', themeName);

                window.themeCanvas.hide();
                applyThemeColorToButton();
            }

            function applyThemeColorToButton() {
                const themedElement = document.querySelector('body');
                const button = document.getElementById('theme-toggle');
                if (themedElement && button) {
                    const themePrimaryColor = getComputedStyle(themedElement).getPropertyValue('--cw-primary');
                    button.style.backgroundColor = themePrimaryColor.trim();
                }
            }

            window.themeCanvas = new bootstrap.Offcanvas(document.getElementById('themeCanvas'));

            themeToggle.addEventListener('click', () => {
                window.themeCanvas.show();
            });

            const savedTheme = localStorage.getItem('selectedTheme');
            if (savedTheme && themes[savedTheme]) {
                applyTheme(savedTheme);
            }

            applyThemeColorToButton();
        });

    </script>

</body>
</html>
