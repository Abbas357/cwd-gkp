<aside class="sidebar-wrapper">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="logo-icon">
            <img src="{{ asset('admin/images/logo.png') }}" style="width:190px; border-radius:5px" class="mt-2" alt="Logo Desktop">
        </a>
        <div class="sidebar-close">
            <span class="bi-layout-sidebar"></span>
        </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">

        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-person-circle"></i></div>
                    <div class="menu-title">Users</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.users.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                    <li><a href="{{ route('admin.users.create') }}"><i class="bi-arrow-right-short"></i>Create</a></li>
                    <li><a href="{{ route('admin.roles.index') }}"><i class="bi-arrow-right-short"></i>Roles</a></li>
                    <li><a href="{{ route('admin.permissions.index') }}"><i class="bi-arrow-right-short"></i>Permissions</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-file-earmark-plus"></i></div>
                    <div class="menu-title">Pages</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.pages.create') }}"><i class="bi-arrow-right-short"></i>Create</a></li>
                    <li><a href="{{ route('admin.pages.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-images"></i></div>
                    <div class="menu-title">Sliders</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.sliders.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                    <li><a href="{{ route('admin.sliders.create') }}"><i class="bi-arrow-right-short"></i>Create</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-circle"></i></div>
                    <div class="menu-title">Stories</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.stories.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                    <li><a href="{{ route('admin.stories.create') }}"><i class="bi-arrow-right-short"></i>Create</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-calendar3-week"></i></div>
                    <div class="menu-title">Online Apply</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.registrations.index') }}"><i class="bi-arrow-right-short"></i>E-Registration</a></li>
                    <li><a href="{{ route('admin.standardizations.index') }}"><i class="bi-arrow-right-short"></i>E-Standardization</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-cloud-arrow-down"></i></div>
                    <div class="menu-title">Downloads</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.downloads.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                    <li><a href="{{ route('admin.downloads.create') }}"><i class="bi-arrow-right-short"></i>Create</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-card-image"></i></div>
                    <div class="menu-title">Gallery</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.gallery.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                    <li><a href="{{ route('admin.gallery.create') }}"><i class="bi-arrow-right-short"></i>Create</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-newspaper"></i></div>
                    <div class="menu-title">News</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.news.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                    <li><a href="{{ route('admin.news.create') }}"><i class="bi-arrow-right-short"></i>Create</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-kanban"></i></div>
                    <div class="menu-title">Projects</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.projects.index') }}" class="{{ Request::routeIs('admin.projects.index') ? 'active' : '' }}">
                            <i class="bi-arrow-right-short"></i>List</a>
                    </li>
                    <li><a href="{{ route('admin.projects.create') }}" class="{{ Request::routeIs('admin.projects.create') ? 'active' : '' }}">
                            <i class="bi-arrow-right-short"></i>Create</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-folder"></i></div>
                    <div class="menu-title">Project Files</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.project_files.index') }}" class="{{ Request::routeIs('admin.project_files.index') ? 'active' : '' }}">
                            <i class="bi-arrow-right-short"></i>List</a>
                    </li>
                    <li><a href="{{ route('admin.project_files.create') }}" class="{{ Request::routeIs('admin.project_files.create') ? 'active' : '' }}">
                            <i class="bi-arrow-right-short"></i>Create</a>
                    </li>
                </ul>
            </li>

            <li class="menu-label">Others</li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-collection"></i></div>
                    <div class="menu-title">Collections</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.districts.index') }}"><i class="bi-arrow-right-short"></i>Districts</a></li>
                    <li><a href="{{ route('admin.categories.index') }}"><i class="bi-arrow-right-short"></i>Categories</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-megaphone"></i></div>
                    <div class="menu-title">Newsletter</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.newsletter.create_mass_email') }}"><i class="bi-arrow-right-short"></i>Send Email</a></li>
                    <li><a href="{{ route('admin.newsletter.index') }}"><i class="bi-arrow-right-short"></i>All Emails</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-exclamation-triangle"></i></div>
                    <div class="menu-title">Public Queries</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.public_contact.index') }}"><i class="bi-arrow-right-short"></i>List</a></li>
                </ul>
            </li>
            {{-- <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class="bi-three-dots"></i></div>
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
            </li> --}}
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
                <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.logs') }}"><i class="bi-activity"></i>Activity Log</a></div>
                <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.settings.index') }}"><i class="bi-gear"></i>Settings</a></div>
                <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.profile.edit') }}"><i class="bi-person-circle"></i>Edit Profile</a></div>
            </div>
        </div>

    </div>
</aside>
