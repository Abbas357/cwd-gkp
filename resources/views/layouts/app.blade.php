@include('layouts.partials.admin.header')

<x-header :show-aside="$showAside">
    <x-slot name="breadcrumb">
        {{ $header ?? '' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="WEBSITE" app-url="{{ route('admin.home') }}">
    @canany(['view any news', 'view any event', 'view any tender', 'view any slider', 'view any story', 'view any gallery', 'view any seniority'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-megaphone text-primary"></i></div>
            <div class="menu-title">Updates</div>
        </a>
        <ul class="p-2 menu-items">
            @can('view any seniority')
            <li><a href="{{ route('admin.seniority.index') }}"><i class="bi-graph-up-arrow fs-6"></i>&nbsp; Seniority</a></li>
            @endcan
            @can('view any news')
            <li><a href="{{ route('admin.news.index') }}"><i class="bi-newspaper fs-6"></i>&nbsp; News</a></li>
            @endcan
            @can('view any event')
            <li><a href="{{ route('admin.events.index') }}"><i class="bi-calendar2-event fs-6"></i>&nbsp; Events</a></li>
            @endcan
            @can('view any tender')
            <li><a href="{{ route('admin.tenders.index') }}"><i class="bi-briefcase fs-6"></i>&nbsp; Tenders</a></li>
            @endcan
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

    @canany(['view any page', 'create download', 'view any card'])
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
            @can('view any card')
            <li><a href="{{ route('admin.cards.index') }}"><i class="bi-credit-card fs-6"></i>&nbsp; Cards</a></li>
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
</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="$settings->site_name" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
