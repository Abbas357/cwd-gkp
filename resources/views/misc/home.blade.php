<x-app-layout title="Dashboard" :showAside="false" id="particles-js">
    @push('style')
        <style>
            /* CSS Variables for Color Management */
            :root {
                /* Define primary colors for each accent */
                --accent-purple: #8d0fe0;
                --accent-black: #000000;
                --accent-red: #ff0000;
                --accent-blue: #1DA1F2;
                --accent-teal: #1a9ea5;
                --accent-pink: #ff69e4;
                --accent-orange: #f47721;
                --accent-yellow: #c7bd03;
                --accent-brown: #d5641c;
                --accent-green: #00db87;

                /* Common color calculations */
                --shadow-opacity: 0.3;
                --hover-shadow-opacity: 0.4;
                --gradient-angle: 135deg;
                --tile-bg-light: white;
                --tile-bg-dark: #2a2a2a;
                --text-color-light: #333;
                --text-color-dark: #eee;

                /* Accent-specific color variables for hover effects */
                --accent-purple-light: color-mix(in srgb, var(--accent-purple) 80%, white);
                --accent-black-light: color-mix(in srgb, var(--accent-black) 80%, white);
                --accent-red-light: color-mix(in srgb, var(--accent-red) 80%, white);
                --accent-blue-light: color-mix(in srgb, var(--accent-blue) 80%, white);
                --accent-teal-light: color-mix(in srgb, var(--accent-teal) 80%, white);
                --accent-pink-light: color-mix(in srgb, var(--accent-pink) 80%, white);
                --accent-orange-light: color-mix(in srgb, var(--accent-orange) 80%, white);
                --accent-yellow-light: color-mix(in srgb, var(--accent-yellow) 80%, white);
                --accent-brown-light: color-mix(in srgb, var(--accent-brown) 80%, white);
                --accent-green-light: color-mix(in srgb, var(--accent-green) 80%, white);
            }

            /* Welcome Message Animation */
            @keyframes slideInDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .welcome-message {
                animation: slideInDown 0.6s ease-out;
            }

            /* Enhanced Wrapper */
            .wrapper {
                margin: 0 auto !important;
                max-width: 1000px;
                width: 90%;
                text-align: center;
                position: relative;
                z-index: 1;
                padding: 1rem 0;
                opacity: 0;
                animation: fadeIn 0.8s ease-out 0.3s forwards;
            }

            @keyframes fadeIn {
                to {
                    opacity: 1;
                }
            }

            #searchBar {
                width: 80%;
                padding: .8rem 2rem;
                margin-bottom: 2rem;
                border-radius: 50px;
                font-size: 1.3em;
                transition: all 0.3s ease;
                position: relative;
                z-index: 10;
                border: 2px solid transparent;
                background: linear-gradient(white, white) padding-box,
                    linear-gradient(135deg, #667eea, #764ba2) border-box;
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
                opacity: 0.9;
            }

            #searchBar:focus {
                outline: none;
                box-shadow: 0 5px 25px rgba(102, 126, 234, 0.3);
                transform: translateY(-2px) scale(1.02);
                opacity: 1;
            }

            [data-bs-theme=dark] #searchBar {
                background: linear-gradient(#2a2a2a, #2a2a2a) padding-box,
                    linear-gradient(135deg, #667eea, #764ba2) border-box;
                color: #fff;
                box-shadow: 0 5px 20px rgba(255, 255, 255, 0.05);
            }

            /* Enhanced App Grid */
            .app-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 25px;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
                opacity: 0;
                animation: gridFadeIn 0.8s ease-out 0.5s forwards;
            }

            @keyframes gridFadeIn {
                to {
                    opacity: 1;
                }
            }

            /* Enhanced App Tiles */
            .app-tile {
                background-color: var(--tile-bg-light);
                padding: 1.2rem 0;
                border-radius: 1.2rem;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                text-align: center;
                cursor: pointer;
                position: relative;
                z-index: 10;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border: 3px solid transparent;
                text-decoration: none;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 120px;
                overflow: hidden;
                transform: translateY(20px);
                opacity: 0;
                animation: tileAppear 0.5s ease-out forwards;
            }

            /* Define accent-specific CSS variables for each tile */
            .accent-purple {
                --current-accent: var(--accent-purple);
                --current-accent-light: var(--accent-purple-light);
            }

            .accent-black {
                --current-accent: var(--accent-black);
                --current-accent-light: var(--accent-black-light);
            }

            .accent-red {
                --current-accent: var(--accent-red);
                --current-accent-light: var(--accent-red-light);
            }

            .accent-blue {
                --current-accent: var(--accent-blue);
                --current-accent-light: var(--accent-blue-light);
            }

            .accent-teal {
                --current-accent: var(--accent-teal);
                --current-accent-light: var(--accent-teal-light);
            }

            .accent-pink {
                --current-accent: var(--accent-pink);
                --current-accent-light: var(--accent-pink-light);
            }

            .accent-orange {
                --current-accent: var(--accent-orange);
                --current-accent-light: var(--accent-orange-light);
            }

            .accent-yellow {
                --current-accent: var(--accent-yellow);
                --current-accent-light: var(--accent-yellow-light);
            }

            .accent-brown {
                --current-accent: var(--accent-brown);
                --current-accent-light: var(--accent-brown-light);
            }

            .accent-green {
                --current-accent: var(--accent-green);
                --current-accent-light: var(--accent-green-light);
            }

            /* Stagger animation for tiles */
            .app-tile:nth-child(1) {
                animation-delay: 0.6s;
            }

            .app-tile:nth-child(2) {
                animation-delay: 0.7s;
            }

            .app-tile:nth-child(3) {
                animation-delay: 0.8s;
            }

            .app-tile:nth-child(4) {
                animation-delay: 0.9s;
            }

            .app-tile:nth-child(5) {
                animation-delay: 1.0s;
            }

            .app-tile:nth-child(6) {
                animation-delay: 1.1s;
            }

            .app-tile:nth-child(7) {
                animation-delay: 1.2s;
            }

            .app-tile:nth-child(8) {
                animation-delay: 1.3s;
            }

            .app-tile:nth-child(9) {
                animation-delay: 1.4s;
            }

            .app-tile:nth-child(10) {
                animation-delay: 1.5s;
            }

            @keyframes tileAppear {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            [data-bs-theme=dark] .app-tile {
                background-color: var(--tile-bg-dark);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }

            .app-tile:hover {
                transform: translateY(-8px) scale(1.05);
                box-shadow: 0 20px 40px rgba(var(--current-accent-rgb, 0, 0, 0), var(--shadow-opacity));
            }

            [data-bs-theme=dark] .app-tile:hover {
                box-shadow: 0 20px 40px rgba(var(--current-accent-rgb, 0, 0, 0), var(--hover-shadow-opacity));
            }

            .app-tile p {
                font-size: 1em;
                font-weight: 600;
                color: var(--text-color-light);
                margin-top: 10px;
                margin-bottom: 0;
                transition: all 0.3s ease;
            }

            [data-bs-theme=dark] .app-tile p {
                color: var(--text-color-dark);
            }

            .app-tile i {
                font-size: 2.8rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                color: var(--current-accent);
            }

            .app-tile:hover i {
                transform: scale(1.2) rotate(5deg);
                opacity: 1;
            }

            /* Enhanced Accent Effects with unified gradient system */
            .app-tile::before {
                content: '';
                position: absolute;
                top: -2px;
                left: -2px;
                right: -2px;
                bottom: -2px;
                border-radius: 1.2rem;
                background: linear-gradient(var(--gradient-angle), var(--current-accent), var(--current-accent-light));
                opacity: 0;
                transition: all 0.3s ease;
                z-index: -1;
            }

            .app-tile:hover::before {
                opacity: 1;
                top: -5px;
                left: -5px;
                right: -5px;
                bottom: -5px;
            }

            /* Intelligent contrast handling for hover state */
            .app-tile:hover {
                background: var(--current-accent);
            }

            /* Light background colors get dark text/icons on hover */
            .accent-yellow:hover,
            .accent-pink:hover,
            .accent-orange:hover {
                --hover-text-color: #000;
                --hover-icon-filter: invert(1);
            }

            /* Dark background colors get light text/icons on hover */
            .accent-purple:hover,
            .accent-black:hover,
            .accent-red:hover,
            .accent-blue:hover,
            .accent-teal:hover,
            .accent-brown:hover,
            .accent-green:hover {
                --hover-text-color: #fff;
                --hover-icon-filter: brightness(0) invert(1);
            }

            .app-tile:hover p {
                color: var(--hover-text-color, #fff);
            }

            .app-tile:hover i {
                filter: var(--hover-icon-filter, none);
            }

            /* Convert RGB values for box-shadow usage */
            .accent-purple {
                --current-accent-rgb: 141, 15, 224;
            }

            .accent-black {
                --current-accent-rgb: 0, 0, 0;
            }

            .accent-red {
                --current-accent-rgb: 255, 0, 0;
            }

            .accent-blue {
                --current-accent-rgb: 29, 161, 242;
            }

            .accent-teal {
                --current-accent-rgb: 26, 158, 165;
            }

            .accent-pink {
                --current-accent-rgb: 255, 105, 228;
            }

            .accent-orange {
                --current-accent-rgb: 244, 119, 33;
            }

            .accent-yellow {
                --current-accent-rgb: 199, 189, 3;
            }

            .accent-brown {
                --current-accent-rgb: 213, 100, 28;
            }

            .accent-green {
                --current-accent-rgb: 0, 219, 135;
            }

            /* Dark mode adjustments */
            [data-bs-theme=dark] .app-tile:hover::before {
                opacity: 1;
            }

            /* Loading state for tiles */
            .app-tile.loading {
                pointer-events: none;
                opacity: 0.6;
            }

            .app-tile.loading::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.8);
                border-radius: 1.2rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            [data-bs-theme=dark] .app-tile.loading::after {
                background: rgba(0, 0, 0, 0.8);
            }

            /* Particles enhancement */
            #particles-js {
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                background-color: transparent;
                z-index: 1;
            }

            /* Enhanced page header */
            .page-header {
                margin-bottom: 2rem;
                position: relative;
                z-index: 10;
                opacity: 0;
                animation: slideInDown 0.8s ease-out 0.2s forwards;
            }

            .page-header h1 {
                font-size: 2.5rem;
                font-weight: 700;
                background: linear-gradient(135deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin-bottom: 1rem;
                letter-spacing: -1px;
            }

            [data-bs-theme=dark] .page-header h1 {
                background: linear-gradient(135deg, #6d8cd9, #8fa7f7);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }

            .page-header p {
                font-size: 1.2rem;
                color: #666;
                max-width: 600px;
                margin: 0 auto;
                font-weight: 500;
            }

            [data-bs-theme=dark] .page-header p {
                color: #aaa;
            }

            /* Ripple effect on click */
            .ripple {
                position: absolute;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.6);
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            }

            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }

            /* Enhanced badge styles */
            .badge {
                transition: all 0.3s ease;
                padding: 0.5rem 1rem;
            }

            .badge:hover {
                transform: scale(1.05);
            }

            #place-request {
                cursor: pointer;
                animation: pulse 2s infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4);
                }

                50% {
                    box-shadow: 0 0 0 10px rgba(13, 110, 253, 0);
                }
            }
        </style>
    @endpush

    <div id="particles-js"></div>
    <div class="wrapper">

        @php
            $user = auth()->user();
        @endphp
        <div class="mb-2 welcome-message">
            <h4 class="fw-bold text-primary mb-1">Welcome, {{ $user->name }}, <span class="text-secondary fw-semibold">
                    {{ $user?->currentOffice?->name ?? 'Currently no posting' }}</span> </h4>
            <div class="fw-bold d-flex flex-wrap align-items-center justify-content-center">
                <span class="badge bg-danger fs-6">Important Notice:</span> &nbsp; If you have no posting or office is
                incorrect, kindly place a transfer/posting request &nbsp;<span class="badge bg-primary cursor-pointer"
                    id="place-request">here.</span>
            </div>
        </div>
        <div class="page-header py-2 px-2 rounded shadow-sm border-top">
            <div>
                <h1 class="display-3 fw-bold mb-1">App Center</h1>
                <p class="fs-5 fw-bold">At your fingertips; every app you need in one place.</p>
            </div>
        </div>

        <input type="text" id="searchBar" placeholder="Search apps..." oninput="filterApps()">

        <div class="app-grid" id="appGrid">
            @if (
                $user->can('viewAny', App\Models\News::class) ||
                    $user->can('viewAny', App\Models\Event::class) ||
                    $user->can('viewAny', App\Models\Tender::class) ||
                    $user->can('viewAny', App\Models\Seniority::class) ||
                    $user->can('viewAny', App\Models\Gallery::class) ||
                    $user->can('viewAny', App\Models\Slider::class) ||
                    $user->can('viewAny', App\Models\Story::class) ||
                    $user->can('viewAny', App\Models\Page::class) ||
                    $user->can('viewAny', App\Models\Download::class) ||
                    $user->can('viewAny', App\Models\Project::class) ||
                    $user->can('viewAny', App\Models\ProjectFile::class) ||
                    $user->can('viewAny', App\Models\DevelopmentProject::class) ||
                    $user->can('viewAny', App\Models\Scheme::class) ||
                    $user->can('viewAny', App\Models\Achievement::class) ||
                    $user->can('viewAny', App\Models\Comment::class) ||
                    $user->can('viewAny', App\Models\PublicContact::class) ||
                    $user->can('viewAny', App\Models\NewsLetter::class) ||
                    $user->can('massEmail', App\Models\NewsLetter::class))
                <a href="{{ route('admin.home') }}" class="app-tile accent-purple">
                    <i class="bi-globe"></i>
                    <p>Web Portal</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\User::class) ||
                    $user->can('viewAny', App\Models\Office::class) ||
                    $user->can('viewAny', App\Models\Designation::class) ||
                    $user->can('viewAny', App\Models\SanctionedPost::class) ||
                    $user->can('viewAny', App\Models\Posting::class) ||
                    $user->can('viewAny', App\Models\Role::class) ||
                    $user->can('assignRole', App\Models\Role::class) ||
                    $user->can('assignPermission', App\Models\Role::class) ||
                    $user->can('viewAny', App\Models\Permission::class) ||
                    $user->can('viewOrganogram', App\Models\office::class))
                <a href="{{ route('admin.apps.hr.index') }}" class="app-tile accent-green">
                    <i class="bi-people"></i>
                    <p>User Mgt.</p>
                </a>
            @endif

            @if ($user->can('viewAny', App\Models\Vehicle::class) || $user->can('viewReports', App\Models\Vehicle::class))
                <a href="{{ route('admin.apps.vehicles.index') }}" class="app-tile accent-black">
                    <i class="bi-bus-front"></i>
                    <p>{{ setting('appName', 'vehicle', 'Vehicle Mgt.') }}</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\Contractor::class) ||
                    $user->can('viewAny', App\Models\ContractorRegistration::class) ||
                    $user->can('viewAny', App\Models\ContractorHumanResource::class) ||
                    $user->can('viewAny', App\Models\ContractorMachinery::class) ||
                    $user->can('viewAny', App\Models\ContractorWorkExperience::class))
                <a href="{{ route('admin.apps.standardizations.index') }}" class="app-tile accent-blue">
                    <i class="bi-patch-check-fill"></i>
                    <p>Standardization</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\Contractor::class) ||
                    $user->can('viewAny', App\Models\ContractorRegistration::class) ||
                    $user->can('viewAny', App\Models\ContractorHumanResource::class) ||
                    $user->can('viewAny', App\Models\ContractorMachinery::class) ||
                    $user->can('viewAny', App\Models\ContractorWorkExperience::class))
                <a href="{{ route('admin.apps.contractors.index') }}" class="app-tile accent-teal">
                    <i class="bi-person-vcard"></i>
                    <p>Contractors</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\Consultant::class) ||
                    $user->can('viewAny', App\Models\ConsultantHumanResource::class) ||
                    $user->can('viewAny', App\Models\ConsultantProject::class))
                <a href="{{ route('admin.apps.consultants.index') }}" class="app-tile accent-pink">
                    <i class="bi-person-lines-fill"></i>
                    <p>Consultants</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\ServiceCard::class) ||
                    $user->can('create', App\Models\ServiceCard::class) ||
                    $user->can('viewCard', App\Models\ServiceCard::class) ||
                    $user->can('pending', App\Models\ServiceCard::class) ||
                    $user->can('verify', App\Models\ServiceCard::class) ||
                    $user->can('reject', App\Models\ServiceCard::class) ||
                    $user->can('renew', App\Models\ServiceCard::class) ||
                    $user->can('markLost', App\Models\ServiceCard::class) ||
                    $user->can('duplicate', App\Models\ServiceCard::class) ||
                    $user->can('markPrinted', App\Models\ServiceCard::class) ||
                    $user->can('searchUsers', App\Models\ServiceCard::class) ||
                    $user->can('createUser', App\Models\ServiceCard::class) ||
                    $user->can('updateUser', App\Models\ServiceCard::class))
                <a href="{{ route('admin.apps.service_cards.index') }}" class="app-tile accent-orange">
                    <i class="bi-credit-card"></i>
                    <p>Service Card</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\ProvincialOwnReceipt::class) ||
                    $user->can('viewReports', App\Models\ProvincialOwnReceipt::class))
                <a href="{{ route('admin.apps.porms.index') }}" class="app-tile accent-yellow">
                    <i class="bi-coin"></i>
                    <p>PORMS</p>
                </a>
            @endif

            @if ($user->can('viewAny', App\Models\Machinery::class) || $user->can('viewReports', App\Models\Machinery::class))
                <a href="{{ route('admin.apps.machineries.index') }}" class="app-tile accent-brown">
                    <i class="bi-building-gear"></i>
                    <p>{{ setting('appName', 'machinery', 'Machnery Mgt.') }}</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\Damage::class) ||
                    $user->can('viewAny', App\Models\Infrastructure::class) ||
                    $user->can('viewMainReport', App\Models\Damage::class) ||
                    $user->can('viewDistrictWiseReport', App\Models\Damage::class))
                <a href="{{ route('admin.apps.dmis.index') }}" class="app-tile accent-red">
                    <i class="bi-cloud-drizzle"></i>
                    <p>{{ setting('appName', 'dmis') }}</p>
                </a>
            @endif
            @if ($user->can('viewAny', App\Models\SecureDocument::class))
                <a href="{{ route('admin.apps.documents.index') }}" class="app-tile accent-red">
                    <i class="bi-shield" style="color: #d01c1c"></i>
                    <p>Secure Docs</p>
                </a>
            @endif
        </div>
    </div>

    @push('script')
        <script src="{{ asset('admin/plugins/particles.js/particles.min.js') }}"></script>

        <script>
            const appTiles = document.querySelectorAll('.app-tile');

            pushStateModal({
                fetchUrl: "{{ route('admin.transfer_requests.create') }}",
                btnSelector: '#place-request',
                title: 'Submit Transfer Request',
                actionButtonName: 'Add Transfer Request',
                modalSize: 'md',
                includeForm: true,
                formAction: "{{ route('admin.transfer_requests.store') }}",
                hash: false,
            });

            appTiles.forEach(tile => {

                // Add ripple effect on click
                tile.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Create ripple
                    const ripple = document.createElement('span');
                    ripple.classList.add('ripple');
                    this.appendChild(ripple);

                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';

                    // Add loading state
                    this.classList.add('loading');

                    // Show page loader

                    // Navigate after animation
                    setTimeout(() => {
                        window.location.href = this.getAttribute('href');
                    }, 300);

                    // Remove ripple after animation
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });

            // Enhanced particles configuration
            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 1000
                        }
                    },
                    "color": {
                        "value": ["#667eea", "#764ba2", "#f093fb", "#f5576c"]
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 4,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 3,
                            "size_min": 0.5,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#667eea",
                        "opacity": 0.4,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 2,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 200,
                            "line_linked": {
                                "opacity": 1
                            }
                        },
                        "bubble": {
                            "distance": 400,
                            "size": 40,
                            "duration": 2,
                            "opacity": 8,
                            "speed": 3
                        },
                        "repulse": {
                            "distance": 200,
                            "duration": 0.4
                        },
                        "push": {
                            "particles_nb": 4
                        },
                        "remove": {
                            "particles_nb": 2
                        }
                    }
                },
                "retina_detect": true
            });

            // Add disappear animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes tileDisappear {
                    to {
                        opacity: 0;
                        transform: translateY(20px) scale(0.9);
                    }
                }
            `;
            document.head.appendChild(style);

            // Smooth scroll for search bar focus
            document.getElementById('searchBar').addEventListener('focus', function() {
                this.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            });

            // Add keyboard navigation
            let currentFocus = -1;
            document.getElementById('searchBar').addEventListener('input', () => filerApps);

            function filterApps() {
                const searchInput = document.getElementById("searchBar").value.toLowerCase();
                const appTiles = document.querySelectorAll(".app-tile");

                appTiles.forEach((tile) => {
                    const appName = tile.querySelector("p").textContent.toLowerCase();
                    if (appName.includes(searchInput)) {
                        tile.style.display = "";
                    } else {
                        tile.style.display = "none";
                    }
                });
            }

            function addActive(tiles) {
                removeActive(tiles);
                if (currentFocus >= tiles.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = tiles.length - 1;
                if (tiles[currentFocus]) {
                    tiles[currentFocus].classList.add('active-focus');
                    tiles[currentFocus].scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            }

            function removeActive(tiles) {
                tiles.forEach(tile => tile.classList.remove('active-focus'));
            }

            // Add active focus style
            const focusStyle = document.createElement('style');
            focusStyle.textContent = `
                .app-tile.active-focus {
                    transform: translateY(-8px) scale(1.05);
                    box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4) !important;
                }
            `;
            document.head.appendChild(focusStyle);

            // Performance optimization: Lazy load tiles animation
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const tileObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animation = 'tileAppear 0.5s ease-out forwards';
                        tileObserver.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all tiles
            document.querySelectorAll('.app-tile').forEach(tile => {
                tileObserver.observe(tile);
            });
        </script>
    @endpush
</x-app-layout>
