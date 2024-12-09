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
                    <i class="bi-book" style="font-size: 1.2rem"></i>
                    <div class="menu-label" style="letter-spacing: 1px">STORIES</div>
                </button>

                <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#informationCanvas" aria-controls="informationCanvas">
                    <i class="bi-info-circle" style="font-size: 1.2rem"></i>
                    <div class="menu-label" style="letter-spacing: 1px">INFO</div>
                </button>

                <div class="offcanvas offcanvas-end" tabindex="-1" id="informationCanvas" aria-labelledby="informationCanvasLabel" style="z-index: 9999">
                    <div class="offcanvas-header border-bottom">
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="mb-4 mt-2 info-box">
                            <h4>Address</h4>
                            <i class="bi bi-geo-alt me-2"></i>{{ $settings->contact_address ?? 'Civil Secretariat, Peshawar'}}
                        </div>
                        <div class="mb-4 info-box">
                            <h4>Email</h4>
                            <a href="mailto:info@cwd.gkp.pk" class="text-decoration-none text-dark">
                                <i class="bi-envelope-fill"></i> &nbsp; {{ $settings->email ?? 'info@cwd.gkp.pk' }}
                            </a>
                        </div>
                        <div class="mb-4 info-box">
                            <h4>Contact Number</h4>
                            <a href="tel:+919210843" class="text-decoration-none text-dark">
                                <i class="bi-telephone-fill"></i> &nbsp; {{ $settings->contact_phone ?? '091-9214039' }}
                            </a>
                        </div>
                        <div class="mb-4 info-box">
                            <h4>Opening Hours</h4>
                            <div><i class="bi-calendar"></i> &nbsp; Monday - Friday</div>
                            <div><i class="bi-alarm"></i> &nbsp; 9:00 AM - 5:00 PM</div>
                        </div>
                        <div class="mb-4 info-box">
                            <h4>Follow Us</h4>
                            <div>
                                <a href="https://facebook.com/{{ $settings->facebook ?? 'CWDKPGovt'}}"><i class="bi bi-facebook fs-4 me-2"></i></a>
                                <a href="https://twitter.com/{{ $settings->twitter ?? 'CWDKPGovt'}}"><i class="bi bi-twitter-x fs-4 me-2"></i></a>
                                <a href="https://youtube.com/{{ $settings->youtube ?? 'CWDKPGovt'}}"><i class="bi bi-youtube fs-4 me-2"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="offcanvas offcanvas-top" tabindex="-1" id="storiesCanvas" aria-labelledby="storiesCanvasLabel" style="z-index: 9999">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="storiesCanvasLabel">Stories from Officers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex justify-content-center pt-2 d-none" id="stories-content">
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
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="1">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true" onclick="window.location.href = '{{ route('site') }}'">
                                <span>HOME</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="1" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle" onclick="window.location.href = '{{ route('site') }}'">
                                    HOME
                                </li>
                                <li role="none" data-tier-id="1">
                                    <a href="{{ route('pages.show', 'about_us') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="1" tabindex="0">ABOUT</a>
                                </li>
                                <li role="none" data-tier-id="1">
                                    <a href="{{ route('pages.show', 'introduction') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="1" tabindex="0">INTRODUCTION</a>
                                </li>
                                <li role="none" data-tier-id="1">
                                    <a href="{{ route('pages.show', 'vision') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="1" tabindex="0">VISION</a>
                                </li>
                                <li role="none" data-tier-id="1">
                                    <a href="{{ route('pages.show', 'functions') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="1" tabindex="0">FUNCTIONS</a>
                                </li>
                                <li role="none" data-tier-id="1">
                                    <a href="{{ route('pages.show', 'organogram') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">ORGANOGRAM</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="2">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>FUNDED PROJECTS</span>
                            </button>

                            <ul class="sub-nav" aria-label="Services" role="menu" data-tier-id="2" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    FUNDED PROJECTS
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('projects.show', 'KITE') }}" role="menuitem" class="cw-menuItem" tabindex="0">KP KITE</a>
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('projects.show', 'KP-PRIP') }}" role="menuitem" class="cw-menuItem" tabindex="0">KP PRIP</a>
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('projects.show', 'KP-RIISP') }}" role="menuitem" class="cw-menuItem" tabindex="0">KP RIISP</a>
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('projects.show', 'KP-RAP') }}" role="menuitem" class="cw-menuItem" tabindex="0">KP RAP</a>
                                </li>
                                <li role="none" data-tier-id="2">
                                    <a href="{{ route('projects.show', 'PaRSA') }}" role="menuitem" class="cw-menuItem" tabindex="0">KP PaRSA</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="3">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>PROJECTS</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="3" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    PROJECTS
                                </li>
                                <li role="none" data-tier-id="3">
                                    <a href="{{ route('development_projects.index', ['status' => 'In-Progress']) }}" role="menuitem" class="cw-menuItem" tabindex="0">IN PROGRESS</a>
                                </li>
                                <li role="none" data-tier-id="3">
                                    <a href="{{ route('development_projects.index', ['status' => 'On-Hold']) }}" role="menuitem" class="cw-menuItem" tabindex="0">ON HOLD</a>
                                </li>
                                <li role="none" data-tier-id="3">
                                    <a href="{{ route('development_projects.index', ['status' => 'Completed']) }}" role="menuitem" class="cw-menuItem" tabindex="0">COMPLETED</a>
                                </li>
                                <li role="none" data-tier-id="3">
                                    <a href="{{ route('development_projects.index') }}" role="menuitem" class="cw-menuItem" tabindex="0">All PROJECTS</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu child-nav" data-tier-id="4">
                            <button role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>UPDATES</span>
                            </button>

                            <ul class="sub-nav" aria-label="Support" role="menu" data-tier-id="4" aria-orientation="vertical">
                                <li role="none" class="cw-back-list-item">
                                    <button role="menuitem" class="cw-back-button" tabindex="0">
                                        <span class="cw-menu-chevron left chevron-right"></span>
                                        <span class="cw-back-button-label">Back </span>
                                    </button>
                                </li>
                                <li role="menuitem" class="cw-hide-mob-links cw-plateTitle">
                                    UPDATES
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a href="{{ route('news.index') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">NEWS</a>
                                </li>
                                <li role="none" data-tier-id="4">
                                    <a href="{{ route('events.index') }}" role="menuitem" class="cw-menuItem" href="#" data-tier-id="4" tabindex="0">EVENTS</a>
                                </li>
                            </ul>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('downloads.index') ? 'uActived' : '' }}" data-tier-id="5">
                            <a href="{{ route('downloads.index') }}" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>DOWNLOADS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('seniority.index') ? 'uActived' : '' }}" data-tier-id="6">
                            <a href="{{ route('seniority.index') }}" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>SENIORITY</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('gallery.index') ? 'uActived' : '' }}" data-tier-id="7">
                            <a href="{{ route('gallery.index') }}" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>GALLERY</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('team') ? 'uActived' : '' }}" data-tier-id="8">
                            <a href="{{ route('team') }}" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>TEAM</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('pages.show', 'achievements') ? 'uActived' : '' }}" data-tier-id="9">
                            <a href="{{ route('pages.show', 'achievements') }}" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>ACHIEVEMENTS</span>
                            </a>
                        </li>
                        <li role="none" class="cw-top-menu {{ request()->routeIs('contacts.index') ? 'uActived' : '' }}" data-tier-id="9">
                            <a href="{{ route('contacts.index') }}" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>CONTACTS</span>
                            </a>
                        </li>
                        <li role="menuitem" aria-hidden="true" class="divider cw-onlyMobileTab"></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    @if (session('success'))
    <div class="container d-flex justify-content-center pt-2 bg-light">
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    </div>
    @endif
