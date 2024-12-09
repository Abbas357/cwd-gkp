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

                <div class="cw-search cw-search-temp-wrapper cw-mobile-search" role="search">
                    <div class="cw-input-container">
                        <input id="cw-search-input" type="search" class="cw-search-input" aria-label="AI Search..." placeholder="AI Search..." tabindex="0" autocomplete="off" />
                        <div class="input-loading"></div>
                        <button class="cw-search-btn cw-search-cancel" tabindex="0" aria-label="Cancel Search">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        <button class="cw-search-btn cw-search-submit" tabindex="0" aria-label="Search...">
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
                </div>
            </div>
            <div class="right-column">
                <div class="d-none d-xl-block cw-info">
                    <a href="mailto:info@cwd.gkp.pk"><i class="bi-envelope"></i> &nbsp; {{ $settings->email ?? 'info@cwd.gkp.pk'}}</a>
                    <a href="tel:+919210843"><i class="bi-telephone"></i> &nbsp; {{ $settings->contact_phone ?? '091-9214039'}}</a>
                </div>
                <button id="story-btn-sm" class="btn cw-onlyMobileTab">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.9898 22.55C9.9398 22.55 9.8898 22.55 9.8398 22.53C6.0098 21.75 2.8998 18.93 1.7398 15.19C1.6198 14.79 1.8398 14.37 2.2298 14.25C2.6298 14.13 3.0498 14.35 3.1698 14.74C4.1698 17.96 6.8398 20.38 10.1398 21.05C10.5498 21.13 10.8098 21.53 10.7198 21.94C10.6498 22.3 10.3298 22.55 9.9898 22.55Z" fill="currentColor" />
                        <path d="M21.9502 11.73C21.5702 11.73 21.2402 11.44 21.2002 11.06C20.7202 6.32 16.7602 2.75 12.0002 2.75C7.23022 2.75 3.28022 6.32 2.80022 11.05C2.76022 11.46 2.40022 11.77 1.98022 11.72C1.57022 11.68 1.27022 11.31 1.31022 10.9C1.87022 5.4 6.47022 1.25 12.0002 1.25C17.5402 1.25 22.1402 5.4 22.6902 10.9C22.7302 11.31 22.4302 11.68 22.0202 11.72C22.0002 11.73 21.9702 11.73 21.9502 11.73Z" fill="currentColor" />
                        <path d="M14.0101 22.55C13.6601 22.55 13.3501 22.31 13.2801 21.95C13.2001 21.54 13.4601 21.15 13.8601 21.07C17.1401 20.4 19.8101 18 20.8201 14.8C20.9401 14.4 21.3701 14.18 21.7601 14.31C22.1601 14.43 22.3701 14.86 22.2501 15.25C21.0701 18.97 17.9701 21.76 14.1601 22.54C14.1101 22.54 14.0601 22.55 14.0101 22.55Z" fill="currentColor" /></svg>
                    <div class="menu-label" style="margin-top:2.5px">STORIES</div>
                </button>
                <div class="searchIcon">
                    <button class="btn cw-search-btn cw-search-submit" tabindex="0" aria-label="Search...">
                        <i class="bi-search"></i>
                        <span class="menu-label">SEARCH</span>
                    </button>
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
                        <li role="none" class="cw-top-menu {{ request()->routeIs('contacts.index') ? 'uActived' : '' }}" data-tier-id="9">
                            <a href="{{ route('contacts.index') }}" role="menuitem" class="cw-top-nav-button first-level" aria-expanded="false" aria-haspopup="true">
                                <span>CONTACTS</span>
                            </a>
                        </li>
                        <li role="menuitem" aria-hidden="true" class="divider cw-onlyMobileTab"></li>
                    </ul>
                </nav>
                <button id="story-btn-lg" class="cw-top-nav-button d-none d-md-inline-block" style="padding: 9px; border: none;position: absolute; bottom: 2px; right:0px; border-radius: 50px">
                    STORIES &nbsp;
                    <i class="bi-caret-down-fill mt-1"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="stories-content" class="container d-flex justify-content-center bg-light pt-2 d-none">
        <div id="stories-spinner" class="show bg-white d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
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
    document.querySelectorAll('#story-btn-lg, #story-btn-sm').forEach(button => {
        button.addEventListener('click', function() {
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
