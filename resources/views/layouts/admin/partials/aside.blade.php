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
            @canany(['view any user', 'view any seniority'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-people-fill text-warning"></i></div>
                    <div class="menu-title">User Management</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any user')
                    <li><a href="{{ route('admin.users.index') }}"><i class="bi-person-circle fs-6"></i>&nbsp; Users</a></li>
                    @endcan
                    @can('view any seniority')
                    <li><a href="{{ route('admin.seniority.index') }}"><i class="bi-graph-up-arrow fs-6"></i>&nbsp; Seniority</a></li>
                    @endcan
                    @can('view hierarchy')
                    <li><a href="{{ route('admin.users.hierarchy') }}"><i class="bi-person-circle fs-6"></i>&nbsp; Hierarchy</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
    
            @canany(['view any news', 'view any event', 'view any tender'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-megaphone text-primary"></i></div>
                    <div class="menu-title">Updates</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any news')
                    <li><a href="{{ route('admin.news.index') }}"><i class="bi-newspaper fs-6"></i>&nbsp; News</a></li>
                    @endcan
                    @can('view any event')
                    <li><a href="{{ route('admin.events.index') }}"><i class="bi-calendar2-event fs-6"></i>&nbsp; Events</a></li>
                    @endcan
                    @can('view any tender')
                    <li><a href="{{ route('admin.tenders.index') }}"><i class="bi-briefcase fs-6"></i>&nbsp; Tenders</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
    
            @canany(['view any slider', 'view any story', 'view any gallery'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-collection-play-fill text-success"></i></div>
                    <div class="menu-title">Media</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any slider')
                    <li><a href="{{ route('admin.sliders.index') }}"><i class="bi-images fs-6"></i>&nbsp; Sliders</a></li>
                    @endcan
                    @can('view any story')
                    <li><a href="{{ route('admin.stories.index') }}"><i class="bi-circle fs-6"></i>&nbsp; Stories</a></li>
                    @endcan
                    @can('view any gallery')
                    <li><a href="{{ route('admin.gallery.index') }}"><i class="bi-card-image fs-6"></i>&nbsp; Gallery</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
    
            @canany(['view any project', 'view project file', 'create development project'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-kanban text-primary"></i></div>
                    <div class="menu-title">Projects</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any project')
                    <li><a href="{{ route('admin.projects.index') }}"><i class="bi-kanban fs-6"></i>&nbsp; Projects</a></li>
                    @endcan
                    @can('view project file')
                    <li><a href="{{ route('admin.project_files.index') }}"><i class="bi-folder fs-6"></i>&nbsp; Project Files</a></li>
                    @endcan
                    @can('create development project')
                    <li><a href="{{ route('admin.development_projects.index') }}"><i class="bi-buildings fs-6"></i>&nbsp; Dev. Projects</a></li>
                    @endcan
                    @can('view any project')
                    <li><a href="{{ route('admin.schemes.index') }}"><i class="bi-building fs-6"></i>&nbsp; Schemes</a></li>
                    @endcan
                    @can('view any achievement')
                    <li><a href="{{ route('admin.achievements.index') }}"><i class="bi-building fs-6"></i>&nbsp; Achievements</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
    
            @canany(['view any page', 'create download'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-database text-success"></i></div>
                    <div class="menu-title">Site Content</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('view any page')
                    <li><a href="{{ route('admin.pages.index') }}"><i class="bi-file-earmark-plus fs-6"></i>&nbsp; Pages</a></li>
                    @endcan
                    @can('create download')
                    <li><a href="{{ route('admin.downloads.index') }}"><i class="bi-cloud-arrow-down fs-6"></i>&nbsp; Downloads</a></li>
                    @endcan
                </ul>
            </li>
            @endcanany
    
            @canany(['update comment', 'view any newsletter', 'view any public contact'])
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi-person-walking text-danger"></i></div>
                    <div class="menu-title">Public Dealings</div>
                </a>
                <ul class="p-2 menu-items">
                    @can('update comment')
                    <li><a href="{{ route('admin.comments.index') }}"><i class="bi-chat fs-6"></i>&nbsp; Comments</a></li>
                    @endcan
                    @can('view any newsletter')
                    <li><a href="{{ route('admin.newsletter.create_mass_email') }}"><i class="bi-send fs-6"></i>&nbsp; Send Email</a></li>
                    <li><a href="{{ route('admin.newsletter.index') }}"><i class="bi-envelope fs-6"></i>&nbsp; All Emails</a></li>
                    @endcan
                    @can('view any public contact')
                    <li><a href="{{ route('admin.public_contact.index') }}"><i class="bi-exclamation-triangle fs-6"></i>&nbsp; Queries</a></li>
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
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.activity.index') }}"><i class="bi-activity"></i>Activity Log</a></div>
                @endcan
                @can('view settings')
                    <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.settings.index') }}"><i class="bi-gear"></i>Settings</a></div>
                @endcan
                <div><a class="dropdown-item d-flex align-items-center gap-3 py-2" href="{{ route('admin.profile.edit') }}"><i class="bi-person-circle"></i>Edit Profile</a></div>
            </div>
        </div>

    </div>
</aside>
