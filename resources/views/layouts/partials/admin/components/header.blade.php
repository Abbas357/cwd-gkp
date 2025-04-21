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
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 d-lg-block d-none"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control border-0 bg-light admin-search search-control d-lg-block d-none" placeholder="Search...">
                    </div>
                    <div class="search-popup">
                        <div class="card overflow-hidden">
                            <div class="card-header d-lg-none">
                                <div class="input-group position-relative">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text" class="form-control border-0 bg-light admin-search mobile-search-control" placeholder="Search...">
                                </div>
                            </div>
                            <div class="card-body search-content">
                                <p class="search-title">Recent Searches</p>
                                <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                                    <a href="javascript:;" class="kewords"><span>E-Bidding</span><i class="bi-search"></i></a>
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
                    @php
                        $user = auth()->user();
                    @endphp
                    <div class="custom-app-grid">
                        @if(
                            $user->can('viewAny', App\Models\News::class) ||
                            $user->can('viewAny', App\Models\Event::class) ||
                            $user->can('viewAny', App\Models\Tender::class) ||
                            $user->can('viewAny', App\Models\Seniority::class) ||
                            $user->can('viewAny', App\Models\Gallery::class) ||
                            $user->can('viewAny', App\Models\Slider::class) ||
                            $user->can('viewAny', App\Models\Story::class) ||
                            $user->can('viewAny', App\Models\Page::class) ||
                            $user->can('viewAny', App\Models\Download::class) ||
                            $user->can('viewAny', App\Models\Project::class) ||
                            $user->can('viewAny', App\Models\ProjectFile::class) ||
                            $user->can('viewAny', App\Models\DevelopmentProject::class) ||
                            $user->can('viewAny', App\Models\Scheme::class) ||
                            $user->can('viewAny', App\Models\Achievement::class) ||
                            $user->can('viewAny', App\Models\Comment::class) ||
                            $user->can('viewAny', App\Models\PublicContact::class) ||
                            $user->can('viewAny', App\Models\NewsLetter::class) ||
                            $user->can('massEmail', App\Models\NewsLetter::class)
                        )
                        <a href="{{ route('admin.home') }}" class="custom-app-tile custom-purple-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-globe custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">Website</p>
                        </a>
                        @endif

                        @if(
                            $user->can('viewAny', App\Models\User::class) ||
                            $user->can('viewAny', App\Models\Office::class) ||
                            $user->can('viewAny', App\Models\Designation::class) ||
                            $user->can('viewAny', App\Models\SanctionedPost::class) ||
                            $user->can('viewAny', App\Models\Posting::class) ||
                            $user->can('viewAny', App\Models\Role::class) ||
                            $user->can('assignRole', App\Models\Role::class) ||
                            $user->can('assignPermission', App\Models\Role::class) ||
                            $user->can('viewAny', App\Models\Permission::class) ||
                            $user->can('viewVacancyReport', App\Models\User::class) ||
                            $user->can('viewEmployeeDirectoryReport', App\Models\User::class) ||
                            $user->can('viewOfficeStrengthReport', App\Models\User::class) ||
                            $user->can('viewPostingHistoryReport', App\Models\User::class) ||
                            $user->can('viewServiceLengthReport', App\Models\User::class) ||
                            $user->can('viewRetirementForecastReport', App\Models\User::class) ||
                            $user->can('viewOfficeStaffReport', App\Models\User::class) ||
                            $user->can('viewOrganogram', App\Models\office::class)
                        )
                        <a href="{{ route('admin.apps.vehicles.index') }}" class="custom-app-tile custom-red-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-people custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">HRMIS</p>
                        </a>
                        @endif

                        @if(
                            $user->can('viewAny', App\Models\Vehicle::class) ||
                            $user->can('viewReports', App\Models\Vehicle::class)
                        )
                        <a href="{{ route('admin.apps.vehicles.index') }}" class="custom-app-tile custom-red-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-bus-front custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">Vehicle Mgt.</p>
                        </a>
                        @endif

                        @if(
                            $user->can('viewAny', App\Models\Standardization::class) ||
                            $user->can('viewAny', App\Models\Product::class)
                        )
                        <a href="{{ route('admin.apps.standardizations.index') }}" class="custom-app-tile custom-green-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-patch-check-fill custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">Standard</p>
                        </a>
                        @endif
                        
                        @if(
                            $user->can('viewAny', App\Models\Contractor::class) ||
                            $user->can('viewAny', App\Models\ContractorRegistration::class) ||
                            $user->can('viewAny', App\Models\ContractorHumanResource::class) ||
                            $user->can('viewAny', App\Models\ContractorMachinery::class) ||
                            $user->can('viewAny', App\Models\ContractorWorkExperience::class)
                        )
                        <a href="{{ route('admin.apps.contractors.index') }}" class="custom-app-tile custom-teal-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-person-vcard custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">Contractors</p>
                        </a>
                        @endif
                        
                        @if(
                            $user->can('viewAny', App\Models\ProvincialOwnReceipt::class) ||
                            $user->can('viewReports', App\Models\ProvincialOwnReceipt::class)
                        )
                        <a href="{{ route('admin.apps.service_cards.index') }}" class="custom-app-tile custom-orange-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-credit-card custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">Service Card</p>
                        </a>
                        @endif

                        @if(
                            $user->can('viewAny', App\Models\ProvincialOwnReceipt::class) ||
                            $user->can('viewReports', App\Models\ProvincialOwnReceipt::class)
                        )
                        <a href="{{ route('admin.apps.porms.index') }}" class="custom-app-tile custom-orange-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-coin custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">PORMS</p>
                        </a>
                        @endif

                        @if(
                            $user->can('viewAny', App\Models\Machinery::class) ||
                            $user->can('viewReports', App\Models\Machinery::class)
                        )
                        <a href="{{ route('admin.apps.machineries.index') }}" class="custom-app-tile custom-orange-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-building-gear custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">Machinery Mgt.</p>
                        </a>
                        @endcan

                        @if(
                            $user->can('viewAny', App\Models\Damage::class) ||
                            $user->can('viewAny', App\Models\Infrastructure::class) ||
                            $user->can('viewMainReport', App\Models\Damage::class) ||
                            $user->can('viewOfficerWiseReport', App\Models\Damage::class) ||
                            $user->can('viewDistrictWiseReport', App\Models\Damage::class) ||
                            $user->can('viewActiveOfficerReport', App\Models\Damage::class)
                        )
                        <a href="{{ route('admin.apps.dmis.dashboard') }}" class="custom-app-tile custom-orange-theme">
                            <div class="custom-app-icon-container">
                                <i class="bi-building-gear custom-app-icon"></i>
                            </div>
                            <p class="custom-app-name">Damage Mgt.</p>
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
                    @can('viewActivity', App\Models\Setting::class)
                    <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.activity.index') }}"><i class="bi-clock-history"></i>Activity Log</a>
                    @endcan
                    @canany(['updateCore', 'manageMainCategory', 'manageDistricts'], App\Models\Setting::class)
                    <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="#" onclick="event.preventDefault(); event.stopPropagation(); document.getElementById('collapseMenuItems').classList.toggle('show');">
                        <i class="bi-arrow-down-circle-fill"></i>Settings
                    </a>
                    <div class="collapse px-3" id="collapseMenuItems">
                        @can('updateCore', App\Models\Setting::class)
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.settings.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-gear-fill"></i>Core Settings
                        </a>
                        @endcan
                        @can('manageMainCategory', App\Models\Setting::class)
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.districts.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-geo-alt"></i>Districts
                        </a>
                        @endcan
                        @can('manageDistricts', App\Models\Setting::class)
                        <a class="dropdown-item d-flex align-items-center gap-2 py-1" href="{{ route('admin.categories.index') }}" onclick="event.stopPropagation();">
                            <i class="bi-list-nested"></i>Categories
                        </a>
                        @endcan
                    </div>
                    @endcanany
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
