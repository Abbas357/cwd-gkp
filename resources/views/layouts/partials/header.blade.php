<header class="top-header">
    <nav class="navbar navbar-expand align-items-center gap-2">
        <div class="d-flex flex-grow-1 justify-content-between align-items-center">
            <div class="btn-toggle">
                <a href="javascript:;"><i class="material-icons-outlined">menu</i></a>
            </div>
            <div class="search-bar" style="max-width: 500px; flex-grow: 1">
                <div class="position-relative">
                    <input class="form-control rounded-3 px-5 search-control d-lg-block d-none" type="text" placeholder="Search">
                    <span class="material-icons-outlined position-absolute d-lg-block d-none ms-3 translate-middle-y start-0 top-50">search</span>
                    <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 search-close">close</span>
                    <div class="search-popup p-3">
                        <div class="card overflow-hidden">
                            <div class="card-header d-lg-none">
                                <div class="position-relative">
                                    <input class="form-control rounded-3 px-5 mobile-search-control" type="text" placeholder="Search">
                                    <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50">search</span>
                                    <span class="material-icons-outlined position-absolute me-3 translate-middle-y end-0 top-50 mobile-search-close">close</span>
                                </div>
                            </div>
                            <div class="card-body search-content">
                                <p class="search-title">Recent Searches</p>
                                <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                                    <a href="javascript:;" class="kewords"><span>Tenders</span><i class="material-icons-outlined fs-6">search</i></a>
                                    <a href="javascript:;" class="kewords"><span>E-Bidding</span><i class="material-icons-outlined fs-6">search</i></a>
                                    <a href="javascript:;" class="kewords"><span>Latest news</span><i class="material-icons-outlined fs-6">search</i></a>
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
                <a class="nav-link" href="javascript:;"><i class="material-icons-outlined">search</i></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i class="material-icons-outlined">apps</i></a>
                <div class="dropdown-menu dropdown-menu-end dropdown-apps shadow-lg p-3">
                    <div class="border rounded-4 overflow-hidden">
                        <div class="row row-cols-3 g-0 border-bottom">
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <img src="{{ asset('images/apps/01.png') }}" width="36" alt="">
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Gmail</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <img src="{{ asset('images/apps/02.png') }}" width="36" alt="">
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Skype</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <img src="{{ asset('images/apps/03.png') }}" width="36" alt="">
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Slack</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end row-->

                        <div class="row row-cols-3 g-0 border-bottom">
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <img src="{{ asset('images/apps/04.png') }}" width="36" alt="">
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">YouTube</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col border-end">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <img src="{{ asset('images/apps/05.png') }}" width="36" alt="">
                                    </div>
                                    <div class="app-name">
                                        <p class="mb-0">Google</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="app-wrapper d-flex flex-column gap-2 text-center">
                                    <div class="app-icon">
                                        <img src="{{ asset('images/apps/06.png') }}" width="36" alt="">
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
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;"><i class="material-icons-outlined">notifications</i>
                    <span class="badge-notify">1</span>
                </a>
                <div class="dropdown-menu dropdown-notify dropdown-menu-end shadow">
                    <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
                        <h5 class="notiy-title mb-0">Notifications</h5>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-icons-outlined">
                                    more_vert
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i class="material-icons-outlined fs-6">done_all</i>Mark all as read</a></div>
                                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i class="material-icons-outlined fs-6">archive</i>Archive</a></div>
                                <div>
                                    <hr class="dropdown-divider">
                                </div>
                                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;"><i class="material-icons-outlined fs-6">leaderboard</i>Reports</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="notify-list">
                        <div>
                            <a class="dropdown-item border-bottom py-2" href="javascript:;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="">
                                        <img src="{{ asset(auth()->user()->image) }}" class="rounded-circle" width="45" height="45" alt="">
                                    </div>
                                    <div class="">
                                        <h5 class="notify-title">Welcome {{ auth()->user()->name }}</h5>
                                        <p class="mb-0 notify-desc">Your account is created </p>
                                        <p class="mb-0 notify-time">{{ auth()->user()->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="notify-close position-absolute end-0 me-3">
                                        <i class="material-icons-outlined fs-6">close</i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
            </li>
            <li class="nav-item dropdown">
                <a href="javascrpt:;" class="dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                    <img src="{{ asset(auth()->user()->image) }}" class="rounded-circle p-1 border" width="45" height="45">
                </a>
                <div class="dropdown-menu dropdown-user dropdown-menu-end shadow">
                    <a class="dropdown-item  gap-2 py-2" href="{{ route('profile.edit') }}">
                        <div class="text-center">
                            <img src="{{ asset('images/no-profile.png') }}" class="rounded-circle p-1 shadow mb-3" width="90" height="90" alt="">
                            <h5 class="user-name mb-0 fw-bold">Hello, {{ auth()->user()->name }}</h5>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('profile.edit') }}"><i class="material-icons-outlined">person_outline</i>Profile</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('profile.edit') }}"><i class="material-icons-outlined">local_bar</i>Setting</a>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('dashboard') }}"><i class="material-icons-outlined">dashboard</i>Dashboard</a>
                    <hr class="dropdown-divider">
                    <form method="POST" action="{{ route('logout') }}" disabled>
                        @csrf
                        <a class="dropdown-item d-flex align-items-center cursor-pointer gap-2 py-2" onclick="event.preventDefault();
                            this.closest('form').submit();
                            this.closest('.top-right-menu').classList.add('hidden');
                            "><i class="material-icons-outlined">power_settings_new</i>Logout
                    </form></a>
                </div>
            </li>
        </ul>

    </nav>
</header>
