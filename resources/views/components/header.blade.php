<header {{ $attributes->merge(['class' => 'top-header']) }}>
    <nav class="navbar navbar-expand align-items-center gap-2" style="{{ !$showAside ? 'left: 0;' : '' }}">
        <div class="d-flex flex-grow-1 justify-content-between align-items-center">
            <div class="d-flex flex-start align-items-center gap-3">
                @if($showAside)
                <div class="btn-toggle user-select-none cursor-pointer">
                    <i class="bi-three-dots-vertical"></i>
                </div>
                @else
                <a href="{{ route('admin.apps') }}" class="logo-icon">
                    <img src="{{ asset('admin/images/logo-square.png') }}" style="width:50px; border-radius:5px" alt="Logo">
                </a>
                @endif
                @if (isset($breadcrumb) && $breadcrumb->isNotEmpty())
                <div class="page-breadcrumb d-none d-sm-flex align-items-center bg-light px-2 shadow-sm">
                    <div class="breadcrumb-title pe-2"><a href="{{ route('admin.apps') }}">Home</a></div> <span class="fs-5">/</span>
                    <div class="ps-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 p-0">
                                {{ $breadcrumb }}
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
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;">
                    <i class="bi-grid-3x3-gap-fill"></i>
                </a>
                <div class="border dropdown-menu dropdown-menu-end custom-app-dropdown-menu shadow-lg">
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
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;">
                    <i class="bi-bell"></i>
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
                <a href="javascript:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
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
                    @canany(['view settings', 'view any district', 'view any category'])
                    <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="#" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('collapseMenuItems').classList.toggle('show');">
                        <i class="bi-arrow-down-circle-fill"></i>Settings
                    </a>
                    <div class="collapse px-3" id="collapseMenuItems">
                        @can('view settings')
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.settings.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-gear-fill"></i>Core Settings
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
                        <a class="dropdown-item d-flex align-items-center cursor-pointer gap-2 py-1" onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="bi-power"></i>Logout
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </nav>
    <script>
        var linksURL = "{{ route('admin.search.links') }}";
        var activityURL = "{{ route('admin.activity.notifications') }}";

    </script>
</header>
