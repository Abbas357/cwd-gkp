<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-2">
        <div class="d-flex flex-grow-1 justify-content-between align-items-center">
            <div class="d-flex flex-start align-items-center gap-3">
                <div class="btn-toggle user-select-none cursor-pointer">
                    <i class="bi-three-dots-vertical"></i>
                </div>
                @if (isset($header))
                <div class="page-breadcrumb d-none d-sm-flex align-items-center bg-light px-2 shadow-sm">
                    <div class="breadcrumb-title pe-2"><a href="{{ route('dashboard') }}">Home</a></div> <span class="fs-5">/</span>
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
                    <input class="form-control rounded-3 px-5 search-control d-lg-block d-none" type="text" placeholder="Search">
                    <span class="bi-search position-absolute d-lg-block d-none ms-3 translate-middle-y start-0 top-50"></span>
                    <span class="bi-x-circle position-absolute me-3 translate-middle-y end-0 top-50 search-close"></span>
                    <div class="search-popup p-3">
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
                                        <h5 class="mb-0 search-list-title"><a href="#">Wordpress Tutorials</a></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-center bg-transparent">
                                <a href="javascript:;" class="btn w-100">See All Search Results</a>
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
                <div class="dropdown-menu dropdown-menu-end dropdown-apps shadow-lg p-3">
                    <div class="border rounded-4 overflow-hidden">
                        <div class="row row-cols-3 g-0 border-bottom">
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <i style="font-size: 26px" class="bi-envelope"></i>
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Gmail</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <i style="font-size: 26px" class="bi-skype"></i>
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Skype</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <i style="font-size: 26px" class="bi-whatsapp"></i>
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Whasapp</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->

                        <div class="row row-cols-3 g-0 border-bottom">
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <i style="font-size: 26px" class="bi-youtube"></i>
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">YouTube</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <i style="font-size: 26px" class="bi-google"></i>
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Google</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <i style="font-size: 26px" class="bi-instagram"></i>
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Instagram</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->

                    </div>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i class="bi-bell"></i>
                    <span class="badge-notify">1</span>
                </a>
                <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
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
            </li>
            <li class="nav-item dropdown">
                <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle p-1 border" width="45" height="45">
                </a>
                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                    <a class="dropdown-item  gap-2 py-2" href="{{ route('profile.edit') }}">
                        <div class="text-center">
                            <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle p-1 shadow mb-3" width="90" height="90" alt="">
                            <h5 class="user-name mb-0 fw-bold">Hello, {{ auth()->user()->name }}</h5>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('profile.edit') }}"><i class="bi-person-circle"></i>Profile</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('profile.edit') }}"><i class="bi-gear-fill"></i>Settings</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('dashboard') }}"><i class="bi-speedometer"></i>Dashboard</a>
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
