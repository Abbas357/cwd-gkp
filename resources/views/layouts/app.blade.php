@include('layouts.partials.admin.header')

<x-header :show-aside="$showAside">
    <x-slot name="breadcrumb">
        {{ $header ?? '' }}
    </x-slot>
</x-header>

@if ($showAside)
@php
    $user = auth()->user();
@endphp
<x-sidebar app-name="WEB PORTAL" app-url="{{ route('admin.home') }}">
    @if(
        $user->can('viewAny', App\Models\News::class) ||
        $user->can('viewAny', App\Models\Event::class) ||
        $user->can('viewAny', App\Models\Tender::class) ||
        $user->can('viewAny', App\Models\Seniority::class)
    )
        <li class="menu-label">Core</li>

        @can('viewAny', App\Models\News::class)
        <li>
            <a href="{{ route('admin.news.index') }}">
                <div class="parent-icon"><i class="bi-newspaper text-info"></i>
                </div>
                <div class="menu-title">News</div>
            </a>
        </li>
        @endcan

        @can('viewAny', App\Models\Event::class)
        <li>
            <a href="{{ route('admin.events.index') }}">
                <div class="parent-icon"><i class="bi-calendar2-event text-primary"></i>
                </div>
                <div class="menu-title">Events</div>
            </a>
        </li>
        @endcan

        @can('viewAny', App\Models\Tender::class)
        <li>
            <a href="{{ route('admin.tenders.index') }}">
                <div class="parent-icon"><i class="bi-briefcase text-warning"></i>
                </div>
                <div class="menu-title">Tenders</div>
            </a>
        </li>
        @endcan

        @can('viewAny', App\Models\Seniority::class)
        <li>
            <a href="{{ route('admin.seniority.index') }}">
                <div class="parent-icon"><i class="bi-graph-up-arrow text-success"></i>
                </div>
                <div class="menu-title">Seniority</div>
            </a>
        </li>
        @endcan
    @endif

    @if(
        $user->can('viewAny', App\Models\Gallery::class) ||
        $user->can('viewAny', App\Models\Slider::class) ||
        $user->can('viewAny', App\Models\Story::class)
    )
    <li class="menu-label ms-1">Site Content</li>
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-image-alt text-success"></i></div>
            <div class="menu-title">Media</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('viewAny', App\Models\Gallery::class)
            <li><a href="{{ route('admin.gallery.index') }}"><i class="bi-images"></i>Gallery</a></li>
            @endcan
            @can('viewAny', App\Models\Slider::class)
            <li><a href="{{ route('admin.sliders.index') }}"><i class="bi-card-image"></i>Sliders</a></li>
            @endcan
            @can('viewAny', App\Models\Story::class)
            <li><a href="{{ route('admin.stories.index') }}"><i class="bi-circle"></i>Stories</a></li>
            @endcan
        </ul>
    </li>
    @endif

    @if(
        $user->can('viewAny', App\Models\Page::class) ||
        $user->can('viewAny', App\Models\Download::class)
    )
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-database text-success"></i></div>
            <div class="menu-title">Site Content</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('viewAny', App\Models\Page::class)
            <li><a href="{{ route('admin.pages.index') }}"><i class="bi-file-earmark-plus"></i>Pages</a></li>
            @endcan
            @can('viewAny', App\Models\Download::class)
            <li><a href="{{ route('admin.downloads.index') }}"><i class="bi-cloud-arrow-down"></i>Downloads</a></li>
            @endcan
        </ul>
    </li>
    @endif

    @if(
        $user->can('viewAny', App\Models\Project::class) ||
        $user->can('viewAny', App\Models\ProjectFile::class) ||
        $user->can('viewAny', App\Models\DevelopmentProject::class) ||
        $user->can('viewAny', App\Models\Scheme::class) 
    )
    <li>
        <a class="has-arrow" href="javascript:;">
            <div class="parent-icon"><i class="bi-kanban text-primary"></i>
            </div>
            <div class="menu-title">Projects</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            <li><a class="has-arrow" href="javascript:;"><i class="bi-globe"></i> Foreign Funded</a>
                <ul class="px-2 py-1 menu-items">
                    @can('viewAny', App\Models\Project::class)
                    <li><a href="{{ route('admin.projects.index') }}"><i class="bi-kanban"></i> Projects</a></li>
                    @endcan
                    @can('viewAny', App\Models\ProjectFile::class)
                    <li><a href="{{ route('admin.project_files.index') }}"><i class="bi-folder"></i>Files</a></li>
                    @endcan
                </ul>
            </li>
            @can('viewAny', App\Models\DevelopmentProject::class)
            <li><a href="{{ route('admin.development_projects.index') }}"><i class="bi-clipboard-check"></i>Developmental</a></li>
            @endcan
            @can('viewAny', App\Models\Scheme::class)
            <li><a href="{{ route('admin.schemes.index') }}"><i class="bi-gear-wide-connected"></i> Schemes</a></li>
            @endcan
        </ul>
    </li>
    @endif

    @can('viewAny', App\Models\Achievement::class)
    <li>
        <a href="{{ route('admin.achievements.index') }}">
            <div class="parent-icon"><i class="bi-building"></i>
            </div>
            <div class="menu-title">Achievements</div>
        </a>
    </li>
    @endcan

    @if(
        $user->can('viewAny', App\Models\Comment::class) ||
        $user->can('viewAny', App\Models\PublicContact::class) ||
        $user->can('viewAny', App\Models\NewsLetter::class) ||
        $user->can('massEmail', App\Models\NewsLetter::class)
    )
    <li class="menu-label ms-1">Others</li>
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-person-walking text-danger"></i></div>
            <div class="menu-title">Feedback</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('viewAny', App\Models\Comment::class)
            <li><a href="{{ route('admin.comments.index') }}"><i class="bi-chat"></i>Comments</a></li>
            @endcan
            @can('viewAny', App\Models\PublicContact::class)
            <li><a href="{{ route('admin.public_contact.index') }}"><i class="bi-exclamation-triangle"></i>Queries</a></li>
            @endcan
        </ul>
    </li>
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-envelope text-info"></i></div>
            <div class="menu-title">Newsletter</div>
        </a>
        <ul class="px-2 py-1 menu-items">
            @can('massEmail', App\Models\NewsLetter::class)
                <li><a href="{{ route('admin.newsletter.create_mass_email') }}"><i class="bi-send"></i>Send Email</a></li>
            @endcan
            @can('viewAny', App\Models\NewsLetter::class)
                <li><a href="{{ route('admin.newsletter.index') }}"><i class="bi-envelope"></i>All Emails</a></li>
            @endcan
        </ul>
    </li>
    @endif

</x-sidebar>

@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
