<!-- Footer Start -->
<img src="{{ asset('site/images/footer-bg.jpg') }}" style="height:100px;width:100%; opacity: 0.3; border-top-left-radius: 1.5rem; border-top-right-radius: 1.5rem; box-shadow: 0 0 1rem #00000011; border-top: 1px solid #ccc; margin-top:1rem" alt="CWD">

<div class="container-fluid footer py-2">
    <div class="container py-3">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-3">
                <h4 class="mb-4 text-white">About Us</h4>
                <p class="text-white">
                    {{ $settings->description ?? 'Communication & Works Department, Government of Khyber Pakhtunkhwa.'}}
                </p>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Department</h4>
                    <a href="{{ route('pages.show', 'about') }}"><i class="bi bi-arrow-right-short me-2"></i> About</a>
                    <a href="{{ route('pages.show', 'introduction') }}"><i class="bi bi-arrow-right-short me-2"></i> Introduction</a>
                    <a href="{{ route('pages.show', 'vision') }}"><i class="bi bi-arrow-right-short me-2"></i> Vision</a>
                    <a href="{{ route('pages.show', 'functions') }}"><i class="bi bi-arrow-right-short me-2"></i> Functions</a>
                    <a href="#"><i class="bi bi-arrow-right-short me-2"></i> Organogram</a>
                    <a href="#"><i class="bi bi-arrow-right-short me-2"></i> Sitemap</a>
                    <a href="#"><i class="bi bi-arrow-right-short me-2"></i> FAQ</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Modules</h4>
                    <a href="{{ route('registrations.create') }}"><i class="bi bi-arrow-right-short me-2"></i> E-Registration</a>
                    <a href="{{ route('standardizations.create') }}"><i class="bi bi-arrow-right-short me-2"></i> E-Standardization</a>
                    <a href="http://eprocurement.cwd.gkp.pk"><i class="bi bi-arrow-right-short me-2"></i> E-bidding</a>
                    <a href="http://etenders.cwd.gkp.pk/"><i class="bi bi-arrow-right-short me-2"></i> Contractor Login</a>
                    <a href="http://103.240.220.71:8080/index.php"><i class="bi bi-arrow-right-short me-2"></i> GIS Portal</a>
                    <a href="http://175.107.63.223:8889/forms/frmservlet?config=mb"><i class="bi bi-arrow-right-short me-2"></i> E-Billing</a>
                    <a href="https://pr.cwd.gkp.pk"><i class="bi bi-arrow-right-short me-2"></i> PWMIS</a>
                    <a href="https://cwd.gkp.pk/etender/login.php"><i class="bi bi-arrow-right-short me-2"></i> Old E-Tender</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-3">
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-4 text-white">Get In Touch</h4>
                    <a href=""><i class="bi bi-house me-2"></i>{{ $settings->contact_address ?? 'Civil Secretariat, Peshawar'}}</a>
                    <a href=""><i class="bi bi-envelope me-2"></i>{{ $settings->email ?? 'info@cwd.gkp.pk'}}</a>
                    <a href=""><i class="bi bi-phone me-2"></i>{{ $settings->contact_phone ?? '091-9214039'}}</a>
                    <a href="" class="mb-3"><i class="bi bi-whatsapp me-2"></i> {{ $settings->whatsapp ?? '0313-0535333'}}</a>
                </div>
                <div class="footer-item d-flex flex-column">
                    <h4 class="mb-2 text-white">Follow Us</h4>
                    <div>
                        <a href="https://facebook.com/{{ $settings->facebook ?? 'CWDKPGovt'}}"><i class="bi bi-facebook fs-4 me-2"></i></a>
                        <a href="https://twitter.com/{{ $settings->twitter ?? 'CWDKPGovt'}}"><i class="bi bi-twitter-x fs-4 me-2"></i></a>
                        <a href="https://youtube.com/{{ $settings->youtube ?? 'CWDKPGovt'}}"><i class="bi bi-youtube fs-4 me-2"></i> </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright text-body py-2">
    <div class="container">
        <div class="g-4 align-items-center">
            <div class="text-center mb-md-0 text-white">
                <a class="text-white" href="https://cwd.gkp.pk">&copy; {{ $settings->site_name ?? config('app.name') }}</a>
                <div>Developed and maintained by <a class="text-info" href="https://cwd.gkp.pk">IT Cell, C&W Department</a></div>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-primary-outline-0 btn-md-square back-to-top"><i class="bi bi-arrow-up"></i></a>

