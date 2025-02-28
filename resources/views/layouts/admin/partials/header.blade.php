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

    .rotate-180 {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    .bi-chevron-down {
        transition: transform 0.3s ease;
    }

    .dropdown-menu {
        transition: max-height 0.3s ease;
    }
    .dropdown-item:hover {
        background: rgba(0, 0, 0, 0.09)
    }

    .dropdown-notify {
        width: 320px;
        max-height: 400px;
    }
    
    .notify-list {
        max-height: 350px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    
    .notify-title {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 2px;
        color: #333;
        display: flex;
        align-items: center;
    }
    
    .notify-desc {
        font-size: 12px;
        color: #666;
    }
    
    .notify-time {
        font-size: 11px;
        color: #999;
    }
    
    .badge-notify {
        position: absolute;
        top: 5;
        right: 0;
        font-size: 10px;
        padding: 0 5px;
        background-color: #ff0000;
        color: white;
        border-radius: 50%;
        transform: translate(25%, -25%);
    }
    
    .notify-list .text-center .bi-bell-slash,
    .notify-list .text-center .bi-exclamation-circle {
        opacity: 0.5;
    }
    
    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    
    .dropdown-item {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    .badge.bg-success {
        font-size: 10px;
        padding: 3px 6px;
    }

    .app-dropdown-menu {
    padding: 15px;
    width: 300px;
}

.custom-app-dropdown-menu {
      padding: 15px;
      width: 300px;
    }

    .custom-app-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }

    .custom-app-tile {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-decoration: none;
      padding: 8px 5px;
      border-radius: 8px;
      transition: all 0.25s ease;
    }

    .custom-app-tile:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .custom-app-icon-container {
      height: 40px;
      width: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 5px;
      border-radius: 8px;
    }

    .custom-app-icon {
      font-size: 18px;
    }

    .custom-app-name {
      margin: 0;
      font-size: 11px;
      font-weight: 500;
      color: #333;
    }

    .custom-purple-theme {
      background-color: rgba(141, 15, 224, 0.05);
      border: 1px solid rgba(141, 15, 224, 0.1);
    }
    .custom-purple-theme .custom-app-icon-container {
      background-color: rgba(141, 15, 224, 0.1);
    }
    .custom-purple-theme .custom-app-icon {
      color: #8d0fe0;
    }

    .custom-red-theme {
      background-color: rgba(255, 0, 13, 0.05);
      border: 1px solid rgba(255, 0, 13, 0.1);
    }
    .custom-red-theme .custom-app-icon-container {
      background-color: rgba(255, 0, 13, 0.1);
    }
    .custom-red-theme .custom-app-icon {
      color: #ff000d;
    }

    .custom-green-theme {
      background-color: rgba(29, 161, 242, 0.05);
      border: 1px solid rgba(29, 161, 242, 0.1);
    }
    .custom-green-theme .custom-app-icon-container {
      background-color: rgba(29, 161, 242, 0.1);
    }
    .custom-green-theme .custom-app-icon {
      color: #1DA1F2;
    }

    .custom-teal-theme {
      background-color: rgba(28, 199, 208, 0.05);
      border: 1px solid rgba(28, 199, 208, 0.1);
    }
    .custom-teal-theme .custom-app-icon-container {
      background-color: rgba(28, 199, 208, 0.1);
    }
    .custom-teal-theme .custom-app-icon {
      color: #1cc7d0;
    }

    .custom-orange-theme {
      background-color: rgba(244, 119, 33, 0.05);
      border: 1px solid rgba(244, 119, 33, 0.1);
    }
    .custom-orange-theme .custom-app-icon-container {
      background-color: rgba(244, 119, 33, 0.1);
    }
    .custom-orange-theme .custom-app-icon {
      color: #f47721;
    }

    [data-bs-theme="dark"] .custom-app-name {
      color: #eee;
    }

</style>

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
                                    <a href="javascript:;" class="kewords"><span>E-Bidding</span><i class="bi-search fs-6"></i></a>
                                </div>
                                <hr>
                                <p class="search-title">Searches</p>
                                <div class="search-list d-flex flex-column gap-2">
                                    <div class="search-list-item d-flex align-items-center gap-3">
                                        <h5 class="mb-0 search-list-title"><a href="#">Tenders</a></h5>
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
                <a
                  class="nav-link dropdown-toggle dropdown-toggle-nocaret"
                  data-bs-auto-close="outside"
                  data-bs-toggle="dropdown"
                  href="javascript:;"
                >
                  <i class="bi-grid-3x3-gap-fill"></i>
                </a>
                <div
                  class="border dropdown-menu dropdown-menu-end custom-app-dropdown-menu shadow-lg"
                >
                  <h6 class="dropdown-header text-center mb-2">Apps</h6>
                  <div class="custom-app-grid">
                    @can('manage website')
                    <a href="{{ route('admin.home') }}" class="custom-app-tile custom-purple-theme">
                      <div class="custom-app-icon-container">
                        <i class="bi-globe custom-app-icon"></i>
                      </div>
                      <p class="custom-app-name">Website</p>
                    </a>
                    @endcan
        
                    @can('manage vehicles')
                    <a href="{{ route('admin.apps.vehicles.index') }}" class="custom-app-tile custom-red-theme">
                      <div class="custom-app-icon-container">
                        <i class="bi-bus-front custom-app-icon"></i>
                      </div>
                      <p class="custom-app-name">Vehicle Mgt.</p>
                    </a>
                    @endcan
        
                    @can('manage standardizations')
                    <a href="{{ route('admin.apps.standardizations.index') }}" class="custom-app-tile custom-green-theme">
                      <div class="custom-app-icon-container">
                        <i class="bi-patch-check-fill custom-app-icon"></i>
                      </div>
                      <p class="custom-app-name">Standard</p>
                    </a>
                    @endcan
        
                    @can('manage contractors')
                    <a href="{{ route('admin.apps.contractors.index') }}" class="custom-app-tile custom-teal-theme">
                      <div class="custom-app-icon-container">
                        <i class="bi-person-vcard custom-app-icon"></i>
                      </div>
                      <p class="custom-app-name">Contractors</p>
                    </a>
                    @endcan
        
                    @can('manage service cards')
                    <a href="{{ route('admin.apps.service_cards.index') }}" class="custom-app-tile custom-orange-theme">
                      <div class="custom-app-icon-container">
                        <i class="bi-credit-card custom-app-icon"></i>
                      </div>
                      <p class="custom-app-name">Service Card</p>
                    </a>
                    @endcan
                  </div>
                </div>
              </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i class="bi-bell"></i>
                    <span class="badge-notify"></span>
                </a>
                <div class="dropdown-menu border dropdown-notify dropdown-menu-end shadow" style="overflow:hidden">
                    <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
                        <h5 class="notiy-title mb-0">Notifications</h5>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="bi-three-dots-vertical"></span>
                            </button>
                            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                                <div><a class="dropdown-item d-flex align-items-center gap-2 py-1" href="javascript:;">Mark all as read</a></div>
                                <div><a class="dropdown-item d-flex align-items-center gap-2 py-1" href="javascript:;">Archive</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="notify-list">
                        <div class="text-center p-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mb-0 mt-3">Loading activity logs...</p>
                        </div>
                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle border" width="40" height="40">
                </a>
                <div class="dropdown-menu border dropdown-user dropdown-menu-end shadow" style="max-height: 85vh; overflow-y: auto;">
                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                        <div class="text-center">
                            <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle p-1 shadow mb-1" width="80" height="80" alt="">
                            <h6 class="user-name mb-0 fw-bold">{{ auth()->user()->designation }}</h6>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.profile.edit') }}"><i class="bi-person-circle"></i>Profile</a>
                    @can('view activity')
                    <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.activity.index') }}"><i class="bi-clock-history"></i>Activity Log</a>
                    @endcan
                    @canany(['view settings', 'view any role', 'view any permission', 'view any district', 'view any category'])
                    <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="#" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('collapseMenuItems').classList.toggle('show');">
                        <i class="bi-arrow-down-circle-fill"></i>Settings
                    </a>
                    <div class="collapse px-3" id="collapseMenuItems">
                        @can('view settings')
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.settings.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-gear-fill"></i>Core Settings
                        </a>
                        @endcan
                        @can('view any role')
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.roles.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-person-badge"></i>Roles
                        </a>
                        @endcan
                        @can('view any permission')
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.permissions.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-key"></i>Permissions
                        </a>
                        @endcan
                        @can('view any district')
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.districts.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-geo-alt"></i>Districts
                        </a>
                        @endcan
                        @can('view any category')
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.categories.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-list-nested"></i>Categories
                        </a>
                        @endcan
                    </div>
                    @endcan

                    <hr class="dropdown-divider">
                    <form method="POST" action="{{ route('logout') }}" disabled>
                        @csrf
                        <a class="dropdown-item d-flex align-items-center cursor-pointer gap-2 py-1" onclick="event.preventDefault();
                            this.closest('form').submit();
                            this.closest('.top-right-menu').classList.add('hidden');
                            "><i class="bi-power"></i>Logout
                        </a>
                    </form>
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
            const url = "{{ route('admin.search.links') }}?query=" + encodeURIComponent(query);
            fetch(url)
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

        document.querySelectorAll('.dropdown-menu').forEach(function(dropdown) {
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });

        document.querySelector('a[onclick*="collapseMenuItems"]').addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('rotate-180');
        });

        const notifyList = document.querySelector('.notify-list');
        const badgeNotify = document.querySelector('.badge-notify');
        let currentPage = 1;
        let loading = false;
        let hasMorePages = true;
        
        function fetchActivityLogs(page = 1, append = false) {
            if (loading || (!append && !hasMorePages)) return;
            
            loading = true;
            
            if (page === 1) {
                notifyList.innerHTML = `
                    <div class="text-center p-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mb-0 mt-3">Loading activity logs...</p>
                    </div>
                `;
            } else if (append) {
                const loadingEl = document.createElement('div');
                loadingEl.className = 'text-center p-2 loading-indicator';
                loadingEl.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"></div>';
                notifyList.appendChild(loadingEl);
            }
            
            const url = "{{ route('admin.activity.notifications') }}?page=" + encodeURIComponent(page) + "&perPage=5";
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const loadingIndicator = notifyList.querySelector('.loading-indicator');
                    if (loadingIndicator) {
                        loadingIndicator.remove();
                    }
                    
                    if (!append) {
                        notifyList.innerHTML = '';
                    }
                    
                    badgeNotify.textContent = data.todayCount > 99 ? '99+' : data.todayCount;
                    
                    if (data.todayCount === 0) {
                        badgeNotify.style.display = 'none';
                    } else {
                        badgeNotify.style.display = 'block';
                    }
                    
                    data.activities.forEach(activity => {
                        const activityItem = document.createElement('div');
                        
                        let todayIndicator = '';
                        if (activity.is_today) {
                            todayIndicator = '<span class="badge bg-success rounded-pill ms-2">New</span>';
                        }
                        
                        activityItem.innerHTML = `
                            <a class="dropdown-item border-bottom py-2" href="javascript:;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="">
                                        <img src="${activity.causer_image}" class="rounded-circle" width="45" height="45" alt="">
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="notify-title">${activity.description} ${todayIndicator}</h5>
                                        <p class="mb-0 notify-desc">By ${activity.causer_name} ${activity.subject_type ? 'on ' + activity.subject_type : ''}</p>
                                        <p class="mb-0 notify-time">${activity.time}</p>
                                    </div>
                                    <div class="notify-close position-absolute end-0 me-3">
                                        <i class="bi-x-circle fs-6"></i>
                                    </div>
                                </div>
                            </a>
                        `;
                        notifyList.appendChild(activityItem);
                    });
                    
                    if (data.activities.length === 0 && !append) {
                        notifyList.innerHTML = `
                            <div class="text-center p-4">
                                <i class="bi bi-bell-slash fs-2 text-muted"></i>
                                <p class="mb-0 mt-2">No activity logs found</p>
                            </div>
                        `;
                    }
                    
                    hasMorePages = data.hasMorePages;
                    currentPage = page;
                    loading = false;
                })
                .catch(error => {
                    console.error('Error fetching activity logs:', error);
                    loading = false;
                    
                    const loadingIndicator = notifyList.querySelector('.loading-indicator');
                    if (loadingIndicator) {
                        loadingIndicator.remove();
                    }
                    
                    if (!append) {
                        notifyList.innerHTML = `
                            <div class="text-center p-4">
                                <i class="bi bi-exclamation-circle fs-2 text-danger"></i>
                                <p class="mb-0 mt-2">Failed to load notifications</p>
                            </div>
                        `;
                    }
                });
        }
        
        fetchActivityLogs();
        
        document.querySelector('.notify-list').addEventListener('scroll', function() {
            const { scrollTop, scrollHeight, clientHeight } = this;
            
            if (scrollTop + clientHeight >= scrollHeight - 50 && hasMorePages && !loading) {
                fetchActivityLogs(currentPage + 1, true);
            }
        });
        
        const notificationButton = document.querySelector('a.nav-link[data-bs-toggle="dropdown"]');
        notificationButton.addEventListener('click', function() {
            if (!document.querySelector('.dropdown-notify').classList.contains('show')) {
                currentPage = 1;
                hasMorePages = true;
                fetchActivityLogs();
            }
        });
        
        notifyList.addEventListener('click', function(e) {
            if (e.target.closest('.notify-close')) {
                e.target.closest('.dropdown-item').remove();
            }
        });

    });

</script>
