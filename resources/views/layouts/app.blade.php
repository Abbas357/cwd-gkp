@include('layouts.partials.admin.header')

<x-header :show-aside="$showAside">
    <x-slot name="breadcrumb">
        {{ $header ?? '' }}
    </x-slot>
</x-header>

@if ($showAside)

<x-sidebar app-name="WEBSITE" app-url="{{ route('admin.home') }}">
    <li class="menu-label">Core</li>

    @canany(['view any news', 'view any event', 'view any tender', 'view any seniority'])

    @can('view any news')
    <li>
        <a href="{{ route('admin.news.index') }}">
            <div class="parent-icon"><i class="bi-newspaper text-info"></i>
            </div>
            <div class="menu-title">News</div>
        </a>
    </li>
    @endcan

    @can('view any event')
    <li>
        <a href="{{ route('admin.events.index') }}">
            <div class="parent-icon"><i class="bi-calendar2-event text-primary"></i>
            </div>
            <div class="menu-title">Events</div>
        </a>
    </li>
    @endcan

    @can('view any tender')
    <li>
        <a href="{{ route('admin.tenders.index') }}">
            <div class="parent-icon"><i class="bi-briefcase text-warning"></i>
            </div>
            <div class="menu-title">Tenders</div>
        </a>
    </li>
    @endcan

    @can('view any seniority')
    <li>
        <a href="{{ route('admin.seniority.index') }}">
            <div class="parent-icon"><i class="bi-graph-up-arrow text-success"></i>
            </div>
            <div class="menu-title">Seniority</div>
        </a>
    </li>
    @endcan

    @endcanany

    <li class="menu-label ms-1">Site Content</li>

    @canany(['view any gallery', 'view any slider', 'view any story'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-image-alt text-success"></i></div>
            <div class="menu-title">Media</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('view any gallery')
            <li><a href="{{ route('admin.gallery.index') }}"><i class="bi-images"></i>Gallery</a></li>
            @endcan
            @can('view any slider')
            <li><a href="{{ route('admin.sliders.index') }}"><i class="bi-card-image"></i>Sliders</a></li>
            @endcan
            @can('view any story')
            <li><a href="{{ route('admin.stories.index') }}"><i class="bi-circle"></i>Stories</a></li>
            @endcan
        </ul>
    </li>
    @endcanany

    @canany(['view any page', 'create download', 'view any card'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-database text-success"></i></div>
            <div class="menu-title">Site Content</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('view any page')
            <li><a href="{{ route('admin.pages.index') }}"><i class="bi-file-earmark-plus"></i>Pages</a></li>
            @endcan
            @can('create download')
            <li><a href="{{ route('admin.downloads.index') }}"><i class="bi-cloud-arrow-down"></i>Downloads</a></li>
            @endcan
            @can('view any card')
            <li><a href="{{ route('admin.cards.index') }}"><i class="bi-credit-card"></i>Cards</a></li>
            @endcan
        </ul>
    </li>
    @endcanany

    @canany(['view any project', 'view project file', 'create development project'])
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class="bi-kanban text-primary"></i>
            </div>
            <div class="menu-title">Projects</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            <li><a class="has-arrow" href="javascript:;"><i class="bi-globe"></i> Foreign Funded</a>
                <ul class="px-2 py-1 menu-items">
                    @can('view any project')
                    <li><a href="{{ route('admin.projects.index') }}"><i class="bi-kanban"></i> Projects</a></li>
                    @endcan
                    @can('view project file')
                    <li><a href="{{ route('admin.project_files.index') }}"><i class="bi-folder"></i>Files</a></li>
                    @endcan
                </ul>
            </li>
            @can('create development project')
            <li><a href="{{ route('admin.development_projects.index') }}"><i class="bi-clipboard-check"></i>Developmental</a></li>
            @endcan
            @can('view any scheme')
            <li><a href="{{ route('admin.schemes.index') }}"><i class="bi-gear-wide-connected"></i> Schemes</a></li>
            @endcan
        </ul>
    </li>
    @endcanany

    @can('view any achievement')
    <li>
        <a href="{{ route('admin.achievements.index') }}">
            <div class="parent-icon"><i class="bi-building"></i>
            </div>
            <div class="menu-title">Achievements</div>
        </a>
    </li>
    @endcan

    <li class="menu-label ms-1">Others</li>

    @canany(['update comment', 'view any newsletter', 'view any public contact'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-person-walking text-danger"></i></div>
            <div class="menu-title">Feedback</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('update comment')
            <li><a href="{{ route('admin.comments.index') }}"><i class="bi-chat"></i>Comments</a></li>
            @endcan
            @can('view any public contact')
            <li><a href="{{ route('admin.public_contact.index') }}"><i class="bi-exclamation-triangle"></i>Queries</a></li>
            @endcan
        </ul>
    </li>
    @endcanany

    @canany(['view any newsletter'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-envelope text-info"></i></div>
            <div class="menu-title">Newsletter</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('view any newsletter')
            <li><a href="{{ route('admin.newsletter.create_mass_email') }}"><i class="bi-send"></i>Send Email</a></li>
            <li><a href="{{ route('admin.newsletter.index') }}"><i class="bi-envelope"></i>All Emails</a></li>
            @endcan
        </ul>
    </li>
    @endcanany

</x-sidebar>

@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