<script>
    (function() {
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

    document.addEventListener('DOMContentLoaded', function() {
        let btn = document.querySelector('#view-stories');
        let contentSeenItems = JSON.parse(localStorage.getItem('zuck-stories-content-seenItems') || '{}');
        let seenUserIds = Object.keys(contentSeenItems);

        fetch("{{ route('stories.get') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ seenUserIds })
            })
            .then(response => {
                if (!response.ok) {
                    return null;
                }
                return response.json();
            })
            .then(data => {
                if (!data) {
                    btn.classList.remove('stories-indicator');
                    return;
                }

                if (data.success && Array.isArray(data.data?.result)) {
                    let storiesData = data.data.result;

                    if (Array.isArray(data.expiredUsers) && data.expiredUsers.length > 0) {
                        data.expiredUsers.forEach(userId => {
                            delete contentSeenItems[userId];
                        });
                        localStorage.setItem('zuck-stories-content-seenItems', JSON.stringify(contentSeenItems));
                    }

                    let unviewedSeenItems = JSON.parse(localStorage.getItem('zuck-unviewed-stories-seenItems') || '{}');

                    storiesData.sort((a, b) => {
                        let aViewed = unviewedSeenItems[a.id] || contentSeenItems[a.id] || false;
                        let bViewed = unviewedSeenItems[b.id] || contentSeenItems[b.id] || false;

                        return aViewed === bViewed ? 0 : aViewed ? 1 : -1;
                    });

                    if (storiesData.some(story => !contentSeenItems[story.id])) {
                        btn.classList.add('stories-indicator');
                    } else {
                        btn.classList.remove('stories-indicator');
                    }
                } else {
                    btn.classList.remove('stories-indicator');
                }
            })
            .catch(error => {
                console.warn('No stories or server error occurred:', error);
                btn.classList.remove('stories-indicator');
            });
    });

    document.querySelector('#view-stories').addEventListener('click', function(e) {
        let btn = document.querySelector('#view-stories');
        if (btn.classList.contains('stories-indicator')) {
            btn.classList.remove('stories-indicator');
        }
        let storiesContent = document.querySelector('#stories-content');
        let spinner = document.querySelector('#stories-spinner');
        let errorMessage = "<div class='alert alert-warning' role='alert' style='margin-bottom:0px'>There are currently no stories</div>";

        loadZuckLibraries(function() {
            storiesContent.classList.remove('d-none');
            spinner.classList.add('show');

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
                        const zuckInstance = new Zuck(storiesContent, {
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

                        storiesContent.zuckInstance = zuckInstance;

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

    document.querySelector('#storiesCanvas').addEventListener('hidden.bs.offcanvas', function() {
        let storiesContent = document.querySelector('#stories-content');

        storiesContent.innerHTML = `
        <div id="stories-spinner" class="show bg-white d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `;
        storiesContent.classList.add('d-none');
    });

    document.addEventListener('DOMContentLoaded', () => {
        const modalContainer = document.getElementById('modal-container');
        const announcementSeen = sessionStorage.getItem('announcement_seen');
        const notificationsSeen = sessionStorage.getItem('notifications_seen');

        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                const {
                    announcement
                    , notifications
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

                if (notifications.length && !notificationsSeen) {
                    const notificationList = notifications.map(item => {
                    return `
                            <div class="d-flex align-items-center p-2 notification-item">
                                <i class="bi ${item.info[0]} notification-icon me-3 fs-3 px-2 py-0 rounded" style="background: ${item.info[2]}"></i>
                                <div>
                                    <a href="${item.url}">${item.title}</a>
                                </div>
                                <small class="news-date text-muted d-flex flex-column start" style="margin-left:auto">
                                    <a href="${item.info[3]}" class="badge text-bg-light mb-1 small" style="font-size: 10px">${item.info[1]}</a>
                                    <span>${item.created_at}</span>
                                </small>
                            </div>
                        `;
                    }).join('');

                    modalContainer.innerHTML += `
                        <div id="news-modal" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content" style="background: #ffffffdd">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="bi-megaphone"></i> &nbsp; Updates & Notifications</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                        <div>${notificationList}</div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center w-100">
                                        <div><a href="{{ route('notifications.index') }}">All Notifications</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                sessionStorage.setItem('notifications_seen', true);
                const newsModal = new bootstrap.Modal(document.getElementById('news-modal'));
                newsModal.show();
            }


            })
            .catch(error => console.error('Error fetching modals:', error));
    });

</script>
