<x-app-layout title="Dashboard" :showAside="false" id="particles-js">
    @push('style')
    <style>
        .wrapper {
            margin: 0 auto;
            max-width: 900px;
            width: 100%;
            text-align: center
        }

        #searchBar {
            width: 80%;
            padding: .7rem 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #ccc;
            border-radius: 50px;
            font-size: 1em;
            position: relative;
            z-index: 1;
        }

        .app-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 20px;
            align-items: center;
        }

        .app-tile {
            background-color: #f1f1f1;
            padding: .7rem 0;
            border-radius: .9rem;
            box-shadow:  5px 5px 3px rgba(0, 0, 0, 0.2);
            text-align: center;
            cursor: pointer;
            position: relative;
            z-index: 1;
            transition: all .1s ease-in-out;
            border: 1px solid #ccc;
        }

        [data-bs-theme=dark] .app-tile {
            box-shadow:  5px 5px 5px rgba(255, 255, 255, 0.1);
            background-color: #333;
            border: 1px solid #000;
        }

        .app-tile:hover {
            box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.3), 5px 5px 10px inset rgba(0, 0, 0, 0.1);
        }

        [data-bs-theme=dark] .app-tile:hover {
            box-shadow: 5px 5px 15px inset rgba(255, 255, 255, 0.1);
        }

        .app-tile p {
            font-size: 1em;
            color: #333;
            margin-bottom: 0px
        }

        [data-bs-theme=dark] .app-tile p {
            color: #ddd;
        }

        .app-tile:hover i {
            opacity: 1;
        }
        .app-tile i {
            font-size: 2.5rem;
            opacity: .7;
        }

        #particles-js {
            position: absolute;
            width: 90%;
            height: 88%;
            background-color: transparent;
            background-image: url("");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 50% 50%;
        }

    </style>
    @endpush
    <div id="particles-js"></div>
    <div class="wrapper">
        <input type="text" id="searchBar" placeholder="Search apps by name..." oninput="filterApps()">
        <div class="app-grid" id="appGrid">
            @can('view any user')
            <a href="{{ route('admin.users.index') }}" class="app-tile">
                <i class="bi bi-person-circle" style="color: #8d0fe0"></i>
                <p>Users</p>
            </a>
            @endcan

            @can('view any tender')
            <a href="{{ route('admin.tenders.index') }}" class="app-tile">
                <i class="bi bi-briefcase" style="color: #ff000d"></i>
                <p>Tenders</p>
            </a>
            @endcan

            @can('view any event')
            <a href="{{ route('admin.events.index') }}" class="app-tile">
                <i class="bi bi-calendar2-event" style="color: #96bb05"></i>
                <p>Events</p>
            </a>
            @endcan

            @can('view any news')
            <a href="{{ route('admin.news.index') }}" class="app-tile">
                <i class="bi bi-journal" style="color: #1cc7d0"></i>
                <p>News</p>
            </a>
            @endcan

            @can('view any slider')
            <a href="{{ route('admin.sliders.index') }}" class="app-tile">
                <i class="bi bi-images" style="color: #146eb4"></i>
                <p>Slider</p>
            </a>
            @endcan

            @can('create download')
            <a href="{{ route('admin.downloads.index') }}" class="app-tile">
                <i class="bi bi-download" style="color: #fb8a2e"></i>
                <p>Downloads</p>
            </a>
            @endcan

            @can('view any gallery')
            <a href="{{ route('admin.gallery.index') }}" class="app-tile">
                <i class="bi bi-card-image" style="color: #11862f"></i>
                <p>Gallery</p>
            </a>
            @endcan

            @can('view any contractor')
            <a href="{{ route('admin.contractors.index') }}" class="app-tile">
                <i class="bi bi-clipboard" style="color: #00a4e4"></i>
                <p>Registration</p>
            </a>
            @endcan

            @can('view any standardization')
            <a href="{{ route('admin.standardizations.index') }}" class="app-tile">
                <i class="bi bi-shield-lock" style="color: #49c0b6"></i>
                <p>Standardization</p>
            </a>
            @endcan

            @can('view any service card')
            <a href="{{ route('admin.service_cards.index') }}" class="app-tile">
                <i class="bi bi-credit-card" style="color: #a4c649"></i>
                <p>Service Card</p>
            </a>
            @endcan

            @can('view any page')
            <a href="{{ route('admin.pages.index') }}" class="app-tile">
                <i class="bi bi-file-earmark-post" style="color: #ffc168"></i>
                <p>Pages</p>
            </a>
            @endcan

            @can('view any story')
            <a href="{{ route('admin.stories.index') }}" class="app-tile">
                <i class="bi bi-app" style="color: #0389ff"></i>
                <p>Stories</p>
            </a>
            @endcan

            @can('view any project')
            <a href="{{ route('admin.projects.index') }}" class="app-tile">
                <i class="bi bi-kanban" style="color: #a71930"></i>
                <p>Projects</p>
            </a>
            @endcan

            @can('view project file')
            <a href="{{ route('admin.project_files.index') }}" class="app-tile">
                <i class="bi bi-file" style="color: #5ecc62"></i>
                <p>Project Files</p>
            </a>
            @endcan

            @can('view any newsletter')
            <a href="{{ route('admin.newsletter.index') }}" class="app-tile">
                <i class="bi bi-envelope" style="color: #505050"></i>
                <p>Newsletter</p>
            </a>
            @endcan

            @can('view any public contact')
            <a href="{{ route('admin.public_contact.index') }}" class="app-tile">
                <i class="bi bi-chat-left" style="color: #00aee6"></i>
                <p>Public Queries</p>
            </a>
            @endcan

            {{-- Settings is typically for admins only --}}
            @can('view any user')
            <a href="{{ route('admin.settings.index') }}" class="app-tile">
                <i class="bi bi-gear" style="color: #f1632a"></i>
                <p>Settings</p>
            </a>
            @endcan

            {{-- Logs are typically for admins only --}}
            @can('view any user')
            <a href="{{ route('admin.logs') }}" class="app-tile">
                <i class="bi bi-activity" style="color: #ce1126"></i>
                <p>Activity Log</p>
            </a>
            @endcan

            @can('view any seniority')
            <a href="{{ route('admin.seniority.index') }}" class="app-tile">
                <i class="bi bi-graph-up-arrow" style="color: #790bdf"></i>
                <p>Seniority List</p>
            </a>
            @endcan

            @can('create development project')
            <a href="{{ route('admin.development_projects.index') }}" class="app-tile">
                <i class="bi bi-buildings" style="color: #0096a0"></i>
                <p>Dev. Projects</p>
            </a>
            @endcan

            @can('update comment')
            <a href="{{ route('admin.comments.index') }}" class="app-tile">
                <i class="bi bi-chat" style="color: #000000"></i>
                <p>Comments</p>
            </a>
            @endcan

            @can('view any project')
            <a href="{{ route('admin.schemes.index') }}" class="app-tile">
                <i class="bi bi-building" style="color: #028be1"></i>
                <p>Schemes</p>
            </a>
            @endcan

            @can('view any achievement')
            <a href="{{ route('admin.achievements.index') }}" class="app-tile">
                <i class="bi bi-award" style="color: #2ef782"></i>
                <p>Achievements</p>
            </a>
            @endcan
        </div>
    </div>
    <audio id="hoverSound" src="{{ asset('admin/click.wav') }}" preload="auto"></audio>

    @push('script')

    <script src="{{ asset('admin/plugins/particles.js/particles.min.js') }}"></script>

    <script>
        

        const appTiles = document.querySelectorAll('.app-tile');
        const hoverSound = document.getElementById('hoverSound');

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
                    "value": 80
                    , "density": {
                        "enable": true
                        , "value_area": 800
                    }
                }
                , "color": {
                    "value": "#3b5998"
                }
                , "shape": {
                    "type": "circle"
                    , "stroke": {
                        "width": 0
                        , "color": "#3b5998"
                    }
                    , "polygon": {
                        "nb_sides": 5
                    }
                    , "image": {
                        "src": "img/github.svg"
                        , "width": 100
                        , "height": 100
                    }
                }
                , "opacity": {
                    "value": 0.5
                    , "random": false
                    , "anim": {
                        "enable": false
                        , "speed": 1
                        , "opacity_min": 0.1
                        , "sync": false
                    }
                }
                , "size": {
                    "value": 3
                    , "random": true
                    , "anim": {
                        "enable": false
                        , "speed": 40
                        , "size_min": 0.1
                        , "sync": false
                    }
                }
                , "line_linked": {
                    "enable": true
                    , "distance": 150
                    , "color": "#3b5998"
                    , "opacity": 0.4
                    , "width": 1
                }
                , "move": {
                    "enable": true
                    , "speed": 6
                    , "direction": "none"
                    , "random": false
                    , "straight": false
                    , "out_mode": "out"
                    , "bounce": false
                    , "attract": {
                        "enable": false
                        , "rotateX": 600
                        , "rotateY": 1200
                    }
                }
            }
            , "interactivity": {
                "detect_on": "canvas"
                , "events": {
                    "onhover": {
                        "enable": true
                        , "mode": "repulse"
                    }
                    , "onclick": {
                        "enable": true
                        , "mode": "push"
                    }
                    , "resize": true
                }
                , "modes": {
                    "grab": {
                        "distance": 400
                        , "line_linked": {
                            "opacity": 1
                        }
                    }
                    , "bubble": {
                        "distance": 400
                        , "size": 40
                        , "duration": 2
                        , "opacity": 8
                        , "speed": 3
                    }
                    , "repulse": {
                        "distance": 200
                        , "duration": 0.4
                    }
                    , "push": {
                        "particles_nb": 4
                    }
                    , "remove": {
                        "particles_nb": 2
                    }
                }
            }
            , "retina_detect": true
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
