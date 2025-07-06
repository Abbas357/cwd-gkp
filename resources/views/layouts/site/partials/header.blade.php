<header id="integrated-plate" class="CWD">
    <div class="cw-top">
        <div class="cw-top-wrapper">
            <div class="left-column">
                <button class="cw-mobile-nav-toggle" tabindex="0" data-navigation-aria-label-text="Navigation" data-navigation-close-aria-label-text="Close" aria-label="Navigation">
                    <span class="cw-nav-menu-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                @include("layouts.site.partials.logo")
            </div>
            <div class="right-column">
                <button class="btn" data-bs-toggle="offcanvas" id="view-stories" data-bs-target="#storiesCanvas" aria-controls="storiesCanvas">
                    <i class="bi-book-half text-secondary" style="font-size: 1.2rem"></i>
                    <div class="menu-label" style="letter-spacing: 1px">STORIES</div>
                </button>

                <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#themeCanvas" aria-controls="themeCanvas">
                    <i class="bi-palette-fill rotate-color-icon" style="font-size: 1.2rem;"></i>
                    <div class="menu-label" style="letter-spacing: 1px">THEME</div>
                </button>

                <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#tutorialsCanvas" aria-controls="tutorialsCanvas">
                    <i class="bi-play-circle circular-icon" style="font-size: 1.2rem"></i>
                    <div class="menu-label" style="letter-spacing: 1px">LEARN</div>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="tutorialsCanvas" aria-labelledby="tutorialsCanvasLabel" style="z-index: 9999">
                    <div class="offcanvas-header border-bottom">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body p-3">
                        <div class="course-grid">
                            
                            <a href="{{ route('learn.epads') }}" target="_blank" class="course-card">
                                <img src="{{ asset('site/images/icons/learn/epads.png') }}" alt="e-PADS Training" class="course-image">
                                <h6 class="course-title">e-PADS</h6>
                            </a>

                            <a href="{{ route('learn.kpdws') }}" target="_blank" class="course-card">
                                <img src="{{ asset('site/images/icons/learn/kpdws.png') }}" alt="User Manual" class="course-image">
                                <h6 class="course-title">KP Digital Workspace</h6>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="offcanvas offcanvas-top" tabindex="-1" id="storiesCanvas" aria-labelledby="storiesCanvasLabel" style="z-index: 9999; --bs-offcanvas-height: fit-content;">
                    <div class="offcanvas-header" style="background: #f5f5f5">
                        <h5 class="offcanvas-title" id="storiesCanvasLabel">Stories</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex justify-content-center pt-2 d-none" id="stories-content" style="flex-grow: 0">
                        <div id="stories-spinner" class="show bg-white d-flex align-items-center justify-content-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="cw-bottom">
        <div class="cw-bottom-wrapper">
            <div class="popoverOverlay"></div>
            <div id="integrated-plate-navigation" class="cw-nav" component="integrated-plate-navigation">
                <nav class="cw-top-nav">
                    <ul role="menu" class="cw-top-menu-nav aria-nav">
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="0">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true" onclick="window.location.href = '{{ route('site') }}'">
                                <span>HOME</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="0" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle" onclick="window.location.href = '{{ route('site') }}'">
                                    HOME
                                </li>
                                <li role="none" data-tier-id="0">
                                    <a href="{{ route('pages.show', 'about_us') }}" data-tier-id="0" role="menuitem" class="cw-menuItem" href="#" tabindex="0">ABOUT</a>
                                </li>
                                <li role="none" data-tier-id="0">
                                    <a href="{{ route('pages.show', 'introduction') }}" data-tier-id="0" role="menuitem" class="cw-menuItem" href="#" tabindex="0">INTRODUCTION</a>
                                </li>
                                <li role="none" data-tier-id="0">
                                    <a href="{{ route('pages.show', 'vision') }}" data-tier-id="0" role="menuitem" class="cw-menuItem" href="#" tabindex="0">VISION</a>
                                </li>
                                <li role="none" data-tier-id="0">
                                    <a href="{{ route('pages.show', 'functions') }}" data-tier-id="0" role="menuitem" class="cw-menuItem" href="#" tabindex="0">FUNCTIONS</a>
                                </li>
                                <li role="none" data-tier-id="0">
                                    <a href="{{ route('pages.show', 'organogram') }}" data-tier-id="0" role="menuitem" class="cw-menuItem" href="#" tabindex="0">ORGANOGRAM</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="1">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>PROJECTS</span>
                            </button>
                            <ul class="sub-nav" role="menu" data-tier-id="1" aria-label="Professional Services" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    PROJECTS
                                </li>
                                <li role="none" class="child-nav" data-tier-id="1">
                                    <button role="menuitem" class="cw-menuItem" data-tier-id="1" tabindex="0" aria-expanded="false" aria-haspopup="true">
                                        FOREIGN FUNDED
                                    </button>
                                    <ul class="sub-nav" role="menu" data-tier-id="1" aria-label="Professional Services" aria-orientation="vertical">
                                        <li role="none" class="cw-back-list-item">
                                            <button role="menuitem" class="cw-back-button" tabindex="0">
                                                <span class="cw-menu-chevron left chevron-right"></span>
                                                <span class="cw-back-button-label">Back
                                                </span>
                                            </button>
                                        </li>
                                        <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                            FOREIGN FUNDED
                                        </li>
                                        <li role="none" data-tier-id="1">
                                            <a href="{{ route('projects.show', 'KITE') }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">KP KITE</a>
                                        </li>
                                        <li role="none" data-tier-id="1">
                                            <a href="{{ route('projects.show', 'KP-PRIP') }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">KP PRIP</a>
                                        </li>
                                        <li role="none" data-ti er-id="1">
                                            <a href="{{ route('projects.show', 'KP-RIISP') }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">KP RIISP</a>
                                        </li>
                                        <li role="none" data-tier-id="1">
                                            <a href="{{ route('projects.show', 'KP-RAP') }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">KP RAP</a>
                                        </li>
                                        <li role="none" data-tier-id="1">
                                            <a href="{{ route('projects.show', 'PaRSA') }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">KP PaRSA</a>
                                        </li>
                                    </ul>
                                </li>
                                <li role="none" class="child-nav" data-tier-id="1">
                                    <button role="menuitem" class="cw-menuItem" data-tier-id="1" tabindex="0" aria-expanded="false" aria-haspopup="true">
                                        ADP (LAST 5 YEARS)
                                    </button>
                                    <ul class="sub-nav" role="menu" data-tier-id="1" aria-label="Professional Services" aria-orientation="vertical">
                                        <li role="none" class="cw-back-list-item">
                                            <button role="menuitem" class="cw-back-button" tabindex="0">
                                                <span class="cw-menu-chevron left chevron-right"></span>
                                                <span class="cw-back-button-label">Back
                                                </span>
                                            </button>
                                        </li>
                                        <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                            DEVELOPMENTAL
                                        </li>
                                        <li role="none" data-tier-id="1">
                                            <a href="{{ route('development_projects.index', ['status' => 'In-Progress']) }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">IN PROGRESS</a>
                                        </li>
                                        <li role="none" data-tier-id="1">
                                            <a href="{{ route('development_projects.index', ['status' => 'Completed']) }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">COMPLETED</a>
                                        </li>
                                        <li role="none" data-tier-id="1">
                                            <a href="{{ route('development_projects.index') }}" data-tier-id="1" role="menuitem" class="cw-menuItem" tabindex="0">All PROJECTS</a>
                                        </li>
                                    </ul>
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('development_projects.index') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="2" tabindex="0">PSDP</a>
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('schemes.index') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="2" tabindex="0">SCHEMES</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="21">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>SERVICES</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="21" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    SERVICES
                                </li>
                                <li role="none" data-tier-id="21">
                                    <a href="{{ route('pages.show', 'E-Standardization') }}" data-tier-id="21" role="menuitem" class="cw-menuItem" href="#" tabindex="0">E-Standardization</a>
                                </li>
                                <li role="none" data-tier-id="21">
                                    <a href="{{ route('pages.show', 'E-Registration') }}" data-tier-id="21" role="menuitem" class="cw-menuItem" href="#" tabindex="0">E-Registration</a>
                                </li>
                                <li role="none" data-tier-id="21">
                                    <a href="{{ route('pages.show', 'NOC for Pumps') }}" data-tier-id="21" role="menuitem" class="cw-menuItem" href="#" tabindex="0">NOC FOR PUMPS</a>
                                </li>
                                <li role="none" data-tier-id="21">
                                    <a href="{{ route('pages.show', 'procurement') }}" data-tier-id="21" role="menuitem" class="cw-menuItem" href="#" tabindex="0">Procurement</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="2">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>MEDIA</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="2" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    MEDIA
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('gallery.index') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="2" tabindex="0">GALLERY</a>
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('events.index') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="2" tabindex="0">EVENTS</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('tenders.index') ? 'uActived' : '' }}" data-tier-id="31">
                            <a href="{{ route('news.index') }}" data-tier-id="31" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>NEWS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('tenders.index') ? 'uActived' : '' }}" data-tier-id="3">
                            <a href="{{ route('tenders.index') }}" data-tier-id="3" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>TENDERS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('downloads.index') ? 'uActived' : '' }}" data-tier-id="3">
                            <a href="{{ route('downloads.index') }}" data-tier-id="3" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>DOWNLOADS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('seniority.index') ? 'uActived' : '' }}" data-tier-id="4">
                            <a href="{{ route('seniority.index') }}" data-tier-id="4" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>SENIORITY</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('team') ? 'uActived' : '' }}" data-tier-id="6">
                            <a href="{{ route('team') }}" data-tier-id="6" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>TEAM</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('contacts.index') ? 'uActived' : '' }}" data-tier-id="7">
                            <a href="{{ route('contacts.index') }}" data-tier-id="7" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>CONTACTS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="8">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>MORE</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="8" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    MORE
                                </li>
                                <li role="none" data-tier-id="8">
                                    <a href="{{ route('achievements.index') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="8" tabindex="0">ACHIEVEMENTS</a>
                                </li>
                                <li role="none" data-tier-id="8">
                                    <a href="{{ route('pages.show', 'contingency_plan') }}" role="menuitem" class="cw-menuItem" data-tier-id="8" tabindex="0">CONTIGENCY PLAN</a>
                                </li>
                                <li role="none" data-tier-id="8">
                                    <a href="{{ route(setting('activity', 'dmis') . '.index') }}" role="menuitem" class="cw-menuItem" data-tier-id="8" tabindex="0">{{ setting('activity', 'dmis') . ' ' . setting('session','dmis') }}</a>
                                </li>
                            </ul>
                        </li>
                        <li role="menuitem" aria-hidden="true" class="divider cw-onlyMobileTab"></li>
                        <button class="cw-top-nav-button" style="margin-top: 3px;padding: 7px; border: none; border-radius: 50px">
                            <a href="https://old.cwd.gkp.pk" target="_blank"><span class="animated-gradient-text">LEGACY</span></a>
                        </button>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>

