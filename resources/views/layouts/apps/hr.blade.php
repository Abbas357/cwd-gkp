@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'HR' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="HRMIS" app-url="{{ route('admin.apps.hr.index') }}">

    @can('view hr dashboard')
    <li>
        <a href="{{ route('admin.apps.hr.index') }}">
            <div class="parent-icon"><i class="bi-house-door-fill text-primary"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('view any user')
    <li>
        <a href="{{ route('admin.apps.hr.users.index') }}">
            <div class="parent-icon"><i class="bi-person-badge text-success"></i></div>
            <div class="menu-title">Users</div>
        </a>
    </li>
    @endcan

    @canany(['view organization chart', 'view organogram'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-bar-chart-line text-primary"></i></div>
            <div class="menu-title">Stats</div>
        </a>
        <ul class="p-2 menu-items">
            @can('view organization chart')
            <li>
                <a href="{{ route('admin.apps.hr.org-chart') }}">
                    <i class="bi-diagram-3 text-info"></i>Organization Chart
                </a>
            </li>
            @endcan
            @can('view organogram')
            <li>
                <a href="{{ route('admin.apps.hr.organogram.index') }}">
                    <i class="bi-diagram-3 text-primary"></i>Organogram
                </a>
            </li>
            @endcan
        </ul>
    </li>
    @endcanany

    @can('view any sanction post')
    <li>
        <a href="{{ route('admin.apps.hr.sanctioned-posts.index') }}">
            <div class="parent-icon"><i class="bi-clipboard-check text-danger"></i></div>
            <div class="menu-title">Sanction Posts</div>
        </a>
    </li>
    @endcan

    @can('view any posting')
    <li>
        <a href="{{ route('admin.apps.hr.postings.index') }}">
            <div class="parent-icon"><i class="bi-geo-alt text-primary"></i></div>
            <div class="menu-title">Postings</div>
        </a>
    </li>
    @endcan

    @canany(['view any office', 'view any designation', 'view any role', 'view any permission'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-gear-fill text-primary"></i></div>
            <div class="menu-title">Settings</div>
        </a>
        <ul class="p-2 menu-items">
            @can('view any office')
            <li>
                <a href="{{ route('admin.apps.hr.offices.index') }}">
                    <i class="bi-building text-warning"></i>Offices</a>
            </li>
            @endcan

            @can('view any designation')
            <li>
                <a href="{{ route('admin.apps.hr.designations.index') }}"><i class="bi-award text-info"></i>Designations</a>
            </li>
            @endcan

            @can('view any role')
            <li>
                <a href="{{ route('admin.apps.hr.roles.index') }}"><i class="bi-person-badge text-success"></i>Roles</a>
            </li>
            @endcan

            @can('view any permission')
            <li>
                <a href="{{ route('admin.apps.hr.permissions.index') }}"><i class="bi-key text-success"></i>Permissions</a>
            </li>
            @endcan
        </ul>        
    </li>
    @endcanany

    @canany(['view vacancy report', 'view office strength', 'view posting history', 'view retirement forecast', 'view service length'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-bar-chart-line text-primary"></i></div>
            <div class="menu-title">Reports</div>
        </a>
        <ul class="p-2 menu-items">
            @can('view vacancy report')
            <li>
                <a href="{{ route('admin.apps.hr.reports.vacancy') }}">
                    <i class="bi-clipboard-data text-warning"></i>Vacancy Report</a>
            </li>
            @endcan

            @can('view office strength')
            <li>
                <a href="{{ route('admin.apps.hr.reports.office-strength') }}">
                    <i class="bi-people text-info"></i>Office Strength</a>
            </li>
            @endcan

            @can('view posting history')
            <li>
                <a href="{{ route('admin.apps.hr.reports.posting-history') }}">
                    <i class="bi-person-lines-fill text-success"></i>Posting History</a>
            </li>
            @endcan

            @can('view retirement forecast')
            <li>
                <a href="{{ route('admin.apps.hr.reports.retirement-forecast') }}">
                    <i class="bi-calendar-check text-danger"></i>Retirement Forecast</a>
            </li>
            @endcan

            @can('view service length')
            <li>
                <a href="{{ route('admin.apps.hr.reports.service-length') }}">
                    <i class="bi-hourglass-split text-primary"></i>Service Length</a>
            </li>
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
