<aside class="sidebar-wrapper">
    <a href="{{ route('admin.apps') }}" class="sidebar-header d-flex align-items-center">
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
            @can('view any vehicle')
            <li><a href="{{ route('admin.settings.index') }}"><i class="bi-bus-front text-info"></i>&nbsp; Home</a></li>
            @endcan

            @can('view any vehicle')
            <li><a href="{{ route('admin.apps.vehicles.all') }}"><i class="bi-speedometer text-success"></i>&nbsp; Vehicles</a></li>
            @endcan

            @can('view any vehicle')
            <li><a href="{{ route('admin.apps.vehicles.reports') }}"><i class="bi-flag text-info"></i>&nbsp; Reports</a></li>
            @endcan
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
