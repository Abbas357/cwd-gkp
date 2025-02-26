<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-2" style="{{ !$showAside ? 'left: 0;' : '' }}">
        <div class="d-flex flex-grow-1 justify-content-between align-items-center">
            <div class="d-flex flex-start align-items-center gap-3">
                @if($showAside)
                <div class="btn-toggle user-select-none cursor-pointer">
                    <i class="bi-three-dots-vertical"></i>
                </div>
                @else
                <a href="{{ route('admin.apps') }}" class="logo-icon">
                    <img src="{{ asset('admin/images/logo.png') }}" style="width:190px; border-radius:5px" alt="Logo Desktop">
                </a>
                @endif
                @if (isset($header))
                <div class="page-breadcrumb d-none d-sm-flex align-items-center bg-light px-2 shadow-sm">
                    <div class="breadcrumb-title pe-2"><a href="{{ route('admin.apps') }}">Home</a></div> <span class="fs-5">/</span>
                    <div class="ps-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                {{ $header }}
                            </ol>
                        </nav>
                    </div>
                </div>
                @endif
            </div>
            <div class="search-bar" style="max-width: 500px; flex-grow: 1">
                <div class="position-relative">
                    <input class="form-control rounded-3 px-5 search-control shadow-sm d-lg-block d-none" type="text" placeholder="Search">
                    <span class="bi-search position-absolute d-lg-block d-none ms-3 translate-middle-y start-0 top-50"></span>
                    <span class="bi-x-circle position-absolute me-3 translate-middle-y end-0 top-50 search-close"></span>
                    <div class="search-popup p-1 border">
                        <div class="card overflow-hidden">
                            <div class="card-header d-lg-none">
                                <div class="position-relative">
                                    <input class="form-control rounded-3 px-5 mobile-search-control" type="text" placeholder="Search">
                                    <span class="bi-search position-absolute ms-3 translate-middle-y start-0 top-50"></span>
                                    <span class="bi-x-circle position-absolute me-3 translate-middle-y end-0 top-50 mobile-search-close"></span>
                                </div>
                            </div>
                            <div class="card-body search-content">
                                <p class="search-title">Recent Searches</p>
                                <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                                    <a href="javascript:;" class="kewords"><span>Tenders</span><i class="bi-search fs-6"></i></a>
                                    <a href="javascript:;" class="kewords"><span>E-Bidding</span><i class="bi-search fs-6"></i></a>
                                    <a href="javascript:;" class="kewords"><span>Latest news</span><i class="bi-search fs-6"></i></a>
                                </div>
                                <hr>
                                <p class="search-title">Searches</p>
                                <div class="search-list d-flex flex-column gap-2">
                                    <div class="search-list-item d-flex align-items-center gap-3">
                                        <h5 class="mb-0 search-list-title"><a href="#">Events</a></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ul class="navbar-nav gap-1 nav-right-links align-items-center">
            <li class="nav-item d-lg-none mobile-search-btn">
                <a class="nav-link" href="javascript:;"><i class="bi-search"></i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i class="bi-grid-3x3-gap-fill"></i></a>
                <div class="border dropdown-menu dropdown-menu-end dropdown-apps shadow-lg p-1">
                    <div class="rounded-4 overflow-hidden">
                        <div class="admin-grid">
                            <div class="grid-container">
                                @can('view any user')
                                <a href="{{ route('admin.users.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #8d0fe0" class="bi bi-person-circle"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Users</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any tender')
                                <a href="{{ route('admin.tenders.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #ff000d" class="bi bi-briefcase"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Tenders</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any event')
                                <a href="{{ route('admin.events.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #96bb05" class="bi bi-calendar2-event"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Events</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any news')
                                <a href="{{ route('admin.news.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #1cc7d0" class="bi bi-journal"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">News</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('create download')
                                <a href="{{ route('admin.downloads.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #fb8a2e" class="bi bi-download"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Downloads</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any gallery')
                                <a href="{{ route('admin.gallery.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #11862f" class="bi bi-card-image"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Gallery</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any contractor')
                                <a href="{{ route('admin.app.contractors.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #00a4e4" class="bi bi-clipboard"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Registration</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any standardization')
                                <a href="{{ route('admin.app.standardizations.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #49c0b6" class="bi bi-shield-lock"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Standardization</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any service card')
                                <a href="{{ route('admin.app.service_cards.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #a4c649" class="bi bi-credit-card"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Service Card</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any story')
                                <a href="{{ route('admin.stories.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #0389ff" class="bi bi-app"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Stories</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any user')
                                <a href="{{ route('admin.settings.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #f1632a" class="bi bi-gear"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Settings</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any user')
                                <a href="{{ route('admin.logs') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #ce1126" class="bi bi-activity"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Activity</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('view any seniority')
                                <a href="{{ route('admin.seniority.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #790bdf" class="bi bi-graph-up-arrow"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">Seniority</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                        
                                @can('create development project')
                                <a href="{{ route('admin.development_projects.index') }}" class="grid-item text-decoration-none text-dark">
                                    <div class="app-wrapper d-flex flex-column gap-2 text-center p-3">
                                        <div class="app-icon">
                                            <i style="font-size: 26px; color: #0096a0" class="bi bi-buildings"></i>
                                        </div>
                                        <div class="app-name">
                                            <p class="mb-0">ADP</p>
                                        </div>
                                    </div>
                                </a>
                                @endcan
                            </div>
                        
                            <style>
                                .admin-grid {
                                    height: 400px;
                                    overflow-y: auto;
                                    overflow-x: hidden;
                                    padding: 1px;
                                }
                        
                                .grid-container {
                                    display: grid;
                                    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
                                    gap: 1px;
                                }
                        
                                .grid-item {
                                    position: relative;
                                }
                        
                                .app-wrapper {
                                    min-height: 100px;
                                    transition: all 0.3s ease;
                                    height: 100%;
                                }
                        
                                .grid-item:hover .app-wrapper {
                                    background-color: rgba(0, 0, 0, 0.02);
                                }
                        
                                .app-icon i {
                                    transition: transform 0.2s ease;
                                }
                        
                                .grid-item:hover .app-icon i {
                                    transform: scale(1.1);
                                }
                        
                                .grid-item {
                                    cursor: pointer;
                                }
                        
                                .grid-item:active .app-wrapper {
                                    background-color: rgba(0, 0, 0, 0.05);
                                }
                        
                                .app-name p {
                                    color: #777;
                                    font-size: 14px;
                                    font-weight: 500;
                                }
                        
                                .admin-grid::-webkit-scrollbar {
                                    width: 8px;
                                }
                        
                                .admin-grid::-webkit-scrollbar-track {
                                    background: transparent;
                                }
                        
                                .admin-grid::-webkit-scrollbar-thumb {
                                    background: #888;
                                    border-radius: 4px;
                                }
                        
                                .admin-grid::-webkit-scrollbar-thumb:hover {
                                    background: #555;
                                }
                        
                                /* Responsive adjustments */
                                @media (max-width: 768px) {
                                    .grid-container {
                                        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
                                    }
                                }
                        
                                @media (max-width: 480px) {
                                    .grid-container {
                                        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
                                    }
                                    
                                    .app-wrapper {
                                        min-height: 80px;
                                        padding: 2px !important;
                                    }
                                    
                                    .app-icon i {
                                        font-size: 20px !important;
                                    }
                                    
                                    .app-name p {
                                        font-size: 12px;
                                    }
                                }
                            </style>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i class="bi-bell"></i>
                    <span class="badge-notify">1</span>
                </a>
                <div class="dropdown-menu border dropdown-notify dropdown-menu-end shadow">
                    <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
                        <h5 class="notiy-title mb-0">Notifications</h5>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="bi-three-dots-vertical"></span>
                            </button>
                            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;">Mark all as read</a></div>
                                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;">Archive</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="notify-list">
                        <div>
                            <a class="dropdown-item border-bottom py-2" href="javascript:;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="">
                                        <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle" width="45" height="45" alt="">
                                    </div>
                                    <div class="">
                                        <h5 class="notify-title">Welcome {{ auth()->user()->name }}</h5>
                                        <p class="mb-0 notify-desc">Your account is created </p>
                                        <p class="mb-0 notify-time">{{ auth()->user()->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="notify-close position-absolute end-0 me-3">
                                        <i class="bi-x-circle fs-6"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle p-1 border" width="45" height="45">
                </a>
                <div class="dropdown-menu border dropdown-user dropdown-menu-end shadow">
                    <a class="dropdown-item  gap-2 py-2" href="{{ route('admin.profile.edit') }}">
                        <div class="text-center">
                            <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle p-1 shadow mb-3" width="90" height="90" alt="">
                            <h5 class="user-name mb-0 fw-bold">Hello, {{ auth()->user()->name }}</h5>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('admin.profile.edit') }}"><i class="bi-person-circle"></i>Profile</a>
                    @can('view settings')
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('admin.settings.index') }}"><i class="bi-gear-fill"></i>Settings</a>
                    @endcan
                    @can('view activity')
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('admin.logs') }}"><i class="bi-activity"></i>Activity Log</a>
                    @endcan
                    <hr class="dropdown-divider">
                    <form method="POST" action="{{ route('logout') }}" disabled>
                        @csrf
                        <a class="dropdown-item d-flex align-items-center cursor-pointer gap-2 py-2" onclick="event.preventDefault();
                            this.closest('form').submit();
                            this.closest('.top-right-menu').classList.add('hidden');
                            "><i class="bi-power"></i>Logout
                    </form></a>
                </div>
            </li>
        </ul>

    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-control');
        const mobileSearchInput = document.querySelector('.mobile-search-control');
        const searchPopup = document.querySelector('.search-popup');
        const keywordsWrapper = document.querySelector('.kewords-wrapper');
        const searchList = document.querySelector('.search-list');
        
        let typingTimer;
        const doneTypingInterval = 500;
        let recentUrlMap = {};

        function performSearch(query) {
            fetch(`/admin/search/links?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    data.results.forEach(result => {
                        if (result.url && result.title) {
                            recentUrlMap[result.title.toLowerCase()] = result.url;
                        }
                    });

                    keywordsWrapper.innerHTML = data.recentSearches.map(search => {
                        const url = recentUrlMap[search.toLowerCase()];
                        return url ? `
                            <a href="${url}" class="kewords">
                                <span>${search}</span>
                                <i class="bi-arrow-right fs-6"></i>
                            </a>
                        ` : `
                            <a href="javascript:;" class="kewords" onclick="document.querySelector('.search-control').value='${search}';performSearch('${search}')">
                                <span>${search}</span>
                                <i class="bi-search fs-6"></i>
                            </a>
                        `;
                    }).join('');

                    // Update search results
                    if (data.results.length === 0) {
                        searchList.innerHTML = `
                            <div class="search-list-item">
                                <p class="text-muted mb-0">No links found</p>
                            </div>
                        `;
                    } else {
                        searchList.innerHTML = data.results.map(link => `
                            <div class="search-list-item">
                                <h5 class="mb-0 search-list-title">
                                    <a href="${link.url}" class="text-decoration-none">
                                        ${link.title}
                                    </a>
                                </h5>
                            </div>
                        `).join('');
                    }
                });
        }

        performSearch('');

        searchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => performSearch(this.value), doneTypingInterval);
        });

        mobileSearchInput.addEventListener('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => performSearch(this.value), doneTypingInterval);
        });

        searchInput.addEventListener('focus', () => searchPopup.style.display = 'block');
        document.querySelector('.search-close').addEventListener('click', () => searchPopup.style.display = 'none');
        document.querySelector('.mobile-search-close').addEventListener('click', () => searchPopup.style.display = 'none');
    });
</script>