@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'dmis' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="dmis" app-url="{{ route('admin.apps.dmis.dashboard') }}">
    @can('viewAny', App\Models\Damage::class)
    <li>
        <a href="{{ route('admin.apps.dmis.dashboard') }}">
            <div class="parent-icon"><i class="bi-house text-primary"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\Damage::class)
    <li>
        <a href="{{ route('admin.apps.dmis.damages.index') }}">
            <div class="parent-icon"><i class="bi-exclamation-triangle text-warning"></i></div>
            <div class="menu-title">Damages</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\Infrastructure::class)
    <li>
        <a href="{{ route('admin.apps.dmis.infrastructures.index') }}">
            <div class="parent-icon"><i class="bi-building text-info"></i></div>
            <div class="menu-title">Infrastructures</div>
        </a>
    </li>
    @endcan

    @canany(['viewMainReport', 'viewOfficerWiseReport', 'viewDistrictWiseReport', 'viewActiveOfficerReport'], App\Models\Damage::class)
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-flag text-primary"></i></div>
            <div class="menu-title">Reports</div>
        </a>
        <ul class="p-2 menu-items">
            @can('viewMainReport', App\Models\Damage::class)
            <li>
                <a href="{{ route('admin.apps.dmis.reports.index') }}">
                    <i class="bi-graph-up text-primary"></i> Main Report
                </a>
            </li>
            @endcan
            @can('viewSituationReport', App\Models\Damage::class)
            <li>
                <a href="{{ route('admin.apps.dmis.reports.daily-situation') }}">
                    <i class="bi-graph-down text-primary"></i> Daily Situation
                </a>
            </li>
            @endcan
            @can('viewOfficerWiseReport', App\Models\Damage::class)
            <li>
                <a href="{{ route('admin.apps.dmis.reports.officer-wise') }}">
                    <i class="bi-person-lines-fill text-success"></i> Officers Wise
                </a>
            </li>
            @endcan
            @can('viewDistrictWiseReport', App\Models\Damage::class)
            <li>
                <a href="{{ route('admin.apps.dmis.reports.district-wise') }}">
                    <i class="bi-geo-alt-fill text-warning"></i> District Wise
                </a>
            </li>
            @endcan
            @can('viewActiveOfficerReport', App\Models\Damage::class)
            <li>
                <a href="{{ route('admin.apps.dmis.reports.active-officers') }}">
                    <i class="bi-person-check-fill text-info"></i> Active Officers
                </a>
            </li>            
            @endcan
        </ul>
    </li>
    @endcanany

    @canany(['viewSettings', 'updateSettings', 'initSettings'], App\Models\Damage::class)
    <li>
        <a href="{{ route('admin.apps.dmis.settings.index') }}">
            <div class="parent-icon"><i class="bi-gear text-danger"></i></div>
            <div class="menu-title">Settings</div>
        </a>
    </li>
    @endcanany

</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
