@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'Vehicle MGT' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="VEHICLE MGT." app-url="{{ route('admin.apps.vehicles.index') }}">
    @can('viewAny', App\Models\Vehicle::class)
    <li>
        <a href="{{ route('admin.apps.vehicles.index') }}">
            <div class="parent-icon"><i class="bi-bus-front text-info"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\Vehicle::class)
    <li>
        <a href="{{ route('admin.apps.vehicles.all') }}">
            <div class="parent-icon"><i class="bi-speedometer text-success"></i></div>
            <div class="menu-title">Vehicles</div>
        </a>
    </li>
    @endcan

    @can('viewReports', App\Models\Vehicle::class)
    <li>
        <a href="{{ route('admin.apps.vehicles.reports') }}">
            <div class="parent-icon"><i class="bi-flag text-info"></i></div>
            <div class="menu-title">Reports</div>
        </a>
    </li>
    @endcan

    @canany(['viewVehicleSettings', 'updateVehicleSettings', 'initVehicleSettings'], App\Models\Setting::class)
    <li>
        <a href="{{ route('admin.apps.vehicles.settings.index') }}">
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
