@include('layouts.partials.admin.header')
<x-header :show-aside="true">
    <x-slot name="breadcrumb">
        {{ $header ?? 'dmis' }}
    </x-slot>
</x-header>

@if ($showAside)
<x-sidebar app-name="DMIS" app-url="{{ route('admin.apps.dmis.index') }}">
    @can('viewAny', App\Models\Damage::class)
    <li>
        <a href="{{ route('admin.apps.dmis.index') }}">
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

    @can('viewMainReport', App\Models\Damage::class)
    <li>
        <a href="{{ route('admin.apps.dmis.reports.index') }}">
            <div class="parent-icon"><i class="bi-flag text-primary"></i></div>
            <div class="menu-title">Reports</div>
        </a>
    </li>
    @endcan

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
