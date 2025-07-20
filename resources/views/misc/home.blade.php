<x-app-layout title="Dashboard" :showAside="false" id="particles-js">
    @push('style')
        <style>
            .wrapper {
                margin: 0 auto !important;
                max-width: 1000px;
                width: 90%;
                text-align: center;
                position: relative;
                z-index: 1;
                padding: 1rem 0;
            }

            #searchBar {
                width: 80%;
                padding: .5rem 1.5rem;
                margin-bottom: 2rem;
                border-radius: 50px;
                font-size: 1.5em;
                transition: all 0.3s ease;
                position: relative;
                z-index: 10;
                border: 1px solid rgba(0, 0, 0, 0.2);
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
                opacity: 0.9;
            }

            #searchBar:focus {
                outline: none;
                box-shadow: 0 2px 5px rgba(59, 89, 152, 0.3);
                transform: translateY(-2px);
            }

            [data-bs-theme=dark] #searchBar {
                background-color: #2a2a2a;
                color: #fff;
                box-shadow: 0 4px 15px rgba(255, 255, 255, 0.05);
            }

            .app-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                gap: 25px;
                align-items: center;
                justify-content: center;
                margin: 0 auto;
            }

            .app-tile {
                background-color: white;
                padding: 1.2rem 0;
                border-radius: 1.2rem;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                text-align: center;
                cursor: pointer;
                position: relative;
                z-index: 10;
                transition: all 0.3s ease;
                border: 3px solid transparent;
                text-decoration: none;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 120px;
                overflow: hidden;
            }

            [data-bs-theme=dark] .app-tile {
                background-color: #2a2a2a;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            }

            .app-tile:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(59, 89, 152, 0.2);
            }

            [data-bs-theme=dark] .app-tile:hover {
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
            }

            .app-tile p {
                font-size: 1em;
                font-weight: 500;
                color: #333;
                margin-top: 10px;
                margin-bottom: 0;
            }

            [data-bs-theme=dark] .app-tile p {
                color: #eee;
            }

            .app-tile i {
                font-size: 2.8rem;
                transition: all 0.3s ease;
            }

            .app-tile:hover i {
                transform: scale(1.1);
                opacity: 1;
            }

            .app-tile::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border-radius: 1.2rem;
                border: 2px solid;
                opacity: 0.3;
                transition: all 0.3s ease;
            }

            .app-tile:hover::before {
                opacity: 0.8;
            }

            .accent-purple::before {
                border-color: #8d0fe0;
            }

            .accent-black::before {
                border-color: #000000;
            }

            .accent-red::before {
                border-color: #ff0000;
            }

            .accent-blue::before {
                border-color: #1DA1F2;
            }

            .accent-teal::before {
                border-color: #1a9ea5;
            }

            .accent-pink::before {
                border-color: #ff69e4;
            }

            .accent-orange::before {
                border-color: #f47721;
            }

            .accent-yellow::before {
                border-color: #c7bd03;
            }

            .accent-brown::before {
                border-color: #d5641c;
            }

            .accent-green::before {
                border-color: #00db87;
            }

            .accent-purple:hover {
                box-shadow: 0 15px 30px rgba(141, 15, 224, 0.2);
            }

            .accent-black:hover {
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            }

            .accent-red:hover {
                box-shadow: 0 15px 30px rgba(255, 0, 0, 0.2);
            }

            .accent-blue:hover {
                box-shadow: 0 15px 30px rgba(5, 120, 187, 0.2);
            }

            .accent-teal:hover {
                box-shadow: 0 15px 30px rgba(17, 148, 155, 0.2);
            }

            .accent-pink:hover {
                box-shadow: 0 15px 30px rgb(255, 207, 246, .8);
            }

            .accent-orange:hover {
                box-shadow: 0 15px 30px rgba(244, 119, 33, 0.4);
            }

            .accent-yellow:hover {
                box-shadow: 0 15px 30px rgba(226, 222, 5, 0.781);
            }

            .accent-brown:hover {
                box-shadow: 0 15px 30px rgba(165, 145, 31, 0.445);
            }

            .accent-green:hover {
                box-shadow: 0 15px 30px rgba(31, 165, 131, 0.445);
            }

            [data-bs-theme=dark] .app-tile:hover::before {
                opacity: 1;
            }

            [data-bs-theme=dark] .accent-purple:hover {
                box-shadow: 0 15px 30px rgba(141, 15, 224, 0.4);
            }

            [data-bs-theme=dark] .accent-black:hover {
                box-shadow: 0 15px 30px rgba(0, 0, 13, 0.4);
            }

            [data-bs-theme=dark] .accent-red:hover {
                box-shadow: 0 15px 30px rgba(255, 0, 0, 0.4);
            }

            [data-bs-theme=dark] .accent-blue:hover {
                box-shadow: 0 15px 30px rgba(20, 122, 255, 0.4);
            }

            [data-bs-theme=dark] .accent-teal:hover {
                box-shadow: 0 15px 30px rgba(12, 199, 209, 0.4);
            }

            [data-bs-theme=dark] .accent-pink:hover {
                box-shadow: 0 15px 30px rgba(255, 35, 215, 0.8);
            }

            [data-bs-theme=dark] .accent-orange:hover {
                box-shadow: 0 15px 30px rgba(255, 134, 53, 0.4);
            }

            [data-bs-theme=dark] .accent-yellow:hover {
                box-shadow: 0 15px 30px rgba(255, 242, 53, 0.4);
            }

            [data-bs-theme=dark] .accent-brown:hover {
                box-shadow: 0 15px 30px rgba(255, 245, 105, 0.479);
            }

            [data-bs-theme=dark] .accent-green:hover {
                box-shadow: 0 15px 30px rgba(105, 255, 173, 0.479);
            }

            #particles-js {
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                background-color: transparent;
                z-index: 1;
            }

            .page-header {
                margin-bottom: 2rem;
                position: relative;
                z-index: 10;
            }

            .page-header h1 {
                font-size: 2.5rem;
                font-weight: 700;
                color: #000000;
                margin-bottom: 1rem;
            }

            [data-bs-theme=dark] .page-header h1 {
                color: #6d8cd9;
            }

            .page-header p {
                font-size: 1.2rem;
                color: #666;
                max-width: 600px;
                margin: 0 auto;
            }

            [data-bs-theme=dark] .page-header p {
                color: #aaa;
            }
        </style>
    @endpush
    <div id="particles-js"></div>
    <div class="wrapper">
        
        @php
            $user = auth()->user();
        @endphp
        <div class="mb-2">
            <h4 class="fw-bold text-primary mb-1">Welcome, {{ $user->name }}, <span class="text-secondary fw-semibold">
                    {{ $user?->currentOffice?->name ?? 'Currently no posting' }}</span> </h4>
            <div class="fw-bold d-flex flex-wrap align-items-center justify-content-center">
               <span class="badge bg-danger fs-6">Important Notice:</span> &nbsp; If you have no posting or office is incorrect, kindly place a transfer/posting request &nbsp;<span class="badge bg-primary cursor-pointer" id="place-request">here.</span> 
            </div>
        </div>
        <div class="page-header py-2 px-2 rounded shadow-sm border-top">
            <div>
                <h1 class="display-3 fw-bold text-dark mb-1">App Center</h1>
                <p class="fs-5 fw-bold text-secondary">At your fingertips; every app you need in one place.</p>
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
                    <i class="bi-globe" style="color: #8d0fe0"></i>
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
                    $user->can('viewVacancyReport', App\Models\User::class) ||
                    $user->can('viewEmployeeDirectoryReport', App\Models\User::class) ||
                    $user->can('viewOfficeStrengthReport', App\Models\User::class) ||
                    $user->can('viewPostingHistoryReport', App\Models\User::class) ||
                    $user->can('viewServiceLengthReport', App\Models\User::class) ||
                    $user->can('viewRetirementForecastReport', App\Models\User::class) ||
                    $user->can('viewOfficeStaffReport', App\Models\User::class) ||
                    $user->can('viewOrganogram', App\Models\office::class))
                <a href="{{ route('admin.apps.hr.index') }}" class="app-tile accent-green">
                    <i class="bi-people" style="color: #00db87"></i>
                    <p>User Mgt.</p>
                </a>
            @endif

            @if ($user->can('viewAny', App\Models\Vehicle::class) || $user->can('viewReports', App\Models\Vehicle::class))
                <a href="{{ route('admin.apps.vehicles.index') }}" class="app-tile accent-black">
                    <i class="bi-bus-front" style="color: #000000"></i>
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
                    <i class="bi-patch-check-fill" style="color: #1DA1F2"></i>
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
                    <i class="bi-person-vcard" style="color: #1cc7d0"></i>
                    <p>Contractors</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\Consultant::class) ||
                    $user->can('viewAny', App\Models\ConsultantHumanResource::class) ||
                    $user->can('viewAny', App\Models\ConsultantProject::class))
                <a href="{{ route('admin.apps.consultants.index') }}" class="app-tile accent-pink">
                    <i class="bi-person-lines-fill" style="color: #d01caf"></i>
                    <p>Consultants</p>
                </a>
            @endif

            @if ($user->can('viewAny', App\Models\ServiceCard::class) || $user->can('create', App\Models\ServiceCard::class))
                <a href="{{ route('admin.apps.service_cards.index') }}" class="app-tile accent-orange">
                    <i class="bi-credit-card" style="color: #f47721"></i>
                    <p>Service Card</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\ProvincialOwnReceipt::class) ||
                    $user->can('viewReports', App\Models\ProvincialOwnReceipt::class))
                <a href="{{ route('admin.apps.porms.index') }}" class="app-tile accent-yellow">
                    <i class="bi-coin" style="color: #ffe600"></i>
                    <p>PORMS</p>
                </a>
            @endif

            @if ($user->can('viewAny', App\Models\Machinery::class) || $user->can('viewReports', App\Models\Machinery::class))
                <a href="{{ route('admin.apps.machineries.index') }}" class="app-tile accent-brown">
                    <i class="bi-building-gear" style="color: #d5641c"></i>
                    <p>{{ setting('appName', 'machinery', 'Machnery Mgt.') }}</p>
                </a>
            @endif

            @if (
                $user->can('viewAny', App\Models\Damage::class) ||
                    $user->can('viewAny', App\Models\Infrastructure::class) ||
                    $user->can('viewMainReport', App\Models\Damage::class) ||
                    $user->can('viewDistrictWiseReport', App\Models\Damage::class))
                <a href="{{ route('admin.apps.dmis.index') }}" class="app-tile accent-red">
                    <i class="bi-cloud-drizzle" style="color: #ff0000"></i>
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
    <audio id="hoverSound" src="{{ asset('admin/click.wav') }}" preload="auto"></audio>

    @push('script')
        <script src="{{ asset('admin/plugins/particles.js/particles.min.js') }}"></script>

        <script>
            const appTiles = document.querySelectorAll('.app-tile');
            const hoverSound = document.getElementById('hoverSound');

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
                tile.addEventListener('mouseenter', () => {
                    hoverSound.currentTime = 0;
                    hoverSound.play();
                });
            });

            $('a.app-tile').on('click', () => {
                document.querySelector('.page-loader').classList.remove('hidden');
            });

            particlesJS("particles-js", {
                "particles": {
                    "number": {
                        "value": 100,
                        "density": {
                            "enable": true,
                            "value_area": 1000
                        }
                    },
                    "color": {
                        "value": "#000000"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        }
                    },
                    "opacity": {
                        "value": 0.6,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 5,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#000000",
                        "opacity": 0.5,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 3,
                        "direction": "none",
                        "random": false,
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
                            "mode": "repulse"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 400,
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
        </script>

        <script>
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
        </script>
    @endpush
</x-app-layout>
