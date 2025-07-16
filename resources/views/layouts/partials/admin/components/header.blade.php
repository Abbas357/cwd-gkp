<style>
    .user-info {
        background: #F5F5F5;
        padding: 8px 16px;
        border-radius: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid #fff;
    }

    .user-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .user-name-office {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: right;
    }

    .user-name {
        color: #333;
        font-weight: 600;
        font-size: 14px;
        line-height: 1.2;
        margin-bottom: 2px;
    }

    .office-name {
        color: #333;
        font-size: 12px;
        font-weight: 400;
        line-height: 1.2;
    }

    .profile-oval {
        width: 50px;
        height: 50px;
        background: #F5F5F5;
        color: #000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        padding: 3px;
    }

    .profile-oval:hover {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .profile-image {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }

    .small-screen-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 8px 16px;
        border-radius: 20px;
        display: inline-block;
        margin-top: 8px;
    }

    .user-name-small {
        color: white;
        font-weight: 600;
        font-size: 13px;
        display: block;
        line-height: 1.2;
    }

    .office-name-small {
        color: rgba(255, 255, 255, 0.85);
        font-size: 11px;
        font-weight: 400;
        display: block;
        line-height: 1.2;
        margin-top: 2px;
    }


    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .profile-oval {
            width: 45px;
            height: 45px;
        }

        .profile-image {
            width: 39px;
            height: 39px;
        }
    }
