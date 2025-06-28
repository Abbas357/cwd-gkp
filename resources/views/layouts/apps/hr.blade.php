@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'HR' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="HRMIS" app-url="{{ route('admin.apps.hr.index') }}">
    @php
        $user = auth()->user();
    @endphp
    @can('viewAny', App\Models\User::class)
    <li>
        <a href="{{ route('admin.apps.hr.index') }}">
            <div class="parent-icon"><i class="bi-house-door-fill text-primary"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\User::class)
    <li>
        <a href="{{ route('admin.apps.hr.users.index') }}">
            <div class="parent-icon"><i class="bi-person-badge text-success"></i></div>
            <div class="menu-title">Users</div>
        </a>
    </li>
    @endcan

    @can('viewOrganogram', App\Models\Office::class)
    <li>
        <a href="{{ route('admin.apps.hr.organogram.index') }}">
            <div class="parent-icon"><i class="bi-diagram-3 text-danger"></i></div>
            <div class="menu-title">Organogram</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\SanctionedPost::class)
    <li>
        <a href="{{ route('admin.apps.hr.sanctioned-posts.index') }}">
            <div class="parent-icon"><i class="bi-clipboard-check text-danger"></i></div>
            <div class="menu-title">Sanction Posts</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\Posting::class)
    <li>
        <a href="{{ route('admin.apps.hr.postings.index') }}">
            <div class="parent-icon"><i class="bi-geo-alt text-primary"></i></div>
            <div class="menu-title">Postings</div>
        </a>
    </li>
    @endcan

    @if(
        $user->can('viewAny', App\Models\Office::class) ||
        $user->can('viewAny', App\Models\Designation::class)
    )
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-gear-fill text-primary"></i></div>
            <div class="menu-title">Settings</div>
        </a>
        <ul class="p-2 menu-items">
            @can('viewAny', App\Models\Office::class)
            <li>
                <a href="{{ route('admin.apps.hr.offices.index') }}">
                    <i class="bi-building text-warning"></i>Offices</a>
            </li>
            @endcan

            @can('viewAny', App\Models\Designation::class)
            <li>
                <a href="{{ route('admin.apps.hr.designations.index') }}"><i class="bi-award text-info"></i>Designations</a>
            </li>
            @endcan

            @canany(['viewSettings', 'updateSettings', 'initSettings'], App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.settings.index') }}">
                    <i class="bi-gear text-danger"></i>Settings
                </a>
            </li>
            @endcanany
        </ul>
    </li>
    @endif

    @if(
        $user->can('viewAny', App\Models\Role::class) ||
        $user->can('viewAny', App\Models\Permission::class) ||
        $user->can('assignRole', App\Models\Role::class) ||
        $user->can('assignPermission', App\Models\Role::class)
    )
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-shield-lock text-primary"></i></div>
            <div class="menu-title">ACL</div>
        </a>
        <ul class="p-2 menu-items">
            @can('viewAny', App\Models\Role::class)
            <li>
                <a href="{{ route('admin.apps.hr.acl.roles.index') }}"><i class="bi-person-badge text-success"></i>Roles</a>
            </li>
            @endcan

            @can('viewAny', App\Models\Permission::class)
            <li>
                <a href="{{ route('admin.apps.hr.acl.permissions.index') }}"><i class="bi-key text-success"></i>Permissions</a>
            </li>
            @endcan

            @can('assignRole', App\Models\Role::class)
            <li>
                <a href="{{ route('admin.apps.hr.acl.users.index') }}"><i class="bi-person text-success"></i>Users</a>
            </li>
            @endcan
        </ul>        
    </li>
    @endif

    @canany(['viewVacancyReport', 'viewEmployeeDirectoryReport', 'viewOfficeStrengthReport', 'viewPostingHistoryReport', 'viewRetirementForecastReport', 'viewServiceLengthReport', 'viewOfficeStaffReport'], App\Models\User::class)
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-bar-chart-line text-primary"></i></div>
            <div class="menu-title">Reports</div>
        </a>
        <ul class="p-2 menu-items">
            @can('viewVacancyReport', App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.reports.vacancy') }}">
                    <i class="bi-clipboard-data text-warning"></i>Vacancy Report</a>
            </li>
            @endcan
            
            @can('viewEmployeeDirectoryReport', App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.reports.employees') }}">
                    <i class="bi-clipboard-data text-warning"></i>Employees Directory</a>
            </li>
            @endcan

            @can('viewOfficeStrengthReport', App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.reports.office-strength') }}">
                    <i class="bi-people text-info"></i>Office Strength</a>
            </li>
            @endcan

            @can('viewPostingHistoryReport', App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.reports.posting-history') }}">
                    <i class="bi-person-lines-fill text-success"></i>Posting History</a>
            </li>
            @endcan

            @can('viewRetirementForecastReport', App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.reports.retirement-forecast') }}">
                    <i class="bi-calendar-check text-danger"></i>Retirement Forecast</a>
            </li>
            @endcan

            @can('viewServiceLengthReport', App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.reports.service-length') }}">
                    <i class="bi-hourglass-split text-primary"></i>Service Length</a>
            </li>
            @endcan

            @can('viewOfficeStaffReport', App\Models\User::class)
            <li>
                <a href="{{ route('admin.apps.hr.reports.office-staff') }}">
                    <i class="bi-hourglass-split text-primary"></i>Office Staff</a>
            </li>
            @endcan
        </ul>        
    </li>
    @endcanany


</x-sidebar>

@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
