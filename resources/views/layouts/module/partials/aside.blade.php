<aside class="sidebar-wrapper">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-header d-flex align-items-center">
        <div class="logo-icon">
            <img src="{{ asset('admin/images/logo-square.png') }}" style="width:40px; border-radius:5px" class="mt-2" alt="Logo Desktop">
        </div>
        <div class="logo-name flex-grow-1 mt-2">
            <h5 class="mb-0 fs-6 fw-bold gradient-text" style="letter-spacing: .1px; transform: scale(1,1.4)">
                C&W DEPARTMENT
            </h5>
        </div>
        <div class="sidebar-close">
            <span class="bi-layout-sidebar"></span>
        </div>
    </a>
    <div class="sidebar-nav" data-simplebar="true">
        <ul class="metismenu" id="sidenav">
       
            @can('view any cards')
            <li><a href="{{ route('module.cards.index') }}"><i class="bi-credit-card"></i>&nbsp; All Cards</a></li>
            @endcan

            @canany(['view any service card'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-credit-card text-success"></i></div>
                    <div class="menu-title">Service Card</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any service card')
                    <li><a href="{{ route('module.service_cards.index') }}"><i class="bi-list-nested fs-6"></i>&nbsp; List</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['view any contractor'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-person-vcard text-warning"></i></div>
                    <div class="menu-title">Contractors</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any contractor')
                    <li><a href="{{ route('module.contractors.index') }}"><i class="bi-list-nested fs-6"></i>&nbsp;Contractor List</a></li>
                    @endcan
                    @can('view any contractor')
                    <li><a href="{{ route('module.contractors.registration.index') }}"><i class="bi-list-nested fs-6"></i>&nbsp; Registration List</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['view any standardization'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-patch-check-fill text-info"></i></div>
                    <div class="menu-title">Standardization</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any standardization')
                    <li><a href="{{ route('module.standardizations.index') }}"><i class="bi-list-nested fs-6"></i>&nbsp; List</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
            @canany(['view any vehicle'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-bus-front text-primary"></i></div>
                    <div class="menu-title">Vehicle Management</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any vehicle')
                    <li><a href="{{ route('module.vehicles.dashboard') }}"><i class="bi-list-nested fs-6"></i>&nbsp; Dashboard</a></li>
                    @endcan
                    @can('view any vehicle')
                    <li><a href="{{ route('module.vehicles.index') }}"><i class="bi-list-nested fs-6"></i>&nbsp; Vehicles</a></li>
                    @endcan
                    @can('view any vehicle')
                    <li><a href="{{ route('module.vehicles.reports') }}"><i class="bi-list-nested fs-6"></i>&nbsp; Reports</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
    
        </ul>
    </div>
    <div class="sidebar-bottom gap-4">
        <div class="dark-mode">
            <a href="javascript:;" class="footer-icon dark-mode-icon">
                <i class="bi-moon"></i>
            </a>
        </div>
        <div class="dropdown dropup-center dropup dropdown-help">
            <form method="POST" action="{{ route('logout') }}" disabled>
                @csrf
                <a class="footer-icon dropdown-toggle dropdown-toggle-nocaret option" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.preventDefault();
                    this.closest('form').submit();
                    this.closest('.top-right-menu').classList.add('hidden')">
                    <i class="bi-power" style="font-size: var(--size-5)"></i>
                </a>
            </form>
        </div>
        <div class="dropdown dropup-center dropup dropdown-help">
            <a class="footer-icon  dropdown-toggle dropdown-toggle-nocaret option" href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi-sliders"></i>
            </a>
            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                @can('view activity')
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.logs') }}"><i class="bi-activity"></i>Activity Log</a></div>
                @endcan
                @can('view settings')
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.settings.index') }}"><i class="bi-gear"></i>Settings</a></div>
                @endcan
                <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.profile.edit') }}"><i class="bi-person-circle"></i>Edit Profile</a></div>
            </div>
        </div>

    </div>
</aside>
