<aside class="sidebar-wrapper">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ asset('images/logo-square.png') }}" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">C&W Dept.</h5>
        </div>
        <div class="sidebar-close">
            <span class="icon icon-sidebar"></span>
        </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">

        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li>
                <a href="{{ route('dashboard') }}">
                    <div class="parent-icon"><i class="icon icon-dashboard"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="icon icon-list"></i>
                    </div>
                    <div class="menu-title">Resources</div>
                </a>
                <ul>
                    <li><a href="{{ route('districts.index') }}"><i class="icon icon-arrow-right"></i>Districts</a>
                    </li>
                    <li><a href="{{ route('roles.index') }}"><i class="icon icon-arrow-right"></i>Roles</a>
                    </li>
                    <li><a href="{{ route('permissions.index') }}"><i class="icon icon-arrow-right"></i>Permissions</a>
                    </li>
                    <li><a href="{{ route('designations.index') }}"><i class="icon icon-arrow-right"></i>Designations</a>
                    </li>
                    <li><a href="{{ route('offices.index') }}"><i class="icon icon-arrow-right"></i>Offices</a>
                    </li>
                    <li><a href="{{ route('contractor_categories.index') }}"><i class="icon icon-arrow-right"></i>Contractor Categories</a>
                    </li>
                    <li><a href="{{ route('provincial_entities.index') }}"><i class="icon icon-arrow-right"></i>Provincial Entities</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="icon icon-user"></i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
                <ul>
                    <li><a href="{{ route('users.index') }}"><i class="icon icon-arrow-right"></i>List</a>
                    </li>
                    <li><a href="{{ route('users.create') }}"><i class="icon icon-arrow-right"></i>Create</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="icon icon-reg"></i>
                    </div>
                    <div class="menu-title">Registrations</div>
                </a>    
                <ul>
                    <li><a href="{{ route('registrations.index') }}"><i class="icon icon-arrow-right"></i>List</a>
                    </li>
                    <li><a href="{{ route('registrations.create') }}"><i class="icon icon-arrow-right"></i>Create</a>
                    </li>
                </ul>
            </li>
            <li class="menu-label">Others</li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="icon icon-menu"></i>
                    </div>
                    <div class="menu-title">Menu Levels</div>
                </a>
                <ul>
                    <li><a class="has-arrow" href="javascript:;"><i class="icon icon-arrow-right"></i>Level
                            One</a>
                        <ul>
                            <li><a class="has-arrow" href="javascript:;"><i class="icon icon-arrow-right"></i>Level
                                    Two</a>
                                <ul>
                                    <li><a href="javascript:;"><i class="icon icon-arrow-right"></i>Level Three</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascrpt:;">
                    <div class="parent-icon"><i class="icon icon-doc"></i>
                    </div>
                    <div class="menu-title">Documentation</div>
                </a>
            </li>
            <li>
                <a href="javascrpt:;">
                    <div class="parent-icon"><i class="icon icon-help"></i>
                    </div>
                    <div class="menu-title">Support</div>
                </a>
            </li>
        </ul>
        <!--end navigation-->
    </div>
    <div class="sidebar-bottom gap-4">
        <div class="dark-mode">
            <a href="javascript:;" class="footer-icon dark-mode-icon">
                <i class="icon icon-dark"></i>
            </a>
        </div>
        <div class="dropdown dropup-center dropup dropdown-help">
            <form method="POST" action="{{ route('logout') }}" disabled>
                @csrf
                <a class="footer-icon dropdown-toggle dropdown-toggle-nocaret option" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.preventDefault();
                    this.closest('form').submit();
                    this.closest('.top-right-menu').classList.add('hidden')">
                    <i class="icon icon-power-off"></i>
                </a>
            </form>
        </div>
        <div class="dropdown dropup-center dropup dropdown-help">
            <a class="footer-icon  dropdown-toggle dropdown-toggle-nocaret option" href="javascript:;" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon icon-help"></i>
            </a>
            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;">Archive All</a></div>
                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;">What's new</a></div>
            </div>
        </div>

    </div>
</aside>