</header>

<div id="modal-container"></div>

<script>
    (function () {
        const leftColumn = document.querySelector(".left-column");
        const informationCanvas = document.querySelector("#informationCanvas .offcanvas-header");

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
                if (informationCanvas && searchElement.parentElement !== informationCanvas) {
                    informationCanvas.insertBefore(searchElement, informationCanvas.firstChild);
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


    function loadZuckLibraries(callback) {
        if (!document.getElementById('zuck-css')) {
            let cssLink = document.createElement('link');
            cssLink.id = 'zuck-css';
            cssLink.rel = 'stylesheet';
            cssLink.href = "{{ asset('site/lib/zuck/css/zuck.min.css') }}";
            document.head.appendChild(cssLink);
        }

        if (!document.getElementById('zuck-js')) {
            let scriptTag = document.createElement('script');
            scriptTag.id = 'zuck-js';
            scriptTag.src = "{{ asset('site/lib/zuck/js/zuck.min.js') }}";
            scriptTag.onload = callback;
            document.body.appendChild(scriptTag);
        } else {
            callback();
        }
    }
    document.querySelector('#view-stories').addEventListener('click', function() {
        let storiesContent = document.querySelector('#stories-content');
        let spinner = document.querySelector('#stories-spinner');
        let errorMessage = "<div class='alert alert-warning' role='alert' style='margin-bottom:0px'>There are currently no stories</div>";

        loadZuckLibraries(function() {
            storiesContent.classList.toggle('d-none');

            let contentSeenItems = localStorage.getItem('zuck-stories-content-seenItems');
            contentSeenItems = contentSeenItems ? JSON.parse(contentSeenItems) : {};

            let seenUserIds = Object.keys(contentSeenItems);

            fetch("{{ route('stories.get') }}", {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                    , body: JSON.stringify({
                        seenUserIds: seenUserIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    spinner.classList.remove('show');
                    if (data.success) {
                        let storiesData = data.data.result;

                        if (data.expiredUsers && data.expiredUsers.length > 0) {
                            data.expiredUsers.forEach(userId => {
                                delete contentSeenItems[userId];
                            });
                            localStorage.setItem('zuck-stories-content-seenItems', JSON.stringify(contentSeenItems));
                        }

                        storiesContent.innerHTML = '';

                        let unviewedSeenItems = localStorage.getItem('zuck-unviewed-stories-seenItems');
                        contentSeenItems = localStorage.getItem('zuck-stories-content-seenItems');

                        unviewedSeenItems = unviewedSeenItems ? JSON.parse(unviewedSeenItems) : {};
                        contentSeenItems = contentSeenItems ? JSON.parse(contentSeenItems) : {};

                        storiesData.sort((a, b) => {
                            let aViewed = unviewedSeenItems[a.id] || contentSeenItems[a.id] || false;
                            let bViewed = unviewedSeenItems[b.id] || contentSeenItems[b.id] || false;

                            if (aViewed && !bViewed) return 1;
                            if (!aViewed && bViewed) return -1;
                            return 0;
                        });

                        new Zuck(storiesContent, {
                            backNative: true
                            , autoFullScreen: false
                            , skin: 'snapgram'
                            , avatars: true
                            , list: false
                            , cubeEffect: true
                            , localStorage: true
                            , reactive: false
                            , stories: storiesData
                            , callbacks: {
                                onView: function(storyId, callback) {
                                    incrementViewCount(storyId);
                                    if (typeof callback === 'function') {
                                        callback();
                                    }
                                }
                                , onClose: function(storyId, callback) {
                                    callback();
                                }
                                , onOpen: function(storyId, callback) {
                                    callback();
                                }
                                , onNextItem: function(storyId, currentItem, callback) {
                                    callback();
                                }
                                , onEnd: function(storyId, callback) {
                                    callback();
                                }
                                , onNavigateItem: function(storyId, direction, callback) {
                                    callback();
                                }
                                , onDataUpdate: function(storyId, callback) {
                                    callback();
                                }
                            }
                        });

                        function incrementViewCount(storyId) {
                            const url = "{{ route('stories.viewed', ':id') }}".replace(':id', storyId);
                            fetch(url, {
                                    method: 'PATCH'
                                    , headers: {
                                        'Content-Type': 'application/json'
                                        , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    console.log('View count incremented:', data);
                                })
                                .catch(error => {
                                    console.error('Error incrementing view count:', error);
                                });
                        }

                    } else {
                        storiesContent.innerHTML = errorMessage;
                    }
                })
                .catch(error => {
                    spinner.classList.remove('show');
                    storiesContent.innerHTML = errorMessage;
                });
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const modalContainer = document.getElementById('modal-container');
        const announcementSeen = sessionStorage.getItem('announcement_seen');
        const newsSeen = sessionStorage.getItem('news_seen');

        fetch('/fetch-popups')
            .then(response => response.json())
            .then(data => {
                const {
                    announcement
                    , news
                } = data;

                if (announcement && !announcementSeen) {
                    modalContainer.innerHTML += `
                        <div id="announcement-modal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">${announcement.title}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <a href="{{ route('pages.show', 'Announcement') }}"><img src="${announcement.image}" style="width:100%" /></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    sessionStorage.setItem('announcement_seen', true);
                    const announcementModal = new bootstrap.Modal(document.getElementById('announcement-modal'));
                    announcementModal.show();
                }

                if (news.length && !newsSeen) {
                    const newsList = news.map(item => `
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="${item.image}" alt="${item.title}" class="img-thumbnail news-image" />
                            <a href="${item.url}" class="news-title ms-3">
                                <strong>${item.title}</strong>
                            </a>
                        </div>
                        <small class="news-date">${item.created_at}</small>
                    </li>
                `).join('');

                    modalContainer.innerHTML += `
                        <div id="news-modal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Latest News</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group">${newsList}</ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    sessionStorage.setItem('news_seen', true);
                    const newsModal = new bootstrap.Modal(document.getElementById('news-modal'));
                    newsModal.show();
                }
            })
            .catch(error => console.error('Error fetching modals:', error));
    });

</script>