</style>
<header {{ $attributes->merge(['class' => 'top-header']) }}>
    <nav class="navbar navbar-expand align-items-center gap-2" style="{{ !$showAside ? 'left: 0;' : '' }}">
        <div class="d-flex flex-grow-1 justify-content-between align-items-center">
            <div class="d-flex flex-start align-items-center gap-3">
                @if ($showAside)
                    <div class="btn-toggle user-select-none cursor-pointer">
                        <i class="bi-three-dots-vertical"></i>
                    </div>
                @else
                    <a href="{{ route('admin.apps') }}" class="logo-icon">
                        <img src="{{ asset('admin/images/logo-square.png') }}" style="width:50px; border-radius:5px"
                            alt="Logo">
                    </a>
                @endif
                @if (isset($breadcrumb) && $breadcrumb->isNotEmpty())
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center bg-light px-2 shadow-sm">
                        <div class="breadcrumb-title pe-2"><a href="{{ route('admin.apps') }}">Home</a></div> <span
                            class="fs-5">/</span>
                        <div class="ps-2">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    {{ $breadcrumb }}
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <a href="/" class="d-none d-md-block px-2 py-0 bg-light border shadow-sm" target="_blank"><i
                            class="bi-box-arrow-up-right"></i> View</a>
                @endif
            </div>
            <div class="search-bar" style="max-width: 500px; flex-grow: 1">
                <div class="position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 d-lg-block d-none"><i
                                class="bi bi-search"></i></span>
                        <input type="text"
                            class="form-control border-0 bg-light admin-search search-control d-lg-block d-none"
                            placeholder="Search...">
                    </div>
                    <div class="search-popup">
                        <div class="card overflow-hidden">
                            <div class="card-header d-lg-none">
                                <div class="input-group position-relative">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                                    <input type="text"
                                        class="form-control border-0 bg-light admin-search mobile-search-control"
                                        placeholder="Search...">
                                </div>
                            </div>
                            <div class="card-body search-content">
                                <p class="search-title">Recent Searches</p>
                                <div class="d-flex align-items-start flex-wrap gap-2 kewords-wrapper">
                                    <a href="javascript:;" class="kewords"><span>E-Bidding</span><i
                                            class="bi-search"></i></a>
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
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-auto-close="outside"
                    data-bs-toggle="dropdown" href="javascript:;">
                    <i class="bi-grid-3x3-gap-fill"></i>
                </a>
                <div class="border dropdown-menu dropdown-menu-end custom-app-dropdown-menu shadow-lg">
                    <h6 class="dropdown-header text-center mb-2">Apps</h6>
                    @php
                        $user = auth()->user();
                    @endphp
                    <div class="custom-app-grid">
                        @if (
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
                                $user->can('massEmail', App\Models\NewsLetter::class))
                            <a href="{{ route('admin.home') }}" class="custom-app-tile custom-purple-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-globe custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">Website</p>
                            </a>
                        @endif

                        @if (
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
                                $user->can('viewOrganogram', App\Models\office::class))
                            <a href="{{ route('admin.apps.vehicles.index') }}" class="custom-app-tile custom-red-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-people custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">HRMIS</p>
                            </a>
                        @endif

                        @if ($user->can('viewAny', App\Models\Vehicle::class) || $user->can('viewReports', App\Models\Vehicle::class))
                            <a href="{{ route('admin.apps.vehicles.index') }}" class="custom-app-tile custom-red-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-bus-front custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">Vehicle Mgt.</p>
                            </a>
                        @endif

                        @if ($user->can('viewAny', App\Models\Standardization::class) || $user->can('viewAny', App\Models\Product::class))
                            <a href="{{ route('admin.apps.standardizations.index') }}"
                                class="custom-app-tile custom-green-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-patch-check-fill custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">Standard</p>
                            </a>
                        @endif

                        @if (
                            $user->can('viewAny', App\Models\Contractor::class) ||
                                $user->can('viewAny', App\Models\ContractorRegistration::class) ||
                                $user->can('viewAny', App\Models\ContractorHumanResource::class) ||
                                $user->can('viewAny', App\Models\ContractorMachinery::class) ||
                                $user->can('viewAny', App\Models\ContractorWorkExperience::class))
                            <a href="{{ route('admin.apps.contractors.index') }}"
                                class="custom-app-tile custom-teal-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-person-vcard custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">Contractors</p>
                            </a>
                        @endif

                        @if (
                            $user->can('viewAny', App\Models\ProvincialOwnReceipt::class) ||
                                $user->can('viewReports', App\Models\ProvincialOwnReceipt::class))
                            <a href="{{ route('admin.apps.service_cards.index') }}"
                                class="custom-app-tile custom-orange-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-credit-card custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">Service Card</p>
                            </a>
                        @endif

                        @if (
                            $user->can('viewAny', App\Models\ProvincialOwnReceipt::class) ||
                                $user->can('viewReports', App\Models\ProvincialOwnReceipt::class))
                            <a href="{{ route('admin.apps.porms.index') }}"
                                class="custom-app-tile custom-orange-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-coin custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">PORMS</p>
                            </a>
                        @endif

                        @if ($user->can('viewAny', App\Models\Machinery::class) || $user->can('viewReports', App\Models\Machinery::class))
                            <a href="{{ route('admin.apps.machineries.index') }}"
                                class="custom-app-tile custom-orange-theme">
                                <div class="custom-app-icon-container">
                                    <i class="bi-building-gear custom-app-icon"></i>
                                </div>
                                <p class="custom-app-name">Machinery Mgt.</p>
                            </a>
                        @endcan

                        @if (
                            $user->can('viewAny', App\Models\Damage::class) ||
                                $user->can('viewAny', App\Models\Infrastructure::class) ||
                                $user->can('viewMainReport', App\Models\Damage::class) ||
                                $user->can('viewOfficerWiseReport', App\Models\Damage::class) ||
                                $user->can('viewDistrictWiseReport', App\Models\Damage::class) ||
                                $user->can('viewActiveOfficerReport', App\Models\Damage::class))
                            <a href="{{ route('admin.apps.dmis.dashboard') }}"
                                class="custom-app-tile custom-orange-theme">
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
        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative"
            data-bs-auto-close="outside" data-bs-toggle="dropdown" href="javascript:;">
            <i class="bi-bell"></i>
            <span class="badge-notify"></span>
        </a>
        <div class="dropdown-menu border dropdown-notify dropdown-menu-end shadow" style="overflow:hidden">
            <div class="px-3 py-1 d-flex align-items-center justify-content-between border-bottom">
                <h5 class="notiy-title mb-0">Notifications</h5>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle dropdown-toggle-nocaret option"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="bi-three-dots-vertical"></span>
                    </button>
                    <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                        <div><a class="dropdown-item d-flex align-items-center gap-2 py-1"
                                href="javascript:;">Mark all as read</a></div>
                        <div><a class="dropdown-item d-flex align-items-center gap-2 py-1"
                                href="javascript:;">Archive</a></div>
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
        <!-- Profile container with oval design -->
        <a href="javascript:;"
            class="dropdown-toggle dropdown-toggle-nocaret profile-container d-flex align-items-center"
            data-bs-toggle="dropdown">
            <!-- User info (hidden on small screens) -->
            <div class="user-info d-none d-lg-block">
                <div class="user-name-office">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="office-name">{{ auth()->user()->currentOffice->name }}</span>
                </div>
            </div>

            <!-- Profile picture -->
            <div class="profile-oval">
                <img src="{{ getProfilePic(auth()->user()) }}" class="profile-image" alt="Profile">
            </div>
        </a>

        <!-- Dropdown menu -->
        <div class="dropdown-menu border dropdown-user dropdown-menu-end shadow"
            style="max-height: 85vh; overflow-y: auto;">
            <div class="dropdown-profile-header">
                <div class="text-center mb-3">
                    <img src="{{ getProfilePic(auth()->user()) }}" class="rounded-circle p-1 shadow mb-2"
                        width="80" height="80" alt="">
                    <h6 class="user-name mb-0 fw-bold">{{ auth()->user()->designation }}</h6>
                    <!-- User info for small screens -->
                    <div class="d-lg-none mt-2">
                        <div class="small-screen-info">
                            <span class="user-name-small">{{ auth()->user()->name }}</span>
                            <span class="office-name-small">{{ auth()->user()->currentOffice->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="dropdown-divider">

            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                href="{{ route('admin.settings.profile.edit') }}">
                <i class="bi-person-circle"></i>Profile
            </a>

            @can('viewActivity', App\Models\Setting::class)
                <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                    href="{{ route('admin.settings.activity.index') }}">
                    <i class="bi-clock-history"></i>Activity Log
                </a>
            @endcan

            @can('updateCore', App\Models\Setting::class)
                <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                    href="{{ route('admin.settings.core.index') }}">
                    <i class="bi-gear-fill"></i>Settings
                </a>
            @endcan

            <hr class="dropdown-divider">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a class="dropdown-item d-flex align-items-center cursor-pointer gap-2 py-2"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="bi-power"></i>Logout
                </a>
            </form>
        </div>
    </li>
</ul>
</nav>
<script>
    var linksURL = "{{ route('admin.settings.search.links') }}";
    var activityURL = "{{ route('admin.settings.activity.notifications') }}";
</script>
</header>
