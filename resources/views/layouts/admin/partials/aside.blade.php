<aside class="sidebar-wrapper">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="{{ asset('images/logo-square.png') }}" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">C&W Dept.</h5>
        </div>
        <div class="sidebar-close">
            <span class="bi-layout-sidebar"></span>
        </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">

        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-house"></i>
                    </div>
                    <div class="menu-title">Home</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}"><i class="bi-arrow-right-short"></i>Dashboard</a></li>
                    <li><a href="{{ route('admin.profile.edit') }}"><i class="bi-arrow-right-short"></i>Edit Profile</a></li>
                    <li><a href="{{ route('admin.logs') }}"><i class="bi-arrow-right-short"></i>Activity Log</a></li>
                    <li>
                        <a href="javascript:;" class="has-arrow">
                            <div class="parent-icon"><i class="bi-arrow-right-short"></i>
                            </div>
                            <div class="menu-title">Resources</div>
                        </a>
                        <ul>
                            <li><a class="has-arrow" href="javascript:;"><i class="bi-arrow-right-short"></i>Access Control</a>
                                <ul>
                                    <li>
                                        <a href="{{ route('admin.roles.index') }}"><i class="bi-arrow-right-short"></i>Roles</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.permissions.index') }}"><i class="bi-arrow-right-short"></i>Permissions</a>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{ route('admin.districts.index') }}"><i class="bi-arrow-right-short"></i>Districts</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.designations.index') }}"><i class="bi-arrow-right-short"></i>Designations</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.offices.index') }}"><i class="bi-arrow-right-short"></i>Offices</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.contractor_categories.index') }}"><i class="bi-arrow-right-short"></i>Contractor Categories</a>
                            </li>
                            <li>
                                <a href="{{ route('admin.provincial_entities.index') }}"><i class="bi-arrow-right-short"></i>Provincial Entities</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-person-circle"></i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.users.index') }}"><i class="bi-arrow-right-short"></i>List</a>
                    </li>
                    <li><a href="{{ route('admin.users.create') }}"><i class="bi-arrow-right-short"></i>Create</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-circle"></i>
                    </div>
                    <div class="menu-title">Stories</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.stories.index') }}"><i class="bi-arrow-right-short"></i>List</a>
                    </li>
                    <li><a href="{{ route('admin.stories.create') }}"><i class="bi-arrow-right-short"></i>Create</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-calendar3-week"></i>
                    </div>
                    <div class="menu-title">Registrations</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.registrations.index') }}"><i class="bi-arrow-right-short"></i>List</a>
                    </li>
                    <li><a href="{{ route('registrations.create') }}"><i class="bi-arrow-right-short"></i>Create</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-basket"></i>
                    </div>
                    <div class="menu-title">e-Standardization</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.standardizations.index') }}"><i class="bi-arrow-right-short"></i>List</a>
                    </li>
                    <li><a href="{{ route('standardizations.create') }}"><i class="bi-arrow-right-short"></i>Create</a>
                    </li>
                </ul>
            </li>
            <li class="menu-label">Others</li>
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="bi-three-dots"></i>
                    </div>
                    <div class="menu-title">Menu Levels</div>
                </a>
                <ul>
                    <li><a class="has-arrow" href="javascript:;"><i class="bi-arrow-right-short"></i>Level
                            One</a>
                        <ul>
                            <li><a class="has-arrow" href="javascript:;"><i class="bi-arrow-right-short"></i>Level
                                    Two</a>
                                <ul>
                                    <li><a href="javascript:;"><i class="bi-arrow-right-short"></i>Level Three</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascrpt:;">
                    <div class="parent-icon"><i class="bi-file-earmark-word"></i>
                    </div>
                    <div class="menu-title">Documentation</div>
                </a>
            </li>
            <li>
                <a href="javascrpt:;">
                    <div class="parent-icon"><i class="bi-exclamation-circle"></i>
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
                <i class="bi-question-circle"></i>
            </a>
            <div class="dropdown-menu dropdown-option dropdown-menu-end shadow">
                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;">Archive All</a></div>
                <div><a class="dropdown-item d-flex align-items-center gap-2 py-2" href="javascript:;">What's new</a></div>
            </div>
        </div>

    </div>
</aside>
