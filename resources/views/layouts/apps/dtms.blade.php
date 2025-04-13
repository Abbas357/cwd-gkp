@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'dtms' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="DTMS" app-url="{{ route('admin.apps.dtms.dashboard') }}">

    @can('view any damage')
    <li>
        <a href="{{ route('admin.apps.dtms.dashboard') }}">
            <div class="parent-icon"><i class="bi-house text-primary"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('view any infrastructures')
    <li>
        <a href="{{ route('admin.apps.dtms.infrastructures.index') }}">
            <div class="parent-icon"><i class="bi-building text-info"></i></div>
            <div class="menu-title">Infrastructures</div>
        </a>
    </li>
    @endcan

    @can('view any damages')
    <li>
        <a href="{{ route('admin.apps.dtms.damages.index') }}">
            <div class="parent-icon"><i class="bi-exclamation-triangle text-warning"></i></div>
            <div class="menu-title">Damages</div>
        </a>
    </li>
    @endcan

    @canany(['view damage report'])
    <li>
        <a href="javascript:;" class="has-arrow">
            <div class="parent-icon"><i class="bi-flag text-primary"></i></div>
            <div class="menu-title">Reports</div>
        </a>
        <ul class="p-2 menu-items">
            @can('view damage report')
            <li>
                <a href="{{ route('admin.apps.dtms.reports.index') }}">
                    <i class="bi-graph-up text-primary"></i> Main Report
                </a>
            </li>
            <li>
                <a href="{{ route('admin.apps.dtms.reports.officer-wise') }}">
                    <i class="bi-person-lines-fill text-success"></i> Officers Wise
                </a>
            </li>
            <li>
                <a href="{{ route('admin.apps.dtms.reports.district-wise') }}">
                    <i class="bi-geo-alt-fill text-warning"></i> District Wise
                </a>
            </li>
            <li>
                <a href="{{ route('admin.apps.dtms.reports.active-officers') }}">
                    <i class="bi-person-check-fill text-info"></i> Active Officers
                </a>
            </li>            
            @endcan
        </ul>
    </li>
    @endcanany

    @can('view dtms settings')
    <li>
        <a href="{{ route('admin.apps.dtms.settings.index') }}">
            <div class="parent-icon"><i class="bi-gear text-danger"></i></div>
            <div class="menu-title">Settings</div>
        </a>
    </li>
    @endcan

</x-sidebar>
@endif

@include('layouts.partials.admin.main')

<x-footer :show-aside="$showAside" :site-name="setting('site_name', 'main', config('app.name'))" />

<x-theme-switcher current-theme="LightTheme" />

@include('layouts.partials.admin.footer')