<script>
    (function() {
        const leftColumn = document.querySelector(".left-column");
        const tutorialsCanvas = document.querySelector("#tutorialsCanvas .offcanvas-header");

        const searchElement = document.createElement("div");
        searchElement.className = "cw-search cw-search-temp-wrapper";
        searchElement.setAttribute("role", "search");
        searchElement.innerHTML = `
        <div class="cw-input-container">
            <input id="cw-search-input" type="search" class="cw-search-input" aria-label="AI Search..." placeholder="AI Search..." tabindex="0" autocomplete="off" />
            <div class="input-loading"></div>
            <button class="cw-search-btn cw-search-cancel" tabindex="0" aria-label="Cancel Search">
                <i class="bi bi-x-circle"></i>
            </button>
            <button class="cw-search-btn cw-search-submit d-none d-lg-block" tabindex="0" aria-label="Search...">
                <i class="bi bi-search d-none d-sm-block"></i>
            </button>
        </div>
        <div class="cw-suggesstion">
            <div class="widget">
                <header class="widget__header">
                    <h1 id="wait">Please wait <span class="dots">...</span></h1>
                </header>
                <div class="widget__body">
                    <div class="list-component list-loader"></div>
                </div>
            </div>
            <div id="content"></div>
        </div>
    `;

        function insertSearchElement() {
            if (window.innerWidth < 768) {
                if (tutorialsCanvas && searchElement.parentElement !== tutorialsCanvas) {
                    tutorialsCanvas.insertBefore(searchElement, tutorialsCanvas.firstChild);
                }
            } else {
                if (leftColumn && searchElement.parentElement !== leftColumn) {
                    leftColumn.appendChild(searchElement);
                }
            }
        }
        insertSearchElement();
        window.addEventListener("resize", insertSearchElement);
    })();

</script>
