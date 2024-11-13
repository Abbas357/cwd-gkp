<aside class="sidebar-wrapper">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-header d-flex align-items-center">
        <div class="logo-icon">
            <img src="{{ asset('admin/images/logo-square.png') }}" style="width:40px; border-radius:5px" class="mt-2" alt="Logo Desktop">
        </div>
        <div class="logo-name flex-grow-1 mt-2">
            <h5 class="mb-0 fs-6 fw-bold" style="letter-spacing: .1px; transform: scale(1,1.4)">C&W DEPARTMENT</h5>
        </div>
        <div class="sidebar-close">
            <span class="bi-layout-sidebar"></span>
        </div>
    </a>
    <div class="sidebar-nav" data-simplebar="true">

        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-database"></i></div>
                    <div class="menu-title">Core</div>
                </a>
                <ul class="px-2">
                    <li><a href="{{ route('admin.users.index') }}"><i class="bi-person-circle fs-6"></i>&nbsp; Users</a></li>
                    <li><a href="{{ route('admin.pages.index') }}"><i class="bi-file-earmark-plus fs-6"></i>&nbsp; Pages</a></li>
                    <li><a href="{{ route('admin.sliders.index') }}"><i class="bi-images fs-6"></i>&nbsp; Sliders</a></li>
                    <li><a href="{{ route('admin.stories.index') }}"><i class="bi-circle fs-6"></i>&nbsp; Stories</a></li>
                    <li><a href="{{ route('admin.downloads.index') }}"><i class="bi-cloud-arrow-down fs-6"></i>&nbsp; Downloads</a></li>
                    <li><a href="{{ route('admin.gallery.index') }}"><i class="bi-card-image fs-6"></i>&nbsp; Gallery</a></li>
                    <li><a href="{{ route('admin.news.index') }}"><i class="bi-newspaper fs-6"></i>&nbsp; News</a></li>
                    <li><a href="{{ route('admin.projects.index') }}"><i class="bi-kanban fs-6"></i>&nbsp; Projects</a></li>
                    <li><a href="{{ route('admin.project_files.index') }}"><i class="bi-folder fs-6"></i>&nbsp; Project Files</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-calendar3-week"></i></div>
                    <div class="menu-title">Modules</div>
                </a>
                <ul class="px-2">
                    <li><a href="{{ route('admin.users.cards') }}"><i class="bi-arrow-right-short fs-6"></i>&nbsp; Service Card</a></li>
                    <li><a href="{{ route('admin.registrations.index') }}"><i class="bi-arrow-right-short fs-6"></i>&nbsp; E-Registration</a></li>
                    <li><a href="{{ route('admin.standardizations.index') }}"><i class="bi-arrow-right-short fs-6"></i>&nbsp; E-Standardization</a></li>
                </ul>
            </li>
            <li class="menu-label">Others</li>
            <li class="px-2">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-collection"></i></div>
                    <div class="menu-title">Collections</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.districts.index') }}"><i class="bi-arrow-right-short fs-6"></i>&nbsp; Districts</a></li>
                    <li><a href="{{ route('admin.categories.index') }}"><i class="bi-arrow-right-short fs-6"></i>&nbsp; Categories</a></li>
                    <li><a href="{{ route('admin.roles.index') }}"><i class="bi-arrow-right-short fs-6"></i>&nbsp; Roles</a></li>
                    <li><a href="{{ route('admin.permissions.index') }}"><i class="bi-arrow-right-short fs-6"></i>&nbsp; Permissions</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-megaphone"></i></div>
                    <div class="menu-title">Public Dealings</div>
                </a>
                <ul class="px-2">
                    <li><a href="{{ route('admin.newsletter.create_mass_email') }}"><i class="bi-send fs-6"></i>&nbsp; Send Email</a></li>
                    <li><a href="{{ route('admin.newsletter.index') }}"><i class="bi-envelope fs-6"></i>&nbsp; All Emails</a></li>
                    <li><a href="{{ route('admin.public_contact.index') }}"><i class="bi-exclamation-triangle fs-6"></i>&nbsp; Queries</a></li>
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
