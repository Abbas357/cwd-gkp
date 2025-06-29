@include('layouts.partials.admin.header')

<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'Machinery' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="MACHINERY MGT." app-url="{{ route('admin.apps.machineries.index') }}">
    @can('viewAny', App\Models\Machinery::class)
    <li>
        <a href="{{ route('admin.apps.machineries.index') }}">
            <div class="parent-icon"><i class="bi-bus-front text-info"></i></div>
            <div class="menu-title">Home</div>
        </a>
    </li>
    @endcan

    @can('viewAny', App\Models\Machinery::class)
    <li>
        <a href="{{ route('admin.apps.machineries.all') }}">
            <div class="parent-icon"><i class="bi-speedometer text-success"></i></div>
            <div class="menu-title">Machinery</div>
        </a>
    </li>
    @endcan

    @can('viewReports', App\Models\Machinery::class)
    <li>
        <a href="{{ route('admin.apps.machineries.reports') }}">
            <div class="parent-icon"><i class="bi-flag text-info"></i></div>
            <div class="menu-title">Reports</div>
        </a>
    </li>
    @endcan
    @canany(['viewSettings', 'updateSettings', 'initSettings'], App\Models\Machinery::class)
    <li>
        <a href="{{ route('admin.apps.machineries.settings.index') }}">
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
